<?php

class ShapeController extends Controller{
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
		$data= ShapeService::data();
		$result= ShapeService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= ShapeService::data();
		$result= ShapeService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ShapeService::data();
		$result= ShapeService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= ShapeService::data();
		$result= ShapeService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetShapeById(){
		$data= ShapeService::data();
		$result= ShapeService::getShapeById($data);
		$this->returnJson($result);
	}

	public function actionRemoveShape(){
		$data= ShapeService::data();
		$result= ShapeService::removeShape($data);
		$this->returnJson($result);
	}
}
?>