<?php

class MaterialLocationController extends Controller{
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
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::update($data);
		$this->returnJson($result);
	}

	public function actionRemoveMaterialLocation(){
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::update($data);
		$this->returnJson($result);
	}

	public function actionGetMaterialLocationById(){
		$data= MaterialLocationService::data();
		$result= MaterialLocationService::getMaterialLocationById($data);
		$this->returnJson($result);
	}
}
?>