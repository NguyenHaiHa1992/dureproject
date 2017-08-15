<?php
class UolService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_uol= UolService::getEmptyUol();
		$result['uol']= $get_empty_uol['uol'];
		$get_empty_uol_error= UolService::getEmptyUolError();
		$result['uol_error']= $get_empty_uol_error['uol_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUol(){
		$result= array();
		$uol= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['uol']= $uol;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUolError(){
		$result= array();
		$uol= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['uol_error']= $uol;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$uols= Uol::model()->findAllByAttributes(array('status'=> 1));
		if($uols!= null && count($uols)>0){
			$result['uols']= self::convertListUol($uols, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['uols']= array();
		}
		return $result;
	}
	
	public static function getUolById($data){
		$result= array();
		$get_empty_uol_error= UolService::getEmptyUolError();
		$result['uol_error']= $get_empty_uol_error['uol_error'];
		$uol= Uol::model()->findByPk($data['id']);
		if($uol){
			$result['success']= true;
			$result['uol']= self::convertUol($uol);
		}
		else{
			$result['success']= false;
			$result['message']= 'Uol \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$uol= new Uol();
		$uol->attributes= $data;
		$uol= self::beforeSave($uol);
		if($uol->validate()){
			$uol->save();
			$result['success']= true;
			$result['id']= $uol->id;
		}
		else{
			$empty_uol_error= UolService::getEmptyUolError();
			$result['uol_error']= $empty_uol_error['uol_error']; 
			foreach ($uol->getErrors() as $key => $error_array) {
				$result['uol_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Uol has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$uol= Uol::model()->findByPk((int)$data['id']);
			if($uol){
				$uol->attributes= $data;
				$uol= self::beforeSave($uol);
				if($uol->validate()){
					if($uol->save()){
						$result['success']= true;
						$result['id']= $uol->id;
						$uol_array= UolService::getUolById(array('id'=>$uol->id));
						$result['uol']= $uol_array['uol'];
						$result['message'] = 'Uol updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($uol);
					}
				}
				else{
					$empty_uol_error= UolService::getEmptyUolError();
					$result['uol_error']= $empty_uol_error['uol_error']; 
					foreach ($uol->getErrors() as $key => $error_array) {
						$result['uol_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Uol has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Uol \'s not found!';
			}
		}
		else{
			// Create new category
			$uol = new Uol();
			$uol->attributes = $data;
			if($uol->save()){
				$result['success']= true;
				$result['id']= $uol->id;
				$uol_array= UolService::getUolById(array('id'=>$uol->id));
				$result['uol']= $uol_array['uol'];
				$result['message'] = 'Uol created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($uol);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($uol){
		if($uol->isNewRecord){
			$uol->created_time= time();
		}
		$uol->status= 1;
		return $uol;
	}
	
	public static function convertListUol($uols, $data){
		$result= array();
		if($uols!= null && count($uols)>0){
			foreach($uols as $uol){
				$result[]= self::convertUol($uol);
			}
		}
		return $result;
	}
	
	public static function convertUol($uol){
		$result= array(
					'id'=> $uol->id,
					'name'=> $uol->name,
					'status'=> $uol->status,
					'created_time'=> date('d-m-Y', $uol->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeUol($data){
		$result= array();
		$uol = Uol::model()->findByPk((int)$data['id']);
		$uol->attributes= $data;

		if($uol->delete()){
			$result['success'] = true;
			$result['message'] = 'Uol deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($uol);
		}
		
		return $result;
	}
}
