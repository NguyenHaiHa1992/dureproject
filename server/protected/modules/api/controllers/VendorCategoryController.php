<?php

class VendorCategoryController extends Controller{
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
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetVendorCategoryById(){
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::getVendorCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveVendorCategory(){
		$data= VendorCategoryService::data();
		$result= VendorCategoryService::removeVendorCategory($data);
		$this->returnJson($result);
	}
}
?>