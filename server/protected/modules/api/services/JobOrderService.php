<?php
class JobOrderService extends iPhoenixService{	
	public static function init($data){
		$result= array();

		if(isset($data['id']))
			$job_order = JobOrder::model()->findByPk($data['id']);
		else{
			$result = array('success'=>false, 'message'=>'Invalid request!');
			return $result;
		}

		if(!isset($job_order)){
			$result = array('success'=>false, 'message'=>'Can not find this Job Order!');
			return $result;
		}
		else{
			$criteria = new CDbCriteria();
			$criteria->compare('job_order_id', $job_order->id);
			$list_job_order_detail = JobOrderDetail::model()->findAll($criteria);

			$job_order_details = array();
			foreach($list_job_order_detail as $job_order_detail){
				$job_order_details[] = JobOrderService::convertJobOrderDetail($job_order_detail);
			}

			// Find job order in group
			$criteria = new CDbCriteria();
			$criteria->compare('jo_group', $job_order->jo_group);
			$criteria->addCondition('id > '.$job_order->id);
			$criteria->order = 'id asc';
			$next_job_order = JobOrder::model()->find($criteria);
			$next_job_order_count = JobOrder::model()->count($criteria);

			$criteria = new CDbCriteria();
			$criteria->compare('jo_group', $job_order->jo_group);
			$criteria->addCondition('id < '.$job_order->id);
			$criteria->order = 'id desc';
			$previous_job_order = JobOrder::model()->find($criteria);
			$previous_job_order_count = JobOrder::model()->count($criteria);

			$result['success'] = true;
			$result['next_job_order_id'] = isset($next_job_order)?$next_job_order->id:'';
			$result['next_job_order_count'] = $next_job_order_count;
			$result['previous_job_order_id'] = isset($previous_job_order)?$previous_job_order->id:'';
			$result['previous_job_order_count'] = $previous_job_order_count;

			$result['job_order'] = self::convertJobOrder($job_order);
			$result['job_order']['job_order_details'] = $job_order_details;
			$result['job_order']['current_time'] = date('Y-m-d', time());
			$result['machines'] = MachineService::convertListMachine(Machine::model()->findAll(), array());
			$result['operations'] = OperationService::convertListOperation(Operation::model()->findAll(), array());
		}

		return $result;
	}

	public static function create($data){
		$success = true;
		$result= array();

		if(isset($data['purchase_order_details']) && isset($data['create_job_orders'])){
			$purchase_order_details = $data['purchase_order_details'];
			$create_job_orders = $data['create_job_orders'];
			$i = 0; $j = 0;

			// Validate before create JO
			foreach($create_job_orders as $create_job_order){
				// Validate quantity > 0
				if($create_job_order['quantity_to_manufacture'] < 0){
					$result['success'] = false;
					$result['message'] = 'Qty to MFR must be bigger than 0';
					return $result;
				}

				// Validate not emtpy JO
				if($create_job_order['jo_code'] == ''){
					$result['success'] = false;
					$result['message'] = 'JO code could not be empty';
					return $result;
				}

				// Validate unique JO
				$criteria = new CDbCriteria();
				$criteria->compare('jo_code', trim($create_job_order['jo_code']));
				$find_jo_qty = JobOrder::model()->count($criteria);

				if($find_jo_qty > 0){
					$result['success'] = false;
					$result['message'] = 'JO code has been existed';
					return $result;
				}
			}

			/***** Create new job orders *****/
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{
				$jo_group = 0;
				$list_job_order = array();
				$i = 0;
				foreach($create_job_orders as $create_job_order){
					$i++;
					$job_order = new JobOrder();
					$job_order->purchase_order_id = $data['purchase_order_id'];
					$job_order->jo_code = $create_job_order['jo_code'];
					$job_order->jo_group = $jo_group;

					if(!$job_order->save()){
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($job_order);
						return $result;
					}

					if($i == 1){
						$jo_group = $job_order->id; //jo_group is newest jo ID
						$job_order->jo_group = $jo_group;
						$job_order->saveAttributes(array('jo_group'));
					}

					// Create job order details
					$job_order_detail = new JobOrderDetail();
					$job_order_detail->job_order_id = $job_order->id;
					$job_order_detail->part_id = $create_job_order['part_id'];
					$job_order_detail->material_id = $create_job_order['material_id'];
					$job_order_detail->quantity_manufacture = $create_job_order['quantity_to_manufacture'];

					if($job_order_detail->save()){
						$job_order_details[] = JobOrderService::convertJobOrderDetail($job_order_detail);
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($job_order_details);
						return $result;
					}

					$list_job_order[] = self::convertJobOrder($job_order) + array('job_order_details'=>$job_order_details);
				}
				$result['job_orders'] = $list_job_order;
				$result['jo_group'] = $jo_group;
				// Transaction commit
				$transaction->commit();
			}
			catch (Exception $e)
			{
				// Rollback
				$transaction->rollBack();
				
				// Message
				$result = array(
					'success'=>false,
					'message'=> $e->getMessage(),
				);

				return $result;
			}
		}

		$result['success'] = true;
		return $result;
	}

