<?php
class OperationService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_operation= OperationService::getEmptyOperation();
		$result['operation']= $get_empty_operation['operation'];
		$get_empty_operation_error= OperationService::getEmptyOperationError();
		$result['operation_error']= $get_empty_operation_error['operation_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyOperation(){
		$result= array();
		$operation= array(
					'id'=> '',
					'category_id'=>'',
					'category_name'=>'',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['operation']= $operation;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyOperationError(){
		$result= array();
		$operation= array(
					'id'=> array(),
					'category_id'=> array(),
					'category_name'=>array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['operation_error']= $operation;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$operations= Operation::model()->findAllByAttributes(array('status'=> 1));
		if($operations!= null && count($operations)>0){
			$result['operations']= self::convertListOperation($operations, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['operations']= array();
		}
		return $result;
	}
	
	public static function getOperationById($data){
		$result= array();
		$get_empty_operation_error= OperationService::getEmptyOperationError();
		$result['operation_error']= $get_empty_operation_error['operation_error'];
		$operation= Operation::model()->findByPk($data['id']);
		if($operation){
			$result['success']= true;
			$result['operation']= self::convertOperation($operation);
		}
		else{
			$result['success']= false;
			$result['message']= 'Operation \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$operation= new Operation();
		$operation->attributes= $data;
		$operation= self::beforeSave($operation);
		if($operation->validate()){
			$operation->save();
			$result['success']= true;
			$result['id']= $operation->id;
		}
		else{
			$empty_operation_error= OperationService::getEmptyOperationError();
			$result['operation_error']= $empty_operation_error['operation_error']; 
			foreach ($operation->getErrors() as $key => $error_array) {
				$result['operation_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Operation has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$operation= Operation::model()->findByPk((int)$data['id']);
			if($operation){
				$operation->attributes= $data;
				$operation= self::beforeSave($operation);
				if($operation->validate()){
					if($operation->save()){
						$result['success']= true;
						$result['id']= $operation->id;
						$operation_array= OperationService::getOperationById(array('id'=>$operation->id));
						$result['operation']= $operation_array['operation'];
						$result['message'] = 'Operation updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($operation);
					}
				}
				else{
					$empty_operation_error= OperationService::getEmptyOperationError();
					$result['operation_error']= $empty_operation_error['operation_error']; 
					foreach ($operation->getErrors() as $key => $error_array) {
						$result['operation_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Operation has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Operation \'s not found!';
			}
		}
		else{
			// Create new category
			$operation = new Operation();
			$operation->attributes = $data;
			if($operation->save()){
				$result['success']= true;
				$result['id']= $operation->id;
				$operation_array= OperationService::getOperationById(array('id'=>$operation->id));
				$result['operation']= $operation_array['operation'];
				$result['message'] = 'Operation created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($operation);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($operation){
		if($operation->isNewRecord){
			$operation->created_time= time();
		}
		$operation->status= 1;
		return $operation;
	}
	
	public static function convertListOperation($operations, $data){
		$result= array();
		if($operations!= null && count($operations)>0){
			foreach($operations as $operation){
				$result[]= self::convertOperation($operation);
			}
		}
		return $result;
	}
	
	public static function convertOperation($operation){
		$result= array(
					'id'=> $operation->id,
					'category_id'=> $operation->category_id,
					'name'=> $operation->name,
					'status'=> $operation->status,
					'created_time'=> date('d-m-Y', $operation->created_time),
					'is_edit'=>false,
					'category'=>isset($operation->category)?OperationCategoryService::convertOperationCategory($operation->category):array(),
					);
		return $result;
	}

	public static function removeOperation($data){
		$result= array();
		$operation = Operation::model()->findByPk((int)$data['id']);
		$operation->attributes= $data;

		if($operation->delete()){
			$result['success'] = true;
			$result['message'] = 'Operation deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($operation);
		}
		
		return $result;
	}
}
