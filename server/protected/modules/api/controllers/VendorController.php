<?php

class VendorController extends Controller{
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
		$data= VendorService::data();
		$result= VendorService::createInit($data);
		$this->returnJson($result);
	}

	public function actionDetailInit(){
		$data= VendorService::data();
		$result= VendorService::detailInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= VendorService::data();
		$result= VendorService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmptyVendor(){
		$result= VendorService::getEmptyVendor();
		$this->returnJson($result);
	}
	
	public function actionGetEmptyVendorError(){
		$result= VendorService::getEmptyVendorError();
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= VendorService::data();
		$result= VendorService::create($data);
		$this->returnJson($result);
	}
	
	public function actionGetVendorById(){
		$data= VendorService::data();
		$result= VendorService::getVendorById($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= VendorService::data();
		$result= VendorService::update($data);
		$this->returnJson($result);
	}
	
	public function actionTest(){
		var_dump(time());
	}
}
?>