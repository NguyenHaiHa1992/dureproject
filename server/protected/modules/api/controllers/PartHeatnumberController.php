<?php

class PartHeatnumberController extends Controller{
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
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::update($data);
		$this->returnJson($result);
	}

	public function actionRemovePartHeatnumber(){
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::update($data);
		$this->returnJson($result);
	}

	public function actionGetPartHeatnumberById(){
		$data= PartHeatnumberService::data();
		$result= PartHeatnumberService::getPartHeatnumberById($data);
		$this->returnJson($result);
	}
}
?>