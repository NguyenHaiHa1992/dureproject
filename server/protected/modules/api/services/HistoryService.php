<?php
class HistoryService extends iPhoenixService{
	public static function getAll($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(History::model()->findAll());
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';

		$sql_left_join=' ';
		$sql_order_by='Order By tbl_history.'.$data['sort_attribute'].' '.$data['sort_type'];
	
		
		$sql= "Select tbl_history.*
			   From tbl_history ";
		$sql= $sql.$sql_left_join;
		$sql = $sql.'Where 1 ';

		if(isset($data['class']) && $data['class']!= ''){
			$sql= $sql."And tbl_history.class = '".$data['class']."' ";
		}
		if(isset($data['id']) && $data['id']!= ''){
			$sql= $sql."And tbl_history.object_id = ".$data['id']." ";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$histories= History::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['class']) && $data['class']!= ''){
			$criteria->compare('class', $data['class']);
		}
		if(isset($data['id']) && $data['id']!= ''){
			$criteria->compare('object_id', $data['id']);
		}
		$total= History::model()->count($criteria);

		if($histories!= null){
			$result['success']= true;
			$result['histories']=self::convertListHistory($histories, $data);
			
			$result['totalresults']= $total;
			$result['start_history']= (int)$data['limitstart']+ 1;
			$result['end_history']= (int)$data['limitstart']+ count($histories);
		}
		else{
			$result['success']= true;
			$result['histories']= array();
			$result['totalresults']= $total;
			$result['start_history']= 0;
			$result['end_history']= 0;
		}
		return $result;
	}

	public static function getHistoryById($data){
		$result= array();
		$get_empty_history_error= HistoryService::getEmptyHistoryError();
		$result['history_error']= $get_empty_history_error['history_error'];
		$get_all_history_categories= HistoryCategoryService::getAll(array());
		$result['history_categories']= $get_all_history_categories['history_categories'];
		$get_all_machines= MachineService::getAll(array());
		$result['machines']= $get_all_machines['machines'];
		$get_all_materials= MaterialService::getAll(array());
		$result['materials']= $get_all_materials['materials'];

		$history= History::model()->findByPk((int)$data['id']);

		if($history!= null){
			$result['success']= true;
			$result['history']= self::convertHistory($history);
		}
		else{
			$result['success']= false;
			$result['message']= 'History\'s not found!';
		}
		return $result;
	}
	
	public static function convertListHistory($histories, $data){
		$result= array();
		if($histories!= null && count($histories)>0){
			foreach($histories as $history){
				$result[]= self::convertHistory($history);
			}
		}
		return $result;
	}

	public static function convertHistory($history){
		$history_object_name = '';
		switch ($history->class) {
			case 'Part':
				$history_object = Part::model()->findByPk($history->object_id);
				$history_object_name = $history_object->part_code;
				break;

			case 'Material':
				$history_object = Material::model()->findByPk($history->object_id);
				$history_object_name = $history_object->material_code;
				break;

			case 'PurchaseOrder':
				$history_object = PurchaseOrder::model()->findByPk($history->object_id);
				$history_object_name = $history_object->po_code;
				break;

			default:
				# code...
				break;
		}

		$result= array(
					'id'=> $history->id,
					'object_id'=> $history->object_id,
					'object_code'=>$history_object_name,
					'description'=>$history->description,
					'class'=> $history->class,
					'content'=> $history->content,
					'created_time'=> date('Y-m-d H:i',$history->created_time),
					'created_by'=> isset($history->author)?$history->author->name:"N/A",
				);

		return $result;
	}
}
