<?php
class MaterialLocationService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_location= MaterialLocationService::getEmptyMaterialLocation();
		$result['location']= $get_empty_location['location'];
		$get_empty_location_error= MaterialLocationService::getEmptyMaterialLocationError();
		$result['location_error']= $get_empty_location_error['location_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialLocation(){
		$result= array();
		$location= array(
					'id'=> '',
					'rack'=> '',
					'row'=> '',
					'box'=> '',
					'status'=> '',
					);
		
		$result['location']= $location;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialLocationError(){
		$result= array();
		$location= array(
					'id'=> array(),
					'rack'=> array(),
					'row'=> array(),
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
			$data['limitnum']= MaterialLocation::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'id';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_materiallocation.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_materiallocation.*
			   From tbl_materiallocation";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['rack']) && $data['rack']!= ''){
			$sql= $sql."And tbl_materiallocation.rack LIKE '%".$data['rack']."%'";
		}
		if(isset($data['row']) && $data['row']!= ''){
			$sql= $sql."And tbl_materiallocation.row LIKE '%".$data['row']."%'";
		}
		if(isset($data['box']) && $data['box']!= ''){
			$sql= $sql."And tbl_materiallocation.box LIKE '%".$data['box']."%'";
		}


		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$locations= MaterialLocation::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['rack']) && $data['rack']!= ''){
			$criteria->compare('rack', $data['rack'], true);
		}
		if(isset($data['row']) && $data['row']!= ''){
			$criteria->compare('row', $data['row'], true);
		}
		if(isset($data['box']) && $data['box']!= ''){
			$criteria->compare('box', $data['box'], true);
		}

		$total = MaterialLocation::model()->count($criteria);
		
		if($locations!= null){
			$result['success']= true;
			$result['locations']= self::convertListMaterialLocation($locations, $data);
			
			$result['totalresults']= $total;
			$result['start_material_location']= (int)$data['limitstart']+ 1;
			$result['end_material_location']= (int)$data['limitstart']+ count($locations);
		}
		else{
			$result['success']= true;
			$result['locations']= array();
			$result['totalresults']= $total;
			$result['start_material_location']= 0;
			$result['end_material_location']= 0;
		}
		return $result;
	}
	
	public static function getMaterialLocationById($data){
		$result= array();
		$get_empty_location_error= MaterialLocationService::getEmptyMaterialLocationError();
		$result['location_error']= $get_empty_location_error['location_error'];
		$location= MaterialLocation::model()->findByPk($data['id']);
		if($location){
			$result['success']= true;
			$result['location']= self::convertMaterialLocation($location);
		}
		else{
			$result['success']= false;
			$result['message']= 'Material Location \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$location= new MaterialLocation();
		$location->attributes= $data;

		if($location->validate()){
			$location->save();
			$result['success']= true;
			$result['id']= $location->id;
		}
		else{
			$empty_location_error= MaterialLocationService::getEmptyMaterialLocationError();
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
			$location= MaterialLocation::model()->findByPk((int)$data['id']);
			if($location){
				$location->attributes= $data;

				if($location->validate()){
					$location->save();
					$result['success']= true;
					$result['id']= $location->id;
					$location_array= MaterialLocationService::getMaterialLocationById(array('id'=>$location->id));
					$result['location']= $location_array['location'];
					$result['message']= 'Material Location updated!';
				}
				else{
					$empty_location_error= MaterialLocationService::getEmptyMaterialLocationError();
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
				$result['message']= 'MaterialLocation \'s not found!';
			}
		}
		else{
			//Create new location
			$location = new MaterialLocation();
			$location->attributes= $data;

			if($location->validate()){
				$location->save();
				$result['success']= true;
				$result['id']= $location->id;
				$location_array= MaterialLocationService::getMaterialLocationById(array('id'=>$location->id));
				$result['location']= $location_array['location'];
				$result['message']= 'Material Location created!';
			}
			else{
				$empty_location_error= MaterialLocationService::getEmptyMaterialLocationError();
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
	
	public static function convertListMaterialLocation($locations, $data){
		$result= array();
		if($locations!= null && count($locations)>0){
			foreach($locations as $location){
				$result[]= self::convertMaterialLocation($location);
			}
		}
		return $result;
	}
	
	public static function convertMaterialLocation($location){
		$result= array(
					'id'=> $location->id,
					'rack'=> $location->rack,
					'row'=> $location->row,
					'box'=> $location->box,
					'name'=>$location->getName(),
					'status'=> $location->status,
				);

		return $result;
	}

	public static function removeMaterialLocation($data){
		$result= array();
		$location = MaterialLocation::model()->findByPk((int)$data['id']);
		$location->attributes= $data;

		if($location->delete()){
			$result['success'] = true;
			$result['message'] = 'MaterialLocation deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($location);
		}
		
		return $result;
	}
}
