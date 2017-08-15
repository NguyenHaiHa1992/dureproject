<?php

class JobOrderController extends Controller{
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

	public function actionInit(){
		$data= JobOrderService::data();
		$result= JobOrderService::init($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= JobOrderService::data();
		$result= JobOrderService::create($data);
		$this->returnJson($result);
	}

	public function actionGetJobOrdersByPurchaseOrderId(){
		$data= JobOrderService::data();
		$result= JobOrderService::getJobOrdersByPurchaseOrderId($data);
		$this->returnJson($result);
	}

	public function actionGetAll(){
		$data= JobOrderService::data();
		$result= JobOrderService::getAll($data);
		$this->returnJson($result);
	}
}
?>