<?php

class PurchaseOrderController extends Controller{
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
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::createInit($data);
		$this->returnJson($result);
	}

	public function actionCheckOutInit(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::checkOutInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::getAll($data);
		$this->returnJson($result);
	}

	public function actionGetAllCategory(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::getAllCategory($data);
		$this->returnJson($result);
	}

	public function actionGetAllPurchaseOrderCode(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::getAllPurchaseOrderCode($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		// if($_POST['fileToUpload']){
			// var_dump('ol');
			// var_dump($_POST['fileToUpload']);
			// var_dump($_FILES); exit;
		// }
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::create($data);
		$this->returnJson($result);
	}
	
	public function actionGetPurchaseOrderById(){
		$data= iPhoenixService::data();
		$result= array();
		$part_order= PurchaseOrder::model()->findByPk($data['id']);
		
		$this->returnJson($result);
	}

	public function actionCheckPurchaseOrderCode(){
		$data= iPhoenixService::data();

		$criteria = new CDbCriteria();
		$criteria->compare('po_code', $data['po_code']);
		$po = PurchaseOrder::model()->find($criteria);
		
		if(isset($po))
			$result = array('success'=>true, 'id'=>$po->id, 'po_code'=>$po->po_code);
		else
			$result = array('success'=>false);

		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::update($data);
		$this->returnJson($result);
	}

	public function actionPreview(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::preview($data);
		$this->returnJson($result);
	}

	public function actionSummary(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::summary($data);
		$this->returnJson($result);
	}

	public function actionCheckout(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::checkout($data);
		$this->returnJson($result);
	}

	public function actionGenerateCertificate(){
		$data= PurchaseOrderService::data();
		$result= PurchaseOrderService::generateCertificate($data);
		$this->returnJson($result);
	}
}
?>