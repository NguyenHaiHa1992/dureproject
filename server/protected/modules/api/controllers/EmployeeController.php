<?php

class EmployeeController extends Controller{
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
		$data= EmployeeService::data();
		$result= EmployeeService::createInit();
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= EmployeeService::data();
		$result= EmployeeService::getAll($data);
		$this->returnJson($result);
	}

	public function actionCreate(){
		$data= EmployeeService::data();
		$result= EmployeeService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= EmployeeService::data();
		$result= EmployeeService::update($data);
		$this->returnJson($result);
	}

	public function actionRemoveEmployee(){
		$data= EmployeeService::data();
		$result= EmployeeService::update($data);
		$this->returnJson($result);
	}

	public function actionGetEmployeeById(){
		$data= EmployeeService::data();
		$result= EmployeeService::getEmployeeById($data);
		$this->returnJson($result);
	}

	public function actionGetEmployeesByOrderId(){
		$data= EmployeeService::data();
		$result= EmployeeService::getEmployeesByOrderId($data);
		$this->returnJson($result);
	}
}
?>