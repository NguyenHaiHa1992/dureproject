<?php
class PartHeatnumberService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_heatnumber= PartHeatnumberService::getEmptyPartHeatnumber();
		$result['heatnumber']= $get_empty_heatnumber['heatnumber'];
		$get_empty_heatnumber_error= PartHeatnumberService::getEmptyPartHeatnumberError();
		$result['heatnumber_error']= $get_empty_heatnumber_error['heatnumber_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartHeatnumber(){
		$result= array();
		$heatnumber= array(
					'id'=> '',
					'heatnumber'=> '',
					'drawing'=> '',
					'designation'=> '',
					'status'=> '',
					);
		
		$result['heatnumber']= $heatnumber;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartHeatnumberError(){
		$result= array();
		$heatnumber= array(
					'id'=> array(),
					'heatnumber'=> array(),
					'drawing'=> array(),
					'designation'=> array(),
					'status'=> array(),
					);
		
		$result['heatnumber_error']= $heatnumber;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();
		$heatnumbers= PartHeatnumber::model()->findAll();
		if($heatnumbers!= null && count($heatnumbers)>0){
			$result['heatnumbers']= self::convertListPartHeatnumber($heatnumbers, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['heatnumbers']= array();
		}
		return $result;
	}
	
	public static function getPartHeatnumberById($data){
		$result= array();
		$get_empty_heatnumber_error= PartHeatnumberService::getEmptyPartHeatnumberError();
		$result['heatnumber_error']= $get_empty_heatnumber_error['heatnumber_error'];
		$heatnumber= PartHeatnumber::model()->findByPk($data['id']);
		if($heatnumber){
			$result['success']= true;
			$result['heatnumber']= self::convertPartHeatnumber($heatnumber);
		}
		else{
			$result['success']= false;
			$result['message']= 'Part Heatnumber \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$heatnumber= new PartHeatnumber();
		$heatnumber->attributes= $data;

		if($heatnumber->validate()){
			$heatnumber->save();
			$result['success']= true;
			$result['id']= $heatnumber->id;
		}
		else{
			$empty_heatnumber_error= PartHeatnumberService::getEmptyPartHeatnumberError();
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
			$heatnumber= PartHeatnumber::model()->findByPk((int)$data['id']);
			if($heatnumber){
				$heatnumber->attributes= $data;

				if($heatnumber->validate()){
					$heatnumber->save();
					$result['success']= true;
					$result['id']= $heatnumber->id;
					$heatnumber_array= PartHeatnumberService::getPartHeatnumberById(array('id'=>$heatnumber->id));
					$result['heatnumber']= $heatnumber_array['heatnumber'];
					$result['message']= 'Part Heatnumber updated!';
				}
				else{
					$empty_heatnumber_error= PartHeatnumberService::getEmptyPartHeatnumberError();
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
				$result['message']= 'PartHeatnumber \'s not found!';
			}
		}
		else{
			//Create new heatnumber
			$heatnumber = new PartHeatnumber();
			$heatnumber->attributes= $data;

			if($heatnumber->validate()){
				$heatnumber->save();
				$result['success']= true;
				$result['id']= $heatnumber->id;
				$heatnumber_array= PartHeatnumberService::getPartHeatnumberById(array('id'=>$heatnumber->id));
				$result['heatnumber']= $heatnumber_array['heatnumber'];
				$result['message']= 'Part Heatnumber created!';
			}
			else{
				$empty_heatnumber_error= PartHeatnumberService::getEmptyPartHeatnumberError();
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
	
	public static function convertListPartHeatnumber($heatnumbers, $data){
		$result= array();
		if($heatnumbers!= null && count($heatnumbers)>0){
			foreach($heatnumbers as $heatnumber){
				$result[]= self::convertPartHeatnumber($heatnumber);
			}
		}
		return $result;
	}
	
	public static function convertPartHeatnumber($heatnumber){
		$result= array(
					'id'=> $heatnumber->id,
					'part_id'=>$heatnumber->part_id,
					'heatnumber'=> $heatnumber->heatnumber,
					'drawing'=> $heatnumber->drawing,
					'designation'=> $heatnumber->designation,
					'status'=> $heatnumber->status,
				);

		return $result;
	}

	public static function removePartHeatnumber($data){
		$result= array();
		$heatnumber = PartHeatnumber::model()->findByPk((int)$data['id']);
		$heatnumber->attributes= $data;

		// Validate before delete heatnumber
		// Check in out history
		$criteria = new CDbCriteria();
		$criteria->addCondition('heatnumber_ids Like \'%"'.$heatnumber->id.'"%\'');
		$find = InOutPart::model()->count($criteria);
		if($find > 0){
			$result['success'] = false;
			$result['message'] = 'This Heatnumber can not be delete because It existed in Part In/Out History!';
			return $result;
		}


		if($heatnumber->delete()){
			$result['success'] = true;
			$result['message'] = 'PartHeatnumber deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($heatnumber);
		}
		
		return $result;
	}
}
