<?php

class SignageCategoryController extends Controller{
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
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::createInit();
		$this->returnJson($result);
	}

	public function actionGetAll(){
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::create($data);
		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::update($data);
		$this->returnJson($result);
	}

	public function actionGetSignageCategoryById(){
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::getSignageCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveSignageCategory(){
		$data= SignageCategoryService::data();
		$result= SignageCategoryService::removeSignageCategory($data);
		$this->returnJson($result);
	}
}
?>
