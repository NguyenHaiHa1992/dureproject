<?php

class TransactionXService extends iPhoenixXService{
	public static function getTransactionsByReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'gettransactionswithsearch';
		//$postfields['userid']= Yii::app()->reseller->id;
		$postfields['userid']= '2';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['totalresults']= $result_api->totalresults;
			if(isset($result_api->transactions))
				$result['transactions']= self::convertListTransactions($result_api->transactions, $data);
			else
				$result['transactions']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}

	public static function convertTransaction($transaction){
		$result= get_object_vars($transaction);
		if($result['gateway']= 'mailin')
			$result['gateway']= 'Thanh toán trực tiếp';
		return $result;
	}
	
	public static function convertListTransactions($transactions, $data){
		$result = array();
		foreach($transactions as $transaction){				
			$tmp_transaction= get_object_vars($transaction);
			if($tmp_transaction['gateway']== 'mailin')
				$tmp_transaction['gateway']= 'Thanh toán trực tiếp';
			$result[]= $tmp_transaction;
		}
		return $result;
	}
}
