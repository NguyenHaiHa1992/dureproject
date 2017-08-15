<?php

class ProductXService extends iPhoenixXService{
	
	public static function getAll($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getproducts';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->products))
				$result['products']= self::convertListProducts($result_api->products->product, $data);
			else
				$result['products']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getProductPriceById($data){//$data['id']
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getproductprice';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['price']= (string)$result_api->price;
			$result['setup_fee']= (string)$result_api->setup_fee;
			$result['time']= $result_api->time;
			$result['paytype']= $result_api->paytype;
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getAllGroups($data){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getproductgroups';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->productgroups))
				$result['productgroups']= self::convertListProductGroups($result_api->productgroups);
			else
				$result['productgroups']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getGroupById($data){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getproductgroups';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			if(isset($result_api->productgroups)){
				$result['success']= false;
				foreach($result_api->productgroups as $key => $productgroup){
					if($productgroup->id== $data['id']){
						$result['success']= true;
						$result['productgroup']= self::convertProduct($productgroup);	
					}		
				}
				if($result['success']== false)
					$result['message']= 'Không tồn tại Nhóm sản phẩm';
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getAllDomains($data){
		$result= array();
		$postfields= array();
		$postfields['action']= 'getdomains';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->domains))
				$result['domains']= self::convertListDomains($result_api->domains);
			else
				$result['domains']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getDomainsByDomain($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getdomainswithsearch';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->domains) && $result_api->domains!= null && count($result_api->domains)> 0)
				$result['domains']= self::convertListDomains($result_api->domains);
			else
				$result['domains']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getProductById($data){
		$result= array();
		$id= $data['id'];
		$postfields= array();
		$postfields['action']= 'getproducts';
		$postfields['pid']= $id;
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->products))
				$result['product']= self::convertProduct($result_api->products->product[0]);
			else
				$result['product']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getProductsOfReseller($data){//$data['id]
		$result= array();
		 $reseller= Reseller::model()->findByPk((int)$data['clientid']);
		 if($reseller){
			$postfields= array();
			$postfields= $data;
			$postfields['action']= 'getclientsproducts';
			$result_api= self::executeService($postfields);
			if($result_api->result== 'success'){
				$result['success']= true;
				if(isset($result_api->products->product)){
					$result['products']= self::convertListProducts($result_api->products->product, $data);
					$result['totalresults']= $result_api->totalresults;
				}
				else
					$result['products']= array();
			}
			else{
				$result['success']= false;
				$result['message']= $result_api->message;
			}
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại Đại lý này!';
		}
		return $result;
	}
	
	public static function getDiscountByProductAndReseller($data){//reseller_id, product_id
		$result= array();
		$reseller= Reseller::model()->findByPk((int)$data['reseller_id']);
		$discount= ResellerGroupDetail::model()->findByAttributes(array(
																	'product_domain_id'=>$data['product_id'], 
																	'type'=> 1,
																	'reseller_group_id'=> $reseller->group_id));
		if($discount){
			$result['success']= true;
			$result['discount']= $discount->discount;
		} 
		else{
			$result['success']= true;
			$result['discount']= 0;
		}
		return $result;
	}
	
	public static function convertProduct($product){
		$result= get_object_vars($product);
		if(Yii::app()->reseller->id){
			$reseller= Reseller::model()->findByPk(Yii::app()->reseller->id);
			$discount= ResellerGroupDetail::model()->findByAttributes(array(
																		'product_domain_id'=>$product->gid, 
																		'type'=> 1,
																		'reseller_group_id'=> $reseller->group_id));
			if($discount)
				$result['discount']= $discount->discount;
			else
				$result['discount']= 0;
		}
		if(isset($result['pricing'])){
			if((int)$result['pricing']->USD->monthly >= 0){
				$result['price']= $result['pricing']->USD->monthly;
				$result['setupfee']= $result['pricing']->USD->msetupfee;
				$result['paytime']= 'monthly';
			}
			else if((int)$result['pricing']->USD->quarterly >= 0){
				$result['price']= $result['pricing']->USD->quarterly;
				$result['setupfee']= $result['pricing']->USD->qsetupfee;
				$result['paytime']= 'quarterly';
			}
			else if((int)$result['pricing']->USD->semiannually >= 0){
				$result['price']= $result['pricing']->USD->semiannually;
				$result['setupfee']= $result['pricing']->USD->ssetupfee;
				$result['paytime']= 'semiannually';
			}
			else if((int)$result['pricing']->USD->annually >= 0){
				$result['price']= $result['pricing']->USD->annually;
				$result['setupfee']= $result['pricing']->USD->asetupfee;
				$result['paytime']= 'annually';
			}
			else if((int)$result['pricing']->USD->biennially >= 0){
				$result['price']= $result['pricing']->USD->biennially;
				$result['setupfee']= $result['pricing']->USD->bsetupfee;
				$result['paytime']= 'biennially';
			}
			else if((int)$result['pricing']->USD->triennially >= 0){
				$result['price']= $result['pricing']->USD->triennially;
				$result['setupfee']= $result['pricing']->USD->tsetupfee;
				$result['paytime']= 'triennially';
			}
		}
		return $result;
	}
	
	public static function convertProductGroup($product_group){
		return get_object_vars($product_group);
	}
	
	public static function convertDomain($domain){
		$result= get_object_vars($domain);
		if(isset($result['value'])){
			$result['value']= substr($result['value'], 1);
			if(Yii::app()->reseller->id){
				$reseller= Reseller::model()->findByPk(Yii::app()->reseller->id);
				$discount= ResellerGroupDetail::model()->findByAttributes(array(
																			'reseller_group_id'=> $reseller->group_id,
																			'product_domain_id'=> (int)$result['id'],
																			'type'=> 2,
																		));	
				if($discount)
					$result['discount']= $discount->discount;
				else
					$result['discount']= 0;
			}
		}
		
		return $result;
	}
	
	public static function convertListProducts($products, $data){
		$result = array();
		$sort_attribute= array();
		if(isset($data['sort_attribute']) && isset($data['sort_type'])){
			foreach($products as $product){
				$tmp_product= self::convertProduct($product);
				$sort_attribute[]= $tmp_product[$data['sort_attribute']];
				$result[]= self::convertProduct($product);
			}
			if($data['sort_type']== 'SORT_ASC')
				array_multisort($sort_attribute, SORT_ASC, $result);
			else
				array_multisort($sort_attribute, SORT_DESC, $result);
		}
		else{
			foreach($products as $product){
				$result[]=self::convertProduct($product);
			}
		}
		return $result;
	}
	
	public static function convertListProductGroups($productgroups){
		$result= array();
		foreach ($productgroups as $productgroup) {
			$result[]= self::convertProductGroup($productgroup);
		}
		return $result;
	}
	
	public static function convertListDomains($domains){
		$result= array();
		foreach ($domains as $domain) {
			$result[]= self::convertDomain($domain);
		}
		return $result;
	}
}
