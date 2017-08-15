<?php

class InvoiceController extends Controller{
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
								'getInvoiceById',
								),
				'users'=>array('@'),
				'expression'=>'null!='.Yii::app()->user->id,
			),
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array(
								'getInvoicesByReseller',
								'getInvoiceById',
								'create',
								'update',
								'applyCredit',
								'getPaymentMethod',
								'viewInvoiceById',
								),
				'users'=>array('*'),
				'expression'=>'null!='.Yii::app()->reseller->id,
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getAll',
								),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'actions'=>array(
								'getInvoicesByReseller',
								'getInvoiceById',
								'create',
								'update',
								'applyCredit',
								'getPaymentMethod',
								'viewInvoiceById',
								),
				'users'=>array('*'),
				'deniedCallback' => function() { Yii::app()->controller->redirect(array ('site/loginReseller')); }
			),
		);
	}
	public function actionGetAll(){
		$data= InvoiceXService::data();
		$result= InvoiceXService::getAll($data);
		$this->returnJson($result);
	}
	
	public function actionCreate(){
		$data= InvoiceXService::data();
		
		$data['userid']= '10';
		$data['date']= '20150210';
		$data['duedate']= '20160210';
		$data['paymentmethod']= 'mailin';
		$data['autoapplycredit']= true;
		
		$data['itemdescription1']= 'create invoice description 1';
		$data['itemamount1']= '4';
		$data['itemtaxed1']= false;
		
		$data['itemdescription2']= 'create invoice description 2';
		$data['itemamount2']= '5';
		$data['itemtaxed2']= false;
		
		
		
		$result= InvoiceXService::create($data);
		$this->returnJson($result);
	}
	
	public function actionUpdate(){
		$data= InvoiceXService::data();
		
		$data['invoiceid']= '34';
		//$data['invoicenumb']= '33';
		
		$data['status']= 'Unpaid';
		
		// $data["itemdescription[63]"]= "Description Update";
		// $data["itemamount[63]"]= "1";
		// $data["itemtaxed[63]"]= "1";
		
		// $invoice= InvoiceXService::getInvoiceById(array('id'=> '34'));
		// //var_dump($invoice['invoice']['items'][0]['description']); exit;
		// if(isset($invoice['invoice']['items'])){
			// $index= 0;
			// foreach ($invoice['invoice']['items'] as $key => $invoice_item) {
				// if(strpos($invoice_item['description'], 'nguyenvanhaicd.com')!== false && strpos($invoice_item['description'], 'Domain Registration')=== false){
					// $data['newitemdescription['.$index.']']= $invoice_item['description'].' - chiết khấu';
					// $data['newitemamount['.$index.']']= '-2';	
					// $data['newitemtaxed['.$index.']']= false;
					// $index++;	
				// }			
			// }
		// }
		
		// $data["newitemdescription[0]"] = "New Line Item";
 		// $data["newitemamount[0]"] = "1";
 		// $data["newitemtaxed[0]"] = false;
		
		$data['paymentmethod']= 'mailin';
		
		$result= InvoiceXService::update($data);
		$this->returnJson($result);
	}
	
	public function actionApplyCredit(){
		$data= InvoiceXService::data();
		
		$data['invoiceid']= '34';
		$data['amount']= '1';
		
		$result= InvoiceXService::applyCredit($data);
		$this->returnJson($result);
	}
	
	public function actionGetPaymentMethod(){
		$result= InvoiceXService::getPaymentMethod();
		$this->returnJson($result);
	}
	
	public function actionGetInvoicesByReseller(){
		$data= InvoiceXService::data();
		$result= InvoiceXService::getInvoicesByReseller($data);
		$this->returnJson($result);
	}
	
	public function actionGetInvoiceById(){//$data['id']
		$data= InvoiceXService::data();
		//$data['id']= '34';
		$result= InvoiceXService::getInvoiceById($data);
		$this->returnJson($result);
	}
	
	public function actionViewInvoiceById(){
		$data= InvoiceXService::data();
		$result= InvoiceXService::viewInvoiceById($data);
		$this->returnJson($result);
	}
}
?>