<?php
class ItemService extends iPhoenixService{
	public static function createInit(){
		$result= array();
		$get_empty_item= ItemService::getEmptyItem();
		$result['item']= $get_empty_item['item'];
		$get_empty_item_error= ItemService::getEmptyItemError();
		$result['item_error']= $get_empty_item_error['item_error'];
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyItem(){
		$result= array();
		$item= array(
					'id'=> '',
					'name'=> '',
					'price'=> '',
					'status'=> '',
					'created_time'=> '',
					'is_edit'=>'',
					);
		
		$result['item']= $item;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyItemError(){
		$result= array();
		$item= array(
					'id'=> array(),
					'name'=> array(),
					'price'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'is_edit'=>array(),
					);
		
		$result['item_error']= $item;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Item::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_item.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_item.*
			   From tbl_item";
		$sql= $sql."
			   		Where tbl_item.status=1 ";
		if(isset($data['name']) && $data['name']!= ''){
			$sql= $sql."And tbl_item.name LIKE '%".$data['name']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$items = Item::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', true);
		if(isset($data['name']) && $data['name']!= ''){
			$criteria->compare('name', $data['name'], true);
		}

		$total = Item::model()->count($criteria);

		if($items!= null){
			$result['success']= true;
			$result['items']=self::convertListItem($items, $data);
			$result['totalresults']= $total;
			$result['start_item']= (int)$data['limitstart']+ 1;
			$result['end_item']= (int)$data['limitstart']+ count($items);
		}
		else{
			$result['success']= true;
			$result['items']= array();
			$result['totalresults']= $total;
			$result['start_item']= 0;
			$result['end_item']= 0;
		}

		return $result;
	}
	
	public static function getItemById($data){
		$result= array();
		$get_empty_item_error= ItemService::getEmptyItemError();
		$result['item_error']= $get_empty_item_error['item_error'];
		$item= Item::model()->findByPk($data['id']);
		if($item){
			$result['success']= true;
			$result['item']= self::convertItem($item);
		}
		else{
			$result['success']= false;
			$result['message']= 'Item \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$item= new Item();
		$item->attributes= $data;
		$item= self::beforeSave($item);
		if($item->validate()){
			$item->save();
			$result['success']= true;
			$result['id']= $item->id;
		}
		else{
			$empty_item_error= ItemService::getEmptyItemError();
			$result['item_error']= $empty_item_error['item_error']; 
			foreach ($item->getErrors() as $key => $error_array) {
				$result['item_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating Item has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$item= Item::model()->findByPk((int)$data['id']);
			if($item){
				$item->attributes= $data;
				$item= self::beforeSave($item);
				if($item->validate()){
					if($item->save()){
						$result['success']= true;
						$result['id']= $item->id;
						$item_array= ItemService::getItemById(array('id'=>$item->id));
						$result['item']= $item_array['item'];
						$result['message'] = 'Item updated!';
					}
					else{
						$result['success'] = false;
						$result['message'] = CHtml::errorSummary($item);
					}
				}
				else{
					$empty_item_error= ItemService::getEmptyItemError();
					$result['item_error']= $empty_item_error['item_error']; 
					foreach ($item->getErrors() as $key => $error_array) {
						$result['item_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update Item has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Item \'s not found!';
			}
		}
		else{
			// Create new category
			$item = new Item();
			$item->attributes = $data;
			if($item->save()){
				$result['success']= true;
				$result['id']= $item->id;
				$item_array= ItemService::getItemById(array('id'=>$item->id));
				$result['item']= $item_array['item'];
				$result['message'] = 'Item created!';
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($item);
			}
		}
		
		return $result;
	}
	
	public static function beforeSave($item){
		if($item->isNewRecord){
			$item->created_time= time();
		}
		$item->status= 1;
		return $item;
	}
	
	public static function convertListItem($items, $data){
		$result= array();
		if($items!= null && count($items)>0){
			foreach($items as $item){
				$result[]= self::convertItem($item);
			}
		}
		return $result;
	}
	
	public static function convertItem($item){
		$result= array(
					'id'=> $item->id,
					'name'=> $item->name,
					'price'=> $item->price,
					'status'=> $item->status,
					'created_time'=> date('d-m-Y', $item->created_time),
					'is_edit'=>false,
					);
		return $result;
	}

	public static function removeItem($data){
		$result= array();
		$item = Item::model()->findByPk((int)$data['id']);
		$item->attributes= $data;

		if($item->delete()){
			$result['success'] = true;
			$result['message'] = 'Item deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($item);
		}
		
		return $result;
	}
}
