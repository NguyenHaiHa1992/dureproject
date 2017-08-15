<?php
class PartController extends Controller{
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
		$data= PartService::data();
		$result= PartService::createInit($data);
		$this->returnJson($result);
	}

	public function actionListInit(){
		$data= PartService::data();
		$result= PartService::listInit($data);
		$this->returnJson($result);
	}

	public function actionDetailInit(){
		$data= PartService::data();
		$result= PartService::detailInit($data);
		$this->returnJson($result);
	}
	
	public function actionGetAll(){
		$data= PartService::data();
		$result= PartService::getAll($data);
		$this->returnJson($result);
	}

	public function actionGetAllPartCode(){
		$data= PartService::data();
		$result= PartService::getAllPartCode($data);
		$this->returnJson($result);
	}
	
	public function actionGetEmptyPart(){
		$result= PartService::getEmptyPart();
		$this->returnJson($result);
	}
	
	public function actionGetEmptyPartError(){
		$result= PartService::getEmptyPartError();
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= PartService::data();
		$result= PartService::create($data);
		$this->returnJson($result);
	}
	
	public function actionGetPartById(){
		$data= PartService::data();
		$result= PartService::getPartById($data);
		$this->returnJson($result);
	}
	
	public function actionGetPartsByCategoryId(){
		$data= PartService::data();
		$result= PartService::getPartsByCategoryId($data);
		$this->returnJson($result);
	}

	public function actionUpdate(){
		$data= PartService::data();
		$result= PartService::update($data);
		$this->returnJson($result);
	}

	public function actionUpdatePriceRange(){
		$data= PartService::data();
		$result= PartService::updatePriceRange($data);
		$this->returnJson($result);
	}

	public function actionUpdatePriceRanges(){
		$data= PartService::data();
		$result= PartService::updatePriceRanges($data);
		$this->returnJson($result);
	}

	public function actionRemovePriceRange(){
		$data= PartService::data();
		$result= PartService::removePriceRange($data);
		$this->returnJson($result);
	}

	public function actionGetPrice(){
		$data= PartService::data();
		$result= PartService::getPrice($data);
		$this->returnJson($result);
	}

	public function actionGetExistPrice(){
		$part = Part::model()->findByPk(8);
		echo $part->getPrice(3000);
	}

	public function actionGetPriceTablePdf(){
		$data= PartService::data();
		$result= PartService::getPriceTablePdf($data);
		$this->returnJson($result);
	}

	public function actionUpdateHeatnumber(){
		$data= PartService::data();
		$result= PartService::updateHeatnumber($data);
		$this->returnJson($result);
	}

	public function actionRemoveHeatnumber(){
		$data= PartService::data();
		$result= PartService::removeHeatnumber($data);
		$this->returnJson($result);
	}

	public function actionCheckIn(){
		$data= PartService::data();
		$result= PartService::checkIn($data);
		$this->returnJson($result);
	}

	public function actionCheckOut(){
		$data= PartService::data();
		$result= PartService::checkOut($data);
		$this->returnJson($result);
	}

	public function actionGetInOutParts(){
		$data= PartService::data();
		$result= PartService::getInOutParts($data);
		$this->returnJson($result);
	}

	public function actionGetAllInOutPart(){
		$data= PartService::data();
		$result= PartService::getAllInOutPart($data);
		$this->returnJson($result);
	}

	public function actionGetRelatedMachines(){
		$data= PartService::data();
		$result= PartService::getRelatedMachines($data);
		$this->returnJson($result);
	}

	public function actionGetHeatnumberDetailInfo(){
		$data= PartService::data();
		$result= PartService::getHeatnumberDetailInfo($data);
		$this->returnJson($result);
	}

	public function actionSavePdfToUploadDocuments(){
		$data= PartService::data();
		$result= PartService::savePdfToUploadDocuments($data);
		$this->returnJson($result);		
	}

	public function actionGetOrderedPartInfo(){
		$data= PartService::data();
		$result= PartService::getOrderedPartInfo($data);
		$this->returnJson($result);		
	}
}
?>