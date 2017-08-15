<?php

class PartLocationController extends Controller{
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
		$data= PartLocationService::data();
		$result= PartLocationService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= PartLocationService::data();
		$result= PartLocationService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= PartLocationService::data();
		$result= PartLocationService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= PartLocationService::data();
		$result= PartLocationService::update($data);
		$this->returnJson($result);
	}

	public function actionRemovePartLocation(){
		$data= PartLocationService::data();
		$result= PartLocationService::update($data);
		$this->returnJson($result);
	}

	public function actionGetPartLocationById(){
		$data= PartLocationService::data();
		$result= PartLocationService::getPartLocationById($data);
		$this->returnJson($result);
	}

	public function actionGetPartLocationsByPartId(){
		$data= PartLocationService::data();
		$result= PartLocationService::getPartLocationsByPartId($data);
		$this->returnJson($result);
	}
}
?>