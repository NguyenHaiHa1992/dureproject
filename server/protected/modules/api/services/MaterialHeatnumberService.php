<?php
class MaterialHeatnumberService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_heatnumber= MaterialHeatnumberService::getEmptyMaterialHeatnumber();
		$result['heatnumber']= $get_empty_heatnumber['heatnumber'];
		$get_empty_heatnumber_error= MaterialHeatnumberService::getEmptyMaterialHeatnumberError();
		$result['heatnumber_error']= $get_empty_heatnumber_error['heatnumber_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialHeatnumber(){
		$result= array();
		$heatnumber= array(
					'id'=> '',
					'heatnumber'=> '',
					'drawing'=> '',
					'status'=> '',
					);
		
		$result['heatnumber']= $heatnumber;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialHeatnumberError(){
		$result= array();
		$heatnumber= array(
					'id'=> array(),
					'heatnumber'=> array(),
					'drawing'=> array(),
					'status'=> array(),
					);
		
		$result['heatnumber_error']= $heatnumber;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$heatnumbers= MaterialHeatnumber::model()->findAll();
		if($heatnumbers!= null && count($heatnumbers)>0){
			$result['heatnumbers']= self::convertListMaterialHeatnumber($heatnumbers, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['heatnumbers']= array();
		}
		return $result;
	}
	
	public static function getMaterialHeatnumberById($data){
		$result= array();
		$get_empty_heatnumber_error= MaterialHeatnumberService::getEmptyMaterialHeatnumberError();
		$result['heatnumber_error']= $get_empty_heatnumber_error['heatnumber_error'];
		$heatnumber= MaterialHeatnumber::model()->findByPk($data['id']);
		if($heatnumber){
			$result['success']= true;
			$result['heatnumber']= self::convertMaterialHeatnumber($heatnumber);
		}
		else{
			$result['success']= false;
			$result['message']= 'Material Heatnumber \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$heatnumber= new MaterialHeatnumber();
		$heatnumber->attributes= $data;

		if($heatnumber->validate()){
			$heatnumber->save();
			$result['success']= true;
			$result['id']= $heatnumber->id;
		}
		else{
			$empty_heatnumber_error= MaterialHeatnumberService::getEmptyMaterialHeatnumberError();
			$result['heatnumber_error']= $empty_heatnumber_error['heatnumber_error']; 
			foreach ($heatnumber->getErrors() as $key => $error_array) {
				$result['heatnumber_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating heatnumber has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$heatnumber= MaterialHeatnumber::model()->findByPk((int)$data['id']);
			if($heatnumber){
				$heatnumber->attributes= $data;

				if($heatnumber->validate()){
					$heatnumber->save();
					$result['success']= true;
					$result['id']= $heatnumber->id;
					$heatnumber_array= MaterialHeatnumberService::getMaterialHeatnumberById(array('id'=>$heatnumber->id));
					$result['heatnumber']= $heatnumber_array['heatnumber'];
					$result['message']= 'Material Heatnumber updated!';
				}
				else{
					$empty_heatnumber_error= MaterialHeatnumberService::getEmptyMaterialHeatnumberError();
					$result['heatnumber_error']= $empty_heatnumber_error['heatnumber_error']; 
					foreach ($heatnumber->getErrors() as $key => $error_array) {
						$result['heatnumber_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update heatnumber has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'MaterialHeatnumber \'s not found!';
			}
		}
		else{
			//Create new heatnumber
			$heatnumber = new MaterialHeatnumber();
			$heatnumber->attributes= $data;

			if($heatnumber->validate()){
				$heatnumber->save();
				$result['success']= true;
				$result['id']= $heatnumber->id;
				$heatnumber_array= MaterialHeatnumberService::getMaterialHeatnumberById(array('id'=>$heatnumber->id));
				$result['heatnumber']= $heatnumber_array['heatnumber'];
				$result['message']= 'Material Heatnumber created!';
			}
			else{
				$empty_heatnumber_error= MaterialHeatnumberService::getEmptyMaterialHeatnumberError();
				$result['heatnumber_error']= $empty_heatnumber_error['heatnumber_error']; 
				foreach ($heatnumber->getErrors() as $key => $error_array) {
					$result['heatnumber_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create heatnumber has some errors';
			}
		}
		
		
		return $result;
	}
	
	public static function convertListMaterialHeatnumber($heatnumbers, $data){
		$result= array();
		if($heatnumbers!= null && count($heatnumbers)>0){
			foreach($heatnumbers as $heatnumber){
				$result[]= self::convertMaterialHeatnumber($heatnumber);
			}
		}
		return $result;
	}
	
	public static function convertMaterialHeatnumber($heatnumber){
		$result= array(
					'id'=> $heatnumber->id,
					'material_id'=>$heatnumber->material_id,
					'heatnumber'=> $heatnumber->heatnumber,
					'drawing'=> $heatnumber->drawing,
					'status'=> $heatnumber->status,
				);

		return $result;
	}

	public static function removeMaterialHeatnumber($data){
		$result= array();
		$heatnumber = MaterialHeatnumber::model()->findByPk((int)$data['id']);
		$heatnumber->attributes= $data;

		// Validate before delete heatnumber
		// Check in out history
		$criteria = new CDbCriteria();
		$criteria->addCondition('heatnumber_ids Like \'%"'.$heatnumber->id.'"%\'');
		$find = InOutMaterial::model()->count($criteria);
		if($find > 0){
			$result['success'] = false;
			$result['message'] = 'This Material Heatnumber can not be delete because It existed in Material In/Out History!';
			return $result;
		}

		// Check used in Part heatnumber
		$criteria = new CDbCriteria();
		$criteria->compare('heatnumber', $heatnumber->heatnumber);
		$find = PartHeatnumber::model()->count($criteria);
		if($find > 0){
			$result['success'] = false;
			$result['message'] = 'This Material Heatnumber can not be delete because It were used in Part Heatnumber';
			return $result;
		}

		if($heatnumber->delete()){
			$result['success'] = true;
			$result['message'] = 'MaterialHeatnumber deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($heatnumber);
		}
		
		return $result;
	}
}
