<?php

class StateController extends Controller{
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
		$data= StateService::data();
		$result= StateService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= StateService::data();
		$result= StateService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= StateService::data();
		$result= StateService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= StateService::data();
		$result= StateService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetStateById(){
		$data= StateService::data();
		$result= StateService::getStateById($data);
		$this->returnJson($result);
	}

	public function actionRemoveState(){
		$data= StateService::data();
		$result= StateService::removeState($data);
		$this->returnJson($result);
	}
}
?>