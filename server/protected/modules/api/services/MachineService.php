<?php
class MachineService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_machine= MachineService::getEmptyMachine();
		$result['machine']= $get_empty_machine['machine'];
		$get_empty_machine_error= MachineService::getEmptyMachineError();
		$result['machine_error']= $get_empty_machine_error['machine_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMachine(){
		$result= array();
		$machine= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					);
		
		$result['machine']= $machine;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMachineError(){
		$result= array();
		$machine= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					);
		
		$result['machine_error']= $machine;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Machine::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_machine.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_machine.*
			   From tbl_machine";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['name']) && $data['name']!= ''){
			$sql= $sql."And tbl_machine.name LIKE '%".$data['name']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$machines= Machine::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['name']) && $data['name']!= ''){
			$criteria->compare('name', $data['name'], true);
		}

		$total = Machine::model()->count($criteria);
		
		if($machines!= null){
			$result['success']= true;
			$result['machines']=self::convertListMachine($machines, $data);
			
			$result['totalresults']= $total;
			$result['start_machine']= (int)$data['limitstart']+ 1;
			$result['end_machine']= (int)$data['limitstart']+ count($machines);
		}
		else{
			$result['success']= true;
			$result['machines']= array();
			$result['totalresults']= $total;
			$result['start_machine']= 0;
			$result['end_machine']= 0;
		}
		return $result;
	}

	public static function getMachinesByOrderId($data){
		$result= array();

		$order = PurchaseOrder::model()->findByPk($data['order_id']);

		if(isset($order)){
			$criteria = new CDbCriteria();
			$criteria->compare('purchase_order_id', $order->id);
			$order_details = PurchaseOrderDetail::model()->findAll($criteria);

			$part_ids = array();
			foreach($order_details as $order_detail){
				if(!in_array($order_detail->part_id, $part_ids))
					$part_ids[] = $order_detail->part_id;
			}

			$criteria = new CDbCriteria();
			$criteria->compare('purchase_order_id', $order->id);
			$job_orders = JobOrder::model()->findAll($criteria);

			$job_order_ids = array();
			foreach($job_orders as $job_order){
				$job_order_ids[] = $job_order->id;
			}


			$machines_ids = array();
			foreach($job_order_ids as $job_order_id){
				$criteria = new CDbCriteria();
				$criteria->compare('job_order_id', $job_order_id);
				$machine_schedules = MachineSchedule::model()->findAll($criteria);

				foreach($machine_schedules as $machine_schedule){
					if(!in_array($machine_schedule->machine_id, $machines_ids))
						$machines_ids[] = $machine_schedule->machine_id;					
				}
			}

			$criteria = new CDbCriteria();
			$criteria->addInCondition('id', $machines_ids);
			$machines = Machine::model()->findAll($criteria);

			if($machines!= null && count($machines)>0){
				$result['machines'] = self::convertListMachine($machines, $data);
				$result['purchase_order'] = array('id'=>$order->id, 'po_code'=>$order->po_code);
				$result['success']= true;
			}
			else{
				$result['success']= true;
				$result['machines']= array();
			}	
		}
		else{
			$result['success']= true;
			$result['machines']= array();
		}	

		return $result;
	}

	public static function getMachineById($data){
		$result= array();
		$get_empty_machine_error= MachineService::getEmptyMachineError();
		$result['machine_error']= $get_empty_machine_error['machine_error'];
		$machine= Machine::model()->findByPk($data['id']);
		if($machine){
			$result['success']= true;
			$result['machine']= self::convertMachine($machine);
		}
		else{
			$result['success']= false;
			$result['message']= 'Machine \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$machine= new Machine();
		$machine->attributes= $data;

		if($machine->validate()){
			$machine->save();
			$result['success']= true;
			$result['id']= $machine->id;
		}
		else{
			$empty_machine_error= MachineService::getEmptyMachineError();
			$result['machine_error']= $empty_machine_error['machine_error']; 
			foreach ($machine->getErrors() as $key => $error_array) {
				$result['machine_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating machine has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$machine= Machine::model()->findByPk((int)$data['id']);
			if($machine){
				$machine->attributes= $data;

				if($machine->validate()){
					$machine->save();
					$result['success']= true;
					$result['id']= $machine->id;
					$machine_array= MachineService::getMachineById(array('id'=>$machine->id));
					$result['machine']= $machine_array['machine'];
					$result['message']= 'Machine updated!';
				}
				else{
					$empty_machine_error= MachineService::getEmptyMachineError();
					$result['machine_error']= $empty_machine_error['machine_error']; 
					foreach ($machine->getErrors() as $key => $error_array) {
						$result['machine_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update machine has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Machine \'s not found!';
			}
		}
		else{
			//Create new machine
			$machine = new Machine();
			$machine->attributes= $data;

			if($machine->validate()){
				$machine->save();
				$result['success']= true;
				$result['id']= $machine->id;
				$machine_array= MachineService::getMachineById(array('id'=>$machine->id));
				$result['machine']= $machine_array['machine'];
				$result['message']= 'Machine created!';
			}
			else{
				$empty_machine_error= MachineService::getEmptyMachineError();
				$result['machine_error']= $empty_machine_error['machine_error']; 
				foreach ($machine->getErrors() as $key => $error_array) {
					$result['machine_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create machine has some errors';
			}
		}
		
		
		return $result;
	}
	
	public static function convertListMachine($machines, $data){
		$result= array();
		if($machines!= null && count($machines)>0){
			foreach($machines as $machine){
				$result[]= self::convertMachine($machine);
			}
		}
		return $result;
	}
	
	public static function convertMachine($machine){
		$result= array(
					'id'=> $machine->id,
					'name'=> $machine->name,
					'status'=> $machine->status,
					'created_time'=> date('d-m-Y', $machine->created_time),
					
					);
		$machine_jobs = MachineJob::model()->findAllByAttributes(array('machine_id'=> $machine->id, 'status'=> 1));
		// Find machine schedule
		$criteria = new CDbCriteria();
		$criteria->compare('machine_id', $machine->id);
		$criteria->compare('status', MachineSchedule::STATUS_WORKING);
		//$list_machine_schedule = MachineSchedule::model()->findAll($criteria);
		$count = MachineSchedule::model()->count($criteria);

		if($count > 0){
			//$machine_schedules = MachineScheduleService::convertListMachineSchedule($list_machine_schedule);
			$result['is_jobs'] = true;
			//$result['machine_schedules'] = $machine_schedules;
		}
		else{
			$result['is_jobs'] = false;
			//$result['machine_schedules'] = array();
		}

		return $result;
	}

	public static function removeMachine($data){
		$result= array();
		$machine = Machine::model()->findByPk((int)$data['id']);
		$machine->attributes= $data;

		if($machine->delete()){
			$result['success'] = true;
			$result['message'] = 'Machine deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($machine);
		}
		
		return $result;
	}
}
