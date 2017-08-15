<?php

class MaterialController extends Controller{
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
		$data= MaterialService::data();
		$result= MaterialService::createInit($data);
		$this->returnJson($result);
	}

	public function actionListInit(){
		$data= MaterialService::data();
		$result= MaterialService::listInit($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= MaterialService::data();
		$result= MaterialService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MaterialService::data();
		$result= MaterialService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MaterialService::data();
		$result= MaterialService::getAll($data);
		$this->returnJson($result);
	}

	public function actionGetAllMaterialCode(){
		$data= MaterialService::data();
		$result= MaterialService::getAllMaterialCode($data);
		$this->returnJson($result);
	}
	
	public function actionGetMaterialById(){
		$data= MaterialService::data();
		$result= MaterialService::getMaterialById($data);
		$this->returnJson($result);
	}

	public function actionCheckin(){
		$data= MaterialService::data();
		$result= MaterialService::checkin($data);
		$this->returnJson($result);
	}

	public function actionCheckout(){
		$data= MaterialService::data();
		$result= MaterialService::checkout($data);
		$this->returnJson($result);
	}

	public function actionGetInOutMaterials(){
		$data= MaterialService::data();
		$result= MaterialService::getInOutMaterials($data);
		$this->returnJson($result);
	}

	public function actionUpdateHeatnumber(){
		$data= MaterialService::data();
		$result= MaterialService::updateHeatnumber($data);
		$this->returnJson($result);
	}

	public function actionRemoveHeatnumber(){
		$data= MaterialService::data();
		$result= MaterialService::removeHeatnumber($data);
		$this->returnJson($result);
	}

	public function actionGetHeatnumberDetailInfo(){
		$data= MaterialService::data();
		$result= MaterialService::getHeatnumberDetailInfo($data);
		$this->returnJson($result);
	}

	public function actionImportHeatnumber(){
		$data= MaterialService::data();
		$result= MaterialService::importHeatnumber($data);
		$this->returnJson($result);
	}

	public function actionReturnItem(){
		$data= MaterialService::data();
		$result= MaterialService::returnItem($data);
		$this->returnJson($result);
	}
}
?>