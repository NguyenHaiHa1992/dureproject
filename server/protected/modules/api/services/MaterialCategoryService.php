<?php
class MaterialCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_material_category= MaterialCategoryService::getEmptyMaterialCategory();
		$result['material_category']= $get_empty_material_category['material_category'];
		$get_empty_material_category_error= MaterialCategoryService::getEmptyMaterialCategoryError();
		$result['material_category_error']= $get_empty_material_category_error['material_category_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialCategory(){
		$result= array();
		$material_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['material_category']= $material_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialCategoryError(){
		$result= array();
		$material_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['material_category_error']= $material_category;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$material_categories= MaterialCategory::model()->findAllByAttributes(array('status'=> 1));
		if($material_categories!= null && count($material_categories)>0){
			$result['material_categories']= self::convertListMaterialCategory($material_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['material_categories']= array();
		}
		return $result;
	}
	
	public static function getMaterialCategoryById($data){
		$result= array();
		$get_empty_material_category_error= MaterialCategoryService::getEmptyMaterialCategoryError();
		$result['material_category_error']= $get_empty_material_category_error['material_category_error'];
		$material_category= MaterialCategory::model()->findByPk($data['id']);
		if($material_category){
			$result['success']= true;
			$result['material_category']= self::convertMaterialCategory($material_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$material_category= new MaterialCategory();
		$material_category->attributes= $data;
		$material_category= self::beforeSave($material_category);
		if($material_category->validate()){
			$material_category->save();
			$result['success']= true;
			$result['id']= $material_category->id;
		}
		else{
			$empty_material_category_error= MaterialCategoryService::getEmptyMaterialCategoryError();
			$result['material_category_error']= $empty_material_category_error['material_category_error']; 
			foreach ($material_category->getErrors() as $key => $error_array) {
				$result['material_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Material has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$material_category= MaterialCategory::model()->findByPk((int)$data['id']);
			if($material_category){
				$material_category->attributes= $data;
				$material_category= self::beforeSave($material_category);
				if($material_category->validate()){
					if($material_category->save()){
						$result['success']= true;
						$result['id']= $material_category->id;
						$material_category_array= MaterialCategoryService::getMaterialCategoryById(array('id'=>$material_category->id));
						$result['material_category']= $material_category_array['material_category'];
						$result['message'] = 'Material category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($material_category);
					}
				}
				else{
					$empty_material_category_error= MaterialCategoryService::getEmptyMaterialCategoryError();
					$result['material_category_error']= $empty_material_category_error['material_category_error']; 
					foreach ($material_category->getErrors() as $key => $error_array) {
						$result['material_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Material category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$material_category = new MaterialCategory();
			$material_category->attributes = $data;
			if($material_category->save()){
				$result['success']= true;
				$result['id']= $material_category->id;
				$material_category_array= MaterialCategoryService::getMaterialCategoryById(array('id'=>$material_category->id));
				$result['material_category']= $material_category_array['material_category'];
				$result['message'] = 'Material category updated!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($material_category);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($material_category){
		if($material_category->isNewRecord){
			$material_category->created_time= time();
		}
		$material_category->status= 1;
		return $material_category;
	}
	
	public static function convertListMaterialCategory($material_categories, $data){
		$result= array();
		if($material_categories!= null && count($material_categories)>0){
			foreach($material_categories as $material_category){
				$result[]= self::convertMaterialCategory($material_category);
			}
		}
		return $result;
	}
	
	public static function convertMaterialCategory($material_category){
		$result= array(
					'id'=> $material_category->id,
					'name'=> $material_category->name,
					'status'=> $material_category->status,
					'created_time'=> date('d-m-Y', $material_category->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeMaterialCategory($data){
		$result= array();
		$material_category = MaterialCategory::model()->findByPk((int)$data['id']);
		$material_category->attributes= $data;

		if($material_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Material category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($material_category);
		}
		
		return $result;
	}
}
