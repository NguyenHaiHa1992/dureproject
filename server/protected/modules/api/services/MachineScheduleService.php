<?php
class MachineScheduleService extends iPhoenixService{	
	public static function convertMachineSchedule($schedule){
		$result = array(
						'id'=> (int)$schedule->id,
						'job_order_id'=> (int)$schedule->job_order_id,
						'job_order_detail_id'=> (int)$schedule->job_order_detail_id,
						'part_id'=> (int)$schedule->part_id,
						'part_code'=> isset($schedule->part)?$schedule->part->part_code:"N/A",
						'material_id'=> (int)$schedule->material_id,
						'machine_id'=> (int)$schedule->machine_id,
						'operation_id'=> $schedule->operation_id,
						'operation'=> isset($schedule->operation)?$schedule->operation->name:array(),
						'start_date'=> date('Y-m-d', $schedule->start_date),
						'employee'=> $schedule->employee,
						'quantity_good'=> (int)$schedule->quantity_good,
						'quantity_scarp'=> (int)$schedule->quantity_scarp,
						'heat_code'=> $schedule->heat_code,
						'designation'=> $schedule->designation,
						'setup_time'=> (int)$schedule->setup_time,
						'cleanup_time'=> (int)$schedule->cleanup_time,
						'total_time'=> (int)$schedule->total_time,
						'has_problem'=> (int)$schedule->has_problem,
						'status'=> (int)$schedule->status,
						'status_label'=> $schedule->getStatusLabel(),
						'created_time'=> (int)$schedule->created_time,
						'updated_time'=> (int)$schedule->updated_time,
						'created_by'=> (int)$schedule->created_by,
						'scheduled_hour'=>(float)$schedule->scheduled_hour,
						'actual_hour'=>(float)$schedule->actual_hour,
					);

		return $result;
	}

	public static function getEmptyMachineSchedule(){
		$result = array(
						'job_order_id'=> '',
						'job_order_detail_id'=> '',
						'part_id'=> '',
						'material_id'=> '',
						'machine_id'=> '',
						'operation_id'=> '',
						'operation'=> array(),
						'start_date'=> '',
						'employee'=> '',
						'quantity_good'=> '',
						'quantity_scarp'=> '',
						'heat_code'=> '',
						'designation'=> '',
						'setup_time'=> '',
						'cleanup_time'=> '',
						'has_problem'=> '',
						'status'=> '',
						'status_label'=> '',
						'created_time'=> '',
						'updated_time'=> '',
						'created_by'=> '',
						'scheduled_hour'=>'',
						'actual_hour'=>'',
					);

		return $result;
	}

	public static function updateSchedule($data){
		$result = array();

		if(!isset($data['schedule']['id']) || $data['schedule']['id'] == ''){
			$machine_schedule = new MachineSchedule();
			$machine_schedule->attributes = $data['schedule'];
			$machine_schedule->start_date = strtotime($machine_schedule->start_date);
			$machine_schedule->status = MachineSchedule::STATUS_WORKING;

			if($machine_schedule->save()){
				$result['success'] = true;
				$result['message'] = 'Machine Schedule Created!';
				$result['schedule'] = self::convertMachineSchedule($machine_schedule);
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($machine_schedule);
			}
		}
		else{
			$machine_schedule = MachineSchedule::model()->findByPk($data['schedule']['id']);
			if(isset($machine_schedule)){
				$machine_schedule->attributes = $data['schedule'];
				$machine_schedule->start_date = strtotime($machine_schedule->start_date);
				$machine_schedule->status = MachineSchedule::STATUS_WORKING;

				if($machine_schedule->save()){
					$result['success'] = true;
					$result['message'] = 'Machine Schedule Created!';
					$result['schedule'] = self::convertMachineSchedule($machine_schedule);
				}
				else{
					$result['success'] = false;
					$result['message'] = CHtml::errorSummary($machine_schedule);
				}
			}
			else{
				$result['success'] = false;
				$result['message'] = 'Can not find this schedule!';
			}
		}

		return $result;
	}

