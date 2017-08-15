<?php

class FileCategoryController extends Controller{
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
		$data= FileCategoryService::data();
		$result= FileCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= FileCategoryService::data();
		$result= FileCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= FileCategoryService::data();
		$result= FileCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= FileCategoryService::data();
		$result= FileCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetFileCategoryById(){
		$data= FileCategoryService::data();
		$result= FileCategoryService::getFileCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveFileCategory(){
		$data= FileCategoryService::data();
		$result= FileCategoryService::removeFileCategory($data);
		$this->returnJson($result);
	}
}
?>