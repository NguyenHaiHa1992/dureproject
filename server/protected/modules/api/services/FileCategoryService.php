<?php
class FileCategoryService extends iPhoenixService{	
	public static function createInit(){
		$result= array();
		$get_empty_file_category= FileCategoryService::getEmptyfileCategory();
		$result['file_category']= $get_empty_file_category['file_category'];
		$get_empty_file_category_error= FileCategoryService::getEmptyfileCategoryError();
		$result['file_category_error']= $get_empty_file_category_error['file_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyFileCategory(){
		$result= array();
		$file_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'code'=> '',
					);
		
		$result['file_category']= $file_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyFileCategoryError(){
		$result= array();
		$file_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'code'=> array(),
					);
		
		$result['file_category_error']= $file_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$file_categories= FileCategory::model()->findAllByAttributes(array('status'=> 1));
		if($file_categories!= null && count($file_categories)>0){
			$result['file_categories']= self::convertListfileCategory($file_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['file_categories']= array();
		}
		return $result;
	}
	
	public static function getFileCategoryById($data){
		$result= array();
		$get_empty_file_category_error= FileCategoryService::getEmptyfileCategoryError();
		$result['file_category_error']= $get_empty_file_category_error['file_category_error'];
		$file_category= fileCategory::model()->findByPk($data['id']);
		if($file_category){
			$result['success']= true;
			$result['file_category']= self::convertfileCategory($file_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$file_category= new FileCategory();
		$file_category->attributes= $data;
		$file_category= self::beforeSave($file_category);
		if($file_category->validate()){
			$file_category->save();
			$result['success']= true;
			$result['id']= $file_category->id;
			$result['message']= 'Category created';
		}
		else{
			$empty_file_category_error= FileCategoryService::getEmptyfileCategoryError();
			$result['file_category_error']= $empty_file_category_error['file_category_error']; 
			foreach ($file_category->getErrors() as $key => $error_array) {
				$result['file_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating category has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$file_category= FileCategory::model()->findByPk((int)$data['id']);
			if($file_category){
				$file_category->attributes= $data;
				$file_category= self::beforeSave($file_category);
				if($file_category->validate()){
					$file_category->save();
					$result['success']= true;
					$result['id']= $file_category->id;
					$file_category_array= FileCategoryService::getfileCategoryById(array('id'=>$file_category->id));
					$result['file_category']= $file_category_array['file_category'];
					$result['message']= 'Category updated';
				}
				else{
					$empty_file_category_error= FileCategoryService::getEmptyfileCategoryError();
					$result['file_category_error']= $empty_file_category_error['file_category_error']; 
					foreach ($file_category->getErrors() as $key => $error_array) {
						$result['file_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update file category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			//Create new category
			$file_category = new FileCategory();
			$file_category->attributes= $data;
			$file_category= self::beforeSave($file_category);
			if($file_category->validate()){
				$file_category->save();
				$result['success']= true;
				$result['id']= $file_category->id;
				$file_category_array= FileCategoryService::getfileCategoryById(array('id'=>$file_category->id));
				$result['file_category']= $file_category_array['file_category'];
				$result['message']= 'Category updated';
			}
			else{
				$empty_file_category_error= FileCategoryService::getEmptyfileCategoryError();
				$result['file_category_error']= $empty_file_category_error['file_category_error']; 
				foreach ($file_category->getErrors() as $key => $error_array) {
					$result['file_category_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create file category has some errors';
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($file_category){
		if($file_category->isNewRecord){
			$file_category->created_time= time();
		}
		$file_category->status= 1;
		return $file_category;
	}
	
	public static function convertListfileCategory($file_categories){
		$result= array();
		if($file_categories!= null && count($file_categories)>0){
			foreach($file_categories as $file_category){
				$result[]= self::convertfileCategory($file_category);
			}
		}
		return $result;
	}
	
	public static function convertFileCategory($file_category){
		$result= array(
					'id'=> $file_category->id,
					'name'=> $file_category->name,
					'status'=> $file_category->status,
					'created_time'=> date('d-m-Y', $file_category->created_time),
					'code' => $file_category->code
					);
		return $result;
	}

	public static function removeFileCategory($data){
		$result= array();
		$file_category = FileCategory::model()->findByPk((int)$data['id']);
		$file_category->attributes= $data;

		if($file_category->delete()){
			$result['success'] = true;
			$result['message'] = 'File category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($file_category);
		}
		
		return $result;
	}
}
