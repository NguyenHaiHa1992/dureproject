<?php
class MaterialCodeService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_material_code= MaterialCodeService::getEmptyMaterialCode();
		$result['material_code']= $get_empty_material_code['material_code'];
		$get_empty_material_code_error= MaterialCodeService::getEmptyMaterialCodeError();
		$result['material_code_error']= $get_empty_material_code_error['material_code_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialCode(){
		$result= array();
		$material_code= array(
					'id'=> '',
					'code'=> '',
					'description'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['material_code']= $material_code;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialCodeError(){
		$result= array();
		$material_code= array(
					'id'=> array(),
					'code'=> array(),
					'description'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['material_code_error']= $material_code;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= MaterialCode::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'id';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_material_code.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_material_code.*
			   From tbl_material_code";
		$sql= $sql."
			   		Where 1 ";
		if(isset($data['code']) && $data['code']!= ''){
			$sql= $sql."And tbl_material_code.code LIKE '%".$data['code']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$material_codes = MaterialCode::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', true);
		if(isset($data['code']) && $data['code']!= ''){
			$criteria->compare('code', $data['code'], true);
		}

		$total = MaterialCode::model()->count($criteria);

		if($material_codes!= null){
			$result['success']= true;
			$result['material_codes']=self::convertListMaterialCode($material_codes, $data);
			$result['totalresults']= $total;
			$result['start_material']= (int)$data['limitstart']+ 1;
			$result['end_material']= (int)$data['limitstart']+ count($material_codes);
		}
		else{
			$result['success']= true;
			$result['material_codes']= array();
			$result['totalresults']= $total;
			$result['start_material']= 0;
			$result['end_material']= 0;
		}

		return $result;
	}
	
	public static function getMaterialCodeById($data){
		$result= array();
		$get_empty_material_code_error= MaterialCodeService::getEmptyMaterialCodeError();
		$result['material_code_error']= $get_empty_material_code_error['material_code_error'];
		$material_code= MaterialCode::model()->findByPk($data['id']);
		if($material_code){
			$result['success']= true;
			$result['material_code']= self::convertMaterialCode($material_code);
		}
		else{
			$result['success']= false;
			$result['message']= 'MaterialCode \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$material_code= new MaterialCode();
		$material_code->attributes= $data;
		$material_code= self::beforeSave($material_code);
		if($material_code->validate()){
			$material_code->save();
			$result['success']= true;
			$result['id']= $material_code->id;
		}
		else{
			$empty_material_code_error= MaterialCodeService::getEmptyMaterialCodeError();
			$result['material_code_error']= $empty_material_code_error['material_code_error']; 
			foreach ($material_code->getErrors() as $key => $error_array) {
				$result['material_code_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating MaterialCode has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$material_code= MaterialCode::model()->findByPk((int)$data['id']);
			if($material_code){
				// Check change code or not
				if($material_code->code != $data['code']){
					// Check before save
					$criteria = new CDbCriteria();
					$criteria->compare('material_code_id', $data['id']);
					$material = Material::model()->find($criteria);

					if(isset($material)){
						$result['success'] = false;
						$result['message'] = 'This code is used for some material. You can not change this code since it will affect material code. You can ONLY change its description';
						return $result;
					}

				}

				$material_code->attributes= $data;
				if($material_code->save()){
					$result['success']= true;
					$result['id']= $material_code->id;
					$material_code_array= MaterialCodeService::getMaterialCodeById(array('id'=>$material_code->id));
					$result['material_code']= $material_code_array['material_code'];
					$result['message'] = 'MaterialCode updated!';
				}
				else{
					$result['success'] = false;
					$result['message'] = CHtml::errorSummary($material_code);
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'MaterialCode \'s not found!';
			}
		}
		else{
			// Create new code
			$material_code = new MaterialCode();
			$material_code->attributes = $data;
			if($material_code->save()){
				$result['success']= true;
				$result['id']= $material_code->id;
				$material_code_array= MaterialCodeService::getMaterialCodeById(array('id'=>$material_code->id));
				$result['material_code']= $material_code_array['material_code'];
				$result['message'] = 'MaterialCode created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($material_code);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($material_code){
		if($material_code->isNewRecord){
			$material_code->created_time= time();
		}
		$material_code->status= 1;
		return $material_code;
	}
	
	public static function convertListMaterialCode($material_codes, $data){
		$result= array();
		if($material_codes!= null && count($material_codes)>0){
			foreach($material_codes as $material_code){
				$result[]= self::convertMaterialCode($material_code);
			}
		}
		return $result;
	}
	
	public static function convertMaterialCode($material_code){
		$result= array(
					'id'=> $material_code->id,
					'code'=> $material_code->code,
					'description'=> $material_code->description,
					'status'=> $material_code->status,
					'created_time'=> date('d-m-Y', $material_code->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeMaterialCode($data){
		$result= array();
		$material_code = MaterialCode::model()->findByPk((int)$data['id']);
		$material_code->attributes= $data;

		if($material_code->delete()){
			$result['success'] = true;
			$result['message'] = 'MaterialCode deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($material_code);
		}
		
		return $result;
	}
}
