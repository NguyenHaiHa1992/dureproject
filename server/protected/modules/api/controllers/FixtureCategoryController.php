<?php

class FixtureCategoryController extends Controller{
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
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::createInit();
		$this->returnJson($result);
	}

	public function actionGetAll(){
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::create($data);
		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::update($data);
		$this->returnJson($result);
	}

	public function actionGetFixtureCategoryById(){
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::getFixtureCategoryById($data);
		$this->returnJson($result);
	}

	public function actionRemoveFixtureCategory(){
		$data= FixtureCategoryService::data();
		$result= FixtureCategoryService::removeFixtureCategory($data);
		$this->returnJson($result);
	}
}
?>
