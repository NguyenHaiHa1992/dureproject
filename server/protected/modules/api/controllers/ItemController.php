<?php

class ItemController extends Controller{
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
		$data= ItemService::data();
		$result= ItemService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= ItemService::data();
		$result= ItemService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ItemService::data();
		$result= ItemService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= ItemService::data();
		$result= ItemService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetItemById(){
		$data= ItemService::data();
		$result= ItemService::getItemById($data);
		$this->returnJson($result);
	}

	public function actionRemoveItem(){
		$data= ItemService::data();
		$result= ItemService::removeItem($data);
		$this->returnJson($result);
	}
}
?>