	public static function convertJobOrderDetail($job_order_detail){
		$part = Part::model()->findByPk($job_order_detail->part_id);
		$convert_part = PartService::convertPart($part);
		// Find related machine
		$machines = array();
		$all_machines = Machine::model()->findAll();
		foreach($all_machines as $machine){
			$convert_machine = MachineService::convertMachine($machine);

			// Get machine schedule
			$criteria = new CDbCriteria();
			$criteria->compare('machine_id', $machine->id);
			$criteria->compare('part_id', $part->id);
			$criteria->compare('job_order_id', $job_order_detail->job_order_id);
			$machine_schedules = MachineSchedule::model()->findAll($criteria);
			if(count($machine_schedules) > 0){
				foreach($machine_schedules as $machine_schedule){
					$convert_machine['schedules'][] = MachineScheduleService::convertMachineSchedule($machine_schedule);
				}

				$machines[] = $convert_machine;
			}
			//else
				//$convert_machine['schedule'] = MachineScheduleService::getEmptyMachineSchedule();

		}

		$material = Material::model()->findByPk($job_order_detail->material_id);

		$result = array(
						'id'=> $job_order_detail->id,
						'job_order_id'=> $job_order_detail->job_order_id,
						'part_id'=> $job_order_detail->part_id,
						'part'=> $convert_part,
						'material_id'=> $job_order_detail->material_id,
						'material'=>MaterialService::convertMaterial($material),
						'quantity_manufacture'=> $job_order_detail->quantity_manufacture,
						'quantity_drew'=> $job_order_detail->quantity_drew,
						'quantity_returned'=> $job_order_detail->quantity_returned,
						'drew_date'=> ($job_order_detail->drew_date > 0)?date('Y-m-d', $job_order_detail->drew_date):"",
						'created_time'=> date('Y-m-d', $job_order_detail->created_time),
						'updated_time'=> date('Y-m-d', $job_order_detail->updated_time),
						'created_by'=> $job_order_detail->created_by,
						'machines'=> $machines
					);

		return $result;
	}

	public static function getAll($data){
		$result= array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(Vendor::model()->findAll());
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}

		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_job_order.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_job_order.*
			   From tbl_job_order";
		$sql= $sql."
			   		Where 1 ";

		// if(isset($data['jo_code']) && $data['jo_code']!= ''){
		// 	$sql= $sql."And tbl_job_order.jo_code LIKE '%".$data['jo_code']."%'";
		// }

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$job_orders= JobOrder::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['jo_code']) && $data['jo_code']!= ''){
			$criteria->compare('jo_code', $data['jo_code'], true);
		}
		$total= JobOrder::model()->count($criteria);

		if($job_orders!= null && count($job_orders)>0){
			$result['job_orders']= self::convertListJobOrder($job_orders, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['job_orders']= array();
		}
		return $result;
	}

	public static function convertJobOrder($job_order){
		$result = array(
						'id'=> $job_order->id,
						'jo_code'=>$job_order->jo_code,
						'purchase_order_id'=> $job_order->purchase_order_id,
						'total_part'=> $job_order->total_part,
						'created_time'=> date('Y-m-d', $job_order->created_time),
						'updated_time'=> date('Y-m-d', $job_order->updated_time),
						'created_by'=> $job_order->created_by,
					);

		return $result;
	}

	public static function convertListJobOrder($job_orders){
		$result= array();
		if($job_orders!= null && count($job_orders)>0){
			foreach($job_orders as $job_order){
				$result[]= self::convertJobOrder($job_order);
			}
		}
		return $result;
	}

	public static function getJobOrdersByPurchaseOrderId($data){
		$result = array();

		if(isset($data['purchase_order_id']) && $data['purchase_order_id'] != ''){
			$criteria = new CDbCriteria();
			$criteria->compare('purchase_order_id', $data['purchase_order_id']);
			$criteria->order = 'id desc';

			$list_job_order = JobOrder::model()->findAll($criteria);
			$job_orders = self::convertListJobOrder($list_job_order);

			$result['success'] = true;
			$result['job_orders'] = $job_orders;
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid Request!';
		}

		return $result;
	}
}
