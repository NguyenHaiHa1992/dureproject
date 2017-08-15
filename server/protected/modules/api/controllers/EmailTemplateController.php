<?php
class EmailTemplateController extends Controller{
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

	public function actionGetAll(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmailTemplateById(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::getEmailTemplateById($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmailTemplateByName(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::getEmailTemplateByName($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::update($data);
		$this->returnJson($result);
	}
	
	public function actionDelete(){
		$data= EmailTemplateService::data();
		$result= EmailTemplateService::delete($data);
		$this->returnJson($result);
	}
}
?>