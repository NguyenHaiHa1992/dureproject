<?php

class HistoryController extends Controller{
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
		$data= HistoryService::data();
		$result= HistoryService::createInit($data);
		$this->returnJson($result);
	}
	
	public function actionDetailInit(){
		$data= HistoryService::data();
		$result= HistoryService::detailInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= HistoryService::data();
		$result= HistoryService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmptyHistory(){
		$result= HistoryService::getEmptyHistory();
		$this->returnJson($result);
	}
	
	public function actionGetEmptyHistoryError(){
		$result= HistoryService::getEmptyHistoryError();
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= HistoryService::data();
		$result= HistoryService::create($data);
		$this->returnJson($result);
	}
	
	public function actionGetHistoryById(){
		$data= HistoryService::data();
		$result= HistoryService::getHistoryById($data);
		$this->returnJson($result);
	}
	
	public function actionGetHistorysByCategoryId(){
		$data= HistoryService::data();
		$result= HistoryService::getHistorysByCategoryId($data);
		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= HistoryService::data();
		$result= HistoryService::update($data);
		$this->returnJson($result);
	}

	public function actionUpdatePriceRange(){
		$data= HistoryService::data();
		$result= HistoryService::updatePriceRange($data);
		$this->returnJson($result);
	}

	public function actionUpdatePriceRanges(){
		$data= HistoryService::data();
		$result= HistoryService::updatePriceRanges($data);
		$this->returnJson($result);
	}

	public function actionRemovePriceRange(){
		$data= HistoryService::data();
		$result= HistoryService::removePriceRange($data);
		$this->returnJson($result);
	}

	public function actionGetPrice(){
		$data= HistoryService::data();
		$result= HistoryService::getPrice($data);
		$this->returnJson($result);
	}
}
?>