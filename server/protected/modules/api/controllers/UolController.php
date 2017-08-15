<?php

class UolController extends Controller{
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
		$data= UolService::data();
		$result= UolService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= UolService::data();
		$result= UolService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= UolService::data();
		$result= UolService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= UolService::data();
		$result= UolService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetUolById(){
		$data= UolService::data();
		$result= UolService::getUolById($data);
		$this->returnJson($result);
	}

	public function actionRemoveUol(){
		$data= UolService::data();
		$result= UolService::removeUol($data);
		$this->returnJson($result);
	}
}
?>