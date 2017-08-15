<?php

class OrderXService extends iPhoenixXService{
	
	public static function getAll($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getorders';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			if(isset($result_api->orders))
				$result['orders']= self::convertListOrders($result_api->orders->order);
			else
				$result['orders']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getOrdersByReseller($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getorderswithsearch';
		// $postfields['limitstart']= 0;
		// $postfields['limitnum']= 1;
		$postfields['userid']= Yii::app()->reseller->id;
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['totalresults']= $result_api->totalresults;
			if(isset($result_api->orders))
				$result['orders']= self::convertListOrders($result_api->orders, $data);
			else
				$result['orders']= array();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function getOrderById($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'getorders';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			if($result_api->orders->order[0]->userid== (string)Yii::app()->reseller->id){
				$result['success']= true;
				if(isset($result_api->orders))
					$result['order']= self::convertOrder($result_api->orders->order[0]);
				else
					$result['order']= null;
			}
			else{
				$result['success']= false;
				$result['message']= 'Không thể thực hiện yêu cầu này';
			}
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}
	
	public static function create($data){
		$result= array();
		
		$update_invoice= array();
		$update_invoice_index= 0;
		// lấy credit của đại lý
		$reseller= ResellerXService::getResellerById(array('id'=> Yii::app()->reseller->id));
		$reseller_credit= $reseller['reseller']['credit'];
		// tính tiền đơn hàng
		$order_amount= 0;
		// tổng chiết khấu
		$discount_total= 0;
		
		foreach ($data as $key_data => $value_data) {
			if(strpos($key_data, 'pid')!== false){
				preg_match('~\[(.*?)]~', $key_data, $product_index);
				$product_index= $product_index[1];
				$product= ProductXService::getProductById(array('id'=> $value_data));
				$order_amount= $order_amount+ $product['product']['price'];
				$order_amount= $order_amount- (float)($product['product']['price']* $product['product']['discount']/ 100);
				
				// thêm chiết khấu cho invoice
				$update_invoice['newitemdescription['.$update_invoice_index.']']= 'Sản phẩm '.$product['product']['name'].' - '.$data['domain['.$product_index.']'].' - chiết khấu';
				$update_invoice['newitemamount['.$update_invoice_index.']']= '-'.(float)($product['product']['price']* $product['product']['discount']/ 100);	
				$update_invoice['newitemtaxed['.$update_invoice_index.']']= false;
				$update_invoice_index++;
				// tính tổng chiết khấu
				$discount_total= $discount_total+ (float)($product['product']['price']* $product['product']['discount']/ 100);
			}
			if(strpos($key_data, 'domaintype')!== false){
				preg_match('~\[(.*?)]~', $key_data, $domain_index);
				$domain_index= $domain_index[1];
				$domain= $data['domain['.$domain_index.']'];
				$tmp_domaintag= explode('.', $domain);
				$tmp_domaintag= '.'.$tmp_domaintag[count($tmp_domaintag)-1];
				$domain_object= DomainXService::getDomainPrice(array('domain'=> $tmp_domaintag, 'type'=> 'domain'.$value_data));
				$tmp_domainprice= $domain_object['domains'][0]['prices'];
				foreach ($tmp_domainprice as $key_domain_price => $value_domain_price) {
					if($key_domain_price== $data['regperiod['.$domain_index.']']){
						$order_amount= $order_amount+ $value_domain_price;
						$order_amount= $order_amount- (float)($value_domain_price* $domain_object['domains'][0]['discount']/100);
						
						// thêm chiết khấu cho invoice
						$update_invoice['newitemdescription['.$update_invoice_index.']']= 'Domain - '.$data['domain['.$domain_index.']'].' - chiết khấu';
						$update_invoice['newitemamount['.$update_invoice_index.']']= '-'.(float)($value_domain_price* $domain_object['domains'][0]['discount']/100);	
						$update_invoice['newitemtaxed['.$update_invoice_index.']']= false;
						$update_invoice_index++;
						// tính tổng chiết khấu
						$discount_total= $discount_total+ (float)($value_domain_price* $domain_object['domains'][0]['discount']/100);
					}
				}
			}
		}
		
		if($order_amount> $reseller_credit){
			$autoauthkey= 'abcXYZ123';
			$timestamp= time();
			$email= $reseller['reseller']['email'];
			$goto= "";
			$hash= sha1($email.$timestamp.$autoauthkey);
			if($data['pay_option']== 'fund'){
				$result['success']= true;
				$result['type']= 'fund';	
				// tham số cho tới link addfunds
				$goto= "clientarea.php?action=addfunds";
				$result['url']= "http://man.199x.net/dologin.php?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
				
				// $whmcsurl = "http://man.199x.net/dologin.php";
				// $autoauthkey = 'abcXYZ123';
				// $timestamp = time(); # Get current timestamp
				// $email = "hainv@gmail.com"; # Clients Email Address to Login
				// $goto = "clientarea.php?action=addfunds";
				// $hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash
				// # Generate AutoAuth URL & Redirect
				// $url = $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode('http://google.com');
				// header("Location: $url");
				// exit;
			}
			elseif($data['pay_option']== 'pay'){
				$result['success']= true;
				$result['type']= 'pay';
				
				$postfields= array();
				$postfields= $data;
				$postfields['paymentmethod']= $data['payment_method'];
				$postfields['clientid']= Yii::app()->reseller->id;
				$postfields['action']= 'addorder';
				$result_api= self::executeService($postfields);	
				if($result_api->result== 'success'){
					$result['orderid']= $result_api->orderid;
					$result['invoiceid']= $result_api->invoiceid;
					$goto= "viewinvoice.php?id=".$result_api->invoiceid;
					$result['url']= "http://man.199x.net/dologin.php?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
				}
			}
		}
		else{
			$postfields= array();
			$postfields= $data;
			$postfields['clientid']= Yii::app()->reseller->id;
			
			$postfields['action']= 'addorder';
			$result_api= self::executeService($postfields);
			if($result_api->result== 'success'){
				$result['orderid']= $result_api->orderid;
				$result['invoiceid']= $result_api->invoiceid;
				
				/* Bắt đầu: update Invoice */
				$invoice= InvoiceXService::getInvoiceById(array('id'=> (string)$result_api->invoiceid));
				$invoice= $invoice['invoice'];
				$update_invoice['invoiceid']= (string)$result_api->invoiceid;
				$update_invoice['status']= 'Unpaid';
				$update_invoice['paymentmethod']= 'mailin';
				$update_invoice_object= InvoiceXService::update($update_invoice);
				/* Kết thúc: update Invoice */
				
				/* Bắt đầu: apply chiết khấu cho Invoice */
				if($update_invoice_object['success']== true){
					$apply_credit_data= array();
					$apply_credit_data['invoiceid']= (string)$result_api->invoiceid;
					$apply_credit_data['amount']= (float)$invoice['balance']- $discount_total;
					$apply_credit= InvoiceXService::applyCredit($apply_credit_data);
					if($apply_credit['success']== true){
						$result['success']= true;
					}
					else{
						$result['success']= false;
						$result['message']= 'Không thêm tiền chiêt khấu cho đại lý được! '.$apply_credit['message'];
					}
				}
				else{
					$result['success']= false;
					$result['message']= 'Không tạo được chiết khấu cho hóa đơn '.$update_invoice_object['message'];
				}
				/* Kết thúc: apply chiết khấu cho Invoice */
			}
			else{
				$result['success']= false;
				$result['message']= $result_api->message;
			}
		}
		return $result;
		
		
		
		
		
		
		
	}
	
	public static function upgradeOrder($data){
		$result= array();
		$postfields= array();
		$postfields= $data;
		$postfields['action']= 'upgradeproduct';
		$result_api= self::executeService($postfields);
		if($result_api->result== 'success'){
			$result['success']= true;
			$result['orderid']= $result_api->orderid;
			$result['invoiceid']= $result_api->invoiceid;
			
			$order_new= new Order();
			$order_new->id= (int)$result_api->orderid;
			$order_new->save();
		}
		else{
			$result['success']= false;
			$result['message']= $result_api->message;
		}
		return $result;
	}

	public static function convertOrder($order){
		$result= get_object_vars($order);
		if($result['paymentmethod']= 'mailin')
			$result['paymentmethod']= 'Thanh toán trực tiếp';
		$result['lineitems']= self::convertListOrderItems($order->lineitems->lineitem);
		return $result;
	}
	
	public static function convertOrderItem($order_item){
		$result= get_object_vars($order_item);
		if($order_item->type== 'domain')
			if((int)$result['billingcycle']== 1)
				$result['billingcycle']= $result['billingcycle'].' year';
			else
				$result['billingcycle']= $result['billingcycle'].' years';
		return $result;
	}
	
	
	public static function convertListOrders($orders, $data){
		$result = array();
		$sort_attribute= array();
		
		// if(isset($data['sort_attribute']) && isset($data['sort_type'])){
			// if(isset($data['date'])&& $data['date']!= ''){
				// foreach ($orders as $order) {
					// $tmp_order= self::convertOrder($order);
					// $tmp_date= str_split($tmp_order['date'],10);
					// if($data['date']== $tmp_date[0]){
						// $sort_attribute[]= $tmp_order[$data['sort_attribute']];
						// $result[]= self::convertOrder($order);
					// }
				// }
				// if(count($sort_attribute)>0){
					// if($data['sort_type']== 'SORT_ASC')
						// array_multisort($sort_attribute, SORT_ASC, $result);
					// else
						// array_multisort($sort_attribute, SORT_DESC, $result);
				// }
			// }
			// else{
				// foreach($orders as $order){
					// $tmp_order= self::convertOrder($order);
					// $sort_attribute[]= $tmp_order[$data['sort_attribute']];
					// $result[]= self::convertOrder($order);
				// }
				// if($data['sort_type']== 'SORT_ASC')
					// array_multisort($sort_attribute, SORT_ASC, $result);
				// else
					// array_multisort($sort_attribute, SORT_DESC, $result);
			// }
// 			
		// }
		// else{
			
			foreach($orders as $order){				
				$tmp_order= get_object_vars($order);
				if($tmp_order['paymentmethod']== 'mailin')
					$tmp_order['paymentmethod']= 'Thanh toán trực tiếp';
				$result[]= $tmp_order;
			}
			
		// }
		// $result= array_slice($result, $data['limitstart'], $data['limitnum']);
		return $result;
	}

	public static function convertListOrderItems($order_items){
		$result= array();
		foreach ($order_items as $order_item) {
			$result[]= self::convertOrderItem($order_item);
		}
		return $result;
	}
}