	public static function releaseSchedule($data){
		$result = array();

		if(isset($data['schedule']['id']) && $data['schedule']['id'] != ''){

			$machine_schedule = MachineSchedule::model()->findByPk($data['schedule']['id']);
			if(isset($machine_schedule)){
				// Release schedule
				$machine_schedule->status = MachineSchedule::STATUS_RELEASED;

				if($machine_schedule->save()){
					$result['success'] = true;
					$result['message'] = 'Machine Schedule Released!';
					$result['schedule'] = self::convertMachineSchedule($machine_schedule);
				}
				else{
					$result['success'] = false;
					$result['message'] = CHtml::errorSummary($machine_schedule);
				}
			}
			else{
				$result['success'] = false;
				$result['message'] = 'Can not find this schedule!';
			}
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid request';
		}

		return $result;
	}

	public static function restartSchedule($data){
		$result = array();

		if(isset($data['schedule']['id']) && $data['schedule']['id'] != ''){

			$machine_schedule = MachineSchedule::model()->findByPk($data['schedule']['id']);
			if(isset($machine_schedule)){
				// Restart schedule
				$machine_schedule->status = MachineSchedule::STATUS_WORKING;

				if($machine_schedule->save()){
					$result['success'] = true;
					$result['message'] = 'Machine Schedule Restarted!';
					$result['schedule'] = self::convertMachineSchedule($machine_schedule);
				}
				else{
					$result['success'] = false;
					$result['message'] = CHtml::errorSummary($machine_schedule);
				}
			}
			else{
				$result['success'] = false;
				$result['message'] = 'Can not find this schedule!';
			}
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid request';
		}

		return $result;
	}

	public static function convertListMachineSchedule($machine_schedules){
		$result= array();
		if($machine_schedules!= null && count($machine_schedules)>0){
			foreach($machine_schedules as $machine_schedule){
				$result[]= self::convertMachineSchedule($machine_schedule);
			}
		}
		return $result;
	}

	public static function deleteSchedule($data){
		$result = array();

		if(isset($data['schedule']['id']) && $data['schedule']['id'] != ''){

			$machine_schedule = MachineSchedule::model()->findByPk($data['schedule']['id']);
			if(isset($machine_schedule)){
				if($machine_schedule->delete()){
					$result['success'] = true;
					$result['message'] = 'Machine Schedule Deleted!';
				}
				else{
					$result['success'] = false;
					$result['message'] = CHtml::errorSummary($machine_schedule);
				}
			}
			else{
				$result['success'] = false;
				$result['message'] = 'Can not find this schedule!';
			}
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid request';
		}

		return $result;
	}

	public static function GetMachineSchedulesById($data){
		$result = array();

		if(isset($data['id']) && isset($data['date'])){
			$start_date = strtotime($data['date']);


			$criteria = new CDbCriteria();
			$criteria->compare('machine_id', $data['id']);
			$criteria->compare('start_date', $start_date);

			// Filter by order 
			if(isset($data['purchase_order_id'])){
				$criteria_2 = new CDbCriteria();
				$criteria_2->compare('purchase_order_id', $data['purchase_order_id']);
				$job_orders = JobOrder::model()->findAll($criteria_2);
				$job_order_ids = array();
				foreach ($job_orders as $job_order) {
					$job_order_ids[] = $job_order->id;
				}

				$criteria->addInCondition('job_order_id', $job_order_ids);
			}

			$machine_schedules = MachineSchedule::model()->findAll($criteria);

			$result = array(
				'success'=>true,
				'machine_schedules' => MachineScheduleService::convertListMachineSchedule($machine_schedules)
			);
		}
		else{
			$result = array(
				'success'=>false,
				'message'=>'Invalid request'
			);
		}

		return $result;
	}
}
