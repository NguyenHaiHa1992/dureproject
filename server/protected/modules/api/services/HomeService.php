<?php
class HomeService extends iPhoenixService{
	public static function createInit($data){
		$result= array();
		
		$get_all= PurchaseOrderService::getAll(array());
		$result['purchase_orders']= $get_all['purchase_orders'];
		
		$result['success']= true;
		return $result;
	}
}
