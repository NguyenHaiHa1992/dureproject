<?php
class ResellerGroupService extends iPhoenixService{
	
	public static function getAll($data){//data là thông tin phân trang
		$result = array();
		if(!isset($data['limitstart']) && !isset($data['limitnum'])){
			$data['limitstart']= '0';
			$data['limitnum']= count(ResellerGroup::model()->findAll());
		}
		
		$criteria = new CDbCriteria();
		if(isset($data['id'])){
			if($data['id']!= '')
				$criteria->compare('id',(int)$data['id']);
			if($data['name']!= '')
				$criteria->compare('name',$data['name']);
			if($data['status']!= '')
				$criteria->compare('status',(int)$data['status']);
		}

		$total = ResellerGroup::model()->count($criteria);
		$pages = new CPagination($total);
		if((int)$data['limitnum']== 0)
			$pages->setCurrentPage(0);
		else
			$pages->setCurrentPage((int)((int)$data['limitstart'])/((int)$data['limitnum']));
		$pages->setPageSize($data['limitnum']);
		$pages->applyLimit($criteria);  // the trick is here!
		$reseller_groups = ResellerGroup::model()->findAll($criteria);
		if($reseller_groups!= null){
			$result['success']= true;
			$result['reseller_groups']=self::convertListResellerGroup($reseller_groups, $data);
			$result['totalresults']= $total;
		}
		else{
			$result['success']= true;
			$result['reseller_groups']= array();
			$result['message']= 'Chưa có nhóm nào được tạo!';
		}
		return $result;
	}
	
	public static function getResellerGroupById($data){
		$result= array();
		$reseller_group= ResellerGroup::model()->findByAttributes(array('id'=> $data['id'], 'status'=> 1));
		if($reseller_group!= null){
			$result['success']= true;
			$result['reseller_group']= self::convertResellerGroup($reseller_group);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại nhóm này!';
		}
		return $result;
	}
	
	public static function getResellerGroupByName($data){
		$result= array();
		$reseller_group= ResellerGroup::model()->findByAttributes(array('name'=> $data['name'], 'status'=> 1));
		if($reseller_group!= null){
			$result['success']= true;
			$result['reseller_group']= self::convertResellerGroup($reseller_group);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại nhóm này!';
		}
		return $result;
	}
	
	public static function getProductsOfResellerGroup($data){//$data['id']
		$result= array();
		$products_of_reseller_group= ResellerGroupDetail::model()->findAllByAttributes(array('reseller_group_id'=> (int)$data['id'], 'type'=> 1));
		if($details_of_reseller_group!= null){
			$result['success']= true;
			
		}
	}
	
