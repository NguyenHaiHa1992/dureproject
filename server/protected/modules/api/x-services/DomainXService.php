<?php

class DomainXService extends iPhoenixXService{
	
	public static function getAll($data){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getdomains';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->domains))
				$result['domains']= self::convertListDomains($result_api->domains);
			else
				$result['domains']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getDomainById($data){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getdomains';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			if(isset($result_api->domains)){
				$result['success']= false;
				foreach($result_api->domains as $key => $domain){
					if($domain->id== $data['id']){
						$result['success']= true;
						$result['domain']= self::convertDomain($domain);	
					}		
				}
				if($result['success']== false)
					$result['message']= 'Không tồn tại Domain này';
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function domainWhoIs($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'domainwhois';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['status']= $result_api->status;
			$result['whois']= $result_api->whois;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getDomainPrice($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getdomainprice';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['domains']= self::convertListDomains($result_api->domains);
			$result['totalresults']= $result_api->totalresults;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function test(){
		$result= array();
		$postfields= array();
		$postfields['action']= 'test';
		$result_api= self::executeService($postfields);
		var_dump($result_api); exit;
		
	}
	
	public static function convertDomain($domain){
		$result= get_object_vars($domain);
		if(isset($result['relid'])){
			$reseller= Reseller::model()->findByPk(Yii::app()->reseller->id);
			$discount= ResellerGroupDetail::model()->findByAttributes(array(
																		'reseller_group_id'=> $reseller->group_id,
																		'product_domain_id'=> (int)$result['relid'],
																		'type'=> 2,
																	));	
			if($discount)
				$result['discount']= $discount->discount;
			else
				$result['discount']= 0;
		}
		
		return $result;
	}
	
	public static function convertListDomains($domains){
		$result = array();
		foreach($domains as $domain){
			$result[]=self::convertDomain($domain);
		}
		return $result;
	}
}
