<?php

class ClientController extends Controller{
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
		$data= ClientService::data();
		$result= ClientService::createInit($data);
		$this->returnJson($result);
	}

	public function actionDetailInit(){
		$data= ClientService::data();
		$result= ClientService::detailInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= ClientService::data();
		$result= ClientService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmptyClient(){
		$result= ClientService::getEmptyClient();
		$this->returnJson($result);
	}
	
	public function actionGetEmptyClientError(){
		$result= ClientService::getEmptyClientError();
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= ClientService::data();
		$result= ClientService::create($data);
		$this->returnJson($result);
	}
	
	public function actionGetClientById(){
		$data= ClientService::data();
		$result= ClientService::getClientById($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= ClientService::data();
		$result= ClientService::update($data);
		$this->returnJson($result);
	}
	
	public function actionTest(){
		var_dump(time());
	}
}
?>