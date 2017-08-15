<?php

class UoqController extends Controller{
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
		$data= UoqService::data();
		$result= UoqService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= UoqService::data();
		$result= UoqService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= UoqService::data();
		$result= UoqService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= UoqService::data();
		$result= UoqService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetUoqById(){
		$data= UoqService::data();
		$result= UoqService::getUoqById($data);
		$this->returnJson($result);
	}

	public function actionRemoveUoq(){
		$data= UoqService::data();
		$result= UoqService::removeUoq($data);
		$this->returnJson($result);
	}
}
?>