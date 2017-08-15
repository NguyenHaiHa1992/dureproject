<?php
class FixtureCategoryService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_fixture_category= FixtureCategoryService::getEmptyFixtureCategory();
		$result['fixture_category']= $get_empty_fixture_category['fixture_category'];
		$get_empty_fixture_category_error= FixtureCategoryService::getEmptyFixtureCategoryError();
		$result['fixture_category_error']= $get_empty_fixture_category_error['fixture_category_error'];
		$result['success']= true;
		return $result;
	}

	public static function getEmptyFixtureCategory(){
		$result= array();
		$fixture_category= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);

		$result['fixture_category']= $fixture_category;
		$result['success']= true;
		return $result;
	}

	public static function getEmptyFixtureCategoryError(){
		$result= array();
		$fixture_category= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);

		$result['fixture_category_error']= $fixture_category;
		$result['success']= true;
		return $result;
	}

	public static function getAll($data){
		$result= array();
		$fixture_categories= FixtureCategory::model()->findAllByAttributes(array('status'=> 1));
		if($fixture_categories!= null && count($fixture_categories)>0){
			$result['fixture_categories']= self::convertListFixtureCategory($fixture_categories, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['fixture_categories']= array();
		}
		return $result;
	}

	public static function getFixtureCategoryById($data){
		$result= array();
		$get_empty_fixture_category_error= FixtureCategoryService::getEmptyFixtureCategoryError();
		$result['fixture_category_error']= $get_empty_fixture_category_error['fixture_category_error'];
		$fixture_category= FixtureCategory::model()->findByPk($data['id']);
		if($fixture_category){
			$result['success']= true;
			$result['fixture_category']= self::convertFixtureCategory($fixture_category);
		}
		else{
			$result['success']= false;
			$result['message']= 'Category \'s not found!';
		}
		return $result;
	}

	public static function create($data){
		$result= array();

		$fixture_category= new FixtureCategory();
		$fixture_category->attributes= $data;
		$fixture_category= self::beforeSave($fixture_category);
		if($fixture_category->validate()){
			$fixture_category->save();
			$result['success']= true;
			$result['id']= $fixture_category->id;
		}
		else{
			$empty_fixture_category_error= FixtureCategoryService::getEmptyFixtureCategoryError();
			$result['fixture_category_error']= $empty_fixture_category_error['fixture_category_error'];
			foreach ($fixture_category->getErrors() as $key => $error_array) {
				$result['fixture_category_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating fixture has some errors';
		}
		return $result;
	}

	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$fixture_category= FixtureCategory::model()->findByPk((int)$data['id']);
                        if($fixture_category){
				$fixture_category->attributes= $data;
				$fixture_category= self::beforeSave($fixture_category);
				if($fixture_category->validate()){
					if($fixture_category->save()){
						$result['success']= true;
						$result['id']= $fixture_category->id;
						$fixture_category_array= FixtureCategoryService::getFixtureCategoryById(array('id'=>$fixture_category->id));
						$result['fixture_category']= $fixture_category_array['fixture_category'];
						$result['message'] = 'Fixture category updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($fixture_category);
					}
				}
				else{
					$empty_fixture_category_error= FixtureCategoryService::getEmptyFixtureCategoryError();
					$result['fixture_category_error']= $empty_fixture_category_error['fixture_category_error'];
					foreach ($fixture_category->getErrors() as $key => $error_array) {
						$result['fixture_category_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update fixture category has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Category \'s not found!';
			}
		}
		else{
			// Create new category
			$fixture_category = new FixtureCategory();
			$fixture_category->attributes = $data;
			if($fixture_category->save()){
				$result['success']= true;
				$result['id']= $fixture_category->id;
				$fixture_category_array= FixtureCategoryService::getFixtureCategoryById(array('id'=>$fixture_category->id));
				$result['fixture_category']= $fixture_category_array['fixture_category'];
				$result['message'] = 'Fixture category created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($fixture_category);
			}
		}

		return $result;
	}

	public static function beforeSave($fixture_category){
		if($fixture_category->isNewRecord){
			$fixture_category->created_time= time();
		}
		$fixture_category->status= 1;
		return $fixture_category;
	}

	public static function convertListFixtureCategory($fixture_categories, $data){
		$result= array();
		if($fixture_categories!= null && count($fixture_categories)>0){
			foreach($fixture_categories as $fixture_category){
				$result[]= self::convertFixtureCategory($fixture_category);
			}
		}
		return $result;
	}

	public static function convertFixtureCategory($fixture_category){
            $result= array(
                'id'=> $fixture_category->id,
                'name'=> $fixture_category->name,
                'general_id' => $fixture_category->general_id,
                'general_name' => $fixture_category->general ? $fixture_category->general->name : "",
                'status'=> $fixture_category->status,
                'created_time_converted'=> date('d-m-Y', $fixture_category->created_time),
                'is_edit'=>false,
            );

            return $result;
	}

	public static function removeFixtureCategory($data){
		$result= array();
		$fixture_category = FixtureCategory::model()->findByPk((int)$data['id']);
		$fixture_category->attributes= $data;

		if($fixture_category->delete()){
			$result['success'] = true;
			$result['message'] = 'Fixture category deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($fixture_category);
		}

		return $result;
	}
}
