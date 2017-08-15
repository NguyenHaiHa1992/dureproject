<?php

class ContactXService extends iPhoenixXService{
	public static function getAll($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getcontacts';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->contacts))
				$result['contacts']= self::convertListContacts($result_api->contacts->contact);
			else
				$result['contacts']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getContactById($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getcontacts';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			if(isset($result_api->contacts)){
				$result['contacts']= self::convertListContacts($result_api->contacts->contact, $data);
				if(count($result['contacts'])== 1){
					$result['success']= true;
				}
				else{
					$result['success']= false;
					$result['message']= 'Không tồn tại Contact này!';
				}
			}
			else{
				$result['success']= false;
				$result['message']= $result_api->message;
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getContactsByReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['userid']= Yii::app()->reseller->id;
		$postfields['action']= 'getcontacts';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['totalresults']= $result_api->totalresults;
			if(isset($result_api->contacts))
				$result['contacts']= self::convertListContacts($result_api->contacts->contact, $data);
			else
				$result['contacts']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getContactByEmail($data){//$data['email']
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getcontacts';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->contacts->contact[0]))
				$result['contact']= self::convertContact($result_api->contacts->contact[0]);
			else{
				$result['contact']= null;
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function updateContact($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'updatecontact';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['id']= $result_api->contactid;
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
		if(!isset($data['clientid']))
			$postfields['clientid']= Yii::app()->reseller->id;
		$postfields['action']= 'addcontact';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['id']= $result_api->contactid;
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
		$postfields['contactid']= $data['id'];
		$postfields['action']= 'updatecontact';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['id']= $result_api->contactid;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function delete($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'deletecontact';
		$result_api= self::executeService($postfields);
		
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['id']= $result_api->contactid;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function convertContact($contact){
		$result= get_object_vars($contact);
		if($result['generalemails']== '1')
			$result['generalemails']= true;
		else
			$result['generalemails']= false;
		
		if($result['productemails']== '1')
			$result['productemails']= true;
		else
			$result['productemails']= false;
		
		if($result['domainemails']== '1')
			$result['domainemails']= true;
		else
			$result['domainemails']= false;
		
		if($result['invoiceemails']== '1')
			$result['invoiceemails']= true;
		else
			$result['invoiceemails']= false;
		
		if($result['supportemails']== '1')
			$result['supportemails']= true;
		else
			$result['supportemails']= false;
		return $result;
	}
	
	public static function convertListContacts($contacts, $data){
		$result = array();
		foreach ($contacts as $contact) {
			$result[]= self::convertContact($contact);
		}
		return $result;
	}
}
