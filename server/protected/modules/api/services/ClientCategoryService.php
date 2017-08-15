<?php
class ClientCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_client_category= ClientCategoryService::getEmptyClientCategory();
		$result['client_category']= $get_empty_client_category['client_category'];
		$get_empty_client_category_error= ClientCategoryService::getEmptyClientCategoryError();
		$result['client_category_error']= $get_empty_client_category_error['client_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyClientCategory(){
		$result= array();
		$client_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['client_category']= $client_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyClientCategoryError(){
		$result= array();
		$client_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['client_category_error']= $client_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$client_categories= ClientCategory::model()->findAllByAttributes(array('status'=> 1));
		if($client_categories!= null && count($client_categories)>0){
			$result['client_categories']= self::convertListClientCategory($client_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['client_categories']= array();
		}
		return $result;
	}
	
	public static function getClientCategoryById($data){
		$result= array();
		$get_empty_client_category_error= ClientCategoryService::getEmptyClientCategoryError();
		$result['client_category_error']= $get_empty_client_category_error['client_category_error'];
		$client_category= ClientCategory::model()->findByPk($data['id']);
		if($client_category){
			$result['success']= true;
			$result['client_category']= self::convertClientCategory($client_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$client_category= new ClientCategory();
		$client_category->attributes= $data;
		$client_category= self::beforeSave($client_category);
		if($client_category->validate()){
			$client_category->save();
			$result['success']= true;
			$result['id']= $client_category->id;
		}
		else{
			$empty_client_category_error= ClientCategoryService::getEmptyClientCategoryError();
			$result['client_category_error']= $empty_client_category_error['client_category_error']; 
			foreach ($client_category->getErrors() as $key => $error_array) {
				$result['client_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating client has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$client_category= ClientCategory::model()->findByPk((int)$data['id']);
			if($client_category){
				$client_category->attributes= $data;
				$client_category= self::beforeSave($client_category);
				if($client_category->validate()){
					if($client_category->save()){
						$result['success']= true;
						$result['id']= $client_category->id;
						$client_category_array= ClientCategoryService::getClientCategoryById(array('id'=>$client_category->id));
						$result['client_category']= $client_category_array['client_category'];
						$result['message'] = 'Client category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($client_category);
					}
				}
				else{
					$empty_client_category_error= ClientCategoryService::getEmptyClientCategoryError();
					$result['client_category_error']= $empty_client_category_error['client_category_error']; 
					foreach ($client_category->getErrors() as $key => $error_array) {
						$result['client_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update client category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$client_category = new ClientCategory();
			$client_category->attributes = $data;
			if($client_category->save()){
				$result['success']= true;
				$result['id']= $client_category->id;
				$client_category_array= ClientCategoryService::getClientCategoryById(array('id'=>$client_category->id));
				$result['client_category']= $client_category_array['client_category'];
				$result['message'] = 'Client category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($client_category);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($client_category){
		if($client_category->isNewRecord){
			$client_category->created_time= time();
		}
		$client_category->status= 1;
		return $client_category;
	}
	
	public static function convertListClientCategory($client_categories, $data){
		$result= array();
		if($client_categories!= null && count($client_categories)>0){
			foreach($client_categories as $client_category){
				$result[]= self::convertClientCategory($client_category);
			}
		}
		return $result;
	}
	
	public static function convertClientCategory($client_category){
		$result= array(
					'id'=> $client_category->id,
					'name'=> $client_category->name,
					'status'=> $client_category->status,
					'created_time'=> date('d-m-Y', $client_category->created_time),
					'is_edit'=>false,
					);

		return $result;
	}

	public static function removeClientCategory($data){
		$result= array();
		$client_category = ClientCategory::model()->findByPk((int)$data['id']);
		$client_category->attributes= $data;

		if($client_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Client category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($client_category);
		}
		
		return $result;
	}
}
