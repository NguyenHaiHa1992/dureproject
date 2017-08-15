<?php
class MaterialService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_material= MaterialService::getEmptyMaterial();

		if(isset($data['id']) && $data['id']!= ''){
			$material= MaterialService::getMaterialById(array('id'=> $data['id']));
			if($material['success']== true){
				$result['material']= $material['material'];
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['material']= $get_empty_material['material'];
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['material']= $get_empty_material['material'];
			$result['is_update']= false;
			$result['is_create']= true;
		}

		$result['material_empty']= $get_empty_material['material'];
		$get_empty_material_error= MaterialService::getEmptyMaterialError();
		$result['material_error']= $get_empty_material_error['material_error'];
		$result['material_error_empty']= $get_empty_material_error['material_error'];

		$material_categories = MaterialCategoryService::getAll(array());
		$result['material_categories'] = $material_categories['material_categories'];

		$material_uols = UolService::getAll(array());
		$result['uols'] = $material_uols['uols'];

		$material_uoqs = UoqService::getAll(array());
		$result['uoqs'] = $material_uoqs['uoqs'];

		$material_shapes = ShapeService::getAll(array());
		$result['shapes'] = $material_shapes['shapes'];

		// $vendors = VendorService::getAll(array());
		// $result['vendors'] = $vendors['vendors'];

		// $employees = EmployeeService::getAll(array());
		// $result['employees'] = $employees['employees'];

		// $parts = PartService::getAll(array());
		// $result['parts'] = $parts['parts'];

		// $job_orders = JobOrderService::getAll(array());
		// $result['job_orders'] = $job_orders['job_orders'];

		$get_all_locations= MaterialLocationService::getAll(array());
		$result['locations']= $get_all_locations['locations'];

		$result['success']= true;
		return $result;
	}

	public static function listInit($data){
		$result= array();

		// $employees = EmployeeService::getAll(array());
		// $result['employees'] = $employees['employees'];

		// $parts = PartService::getAll(array());
		// $result['parts'] = $parts['parts'];

		// $job_orders = JobOrderService::getAll(array());
		// $result['job_orders'] = $job_orders['job_orders'];

		$result['success']= true;
		return $result;
	}

	public static function getAll($data){//data là thông tin phân trang
		$result = array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= Material::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_material.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_material.*
			   From tbl_material";
		$sql= $sql."
			   		Where 1 ";
		if(isset($data['material_code']) && $data['material_code']!= ''){
			$sql= $sql."And tbl_material.material_code LIKE '%".$data['material_code']."%'";
		}

		if(isset($data['category_id']) && $data['category_id']!= ''){
			$sql= $sql." And tbl_material.category_id = ".$data['category_id']." ";
		}

		if(isset($data['shape_id']) && $data['shape_id']!= ''){
			$sql= $sql." And tbl_material.shape_id = ".$data['shape_id']." ";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$materials = Material::model()->findAllBySql($sql);

		// Filter size option if need
		if(isset($data['is_change_size']) && $data['is_change_size']){
			$size_options = $data['size_options'];
			$size_values = $data['size_values'];
			$size_labels = array_reverse($data['size_labels']); // Array reverse

			$list_material = array();
			foreach($materials as $material){
				$material_sizes = $material->sizes;
				$check = true;
				$i = 0;

				foreach($size_options as $option){
					switch ((string)$option) {
						case '-1':
							$label = $size_labels[$i];
							if(isset($material_sizes->$label) && $size_values[$i] != ''){
								if($material_sizes->$label >= $size_values[$i]){
									$check = false;
								}
							}
							else{
								$check = false;
							}

							break;
						case '0':
							$label = $size_labels[$i];
							if(isset($material_sizes->$label) && $size_values[$i] != ''){
								if($material_sizes->$label != $size_values[$i]){
									$check = false;
								}
							}
							else{
								$check = false;
							}

							break;
						case '1':
							$label = $size_labels[$i];
							if(isset($material_sizes->$label) && $size_values[$i] != ''){
								if($material_sizes->$label <= $size_values[$i]){
									$check = false;
								}
							}
							else{
								$check = false;
							}

							break;
						default:
							# code...
							break;
					}

					$i++;
				}

				if($check){
					//var_dump($material->material_code);
					$list_material[] = $material;
				}
			}

			$materials = $list_material;
		}

		$criteria = new CDbCriteria();
		if(isset($data['material_code']) && $data['material_code']!= ''){
			$criteria->compare('material_code', $data['material_code'], true);
		}
		if(isset($data['category_id']) && $data['category_id']!= ''){
			$criteria->compare('category_id', $data['category_id']);
		}
		if(isset($data['shape_id']) && $data['shape_id']!= ''){
			$criteria->compare('shape_id', $data['shape_id']);
		}
		$total = Material::model()->count($criteria);

		if($materials!= null){
			$result['success']= true;
			$result['materials']=self::convertListMaterial($materials, $data);
			$result['totalresults']= $total;
			$result['start_material']= (int)$data['limitstart']+ 1;
			$result['end_material']= (int)$data['limitstart']+ count($materials);
		}
		else{
			$result['success']= true;
			$result['materials']= array();
			$result['totalresults']= $total;
			$result['start_material']= 0;
			$result['end_material']= 0;
		}

		// Get Material locations list
		$get_all_locations= MaterialLocationService::getAll(array());
		$result['locations']= $get_all_locations['locations'];

		return $result;
	}

	public static function getAllMaterialCode($data){//data là thông tin phân trang
		$result = array();

		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(Material::model()->findAll());
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}
		
		$sql= '';
		$sql_order_by='Order By tbl_material.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_material.id, tbl_material.material_code
			   From tbl_material";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['material_code']) && $data['material_code']!= ''){
			$sql= $sql."And tbl_material.material_code LIKE '%".$data['material_code']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];

		$materials = Material::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['material_code']) && $data['material_code']!= ''){
			$criteria->compare('material_code', $data['material_code'], true);
		}
		$total = Material::model()->count($criteria);

		if($materials!= null){
			$converted_materials = array();
			foreach($materials as $material){
				$converted_materials[] = array(
					'id'=>$material->id,
					'material_code'=>$material->material_code,
				);
			}

			$result['success']= true;
			$result['materials']=$converted_materials;
			$result['totalresults']= $total;
			$result['start_material']= (int)$data['limitstart']+ 1;
			$result['end_material']= (int)$data['limitstart']+ count($materials);
		}
		else{
			$result['success']= true;
			$result['materials']= array();
			$result['totalresults']= $total;
			$result['start_material']= 0;
			$result['end_material']= 0;
		}

		return $result;
	}

	public static function getMaterialById($data){
		$result= array();
		$get_empty_material_error= MaterialService::getEmptyMaterialError();
		$result['material_error']= $get_empty_material_error['material_error'];
		
		$material;
		$material= Material::model()->findByPk((int)$data['id']);
		if($material!= null){
			$result['success']= true;
			$result['material']= self::convertMaterial($material);
		}
		else{
			$result['success']= false;
			$result['message']= 'Material\'s not found!';
		}
		return $result;
	}

	public static function getEmptyMaterial(){
		$result= array();
		$material= array(
					'id'=> '',
					'material_code'=> '',
					'material_code_id'=> '',
					'category_id'=> '',
					'date'=> '',
					
					'status'=> '0',
					'created_time'=> '',

					'shape_id'=> '',
					'uol_id'=> '',
					'uoq_id'=> '',
					'receiver'=> '',
					'note'=> '',
					'location'=> '',
					'size_ids' => array(),
					'am_designation'=>'',
					'designation_id'=>'',
					'heat_number'=>'',

					'inches'=> '',
					'quantity'=> '',
					'total_length'=> '',
					'total_lbs'=> '',
					'cost_lbs'=> '',
					'cost_inch'=>'',
					'optimum_inventory'=> '',
					'stock_in_hand'=> '',
					'sizes'=>array(),
					'heatnumbers'=> array(),
					'arr_location_ids'=> array(),
				);
		
		$result['material']= $material;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialError(){
		$result= array();
		$material= array(
					'id'=> array(),
					'material_code'=> array(),
					'material_code_id'=> array(),
					'category_id'=> array(),
					'date'=> array(),
					'status'=> array(),
					'created_time'=> array(),
					'shape_id'=> array(),
					'uol_id'=> array(),
					'uoq_id'=> array(),
					'receiver'=> array(),
					'note'=> array(),
					'location'=> array(),
					'size_ids' => array(),
					'am_designation'=>array(),
					'designation_id'=>array(),
					'heat_number'=>array(),

					'inches'=> array(),
					'quantity'=> array(),
					'total_length'=> array(),
					'total_lbs'=> array(),
					'cost_lbs'=> array(),
					'cost_inch'=> array(),
					'optimum_inventory'=> array(),
					'stock_in_hand'=> array(),
					'sizes'=> array(),
					'arr_location_ids'=> array(),
				);

		$result['material_error']= $material;
		$result['success']= true;
		return $result;
	}
	
	public static function create($data){
		$result= array();
		$material= new Material();
		$material->attributes= $data;
		$material->date= strtotime($data['date']);
		$material->heatnumbers = $data['heatnumbers'];

		$empty_material_error= MaterialService::getEmptyMaterialError();
		$result['material_error']= $empty_material_error['material_error'];

		if(!$material->save()){
			foreach ($material->getErrors() as $key => $error_array) {
				$result['material_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= CHtml::errorSummary($material);
		}
		else{
			$result['success']= true;
			$material_array= MaterialService::getMaterialById(array('id'=>$material->id));
			$result['material']= $material_array['material'];
			$result['id']= $material->id;
		}	
		
		return $result;
	}
	
	public static function update($data){
		$result= array();
		$material= Material::model()->findByPk((int)$data['id']);
		if($material== null){
			$result['success']= false;
			$result['message']= 'Material \'s not found!';
		}
		else{
			$material->attributes= $data;
			$material->date= strtotime($data['date']);
			$material->heatnumbers = $data['heatnumbers'];

			$empty_material_error= MaterialService::getEmptyMaterialError();
			$result['material_error']= $empty_material_error['material_error'];
			$is_save= true;

			if(!$material->validate()){
				$is_save= false;
				foreach ($material->getErrors() as $key => $error_array) {
					$result['material_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= CHtml::errorSummary($material);
			}

			if($is_save){
				$material->save();

				$result['success']= true;
				$material_array= MaterialService::getMaterialById(array('id'=>$material->id));
				$result['material']= $material_array['material'];
				$result['id']= $material->id;
			}
		}
		return $result;
	}
	
	public static function convertListMaterial($materials, $data){
		$result= array();
		if($materials!= null && count($materials)>0){
			foreach($materials as $material){
				$result[]= self::convertMaterial($material);
			}
		}
		return $result;
	}
	
	public static function convertMaterial($material){
		$result= array(
					'id'=> $material->id,
					'material_code'=> $material->material_code,
					'material_code_id'=> $material->material_code_id,
					'category_id'=> $material->category_id,
					'category_name'=> isset($material->category)?$material->category->name:"N/A",
					'date'=> date('Y-m-d', $material->date),
					
					'status'=> $material->status,
					'created_time'=> $material->created_time,

					'shape_id'=> $material->shape_id,
					'shape_img_src'=> $material->getShapeImage(),
					'uol_id'=> $material->uol_id,
					'uoq_id'=> $material->uoq_id,
					'receiver'=> $material->receiver,
					'note'=> $material->note,
					'location'=> $material->location,
					'am_designation'=> $material->am_designation,
					'designation_id'=> $material->designation_id,
					'heat_number'=> $material->heat_number,

					'inches'=> $material->inches,
					'quantity'=> $material->quantity,
					'total_length'=> $material->total_length,
					'total_lbs'=> $material->total_lbs,
					'cost_lbs'=> $material->cost_lbs,
					'cost_inch'=> $material->cost_inch,
					'optimum_inventory'=> $material->optimum_inventory,
					'stock_in_hand'=> $material->stock_in_hand,
					'sizes'=> $material->sizes,
					'upload_file_id'=> $material->upload_file_id,
					'arr_location_ids'=> $material->arr_location_ids,
				);

		$result['heatnumbers'] = $material->heatnumbers;

		return $result;
	}

	public static function checkin($data){
		$errors = '';
		$result= array();
		$new_location_ids = array();

		if(isset($data['id']) && isset($data['check_in'])){
			$material = Material::model()->findByPk($data['id']);

			if(isset($material)){
				// Save check in
				$check_in = new InOutMaterial();
				$check_in->scenario = 'checkin';
				$check_in->attributes = $data['check_in'];
				$check_in->received_date = strtotime($check_in->received_date);
				$check_in->type = InOutMaterial::TYPE_CHECK_IN;
				$check_in->material_id = $data['id'];

				$transaction = Yii::app()->db->beginTransaction();
				try 
				{
					// Save model
					if($check_in->save()){
						// Find Heat numbers
						$heatnumbers = $check_in->heatnumbers;
						foreach($heatnumbers as $h){
							$heatnumber = MaterialHeatnumber::model()->findByPk($h->id);
							if(isset($heatnumber) && $heatnumber->material_id == $check_in->material_id){
								// Update total quantity
								$heatnumber->quantity = $heatnumber->quantity + $h->quantity;

								//Update quantity detail
								$add_quantity_detail = $h->quantity_detail;
								$quantity_detail = $heatnumber->quantity_detail;

								foreach ($add_quantity_detail as $add_detail) {
									$i = 0;

									if(is_array($quantity_detail) && count($quantity_detail) > 0){
										foreach ($quantity_detail as $detail) {

											if($detail->length == $add_detail->length){
												if(!is_numeric($add_detail->quantity) || $add_detail->quantity <= 0){
													$check_in->delete();
													$result = array(
														'success'=>false,
														'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!',
													);

													return $result;

												}
												else{
													$detail->quantity = $detail->quantity + $add_detail->quantity;
													$quantity_detail[$i] = $detail;
												}

												break;
											}

											$i++;
										}

										if($i == sizeof($quantity_detail)){
											array_push($quantity_detail, (object) array(
												'quantity'=>$add_detail->quantity,
												'length'=>$add_detail->length,
											));
										}
									}
									else{
										$quantity_detail = array();
										array_push($quantity_detail, (object) array(
											'quantity'=>$add_detail->quantity,
											'length'=>$add_detail->length,
										));
									}
								}

								$heatnumber->quantity_detail = $quantity_detail;

								if(!$heatnumber->save()){
									$check_in->delete();
									$result = array(
										'success'=>false,
										'message'=> CHtml::errorSummary($heatnumber),
									);

									return $result;
								}
								else{
									//Update quantity detail
									$add_quantity_detail = $h->quantity_detail;

									foreach($add_quantity_detail as $add_detail){
										if(isset($add_detail->quantity) && is_numeric($add_detail->quantity) && $add_detail->quantity > 0){
											$new_location_ids[] = $add_detail->location_id;
											$criteria = new CDbCriteria();
											$criteria->compare('location_id', $add_detail->location_id);
											$criteria->compare('material_heatnumber_id', $heatnumber->id);
											$material_heatnumber_location = MaterialHeatnumberLocation::model()->find($criteria);

											if(isset($material_heatnumber_location)){
												// Update quantity detail
												$i = 0;
												$total_heatnumber_location_quantity = 0;
												$quantity_detail = $material_heatnumber_location->quantity_detail;
												if(is_array($quantity_detail)){
													foreach ($quantity_detail as $detail) {
														if($detail->length == $add_detail->length){
															$detail->quantity = $detail->quantity + $add_detail->quantity;
															$quantity_detail[$i] = $detail;
															$total_heatnumber_location_quantity = $total_heatnumber_location_quantity + $add_detail->quantity;

															break;
														}

														$i++;
													}

													if($i == sizeof($quantity_detail)){
														array_push($quantity_detail, array(
															'length'=>$add_detail->length,
															'quantity'=>$add_detail->quantity,
														));
													}
												}
												else{
													$quantity_detail = array(
														array(
															'length'=>$add_detail->length,
															'quantity'=>$add_detail->quantity,
														)
													);
												}
												// end of update quantity detail

												$material_heatnumber_location->quantity_detail = $quantity_detail;
												$material_heatnumber_location->quantity = $material_heatnumber_location->quantity + $total_heatnumber_location_quantity;

												if(!$material_heatnumber_location->save()){
													$check_in->delete();
													$result = array(
														'success'=>false,
														'message'=> CHtml::errorSummary($material_heatnumber_location),
														'error'=> $material_heatnumber_location->getErrors()
													);

													return $result;
												}
											}
											else{
												$material_heatnumber_location = new MaterialHeatnumberLocation();
												$material_heatnumber_location->quantity = $add_detail->quantity;
												$material_heatnumber_location->location_id = $add_detail->location_id;
												$material_heatnumber_location->material_heatnumber_id = $heatnumber->id;
												$material_heatnumber_location->quantity_detail = array(
													array(
														'length'=>$add_detail->length,
														'quantity'=>$add_detail->quantity,
													)
												);

												if(!$material_heatnumber_location->save()){
													$check_in->delete();
													$result = array(
														'success'=>false,
														'message'=> CHtml::errorSummary($material_heatnumber_location),
														'error'=> $material_heatnumber_location->getErrors()
													);

													return $result;
												}
											}
										}
										else{
											$check_in->delete();
											$result = array(
												'success'=>false,
												'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!',
											);

											return $result;
										}
									}
								}
							}
						}

						// Get list newest heatnumbers
						$criteria = new CDbCriteria();
						$criteria->compare('material_id', $material->id);
						$full_heatnumbers = MaterialHeatnumber::model()->findAll($criteria);
						$newest_heatnumbers = array();
						$total_material_quantity = 0;

						foreach($full_heatnumbers as $heatnumber){
							$total_material_quantity = $total_material_quantity + $heatnumber->quantity;

							// Update heat number list length
							$heatnumber_list_length = array();
							$heatnumber_quantity_detail = $heatnumber->quantity_detail;
							if(is_array($heatnumber_quantity_detail)){
								foreach ($heatnumber_quantity_detail as $quantity_detail) {
									$heatnumber_list_length[] = $quantity_detail->length;
								}	
							}

							$newest_heatnumbers[] = array(
								'id'=>$heatnumber->id, 
								'material_id'=>$heatnumber->material_id,
								'heatnumber'=>$heatnumber->heatnumber, 
								'designation'=>$heatnumber->designation,
								'quantity'=>$heatnumber->quantity,
								'quantity_detail'=>$heatnumber->quantity_detail,
								'list_length'=>$heatnumber_list_length,
								'edit'=>false
							);

							$heatnumber_list_length[] = $quantity_detail->length;
						}

						// Update material
						$material->stock_in_hand = $material->stock_in_hand + $check_in->total_inch;
						$material->saveAttributes(array('stock_in_hand'));

						// Update material Location 
						$new_location_ids = array_unique($new_location_ids);
						foreach($new_location_ids as $location_id){
							$criteria = new CDbCriteria();
							$criteria->compare('material_id', $material->id);
							$criteria->compare('location_id', $location_id);
							$criteria->select = array('id');
							$materiallocation_material = MaterialLocationMaterial::model()->find($criteria);
							if(!isset($materiallocation_material)){
								$materiallocation_material = new MaterialLocationMaterial();
								$materiallocation_material->material_id = $material->id;
								$materiallocation_material->location_id = $location_id;
								$materiallocation_material->save();
							}
						}

						$criteria = new CDbCriteria();
						$criteria->compare('material_id', $material->id);
						$criteria->select = array('id','location_id');
						$tmp_list = MaterialLocationMaterial::model()->findAll($criteria);
						$arr_location_ids = array();
						foreach($tmp_list as $tmp_item){
							if(!in_array($tmp_item->location_id, $arr_location_ids))
								$arr_location_ids[] = $tmp_item->location_id;
						}

						$result = array(
							'success'=>true, 
							'stock_in_hand'=>$material->stock_in_hand,
							'quantity'=>$total_material_quantity,
							'heatnumbers'=>$newest_heatnumbers,
							'message'=>'Stock-in-hand now is '.$material->stock_in_hand,
							'arr_location_ids'=> $arr_location_ids
						);
					}
					else{
						$result = array('success'=>false, 'message'=>CHtml::errorSummary($material), 'check_in_material_error'=>$check_in->getErrors());
					}

					// Transaction commit
					$transaction->commit();
				}
				catch (Exception $e)
				{
					// Rollback
					$transaction->rollBack();
					
					// Message
					$result = array(
						'success'=>false,
						'message'=> $e->getMessage(),
					);

					return $result;
				}
			}
		}
		
		return $result;
	}

	public static function checkout($data){
		$errors = '';
		$result= array();
		if(isset($data['id']) && isset($data['check_out'])){
			$material = Material::model()->findByPk($data['id']);

			if(isset($material)){
				// Save check out
				$check_out = new InOutMaterial();
				$check_out->scenario = 'checkout';
				$check_out->attributes = $data['check_out'];
				$check_out->received_date = strtotime($check_out->received_date);
				$check_out->type = InOutMaterial::TYPE_CHECK_OUT;
				$check_out->material_id = $data['id'];

				$transaction = Yii::app()->db->beginTransaction();
				try 
				{
					if($check_out->save()){
						if($material->stock_in_hand >= $check_out->total_inch && $material->quantity >= 0){
							// Find Heat numbers
							$heatnumbers = $check_out->heatnumbers;

							$list_heatnumber = array();

							// Check heatnumber enough to check out or not
							foreach($heatnumbers as $h){
								if(isset($h->id)){
									$heatnumber = MaterialHeatnumber::model()->findByPk($h->id);
									if(isset($heatnumber) && $heatnumber->material_id == $check_out->material_id){
										// Check whether enough to check out
										if($heatnumber->quantity >= $h->quantity){
											// Update total quantity
											$heatnumber->quantity = $heatnumber->quantity - $h->quantity;

											// Update quantity detail
											$add_quantity_detail = $h->quantity_detail;
											$quantity_detail = $heatnumber->quantity_detail;

											foreach ($add_quantity_detail as $add_detail) {
												$i = 0;

												if(is_array($quantity_detail)){
													foreach ($quantity_detail as $detail) {
														if($detail->length == $add_detail->length){
															if(!isset($add_detail->quantity) || !is_numeric($add_detail->quantity) || $add_detail->quantity <= 0){
																$check_out->delete();
																$result = array(
																	'success'=>false, 
																	'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!', 
																);

																return $result;
															}
															else{
																// Check quantity is enough to check out
																if($detail->quantity >= $add_detail->quantity){
																	// Check quantity detail of location is enough to check out
																	$criteria = new CDbCriteria();
																	$criteria->compare('location_id', $add_detail->location_id);
																	$criteria->compare('material_heatnumber_id', $heatnumber->id);
																	$material_heatnumber_location = MaterialHeatnumberLocation::model()->find($criteria);

																	if(isset($material_heatnumber_location)){
																		// Update quantity detail
																		$location_quantity_detail = $material_heatnumber_location->quantity_detail;
																		if(is_array($location_quantity_detail)){
																			foreach ($location_quantity_detail as $location_detail) {
																				if($location_detail->length == $add_detail->length){
																					if(!is_numeric($add_detail->quantity) || $add_detail->quantity <= 0){
																						$check_out->delete();
																						$result = array(
																							'success'=>false, 
																							'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'" at Location ID "'.$add_detail->location_id.'"!', 
																						);

																						return $result;
																					}
																					else{
																						// Check quantity is not enough to check out
																						if($location_detail->quantity < $add_detail->quantity){
																							$check_out->delete();
																							$result = array(
																								'success'=>false, 
																								'message'=> 'Quantity of Heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$location_detail->length.'" at Location ID "'.$add_detail->location_id.'" is not enough to check out!', 
																							);

																							return $result;
																						}
																					}

																					break;
																				}
																			}
																		}
																		else{
																			$check_out->delete();
																			$result = array(
																				'success'=>false, 
																				'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" does not have any Length"!', 
																			);

																			return $result;
																		}

																	}// end of check
																	else{
																		$check_out->delete();
																		$result = array(
																			'success'=>false, 
																			'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" does not have any Length at Location ID "'.$add_detail->location_id.'"!', 
																		);

																		return $result;
																	}

																	// Update quantity_detail
																	$detail->quantity = $detail->quantity - $add_detail->quantity;
																	$quantity_detail[$i] = $detail;
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

															break;
														}
														$i++;
													}
												}
												else{
													$check_out->delete();
													$result = array(
														'success'=>false, 
														'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" is empty!', 
													);

													return $result;
												}
											}

											$heatnumber->quantity_detail = $quantity_detail;

											// Save to array to save after
											$list_heatnumber[] = $heatnumber;
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
								}
								else{
									$check_out->delete();
									$result = array(
										'success'=>false, 
										'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" is empty!', 
									);

									return $result;
								}

							}

							// Save to database
							foreach($list_heatnumber as $heatnumber){
								if(!$heatnumber->save()){
									$check_out->delete();
									$result = array(
										'success'=>false,
										'message'=> CHtml::errorSummary($heatnumber),
									);

									return $result;
								}
								else{
									//Update quantity detail
									$add_quantity_detail = $h->quantity_detail;

									foreach($add_quantity_detail as $add_detail){
										if(isset($add_detail->quantity) && is_numeric($add_detail->quantity) && $add_detail->quantity > 0){
											$criteria = new CDbCriteria();
											$criteria->compare('location_id', $add_detail->location_id);
											$criteria->compare('material_heatnumber_id', $heatnumber->id);
											$material_heatnumber_location = MaterialHeatnumberLocation::model()->find($criteria);

											if(isset($material_heatnumber_location)){
												// Update quantity detail
												$i = 0;
												$total_heatnumber_location_checkout_quantity = 0;
												$quantity_detail = $material_heatnumber_location->quantity_detail;
												if(is_array($quantity_detail)){
													foreach ($quantity_detail as $detail) {
														if($detail->length == $add_detail->length){
															// Check quantity is enough to check out
															if($detail->quantity >= $add_detail->quantity){
																$detail->quantity = $detail->quantity - $add_detail->quantity;
																$total_heatnumber_location_checkout_quantity = $total_heatnumber_location_checkout_quantity + $add_detail->quantity;
																$quantity_detail[$i] = $detail;
															}
															else{
																$check_out->delete();
																$result = array(
																	'success'=>false, 
																	'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'" is not enough to check out!', 
																);

																return $result;
															}

															break;
														}

														$i++;
													}

													if($i == sizeof($quantity_detail)){
														$check_out->delete();
														$result = array(
															'success'=>false, 
															'message'=> 'Quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$add_detail->length.'" does not exist!', 
														);

														return $result;
													}
												}

												// end of update quantity detail

												$material_heatnumber_location->quantity_detail = $quantity_detail;
												$material_heatnumber_location->quantity = $material_heatnumber_location->quantity - $total_heatnumber_location_checkout_quantity;

												if(!$material_heatnumber_location->save()){
													$check_out->delete();
													$result = array(
														'success'=>false, 
														'message'=> CHtml::errorSummary($material_heatnumber_location), 
													);

													return $result;
												}
											}
											else{
												$check_out->delete();
												$result = array(
													'success'=>false, 
													'message'=> 'Heatnumber "'.$heatnumber->heatnumber.'" with length "'.$add_detail->length.'" at Location ID "'.$add_detail->location_id.'" does not exist!', 
												);

												return $result;
											}
										}
										else{
											$check_out->delete();
											$result = array(
												'success'=>false, 
												'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!', 
											);

											return $result;
										}
									}
								}
							}

							// Get list newest heatnumbers
							$criteria = new CDbCriteria();
							$criteria->compare('material_id', $material->id);
							$full_heatnumbers = MaterialHeatnumber::model()->findAll($criteria);
							$newest_heatnumbers = array();
							$total_material_quantity = 0;
							foreach($full_heatnumbers as $heatnumber){
								// Update heat number list length
								$heatnumber_list_length = array();
								$heatnumber_quantity_detail = $heatnumber->quantity_detail;
								$total_material_quantity = $total_material_quantity + $heatnumber->quantity;

								if(is_array($heatnumber_quantity_detail)){
									foreach ($heatnumber_quantity_detail as $quantity_detail) {
										$heatnumber_list_length[] = $quantity_detail->length;
									}	
								}

								$newest_heatnumbers[] = array(
									'id'=>$heatnumber->id, 
									'material_id'=>$heatnumber->material_id,
									'heatnumber'=>$heatnumber->heatnumber, 
									'designation'=>$heatnumber->designation,
									'quantity'=>$heatnumber->quantity,
									'quantity_detail'=>$heatnumber->quantity_detail,
									'list_length'=>$heatnumber_list_length,
									'edit'=>false
								);
							}

							// Update material
							$material->stock_in_hand = $material->stock_in_hand - $check_out->total_inch;
							$material->saveAttributes(array('stock_in_hand'));

							$result = array(
								'success'=>true, 
								'stock_in_hand'=>$material->stock_in_hand,
								'quantity'=>$total_material_quantity,
								'heatnumbers'=>$newest_heatnumbers,
								'message'=>'Stock-in-hand now is '.$material->stock_in_hand
							);
						}
						else{
							$result = array('success'=>false, 'message'=>'Quantity of Material is not enought to Check-out');
						}
					}
					else{
						$result = array('success'=>false, 'message'=>CHtml::errorSummary($material), 'check_out_material_error'=>$check_out->getErrors());
					}

					// Transaction commit
					$transaction->commit();
				}
				catch (Exception $e)
				{
					// Rollback
					$transaction->rollBack();
					
					// Message
					$result = array(
						'success'=>false,
						'message'=> $e->getMessage(),
					);

					return $result;
				}
			}
		}
		
		return $result;
	}

	public static function returnItem($data){
		$errors = '';
		$result= array();
		$new_location_ids = array();

		if(isset($data['id']) && isset($data['return_item'])){
			$material = Material::model()->findByPk($data['id']);

			if(isset($material)){
				// Save check in
				$return_item = new InOutMaterial();
				$return_item->scenario = 'return';
				$return_item->attributes = $data['return_item'];
				$return_item->received_date = strtotime($return_item->received_date);
				$return_item->type = InOutMaterial::TYPE_RETURN;
				$return_item->material_id = $data['id'];

				$transaction = Yii::app()->db->beginTransaction();
				try 
				{
					// Save model
					if($return_item->save()){
						// Find Heat numbers
						$heatnumbers = $return_item->heatnumbers;
						foreach($heatnumbers as $h){
							$heatnumber = MaterialHeatnumber::model()->findByPk($h->id);
							if(isset($heatnumber) && $heatnumber->material_id == $return_item->material_id){
								// Update total quantity
								$heatnumber->quantity = $heatnumber->quantity + $h->quantity;

								//Update quantity detail
								$add_quantity_detail = $h->quantity_detail;
								$quantity_detail = $heatnumber->quantity_detail;

								foreach ($add_quantity_detail as $add_detail) {
									$i = 0;

									if(is_array($quantity_detail) && count($quantity_detail) > 0){
										foreach ($quantity_detail as $detail) {

											if($detail->length == $add_detail->length){
												if(!is_numeric($add_detail->quantity) || $add_detail->quantity <= 0){
													$return_item->delete();
													$result = array(
														'success'=>false,
														'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!',
													);

													return $result;

												}
												else{
													$detail->quantity = $detail->quantity + $add_detail->quantity;
													$quantity_detail[$i] = $detail;
												}

												break;
											}

											$i++;
										}

										if($i == sizeof($quantity_detail)){
											array_push($quantity_detail, (object) array(
												'quantity'=>$add_detail->quantity,
												'length'=>$add_detail->length,
											));
										}
									}
									else{
										$quantity_detail = array();
										array_push($quantity_detail, (object) array(
											'quantity'=>$add_detail->quantity,
											'length'=>$add_detail->length,
										));
									}
								}

								$heatnumber->quantity_detail = $quantity_detail;

								if(!$heatnumber->save()){
									$return_item->delete();
									$result = array(
										'success'=>false,
										'message'=> CHtml::errorSummary($heatnumber),
									);

									return $result;
								}
								else{
									//Update quantity detail
									$add_quantity_detail = $h->quantity_detail;

									foreach($add_quantity_detail as $add_detail){
										if(isset($add_detail->quantity) && is_numeric($add_detail->quantity) && $add_detail->quantity > 0){
											$new_location_ids[] = $add_detail->location_id;
											$criteria = new CDbCriteria();
											$criteria->compare('location_id', $add_detail->location_id);
											$criteria->compare('material_heatnumber_id', $heatnumber->id);
											$material_heatnumber_location = MaterialHeatnumberLocation::model()->find($criteria);

											if(isset($material_heatnumber_location)){
												// Update quantity detail
												$i = 0;
												$total_heatnumber_location_quantity = 0;
												$quantity_detail = $material_heatnumber_location->quantity_detail;
												if(is_array($quantity_detail)){
													foreach ($quantity_detail as $detail) {
														if($detail->length == $add_detail->length){
															$detail->quantity = $detail->quantity + $add_detail->quantity;
															$quantity_detail[$i] = $detail;
															$total_heatnumber_location_quantity = $total_heatnumber_location_quantity + $add_detail->quantity;

															break;
														}

														$i++;
													}

													if($i == sizeof($quantity_detail)){
														array_push($quantity_detail, array(
															'length'=>$add_detail->length,
															'quantity'=>$add_detail->quantity,
														));
													}
												}
												else{
													$quantity_detail = array(
														array(
															'length'=>$add_detail->length,
															'quantity'=>$add_detail->quantity,
														)
													);
												}
												// end of update quantity detail

												$material_heatnumber_location->quantity_detail = $quantity_detail;
												$material_heatnumber_location->quantity = $material_heatnumber_location->quantity + $total_heatnumber_location_quantity;

												if(!$material_heatnumber_location->save()){
													$return_item->delete();
													$result = array(
														'success'=>false,
														'message'=> CHtml::errorSummary($material_heatnumber_location),
														'error'=> $material_heatnumber_location->getErrors()
													);

													return $result;
												}
											}
											else{
												$material_heatnumber_location = new MaterialHeatnumberLocation();
												$material_heatnumber_location->quantity = $add_detail->quantity;
												$material_heatnumber_location->location_id = $add_detail->location_id;
												$material_heatnumber_location->material_heatnumber_id = $heatnumber->id;
												$material_heatnumber_location->quantity_detail = array(
													array(
														'length'=>$add_detail->length,
														'quantity'=>$add_detail->quantity,
													)
												);

												if(!$material_heatnumber_location->save()){
													$return_item->delete();
													$result = array(
														'success'=>false,
														'message'=> CHtml::errorSummary($material_heatnumber_location),
														'error'=> $material_heatnumber_location->getErrors()
													);

													return $result;
												}
											}
										}
										else{
											$return_item->delete();
											$result = array(
												'success'=>false,
												'message'=> 'Invalid quantity of heatnumber "'.$heatnumber->heatnumber.'" with length: "'.$detail->length.'"!',
											);

											return $result;
										}
									}
								}
							}
						}

						// Get list newest heatnumbers
						$criteria = new CDbCriteria();
						$criteria->compare('material_id', $material->id);
						$full_heatnumbers = MaterialHeatnumber::model()->findAll($criteria);
						$newest_heatnumbers = array();
						$total_material_quantity = 0;

						foreach($full_heatnumbers as $heatnumber){
							$total_material_quantity = $total_material_quantity + $heatnumber->quantity;

							// Update heat number list length
							$heatnumber_list_length = array();
							$heatnumber_quantity_detail = $heatnumber->quantity_detail;
							if(is_array($heatnumber_quantity_detail)){
								foreach ($heatnumber_quantity_detail as $quantity_detail) {
									$heatnumber_list_length[] = $quantity_detail->length;
								}	
							}

							$newest_heatnumbers[] = array(
								'id'=>$heatnumber->id, 
								'material_id'=>$heatnumber->material_id,
								'heatnumber'=>$heatnumber->heatnumber, 
								'designation'=>$heatnumber->designation,
								'quantity'=>$heatnumber->quantity,
								'quantity_detail'=>$heatnumber->quantity_detail,
								'list_length'=>$heatnumber_list_length,
								'edit'=>false
							);

							$heatnumber_list_length[] = $quantity_detail->length;
						}

						// Update material
						$material->stock_in_hand = $material->stock_in_hand + $return_item->total_inch;
						$material->saveAttributes(array('stock_in_hand'));

						// Update material Location 
						$new_location_ids = array_unique($new_location_ids);
						foreach($new_location_ids as $location_id){
							$criteria = new CDbCriteria();
							$criteria->compare('material_id', $material->id);
							$criteria->compare('location_id', $location_id);
							$criteria->select = array('id');
							$materiallocation_material = MaterialLocationMaterial::model()->find($criteria);
							if(!isset($materiallocation_material)){
								$materiallocation_material = new MaterialLocationMaterial();
								$materiallocation_material->material_id = $material->id;
								$materiallocation_material->location_id = $location_id;
								$materiallocation_material->save();
							}
						}

						$criteria = new CDbCriteria();
						$criteria->compare('material_id', $material->id);
						$criteria->select = array('id','location_id');
						$tmp_list = MaterialLocationMaterial::model()->findAll($criteria);
						$arr_location_ids = array();
						foreach($tmp_list as $tmp_item){
							if(!in_array($tmp_item->location_id, $arr_location_ids))
								$arr_location_ids[] = $tmp_item->location_id;
						}

						$result = array(
							'success'=>true, 
							'stock_in_hand'=>$material->stock_in_hand,
							'quantity'=>$total_material_quantity,
							'heatnumbers'=>$newest_heatnumbers,
							'message'=>'Stock-in-hand now is '.$material->stock_in_hand,
							'arr_location_ids'=> $arr_location_ids
						);
					}
					else{
						$result = array('success'=>false, 'message'=>CHtml::errorSummary($material), 'return_material_error'=>$return_item->getErrors());
					}

					// Transaction commit
					$transaction->commit();
				}
				catch (Exception $e)
				{
					// Rollback
					$transaction->rollBack();
					
					// Message
					$result = array(
						'success'=>false,
						'message'=> $e->getMessage(),
					);

					return $result;
				}
			}
		}
		
		return $result;
	}

	public static function getInOutMaterials($data){
		$result = array();
		if(isset($data['material_id']) && $data['material_id'] != ''){
			$criteria = new CDbCriteria();
			$criteria->compare('material_id', $data['material_id']);
			$criteria->order = "id desc";
			$list = InOutMaterial::model()->findAll($criteria);
			$result['in_out_materials'] = self::convertListInOutMaterial($list);
			$result['success'] = true;
		}
		else{
			$result['success'] = false;
			$result['message'] = 'Invalid request';
		}

		return $result;
	}

	public static function convertInOutMaterial($in_out_material){
		$result= array(
					'id'=> (int)$in_out_material->id,
					'type'=> (int)$in_out_material->type,
					'type_label'=> $in_out_material->getTypeLabel(),
					'received_date'=> date('Y-m-d', $in_out_material->received_date),
					'material_id'=> (int)$in_out_material->material_id,
					'quantity'=> (int)$in_out_material->quantity,
					'inch_bar'=> (float)$in_out_material->inch_bar,
					'total_inch'=> (float)$in_out_material->total_inch,
					'total_lbs'=> (float)$in_out_material->total_lbs,
					'note'=> $in_out_material->note,
					'vendor_id'=> $in_out_material->vendor_id,
					'cost_inch'=>(float)$in_out_material->cost_inch,
					'cost_lbs'=> $in_out_material->cost_lbs,
					'heatnumbers'=> $in_out_material->heatnumbers,
					'heatnumber_ids'=> $in_out_material->heatnumber_ids,
					'received_by'=> (int)$in_out_material->received_by,
					'employee'=> isset($in_out_material->employee)?$in_out_material->employee->name:"N/A",
					'mill_cert_file_id'=> (int)$in_out_material->mill_cert_file_id,
					'job_order_id'=> (int)$in_out_material->job_order_id,
					'part_id'=> (int)$in_out_material->part_id,
				);
		return $result;
	}

	public static function convertListInOutMaterial($in_out_materials){
		$result= array();
		if($in_out_materials!= null && count($in_out_materials)>0){
			foreach($in_out_materials as $in_out_material){
				$result[]= self::convertInOutMaterial($in_out_material);
			}
		}
		return $result;
	}

	/****** Heat number ******/
	public static function updateHeatnumber($data){
		$result= array();
		if(isset($data['id']) && $data['id'] != ''){
			$material_heatnumber = MaterialHeatnumber::model()->findByPk((int)$data['id']);
			if(isset($material_heatnumber)){
				$material_heatnumber->attributes= $data;

				if($material_heatnumber->save()){
					$result['success'] = true;
					$result['message'] = 'Heatnumber updated!';
					$result['designation'] = $material_heatnumber->designation;
					$result['id'] = $material_heatnumber->id;
				}
				else{
					$result['success']= false;
					$result['message']= CHtml::errorSummary($material_heatnumber);
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Can not find this price range';
			}
		}
		else{
			$material_heatnumber = new MaterialHeatnumber();
			$material_heatnumber->attributes= $data;
			$material_heatnumber->material_id = $data['material_id'];

			if($material_heatnumber->save()){
				$result['success'] = true;
				$result['message'] = 'Heatnumber created!';
				$result['id'] = $material_heatnumber->id;

				// Update heatnumber designation
				$material = Material::model()->findByPk($material_heatnumber->material_id);
				if(!isset($heatnumber->designation) || $heatnumber->designation == ''){
					$label_list = $material->AM_DESIGNATION_OPTIONS;
					if(isset($label_list[$material->am_designation])){
						$label = $label_list[$material->am_designation];
						$material_heatnumber->designation = $label.$material_heatnumber->id;
					}
				}

				$result['designation'] = $material_heatnumber->designation;
			}
			else{
				$result['success']= false;
				$result['message']= CHtml::errorSummary($material_heatnumber);
			}
		}
		
		return $result;
	}

	public static function removeHeatnumber($data){
		$result= array();
		$material_heatnumber = MaterialHeatnumber::model()->findByPk((int)$data['id']);

		if(isset($material_heatnumber)){
			// Validate before delete heatnumber
			// Check in out history
			$criteria = new CDbCriteria();
			$criteria->addCondition('heatnumber_ids Like \'%"'.$material_heatnumber->id.'"%\'');
			$find = InOutMaterial::model()->count($criteria);
			if($find > 0){
				$result['success'] = false;
				$result['message'] = 'This Material Heatnumber can not be delete because It existed in Material In/Out History!';
				return $result;
			}

			// Check used in Part heatnumber
			$criteria = new CDbCriteria();
			$criteria->compare('heatnumber', $material_heatnumber->heatnumber);
			$find = PartHeatnumber::model()->count($criteria);
			if($find > 0){
				$result['success'] = false;
				$result['message'] = 'This Material Heatnumber can not be delete because It were used in Part Heatnumber';
				return $result;
			}

			// Delete Material Heatnumber
			if($material_heatnumber->delete()){
				$result['success'] = true;
				$result['message'] = 'Heatnumber deleted!';
			}
			else{
				$result['success']= false;
				$result['message']= CHtml::errorSummary($material_heatnumber);
			}
		}

		return $result;
	}

	public static function getHeatnumberDetailInfo($data){
		$result= array();
		$material_heatnumber = MaterialHeatnumber::model()->findByPk((int)$data['id']);

		if(isset($material_heatnumber)){
			$criteria = new CDbCriteria();
			$criteria->compare('material_heatnumber_id', $material_heatnumber->id);
			$list_location = MaterialHeatnumberLocation::model()->findAll($criteria);

			$location_heatnumbers = array();
			foreach($list_location as $location){
				if($location->quantity > 0){
					$location_heatnumbers[] = array(
						'location_id'=> $location->location_id,
						'location_name'=>$location->location->name,
						'quantity'=>$location->quantity,
						'quantity_detail'=>$location->quantity_detail,
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

	public static function importHeatnumber($data){
		$result= array();

		if(isset($data['uploaded_file'])){
			$path= $_FILES['uploaded_file']['name'];
			$file = $_FILES['uploaded_file']['tmp_name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);

			if($ext== 'xls'|| $ext== 'xlsx'|| $ext== 'csv'){
				$filename=$_FILES["uploaded_file"]["tmp_name"];
				require_once(Yii::getPathOfAlias('ext.phpexcel') . '/PHPExcel.php');

				$objPHPExcel= PHPExcel_IOFactory::load($file);
				$worksheet = $objPHPExcel->getActiveSheet();
			    $worksheetTitle = $worksheet->getTitle();
			    $highestRow = $worksheet->getHighestRow(); // e.g. 10 For all rows
			    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

				// Material Price to database
				$list_error = array();
				$list_new_heatnumber = array();

				for ($row=2; $row <= $highestRow ; $row++) {
					if($worksheet->getCellByColumnAndRow(0, $row)->getValue()!= null){
						// Get value
						$heatnumber = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$designation = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

						// Validate unique heatnumber for this material
						$criteria = new CDbCriteria();
						$criteria->compare('material_id', $data['material_id']);
						$criteria->compare('heatnumber', $heatnumber);

						$find = MaterialHeatnumber::model()->count($criteria);
						if($find > 0){
							$list_error[] = 'Heatnumber "'.$heatnumber.'" has existed. Row #'.($row - 1).' dismissed';
							continue;
						}

						// Save record
						$material_heatnumber = new MaterialHeatnumber();
						$material_heatnumber->material_id = $data['material_id'];
						$material_heatnumber->heatnumber = $heatnumber;
						$material_heatnumber->designation = $designation;

						if(!$material_heatnumber->save()){
							$list_error[] = CHtml::errorSummary($material_heatnumber);
						}
						else{
							$list_new_heatnumber[] = array(
								'heatnumber' => $material_heatnumber->heatnumber,
								'designation' => $material_heatnumber->designation,
								'material_id' => $material_heatnumber->material_id,
								'is_edit' => false,
								'is_new' => false,
							);
						}
					}
				}

				if(count($list_error)){
					$result = array(
						'success'=>false,
						'message'=>'<b>List Excel Rows can not be imported:</b><br />'.implode('<br />', $list_error),
						'list_new_heatnumber'=>$list_new_heatnumber,
					);
				}
				else{
					$result = array(
						'success'=>true,
						'message'=>'Import finishes',
						'list_new_heatnumber'=>$list_new_heatnumber,
					);
				}
			}
			else{
				$result['success'] = false;
				$result['message'] = 'Wrong file format!';
			}
		}
		
		return $result;
	}
}
