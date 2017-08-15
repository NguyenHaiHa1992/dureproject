<?php
class UomService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_uom= UomService::getEmptyUom();
		$result['uom']= $get_empty_uom['uom'];
		$get_empty_uom_error= UomService::getEmptyUomError();
		$result['uom_error']= $get_empty_uom_error['uom_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUom(){
		$result= array();
		$uom= array(
					'id'=> '',
					'name'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['uom']= $uom;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyUomError(){
		$result= array();
		$uom= array(
					'id'=> array(),
					'name'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['uom_error']= $uom;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$uoms= Uom::model()->findAllByAttributes(array('status'=> 1));
		if($uoms!= null && count($uoms)>0){
			$result['uoms']= self::convertListUom($uoms, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['uoms']= array();
		}
		return $result;
	}
	
	public static function getUomById($data){
		$result= array();
		$get_empty_uom_error= UomService::getEmptyUomError();
		$result['uom_error']= $get_empty_uom_error['uom_error'];
		$uom= Uom::model()->findByPk($data['id']);
		if($uom){
			$result['success']= true;
			$result['uom']= self::convertUom($uom);
		}
		else{
			$result['success']= false;
			$result['message']= 'Uom \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$uom= new Uom();
		$uom->attributes= $data;
		$uom= self::beforeSave($uom);
		if($uom->validate()){
			$uom->save();
			$result['success']= true;
			$result['id']= $uom->id;
		}
		else{
			$empty_uom_error= UomService::getEmptyUomError();
			$result['uom_error']= $empty_uom_error['uom_error']; 
			foreach ($uom->getErrors() as $key => $error_array) {
				$result['uom_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Uom has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$uom= Uom::model()->findByPk((int)$data['id']);
			if($uom){
				$uom->attributes= $data;
				$uom= self::beforeSave($uom);
				if($uom->validate()){
					if($uom->save()){
						$result['success']= true;
						$result['id']= $uom->id;
						$uom_array= UomService::getUomById(array('id'=>$uom->id));
						$result['uom']= $uom_array['uom'];
						$result['message'] = 'Uom updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($uom);
					}
				}
				else{
					$empty_uom_error= UomService::getEmptyUomError();
					$result['uom_error']= $empty_uom_error['uom_error']; 
					foreach ($uom->getErrors() as $key => $error_array) {
						$result['uom_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Uom has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Uom \'s not found!';
			}
		}
		else{
			// Create new category
			$uom = new Uom();
			$uom->attributes = $data;
			if($uom->save()){
				$result['success']= true;
				$result['id']= $uom->id;
				$uom_array= UomService::getUomById(array('id'=>$uom->id));
				$result['uom']= $uom_array['uom'];
				$result['message'] = 'Uom created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($uom);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($uom){
		if($uom->isNewRecord){
			$uom->created_time= time();
		}
		$uom->status= 1;
		return $uom;
	}
	
	public static function convertListUom($uoms, $data){
		$result= array();
		if($uoms!= null && count($uoms)>0){
			foreach($uoms as $uom){
				$result[]= self::convertUom($uom);
			}
		}
		return $result;
	}
	
	public static function convertUom($uom){
		$result= array(
					'id'=> $uom->id,
					'name'=> $uom->name,
					'status'=> $uom->status,
					'created_time'=> date('d-m-Y', $uom->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeUom($data){
		$result= array();
		$uom = Uom::model()->findByPk((int)$data['id']);
		$uom->attributes= $data;

		if($uom->delete()){
			$result['success'] = true;
			$result['message'] = 'Uom deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($uom);
		}
		
		return $result;
	}
}
