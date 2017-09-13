<?php

/*
 * To change this license header, choose License Headers in ProductDevelopment Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductService
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class ProductService extends iPhoenixService {
    
    public static function createInit($data) {
        $result = array();
        $get_empty_productDevelopment = ProductService::getEmptyProductDevelopment();
        if (isset($data['id']) && $data['id'] != '') {
            $productDevelopment = ProductService::getProductDevelopmentById(array('id' => $data['id']));
            if ($productDevelopment['success'] == true) {
                $result['productDevelopment'] = $productDevelopment['productDevelopment'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['productDevelopment'] = $get_empty_productDevelopment['productDevelopment'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['productDevelopment'] = $get_empty_productDevelopment['productDevelopment'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['productDevelopment_empty'] = $get_empty_productDevelopment['productDevelopment'];
        $get_empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
        $result['productDevelopment_error'] = $get_empty_productDevelopment_error['productDevelopment_error'];
        $result['productDevelopment_error_empty'] = $get_empty_productDevelopment_error['productDevelopment_error'];
        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = true) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = ProductDevelopment::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $criteria = new CDbCriteria();
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
        $criteria->order = $data['sort_attribute'] . ' ' . $data['sort_type'];
        $criteria->limit = $data['limitnum'];
        $criteria->offset = $data['limitstart'];

        $productDevelopments = ProductDevelopment::model()->findAll($criteria);
        $total = count($productDevelopments);

        if ($productDevelopments != null) {
            $result['success'] = true;
            $result['productDevelopments'] = self::convertListProductDevelopment($productDevelopments, $isRelated);

            $result['totalresults'] = $total;
            $result['start_productDevelopment'] = (int) $data['limitstart'] + 1;
            $result['end_productDevelopment'] = (int) $data['limitstart'] + count($productDevelopments);
        } else {
            $result['success'] = true;
            $result['productDevelopments'] = array();
            $result['totalresults'] = $total;
            $result['start_productDevelopment'] = 0;
            $result['end_productDevelopment'] = 0;
        }
        return $result;
    }

    public static function getEmptyProductDevelopment() {
        $result = array();
        $productDevelopment = new ProductDevelopment();
        $attribute_names = $productDevelopment->attributeNames();
        foreach($attribute_names as $attr){
          $result['productDevelopment'][$attr] = '';
        }
        $result['productDevelopment']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyProductDevelopmentError() {
      $result = array();
      $productDevelopment = new ProductDevelopment();
      $attribute_names = $productDevelopment->attributeNames();
      foreach($attribute_names as $attr){
        $result['productDevelopment_error'][$attr] = [];
      }
      $result['productDevelopment_error']['tmp_file_ids'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getProductDevelopmentById($data) {
        $result = array();
        $get_empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
        $result['productDevelopment_error'] = $get_empty_productDevelopment_error['productDevelopment_error'];

        $productDevelopment;
        $productDevelopment = ProductDevelopment::model()->findByPk((int) $data['id']);
        if ($productDevelopment != null) {
            $result['success'] = true;
            $result['productDevelopment'] = self::convertProductDevelopment($productDevelopment);
        } else {
            $result['success'] = false;
            $result['message'] = 'ProductDevelopment\'s not found!';
        }
        return $result;
    }

    public static function getProductByProjectId($data){
        $result = array();
        $get_empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
        $result['productDevelopment_error'] = $get_empty_productDevelopment_error['productDevelopment_error'];

        $productDevelopment;
        $productDevelopment = ProductDevelopment::model()->findByAttributes(['project_id' => (int)$data['id']]);
        if ($productDevelopment != null) {
            $result['success'] = true;
            $result['productDevelopment'] = self::convertProductDevelopment($productDevelopment);
        } else {
            $result['success'] = false;
            $result['message'] = 'ProductDevelopment\'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $productDevelopment = null;
        if(isset($data['id']) && $data['id']){
            $productDevelopment = ProductDevelopment::model()->findByPk((int)$data['id']);
        }
        if(!$productDevelopment){
            $productDevelopment = new ProductDevelopment();
        }

        $productDevelopment->attributes = $data;
        
        $productDevelopment = ProductService::beforeSave($productDevelopment);
        if ($productDevelopment->validate()) {
            $productDevelopment->save();
            $result['success'] = true;
            $result['id'] = $productDevelopment->id;
            $new_productDevelopment = self::getProductDevelopmentById(array('id' => $productDevelopment->id));
            $result['productDevelopment'] = $new_productDevelopment['productDevelopment'];
        } else {
            $empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
            $result['productDevelopment_error'] = $empty_productDevelopment_error['productDevelopment_error'];
            foreach ($productDevelopment->getErrors() as $key => $error_array) {
                $result['productDevelopment_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating ProductDevelopment has some errors';
            $result['error_array'] = $productDevelopment->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $productDevelopment = ProductDevelopment::model()->findByPk((int) $data['id']);
        $productDevelopment->attributes = $data;
        $productDevelopment = ProductService::beforeSave($productDevelopment);
        if ($productDevelopment->validate()) {
            $productDevelopment->save();
            $result['success'] = true;
            $productDevelopment_array = ProductService::getProductDevelopmentById(array('id' => $productDevelopment->id));
            $get_empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
            $result['productDevelopment_error'] = $get_empty_productDevelopment_error['productDevelopment_error'];
            $result['productDevelopment'] = $productDevelopment_array['productDevelopment'];
            $result['id'] = $productDevelopment->id;
        } else {
            $empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
            $result['productDevelopment_error'] = $empty_productDevelopment_error['productDevelopment_error'];
            foreach ($productDevelopment->getErrors() as $key => $error_array) {
                $result['productDevelopment_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update ProductDevelopment has some errors';
            $result['error_array'] = $productDevelopment->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $productDevelopment = ProductDevelopment::model()->findByPk((int)$data['id']);
        if(!$productDevelopment){
            $result['success'] = false;
            return $result;
        }
        $productDevelopment->in_trash = 1;
        if($productDevelopment->save(false)){
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($productDevelopment) {
        
        if ($productDevelopment->isNewRecord) {
            // $productDevelopment->status = 1;
            $productDevelopment->created_time = time();
        }
        else{
//            $productDevelopment->updated_time = time();
        }
        return $productDevelopment;
    }

    public static function convertListProductDevelopment($productDevelopments, $isRelated = true) {
        $result = array();
        if ($productDevelopments != null && count($productDevelopments) > 0) {
            foreach ($productDevelopments as $productDevelopment) {
                $result[] = self::convertProductDevelopment($productDevelopment, $isRelated);
            }
        }
        return $result;
    }

    public static function convertProductDevelopment($productDevelopment, $isRelated = true) {
        if(is_array($productDevelopment)){
            $result = $productDevelopment;
            $id = isset($productDevelopment['id']) ? $productDevelopment['id'] : 0;
            $productDevelopment = ProductDevelopment::model()->findByPk($id);
        }
        else{
            $result = $productDevelopment->attributes;
        }
       if(isset($result['date']) && $result['date']){
        //                if(is_integer($productDevelopment['date'])){

                            $result['date'] = date('Y-m-d' ,$result['date']);
        //                }
        }
        $result['tmp_file_ids'] = $productDevelopment->tmp_file_ids;
        return $result;
    }
    
    public static function copy($data) {
        $result = array();
        $id = isset($data['id']) ? (int)$data['id'] : null;
        $productDevelopmentCopy = ProductDevelopment::model()->findByPk($id);
        if(!$productDevelopmentCopy){
            $result['success'] = false;
            $result['message'] = 'ProductDevelopment copy is not found';
            return $result;
        }
        $productDevelopment = new ProductDevelopment();
        $productDevelopment->attributes = $productDevelopmentCopy->attributes;
//        $productDevelopment->name = time()."_".CustomEnum::COPY_CODE.$productDevelopmentCopy->name;
        $productDevelopment = ProductService::beforeSave($productDevelopment);
        if ($productDevelopment->validate()) {
            $productDevelopment->save();
            $result['success'] = true;
            $result['id'] = $productDevelopment->id;
            $new_productDevelopment = self::getProductDevelopmentById(array('id' => $productDevelopment->id));
            $result['productDevelopment'] = $new_productDevelopment['productDevelopment'];
        } else {
            $empty_productDevelopment_error = ProductService::getEmptyProductDevelopmentError();
            $result['productDevelopment_error'] = $empty_productDevelopment_error['productDevelopment_error'];
            foreach ($productDevelopment->getErrors() as $key => $error_array) {
                $result['productDevelopment_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating ProductDevelopment has some errors';
            $result['error_array'] = $productDevelopment->getErrors();
        }

        return $result;
    }
}
