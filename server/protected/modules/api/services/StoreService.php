<?php

class StoreService extends iPhoenixService {

    public static function createInit($data) {
        $result = array();
        $get_empty_store = StoreService::getEmptyStore();
        if (isset($data['id']) && $data['id'] != '') {
            $store = StoreService::getStoreById(array('id' => $data['id']));
            if ($store['success'] == true) {
                $result['store'] = $store['store'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['store'] = $get_empty_store['store'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['store'] = $get_empty_store['store'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['store_empty'] = $get_empty_store['store'];
        $get_empty_store_error = StoreService::getEmptyStoreError();
        $result['store_error'] = $get_empty_store_error['store_error'];
        $result['store_error_empty'] = $get_empty_store_error['store_error'];

        $tiers = TierService::getAll(array());
        $result['tiers'] = $tiers['tiers'];

        $states = StateService::getAll(array());
        $result['states'] = $states['states'];

        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = true) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Store::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'ORDER BY tbl_store.' . $data['sort_attribute'] . ' ' . $data['sort_type'];

        if(isset($data['signage_id']) && $data['signage_id']){
            $sql = "SELECT tbl_store.*, tbl_store_signage.signage_quantity, tbl_store_signage.id store_signage_id FROM tbl_store ";
        }
        else{
            $sql = "SELECT tbl_store.* FROM tbl_store ";
        }
        
        if(isset($data['signage_id']) && $data['signage_id']){
            $sql = $sql . " INNER JOIN tbl_store_signage ON tbl_store.id = tbl_store_signage.store_id AND tbl_store_signage.signage_id = ".$data['signage_id'];
        }
        if(isset($data['fixture_id']) && $data['fixture_id']){
            $sql = $sql . " INNER JOIN tbl_store_fixture ON tbl_store.id = tbl_store_fixture.store_id AND tbl_store_fixture.fixture_id = ".$data['fixture_id'];
        }
        $sql = $sql . " Where 1 ";

        if (isset($data['tier_id']) && $data['tier_id'] != '') {
            $sql = $sql . "And tbl_store.tier_id = " . $data['tier_id'] . " ";
        }
        if (isset($data['name']) && $data['name'] != '') {
            $sql = $sql . "And tbl_store.name LIKE '%" . $data['name'] . "%' ";
        }
        if (isset($data['email']) && $data['email'] != '') {
            $sql = $sql . "And tbl_store.email LIKE '%" . $data['email'] . "%' ";
        }
        if (isset($data['city']) && $data['city'] != '') {
            $sql = $sql . "And tbl_store.city LIKE '%" . $data['city'] . "%' ";
        }
        if (isset($data['country']) && $data['country'] != '') {
            $sql = $sql . "And tbl_store.country LIKE '%" . $data['country'] . "%' ";
        }
        $sql = $sql . "And tbl_store.in_trash = 0 ";
        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
//        $stores = Store::model()->findAllBySql($sql);
        $stores = Yii::app()->db->createCommand($sql)->queryAll();
        
        $criteria = new CDbCriteria();
        if(isset($data['signage_id']) && $data['signage_id']){
            $criteria->join = "INNER JOIN tbl_store_signage ON t.id = tbl_store_signage.store_id AND tbl_store_signage.signage_id = ".$data['signage_id'];
        }
        if(isset($data['fixture_id']) && $data['fixture_id']){
            $criteria->join = "INNER JOIN tbl_store_fixture ON t.id = tbl_store_fixture.store_id AND tbl_store_fixture.fixture_id = ".$data['fixture_id'];
        }
        if (isset($data['tier_id']) && $data['tier_id'] != '') {
            $criteria->compare('tier_id', $data['tier_id']);
        }
        if (isset($data['name']) && $data['name'] != '') {
            $criteria->compare('name', $data['name'], true);
        }
        if (isset($data['email']) && $data['email'] != '') {
            $criteria->compare('email', $data['email'], true);
        }
        if (isset($data['city']) && $data['city'] != '') {
            $criteria->compare('city', $data['city'], true);
        }
        $criteria->compare('t.in_trash', 0);
        $total = Store::model()->count($criteria);

        if ($stores != null) {
            $result['success'] = true;
            $result['stores'] = self::convertListStore($stores, $isRelated);

            $result['totalresults'] = $total;
            $result['start_store'] = (int) $data['limitstart'] + 1;
            $result['end_store'] = (int) $data['limitstart'] + count($stores);
        } else {
            $result['success'] = true;
            $result['stores'] = array();
            $result['totalresults'] = $total;
            $result['start_store'] = 0;
            $result['end_store'] = 0;
        }
        return $result;
    }

    public static function getEmptyStore() {
        $result = array();
        $store = new Store();
        $attribute_names = $store->attributeNames();
        foreach($attribute_names as $attr){
          $result['store'][$attr] = '';
        }
        $result['store']['tmp_file_ids'] = '';
        $result['store']['state_name'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyStoreError() {
      $result = array();
      $store = new Store();
      $attribute_names = $store->attributeNames();
      foreach($attribute_names as $attr){
        $result['store_error'][$attr] = [];
      }
      $result['store_error']['tmp_file_ids'] = [];
      $result['store_error']['state_name'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getStoreById($data) {
        $result = array();
        $get_empty_store_error = StoreService::getEmptyStoreError();
        $result['store_error'] = $get_empty_store_error['store_error'];

        $store;
        $store = Store::model()->findByPk((int) $data['id']);
        if ($store != null) {
            $result['success'] = true;
            $result['store'] = self::convertStore($store);
        } else {
            $result['success'] = false;
            $result['message'] = 'Store\'s not found!';
        }
        return $result;
    }

    public static function getStoresByCategoryId($data) {//data['id']
        $result = array();
        $stores = Store::model()->findAllByAttributes(array('category_id' => $data['id']));
        if ($stores != null && count($stores) > 0) {
            $result['success'] = true;
            $result['stores'] = self::convertListStore($stores, $data);
        } else {
            $result['success'] = true;
            $result['stores'] = array();
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
        $store = new Store();
        $store->attributes = $data;
        $store = StoreService::beforeSave($store);
        if ($store->validate()) {
            $store->save();
            $result['success'] = true;
            $result['id'] = $store->id;
            $new_store = self::getStoreById(array('id' => $store->id));
            $result['store'] = $new_store['store'];
        } else {
            $empty_store_error = StoreService::getEmptyStoreError();
            $result['store_error'] = $empty_store_error['store_error'];
            foreach ($store->getErrors() as $key => $error_array) {
                $result['store_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Store has some errors';
            $result['error_array'] = $store->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $store = Store::model()->findByPk((int) $data['id']);
        $store->attributes = $data;

        $store = StoreService::beforeSave($store);
        if ($store->validate()) {
            $store->save();
            $result['success'] = true;
            $store_array = StoreService::getStoreById(array('id' => $store->id));
            $get_empty_store_error = StoreService::getEmptyStoreError();
            $result['store_error'] = $get_empty_store_error['store_error'];
            $result['store'] = $store_array['store'];
            $result['id'] = $store->id;
        } else {
            $empty_store_error = StoreService::getEmptyStoreError();
            $result['store_error'] = $empty_store_error['store_error'];
            foreach ($store->getErrors() as $key => $error_array) {
                $result['store_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Store has some errors';
            $result['error_array'] = $store->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $store = Store::model()->findByPk((int)$data['id']);
        if(!$store){
            $result['success'] = false;
            return $result;
        }
        $store->in_trash = 1;
        if($store->save()){
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($store) {
        if ($store->isNewRecord) {
            $store->status = 1;
            $store->created_time = time();
            $store->created_by = Yii::app()->user->id;
        }
        else{
            $store->updated_time = time();
        }
        if($store->open_date && strtotime($store->open_date)){
            $store->open_date = strtotime($store->open_date.' 00:00:00');
        }
        return $store;
    }

    public static function convertListStore($stores, $isRelated = true) {
        $result = array();
        if ($stores != null && count($stores) > 0) {
            foreach ($stores as $store) {
                $result[] = self::convertStore($store, $isRelated);
            }
        }
        return $result;
    }

    public static function convertStore($store, $isRelated = true) {
        if(is_array($store)){
            $result = $store;
            $id = isset($store['id']) ? $store['id'] : 0;
            $store = Store::model()->findByPk($id);
        }
        else{
            $result = $store->attributes;
        }
        $result['state_name'] =  isset($store->state) ? $store->state->state_short : "N/A";
        $result['tier_name'] =  isset($store->tier) ? $store->tier->name : "N/A";
        $result['tmp_file_ids'] = $store->tmp_file_ids;
        if($isRelated){
            $result['store_signages'] = $store->getListSignage();
            $result['store_fixtures'] = $store->getListFixture();
        }
        
        if($store->open_date){
            $result['open_date'] = date('Y-m-d', $store->open_date);
        }
        $result['image_id_url'] = $store->image && $store->image->getThumbUrl(80, 80, false)
                ? "server/".$store->image->getThumbUrl(80, 80, false)
                : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        return $result;
    }
    
    public static function copy($data) {
        $result = array();
        $id = isset($data['id']) ? (int)$data['id'] : null;
        $storeCopy = Store::model()->findByPk($id);
        if(!$storeCopy){
            $result['success'] = false;
            $result['message'] = 'Store copy is not found';
            return $result;
        }
        $store = new Store();
        $store->attributes = $storeCopy->attributes;
        $store->name = time()."_".CustomEnum::COPY_CODE.$storeCopy->name;
        $store = StoreService::beforeSave($store);
        if ($store->validate()) {
            $store->save();
            $result['success'] = true;
            $result['id'] = $store->id;
            $new_store = self::getStoreById(array('id' => $store->id));
            $result['store'] = $new_store['store'];
            
            // create StoreSignage
            self::copyRelate('StoreSignage', 'store_id', $storeCopy->id, $store->id);
            // create StoreFixture
            self::copyRelate('StoreFixture', 'store_id', $storeCopy->id, $store->id);
            // create StoreFile
            self::copyRelate('StoreFile', 'store_id', $storeCopy->id, $store->id);
        } else {
            $empty_store_error = StoreService::getEmptyStoreError();
            $result['store_error'] = $empty_store_error['store_error'];
            foreach ($store->getErrors() as $key => $error_array) {
                $result['store_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Store has some errors';
            $result['error_array'] = $store->getErrors();
        }

        return $result;
    }
}
