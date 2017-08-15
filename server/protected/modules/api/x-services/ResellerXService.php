<?php

class ResellerXService extends iPhoenixXService{
	
	public static function getAll($data){//data là thông tin phân trang
		$result= array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(Reseller::model()->findAll());
		}
		$criteria = new CDbCriteria();
		if(isset($data['id'])){
			if($data['id']!= '')
				$criteria->compare('id', (int)$data['id']);
			if($data['firstname']!= '')
				$criteria->compare('firstname', $data['firstname']);
			if($data['lastname']!= '')
				$criteria->compare('lastname', $data['lastname']);
			if($data['companyname']!= '')
				$criteria->compare('companyname', $data['companyname']);
			if($data['email']!= '')
				$criteria->compare('email', $data['email']);
			if($data['created']!= '')
				$criteria->compare('created', strtotime($data['created']));
			if($data['status']!= '')
				$criteria->compare('status', $data['status']);
		}
		$total = Reseller::model()->count($criteria);
		$pages = new CPagination($total);
		if((int)$data['limitnum']== 0)
			$pages->setCurrentPage(0);
		else
			$pages->setCurrentPage((int)((int)$data['limitstart'])/((int)$data['limitnum']));
		$pages->setPageSize($data['limitnum']);
		$pages->applyLimit($criteria);  // the trick is here!
		$resellers = Reseller::model()->findAll($criteria);
		if($resellers!= null){
			$result['success']= true;
			$result['resellers']=self::convertListResellers($resellers, $data);
			$result['totalresults']= $total;
		}
		else{
			$result['success']= true;
			$result['resellers']= array();
			$result['message']= 'Chưa có nhóm nào được tạo!';
		}
		return $result;
	}
	
	public static function getResellerById($data){
		$result= array();
		if(Reseller::model()->findByPk((int)$data['id'])== null){
			$result['success']= false;
			$result['message']= 'Không tồn tại Đại lý!';
		}
		else{
			$id= $data['id'];
			$postfields= array();
			$postfields['action'] = 'getclientsdetails';
			$postfields['clientid'] = $id;
			$postfields['status'] = true;
			$result_api= self::executeService($postfields);
			if($result_api->result== 'success'){
				$result['success']= true;
				$result['reseller']= self::convertReseller($result_api);
			}
			else{
				$result['success']= false;
				$result['message']= $result_api->message;
			}
		}
		return $result;
	}
	
	public static function getResellerByEmail($data){
		$result= array();
		$email= $data['email'];
		$postfields= array();
		$postfields['action'] = 'getclientsdetails';
		$postfields['email'] = $email;
		$postfields['stats'] = true;
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['reseller']= self::convertReseller($result_api->client);
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function isExistResellerByEmail($data){
		$result= array();
		$email= $data['email'];
		$postfields= array();
		$postfields['action'] = 'getclientsdetails';
		$postfields['email'] = $email;
		$postfields['stats'] = true;
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){//đã tồn tại trong Hệt thống WHMCS
			$result['success']= true;
			if(Reseller::model()->findByPk((int)$result_api->client->id))
				$result['type']= 1; //đã tồn tại trong Hệ thống Reseller
			else
				$result['type']= 2;// chưa tồn tại trong Hệ thống Reseller
			$result['id']= $result_api->client->id;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function createReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action'] = 'addclient';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$reseller= new Reseller();
			$reseller->attributes= $data;
			$reseller->id= (int)$result_api->clientid;
			if(isset($data['group_id']))
				$reseller->group_id= (int)$data['group_id'];
			else
				$reseller->group_id= 0;
			
			if($reseller->validate()){
				$reseller->save();
				
				$identity=new ResellerIdentity($data['email'],$data['password2']);
                $identity->authenticate();
                Yii::app()->reseller->login($identity,0);
				
				$result['success']= true;
				$result['id']= $reseller->id;
			}
			else{
				$result['success']= false;
				$result['errors']= $reseller->getErrors();
				$result['message']= 'Có lỗi xảy ra!';
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function activeReseller($data){//$data['id]
		$result= array();
		$reseller= new Reseller();
		$reseller->id= (int)$data['id'];
		$reseller->group_id= 0;
		if($reseller->validate()){
			$reseller->save();
			$result['success']= true;
			$result['id']= $reseller->id;
		}
		else{
			$result['success']= false;
			$result['errors']= $reseller->getErrors();
			$result['message']= 'Không thể thực hiện yêu cầu này';
		}
		return $result;
	}
	
	public static function updateReseller($data){
		$result= array();
		$id_array['id']= $data['id'];
		$postfields= array();
		$postfields= $data;
		$postfields['action'] = 'updateclient';
		$postfields['clientid']= $id_array['id'];
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$reseller= Reseller::model()->findByPk((int)$data['id']);
			if($reseller!= null){
				$reseller->attributes= $data;
				$reseller->group_id= (int)$data['group_id'];
				if($reseller->validate()){
					$reseller->save();
					$result['success']= true;
					$result['id']= $result_api->clientid;
				}
				else{
					$result['success']= false;
					$result['errors']= $reseller->getErrors();
					$result['message']= 'Có lỗi xảy ra!';
				}
			}
			
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function deleteReseller($data){
		$result= array();
		$reseller= Reseller::model()->findByPk((int)$data['id']);
		if($reseller->delete())
			$result['success']= true;
		else
			$result['success']= false;
		return $result;
	}

	public static function getCredit($data){//$data[id]
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action'] = 'getcredits';
		$postfields['clientid']= $data['id'];
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			var_dump($result_api); exit;
			$result['totalresults']= $result_api->totalresults;
			$result['clientid']= $result_api->clientid;
			
			$result['success']= true;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function convertReseller($reseller){
		$result= get_object_vars($reseller);
		$reseller_object= Reseller::model()->findByPk((int)$result['id']);
		$result['group_id']= $reseller_object->group_id; 
		$result['host']= $reseller_object->host;
		$result['host_email']= $reseller_object->host_email;
		$result['host_email_password']= $reseller_object->host_email_password;
		$result['host_port']= $reseller_object->host_port;
		$result['host_encryption']= $reseller_object->host_encryption;
		return $result;
	}
	
	public static function convertArray($reseller){//lấy ra những trường cần thiết
		$reseller_object= Reseller::model()->findByPk($reseller->id);
		return array(
				'id'=>$reseller->id,
				'firstname'=> $reseller->firstname,
				'lastname'=> $reseller->lastname,
				'companyname'=> $reseller->companyname,
				'email'=> $reseller->email,
				'datecreated'=> $reseller->datecreated,
				'groupid'=> $reseller->groupid,
				'status'=> $reseller->status,
				'host'=> $reseller_object->host,
				'host_email'=> $reseller_object->host_email,
				'host_email_password'=> $reseller_object->host_email_password,
				'host_port'=> $reseller_object->host_port,
				'host_encryption'=> $reseller_object->host_encryption,
			);
	}
	
	public static function convertListResellers($resellers, $data){
		$result = array();
		// $sort_attribute= array();
		// if(isset($data['sort_attribute']) && isset($data['sort_type'])){
			// foreach($resellers as $reseller){
				// if(Reseller::model()->findByPk($reseller->id)!= null){
					// $tmp_reseller= self::convertReseller($reseller);
					// $sort_attribute[]= $tmp_reseller[$data['sort_attribute']];
					// $result[]= self::convertReseller($reseller);	
				// }
			// }
			// if($data['sort_type']== 'SORT_ASC')
				// array_multisort($sort_attribute, SORT_ASC, $result);
			// else
				// array_multisort($sort_attribute, SORT_DESC, $result);
		// }
		// else{
			foreach($resellers as $reseller){
				if(Reseller::model()->findByPk($reseller->id)!= null){
					$reseller_object= Reseller::model()->findByPk($reseller->id);
					$result[]= array(
										'id'=>$reseller->id,
										'firstname'=> $reseller->firstname,
										'lastname'=> $reseller->lastname,
										'companyname'=> $reseller->companyname,
										'email'=> $reseller->email,
										'created'=> date('Y-m-d', $reseller->created),
										'group_id'=> $reseller->group_id,
										'status'=> $reseller->status,
										'host'=> $reseller_object->host,
										'host_email'=> $reseller_object->host_email,
										'host_email_password'=> $reseller_object->host_email_password,
										'host_port'=> $reseller_object->host_port,
										'host_encryption'=> $reseller_object->host_encryption,
									);;
				}
			}
		// }
		// $result= array_slice($result, $data['limitstart'], $data['limitnum']);
		return $result;
	}
}
