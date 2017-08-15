<?php

class InvoiceXService extends iPhoenixXService{
	
	public static function getAll($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getinvoices';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->invoices))
				$result['invoices']= self::convertListInvoices($result_api->invoices->invoice);
			else
				$result['invoices']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getInvoicesByReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getinvoiceswithsearch';
		// $postfields['limitstart']= 0;
		// $postfields['limitnum']= 10000;
		$postfields['userid']= Yii::app()->reseller->id;
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['totalresults']= $result_api->totalresults;
			if(isset($result_api->invoices))
				$result['invoices']= self::convertListInvoices($result_api->invoices, $data);
			else
				$result['invoices']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getInvoiceById($data){//$data['id']
		$result= array();
		$postfields= array();
		$postfields['invoiceid']= $data['id'];
		$postfields['action'] = 'getinvoice';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			if($result_api->userid!= (string)Yii::app()->reseller->id){
				$result['success']= false;
				$result['message']= 'Không thể thực hiện yêu cầu này!';
			}
			else{
				$result['success']= true;
				$result['invoice']= self::convertInvoice($result_api);
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'createinvoice';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['invoiceid']= $result_api->invoiceid;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'updateinvoice';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['invoiceid']= $result_api->invoiceid;
			
			// apply credit
			// $result['applyCredit']= self::applyCredit(array('invoiceid'=> '34', 'amount'=> '-2'));
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function applyCredit($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'applycredit';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['invoiceid']= $result_api->invoiceid;
			$result['amount']= $result_api->amount;
			$result['invoicepaid']= $result_api->invoicepaid;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getPaymentMethod(){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getpaymentmethods';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['totalresults']= $result_api->totalresults;
			$result['paymentmethods']= array();
			if($result_api->paymentmethods->paymentmethod){
				foreach ($result_api->paymentmethods->paymentmethod as $key => $paymentmethod) {
					$result['paymentmethods'][]= get_object_vars($paymentmethod);
				}
			}
			
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function viewInvoiceById($data){//$data['id']
		$result= array();
		$reseller= ResellerXService::getResellerById(array('id'=> Yii::app()->reseller->id));
		$result['success']= true;
		$autoauthkey= 'abcXYZ123';
		$timestamp= time();
		$email= $reseller['reseller']['email'];
		$goto= "";
		$hash= sha1($email.$timestamp.$autoauthkey);
		$goto= "viewinvoice.php?id=".$data['id'];
		$result['url']= "http://man.199x.net/dologin.php?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
		return $result;			
	}
	
	public static function convertInvoiceItem($invoice_item){
		$result= get_object_vars($invoice_item);
		if($result['taxed']== '1')
			$result['taxed']= 'Yes';
		else
			$result['taxed']= 'No';
		return $result;
	}
	
	public static function convertListInvoiceItems($invoice_items){
		$result= array();
		foreach ($invoice_items as $invoice_item) {
			$result[]= self::convertInvoiceItem($invoice_item);
		}
		return $result;
	}
	
	public static function convertInvoice($invoice){
		$result= get_object_vars($invoice);
		if($result['paymentmethod']= 'mailin')
			$result['paymentmethod']= 'Thanh toán trực tiếp';
		if(isset($result['items']))
			$result['items']= self::convertListInvoiceItems($result['items']->item);
		return $result;
	}
	
	public static function convertListInvoices($invoices, $data){
		$result = array();
		foreach($invoices as $invoice){				
			$tmp_invoice= get_object_vars($invoice);
			if($tmp_invoice['paymentmethod']== 'mailin')
				$tmp_invoice['paymentmethod']= 'Thanh toán trực tiếp';
			$result[]= $tmp_invoice;
		}
		return $result;
	}
}
