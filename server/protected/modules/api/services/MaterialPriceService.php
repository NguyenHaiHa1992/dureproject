<?php
class MaterialPriceService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		$get_empty_material_price= MaterialPriceService::getEmptyMaterialPrice();

		if(isset($data['id']) && $data['id']!= ''){
			$material_price = MaterialPriceService::getMaterialPriceById(array('id'=> $data['id']));
			if($material_price['success'] == true){
				$result['material_price']= $material_price['material_price'];
				$result['is_update']= true;
				$result['is_create']= false;
			}
			else{
				$result['material_price']= $get_empty_material_price['material_price'];
				$result['is_update']= false;
				$result['is_create']= true;
			}
		}
		else{
			$result['material_price']= $get_empty_material_price['material_price'];
			$result['is_update']= false;
			$result['is_create']= true;
		}
		
		$result['material_price_empty']= $get_empty_material_price['material_price'];
		$get_empty_material_price_error= MaterialPriceService::getEmptyMaterialPriceError();
		$result['material_price_error']= $get_empty_material_price_error['material_price_error'];

		$vendors = VendorService::getAll(array());
		$result['vendors'] = $vendors['vendors'];

		$list_material = Material::model()->findAll();
		$materials = array();
		foreach($list_material as $material){
			$materials[] = array(
				'id'=>$material->id,
				'material_code'=>$material->material_code,
				'shape'=>isset($material->shape)?$material->shape->name:'N/A',
				'sizes'=>$material->sizes,
			);
		}
		$result['materials'] = $materials;

		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialPrice(){
		$result= array();
		$material_price= array(
					'id'=> '',
					'date'=>'',
					'material_id'=> '',
					'vendor_id'=> '',
					'total_inch'=>'',
					'price_per_inch'=> '',
					'weight'=> '',
					'price_per_lbs'=>'',
					'created_time'=> '',
					'created_by'=> '',
					);
		
		$result['material_price']= $material_price;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyMaterialPriceError(){
		$result= array();
		$material_price= array(
					'id'=> array(),
					'date'=> array(),
					'material_id'=> array(),
					'vendor_id'=> array(),
					'total_inch'=>array(),
					'price_per_inch'=> array(),
					'weight'=> array(),
					'price_per_lbs'=> array(),
					'created_time'=> array(),
					'created_by'=> array(),
					);
		
		$result['material_price_error']= $material_price;
		$result['success']= true;
		return $result;
	}
	
	public static function getAll($data){
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= MaterialPrice::model()->count();
		}
		if(!isset($data['sort_attribute']) && !isset($data['sort_type'])){
			$data['sort_attribute']= 'created_time';
			$data['sort_type']= 'DESC';
		}

		$sql= '';
		$sql_order_by= '';
		$sql_order_by='Order By tbl_material_price.'.$data['sort_attribute'].' '.$data['sort_type'];
		
		
		$sql= "Select tbl_material_price.*
			   From tbl_material_price";
		$sql= $sql."
			   		Where 1 ";

		if(isset($data['vendor_id']) && $data['vendor_id']!= ''){
			$sql= $sql."And tbl_material_price.vendor_id LIKE '%".$data['vendor_id']."%'";
		}
		if(isset($data['material_id']) && $data['material_id']!= ''){
			$sql= $sql."And tbl_material_price.material_id LIKE '%".$data['material_id']."%'";
		}

		$sql= $sql.$sql_order_by;
		$sql= $sql." Limit ".$data['limitstart'].", ".$data['limitnum'];
		$material_prices= MaterialPrice::model()->findAllBySql($sql);

		$criteria = new CDbCriteria();
		if(isset($data['vendor_id']) && $data['vendor_id']!= ''){
			$criteria->compare('vendor_id', $data['vendor_id'], true);
		}
		if(isset($data['material_id']) && $data['material_id']!= ''){
			$criteria->compare('material_id', $data['material_id'], true);
		}
		$total= MaterialPrice::model()->count($criteria);
		
		if($material_prices!= null){
			$result['success']= true;
			$result['material_prices']=self::convertListMaterialPrice($material_prices, $data);
			
			$result['totalresults']= $total;
			$result['start_material_price']= (int)$data['limitstart']+ 1;
			$result['end_material_price']= (int)$data['limitstart']+ count($material_prices);
		}
		else{
			$result['success']= true;
			$result['material_prices']= array();
			$result['totalresults']= $total;
			$result['start_material_price']= 0;
			$result['end_material_price']= 0;
		}
		return $result;
	}

	public static function getMaterialPriceById($data){
		$result= array();
		$get_empty_material_price_error= MaterialPriceService::getEmptyMaterialPriceError();
		$result['material_price_error']= $get_empty_material_price_error['material_price_error'];
		$material_price= MaterialPrice::model()->findByPk($data['id']);

		if($material_price){
			$result['success']= true;
			$result['material_price']= self::convertMaterialPrice($material_price);
		}
		else{
			$result['success']= false;
			$result['message']= 'MaterialPrice \'s not found!';
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$material_price= new MaterialPrice();
		$material_price->attributes= $data;
		$material_price->date = strtotime($data['date']);

		if($material_price->validate()){
			$material_price->save();
			$result['success']= true;
			$result['id']= $material_price->id;
		}
		else{
			$empty_material_price_error= MaterialPriceService::getEmptyMaterialPriceError();
			$result['material_price_error']= $empty_material_price_error['material_price_error']; 
			foreach ($material_price->getErrors() as $key => $error_array) {
				$result['material_price_error'][$key]= $error_array;
			}
			$result['success']= false;
			$result['message']= 'Creating material_price has some errors';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		if(isset($data['id'])){
			$material_price= MaterialPrice::model()->findByPk((int)$data['id']);
			if($material_price){
				$material_price->attributes= $data;
				$material_price->date = strtotime($data['date']);

				if($material_price->validate()){
					$material_price->save();
					$result['success']= true;
					$result['id']= $material_price->id;
					$material_price_array= MaterialPriceService::getMaterialPriceById(array('id'=>$material_price->id));
					$result['material_price']= $material_price_array['material_price'];
					$result['message']= 'MaterialPrice updated!';
				}
				else{
					$empty_material_price_error= MaterialPriceService::getEmptyMaterialPriceError();
					$result['material_price_error']= $empty_material_price_error['material_price_error']; 
					foreach ($material_price->getErrors() as $key => $error_array) {
						$result['material_price_error'][$key]= $error_array;
					}
					$result['success']= false;
					$result['message']= 'Update material_price has some errors';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'MaterialPrice \'s not found!';
			}
		}
		else{
			//Create new material_price
			$material_price = new MaterialPrice();
			$material_price->attributes= $data;

			if($material_price->validate()){
				$material_price->save();
				$result['success']= true;
				$result['id']= $material_price->id;
				$material_price_array= MaterialPriceService::getMaterialPriceById(array('id'=>$material_price->id));
				$result['material_price']= $material_price_array['material_price'];
				$result['message']= 'MaterialPrice created!';
			}
			else{
				$empty_material_price_error= MaterialPriceService::getEmptyMaterialPriceError();
				$result['material_price_error']= $empty_material_price_error['material_price_error']; 
				foreach ($material_price->getErrors() as $key => $error_array) {
					$result['material_price_error'][$key]= $error_array;
				}
				$result['success']= false;
				$result['message']= 'Create material_price has some errors';
			}
		}
		
		
		return $result;
	}
	
	public static function convertListMaterialPrice($material_prices, $data){
		$result= array();
		if($material_prices!= null && count($material_prices)>0){
			foreach($material_prices as $material_price){
				$result[]= self::convertMaterialPrice($material_price);
			}
		}
		return $result;
	}
	
	public static function convertMaterialPrice($material_price){
		$result= array(
					'id'=> $material_price->id,
					'date'=> date('Y-m-d', $material_price->date),
					'material_id'=> $material_price->material_id,
					'material'=> array(
						'material_code' => $material_price->material->material_code,
						'sizes' => $material_price->material->sizes,
						'shape' => $material_price->material->shape->name
					),
					'vendor_id'=> $material_price->vendor_id,
					'vendor'=> array(
						'name'=>$material_price->vendor->name,
					),
					'total_inch'=> $material_price->total_inch,
					'price_per_inch'=> $material_price->price_per_inch,
					'weight'=> $material_price->weight,
					'price_per_lbs'=> $material_price->price_per_lbs,
					'created_time'=> date('Y-m-d', $material_price->created_time),
					'created_by'=> $material_price->created_by,
					);

		return $result;
	}

	public static function removeMaterialPrice($data){
		$result= array();
		$material_price = MaterialPrice::model()->findByPk((int)$data['id']);
		$material_price->attributes= $data;

		if($material_price->delete()){
			$result['success'] = true;
			$result['message'] = 'MaterialPrice deleted!';
		}
		else{
			$result['success']= false;
			$result['message']= CHtml::errorSummary($material_price);
		}
		
		return $result;
	}

	public static function importFile($data){
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
				for ($row=2; $row <= $highestRow ; $row++) {
					if($worksheet->getCellByColumnAndRow(0, $row)->getValue()!= null){
						// Get value
						$date = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$date = ($date - 25569) * 86400; // Convert excel date to Unix timestamp

						$material_code = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$material_code = preg_replace('/\s+/', ' ', $material_code);

						$vendor_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$vendor_name = preg_replace('/\s+/', ' ', $vendor_name);

						$total_inch = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$weight = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

						$price = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$price_type = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

						// Validate price_type material and vendor
						if($price_type != 'inch' && $price_type != 'lbs'){
							$list_error[] = 'Price Type "'.$price_type.'" is invalid. Row #'.($row - 1).' dismissed';
							continue;
						}

						$criteria = new CDbCriteria();
						$criteria->select = array('id');
						$criteria->compare('material_code', $material_code);
						$material = Material::model()->find($criteria);
						if(!$material){
							$list_error[] = 'Material Code "'.$material_code.'" does not exist. Row #'.($row - 1).' dismissed';
							continue;
						}

						$criteria = new CDbCriteria();
						$criteria->select = array('id');
						$criteria->compare('name', $vendor_name);
						$vendor = Vendor::model()->find($criteria);
						if(!$vendor){
							$list_error[] = 'Vendor "'.$vendor_name.'" does not exist. Row #'.($row - 1).' dismissed';
							continue;
						}

						// Save record
						$material_price = new MaterialPrice();
						$material_price->date = $date;
						$material_price->material_id = $material->id;
						$material_price->vendor_id = $vendor->id;
						$material_price->total_inch = $total_inch;
						$material_price->weight = $weight;
						
						if($price_type == 'inch'){
							$material_price->price_per_inch = $price;
						}
						else{
							$material_price->price_per_inch = round($price * $weight / $total_inch, 2);
						}

						if(!$material_price->save()){
							$list_error[] = CHtml::errorSummary($material_price);
						}
					}
				}

				if(count($list_error)){
					$result = array(
						'success'=>false,
						'message'=>'<b>List Excel Rows can not be imported:</b><br />'.implode('<br />', $list_error),
					);
				}
				else{
					$result = array(
						'success'=>true,
						'message'=>'Import finishes',
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
