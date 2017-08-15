<?php

class TransactionController extends Controller{
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
			// array('allow',  // allow all users to access 'index' and 'view' actions.
				// 'actions'=>array(
								// 'getTransactionById',
								// ),
				// 'users'=>array('@'),
				// 'expression'=>'null!='.Yii::app()->user->id,
			// ),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getTransactionsByReseller',
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
								'getTransactionsByReseller',
								),
				'users'=>array('*'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	
	public function actionGetTransactionsByReseller(){
		$data= TransactionXService::data();
		$result= TransactionXService::getTransactionsByReseller($data);
		$this->returnJson($result);
	}
	
}
?>