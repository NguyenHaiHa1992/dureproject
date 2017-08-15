<?php
class UoqService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_uoq= UoqService::getEmptyUoq();
		$result['uoq']= $get_empty_uoq['uoq'];
		$get_empty_uoq_error= UoqService::getEmptyUoqError();
		$result['uoq_error']= $get_empty_uoq_error['uoq_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUoq(){
		$result= array();
		$uoq= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['uoq']= $uoq;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUoqError(){
		$result= array();
		$uoq= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['uoq_error']= $uoq;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$uoqs= Uoq::model()->findAllByAttributes(array('status'=> 1));
		if($uoqs!= null && count($uoqs)>0){
			$result['uoqs']= self::convertListUoq($uoqs, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['uoqs']= array();
		}
		return $result;
	}
	
	public static function getUoqById($data){
		$result= array();
		$get_empty_uoq_error= UoqService::getEmptyUoqError();
		$result['uoq_error']= $get_empty_uoq_error['uoq_error'];
		$uoq= Uoq::model()->findByPk($data['id']);
		if($uoq){
			$result['success']= true;
			$result['uoq']= self::convertUoq($uoq);
		}
		else{
			$result['success']= false;
			$result['message']= 'Uoq \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$uoq= new Uoq();
		$uoq->attributes= $data;
		$uoq= self::beforeSave($uoq);
		if($uoq->validate()){
			$uoq->save();
			$result['success']= true;
			$result['id']= $uoq->id;
		}
		else{
			$empty_uoq_error= UoqService::getEmptyUoqError();
			$result['uoq_error']= $empty_uoq_error['uoq_error']; 
			foreach ($uoq->getErrors() as $key => $error_array) {
				$result['uoq_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Uoq has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$uoq= Uoq::model()->findByPk((int)$data['id']);
			if($uoq){
				$uoq->attributes= $data;
				$uoq= self::beforeSave($uoq);
				if($uoq->validate()){
					if($uoq->save()){
						$result['success']= true;
						$result['id']= $uoq->id;
						$uoq_array= UoqService::getUoqById(array('id'=>$uoq->id));
						$result['uoq']= $uoq_array['uoq'];
						$result['message'] = 'Uoq updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($uoq);
					}
				}
				else{
					$empty_uoq_error= UoqService::getEmptyUoqError();
					$result['uoq_error']= $empty_uoq_error['uoq_error']; 
					foreach ($uoq->getErrors() as $key => $error_array) {
						$result['uoq_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Uoq has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Uoq \'s not found!';
			}
		}
		else{
			// Create new category
			$uoq = new Uoq();
			$uoq->attributes = $data;
			if($uoq->save()){
				$result['success']= true;
				$result['id']= $uoq->id;
				$uoq_array= UoqService::getUoqById(array('id'=>$uoq->id));
				$result['uoq']= $uoq_array['uoq'];
				$result['message'] = 'Uoq created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($uoq);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($uoq){
		if($uoq->isNewRecord){
			$uoq->created_time= time();
		}
		$uoq->status= 1;
		return $uoq;
	}
	
	public static function convertListUoq($uoqs, $data){
		$result= array();
		if($uoqs!= null && count($uoqs)>0){
			foreach($uoqs as $uoq){
				$result[]= self::convertUoq($uoq);
			}
		}
		return $result;
	}
	
	public static function convertUoq($uoq){
		$result= array(
					'id'=> $uoq->id,
					'name'=> $uoq->name,
					'status'=> $uoq->status,
					'created_time'=> date('d-m-Y', $uoq->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeUoq($data){
		$result= array();
		$uoq = Uoq::model()->findByPk((int)$data['id']);
		$uoq->attributes= $data;

		if($uoq->delete()){
			$result['success'] = true;
			$result['message'] = 'Uoq deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($uoq);
		}
		
		return $result;
	}
}
