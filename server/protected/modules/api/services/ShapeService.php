<?php
class ShapeService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_shape= ShapeService::getEmptyShape();
		$result['shape']= $get_empty_shape['shape'];
		$get_empty_shape_error= ShapeService::getEmptyShapeError();
		$result['shape_error']= $get_empty_shape_error['shape_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyShape(){
		$result= array();
		$shape= array(
					'id'=> '',
					'name'=> '',
					'image_id'=>'',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					'image_src'=>'',
					);
		
		$result['shape']= $shape;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyShapeError(){
		$result= array();
		$shape= array(
					'id'=> array(),
					'name'=> array(),
					'image_id'=>array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					'image_src'=>array(),
					);
		
		$result['shape_error']= $shape;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$shapes= Shape::model()->findAllByAttributes(array('status'=> 1));
		if($shapes!= null && count($shapes)>0){
			$result['shapes']= self::convertListShape($shapes, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['shapes']= array();
		}
		return $result;
	}
	
	public static function getShapeById($data){
		$result= array();
		$get_empty_shape_error= ShapeService::getEmptyShapeError();
		$result['shape_error']= $get_empty_shape_error['shape_error'];
		$shape= Shape::model()->findByPk($data['id']);
		if($shape){
			$result['success']= true;
			$result['shape']= self::convertShape($shape);
		}
		else{
			$result['success']= false;
			$result['message']= 'Shape \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$shape= new Shape();
		$shape->attributes= $data;
		$shape= self::beforeSave($shape);
		if($shape->validate()){
			$shape->save();
			$result['success']= true;
			$result['id']= $shape->id;
		}
		else{
			$empty_shape_error= ShapeService::getEmptyShapeError();
			$result['shape_error']= $empty_shape_error['shape_error']; 
			foreach ($shape->getErrors() as $key => $error_array) {
				$result['shape_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Shape has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$shape= Shape::model()->findByPk((int)$data['id']);
			if($shape){
				$shape->attributes= $data;
				$shape= self::beforeSave($shape);
				if($shape->validate()){
					if($shape->save()){
						$result['success']= true;
						$result['id']= $shape->id;
						$shape_array= ShapeService::getShapeById(array('id'=>$shape->id));
						$result['shape']= $shape_array['shape'];
						$result['message'] = 'Shape updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($shape);
					}
				}
				else{
					$empty_shape_error= ShapeService::getEmptyShapeError();
					$result['shape_error']= $empty_shape_error['shape_error']; 
					foreach ($shape->getErrors() as $key => $error_array) {
						$result['shape_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Shape has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Shape \'s not found!';
			}
		}
		else{
			// Create new category
			$shape = new Shape();
			$shape->attributes = $data;
			if($shape->save()){
				$result['success']= true;
				$result['id']= $shape->id;
				$shape_array= ShapeService::getShapeById(array('id'=>$shape->id));
				$result['shape']= $shape_array['shape'];
				$result['message'] = 'Shape created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($shape);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($shape){
		if($shape->isNewRecord){
			$shape->created_time= time();
		}
		$shape->status= 1;
		return $shape;
	}

	public static function convertListShape($shapes, $data){
		$result= array();
		if($shapes!= null && count($shapes)>0){
			foreach($shapes as $shape){
				$result[]= self::convertShape($shape);
			}
		}
		return $result;
	}
	
	public static function convertShape($shape){
		$result= array(
					'id'=> $shape->id,
					'name'=> $shape->name,
					'image_id'=> $shape->image_id,
					'image_src'=> FileService::getAbsoluteUrl($shape->image_id),
					'status'=> $shape->status,
					'created_time'=> date('d-m-Y', $shape->created_time),
					'is_edit'=>false,
					'sizes'=>$shape->sizes,
					);
		return $result;
	}

	public static function removeShape($data){
		$result= array();
		$shape = Shape::model()->findByPk((int)$data['id']);
		$shape->attributes= $data;

		if($shape->delete()){
			$result['success'] = true;
			$result['message'] = 'Shape deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($shape);
		}
		
		return $result;
	}
}
