<?php

class ResellerController extends Controller{
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
								'getAll',
								'getResellerById',
								'getResellerByEmail',
								'createReseller',
								'updateReseller',
								'deleteReseller',
								'getAllGroup',
								'updateResellerGroup',
								'getAllHistory',
								),
				'users'=>array('@'),
				'expression'=>'null!='.Yii::app()->user->id,
			),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getCurrentResellerById',
								'updateInformationReseller',
								),
				'users'=>array('*'),
				'expression'=> 'null!='.Yii::app()->reseller->id,
			),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'signupReseller',
								'isExistResellerByEmail',
								'activeReseller',
								),
				'users'=>array('*'),
			),
			// array('allow', // allow authenticated users to access all actions
				// 'users'=>array('@'),
			// ),
			// array('deny',  // deny all users
				// 'users'=>array('*'),
				// 'expression'=> 'null=='.Yii::app()->reseller->id.'&&null=='.Yii::app()->user->id,
			// ),
			array('deny',  // deny all users
				'actions'=>array(
								'getAll',
								'getResellerById',
								'getResellerByEmail',
								'createReseller',
								'updateReseller',
								'deleteReseller',
								'getAllGroup',
								'updateResellerGroup',
								'getAllHistory',
								),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getCurrentResellerById',
								'updateInformationReseller',
								),
				'users'=>array('*'),
				//'redirect'=>array('api/site/loginReseller'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	
	public function actionGetAll(){
		$data= ResellerXService::data();//data thông tin phân trang
		$result= ResellerXService::getAll($data);
		$this->returnJson($result);
	}
		
	public function actionGetResellerById(){
		$data= ResellerXService::data();//data['id']
		$result= ResellerXService::getResellerById($data);
		$this->returnJson($result);
	}
	
	public function actionGetCurrentResellerById(){
		$data= ResellerXService::data();//data['id']
		$data['id']= Yii::app()->reseller->id;
		$result= ResellerXService::getResellerById($data);
		$this->returnJson($result);
	}	
	
	public function actionGetResellerByEmail(){
		$data= ResellerXService::data();//data['email]
		$result= ResellerXService::getResellerByEmail($data);
		$this->returnJson($result);
	}	
	
	public function actionIsExistResellerByEmail(){
		$data= ResellerXService::data();//data['email]
		$result= ResellerXService::isExistResellerByEmail($data);
		$this->returnJson($result);
	}
	
	public function actionCreateReseller(){
		$data= ResellerXService::data();//data create
		$result= ResellerXService::createReseller($data);
		$this->returnJson($result);	
	}
	
	public function actionSignupReseller(){
		$data= ResellerXService::data();//data create
		$result= ResellerXService::createReseller($data);
		$this->returnJson($result);	
	}
	
	public function actionActiveReseller(){
		$data= ResellerXService::data();//data create
		$result= ResellerXService::activeReseller($data);
		$this->returnJson($result);
	}
	
	public function actionUpdateReseller(){
		$data= ResellerXService::data();//data update
		// $data= array(
					// 'id'=> '2',
// 					
					// 'firstname'=> 'Chu',
					// // 'lastname'=> '',
					// // 'companyname'=> '',
					// // 'email'=> '',
					// // 'address1'=> '',
					// // 'address2'=> '',
					// // 'city'=> '',
					// // 'state'=> '',
					// // 'postcode'=> '',
					// // 'country'=> '',
					// // 'phonenumber'=> '',
					// // 'password2'=> '',
					// // 'credit'=> '',
					// // 'taxexempt'=> '',
					// // 'notes'=> '',
					// // 'cardtype'=> '',
					// // 'cardnum'=> '',
					// // 'expdate'=> '',
					// // 'startdate'=> '',
					// // 'issuenumber'=> '',
					// // 'clearcreditcard'=> '',
					// // 'language'=> '',
					// // 'customfields'=> '',
					// // 'status'=> '',
					// // 'taxexempt'=> '',
					// // 'latefeeoveride'=> '',
					// // 'overideduenotices'=> '',
					// // 'separateinvoices'=> '',
					// // 'disableautocc'=> '',
					// );
		$result= ResellerXService::updateReseller($data);
		$this->returnJson($result);	
	}
	
	public function actionDeleteReseller(){
		$data= ResellerXService::data();//data create
		$result= ResellerXService::deleteReseller($data);
		$this->returnJson($result);	
	}
	
	public function actionUpdateInformationReseller(){
		$data= ResellerXService::data();//data update
		unset($data['credit']);
		$result= ResellerXService::updateReseller($data);
		$this->returnJson($result);	
	}
	
	public function actionGetAllGroup(){
		$data= ResellerGroupService::data();//data thông tin phân trang
		$data= array(
					'current_page'=> 0,
					'page_size'=> 25,
					);
		$result= ResellerGroupService::getAll($data);
		return $result;
	}
	
	public function actionUpdateResellerGroup(){
		$data= ResellerGroupService::data();
		$data= array(
					'id'=> 1,
					'service_id'=> 1,
					'discount'=> 10,
					'status'=> 1);
		
		$result= ResellerGroupService::updateResellerGroup($data);
		return $result;
	}
	
	public function actionGetAllHistory(){
		$data= SiteXService::data();
		$data= array(
					'current_page'=> 0,
					'page_size'=> 25,
					);
		$result= HistoryService::getAll($data);
		return $result;
	}
	
	public function actionTest(){
		var_dump(ResellerXService::getClientByPk(1)); exit;
	}
	public function actionStartGameWithCode(){
		$data= GiftService::data();
		if(isset($data) && (sizeof($data)>0)){
			$this->returnJson(GiftService::startGameWithCode($data));
		}
	}

}
?>