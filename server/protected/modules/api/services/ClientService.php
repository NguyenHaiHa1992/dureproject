<?php
class ClientService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_client= ClientService::getEmptyClient();
		if(isset($data['id']) && $data['id']!= ''){
			$client= ClientService::getClientById(array('id'=> $data['id']));
			if($client['success']== true){
				$result['client']= $client['client'];
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['client']= $get_empty_client['client'];
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['client']= $get_empty_client['client'];
			$result['is_update']= false;
			$result['is_create']= true;
		}
		
		$result['client_empty']= $get_empty_client['client'];
		$get_empty_client_error= ClientService::getEmptyClientError();
		$result['client_error']= $get_empty_client_error['client_error'];
		$result['client_error_empty']= $get_empty_client_error['client_error'];

		$client_categories = ClientCategoryService::getAll(array());
		$result['client_categories'] = $client_categories['client_categories'];

		$states = StateService::getAll(array());
		$result['states'] = $states['states'];

		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Client::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}

		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_client.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_client.*
			   From tbl_client";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['name']) && $data['name']!= ''){
			$sql= $sql."And tbl_client.name LIKE '%".$data['name']."%'";
		}
		if(isset($data['email']) && $data['email']!= ''){
			$sql= $sql."And tbl_client.email LIKE '%".$data['email']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$clients= Client::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['name']) && $data['name']!= ''){
			$criteria->compare('name', $data['name'], true);
		}
		if(isset($data['email']) && $data['email']!= ''){
			$criteria->compare('email', $data['email'], true);
		}
		$total= Client::model()->count($criteria);
		
		if($clients!= null){
			$result['success']= true;
			$result['clients']=self::convertListClient($clients, $data);
			
			$result['totalresults']= $total;
			$result['start_client']= (int)$data['limitstart']+ 1;
			$result['end_client']= (int)$data['limitstart']+ count($clients);
		}
		else{
			$result['success']= true;
			$result['clients']= array();
			$result['totalresults']= $total;
			$result['start_client']= 0;
			$result['end_client']= 0;
		}
		return $result;
	}
	
	public static function getEmptyClient(){
		$result= array();
		$client= array(
					'id'=> '',
					'name'=> '',
					'address1'=> '',
					'address2'=> '',
					'country'=> '',
					'city'=> '',
					'state_id'=> '',
					'zipcode'=> '',
					'company_name'=> '',
					'contact_name'=> '',
					'email'=> '',
					'phone'=> '',
					'fax'=> '',
					'status'=> '',
					'created_time'=> '',
					'category_ids'=>'',
					'state_name'=>'',
					'tmp_file_ids'=>'',
					);
		$result['client']= $client;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyClientError(){
		$result= array();
		$client= array(
					'id'=> array(),
					'name'=> array(),
					'address1'=> array(),
					'address2'=> array(),
					'country'=> array(),
					'city'=> array(),
					'state_id'=> array(),
					'zipcode'=> array(),
					'company_name'=> array(),
					'contact_name'=> array(),
					'email'=> array(),
					'phone'=> array(),
					'fax'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'category_ids'=>array(),
					'tmp_file_ids'=>array(),
					);
		
		$result['client_error']= $client;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmailTemplatesByReseller($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(EmailTemplate::model()->findAll());
		}
		
		$criteria = new CDbCriteria();
		$criteria->compare('reseller_id', Yii::app()->reseller->id);
		if(isset($data['id']) && $data['id']!= '')
			$criteria->compare('id', (int)$data['id']);
		if(isset($data['name']) && $data['name']!= '')
			$criteria->compare('name', $data['name']);
		if(isset($data['created']) && $data['created']!= ''){
			$start_time= strtotime($data['created'].' 00:00:00');
			$end_time= strtotime($data['created'].' 24:00:00');
			$criteria->condition='created >='.$start_time;
			$criteria->condition='created <'.$end_time;
		}
		$total = EmailTemplate::model()->count($criteria);
		$pages = new CPagination($total);
		$pages->setCurrentPage((int)((int)$data['limitstart'])/((int)$data['limitnum']));
		$pages->setPageSize($data['limitnum']);
		$pages->applyLimit($criteria);  // the trick is here!
		$email_templates = EmailTemplate::model()->findAll($criteria);
		if($email_templates!= null){
			$result['success']= true;
			$result['email_templates']=self::convertListEmailTemplate($email_templates, $data);
			$result['totalresults']= $total;
		}
		else{
			$result['success']= true;
			$result['email_templates']= array();
			$result['totalresults']= $total;
		}
		return $result;
	}
	
	public static function getClientById($data){
		$result= array();
		$get_empty_client_error= ClientService::getEmptyClientError();
		$result['client_error']= $get_empty_client_error['client_error'];
		
		$client;
		$client= Client::model()->findByPk((int)$data['id']);
		if($client!= null){
			$result['success']= true;
			$result['client']= self::convertClient($client);
		}
		else{
			$result['success']= false;
			$result['message']= 'Client\'s not found!';
		}
		return $result;
	}
	
	public static function getClientsByCategoryId($data){//data['id']
		$result= array();
		$clients= Client::model()->findAllByAttributes(array('category_id'=>$data['id']));
		if($clients!= null && count($clients)>0){
			$result['success']= true;
			$result['clients']= self::convertListClient($clients, $data);
		}
		else{
			$result['success']= true;
			$result['clients']= array();
		}
		return $result;
	}
	
	public static function getEmailTemplateByName($data){
		$result= array();
		$email_template= EmailTemplate::model()->findByAttributes(array('name'=>$data['name']));
		if($email_template!= null){
			$result['success']= true;
			$result['email_template']= self::convertEmailTemplate($email_template);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại Email Template này!';
		}
		return $result;
	}
	
	
	
	public static function create($data){
		$result= array();
		$client= new Client();
		$client->attributes= $data;
		$client= ClientService::beforeSave($client);
		if($client->validate()){
			$client->save();
			$result['success']= true;
			$result['id']= $client->id;
			$new_client= self::getClientById(array('id'=> $client->id));
			$result['client']= $new_client['client'];
		}
		else{
			$empty_client_error= ClientService::getEmptyClientError();
			$result['client_error']= $empty_client_error['client_error']; 
			foreach ($client->getErrors() as $key => $error_array) {
				$result['client_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Client has some errors';
			$result['error_array']= $client->getErrors();
		}
		
		return $result;
	}
	
	
	public static function update($data){
		$result= array();
		$client= Client::model()->findByPk((int)$data['id']);
		$client->attributes= $data;
		
		$client= ClientService::beforeSave($client);
		if($client->validate()){
			$client->save();
			$result['success']= true;
			$client_array= ClientService::getClientById(array('id'=>$client->id));
			$get_empty_client_error= ClientService::getEmptyClientError();
			$result['client_error']= $get_empty_client_error['client_error'];
			$result['client']= $client_array['client'];
			$result['id']= $client->id;
		}
		else{
			$empty_client_error= ClientService::getEmptyClientError();
			$result['client_error']= $empty_client_error['client_error']; 
			foreach ($client->getErrors() as $key => $error_array) {
				$result['client_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Update Client has some errors';
			$result['error_array']= $client->getErrors();
		}
		
		return $result;
	}
	
	public static function delete($data){
		$result= array();
		$email_template= EmailTemplate::model()->findByPk((int)$data['id']);
		if($email_template->delete()){
			$email_template_files= EmailTemplateFile::model()->findAllByAttributes(array('email_template_id'=> $email_template->id));
			if(count($email_template_files)>0){
				foreach ($email_template_files as $key => $email_template_file) {
					$email_template_file->delete();
				}
			}
			$result['success']= true;
		}
		else
			$result['success']= false;
		return $result;
	}
	
	
	
	public static function beforeSave($client){
		if($client->isNewRecord){
			$client->created_time= time();
		}
		$client->status= 1;
		return $client;
	}
	
	public static function convertListClient($clients, $data){
		$result= array();
		if($clients!= null && count($clients)>0){
			foreach($clients as $client){
				$result[]= self::convertClient($client);
			}
		}
		return $result;
	}
	
	public static function convertClient($client){
		$result= array(
					'id'=> $client->id,
					'name'=> $client->name,
					'address1'=> $client->address1,
					'address2'=> $client->address2,
					'company_name'=> $client->company_name,
					'contact_name'=> $client->contact_name,
					'country'=> $client->country,
					'city'=> $client->city,
					'state_id'=> $client->state_id,
					'state_name'=> isset($client->state)?$client->state->state_short:"N/A",
					'zipcode'=> $client->zipcode,
					'email'=> $client->email,
					'phone'=> $client->phone,
					'fax'=> $client->fax,
					'status'=> $client->status,
					'created_time'=> $client->created_time,
					'category_ids'=>array(),
					'tmp_file_ids'=> $client->tmp_file_ids
					);
		return $result;
	}
}
