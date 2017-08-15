<?php
class VendorCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_vendor_category= VendorCategoryService::getEmptyVendorCategory();
		$result['vendor_category']= $get_empty_vendor_category['vendor_category'];
		$get_empty_vendor_category_error= VendorCategoryService::getEmptyVendorCategoryError();
		$result['vendor_category_error']= $get_empty_vendor_category_error['vendor_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyVendorCategory(){
		$result= array();
		$vendor_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['vendor_category']= $vendor_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyVendorCategoryError(){
		$result= array();
		$vendor_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['vendor_category_error']= $vendor_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$vendor_categories= VendorCategory::model()->findAllByAttributes(array('status'=> 1));
		if($vendor_categories!= null && count($vendor_categories)>0){
			$result['vendor_categories']= self::convertListVendorCategory($vendor_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['vendor_categories']= array();
		}
		return $result;
	}
	
	public static function getVendorCategoryById($data){
		$result= array();
		$get_empty_vendor_category_error= VendorCategoryService::getEmptyVendorCategoryError();
		$result['vendor_category_error']= $get_empty_vendor_category_error['vendor_category_error'];
		$vendor_category= VendorCategory::model()->findByPk($data['id']);
		if($vendor_category){
			$result['success']= true;
			$result['vendor_category']= self::convertVendorCategory($vendor_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$vendor_category= new VendorCategory();
		$vendor_category->attributes= $data;
		$vendor_category= self::beforeSave($vendor_category);
		if($vendor_category->validate()){
			$vendor_category->save();
			$result['success']= true;
			$result['id']= $vendor_category->id;
		}
		else{
			$empty_vendor_category_error= VendorCategoryService::getEmptyVendorCategoryError();
			$result['vendor_category_error']= $empty_vendor_category_error['vendor_category_error']; 
			foreach ($vendor_category->getErrors() as $key => $error_array) {
				$result['vendor_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating vendor has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$vendor_category= VendorCategory::model()->findByPk((int)$data['id']);
			if($vendor_category){
				$vendor_category->attributes= $data;
				$vendor_category= self::beforeSave($vendor_category);
				if($vendor_category->validate()){
					if($vendor_category->save()){
						$result['success']= true;
						$result['id']= $vendor_category->id;
						$vendor_category_array= VendorCategoryService::getVendorCategoryById(array('id'=>$vendor_category->id));
						$result['vendor_category']= $vendor_category_array['vendor_category'];
						$result['message'] = 'Vendor category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($vendor_category);
					}
				}
				else{
					$empty_vendor_category_error= VendorCategoryService::getEmptyVendorCategoryError();
					$result['vendor_category_error']= $empty_vendor_category_error['vendor_category_error']; 
					foreach ($vendor_category->getErrors() as $key => $error_array) {
						$result['vendor_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update vendor category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$vendor_category = new VendorCategory();
			$vendor_category->attributes = $data;
			if($vendor_category->save()){
				$result['success']= true;
				$result['id']= $vendor_category->id;
				$vendor_category_array= VendorCategoryService::getVendorCategoryById(array('id'=>$vendor_category->id));
				$result['vendor_category']= $vendor_category_array['vendor_category'];
				$result['message'] = 'Vendor category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($vendor_category);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($vendor_category){
		if($vendor_category->isNewRecord){
			$vendor_category->created_time= time();
		}
		$vendor_category->status= 1;
		return $vendor_category;
	}
	
	public static function convertListVendorCategory($vendor_categories, $data){
		$result= array();
		if($vendor_categories!= null && count($vendor_categories)>0){
			foreach($vendor_categories as $vendor_category){
				$result[]= self::convertVendorCategory($vendor_category);
			}
		}
		return $result;
	}
	
	public static function convertVendorCategory($vendor_category){
		$result= array(
					'id'=> $vendor_category->id,
					'name'=> $vendor_category->name,
					'status'=> $vendor_category->status,
					'created_time'=> date('d-m-Y', $vendor_category->created_time),
					'is_edit'=>false,
					);

		return $result;
	}

	public static function removeVendorCategory($data){
		$result= array();
		$vendor_category = VendorCategory::model()->findByPk((int)$data['id']);
		$vendor_category->attributes= $data;

		if($vendor_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Vendor category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($vendor_category);
		}
		
		return $result;
	}
}
