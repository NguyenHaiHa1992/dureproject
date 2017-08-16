<?php

class CustomerService extends iPhoenixService {

    public static function createInit($data) {
        $result = array();
        $get_empty_customer = CustomerService::getEmptyCustomer();
        if (isset($data['id']) && $data['id'] != '') {
            $customer = CustomerService::getCustomerById(array('id' => $data['id']));
            if ($customer['success'] == true) {
                $result['customer'] = $customer['customer'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['customer'] = $get_empty_customer['customer'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['customer'] = $get_empty_customer['customer'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['customer_empty'] = $get_empty_customer['customer'];
        $get_empty_customer_error = CustomerService::getEmptyCustomerError();
        $result['customer_error'] = $get_empty_customer_error['customer_error'];
        $result['customer_error_empty'] = $get_empty_customer_error['customer_error'];
        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = true) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Customer::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'ORDER BY tbl_customer.' . $data['sort_attribute'] . ' ' . $data['sort_type'];

//        if(isset($data['signage_id']) && $data['signage_id']){
//            $sql = "SELECT tbl_customer.*, tbl_customer_signage.signage_quantity, tbl_customer_signage.id customer_signage_id FROM tbl_customer ";
//        }
//        else{
//            $sql = "SELECT tbl_customer.* FROM tbl_customer ";
//        }
        $sql = "SELECT tbl_customer.* FROM tbl_customer ";
        if(isset($data['signage_id']) && $data['signage_id']){
            $sql = $sql . " INNER JOIN tbl_customer_signage ON tbl_customer.id = tbl_customer_signage.customer_id AND tbl_customer_signage.signage_id = ".$data['signage_id'];
        }
        $sql = $sql . " Where 1 ";

        if (isset($data['ship_to']) && $data['ship_to'] != '') {
            $sql = $sql . "And tbl_customer.ship_to LIKE '%" . $data['ship_to'] . "%' ";
        }
        if (isset($data['ship_oa']) && $data['ship_oa'] != '') {
            $sql = $sql . "And tbl_customer.ship_oa LIKE '%" . $data['ship_oa'] . "%' ";
        }
        if (isset($data['ship_address']) && $data['ship_address'] != '') {
            $sql = $sql . "And tbl_customer.ship_address LIKE '%" . $data['ship_address'] . "%' ";
        }
        if (isset($data['bill_to']) && $data['bill_to'] != '') {
            $sql = $sql . "And tbl_customer.bill_to LIKE '%" . $data['bill_to'] . "%' ";
        }
        
        if (isset($data['bill_oa']) && $data['bill_oa'] != '') {
            $sql = $sql . "And tbl_customer.bill_oa LIKE '%" . $data['bill_oa'] . "%' ";
        }
        
        if (isset($data['bill_address']) && $data['bill_address'] != '') {
            $sql = $sql . "And tbl_customer.bill_address LIKE '%" . $data['bill_address'] . "%' ";
        }
        
        if (isset($data['phone']) && $data['phone'] != '') {
            $sql = $sql . "And tbl_customer.phone LIKE '%" . $data['phone'] . "%' ";
        }
        
        if (isset($data['fax']) && $data['fax'] != '') {
            $sql = $sql . "And tbl_customer.fax LIKE '%" . $data['fax'] . "%' ";
        }
        $sql = $sql . "And tbl_customer.in_trash = 0 ";
        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
//        $customers = Customer::model()->findAllBySql($sql);
        $customers = Yii::app()->db->createCommand($sql)->queryAll();
        
        $criteria = new CDbCriteria();
        if(isset($data['signage_id']) && $data['signage_id']){
            $criteria->join = "INNER JOIN tbl_customer_signage ON t.id = tbl_customer_signage.customer_id AND tbl_customer_signage.signage_id = ".$data['signage_id'];
        }
        if (isset($data['ship_to']) && $data['ship_to'] != '') {
            $criteria->compare('ship_to', $data['ship_to'], true);
        }
        if (isset($data['ship_oa']) && $data['ship_oa'] != '') {
            $criteria->compare('ship_oa', $data['ship_oa'], true);
        }
        if (isset($data['ship_address']) && $data['ship_address'] != '') {
            $criteria->compare('ship_address', $data['ship_address'], true);
        }
        
        if (isset($data['bill_to']) && $data['bill_to'] != '') {
            $criteria->compare('bill_to', $data['bill_to'], true);
        }
        if (isset($data['bill_oa']) && $data['bill_oa'] != '') {
            $criteria->compare('bill_oa', $data['bill_oa'], true);
        }
        if (isset($data['bill_address']) && $data['bill_address'] != '') {
            $criteria->compare('bill_address', $data['bill_address'], true);
        }
        if (isset($data['phone']) && $data['phone'] != '') {
            $criteria->compare('phone', $data['phone'], true);
        }
        if (isset($data['fax']) && $data['fax'] != '') {
            $criteria->compare('fax', $data['fax'], true);
        }
        $criteria->compare('t.in_trash', 0);
        $total = Customer::model()->count($criteria);

        if ($customers != null) {
            $result['success'] = true;
            $result['customers'] = self::convertListCustomer($customers, $isRelated);

            $result['totalresults'] = $total;
            $result['start_customer'] = (int) $data['limitstart'] + 1;
            $result['end_customer'] = (int) $data['limitstart'] + count($customers);
        } else {
            $result['success'] = true;
            $result['customers'] = array();
            $result['totalresults'] = $total;
            $result['start_customer'] = 0;
            $result['end_customer'] = 0;
        }
        return $result;
    }

    public static function getEmptyCustomer() {
        $result = array();
        $customer = new Customer();
        $attribute_names = $customer->attributeNames();
        foreach($attribute_names as $attr){
          $result['customer'][$attr] = '';
        }
        $result['customer']['tmp_file_ids'] = '';
        $result['customer']['state_name'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyCustomerError() {
      $result = array();
      $customer = new Customer();
      $attribute_names = $customer->attributeNames();
      foreach($attribute_names as $attr){
        $result['customer_error'][$attr] = [];
      }
      $result['customer_error']['tmp_file_ids'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getCustomerById($data) {
        $result = array();
        $get_empty_customer_error = CustomerService::getEmptyCustomerError();
        $result['customer_error'] = $get_empty_customer_error['customer_error'];

        $customer;
        $customer = Customer::model()->findByPk((int) $data['id']);
        if ($customer != null) {
            $result['success'] = true;
            $result['customer'] = self::convertCustomer($customer);
        } else {
            $result['success'] = false;
            $result['message'] = 'Customer\'s not found!';
        }
        return $result;
    }

    public static function getCustomersByCategoryId($data) {//data['id']
        $result = array();
        $customers = Customer::model()->findAllByAttributes(array('category_id' => $data['id']));
        if ($customers != null && count($customers) > 0) {
            $result['success'] = true;
            $result['customers'] = self::convertListCustomer($customers, $data);
        } else {
            $result['success'] = true;
            $result['customers'] = array();
        }
        return $result;
    }

    public static function getEmailTemplateByName($data) {
        $result = array();
        $email_template = EmailTemplate::model()->findByAttributes(array('name' => $data['name']));
        if ($email_template != null) {
            $result['success'] = true;
            $result['email_template'] = self::convertEmailTemplate($email_template);
        } else {
            $result['success'] = false;
            $result['message'] = 'Không tồn tại Email Template này!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $customer = new Customer();
        $customer->attributes = $data;
        $customer = CustomerService::beforeSave($customer);
        if ($customer->validate()) {
            $customer->save();
            $result['success'] = true;
            $result['id'] = $customer->id;
            $new_customer = self::getCustomerById(array('id' => $customer->id));
            $result['customer'] = $new_customer['customer'];
        } else {
            $empty_customer_error = CustomerService::getEmptyCustomerError();
            $result['customer_error'] = $empty_customer_error['customer_error'];
            foreach ($customer->getErrors() as $key => $error_array) {
                $result['customer_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Customer has some errors';
            $result['error_array'] = $customer->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $customer = Customer::model()->findByPk((int) $data['id']);
        $customer->attributes = $data;
        $customer = CustomerService::beforeSave($customer);
        if ($customer->validate()) {
            $customer->save();
            $result['success'] = true;
            $customer_array = CustomerService::getCustomerById(array('id' => $customer->id));
            $get_empty_customer_error = CustomerService::getEmptyCustomerError();
            $result['customer_error'] = $get_empty_customer_error['customer_error'];
            $result['customer'] = $customer_array['customer'];
            $result['id'] = $customer->id;
        } else {
            $empty_customer_error = CustomerService::getEmptyCustomerError();
            $result['customer_error'] = $empty_customer_error['customer_error'];
            foreach ($customer->getErrors() as $key => $error_array) {
                $result['customer_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Customer has some errors';
            $result['error_array'] = $customer->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $customer = Customer::model()->findByPk((int)$data['id']);
        if(!$customer){
            $result['success'] = false;
            return $result;
        }
        $customer->in_trash = 1;
        if($customer->save()){
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($customer) {
        if ($customer->isNewRecord) {
            $customer->status = 1;
            $customer->created_time = time();
//            $customer->created_by = Yii::app()->user->id;
        }
        else{
            $customer->updated_time = time();
        }
        return $customer;
    }

    public static function convertListCustomer($customers, $isRelated = true) {
        $result = array();
        if ($customers != null && count($customers) > 0) {
            foreach ($customers as $customer) {
                $result[] = self::convertCustomer($customer, $isRelated);
            }
        }
        return $result;
    }

    public static function convertCustomer($customer, $isRelated = true) {
        if(is_array($customer)){
            $result = $customer;
            $id = isset($customer['id']) ? $customer['id'] : 0;
            $customer = Customer::model()->findByPk($id);
        }
        else{
            $result = $customer->attributes;
        }
        $result['tmp_file_ids'] = $customer->tmp_file_ids;
//        if($isRelated){
//            $result['customer_signages'] = $customer->getListSignage();
//            $result['customer_fixtures'] = $customer->getListFixture();
//        }
        
//        if($customer->open_date){
//            $result['open_date'] = date('Y-m-d', $customer->open_date);
//        }
//        $result['image_id_url'] = $customer->image && $customer->image->getThumbUrl(80, 80, false)
//                ? "server/".$customer->image->getThumbUrl(80, 80, false)
//                : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        return $result;
    }
    
    public static function copy($data) {
        $result = array();
        $id = isset($data['id']) ? (int)$data['id'] : null;
        $customerCopy = Customer::model()->findByPk($id);
        if(!$customerCopy){
            $result['success'] = false;
            $result['message'] = 'Customer copy is not found';
            return $result;
        }
        $customer = new Customer();
        $customer->attributes = $customerCopy->attributes;
//        $customer->name = time()."_".CustomEnum::COPY_CODE.$customerCopy->name;
        $customer = CustomerService::beforeSave($customer);
        if ($customer->validate()) {
            $customer->save();
            $result['success'] = true;
            $result['id'] = $customer->id;
            $new_customer = self::getCustomerById(array('id' => $customer->id));
            $result['customer'] = $new_customer['customer'];
            
            // create CustomerSignage
//            self::copyRelate('CustomerSignage', 'customer_id', $customerCopy->id, $customer->id);
            // create CustomerFixture
//            self::copyRelate('CustomerFixture', 'customer_id', $customerCopy->id, $customer->id);
            // create CustomerFile
//            self::copyRelate('CustomerFile', 'customer_id', $customerCopy->id, $customer->id);
        } else {
            $empty_customer_error = CustomerService::getEmptyCustomerError();
            $result['customer_error'] = $empty_customer_error['customer_error'];
            foreach ($customer->getErrors() as $key => $error_array) {
                $result['customer_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Customer has some errors';
            $result['error_array'] = $customer->getErrors();
        }

        return $result;
    }
}
