<?php
class SignageCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_signage_category= SignageCategoryService::getEmptySignageCategory();
		$result['signage_category']= $get_empty_signage_category['signage_category'];
		$get_empty_signage_category_error= SignageCategoryService::getEmptySignageCategoryError();
		$result['signage_category_error']= $get_empty_signage_category_error['signage_category_error'];
		$result['success']= true;
		return $result;
	}

	public static function getEmptySignageCategory(){
		$result= array();
		$signage_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);

		$result['signage_category']= $signage_category;
		$result['success']= true;
		return $result;
	}

	public static function getEmptySignageCategoryError(){
		$result= array();
		$signage_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);

		$result['signage_category_error']= $signage_category;
		$result['success']= true;
		return $result;
	}

	public static function getAll($data){
		$result= array();
                $criteria = new CDbCriteria();
                $criteria->condition = "status = 1";
                $criteria->order = "name ASC";
		$signage_categories= SignageCategory::model()->findAll($criteria);
		if($signage_categories!= null && count($signage_categories)>0){
			$result['signage_categories']= self::convertListSignageCategory($signage_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['signage_categories']= array();
		}
		return $result;
	}

	public static function getSignageCategoryById($data){
		$result= array();
		$get_empty_signage_category_error= SignageCategoryService::getEmptySignageCategoryError();
		$result['signage_category_error']= $get_empty_signage_category_error['signage_category_error'];
		$signage_category= SignageCategory::model()->findByPk($data['id']);
		if($signage_category){
			$result['success']= true;
			$result['signage_category']= self::convertSignageCategory($signage_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}

	public static function create($data){
		$result= array();

		$signage_category= new SignageCategory();
		$signage_category->attributes= $data;
		$signage_category= self::beforeSave($signage_category);
		if($signage_category->validate()){
			$signage_category->save();
			$result['success']= true;
			$result['id']= $signage_category->id;
		}
		else{
			$empty_signage_category_error= SignageCategoryService::getEmptySignageCategoryError();
			$result['signage_category_error']= $empty_signage_category_error['signage_category_error'];
			foreach ($signage_category->getErrors() as $key => $error_array) {
				$result['signage_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating signage has some errors';
		}
		return $result;
	}

	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$signage_category= SignageCategory::model()->findByPk((int)$data['id']);
			if($signage_category){
				$signage_category->attributes= $data;
				$signage_category= self::beforeSave($signage_category);
				if($signage_category->validate()){
					if($signage_category->save()){
						$result['success']= true;
						$result['id']= $signage_category->id;
						$signage_category_array= SignageCategoryService::getSignageCategoryById(array('id'=>$signage_category->id));
						$result['signage_category']= $signage_category_array['signage_category'];
						$result['message'] = 'Signage category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($signage_category);
					}
				}
				else{
					$empty_signage_category_error= SignageCategoryService::getEmptySignageCategoryError();
					$result['signage_category_error']= $empty_signage_category_error['signage_category_error'];
					foreach ($signage_category->getErrors() as $key => $error_array) {
						$result['signage_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update signage category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$signage_category = new SignageCategory();
			$signage_category->attributes = $data;
			if($signage_category->save()){
				$result['success']= true;
				$result['id']= $signage_category->id;
				$signage_category_array= SignageCategoryService::getSignageCategoryById(array('id'=>$signage_category->id));
				$result['signage_category']= $signage_category_array['signage_category'];
				$result['message'] = 'Signage category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($signage_category);
			}
		}

		return $result;
	}

	public static function beforeSave($signage_category){
		if($signage_category->isNewRecord){
			$signage_category->created_time= time();
		}
		$signage_category->status= 1;
		return $signage_category;
	}

	public static function convertListSignageCategory($signage_categories, $data){
		$result= array();
		if($signage_categories!= null && count($signage_categories)>0){
			foreach($signage_categories as $signage_category){
				$result[]= self::convertSignageCategory($signage_category);
			}
		}
		return $result;
	}

	public static function convertSignageCategory($signage_category){
            $result= array(
                'id'=> $signage_category->id,
                'name'=> $signage_category->name,
                'general_id' => $signage_category->general_id,
                'general_name' => $signage_category->general ? $signage_category->general->name : "",
                'status'=> $signage_category->status,
                'created_time_converted'=> date('d-m-Y', $signage_category->created_time),
                'is_edit'=>false,
            );

            return $result;
	}

	public static function removeSignageCategory($data){
		$result= array();
		$signage_category = SignageCategory::model()->findByPk((int)$data['id']);
		$signage_category->attributes= $data;

		if($signage_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Signage category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($signage_category);
		}

		return $result;
	}
}
