<?php

class MaterialCategoryController extends Controller{
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
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetMaterialCategoryById(){
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::getMaterialCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveMaterialCategory(){
		$data= MaterialCategoryService::data();
		$result= MaterialCategoryService::removeMaterialCategory($data);
		$this->returnJson($result);
	}
}
?>