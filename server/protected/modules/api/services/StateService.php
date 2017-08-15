<?php
class StateService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_state= StateService::getEmptyState();
		$result['state']= $get_empty_state['state'];
		$get_empty_state_error= StateService::getEmptyStateError();
		$result['state_error']= $get_empty_state_error['state_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyState(){
		$result= array();
		$state= array(
					'id'=> '',
					'state_short'=> '',
					'state_full'=> '',
					'country_short'=> '',
					'country_full'=>'',
					'is_edit'=>''
					);
		
		$result['state']= $state;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyStateError(){
		$result= array();
		$state= array(
					'id'=> array(),
					'state_short'=> array(),
					'state_full'=> array(),
					'country_short'=> array(),
					'country_full'=>array(),
					'is_edit'=>array(),
					);
		
		$result['state_error']= $state;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(State::model()->findAll());
		}

		$sql= "Select tbl_state.*
			   From tbl_state";

		$sql= $sql."
			   		Where tbl_state.status= 1 ";

		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$states= State::model()->findAllBySql($sql);
	    
		$total= count(State::model()->findAll());
		
		if($states!= null){
			$result['success']= true;
			$result['states']=self::convertListState($states, $data);
			
			$result['totalresults']= $total;
			$result['start_state']= (int)$data['limitstart']+ 1;
			$result['end_state']= (int)$data['limitstart']+ count($states);
		}
		else{
			$result['success']= true;
			$result['states']= array();
			$result['totalresults']= $total;
			$result['start_part']= 0;
			$result['end_part']= 0;
		}
		return $result;
	}
	
	public static function getStateById($data){
		$result= array();
		$get_empty_state_error= StateService::getEmptyStateError();
		$result['state_error']= $get_empty_state_error['state_error'];
		$state= State::model()->findByPk($data['id']);
		if($state){
			$result['success']= true;
			$result['state']= self::convertState($state);
		}
		else{
			$result['success']= false;
			$result['message']= 'State \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$state= new State();
		$state->attributes= $data;
		$state= self::beforeSave($state);
		if($state->validate()){
			$state->save();
			$result['success']= true;
			$result['id']= $state->id;
		}
		else{
			$empty_state_error= StateService::getEmptyStateError();
			$result['state_error']= $empty_state_error['state_error']; 
			foreach ($state->getErrors() as $key => $error_array) {
				$result['state_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating State has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$state= State::model()->findByPk((int)$data['id']);
			if($state){
				$state->attributes= $data;
				$state= self::beforeSave($state);
				if($state->validate()){
					if($state->save()){
						$result['success']= true;
						$result['id']= $state->id;
						$state_array= StateService::getStateById(array('id'=>$state->id));
						$result['state']= $state_array['state'];
						$result['message'] = 'State updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($state);
					}
				}
				else{
					$empty_state_error= StateService::getEmptyStateError();
					$result['state_error']= $empty_state_error['state_error']; 
					foreach ($state->getErrors() as $key => $error_array) {
						$result['state_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update State has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'State \'s not found!';
			}
		}
		else{
			// Create new category
			$state = new State();
			$state->attributes = $data;
			if($state->save()){
				$result['success']= true;
				$result['id']= $state->id;
				$state_array= StateService::getStateById(array('id'=>$state->id));
				$result['state']= $state_array['state'];
				$result['message'] = 'State created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($state);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($state){
		if($state->isNewRecord){
			$state->created_time= time();
		}
		$state->status= 1;
		return $state;
	}
	
	public static function convertListState($states, $data){
		$result= array();
		if($states!= null && count($states)>0){
			foreach($states as $state){
				$result[]= self::convertState($state);
			}
		}
		return $result;
	}
	
	public static function convertState($state){
		$result= array(
					'id'=> $state->id,
					'state_short'=> $state->state_short,
					'state_full'=> $state->state_full,
					'country_short'=> $state->country_short,
					'country_full'=> $state->country_full,
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeState($data){
		$result= array();
		$state = State::model()->findByPk((int)$data['id']);
		$state->attributes= $data;

		if($state->delete()){
			$result['success'] = true;
			$result['message'] = 'State deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($state);
		}
		
		return $result;
	}
}
