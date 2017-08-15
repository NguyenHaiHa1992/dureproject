<?php
class PartCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_part_category= PartCategoryService::getEmptyPartCategory();
		$result['part_category']= $get_empty_part_category['part_category'];
		$get_empty_part_category_error= PartCategoryService::getEmptyPartCategoryError();
		$result['part_category_error']= $get_empty_part_category_error['part_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartCategory(){
		$result= array();
		$part_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['part_category']= $part_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartCategoryError(){
		$result= array();
		$part_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['part_category_error']= $part_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$part_categories= PartCategory::model()->findAllByAttributes(array('status'=> 1));
		if($part_categories!= null && count($part_categories)>0){
			$result['part_categories']= self::convertListPartCategory($part_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['part_categories']= array();
		}
		return $result;
	}
	
	public static function getPartCategoryById($data){
		$result= array();
		$get_empty_part_category_error= PartCategoryService::getEmptyPartCategoryError();
		$result['part_category_error']= $get_empty_part_category_error['part_category_error'];
		$part_category= PartCategory::model()->findByPk($data['id']);
		if($part_category){
			$result['success']= true;
			$result['part_category']= self::convertPartCategory($part_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$part_category= new PartCategory();
		$part_category->attributes= $data;
		$part_category= self::beforeSave($part_category);
		if($part_category->validate()){
			$part_category->save();
			$result['success']= true;
			$result['id']= $part_category->id;
		}
		else{
			$empty_part_category_error= PartCategoryService::getEmptyPartCategoryError();
			$result['part_category_error']= $empty_part_category_error['part_category_error']; 
			foreach ($part_category->getErrors() as $key => $error_array) {
				$result['part_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating part has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$part_category= PartCategory::model()->findByPk((int)$data['id']);
			if($part_category){
				$part_category->attributes= $data;
				$part_category= self::beforeSave($part_category);
				if($part_category->validate()){
					if($part_category->save()){
						$result['success']= true;
						$result['id']= $part_category->id;
						$part_category_array= PartCategoryService::getPartCategoryById(array('id'=>$part_category->id));
						$result['part_category']= $part_category_array['part_category'];
						$result['message'] = 'Part category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($part_category);
					}
				}
				else{
					$empty_part_category_error= PartCategoryService::getEmptyPartCategoryError();
					$result['part_category_error']= $empty_part_category_error['part_category_error']; 
					foreach ($part_category->getErrors() as $key => $error_array) {
						$result['part_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update part category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$part_category = new PartCategory();
			$part_category->attributes = $data;
			if($part_category->save()){
				$result['success']= true;
				$result['id']= $part_category->id;
				$part_category_array= PartCategoryService::getPartCategoryById(array('id'=>$part_category->id));
				$result['part_category']= $part_category_array['part_category'];
				$result['message'] = 'Part category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($part_category);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($part_category){
		if($part_category->isNewRecord){
			$part_category->created_time= time();
		}
		$part_category->status= 1;
		return $part_category;
	}
	
	public static function convertListPartCategory($part_categories, $data){
		$result= array();
		if($part_categories!= null && count($part_categories)>0){
			foreach($part_categories as $part_category){
				$result[]= self::convertPartCategory($part_category);
			}
		}
		return $result;
	}
	
	public static function convertPartCategory($part_category){
		$result= array(
					'id'=> $part_category->id,
					'name'=> $part_category->name,
					'status'=> $part_category->status,
					'created_time'=> date('d-m-Y', $part_category->created_time),
					'is_edit'=>false,
					);
		$is_enough_inventory= 'true';
		$parts= Part::model()->findAllByAttributes(array('category_id'=> $part_category->id));
		if($parts!= null && count($parts)>0){
			foreach ($parts as $part) {
				if($part->inventory_on_hand< $part->optimum_inventory)
					$is_enough_inventory= 'false';
			}
		}
		$result['is_enough_inventory']= $is_enough_inventory;
		return $result;
	}

	public static function removePartCategory($data){
		$result= array();
		$part_category = PartCategory::model()->findByPk((int)$data['id']);
		$part_category->attributes= $data;

		if($part_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Part category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($part_category);
		}
		
		return $result;
	}
}
