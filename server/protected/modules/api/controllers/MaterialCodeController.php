<?php

class MaterialCodeController extends Controller{
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
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::update($data);
		$this->returnJson($result);
	}
	
	public function actionGetMaterialCodeById(){
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::getMaterialCodeById($data);
		$this->returnJson($result);
	}

	public function actionRemoveMaterialCode(){
		$data= MaterialCodeService::data();
		$result= MaterialCodeService::removeMaterialCode($data);
		$this->returnJson($result);
	}
}
?>