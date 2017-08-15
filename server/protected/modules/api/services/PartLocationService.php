<?php
class PartLocationService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_location= PartLocationService::getEmptyPartLocation();
		$result['location']= $get_empty_location['location'];
		$get_empty_location_error= PartLocationService::getEmptyPartLocationError();
		$result['location_error']= $get_empty_location_error['location_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartLocation(){
		$result= array();
		$location= array(
					'id'=> '',
					'shelf'=> '',
					'section'=> '',
					'box'=> '',
					'status'=> '',
					);
		
		$result['location']= $location;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartLocationError(){
		$result= array();
		$location= array(
					'id'=> array(),
					'shelf'=> array(),
					'section'=> array(),
					'box'=> array(),
					'status'=> array(),
					);
		
		$result['location_error']= $location;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= PartLocation::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'id';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_partlocation.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_partlocation.*
			   From tbl_partlocation";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['shelf']) && $data['shelf']!= ''){
			$sql= $sql."And tbl_partlocation.shelf LIKE '%".$data['shelf']."%'";
		}
		if(isset($data['section']) && $data['section']!= ''){
			$sql= $sql."And tbl_partlocation.section LIKE '%".$data['section']."%'";
		}
		if(isset($data['box']) && $data['box']!= ''){
			$sql= $sql."And tbl_partlocation.box LIKE '%".$data['box']."%'";
		}


		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$locations= PartLocation::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['shelf']) && $data['shelf']!= ''){
			$criteria->compare('shelf', $data['shelf'], true);
		}
		if(isset($data['section']) && $data['section']!= ''){
			$criteria->compare('section', $data['section'], true);
		}
		if(isset($data['box']) && $data['box']!= ''){
			$criteria->compare('box', $data['box'], true);
		}

		$total = PartLocation::model()->count($criteria);
		
		if($locations!= null){
			$result['success']= true;
			$result['locations']= self::convertListPartLocation($locations, $data);
			
			$result['totalresults']= $total;
			$result['start_part_location']= (int)$data['limitstart']+ 1;
			$result['end_part_location']= (int)$data['limitstart']+ count($locations);
		}
		else{
			$result['success']= true;
			$result['locations']= array();
			$result['totalresults']= $total;
			$result['start_part_location']= 0;
			$result['end_part_location']= 0;
		}
		return $result;
	}

	public static function getPartLocationById($data){
		$result= array();
		$get_empty_location_error= PartLocationService::getEmptyPartLocationError();
		$result['location_error']= $get_empty_location_error['location_error'];
		$location= PartLocation::model()->findByPk($data['id']);
		if($location){
			$result['success']= true;
			$result['location']= self::convertPartLocation($location);
		}
		else{
			$result['success']= false;
			$result['message']= 'Part Location \'s not found!';
		}
		return $result;
	}

	public static function create($data){
		$result= array();
		
		$location= new PartLocation();
		$location->attributes= $data;

		if($location->validate()){
			$location->save();
			$result['success']= true;
			$result['id']= $location->id;
		}
		else{
			$empty_location_error= PartLocationService::getEmptyPartLocationError();
			$result['location_error']= $empty_location_error['location_error']; 
			foreach ($location->getErrors() as $key => $error_array) {
				$result['location_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating location has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$location= PartLocation::model()->findByPk((int)$data['id']);
			if($location){
				$location->attributes= $data;

				if($location->validate()){
					$location->save();
					$result['success']= true;
					$result['id']= $location->id;
					$location_array= PartLocationService::getPartLocationById(array('id'=>$location->id));
					$result['location']= $location_array['location'];
					$result['message']= 'Part Location updated!';
				}
				else{
					$empty_location_error= PartLocationService::getEmptyPartLocationError();
					$result['location_error']= $empty_location_error['location_error']; 
					foreach ($location->getErrors() as $key => $error_array) {
						$result['location_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update location has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'PartLocation \'s not found!';
			}
		}
		else{
			//Create new location
			$location = new PartLocation();
			$location->attributes= $data;

			if($location->validate()){
				$location->save();
				$result['success']= true;
				$result['id']= $location->id;
				$location_array= PartLocationService::getPartLocationById(array('id'=>$location->id));
				$result['location']= $location_array['location'];
				$result['message']= 'Part Location created!';
			}
			else{
				$empty_location_error= PartLocationService::getEmptyPartLocationError();
				$result['location_error']= $empty_location_error['location_error']; 
				foreach ($location->getErrors() as $key => $error_array) {
					$result['location_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create location has some errors';
			}
		}
		
		
		return $result;
	}
	
	public static function convertListPartLocation($locations, $data){
		$result= array();
		if($locations!= null && count($locations)>0){
			foreach($locations as $location){
				$result[]= self::convertPartLocation($location);
			}
		}
		return $result;
	}
	
	public static function convertPartLocation($location){
		$result= array(
					'id'=> $location->id,
					'shelf'=> $location->shelf,
					'section'=> $location->section,
					'box'=> $location->box,
					'name'=>$location->getName(),
					'status'=> $location->status,
				);

		return $result;
	}

	public static function removePartLocation($data){
		$result= array();
		$location = PartLocation::model()->findByPk((int)$data['id']);
		$location->attributes= $data;

		if($location->delete()){
			$result['success'] = true;
			$result['message'] = 'PartLocation deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($location);
		}
		
		return $result;
	}
}
