<?php

class OrderController extends Controller{
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

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules()
	{
		$user= null;
		$reseller= null;
		if(Yii::app()->user->id!= null)
			$user= User::model()->findByPk(Yii::app()->user->id);
		if(Yii::app()->reseller->id!= null)
			$reseller= Reseller::model()->findByPk(Yii::app()->reseller->id);
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getAll',
								),
				'users'=>array('@'),
				'expression'=>'null!='.Yii::app()->user->id,
			),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getOrdersByReseller',
								'getOrderById',
								'create',
								),
				'users'=>array('*'),
				'expression'=>'null!='.Yii::app()->reseller->id,
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getAll',
								),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getOrdersByReseller',
								'getOrderById',
								'create',
								),
				'users'=>array('*'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	public function actionGetAll(){
		$data= OrderXService::data();
		$result= OrderXService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetOrdersByReseller(){
		$data= OrderXService::data();
		$result= OrderXService::getOrdersByReseller($data);
		$this->returnJson($result);
	}
	
	public function actionGetOrderById(){
		$data= OrderXService::data();
		$result= OrderXService::getOrderById($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= OrderXService::data();
		/* kiểm tra đủ tiền không */
		
		//if($data[''])
		// $data['clientid']= '10';
		
		// $data['pid[0]']= '1';
		// $data['domain[0]']= 'gggggggggggggggggggggggggh1.com';
		// $data['billingcycle[0]']= 'onetime';
		// $data['regperiod[0]']= '3';
		// $data['domaintype[0]']= 'register';
// 		
		// $data['pid[1]']= '1';
		// $data['domain[1]']= 'gggggggggggggggggggggggggh2.com';
		// $data['billingcycle[1]']= 'monthly';
		// $data['regperiod[1]']= '4';
		//$data['domaintype[1]']= 'transfer';//bỏ thằng này đi là bỏ domain đi, chỉ có product
		
		//tạo domain, ko có product
		// $data['domain[0]']= 'gggggggggggggggggggggggggh3.com';
		// $data['regperiod[0]']= '4';
		// $data['domaintype[0]']= 'register';
		
		//tạo product, domain cùng nhau, nhưng index lệch nhau
		
		// $data['pid[0]']= '1';
		// $data['domain[0]']= 'gggggggggggggggggggggggggh4.com';
		// $data['billingcycle[0]']= 'onetime';
// 		
		// $data['pid[1]']= '1';
		// $data['domain[1]']= 'gggggggggggggggggggggggggh5.com';
		// $data['billingcycle[1]']= 'onetime';
// 		
		// $data['domain[0]']= 'gggggggggggggggggggggggggh5.com';
		// $data['regperiod[0]']= '4';
		// $data['domaintype[0]']= 'register';
// 		
		// $data['paymentmethod'] = 'mailin';
		// $data['contactid']= '2';
		$result= OrderXService::create($data);
		$this->returnJson($result);
	}
	
}
?>