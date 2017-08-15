<?php

class OperationCategoryController extends Controller{
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
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetOperationCategoryById(){
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::getOperationCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveOperationCategory(){
		$data= OperationCategoryService::data();
		$result= OperationCategoryService::removeOperationCategory($data);
		$this->returnJson($result);
	}
}
?>