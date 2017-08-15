<?php
class VendorService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_vendor= VendorService::getEmptyVendor();
		if(isset($data['id']) && $data['id']!= ''){
			$vendor= VendorService::getVendorById(array('id'=> $data['id']));
			if($vendor['success']== true){
				$result['vendor']= $vendor['vendor'];
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['vendor']= $get_empty_vendor['vendor'];
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['vendor']= $get_empty_vendor['vendor'];
			$result['is_update']= false;
			$result['is_create']= true;
		}
		
		$result['vendor_empty']= $get_empty_vendor['vendor'];
		$get_empty_vendor_error= VendorService::getEmptyVendorError();
		$result['vendor_error']= $get_empty_vendor_error['vendor_error'];
		$result['vendor_error_empty']= $get_empty_vendor_error['vendor_error'];

		$vendor_categories = VendorCategoryService::getAll(array());
		$result['vendor_categories'] = $vendor_categories['vendor_categories'];

		$states = StateService::getAll(array());
		$result['states'] = $states['states'];

		
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Vendor::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_vendor.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_vendor.*
			   From tbl_vendor";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['name']) && $data['name']!= ''){
			$sql= $sql."And tbl_vendor.name LIKE '%".$data['name']."%'";
		}
		if(isset($data['email']) && $data['email']!= ''){
			$sql= $sql."And tbl_vendor.email LIKE '%".$data['email']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$vendors= Vendor::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['name']) && $data['name']!= ''){
			$criteria->compare('name', $data['name'], true);
		}
		if(isset($data['email']) && $data['email']!= ''){
			$criteria->compare('email', $data['email'], true);
		}

		$total = Vendor::model()->count($criteria);
		
		if($vendors!= null){
			$result['success']= true;
			$result['vendors']=self::convertListVendor($vendors, $data);
			
			$result['totalresults']= $total;
			$result['start_vendor']= (int)$data['limitstart']+ 1;
			$result['end_vendor']= (int)$data['limitstart']+ count($vendors);
		}
		else{
			$result['success']= true;
			$result['vendors']= array();
			$result['totalresults']= $total;
			$result['start_vendor']= 0;
			$result['end_vendor']= 0;
		}
		return $result;
	}
	
	public static function getEmptyVendor(){
		$result= array();
		$vendor= array(
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
					'tmp_cat_ids'=>array(),
					'tmp_file_ids'=>'',
					);
		$result['vendor']= $vendor;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyVendorError(){
		$result= array();
		$vendor= array(
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
					'tmp_cat_ids'=> array(),
					'tmp_file_ids'=>array(),
					);
		
		$result['vendor_error']= $vendor;
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
	
	public static function getVendorById($data){
		$result= array();
		$get_empty_vendor_error= VendorService::getEmptyVendorError();
		$result['vendor_error']= $get_empty_vendor_error['vendor_error'];
		
		$vendor;
		$vendor= Vendor::model()->findByPk((int)$data['id']);
		if($vendor!= null){
			$result['success']= true;
			$result['vendor']= self::convertVendor($vendor);
		}
		else{
			$result['success']= false;
			$result['message']= 'Vendor\'s not found!';
		}
		return $result;
	}
	
	public static function getVendorsByCategoryId($data){//data['id']
		$result= array();
		$vendors= Vendor::model()->findAllByAttributes(array('category_id'=>$data['id']));
		if($vendors!= null && count($vendors)>0){
			$result['success']= true;
			$result['vendors']= self::convertListVendor($vendors, $data);
		}
		else{
			$result['success']= true;
			$result['vendors']= array();
		}
		return $result;
	}
	
	public static function getEmailTemplateByName($data){
		$result= array();
		$email_template;
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
		$vendor= new Vendor();
		$vendor->attributes= $data;
		$vendor= VendorService::beforeSave($vendor);
		if($vendor->validate()){
			$vendor->save();
			$result['success']= true;
			$result['id']= $vendor->id;
			$new_vendor= self::getVendorById(array('id'=> $vendor->id));
			$result['vendor']= $new_vendor['vendor'];
		}
		else{
			$empty_vendor_error= VendorService::getEmptyVendorError();
			$result['vendor_error']= $empty_vendor_error['vendor_error']; 
			foreach ($vendor->getErrors() as $key => $error_array) {
				$result['vendor_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Vendor has some errors';
			$result['error_array']= $vendor->getErrors();
		}
		
		return $result;
	}
	
	
	public static function update($data){
		$result= array();
		$vendor= Vendor::model()->findByPk((int)$data['id']);
		$vendor->attributes= $data;
		
		$vendor= VendorService::beforeSave($vendor);
		if($vendor->validate()){
			$vendor->save();
			$result['success']= true;
			$vendor_array= VendorService::getVendorById(array('id'=>$vendor->id));
			$get_empty_vendor_error= VendorService::getEmptyVendorError();
			$result['vendor_error']= $get_empty_vendor_error['vendor_error'];
			$result['vendor']= $vendor_array['vendor'];
			$result['id']= $vendor->id;
		}
		else{
			$empty_vendor_error= VendorService::getEmptyVendorError();
			$result['vendor_error']= $empty_vendor_error['vendor_error']; 
			foreach ($vendor->getErrors() as $key => $error_array) {
				$result['vendor_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Update Vendor has some errors';
			$result['error_array']= $vendor->getErrors();
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
	
	
	
	public static function beforeSave($vendor){
		if($vendor->isNewRecord){
			$vendor->created_time= time();
		}
		$vendor->status= 1;
		return $vendor;
	}
	
	public static function convertListVendor($vendors, $data){
		$result= array();
		if($vendors!= null && count($vendors)>0){
			foreach($vendors as $vendor){
				$result[]= self::convertVendor($vendor);
			}
		}
		return $result;
	}
	
	public static function convertVendor($vendor){
		$result= array(
					'id'=> $vendor->id,
					'name'=> $vendor->name,
					'address1'=> $vendor->address1,
					'address2'=> $vendor->address2,
					'company_name'=> $vendor->company_name,
					'contact_name'=> $vendor->contact_name,
					'country'=> $vendor->country,
					'city'=> $vendor->city,
					'state_id'=> $vendor->state_id,
					'zipcode'=> $vendor->zipcode,
					'email'=> $vendor->email,
					'phone'=> $vendor->phone,
					'fax'=> $vendor->fax,
					'status'=> $vendor->status,
					'created_time'=> $vendor->created_time,
					'tmp_file_ids'=> $vendor->tmp_file_ids,
					'tmp_cat_ids'=> $vendor->tmp_cat_ids,
				);

		return $result;
	}
}
