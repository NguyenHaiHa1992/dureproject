<?php

class UomController extends Controller{
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
		$data= UomService::data();
		$result= UomService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= UomService::data();
		$result= UomService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= UomService::data();
		$result= UomService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= UomService::data();
		$result= UomService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetUomById(){
		$data= UomService::data();
		$result= UomService::getUomById($data);
		$this->returnJson($result);
	}

	public function actionRemoveUom(){
		$data= UomService::data();
		$result= UomService::removeUom($data);
		$this->returnJson($result);
	}
}
?>