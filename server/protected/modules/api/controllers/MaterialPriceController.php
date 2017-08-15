<?php

class MaterialPriceController extends Controller{
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
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::createInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::update($data);
		$this->returnJson($result);
	}

	public function actionRemoveMaterialPrice(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::update($data);
		$this->returnJson($result);
	}

	public function actionGetMaterialPriceById(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::getMaterialPriceById($data);
		$this->returnJson($result);
	}

	public function actionImportFile(){
		$data= MaterialPriceService::data();
		$result= MaterialPriceService::importFile($data);
		$this->returnJson($result);
	}
}
?>