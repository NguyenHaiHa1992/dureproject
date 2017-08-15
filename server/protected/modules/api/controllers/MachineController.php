<?php

class MachineController extends Controller{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				//'roles'=>array('AMP Master Admin'),
				'users'=>array('@'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionCreateInit(){
		$data= MachineService::data();
		$result= MachineService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MachineService::data();
		$result= MachineService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= MachineService::data();
		$result= MachineService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MachineService::data();
		$result= MachineService::update($data);
		$this->returnJson($result);
	}

	public function actionRemoveMachine(){
		$data= MachineService::data();
		$result= MachineService::update($data);
		$this->returnJson($result);
	}

	public function actionGetMachineById(){
		$data= MachineService::data();
		$result= MachineService::getMachineById($data);
		$this->returnJson($result);
	}

	public function actionGetMachinesByOrderId(){
		$data= MachineService::data();
		$result= MachineService::getMachinesByOrderId($data);
		$this->returnJson($result);
	}

	public function actionUpdateSchedule(){
		$data= MachineScheduleService::data();
		$result= MachineScheduleService::updateSchedule($data);
		$this->returnJson($result);
	}

	public function actionReleaseSchedule(){
		$data= MachineScheduleService::data();
		$result= MachineScheduleService::releaseSchedule($data);
		$this->returnJson($result);
	}

	public function actionRestartSchedule(){
		$data= MachineScheduleService::data();
		$result= MachineScheduleService::restartSchedule($data);
		$this->returnJson($result);
	}

	public function actionDeleteSchedule(){
		$data= MachineScheduleService::data();
		$result= MachineScheduleService::deleteSchedule($data);
		$this->returnJson($result);
	}

	public function actionGetMachineSchedulesById(){
		$data= MachineScheduleService::data();
		$result= MachineScheduleService::getMachineSchedulesById($data);
		$this->returnJson($result);
	}
}
?>