<?php
class OperationCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_operation_category= OperationCategoryService::getEmptyOperationCategory();
		$result['operation_category']= $get_empty_operation_category['operation_category'];
		$get_empty_operation_category_error= OperationCategoryService::getEmptyOperationCategoryError();
		$result['operation_category_error']= $get_empty_operation_category_error['operation_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyOperationCategory(){
		$result= array();
		$operation_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['operation_category']= $operation_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyOperationCategoryError(){
		$result= array();
		$operation_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['operation_category_error']= $operation_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$operation_categories= OperationCategory::model()->findAllByAttributes(array('status'=> 1));
		if($operation_categories!= null && count($operation_categories)>0){
			$result['operation_categories']= self::convertListOperationCategory($operation_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['operation_categories']= array();
		}
		return $result;
	}
	
	public static function getOperationCategoryById($data){
		$result= array();
		$get_empty_operation_category_error= OperationCategoryService::getEmptyOperationCategoryError();
		$result['operation_category_error']= $get_empty_operation_category_error['operation_category_error'];
		$operation_category= OperationCategory::model()->findByPk($data['id']);
		if($operation_category){
			$result['success']= true;
			$result['operation_category']= self::convertOperationCategory($operation_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$operation_category= new OperationCategory();
		$operation_category->attributes= $data;
		$operation_category= self::beforeSave($operation_category);
		if($operation_category->validate()){
			$operation_category->save();
			$result['success']= true;
			$result['id']= $operation_category->id;
		}
		else{
			$empty_operation_category_error= OperationCategoryService::getEmptyOperationCategoryError();
			$result['operation_category_error']= $empty_operation_category_error['operation_category_error']; 
			foreach ($operation_category->getErrors() as $key => $error_array) {
				$result['operation_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating operation has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$operation_category= OperationCategory::model()->findByPk((int)$data['id']);
			if($operation_category){
				$operation_category->attributes= $data;
				$operation_category= self::beforeSave($operation_category);
				if($operation_category->validate()){
					if($operation_category->save()){
						$result['success']= true;
						$result['id']= $operation_category->id;
						$operation_category_array= OperationCategoryService::getOperationCategoryById(array('id'=>$operation_category->id));
						$result['operation_category']= $operation_category_array['operation_category'];
						$result['message'] = 'Operation category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($operation_category);
					}
				}
				else{
					$empty_operation_category_error= OperationCategoryService::getEmptyOperationCategoryError();
					$result['operation_category_error']= $empty_operation_category_error['operation_category_error']; 
					foreach ($operation_category->getErrors() as $key => $error_array) {
						$result['operation_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update operation category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$operation_category = new OperationCategory();
			$operation_category->attributes = $data;
			if($operation_category->save()){
				$result['success']= true;
				$result['id']= $operation_category->id;
				$operation_category_array= OperationCategoryService::getOperationCategoryById(array('id'=>$operation_category->id));
				$result['operation_category']= $operation_category_array['operation_category'];
				$result['message'] = 'Operation category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($operation_category);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($operation_category){
		if($operation_category->isNewRecord){
			$operation_category->created_time= time();
		}
		$operation_category->status= 1;
		return $operation_category;
	}
	
	public static function convertListOperationCategory($operation_categories, $data){
		$result= array();
		if($operation_categories!= null && count($operation_categories)>0){
			foreach($operation_categories as $operation_category){
				$result[]= self::convertOperationCategory($operation_category);
			}
		}
		return $result;
	}
	
	public static function convertOperationCategory($operation_category){
		$result= array(
					'id'=> $operation_category->id,
					'name'=> $operation_category->name,
					'status'=> $operation_category->status,
					'created_time'=> date('d-m-Y', $operation_category->created_time),
					'is_edit'=>false,
					);

		return $result;
	}

	public static function removeOperationCategory($data){
		$result= array();
		$operation_category = OperationCategory::model()->findByPk((int)$data['id']);
		$operation_category->attributes= $data;

		if($operation_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Operation category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($operation_category);
		}
		
		return $result;
	}
}
