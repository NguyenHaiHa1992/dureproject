<?php

class SiteXService extends iPhoenixXService{
	public static function checkLoginReseller(){
		$result= array();
		if(Yii::app()->reseller->id!= null)
			$result['success']= true;
		else
			$result['success']= false;
		return $result;
	}
	
	public static function loginReseller($data){
		$result= array();

		if(!Yii::app()->reseller->isGuest){ 
			$result['success']= true;
		}
		else{
			$model=new ResellerLoginForm;
			$model->attributes= $data;
			if($model->login()){
				$result['success']= true;
			}
			else{
				$result['success']= false;
				$result['error']= 'RESELLER_LOGIN';
				$result['message']= 'your email or password invalid';
			}
		}
		
		return $result;
	}
	
	public static function logoutReseller(){
		$result= array();	
		if(Yii::app()->reseller->id!= null){
			Yii::app()->reseller->id= null;
			$result['success']= true;
		}
		else{
			$result['success']= false;
			$result['message']= 'Logout error';
		}
		return $result;
	}
	
	public static function registerReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'addclient';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$reseller_new= new Reseller();
			$reseller_new->id= (int)$result_api->clientid;
			$reseller_new->type= (int)$data['type'];
			if($reseller_new->validate()){
				$result['success']= true;
				$reseller_new->save();
				
				$reseller_history= new History();
				$reseller_history->reseller_id= $reseller_new->id;
				$reseller_history->type= 0;//0: là register
				if($reseller_history->validate()){
					$reseller_history->save();
				}
				else{
					$result['success']= false;
					$result['errors']= $reseller_history->getErrors();
				}
				if(isset($data['reseller_group_id']))
					if($data['reseller_group_id']!= ''){
						$reseller_group_new= new ResellerAndGroup();
						$reseller_group_new->reseller_id= (int)$result_api->clientid;
						$reseller_group_new->reseller_group_id= (int)$data['reseller_group_id'];
						$reseller_group_new->status= 1;
						if($reseller_group_new->validate())
							$reseller_group_new->save();
					}
				$result['id']= $result_api->clientid;
			}
			else{
				$result['success']= false;
				$result['errors']= $reseller_new->getErrors();
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
}
