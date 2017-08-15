<?php
class PurchaseOrderService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_purchase_order= PurchaseOrderService::getEmptyPurchaseOrder();
		if(isset($data['id']) && $data['id']!= ''){
			$purchase_order= PurchaseOrderService::getPurchaseOrderById(array('id'=> $data['id']));
			if($purchase_order['success']== true){
				$result['purchase_order']= $purchase_order['purchase_order'];
				$result['po_code']= $purchase_order['purchase_order']['po_code'];
				$result['client_name']= $purchase_order['purchase_order']['client']['name'];
				// foreach ($purchase_order['purchase_order']['purchase_order_details'] as $key => $purchase_order_detail) {
				// 	$result['part_codes'][$key]= $purchase_order_detail['part_code'];
				// }
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['purchase_order']= $get_empty_purchase_order['purchase_order'];
				// foreach ($get_empty_purchase_order['purchase_order']['purchase_order_details'] as $key => $purchase_order_detail) {
				// 	$result['part_codes'][$key]= $purchase_order_detail['part_code'];
				// }
				$result['po_code']= '';
				$result['client_name']= '';
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['purchase_order']= $get_empty_purchase_order['purchase_order'];
			// foreach ($get_empty_purchase_order['purchase_order']['purchase_order_details'] as $key => $purchase_order_detail) {
			// 	$result['part_codes'][$key]= $purchase_order_detail['part_code'];
			// }
			$result['po_code']= '';
			$result['client_name']= '';
			$result['is_update']= false;
			$result['is_create']= true;
		}
		$result['purchase_order_empty']= $get_empty_purchase_order['purchase_order'];
		$get_empty_purchase_order_error= PurchaseOrderService::getEmptyPurchaseOrderError();
		$result['purchase_order_error']= $get_empty_purchase_order_error['purchase_order_error'];
		$result['purchase_order_error_empty']= $get_empty_purchase_order_error['purchase_order_error'];

		// Get existed items
		$existed_items = ItemService::getAll(array());
		$result['existed_items'] = $existed_items['items'];

		// Get list category
		$purchase_order_categories = PurchaseOrder::$category_list;
		$result['purchase_order_categories'] = $purchase_order_categories;

		$result['success']= true;
		return $result;
	}

	public static function checkOutInit(){
		$result= array();

		$get_all_locations= PartLocationService::getAll(array());
		$result['locations']= $get_all_locations['locations'];

		$employees = EmployeeService::getAll(array());
		$result['employees'] = $employees['employees'];

		$result['success']= true;
		return $result;
	}

	public static function getAll($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= PurchaseOrder::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_purchase_order.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_purchase_order.*
			   From tbl_purchase_order";
		$sql= $sql."
			   		Where tbl_purchase_order.status= 1 ";
		if(isset($data['po_code']) && $data['po_code']!= ''){
			$sql= $sql."And tbl_purchase_order.po_code LIKE '%".$data['po_code']."%'";
		}
		if(isset($data['category'])){
			$sql= $sql."And tbl_purchase_order.category = '".$data['category']."'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$purchase_orders = PurchaseOrder::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['po_code']) && $data['po_code']!= ''){
			$criteria->compare('po_code', $data['po_code'], true);
		}
		if(isset($data['category'])){
			$criteria->compare('category', $data['category']);
		}
		$total= PurchaseOrder::model()->count($criteria);

		if(count($purchase_orders)>0){
			$result['purchase_orders']= self::convertListPurchaseOrder($purchase_orders, array());
			$result['totalresults']= $total;
			$result['start_purchase_order']= (int)$data['limitstart']+ 1;
			$result['end_purchase_order']= (int)$data['limitstart']+ count($purchase_orders);
			$result['success']= true;
		}
		else{
			$result['purchase_orders']= array();
			$result['totalresults']= $total;
			$result['start_purchase_order']= 0;
			$result['end_purchase_order']= 0;
			$result['success']= true;
		}

		return $result;
	}

	public static function getAllPurchaseOrderCode($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(Material::model()->findAll());
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_purchase_order.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_purchase_order.id, tbl_purchase_order.po_code
			   From tbl_purchase_order";
		$sql= $sql."
			   		Where tbl_purchase_order.status= 1 ";
		if(isset($data['po_code']) && $data['po_code']!= ''){
			$sql= $sql."And tbl_purchase_order.po_code LIKE '%".$data['po_code']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$purchase_orders = PurchaseOrder::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		$criteria->compare('status', 1);
		if(isset($data['po_code']) && $data['po_code']!= ''){
			$criteria->compare('po_code', $data['po_code'], true);
		}

		$total= PurchaseOrder::model()->count($criteria);

		if(count($purchase_orders)>0){
			$converted_purchase_orders = array();
			foreach($purchase_orders as $purchase_order){
				$converted_purchase_orders[] = array(
					'id'=>$purchase_order->id,
					'po_code'=>$purchase_order->po_code,
				);
			}

			$result['purchase_orders']= $converted_purchase_orders;
			$result['totalresults']= $total;
			$result['start_purchase_order']= (int)$data['limitstart']+ 1;
			$result['end_purchase_order']= (int)$data['limitstart']+ count($purchase_orders);
			$result['success']= true;
		}
		else{
			$result['purchase_orders']= array();
			$result['totalresults']= $total;
			$result['start_purchase_order']= 0;
			$result['end_purchase_order']= 0;
			$result['success']= true;
		}

		return $result;
	}

	// public static function getAll($data){//data là thông tin phân trang
		// $result = array();
		// if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			// $data['limitstart']= '0';
			// $data['limitnum']= count(Material::model()->findAll());
		// }
		// if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			// $data['sort_attribute']= 'created_time';
			// $data['sort_type']= 'DESC';
		// }
// 		
		// $sql= '';
		// $sql_order_by='Order By tbl_material.'.$data['sort_attribute'].' '.$data['sort_type'];
// 		
// 		
		// $sql= "Select tbl_material.*
			   // From tbl_material";
		// $sql= $sql."
			   		// Where tbl_material.status= 1 ";
		// $sql= $sql.$sql_order_by;
		// $sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		// $materials= Material::model()->findAllBySql($sql);
		// $total= count(Material::model()->findAll());
		// if($materials!= null){
			// $result['success']= true;
			// $result['materials']=self::convertListMaterial($materials, $data);
			// $result['totalresults']= $total;
			// $result['start_material']= (int)$data['limitstart']+ 1;
			// $result['end_material']= (int)$data['limitstart']+ count($materials);
		// }
		// else{
			// $result['success']= true;
			// $result['materials']= array();
			// $result['totalresults']= $total;
			// $result['start_material']= 0;
			// $result['end_material']= 0;
		// }
		// return $result;
	// }

	public static function getPurchaseOrderById($data){
		$result= array();
		$get_empty_purchase_order_error= PurchaseOrderService::getEmptyPurchaseOrderError();
		$result['purchase_order_error']= $get_empty_purchase_order_error['purchase_order_error'];
		
		$purchase_order;
		$purchase_order= PurchaseOrder::model()->findByPk((int)$data['id']);
		if($purchase_order!= null){
			$result['success']= true;
			$result['purchase_order']= self::convertPurchaseOrder($purchase_order);
		}
		else{
			$result['success']= false;
			$result['message']= 'PO\'s not found!';
		}
		return $result;
	}
	
	public static function getEmptyPurchaseOrder(){
		$result= array();
		$purchase_order= array(
					'id'=> '',
					'po_code'=> '',
					'client_id'=> '',
					'ship_via'=> '',
					'order_date'=> '',
					'delivery_date'=> '',
					'entered_date'=> '',
					'customer_po'=> '',
					'file_id'=> '',
					'tmp_file_ids'=>'',
					'status'=> '',
					'created_time'=> '',
					'client'=>[],
					'shipping_address'=>'',
					'note'=>'',
					'tax'=>Setting::g('TAX'),
					'comment'=>'',
					'category'=>'',
					'category_name'=>'',
					);
		$purchase_order['purchase_order_details']= array();
		for($i= 0; $i<5; $i++){
			$purchase_order['purchase_order_details'][]= array(
														'id'=> '',
														'purchase_order_id'=> '',
														'item_number'=>'',
														'line_number'=> '',
														'quantity'=> '',
														'uom'=> '',
														'part_id'=> '',
														'description'=> '',
														'revision'=> '',
														'drawing_id'=> '',
														'price'=> '',
														'revised_price'=> '',
														'discount'=> '',
														'delivery_date'=> '',
														'revised_date'=> '',
														'take_from_inventory'=> '',
														'status'=> '',
														'created_time'=> '',
														'existing_price'=> '',
														'part_code'=> '',
														'pulled_quantity'=>''
														);
		}
		unset($i);

		$purchase_order['purchase_order_items']= array();

		$result['purchase_order']= $purchase_order;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPurchaseOrderError(){
		$result= array();
		$purchase_order= array(
						'id'=> array(),
						'po_code'=> array(),
						'client_id'=> array(),
						'ship_via'=> array(),
						'order_date'=> array(),
						'delivery_date'=> array(),
						'entered_date'=> array(),
						'file_id'=> array(),
						'tmp_file_ids'=>array(),
						'status'=> array(),
						'created_time'=> array(),
						'customer_po'=>array(),
						'shipping_address'=>array(),
						'note'=>array(),
						'tax'=>array(),
						'comment'=>array(),
						'category'=>array(),
						);
					
		$purchase_order['purchase_order_details']= array();
		for($i= 0; $i< 5; $i++){
			$purchase_order['purchase_order_details'][]= array(
														'id'=> array(),
														'purchase_order_id'=> array(),
														'line_number'=> array(),
														'item_number'=>array(),
														'quantity'=> array(),
														'uom'=> array(),
														'part_id'=> array(),
														'description'=> array(),
														'revision'=> array(),
														'drawing_id'=> array(),
														'price'=> array(),
														'revised_price'=> array(),
														'discount'=> array(),
														'delivery_date'=> array(),
														'revised_date'=>array(),
														'take_from_inventory'=> array(),
														'status'=> array(),
														'created_time'=> array(),
														'pulled_quantity'=> array(),
														);
		}
		unset($i);

		$purchase_order['purchase_order_items']= array();

		$result['purchase_order_error']= $purchase_order;
		$result['success']= true;
		return $result;
	}
	
	public static function create($data){

		$result= array();
		$purchase_order= new PurchaseOrder();
		$purchase_order->attributes= $data;
		$purchase_order->order_date= strtotime($data['order_date']);
		$purchase_order->delivery_date= strtotime($data['delivery_date']);
		$purchase_order->entered_date= strtotime($data['entered_date']);
		$purchase_order= PurchaseOrderService::beforeSave($purchase_order);
		
		$empty_purchase_order_error= PurchaseOrderService::getEmptyPurchaseOrderError();
		$result['purchase_order_error']= $empty_purchase_order_error['purchase_order_error'];
		$is_save= true;
		$purchase_order_details_number= 0;
		$purchase_order_details_save= array();

		if(isset($data['purchase_order_details']) && count($data['purchase_order_details'])>0){
			foreach ($data['purchase_order_details'] as $key => $detail) {
				if($detail['quantity']!= '' || $detail['part_id']!= '' || $detail['description']!= '' || $detail['price']!= '' || $detail['delivery_date']!= ''){
					$purchase_order_details_number++;
					$purchase_order_detail= new PurchaseOrderDetail();
					$purchase_order_detail->attributes= $detail;
					$purchase_order_detail->purchase_order_id= '1';
					$purchase_order_detail->delivery_date= strtotime($detail['delivery_date']);
					$purchase_order_detail->revised_date= strtotime($detail['revised_date']);
					$purchase_order_detail->status= 1;
					$purchase_order_detail->created_time= time();
					if($purchase_order_detail->validate()){
						$purchase_order_details_save[]= $purchase_order_detail;
					}
					else{
						$is_save= false;
						foreach ($purchase_order_detail->getErrors() as $error_key => $error_array) {
							$result['purchase_order_error']['purchase_order_details'][$key][$error_key]= $error_array;
						}
					}
				}
			}
			if($purchase_order_details_number==0){
				$is_save= false;
				$result['success']= false;
				$result['type']= 'alert';
				$result['message']= 'Kindly inputs mandetory fields';
				return $result;
			}
		}
		else{
			$is_save= false;
			$result['success']= false;
			$result['type']= 'alert';
			$result['message']= 'Kindly inputs mandetory fields';
			return $result;
		}
		
		if($purchase_order->validate()){
		}
		else{
			$is_save= false;
			foreach ($purchase_order->getErrors() as $key => $error_array) {
				$result['purchase_order_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Update purchase has some errors';
		}
		if($is_save){
			$purchase_order->save();
			//Save detail
			foreach ($purchase_order_details_save as $purchase_order_detail_save) {
				$purchase_order_detail_save->purchase_order_id= $purchase_order->id;
				$purchase_order_detail_save->save();
			}

			// Save other items
			if(isset($data['purchase_order_items']) && count($data['purchase_order_items'])>0){
				foreach ($data['purchase_order_items'] as $key => $item) {
					if($item['quantity']!= '' || $item['price']!= '' || $item['item_name']!= ''){
						$purchase_order_item= new PurchaseOrderItem();
						$purchase_order_item->attributes= $item;
						$purchase_order_item->purchase_order_id= $purchase_order->id;
						$purchase_order_item->status= 1;
						$purchase_order_item->save();
					}
				}
			}

			$result['success']= true;
			$purchase_order_array= PurchaseOrderService::getPurchaseOrderById(array('id'=>$purchase_order->id));
			$result['purchase_order']= $purchase_order_array['purchase_order'];
			$result['id']= $purchase_order->id;

			// Save history of order
			History::trackOthers($purchase_order, 'Order created');
		}
		else{
			$result['success']= false;
			$result['message']= 'Have some error!';
		}	
		
		return $result;
	}
	
	public static function update($data){
		$result= array();
		$purchase_order= PurchaseOrder::model()->findByPk((int)$data['id']);
		$purchase_order->attributes= $data;
		$purchase_order->order_date= strtotime($data['order_date']);
		$purchase_order->delivery_date= strtotime($data['delivery_date']);
		$purchase_order->entered_date= strtotime($data['entered_date']);
		$purchase_order= PurchaseOrderService::beforeSave($purchase_order);
		
		$empty_purchase_order_error= PurchaseOrderService::getEmptyPurchaseOrderError();
		$result['purchase_order_error']= $empty_purchase_order_error['purchase_order_error'];
		$is_save= true;
		$purchase_order_details_number = 0;
		$purchase_order_details_save = array();
		$purchase_order_detail_ids = array();
		if(isset($data['purchase_order_details']) && count($data['purchase_order_details'])>0){
			foreach ($data['purchase_order_details'] as $key => $detail) {
				if($detail['quantity']!= '' || $detail['part_id']!= '' || $detail['price']!= '' || $detail['delivery_date']!= ''){
					$purchase_order_details_number++;

					if($detail['id']!= ''){
						$purchase_order_detail= PurchaseOrderDetail::model()->findByPk((int)$detail['id']);
					}
					else{
						$purchase_order_detail= new PurchaseOrderDetail();
						$purchase_order_detail->created_time= time();
					}
					$purchase_order_detail->attributes= $detail;
					$purchase_order_detail->purchase_order_id= '1';
					$purchase_order_detail->delivery_date= strtotime($detail['delivery_date']);
					$purchase_order_detail->revised_date= strtotime($detail['revised_date']);
					$purchase_order_detail->status= 1;
					
					if($purchase_order_detail->validate()){
						$purchase_order_details_save[]= $purchase_order_detail;
						$purchase_order_detail_ids[] = $purchase_order_detail->id;
					}
					else{
						$is_save= false;
						foreach ($purchase_order_detail->getErrors() as $error_key => $error_array) {
							$result['purchase_order_error']['purchase_order_details'][$key][$error_key]= $error_array;
						}
					}

					// Delete unused purchase order detail
					if(isset($data['delete_purchase_order_detail_ids'])){
						$criteria = new CDbCriteria();
						$criteria->addInCondition('id', $data['delete_purchase_order_detail_ids']);
						PurchaseOrderDetail::model()->deleteAll($criteria);
					}
				}
			}
			if($purchase_order_details_number==0){
				$is_save= false;
				$result['success']= false;
				$result['type']= 'alert';
				$result['message']= 'Kindly inputs mandetory fields';
				return $result;
			}
		}
		else{
			$is_save= false;
		}
		
		if($purchase_order->validate()){
		}
		else{
			$is_save= false;
			foreach ($purchase_order->getErrors() as $key => $error_array) {
				$result['purchase_order_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Update purchase has some errors';
		}
		if($is_save){
			$purchase_order->save();

			// Save details
			foreach ($purchase_order_details_save as $purchase_order_detail_save) {
				$purchase_order_detail_save->purchase_order_id= $purchase_order->id;
				$purchase_order_detail_save->save();
			}


			// Save other items
			if(isset($data['purchase_order_items'])){
				//Remove all purchase_order_item
				$criteria = new CDbCriteria();
				$criteria->compare('purchase_order_id', $data['id']);
				PurchaseOrderItem::model()->deleteAll($criteria);

				foreach ($data['purchase_order_items'] as $key => $item) {
					if($item['quantity']!= '' || $item['price']!= '' || $item['item_name']!= ''){
						if($item['id']!= ''){
							$purchase_order_item = PurchaseOrderItem::model()->findByPk((int)$item['id']);
							if(isset($purchase_order_item)){
								$purchase_order_item->price = $item['price'];
								$purchase_order_item->quantity = $item['quantity'];
								$purchase_order_item->item_name = $item['item_name'];
								$purchase_order_item->save();
							}
							else{
								$purchase_order_item= new PurchaseOrderItem();
								$purchase_order_item->status= 1;
								$purchase_order_item->attributes= $item;
								$purchase_order_item->purchase_order_id= $purchase_order->id;
								$purchase_order_item->save();
							}
						}
						else{
							$purchase_order_item= new PurchaseOrderItem();
							$purchase_order_item->status= 1;
							$purchase_order_item->attributes= $item;
							$purchase_order_item->purchase_order_id= $purchase_order->id;
							$purchase_order_item->save();
						}
					}
				}
			}

			$result['success']= true;
			$purchase_order_array= PurchaseOrderService::getPurchaseOrderById(array('id'=>$purchase_order->id));
			$result['purchase_order']= $purchase_order_array['purchase_order'];
			$result['id']= $purchase_order->id;

			// Save history of order
			History::trackOthers($purchase_order, 'Order updated');
		}
		else{
			$result['success']= false;
			$result['message']= 'Have some error!';
		}	
		
		return $result;
	}
	
	public static function beforeSave($material){
		if($material->isNewRecord){
			$material->created_time= time();
		}
		$material->status= 1;
		return $material;
	}
	
	public static function convertListPurchaseOrder($purchase_orders, $data){
		$result= array();
		if($purchase_orders!= null && count($purchase_orders)>0){
			foreach($purchase_orders as $purchase_order){
				$result[]= self::convertPurchaseOrder($purchase_order);
			}
		}
		return $result;
	}
	
	public static function convertPurchaseOrder($purchase_order){
		$result= array(
					'id'=> $purchase_order->id,
					'po_code'=> $purchase_order->po_code,
					'client_id'=> $purchase_order->client_id,
					'ship_via'=> $purchase_order->ship_via,
					'order_date'=> date('Y-m-d', $purchase_order->order_date),
					'entered_date'=> date('Y-m-d', $purchase_order->entered_date),
					'delivery_date'=> date('Y-m-d', $purchase_order->delivery_date),
					'file_id'=> $purchase_order->file_id,
					'tmp_file_ids'=>$purchase_order->tmp_file_ids,
					'status'=> $purchase_order->status,
					'created_time'=> $purchase_order->created_time,
					'customer_po'=> $purchase_order->customer_po,
					'shipping_address'=>$purchase_order->shipping_address,
					'note'=>$purchase_order->note,
					'tax'=>$purchase_order->tax,
					'comment'=>$purchase_order->comment,
					'category'=>(int)$purchase_order->category,
					'category_name'=>$purchase_order->categoryName,
					);
		$result['client']= array();
		$get_client_by_id= ClientService::getClientById(array('id'=> $purchase_order->client_id));
		$result['client']= $get_client_by_id['client'];

		$result['purchase_order_items'] = array();
		$purchase_order_items = array();
		$purchase_order_items = PurchaseOrderItem::model()->findAllByAttributes(array('purchase_order_id'=> $purchase_order->id));
		if($purchase_order_items!= null && count($purchase_order_items)>0){
			foreach ($purchase_order_items as $key => $purchase_order_item) {
				$result['purchase_order_items'][]= array(
													'id'=> $purchase_order_item->id,
													'item_name'=> $purchase_order_item->item_name,
													'price'=> $purchase_order_item->price,
													'quantity'=> $purchase_order_item->quantity,
													);
			}
		}

		$result['purchase_order_details']= array();
		$purchase_order_details= PurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id'=> $purchase_order->id, 'status'=> 1));
		if($purchase_order_details!= null && count($purchase_order_details)>0){
			foreach ($purchase_order_details as $key => $purchase_order_detail) {
				$part= Part::model()->findByPk($purchase_order_detail->part_id);

				$result['purchase_order_details'][]= array(
													'id'=> $purchase_order_detail->id,
													'item_number'=> $purchase_order_detail->item_number,
													'purchase_order_id'=> $purchase_order_detail->purchase_order_id,
													'quantity'=> $purchase_order_detail->quantity,
													'part_id'=> $purchase_order_detail->part_id,
													'drawing_id'=> $purchase_order_detail->drawing_id,
													'price'=> ($purchase_order_detail->price==0)?'':$purchase_order_detail->price,
													'revised_price'=> ($purchase_order_detail->revised_price==0)?'':$purchase_order_detail->revised_price,
													'discount'=> $purchase_order_detail->discount,
													'delivery_date'=> date('Y-m-d', $purchase_order_detail->delivery_date),
													'revised_date'=> ($purchase_order_detail->revised_date == 0)?'':date('Y-m-d', $purchase_order_detail->revised_date),
													'part'=>PartService::convertPart($part),
													'existing_price'=>$part->getPrice($purchase_order_detail->quantity),
													'pulled_quantity'=>$purchase_order_detail->pulled_quantity,
													);
			}

			return $result;
		}
		else{
			return false;
		}
	}

	public static function convertPurchaseOrderDetail($purchase_order_detail){
		$part= Part::model()->findByPk($purchase_order_detail->part_id);

		$result = array(
						'id'=> $purchase_order_detail->id,
						'item_number'=>$purchase_order_detail->item_number,
						'purchase_order_id'=> $purchase_order_detail->purchase_order_id,
						'quantity'=> $purchase_order_detail->quantity,
						'part_id'=> $purchase_order_detail->part_id,
						'drawing_id'=> $purchase_order_detail->drawing_id,
						'price'=> $purchase_order_detail->price,
						'revised_price'=> $purchase_order_detail->revised_price,
						'discount'=> $purchase_order_detail->discount,
						'delivery_date'=> date('Y-m-d', $purchase_order_detail->delivery_date),
						'revised_date'=> date('Y-m-d', $purchase_order_detail->revised_date),
						'part'=>PartService::convertPart($part),
						'existing_price'=>$part->getPrice($purchase_order_detail->quantity),
						'pulled_quantity'=>$purchase_order_detail->pulled_quantity,
					);

		return $result;
	}

	public static function preview($data){
		$option = isset($data['option'])?$data['option']:"";

		$purchase_order = PurchaseOrder::model()->findByPk($data['id']);
		if(isset($purchase_order)){
			if(isset($purchase_order->client)){
				// Get client info
				$client = $purchase_order->client;

				// Create detail PO html
				$criteria = new CDbCriteria();
				$criteria->compare('purchase_order_id', $purchase_order->id);
				$list_po_detail = PurchaseOrderDetail::model()->findAll($criteria);

				$criteria = new CDbCriteria();
				$criteria->compare('purchase_order_id', $purchase_order->id);
				$list_po_items = PurchaseOrderItem::model()->findAll($criteria);

				$detail = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_purchase_order_pdf_template.php', array(
					'purchase_order'=>$purchase_order, 
					'list_po_detail'=>$list_po_detail,
					'list_po_items'=>$list_po_items,
					'option'=>$option
				),true, true);

				$result = array(
					'success'=>true,
					'order_preview'=> array(
						'content'=> $detail,
						'option'=>$option,
						'title'=>($option=='revise')?'Preview Order Revised Confirmation':'Preview Order Confirmation'
					)
				);
			}
			else{
				$result = array(
					'success'=>false,
					'message'=>'Can not find client of this Order!'
				);
			}
		}

		return $result;
	}

	public static function summary($data){
		$result= array();
		$get_empty_purchase_order= PurchaseOrderService::getEmptyPurchaseOrder();
		if(isset($data['id']) && $data['id']!= ''){
			$purchase_order= PurchaseOrderService::getPurchaseOrderById(array('id'=> $data['id']));
			if($purchase_order['success']== true){
				$result['purchase_order']= $purchase_order['purchase_order'];
				$result['po_code']= $purchase_order['purchase_order']['po_code'];
				$result['client_name']= $purchase_order['purchase_order']['client']['name'];

				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['purchase_order']= $get_empty_purchase_order['purchase_order'];

				$result['po_code']= '';
				$result['client_name']= '';
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['purchase_order']= $get_empty_purchase_order['purchase_order'];

			$result['po_code']= '';
			$result['client_name']= '';
			$result['is_update']= false;
			$result['is_create']= true;
		}
		$result['purchase_order_empty']= $get_empty_purchase_order['purchase_order'];
		$get_empty_purchase_order_error= PurchaseOrderService::getEmptyPurchaseOrderError();
		$result['purchase_order_error']= $get_empty_purchase_order_error['purchase_order_error'];
		$result['purchase_order_error_empty']= $get_empty_purchase_order_error['purchase_order_error'];

		$result['success']= true;
		return $result;
	}

	public static function checkout($data){
		$success = true;
		$result= array();

		if(isset($data['purchase_order_details'])){
			$purchase_order_details = $data['purchase_order_details'];
			$i = 0; $j = 0;
			foreach($purchase_order_details as $purchase_order_detail){
				if(isset($purchase_order_detail['id']) && $purchase_order_detail['id'] != ''){
					if($purchase_order_detail['take_from_inventory'] == 1){
						if($purchase_order_detail['inventory_after_order'] >= 0){
							$part = Part::model()->findByPk($purchase_order_detail['part_id']);
							if(isset($part)){
								$part->inventory_on_hand = $purchase_order_detail['inventory_after_order'];
								if($part->save()){
									$result['message'][$part->part_code] = 'Stock-in-hand updated!';

									$purchase_order_details[$i]['part'] = PartService::convertPart($part);
								}
								else{
									$success = false;
									$result['message'][$part->part_code] = CHtml::errorSummary($part);
								}
							}
						}
						else{
							$success = false;
							$part_code = $purchase_order_detail['part']['part_code'];
							$result['message'][$part_code] = 'Stock-in-hand is not enough!';
						}

						$j++;
					}
				}

				$i++;
			}

			// Convert message to html
			$messages = '';

			if($j > 0){
				foreach($result['message'] as $part_code => $message){
					$messages = '<p>Part "'.$part_code.'" : '.$message.'</p>';
				}
			}
			else{
				$success = false;
				$messages = 'You must select at least one Part to "Take from Inventory"!';
			}

			$result['message'] = $messages;
			$result['success']= $success;
			$result['purchase_order_details'] = $purchase_order_details;

		}
		else{
			$success = false;
			$messages = 'Invalid request!';
			$result['message'] = $messages;
			$result['success']= $success;
		}

		return $result;
	}

	public static function generateCertificate($data){
		$checkout = InOutPart::model()->findByPk($data['checkout_id']);
		$purchase_order_code = $data['purchase_order_code'];

		$list_pdf_file = array();

		if(isset($checkout)){
			foreach($checkout->heatnumbers as $heatnumber){
				// Check whether file exists
				$heatnumber_converted = preg_replace('/\s+/', '_', $heatnumber->heatnumber);
				$part_code_converted = preg_replace('/\s+/', '_', $checkout->part->part_code);
				$coc_file = 'COC_'.$part_code_converted.'_'.$heatnumber_converted.'_'.date('Ymd', $checkout->created_time).'_'.$checkout->id;
				$check_file = $coc_file;
				$i = 1;
				while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
					$check_file = $coc_file.'_'.$i;
					$i++;
				}

				$coc_file = $check_file;

				// Create pdf
				$detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_coc_pdf_template.php', array(
					'part_code'=>$checkout->part->part_code,
					'part_description'=>$checkout->part->description, 
					'purchase_order_code'=>$purchase_order_code,
					'checkout_quantity'=>$checkout->quantity,
					'heatnumber'=>$heatnumber,
				),true, true);
				iPhoenixUrl::exportPdfFromHTML($detail_pdf, $coc_file, 'landscape');

				$list_pdf_file[] = Yii::app()->baseUrl.'/data/pdf/'.$coc_file.'.pdf';
			}

			// Save files to checkout db
			$checkout->coc_files = json_encode($list_pdf_file);
			$checkout->saveAttributes(array('coc_files'));

			// Return results
			$success = true;
			$message = '<ul>';
			foreach($list_pdf_file as $pdf_file){
				$message = $message.'<li><a href="'.$pdf_file.'" target=_blank>'.$coc_file.'.pdf</a></li>';
			}
			$message = $message.'</ul>';
			$result['message'] = $message;
			$result['success'] = $success;
			$result['coc_files'] = $list_pdf_file;

		}
		else{
			$success = false;
			$messages = 'Invalid request!';
			$result['message'] = $messages;
			$result['success']= $success;
		}

		return $result;
	}

	public static function getAllCategory(){
		$result = array(
			'success'=>true,
			'purchase_order_categories'=>PurchaseOrder::$category_list
		);

		return $result;
	}
}
