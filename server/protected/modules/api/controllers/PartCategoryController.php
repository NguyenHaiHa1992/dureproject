<?php

class PartCategoryController extends Controller{
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
		$data= PartCategoryService::data();
		$result= PartCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= PartCategoryService::data();
		$result= PartCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= PartCategoryService::data();
		$result= PartCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= PartCategoryService::data();
		$result= PartCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetPartCategoryById(){
		$data= PartCategoryService::data();
		$result= PartCategoryService::getPartCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemovePartCategory(){
		$data= PartCategoryService::data();
		$result= PartCategoryService::removePartCategory($data);
		$this->returnJson($result);
	}
}
?>