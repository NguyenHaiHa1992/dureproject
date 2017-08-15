<?php

class OperationController extends Controller{
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
		$data= OperationService::data();
		$result= OperationService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= OperationService::data();
		$result= OperationService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= OperationService::data();
		$result= OperationService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= OperationService::data();
		$result= OperationService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetOperationById(){
		$data= OperationService::data();
		$result= OperationService::getOperationById($data);
		$this->returnJson($result);
	}

	public function actionRemoveOperation(){
		$data= OperationService::data();
		$result= OperationService::removeOperation($data);
		$this->returnJson($result);
	}
}
?>