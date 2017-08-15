<?php
class EmailService extends iPhoenixService{	
	public static function getEmptyEmail(){
		$result= array();
		$email= array(
					'id'=> '',
					'from'=> '',
					'to'=> '',
					'created_time'=> '',
					);
		
		$result['email']= $email;
		$result['success']= true;
		return $result;
	}
	
	public static function getEmptyEmailError(){
		$result= array();
		$email= array(
					'id'=> array(),
					'from'=> array(),
					'to'=> array(),
					'created_time'=> array(),
					);
		
		$result['email_error']= $email;
		$result['success']= true;
		return $result;
	}

	public static function init_bk($data){
		$result = array();
		if(isset($data['type']) && isset($data['id']) && $data['type'] != '' && $data['id'] != ''){
			// Init email
			$from = Yii::app()->params['admin_email'];

			switch ($data['type']) {
				case 'order':
					/*** Send order to vendor ***/
					// Get vendor list
					$list_vendor = array();
					$list_assigned_vendor_id = array();

					foreach(VendorCategory::model()->findAll() as $cat){
						$list_cat[$cat->id] = $cat->name;

						$criteria = new CDbCriteria();
						$criteria->compare('category_id', $cat->id);
						$list = VendorVendorCategory::model()->findAll($criteria);
						foreach($list as $item){
							$vendor = Vendor::model()->findByPk($item->vendor_id);
							if(isset($vendor)){
								$list_vendor[] = array('id'=>$vendor->email, 'email'=>$vendor->email, 'category'=>$cat->name);
								$list_assigned_vendor_id[] = $item->vendor_id;
							}
						}
					}

					$all_vendor = Vendor::model()->findAll();
					foreach($all_vendor as $vendor){
						if(!in_array($vendor->id, $list_assigned_vendor_id))
							$list_vendor[] = array('id'=>$vendor->id, 'email'=>$vendor->email, 'category'=>'Not assigned yet');					
					}

					$email_template = EmailTemplateService::getEmailTemplateByName(array('name'=>'EMAIL_ORDER_TO_VENDOR'));

					if($email_template['success']){
						$result['email'] = array(
							'from'=>Yii::app()->params['admin_email'],
							'to'=>0,
							'subject'=>$email_template['email_template']['subject'],
							'content'=>$email_template['email_template']['content'],
						);
						$empty_email_error= self::getEmptyEmailError();

						$result['success'] = true;
						$result['list_to'] = $list_vendor;
						$result['email_error']= $empty_email_error['email_error']; 
					}
					break;
				
				default:
					# code...
					break;
			}
		}
		else{
			$result = array('success'=>false, 'message'=>'Invalid request!');
		}

		return $result;
	}

	public static function init($data){
		$result = array();
		$email_title = '';
		if(isset($data['type']) && isset($data['id']) && $data['type'] != '' && $data['id'] != ''){
			// Init email
			$from = Setting::g('SYSTEM_EMAIL');
			$cc_string = Setting::g('SYSTEM_EMAIL_CC');
			$cc_string = preg_replace('/\s+/', '', $cc_string); // Remove all whitespace
			$cc = explode(",", $cc_string);

			switch ($data['type']) {
				case 'order':
					$email_default_version = 'standard';
					$email_title = 'Send Order Confirmation';
					if(isset($data['option']) && $data['option']== 'revise')
						$email_title = 'Send Revised Order Confirmation';

					/*** Send order to client ***/
					$purchase_order = PurchaseOrder::model()->findByPk($data['id']);
					if(isset($purchase_order)){
						$client = $purchase_order->client;
						if(isset($data['option']) && $data['option'] == 'revise')
							$email_template = EmailTemplateService::getEmailTemplateByName(array('name'=>'EMAIL_ORDER_TO_CLIENT_REVISED'));
						else
							$email_template = EmailTemplateService::getEmailTemplateByName(array('name'=>'EMAIL_ORDER_TO_CLIENT'));

						// Replace content
						$arr_variable = array("%CUSTOMER%", "%ORDER%", "%DATE%");
						$arr_value = array($client->name, $purchase_order->po_code, date('d/m/Y', $purchase_order->delivery_date));
						$email_template_subject = str_replace($arr_variable, $arr_value, $email_template['email_template']['subject']);
						$email_template_content = str_replace($arr_variable, $arr_value, $email_template['email_template']['content']);

						if($email_template['success']){
							$result['email'] = array(
								'from'=>$from,
								'cc'=>$cc,
								'to'=>isset($purchase_order->client)?$purchase_order->client->email:"No client info",
								'subject'=>$email_template_subject,
								'content'=>$email_template_content,
								'version'=> $email_default_version
							);
							$result['email_title'] = $email_title;

							$result['success'] = true;
							$empty_email_error= self::getEmptyEmailError();
							$result['email_error']= $empty_email_error['email_error']; 
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		}

		if(isset($data['type']) && $data['type'] == 'document'){
			$from = Yii::app()->params['admin_email'];

			$result['email'] = array(
				'from'=>Yii::app()->params['admin_email'],
				'to'=> '',
				'subject'=>'',
				'content'=>'',
			);
			$result['email_title'] = 'Email Documents';

			$result['success'] = true;
			$empty_email_error= self::getEmptyEmailError();
			$result['email_error']= $empty_email_error['email_error'];
		}

		if(!isset($data['type'])){
			$result = array('success'=>false, 'message'=>'Invalid request!');
		}

		return $result;
	}

	public static function changeVersionTemplate($data){
		if(isset($data['type']) && isset($data['version']) && isset($data['id']) && $data['type'] != '' && $data['id'] != ''){
			// Init email
			$from = Yii::app()->params['admin_email'];

			switch ($data['type']) {
				case 'order':
					if($data['version'] == 'standard'){
						$email_title = 'Send Order Confirmation';
						$template_name = 'EMAIL_ORDER_TO_CLIENT';
						if(isset($data['option']) && $data['option']== 'revise'){
							$email_title = 'Send Revised Order Confirmation';
							$template_name = 'EMAIL_ORDER_TO_CLIENT_REVISED';
						}
					}
					if($data['version'] == 'short'){
						$email_title = 'Send Order Confirmation | Short version';
						$template_name = 'EMAIL_ORDER_TO_CLIENT_SHORT';
						if(isset($data['option']) && $data['option']== 'revise'){
							$email_title = 'Send Revised Order Confirmation | Short version';
							$template_name = 'EMAIL_ORDER_TO_CLIENT_REVISED_SHORT';
						}
					}					

					$email_template = EmailTemplateService::getEmailTemplateByName(array('name'=>$template_name));

					$purchase_order = PurchaseOrder::model()->findByPk($data['id']);
					if(isset($purchase_order)){
						$client = $purchase_order->client;

						// Replace content
						$arr_variable = array("%CUSTOMER%", "%ORDER%", "%DATE%");
						$arr_value = array($client->name, $purchase_order->po_code, date('d/m/Y', $purchase_order->delivery_date));
						$email_template_subject = str_replace($arr_variable, $arr_value, $email_template['email_template']['subject']);
						$email_template_content = str_replace($arr_variable, $arr_value, $email_template['email_template']['content']);

						if($email_template['success']){
							$result['email'] = array(
								'from'=>Yii::app()->params['admin_email'],
								'to'=>isset($purchase_order->client)?$purchase_order->client->email:"No client info",
								'subject'=>$email_template_subject,
								'content'=>$email_template_content
							);
							$result['email_title'] = $email_title;

							$result['success'] = true;
							$empty_email_error= self::getEmptyEmailError();
							$result['email_error']= $empty_email_error['email_error']; 
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		}

		return $result;
	}
}
