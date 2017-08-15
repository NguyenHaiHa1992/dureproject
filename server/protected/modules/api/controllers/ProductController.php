<?php

class ProductController extends Controller{
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
								'getAllGroups',
								'getAllDomains',
								'getProductById',
								'getProductsOfReseller',
								),
				'users'=>array('@'),
				'expression'=>'null!='.Yii::app()->user->id,
			),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getProductsOfCurrentReseller',
								'getAllGroups',
								'getAll',
								'getAllDomains',
								'domainWhoIs',
								'getDomainsByDomain',
								'getProductById',
								'getDomainPrice',
								'getDiscountByProductAndReseller',
								),
				'users'=>array('*'),
				'expression'=> 'null!='.Yii::app()->reseller->id,
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getAll',
								'getAllDomains',
								'getProductById',
								'getProductsOfReseller',
								),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getProductsOfCurrentReseller',
								'getAllGroups',
								'domainWhoIs',
								'getDomainsByDomain',
								'getDomainPrice',
								'getDiscountByProductAndReseller',
								),
				'users'=>array('*'),
				//'redirect'=>array('api/site/loginReseller'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	public function actionGetAll(){
		$data= ProductXService::data();//data thông tin phân trang
		$result= ProductXService::getAll($data);
		$this->returnJson($result);
	}
		
	public function actionGetAllGroups(){
		$data= ProductXService::data();//data thông tin phân trang
		$data= array(
					);
		$result= ProductXService::getAllGroups($data);
		$this->returnJson($result);
	}
	
	public function actionGetAllDomains(){
		$data= ProductXService::data();//data thông tin phân trang
		$data= array(
					);
		$result= ProductXService::getAllDomains($data);
		$this->returnJson($result);
	}
	
	public function actionGetDomainsByDomain(){
		$data= ProductXService::data();
		$result= ProductXService::getDomainsByDomain($data);
		$this->returnJson($result);
	}
	
	public function actionGetProductById(){
		$data= ProductXService::data();//data 
		$data= array(
					'id'=> 1,
					);
		$result= ProductXService::getProductById($data);
		return $result;
	}

	public function actionGetProductsOfReseller(){
		$data= ProductXService::data();//data['id']
		$data['clientid']= '2';
		$result= ProductXService::getProductsOfReseller($data);
		return $result;
	}
	
	public function actionGetProductsOfCurrentReseller(){
		$data= ProductXService::data();//
		$data['clientid']= (string)Yii::app()->reseller->id;
		
		$result= ProductXService::getProductsOfReseller($data);
		$this->returnJson($result);
	}
	
	public function actionTest(){
		//var_dump(DomainXService::test()); exit;
		$whmcsurl = "http://man.199x.net/dologin.php";
		$autoauthkey = 'abcXYZ123';
		
		$timestamp = time(); # Get current timestamp
		$email = "hainv@gmail.com"; # Clients Email Address to Login
		$goto = "clientarea.php?action=products";
		
		$hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash
		
		# Generate AutoAuth URL & Redirect
		$url = $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode('http://google.com');
		header("Location: $url");
		exit;
	}
	public function actionStartGameWithCode(){
		$data= GiftService::data();
		if(isset($data) && (sizeof($data)>0)){
			$this->returnJson(GiftService::startGameWithCode($data));
		}
	}
	
	public function actionDomainWhoIs(){
		$data= DomainXService::data();
		$result= DomainXService::domainWhoIs($data);
		$this->returnJson($result);
	}
	
	public function actionGetDomainPrice(){
		$data= DomainXService::data();
		$result= DomainXService::getDomainPrice($data);
		$this->returnJson($result);
	}

	public function actionGetDiscountByProductAndReseller(){
		$data= ProductXService::data();
		$result= ProductXService::getDiscountByProductAndReseller($data);
		$this->returnJson($result);
	}

}
?>