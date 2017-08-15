<?php

class ContactController extends Controller{
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
			// array('allow',  // allow all users to access 'index' and 'view' actions.
				// 'actions'=>array(
								// 'getInvoiceById',
								// ),
				// 'users'=>array('@'),
				// 'expression'=>'null!='.Yii::app()->user->id,
			// ),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getContactById',
								'getContactsByReseller',
								'getContactByEmail',
								'getContactByResellerAndEmail',
								'create',
								'update',
								),
				'users'=>array('*'),
				'expression'=>'null!='.Yii::app()->reseller->id,
			),
			// array('deny',  // deny all users
				// 'actions'=>array(
								// 'getAll',
								// ),
				// 'users'=>array('*'),
			// ),
			array('deny',  // deny all users
				'actions'=>array(
								'getContactById',
								'getContactsByReseller',
								'getContactByEmail',
								'getContactByResellerAndEmail',
								'create',
								'update',
								),
				'users'=>array('*'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	
	public function actionGetContactById(){
		$data= ContactXService::data();
		$result= ContactXService::getContactById($data);
		$this->returnJson($result);
	}
	
	public function actionGetContactsByReseller(){
		$data= ContactXService::data();
		$result= ContactXService::getContactsByReseller($data);
		$this->returnJson($result);
	}
	
	public function actionGetContactByEmail(){
		$data= ContactXService::data();
		$result= ContactXService::getContactByEmail($data);
		$this->returnJson($result);
	}
	
	public function actionGetContactByResellerAndEmail(){
		$data= ContactXService::data();
		$result= ContactXService::getContactsByReseller($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ContactXService::data();
		$result= ContactXService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= ContactXService::data();
		$result= ContactXService::update($data);
		$this->returnJson($result);
	}
	
	public function actionDelete(){
		$data= ContactXService::data();
		$result= ContactXService::delete($data);
		$this->returnJson($result);
	}
}
?>