	public static function create($data){
		$result= array();
		$reseller_group= new ResellerGroup();
		$reseller_group->name= $data['name'];
		$reseller_group_details= array();
		$reseller_group_details_save= true;
		$errors= array();
		if(!$reseller_group->validate()){
			$reseller_group_details_save= false;
			$errors[]= $reseller_group->getErrors();
		}
		else{
			foreach ($data['reseller_group_details'] as $key => $reseller_group_detail_array){//(array)$reseller_group_detail_array
				$reseller_group_detail= new ResellerGroupDetail();
				$reseller_group_detail->reseller_group_id= 1;
				$reseller_group_detail->product_domain_id= $reseller_group_detail_array['product_domain_id'];
				$reseller_group_detail->type= (int)$reseller_group_detail_array['type'];
				$reseller_group_detail->discount= (int)$reseller_group_detail_array['discount'];
				$reseller_group_details[]= $reseller_group_detail;
				if(!$reseller_group_detail->validate()){
					$reseller_group_details_save= false;
					$errors[]= $reseller_group_detail->getErrors();
				}
			}	
		}
		
		if($reseller_group_details_save){
			$reseller_group->save();
			foreach ($reseller_group_details as $key => $reseller_group_detail) {
				$reseller_group_detail->reseller_group_id= $reseller_group->id;
				$reseller_group_detail->save();
			}
			$result['success']= true;
			$result['id']= $reseller_group->id;
		}
		else{
			$result['success']= false;
			$result['message']= 'Có lỗi xảy ra, mời bạn nhập lại!';
			$result['errors']= $errors;
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		$reseller_group= ResellerGroup::model()->findByPk((int)$data['id']);
		$reseller_group->name= $data['name'];
		$reseller_group_details= array();
		$reseller_group_details_save= true;
		$errors= array();
		if(!$reseller_group->validate()){
			$reseller_group_details_save= false;
			$errors[]= $reseller_group->getErrors();
		}
		else{
			foreach ($data['reseller_group_details'] as $key => $reseller_group_detail_array){//(array)$reseller_group_detail_array
				$reseller_group_detail= ResellerGroupDetail::model()->findByAttributes(array(
																							'reseller_group_id'=> $reseller_group_detail_array['reseller_group_id'], 
																							'product_domain_id'=> $reseller_group_detail_array['product_domain_id'],
																							'type'=> $reseller_group_detail_array['type']));
				$reseller_group_detail->discount= (int)$reseller_group_detail_array['discount'];
				$reseller_group_details[]= $reseller_group_detail;
				if(!$reseller_group_detail->validate()){
					$reseller_group_details_save= false;
					$errors[]= $reseller_group_detail->getErrors();
				}
			}	
		}
		
		if($reseller_group_details_save){
			$reseller_group->save();
			foreach ($reseller_group_details as $key => $reseller_group_detail) {
				$reseller_group_detail->reseller_group_id= $reseller_group->id;
				$reseller_group_detail->save();
			}
			$result['success']= true;
			$result['id']= $reseller_group->id;
		}
		else{
			$result['success']= false;
			$result['message']= 'Có lỗi xảy ra, mời bạn nhập lại!';
			$result['errors']= $errors;
		}
		return $result;
	}
	
	public static function delete($data){
		$result= array();
		$reseller_group= ResellerGroup::model()->findByPk((int)$data['id']);
		if($reseller_group->delete()){
			$resellers= Reseller::model()->findAllByAttributes(array('group_id'=> $reseller_group->id));
			if(count($resellers)> 0){
				foreach ($resellers as $key => $reseller) {
					$reseller->group_id= 0;
					$reseller->save();
				}
			}
			$result['success']= true;
		}
		else
			$result['success']= false;
		return $result;
	}
	
	public static function convertListResellerGroup($reseller_groups, $data){
		$result= array();
		// $sort_attribute= array();
		// if(isset($data['sort_attribute']) && isset($data['sort_type'])){
			// foreach($reseller_groups as $reseller_group){
				// $tmp_reseller_group= self::convertResellerGroup($reseller_group);
				// $sort_attribute[]= $tmp_reseller_group[$data['sort_attribute']];
				// $result[]= self::convertResellerGroup($reseller_group);
			// }
			// if($data['sort_type']== 'SORT_ASC')
				// array_multisort($sort_attribute, SORT_ASC, $result);
			// else
				// array_multisort($sort_attribute, SORT_DESC, $result);
		// }
		// else{
			foreach($reseller_groups as $reseller_group){
				$result[]= self::convertResellerGroup($reseller_group);
			}
		// }
		
		return $result;
	}
	
	public static function convertResellerGroup($reseller_group){
		$product_domains= ResellerGroupDetail::model()->findAllByAttributes(array('reseller_group_id'=> $reseller_group->id));
		$reseller_group_details= array();
		if($product_domains!= null){
			foreach ($product_domains as $key => $product_domain){
				$name= '';
				if($product_domain->type== 1){
					$productgroup= ProductXService::getGroupById(array('id'=> $product_domain->product_domain_id));
					$name= $productgroup['productgroup']['name'];
				}
				else{
					$domain= DomainXService::getDomainById(array('id'=> $product_domain->product_domain_id));
					$name= $domain['domain']['value'];
				}
				$reseller_group_details[]= array(
												'reseller_group_id'=> $reseller_group->id,
												'product_domain_id'=> $product_domain->product_domain_id,
												'product_domain_name'=> $name,
												'type'=> $product_domain->type,
												'discount'=> $product_domain->discount, 
												);
			}
		}
		
		return array(
					'id'=> $reseller_group->id,
					'status'=> $reseller_group->status== 1?'Active':'Inactive',
					'name'=> $reseller_group->name,
					'reseller_group_details'=> $reseller_group_details,
					);
	}
}
