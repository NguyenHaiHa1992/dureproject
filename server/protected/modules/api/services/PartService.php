<?php
class PartService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_part= PartService::getEmptyPart();
		if(isset($data['id']) && $data['id']!= ''){
			$part= PartService::getPartById(array('id'=> $data['id']));
			if($part['success']== true){
				$result['part']= $part['part'];
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['part']= $get_empty_part['part'];
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['part']= $get_empty_part['part'];
			$result['is_update']= false;
			$result['is_create']= true;
		}
		
		$result['part_empty']= $get_empty_part['part'];
		$get_empty_part_error= PartService::getEmptyPartError();
		$result['part_error']= $get_empty_part_error['part_error'];
		$result['part_error_empty']= $get_empty_part_error['part_error'];

		$get_all_part_categories= PartCategoryService::getAll(array());
		$result['part_categories']= $get_all_part_categories['part_categories'];

		$get_all_uoms= UomService::getAll(array());
		$result['uoms']= $get_all_uoms['uoms'];

		$get_all_machines= MachineService::getAll(array());
		$result['machines']= $get_all_machines['machines'];

		//$get_all_materials= MaterialService::getAll(array());
		//$result['materials']= $get_all_materials['materials'];

		$get_all_locations= PartLocationService::getAll(array());
		$result['locations']= $get_all_locations['locations'];

		// $list_purchase_order = PurchaseOrder::model()->findAll();
		// $purchase_orders = array();
		// foreach($list_purchase_order as $purchase_order){
		// 	$purchase_orders[] = array(
		// 		'id'=>$purchase_order->id,
		// 		'po_code'=>$purchase_order->po_code,
		// 	);
		// }

		// $result['purchase_orders']= $purchase_orders;

		//$get_all= PartService::getAll(array());
		//$result['parts']= $get_all['parts'];

		// $employees = EmployeeService::getAll(array());
		// $result['employees'] = $employees['employees'];

		$file_categories = FileCategoryService::getAll(array());
		$result['file_categories'] = $file_categories['file_categories'];

		$result['success']= true;
		return $result;
	}

	public static function listInit($data){
		$result= array();

		// $employees = EmployeeService::getAll(array());
		// $result['employees'] = $employees['employees'];

		// $list_purchase_order = PurchaseOrder::model()->findAll();
		// $purchase_orders = array();
		// foreach($list_purchase_order as $purchase_order){
		// 	$purchase_orders[] = array(
		// 		'id'=>$purchase_order->id,
		// 		'po_code'=>$purchase_order->po_code,
		// 	);
		// }

		// $result['purchase_orders']= $purchase_orders;

		$result['success']= true;
		return $result;
	}

	public static function detailInit($data){//$data['id']
		$result= array();
		$get_empty_part= PartService::getEmptyPart();
		$result['part_empty']= $get_empty_part['part'];
		$get_empty_part_error= PartService::getEmptyPartError();
		$result['part_error']= $get_empty_part_error['part_error'];
		$get_all_part_categories= PartCategoryService::getAll(array());
		$result['part_categories']= $get_all_part_categories['part_categories'];
		$get_all_machines= MachineService::getAll(array());
		$result['machines']= $get_all_machines['machines'];
		$get_all_materials= MaterialService::getAll(array());
		$result['materials']= $get_all_materials['materials'];
		$get_part_by_id= PartService::getPartById(array('id'=>$data['id']));
		$result['part']= $get_part_by_id['part'];
		//$get_all= PartService::getAll(array());
		$result['parts']= $get_all['parts'];
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Part::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		
		$sql= '';
		$sql_left_join= '';
		$sql_order_by= '';
		if($data['sort_attribute']== 'category_id'){
			$sql_left_join='
							Left Join (
							   				Select tbl_part_category.id,tbl_part_category.name From tbl_part_category
							   			)category
							On tbl_part.category_id= category.id
						';
			$sql_order_by='Order By category.name '.$data['sort_type']; 
		}
		elseif($data['sort_attribute']== 'machine_id'){
			$sql_left_join='
							Left Join (
							   				Select tbl_machine.id,tbl_machine.name From tbl_machine
							   			)machine
							On tbl_part.machine_id= machine.id
						';
			$sql_order_by='Order By machine.name '.$data['sort_type'];
		}
		elseif($data['sort_attribute']== 'material_id'){
			$sql_left_join='
							Left Join (
							   				Select tbl_material.id,tbl_material.material_code From tbl_material
							   			)material
							On tbl_part.material_id= material.id
						';
			$sql_order_by='Order By material.material_code '.$data['sort_type'];
		}
		else{
			$sql_left_join='';
			$sql_order_by='Order By tbl_part.'.$data['sort_attribute'].' '.$data['sort_type'];
		}
		
		$sql= "Select tbl_part.*
			   From tbl_part";
		$sql= $sql.$sql_left_join;
		$sql= $sql."
			   		Where 1 ";
		
		if(isset($data['part_code']) && $data['part_code']!= ''){
			$sql= $sql."And tbl_part.part_code LIKE '%".$data['part_code']."%'";
		}

		if(isset($data['category_id']) && $data['category_id']!= ''){
			$sql= $sql."And tbl_part.category_id = ".$data['category_id']." ";
		}

		if(isset($data['description']) && $data['description']!= ''){
			$sql= $sql."And tbl_part.description LIKE '%".$data['description']."%' ";
		}

		if(isset($data['client_id']) && $data['client_id']!= ''){
			$sql= $sql."And tbl_part.client_id = ".$data['client_id']." ";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$parts= Part::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['part_code']) && $data['part_code']!= ''){
			$criteria->compare('part_code', $data['part_code'], true);
		}
		if(isset($data['category_id']) && $data['category_id']!= ''){
			$criteria->compare('category_id', $data['category_id']);
		}
		if(isset($data['description']) && $data['description']!= ''){
			$criteria->compare('description', $data['description'], true);
		}
		if(isset($data['client_id']) && $data['client_id']!= ''){
			$criteria->compare('client_id', $data['client_id']);
		}
		$total= Part::model()->count($criteria);
		
		if($parts!= null){
			$result['success']= true;
			$result['parts']=self::convertListPart($parts, $data);
			
			$result['totalresults']= $total;
			$result['start_part']= (int)$data['limitstart']+ 1;
			$result['end_part']= (int)$data['limitstart']+ count($parts);
		}
		else{
			$result['success']= true;
			$result['parts']= array();
			$result['totalresults']= $total;
			$result['start_part']= 0;
			$result['end_part']= 0;
		}

		// Get Part locations list
		$get_all_locations= PartLocationService::getAll(array());
		$result['locations']= $get_all_locations['locations'];

		return $result;
	}

	public static function getAllPartCode($data){//data là thông tin phân trang
		$result = array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(Part::model()->findAll());
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_part.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_part.id, tbl_part.part_code
			   From tbl_part";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['part_code']) && $data['part_code']!= ''){
			$sql= $sql."And tbl_part.part_code LIKE '%".$data['part_code']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$parts = Part::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['part_code']) && $data['part_code']!= ''){
			$criteria->compare('part_code', $data['part_code'], true);
		}
		$total = Part::model()->count($criteria);

		if($parts!= null){
			$converted_parts = array();
			foreach($parts as $part){
				$converted_parts[] = array(
					'id'=>$part->id,
					'part_code'=>$part->part_code,
				);
			}

			$result['success']= true;
			$result['parts']=$converted_parts;
			$result['totalresults']= $total;
			$result['start_part']= (int)$data['limitstart']+ 1;
			$result['end_part']= (int)$data['limitstart']+ count($parts);
		}
		else{
			$result['success']= true;
			$result['parts']= array();
			$result['totalresults']= $total;
			$result['start_part']= 0;
			$result['end_part']= 0;
		}

		return $result;
	}

	public static function getEmptyPart(){
		$result= array();
		$part= array(
					'id'=> '',
					'part_code'=> '',
					'category_id'=> '',
					'description'=> '',
					'design'=> '',
					'revision'=> '',
					'uom_id'=> '',
					'price'=> '',
					'quantity'=>'',
					'optimum_inventory'=> '',
					'inventory_on_hand'=> '',
					'notes'=> '',
					'location'=> '',
					'shop_floor'=> '',
					'material_id'=> '',
					'material'=> array(
						'sizes'=>array(),
						'shape_img_src'=>''
					),
					'bar_length_pc'=> '',
					'bars_needed'=> '',
					'slug_length'=> '',
					'heat_code'=> '',
					'designation'=> '',
					'status'=> '0',
					'created_time'=> '',
					'tmp_file_ids'=>'',
					'drawing_file_id'=>'',
					'prices'=>array(),
					'arr_machine_ids'=> array(),
					'arr_location_ids'=> array(),
					'bar_length'=>'',
					'part_length'=>'',
					'heatnumbers'=> array(),
					'drawing'=>'',
					'client_id'=>'',
					'client'=> array(
						'name'=>''
					)
				);

		if($first_part_category= PartCategory::model()->find())
			$part['category_id']= $first_part_category->id;
		
		$result['part']= $part;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyPartError(){
		$result= array();
		$part= array(
					'id'=> array(),
					'part_code'=> array(),
					'category_id'=> array(),
					'description'=> array(),
					'design'=> array(),
					'revision'=> array(),
					'uom_id'=> array(),
					'price'=> array(),
					'quantity'=> array(),
					'optimum_inventory'=> array(),
					'inventory_on_hand'=> array(),
					'notes'=> array(),
					'location'=> array(),
					'shop_floor'=> array(),
					'material_id'=> array(),
					'bar_length_pc'=> array(),
					'bars_needed'=> array(),
					'slug_length'=> array(),
					'heat_code'=> array(),
					'designation'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'tmp_file_ids'=>array(),
					'drawing_file_id'=>array(),
					'prices'=>array(),
					'arr_machine_ids'=>array(),
					'arr_location_ids'=>array(),
					'bar_length'=>array(),
					'part_length'=>array(),
					'drawing'=>array(),
					'client_id'=>array(),
				);
		
		$result['part_error']= $part;
		$result['success']= true;
		return $result;
	}

	public static function getPartById($data){
		$result= array();
		$get_empty_part_error= PartService::getEmptyPartError();
		$result['part_error']= $get_empty_part_error['part_error'];
		$get_all_part_categories= PartCategoryService::getAll(array());
		$result['part_categories']= $get_all_part_categories['part_categories'];
		$get_all_machines= MachineService::getAll(array());
		$result['machines']= $get_all_machines['machines'];
		$get_all_materials= MaterialService::getAll(array());
		$result['materials']= $get_all_materials['materials'];

		$part= Part::model()->findByPk((int)$data['id']);

		if($part!= null){
			$result['success']= true;
			$result['part']= self::convertPart($part);
		}
		else{
			$result['success']= false;
			$result['message']= 'Part\'s not found!';
		}
		return $result;
	}

	public static function getPartsByCategoryId($data){//data['id']
		$result= array();
		$parts= Part::model()->findAllByAttributes(array('category_id'=>$data['id']));
		if($parts!= null && count($parts)>0){
			$result['success']= true;
			$result['parts']= self::convertListPart($parts, $data);
		}
		else{
			$result['success']= true;
			$result['parts']= array();
		}
		return $result;
	}

	public static function getPriceRangeById($id){
		$result= array();
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $id);
		$criteria->order = 'max desc, id desc';
		$prices = PartPrice::model()->findAll($criteria);

		if($prices!= null){
			$result = self::convertListPriceRange($prices);
		}
		else
			$result = array();

		return $result;
	}

	public static function getListUptoById($id){
		$result= array();
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $id);
		$criteria->order = 'max desc, id desc';
		$prices = PartPrice::model()->findAll($criteria);
		$list = array();
		if($prices!= null){
			foreach($prices as $price)
				$list[] = $price->max;
			$result = implode(',', $list);
		}
		else
			$result = '';

		return $result;
	}

	public static function getListPriceById($id){
		$result= array();
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $id);
		$criteria->order = 'price asc, id desc';
		$prices = PartPrice::model()->findAll($criteria);
		$list = array();
		if($prices!= null){
			foreach($prices as $price)
				$list[] = $price->price;
			$result = implode(',', $list);
		}
		else
			$result = '';

		return $result;
	}

	public static function getEmailTemplateByName($data){
		$result= array();
		$email_template;
		$email_template= EmailTemplate::model()->findByAttributes(array('name'=>$data['name']));
		if($email_template!= null){
			$result['success']= true;
			$result['email_template']= self::convertEmailTemplate($email_template);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại Email Template này!';
		}
		return $result;
	}

	public static function create($data){
		$result= array();
		$part= new Part();
		$part->attributes= $data;
		$part->notes= $data['notes'];
		$part->heatnumbers = $data['heatnumbers'];

		$part= PartService::beforeSave($part);
		if($part->validate()){
			if($part->save()){
				//Save part price range
				foreach ($data['prices'] as $index=>$price) {
					if(!isset($price['id']) || $price['id'] == ''){
						$price_range = new PartPrice();
						$price_range->part_id = $part->id;
						$price_range->max = (int)$price['max'];
						$price_range->price = $price['price'];
						$price_range->save();
					}
					else{
						$price_range = PartPrice::model()->findByPk($price['id']);
						if(isset($price_range)){
							$price_range->max = (int)$price['max'];
							$price_range->price = $price['price'];
							$price_range->save();
						}
					}
				}

				$result['success']= true;
				$result['id']= $part->id;
				$new_part= self::getPartById(array('id'=> $part->id));
				$result['part']= $new_part['part'];
			}
		}
		else{
			$empty_part_error= PartService::getEmptyPartError();
			$result['part_error']= $empty_part_error['part_error']; 
			foreach ($part->getErrors() as $key => $error_array) {
				$result['part_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= CHtml::errorSummary($part);
			$result['error_array']= $part->getErrors();
		}
		
		return $result;
	}
	
	
	public static function update($data){
		$result= array();
		$part= Part::model()->findByPk((int)$data['id']);
		$part->attributes= $data;
		$part->notes= $data['notes'];
		$part->heatnumbers = $data['heatnumbers'];

		$part= PartService::beforeSave($part);
		if($part->validate()){
			if($part->save()){
				//Save part price range
				foreach ($data['prices'] as $index=>$price) {
					if(!isset($price['id']) || $price['id'] == ''){
						$price_range = new PartPrice();

						$price_range->part_id = $part->id;
						$price_range->max = (int)$price['max'];
						$price_range->price = $price['price'];
						if(!$price_range->save()){
							echo(CHtml::errorSummary($price_range));
						}
					}
					else{
						$price_range = PartPrice::model()->findByPk($price['id']);
						if(isset($price_range)){
							$price_range->max = $price['max'];
							$price_range->price = $price['price'];
							$price_range->save();
						}
					}
				}

				$result['success']= true;
				$part_array= PartService::getPartById(array('id'=>$part->id));
				$get_empty_part_error= PartService::getEmptyPartError();
				$result['part_error']= $get_empty_part_error['part_error'];
				$result['part']= $part_array['part'];
				$result['id']= $part->id;
			}
			else{
				$result['success']= false;
				$result['message'] = CHtml::errorSummary($part);
			}
		}
		else{
			$empty_part_error= PartService::getEmptyPartError();
			$result['part_error']= $empty_part_error['part_error']; 
			foreach ($part->getErrors() as $key => $error_array) {
				$result['part_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= CHtml::errorSummary($part);
			$result['error_array']= $part->getErrors();
		}
		
		return $result;
	}
	
	public static function delete($data){
		$result= array();
		$email_template= EmailTemplate::model()->findByPk((int)$data['id']);
		if($email_template->delete()){
			$email_template_files= EmailTemplateFile::model()->findAllByAttributes(array('email_template_id'=> $email_template->id));
			if(count($email_template_files)>0){
				foreach ($email_template_files as $key => $email_template_file) {
					$email_template_file->delete();
				}
			}
			$result['success']= true;
		}
		else
			$result['success']= false;
		return $result;
	}
	
	
	
	public static function beforeSave($part){
		if($part->isNewRecord){
			$part->created_time= time();
		}
		$part->status= 1;
		return $part;
	}
	
	public static function convertListPart($parts, $data){
		$result= array();
		if($parts!= null && count($parts)>0){
			foreach($parts as $part){
				$result[]= self::convertPart($part);
			}
		}
		return $result;
	}
	
	public static function convertPart($part){
		$drawing_file = array();
		if(isset($part->drawing_file)){
			$file = $part->drawing_file;
			$drawing_file = array(
				'id'=>$file->id,
				'filename'=>$file->filename,
				'url'=>FileService::getAbsoluteUrl($part->id),
			);
		}

		$result= array(
					'id'=> $part->id,
					'part_code'=> $part->part_code,
					'category_id'=> $part->category_id,
					'description'=> $part->description,
					'design'=> $part->design,
					'revision'=> $part->revision,
					'uom_id'=> $part->uom_id,
					'uom_name'=> isset($part->uom)?$part->uom->name:"N/A",
					'price'=> $part->price,
					'quantity'=> $part->quantity,
					'optimum_inventory'=> $part->optimum_inventory,
					'inventory_on_hand'=> $part->inventory_on_hand,
					'notes'=> $part->notes,
					'location'=> $part->location,
					'shop_floor'=> $part->shop_floor,
					'material_id'=> $part->material_id,
					'material_code'=>isset($part->material)?$part->material->material_code:"N/A",
					'material'=> array(
						'sizes'=> isset($part->material)?$part->material->sizes: array(),
						'shape_id'=> isset($part->material)?$part->material->shape_id: '',
						'shape_img_src' => isset($part->material)?$part->material->getShapeImage(): '',
					),
					'bar_length_pc'=> $part->bar_length_pc,
					'bars_needed'=> $part->bars_needed,
					'slug_length'=> $part->slug_length,
					'heat_code'=> $part->heat_code,
					'designation'=> $part->designation,
					'status'=> $part->status,
					'created_time'=> $part->created_time,
					'tmp_file_ids'=>$part->tmp_file_ids,
					'drawing_file_id'=>$part->drawing_file_id,
					'drawing_file'=>$drawing_file,
					'prices' => self::getPriceRangeById($part->id),
					'table_price' => $part->getTablePrice(),
					'table_info' => $part->getTableInformation(),
					'arr_machine_ids'=> $part->arr_machine_ids,
					'arr_location_ids'=> $part->arr_location_ids,
					'list_upto'=> '',
					'list_price'=> '',
					'bar_length'=>$part->bar_length,
					'part_length'=>$part->part_length,
					'drawing'=>$part->drawing,
					'client_id'=>$part->client_id,
					'client'=> array(
						'name'=>isset($part->client)?$part->client->name:"N/A"
					)
				);
		if($part->category!= null)
			$result['category_name']= $part->category->name;
		else
			$result['category_name']= null;

		if($part->material!= null)
			$result['material_code']= $part->material->material_code;
		else
			$result['material_code']= null;
		$is_enough_inventory= true;
		if($part->inventory_on_hand< $part->optimum_inventory)
			$is_enough_inventory= false;
		$result['is_enough_inventory']= $is_enough_inventory;

		$result['heatnumbers'] = $part->heatnumbers;

		return $result;
	}

	public static function convertListPriceRange($prices){
		$result= array();
		if($prices!= null && count($prices)>0){
			foreach($prices as $price){
				$result[]= self::convertPriceRange($price);
			}
		}
		return $result;
	}
	
	public static function convertPriceRange($price){
		$result= array(
					'id'=> $price->id,
					'price'=> $price->price,
					'max'=> $price->max,
					'is_edit' => false
		);
		return $result;
	}

	public static function updatePriceRange($data){
		$result= array();
		if(isset($data['id']) && $data['id'] != ''){
			$part_price = PartPrice::model()->findByPk((int)$data['id']);
			if(isset($part_price)){
				$part_price->attributes= $data;
				$part_price->price = $part_price->price;

				if($part_price->save()){
					$result['success'] = true;
					$result['price'] = $part_price->price;
					$result['message'] = 'Price range updated!';
				}
				else{
					$result['success']= false;
					$result['message']= CHtml::errorSummary($part_price);
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Can not find this price range';
			}
		}
		else{
			$part_price = new PartPrice();
			$part_price->attributes= $data;
			$part_price->price = $part_price->price;
			$part_price->part_id = $data['part_id'];

			if($part_price->save()){
				$result['success'] = true;
				$result['price'] = self::convertPriceRange($part_price);
				$result['message'] = 'Price range created!';
			}
			else{
				$result['success']= false;
				$result['message']= CHtml::errorSummary($part_price);
			}
		}
		
		return $result;
	}

	/*
	public static function updatePriceRanges($data){
		$result= array();
		if(isset($data['part_id']) && $data['part_id'] != ''){
			$list_upto = explode(',', $data['list_upto']);
			$list_price = explode(',', $data['list_price']);

			if(count($list_upto) == count($list_price)){
				$criteria = new CDbCriteria();
				$criteria->compare('part_id', (int)$data['part_id']);
				PartPrice::model()->deleteAll($criteria);

				$i = 0;
				foreach($list_upto as $upto){
					$part_price = new PartPrice();
					$part_price->max = (int)$upto;
					$part_price->price = (int)$list_price[$i];
					$part_price->part_id = (int)$data['part_id'];
					$part_price->save();
					$i++;
				}

				$result['success'] = true;
				$result['price'] = self::getPriceRangeById((int)$data['part_id']);
				$result['message'] = 'Price range updated!';
			}
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Please save your part before!';
		}

		return $result;
	}
	*/

	public static function removePriceRange($data){
		$result= array();
		$part_price = PartPrice::model()->findByPk((int)$data['id']);
		$part_price->attributes= $data;
		$part_price->price = $part_price->price;

		if($part_price->delete()){
			$result['success'] = true;
			$result['message'] = 'Price range deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($part_price);
		}
		
		return $result;
	}

	public static function getPrice($data){
		$result= array();
		$part = Part::model()->findByPk((int)$data['part_id']);
		if(isset($part)){
			$result['success'] = true;
			$result['price'] = $part->getPrice($data['qty']);
		}
		else{
			$result['success']= false;
			$result['message']= 'This part does not exist!';
		}
		
		return $result;
	}

	public static function getPriceTablePdf($data){
		$result= array();

		if(isset($data['part'])){
			$part = new Part();
			$part->attributes = $data['part'];
			$rfq_number = isset($data['rfq_number'])?$data['rfq_number']:"";
			$comment = isset($data['comment'])?$data['comment']:"";

			$detail = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_part_price_list_pdf_template.php', array(
				'part'=>$part, 
				'list_price'=>$data['part']['prices'],
				'rfq_number'=>$rfq_number,
				'comment'=>$comment
			),true, true);

			$result['success'] = true;
			$result['content'] = $detail;
		}
		else{
			$result['success']= false;
			$result['message']= 'Invalid Request!';
		}
		
		return $result;
	}

	/****** Heat number ******/
	public static function updateHeatnumber($data){
		$result= array();
		if(isset($data['id']) && $data['id'] != ''){
			$part_heatnumber = PartHeatnumber::model()->findByPk((int)$data['id']);
			if(isset($part_heatnumber)){
				$part_heatnumber->attributes= $data;

				if($part_heatnumber->save()){
					$result['success'] = true;
					$result['message'] = 'Heatnumber updated!';
					$result['id'] = $part_heatnumber->id;
				}
				else{
					$result['success']= false;
					$result['message']= CHtml::errorSummary($part_heatnumber);
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Can not find this Heatnumber';
			}
		}
		else{
			$part_heatnumber = new PartHeatnumber();
			$part_heatnumber->attributes= $data;
			$part_heatnumber->part_id = $data['part_id'];

			if($part_heatnumber->save()){
				$result['success'] = true;
				$result['message'] = 'Heatnumber created!';
				$result['id'] = $part_heatnumber->id;
			}
			else{
				$result['success']= false;
				$result['message']= CHtml::errorSummary($part_heatnumber);
			}
		}
		
		return $result;
	}

	public static function removeHeatnumber($data){
		$result= array();
		$part_heatnumber = PartHeatnumber::model()->findByPk((int)$data['id']);

		if(isset($part_heatnumber)){
			// Validate before delete heatnumber
			// Check in out history
			$criteria = new CDbCriteria();
			$criteria->addCondition('heatnumber_ids Like \'%"'.$part_heatnumber->id.'"%\'');
			$find = InOutPart::model()->count($criteria);
			if($find > 0){
				$result['success'] = false;
				$result['message'] = 'This Heatnumber can not be delete because It existed in Part In/Out History!';
				return $result;
			}

			// Delete heatnumber
			if($part_heatnumber->delete()){
				$result['success'] = true;
				$result['message'] = 'Heatnumber deleted!';
			}
			else{
				$result['success']= false;
				$result['message']= CHtml::errorSummary($part_heatnumber);
			}
		}

		return $result;
	}

	public static function checkIn($data){
		$errors = '';
		$result= array();
		$new_location_ids = array();

		if(isset($data['id']) && isset($data['check_in'])){
			$part = Part::model()->findByPk($data['id']);

			if(isset($part)){
				// Save check in
				$check_in = new InOutPart();
				$check_in->scenario = 'checkin';
				$check_in->attributes = $data['check_in'];
				$check_in->received_date = strtotime($check_in->received_date);
				$check_in->type = InOutPart::TYPE_CHECK_IN;
				$check_in->part_id = $data['id'];

				if($check_in->save()){
					// Find Heat numbers
					$heatnumbers = $check_in->heatnumbers;
					foreach($heatnumbers as $h){
						$heatnumber = PartHeatnumber::model()->findByPk($h->id);
						if(isset($heatnumber) && $heatnumber->part_id == $check_in->part_id){
							$heatnumber->quantity = $heatnumber->quantity + $h->quantity;
						}

						if(!$heatnumber->save()){
							$check_in->delete();
							$result = array(
								'success'=>false, 
								'message'=> CHtml::errorSummary($heatnumber)
							);

							return $result;
						}
						else{
							// Update heatnumber quantity detail
							if(!isset($h->quantity_details) || count($h->quantity_details) == 0){
								$check_in->delete();
								$result = array(
									'success'=>false, 
									'message'=> 'Heatnumber quantity detail can not empty'
								);
								return $result;
							}
							else{
								$quantity_details = $h->quantity_details;

								foreach($quantity_details as $quantity_detail){
									$location_id = $quantity_detail->location_id;
									$new_location_ids[] = $location_id; 
									$quantity = $quantity_detail->quantity;

									if($quantity > 0){
										$criteria = new CDbCriteria();
										$criteria->compare('location_id', $location_id);
										$criteria->compare('part_heatnumber_id', $heatnumber->id);
										$part_heatnumber_location = PartHeatnumberLocation::model()->find($criteria);

										if(isset($part_heatnumber_location)){
											$part_heatnumber_location->quantity = $part_heatnumber_location->quantity + $quantity;
											if(!$part_heatnumber_location->save()){
												$check_in->delete();
												$result = array(
													'success'=>false, 
													'message'=> CHtml::errorSummary($part_heatnumber_location)
												);

												return $result;
											}
										}
										else{
											$part_heatnumber_location = new PartHeatnumberLocation();
											$part_heatnumber_location->quantity = $quantity;
											$part_heatnumber_location->location_id = $location_id;
											$part_heatnumber_location->part_heatnumber_id = $heatnumber->id;
											if(!$part_heatnumber_location->save()){
												$check_in->delete();
												$result = array(
													'success'=>false, 
													'message'=> CHtml::errorSummary($part_heatnumber_location)
												);

												return $result;
											}
										}
									}
								}
							}
						}
					}

					if(strlen($errors) == 0){
						$total_quantity = 0;
						// Get list newest heatnumbers
						$criteria = new CDbCriteria();
						$criteria->compare('part_id', $part->id);
						$full_heatnumbers = PartHeatnumber::model()->findAll($criteria);
						$newest_heatnumbers = array();
						foreach($full_heatnumbers as $heatnumber){
							$newest_heatnumbers[] = array(
								'id'=>$heatnumber->id, 
								'part_id'=>$heatnumber->part_id,
								'heatnumber'=>$heatnumber->heatnumber, 
								'drawing'=>$heatnumber->drawing,
								'quantity'=>$heatnumber->quantity,
								'edit'=>false
							);

							//Update total quantity
							$total_quantity = $total_quantity + $heatnumber->quantity;
						}

						// Update Part Location 
						$new_location_ids = array_unique($new_location_ids);
						foreach($new_location_ids as $location_id){
							$criteria = new CDbCriteria();
							$criteria->compare('part_id', $part->id);
							$criteria->compare('location_id', $location_id);
							$criteria->select = array('id');
							$partlocation_part = PartLocationPart::model()->find($criteria);
							if(!isset($partlocation_part)){
								$partlocation_part = new PartLocationPart();
								$partlocation_part->part_id = $part->id;
								$partlocation_part->location_id = $location_id;
								$partlocation_part->save();
							}
						}

						$criteria = new CDbCriteria();
						$criteria->compare('part_id', $part->id);
						$criteria->select = array('id','location_id');
						$tmp_list = PartLocationPart::model()->findAll($criteria);
						$arr_location_ids = array();
						foreach($tmp_list as $tmp_item){
							if(!in_array($tmp_item->location_id, $arr_location_ids))
								$arr_location_ids[] = $tmp_item->location_id;
						}

						$result = array(
							'success'=>true, 
							'message'=>'Check In succeeded',
							'quantity'=>$total_quantity,
							'heatnumbers'=> $newest_heatnumbers,
							'arr_location_ids'=> $arr_location_ids
						);

					}
					else{
						$check_in->delete();
						$result = array('success'=>false, 'message'=> $errors);
					}
				}
				else{
					$result = array(
						'success'=>false, 
						'message'=>CHtml::errorSummary($check_in), 
						'check_in_part_error'=>$check_in->getErrors()
					);
				}
			}
		}
		
		return $result;
	}

	public static function checkOut($data){
		$errors = '';
		$result= array();
		if(isset($data['id']) && isset($data['check_out'])){
			$part = Part::model()->findByPk($data['id']);

			if(isset($part)){
				// Save check in
				$check_out = new InOutPart();
				$check_out->scenario = 'checkout';
				$check_out->attributes = $data['check_out'];
				$check_out->received_date = strtotime($check_out->received_date);
				$check_out->type = InOutPart::TYPE_CHECK_OUT;
				$check_out->part_id = $data['id'];
				
				$pulled_quantity = 0;

				if($check_out->save()){
					// Find Heat numbers
					$heatnumbers = $check_out->heatnumbers;

					$list_heatnumber = array();
					$list_h = array();

					// Check heatnumber enough to check out or not

					foreach($heatnumbers as $h){
						if(isset($h->id)){
							$heatnumber = PartHeatnumber::model()->findByPk($h->id);
							if(isset($heatnumber) && $heatnumber->part_id == $check_out->part_id){

								// Check whether enough to check out
								if($heatnumber->quantity >= $h->quantity){
									// Check location quantity detail before save heatnumber
									$check = true;

									if(!isset($h->quantity_details) || count($h->quantity_details) == 0){
										$check_out->delete();
										$result = array(
											'success'=>false, 
											'message'=> 'Sorry, Heatnumber quantity detail can not empty!', 
										);

										return $result;
									}
									else{
										$quantity_details = $h->quantity_details;

										foreach($quantity_details as $quantity_detail){
											$location_id = $quantity_detail->location_id;
											$quantity = $quantity_detail->quantity;

											if((int)$quantity > 0){
												$criteria = new CDbCriteria();
												$criteria->compare('location_id', $location_id);
												$criteria->compare('part_heatnumber_id', $heatnumber->id);
												$part_heatnumber_location = PartHeatnumberLocation::model()->find($criteria);

												if(isset($part_heatnumber_location)){
													if($part_heatnumber_location->quantity < $quantity){
														// If heatnumber location not enough, break foreach
														$check = false;
														break;
													}
												}
											}
										}
									}

									if($check){
										$heatnumber->quantity = $heatnumber->quantity - $h->quantity;

										// Save to array to save after
										$list_heatnumber[] = $heatnumber;
										$list_h[] = $h;

										$pulled_quantity = $pulled_quantity + $h->quantity;
									}
									else{
										$check_out->delete();
										$result = array(
											'success'=>false, 
											'message'=> 'Sorry, Heatnumber "'.$heatnumber->heatnumber.'" is not enough to check out!', 
										);

										return $result;
									}
								}
								else{
									$check_out->delete();
									$result = array(
										'success'=>false, 
										'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" is not enough to check out!', 
									);

									return $result;
								}
							}
						}
						else{
							$check_out->delete();
							$result = array(
								'success'=>false, 
								'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" not enough to check-out!', 
							);

							return $result;
						}
					}

					// Save to database
					$i_h = 0;
					foreach($list_heatnumber as $heatnumber){
						if(!$heatnumber->save()){
							$check_in->delete();
							$result = array(
								'success'=>false, 
								'message'=> CHtml::errorSummary($heatnumber)
							);

							return $result;
						}
						else{
							// Update heatnumber quantity detail
							$h = $list_h[$i_h];
							$quantity_details = $h->quantity_details;

							foreach($quantity_details as $quantity_detail){
								$location_id = $quantity_detail->location_id;
								$quantity = $quantity_detail->quantity;

								if((int)$quantity > 0){
									$criteria = new CDbCriteria();
									$criteria->compare('location_id', $location_id);
									$criteria->compare('part_heatnumber_id', $heatnumber->id);
									$part_heatnumber_location = PartHeatnumberLocation::model()->find($criteria);

									if(isset($part_heatnumber_location)){
										$part_heatnumber_location->quantity = $part_heatnumber_location->quantity - $quantity;
										if(!$part_heatnumber_location->save()){
											$check_in->delete();
											$result = array(
												'success'=>false, 
												'message'=> CHtml::errorSummary($part_heatnumber_location)
											);

											return $result;
										}
									}
									else{
										$check_in->delete();
										$result = array(
											'success'=>false, 
											'message'=> 'Can not find this location detail quantity'
										);

										return $result;
									}
								}
							}
						}

						$i_h++;
					}

					if(strlen($errors) == 0){
						$total_quantity = 0;

						// Get list newest heatnumbers
						$criteria = new CDbCriteria();
						$criteria->compare('part_id', $part->id);
						$full_heatnumbers = PartHeatnumber::model()->findAll($criteria);
						$newest_heatnumbers = array();
						foreach($full_heatnumbers as $heatnumber){
							$newest_heatnumbers[] = array(
								'id'=>$heatnumber->id, 
								'part_id'=>$heatnumber->part_id,
								'heatnumber'=>$heatnumber->heatnumber, 
								'drawing'=>$heatnumber->drawing,
								'quantity'=>$heatnumber->quantity,
								'edit'=>false
							);

							//Update total quantity
							$total_quantity = $total_quantity + $heatnumber->quantity;
						}

						$result = array(
							'success'=>true, 
							'message'=>'Check Out succeeded',
							'quantity'=>$total_quantity,
							'pulled_quantity'=>$pulled_quantity,
							'heatnumbers'=>$newest_heatnumbers,
							'checkout'=>array(
								'id'=>$check_out->id,
							)
						);
					}
					else{
						$check_out->delete();
						$result = array('success'=>false, 'message'=> $errors);
					}
				}
				else{
					$result = array(
						'success'=>false, 
						'message'=>CHtml::errorSummary($check_out), 
						'check_out_part_error'=>$check_out->getErrors()
					);
				}
			}
		}
		
		return $result;
	}

	// In Out Part
	public static function getInOutParts($data){
		$result = array();
		if(isset($data['part_id']) && $data['part_id'] != ''){
			$criteria = new CDbCriteria();
			$criteria->compare('part_id', $data['part_id']);
			$criteria->order = "id desc";
			$list = InOutPart::model()->findAll($criteria);
			$result['in_out_parts'] = self::convertListInOutPart($list);
			$result['success'] = true;
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid request';
		}

		return $result;
	}

	public static function getAllInOutPart($data){
		$result= array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= InOutPart::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_in_out_part.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_in_out_part.*
			   From tbl_in_out_part";
		$sql= $sql."
			   		Where 1 ";
		if(isset($data['purchase_order_id']) && $data['purchase_order_id']!= ''){
			$sql= $sql."And tbl_in_out_part.purchase_order_id = '".$data['purchase_order_id']."'";
		}

		if(isset($data['part_id']) && $data['part_id']!= ''){
			$sql= $sql."And tbl_in_out_part.part_id = '".$data['part_id']."'";
		}

		if(isset($data['type']) && $data['type']!= ''){
			$sql= $sql."And tbl_in_out_part.type = '".$data['type']."'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$inOutParts = InOutPart::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['purchase_order_id']) && $data['purchase_order_id']!= ''){
			$criteria->compare('purchase_order_id', $data['purchase_order_id']);
		}
		if(isset($data['part_id']) && $data['part_id']!= ''){
			$criteria->compare('part_id', $data['part_id']);
		}
		if(isset($data['type']) && $data['type']!= ''){
			$criteria->compare('type', $data['type']);
		}

		$total = InOutPart::model()->count($criteria);

		if($inOutParts!= null){
			$result['success']= true;
			$result['inOutParts']=self::convertListInOutPart($inOutParts, $data);
			$result['totalresults']= $total;
			$result['start_inOutPart']= (int)$data['limitstart']+ 1;
			$result['end_inOutPart']= (int)$data['limitstart']+ count($inOutParts);
		}
		else{
			$result['success']= true;
			$result['inOutParts']= array();
			$result['totalresults']= $total;
			$result['start_inOutPart']= 0;
			$result['end_inOutPart']= 0;
		}

		return $result;
	}

	public static function convertInOutPart($in_out_part){
		$result= array(
					'id'=> (int)$in_out_part->id,
					'type'=> (int)$in_out_part->type,
					'type_label'=> $in_out_part->getTypeLabel(),
					'received_date'=> date('Y-m-d', $in_out_part->received_date),
					'material_id'=> (int)$in_out_part->part_id,
					'quantity'=> (int)$in_out_part->quantity,
					'note'=> $in_out_part->note,
					'location_ids'=> $in_out_part->location_ids,
					'location_labels'=> $in_out_part->location_labels,
					'heatnumbers'=> $in_out_part->heatnumbers,
					'heatnumber_ids'=> $in_out_part->heatnumber_ids,
					'received_by'=> $in_out_part->received_by,
					'employee'=>isset($in_out_part->employee)?$in_out_part->employee->name:"-",
					'purchase_order_id'=> $in_out_part->purchase_order_id,
					'purchase_order'=> isset($in_out_part->purchase_order)?array('purchase_order_code'=>$in_out_part->purchase_order->po_code):array(),
					'part_id'=>$in_out_part->part_id,
					'part'=> isset($in_out_part->part)?array('part_code'=>$in_out_part->part->part_code):array(),
					'coc_files'=> $in_out_part->coc_files
				);
		return $result;
	}

	public static function convertListInOutPart($in_out_parts){
		$result= array();
		if($in_out_parts!= null && count($in_out_parts)>0){
			foreach($in_out_parts as $in_out_part){
				$result[]= self::convertInOutPart($in_out_part);
			}
		}
		return $result;
	}

	public static function getRelatedMachines($part_id){
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $part_id);
		$list_machine_schedule = MachineSchedule::model()->findAll($criteria);

		$related_machines = array();

		if(sizeof($list_machine_schedule) > 0){
			foreach($list_machine_schedule as $schedule){
				$related_machines[] = array(
					'machine'=>array(
						'name'=>isset($schedule->machine)?$schedule->machine->name:'N/A',
					),
					'job_order'=>array(
						'jo_code'=>isset($schedule->job_order)?$schedule->job_order->jo_code:'N/A',
					),
					'operation'=>array(
						'name'=>isset($schedule->operation)?$schedule->operation->name:'N/A',
					),
				);
			}

			$result['related_machines'] = $related_machines;
			$result['success'] = true;
		}
		else{
			$result['related_machines'] = array();
			$result['success'] = false;
			$result['message'] = 'There is not any related machine';
		}

		return $result;
	}

	public static function getHeatnumberDetailInfo($data){
		$result= array();
		$part_heatnumber = PartHeatnumber::model()->findByPk((int)$data['id']);

		if(isset($part_heatnumber)){
			$criteria = new CDbCriteria();
			$criteria->compare('part_heatnumber_id', $part_heatnumber->id);
			$list_location = PartHeatnumberLocation::model()->findAll($criteria);

			$location_heatnumbers = array();
			foreach($list_location as $location){
				if($location->quantity > 0){
					$location_heatnumbers[] = array(
						'location_id'=> $location->location_id,
						'location_name'=>$location->location->name,
						'quantity'=>$location->quantity
					);
				}
			}

			$result['success'] = true;
			$result['location_heatnumbers'] = $location_heatnumbers;
		}
		else{
			$result['success']= false;
			$result['message']= 'Can not find this Heatnumber';
		}

		return $result;
	}

	public static function savePdfToUploadDocuments($data){
		$result = array();
		if(isset($data['documents']) && isset($data['category_id']) && isset($data['part_id'])){
			foreach($data['documents'] as $document){
				$file = new File();
				$file->filename = $document['filename'];
				$file->extension = $document['extension'];
				$file->dirname = $document['dirname'];
				$file->cat_id = $data['category_id'];
				$file->filesize = filesize(Yii::getPathOfAlias ( 'webroot' ).$file->dirname.'/'.$file->filename.'.'.$file->extension);

				if($file->save()){
					$part_file = new PartFile();
					$part_file->file_id = $file->id;
					$part_file->part_id = $data['part_id'];

					if($part_file->save()){
						$criteria = new CDbCriteria();
						$criteria->compare('part_id', $data['part_id']);
						$list_part_file = PartFile::model()->findAll($criteria);
						$list_file_id = array();
						foreach($list_part_file as $p){
							$list_file_id[] = $p->file_id;
						}
						
						$result = array(
							'success'=>true,
							'message'=>'PDF file added!',
							'file_id'=>$file->id,
							'tmp_file_ids'=>implode(",", $list_file_id)
						);
					}
					else{
						$result = array('success'=>false, 'message'=> CHtml::errorSummary($part_file));
					}
				}
				else{
					$result = array('success'=>false, 'message'=> CHtml::errorSummary($file));
				}
			}
		}
		else{
			$result = array('success'=>false, 'message'=>'Invalid request');
		}

		return $result;
	}

	public static function getOrderedPartInfo($part_id){
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->select = array('quantity');
		$criteria->compare('part_id', $part_id);
		$list_purchase_order_detail = PurchaseOrderDetail::model()->findAll($criteria);

		$ordered_quantity = 0;
		foreach($list_purchase_order_detail as $purchase_order_detail){
			$ordered_quantity = $ordered_quantity + $purchase_order_detail->quantity;
		}

		$criteria = new CDbCriteria();
		$criteria->select = array('heatnumbers');
		$criteria->compare('part_id', $part_id);
		$criteria->compare('type', InOutPart::TYPE_CHECK_OUT);
		$list_in_out_part = InOutPart::model()->findAll($criteria);

		$checked_out_quantity = 0;
		foreach($list_in_out_part as $in_out_part){
			if(is_array($in_out_part->heatnumbers)){
				foreach($in_out_part->heatnumbers as $heatnumber_detail){
					if(isset($heatnumber_detail->quantity)){
						$checked_out_quantity = $checked_out_quantity + $heatnumber_detail->quantity;
					}
				}
			}
		}


		$result['ordered_part_info'] = array(
			'ordered_quantity'=>$ordered_quantity,
			'checked_out_quantity'=>$checked_out_quantity,
			'outstanding_quantity'=>($ordered_quantity <= $checked_out_quantity)?0:$ordered_quantity - $checked_out_quantity,
		);
		$result['success'] = true;

		return $result;
	}
}
