<?php

class ResellerGroupController extends Controller{
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
								'findAll',
								'getAll',
								'getResellerGroupById',
								'getResellerGroupByName',
								'create',
								'update',
								'delete',
								),
				'users'=>array('@'),
				'expression'=>'null!='.Yii::app()->user->id,
			),
			// array('allow',  // allow all users to access 'index' and 'view' actions.
				// 'actions'=>array(
								// 'getResellerGroupById',
								// ),
				// 'users'=>array('@'),
				// 'expression'=>'null!='.Yii::app()->reseller->id,
			// ),
			array('deny',  // deny all users
				'actions'=>array(
								'findAll',
								'getAll',
								'getResellerGroupById',
								'getResellerGroupByName',
								'create',
								'update',
								'delete',
								),
				'users'=>array('*'),
			),
			// array('deny',  // deny all users
				// 'actions'=>array(
								// 'getResellerGroupById',
								// ),
				// 'users'=>array('*'),
				// 'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			// ),
		);
	}
	public function actionFindAll(){
		$result= ResellerGroupService::findAll();
		$this->returnJson($result);
	}
	public function actionGetAll(){
		$data= ResellerGroupService::data();//data thông tin phân trang
		$result= ResellerGroupService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetResellerGroupById(){
		$data= ResellerGroupService::data();
		$result= ResellerGroupService::getResellerGroupById($data);
		$this->returnJson($result);
	}

	public function actionGetResellerGroupByName(){
		$data= ResellerGroupService::data();
		$result= ResellerGroupService::getResellerGroupByName($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ResellerGroupService::data();
		$result= ResellerGroupService::create($data);
		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= ResellerGroupService::data();
		$result= ResellerGroupService::update($data);
		$this->returnJson($result);
	}
	
	public function actionDelete(){
		$data= ResellerGroupService::data();
		$result= ResellerGroupService::delete($data);
		$this->returnJson($result);
	}
}
?>