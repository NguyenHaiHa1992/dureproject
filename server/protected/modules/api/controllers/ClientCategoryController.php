<?php

class ClientCategoryController extends Controller{
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
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetClientCategoryById(){
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::getClientCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveClientCategory(){
		$data= ClientCategoryService::data();
		$result= ClientCategoryService::removeClientCategory($data);
		$this->returnJson($result);
	}
}
?>