<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PackProductService
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class PackProductService extends iPhoenixService{
    public static function createInit($data) {
        $result = array();
        $get_empty_packProduct = PackProductService::getEmptyPackProduct();
        if (isset($data['id']) && $data['id'] != '') {
            $packProduct = PackProductService::getPackProductById(array('id' => $data['id']));
            if ($packProduct['success'] == true) {
                $result['packProduct'] = $packProduct['packProduct'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['packProduct'] = $get_empty_packProduct['packProduct'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['packProduct'] = $get_empty_packProduct['packProduct'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['packProduct_empty'] = $get_empty_packProduct['packProduct'];
        $get_empty_packProduct_error = PackProductService::getEmptyPackProductError();
        $result['packProduct_error'] = $get_empty_packProduct_error['packProduct_error'];
        $result['packProduct_error_empty'] = $get_empty_packProduct_error['packProduct_error'];
        $result['success'] = true;
        return $result;
    }
    
    public static function getEmptyPackProduct() {
        $result = array();
        $packProduct = new PackProduction();
        $attribute_names = $packProduct->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['packProduct'][$attr] = '';
        }
        $result['packProduct']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyPackProductError() {
        $result = array();
        $packProduct = new PackProduction();
        $attribute_names = $packProduct->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['packProduct_error'][$attr] = [];
        }
        $result['packProduct_error']['tmp_file_ids'] = [];

        $result['success'] = true;
        return $result;
    }

    public static function getPackProductById($data) {
        $result = array();
        $get_empty_packProduct_error = PackProductService::getEmptyPackProductError();
        $result['packProduct_error'] = $get_empty_packProduct_error['packProduct_error'];

        $packProduct;
        $packProduct = PackProduction::model()->findByPk((int) $data['id']);
        if ($packProduct != null) {
            $result['success'] = true;
            $result['packProduct'] = self::convertPackProduct($packProduct);
        } else {
            $result['success'] = false;
            $result['message'] = 'PackProduct\'s not found!';
        }
        return $result;
    }

    public static function getPackProductByProjectId($data) {
        $result = array();
        $get_empty_packProduct_error = PackProductService::getEmptyPackProductError();
        $result['packProduct_error'] = $get_empty_packProduct_error['packProduct_error'];

        $packProduct;
        $packProduct = PackProduction::model()->findByAttributes(['project_id' => (int) $data['id']]);
        if ($packProduct != null) {
            $result['success'] = true;
            $result['packProduct'] = self::convertPackProduct($packProduct);
        } else {
            $result['success'] = false;
            $result['message'] = 'PackProduct\'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $packProduct = null;
        if (isset($data['id']) && $data['id']) {
            $packProduct = PackProduction::model()->findByPk((int) $data['id']);
        }
        if (!$packProduct) {
            $packProduct = new PackProduction();
        }
        
        $packProduct->attributes = $data;

        if(!is_integer($packProduct->date)){
            $packProduct->date = strtotime($packProduct->date);
        }
        $packProduct->date = (int)$packProduct->date;
        
        if(!is_integer($packProduct->plant_manager_date)){
            $packProduct->plant_manager_date = strtotime($packProduct->plant_manager_date);
        }
        $packProduct->plant_manager_date = (int)$packProduct->plant_manager_date;
        
        $packProduct = PackProductService::beforeSave($packProduct);
        if ($packProduct->validate()) {
            $packProduct->save();
            $result['success'] = true;
            $result['id'] = $packProduct->id;
            $new_packProduct = self::getPackProductById(array('id' => $packProduct->id));
            $result['packProduct'] = $new_packProduct['packProduct'];
        } else {
            $empty_packProduct_error = PackProductService::getEmptyPackProductError();
            $result['packProduct_error'] = $empty_packProduct_error['packProduct_error'];
            foreach ($packProduct->getErrors() as $key => $error_array) {
                $result['packProduct_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating PackProduct has some errors';
            $result['error_array'] = $packProduct->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $packProduct = PackProduction::model()->findByPk((int) $data['id']);
        if (!$packProduct) {
            $packProduct = new PackProduction();
        }
        $packProduct->attributes = $data;
        $packProduct = PackProductService::beforeSave($packProduct);
        if ($packProduct->validate()) {
            $packProduct->save();
            $result['success'] = true;
            $packProduct_array = PackProductService::getPackProductById(array('id' => $packProduct->id));
            $get_empty_packProduct_error = PackProductService::getEmptyPackProductError();
            $result['packProduct_error'] = $get_empty_packProduct_error['packProduct_error'];
            $result['packProduct'] = $packProduct_array['packProduct'];
            $result['id'] = $packProduct->id;
        } else {
            $empty_packProduct_error = PackProductService::getEmptyPackProductError();
            $result['packProduct_error'] = $empty_packProduct_error['packProduct_error'];
            foreach ($packProduct->getErrors() as $key => $error_array) {
                $result['packProduct_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update PackProduct has some errors';
            $result['error_array'] = $packProduct->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if (!isset($data['id'])) {
            $result['success'] = false;
            return $result;
        }
        $packProduct = PackProduction::model()->findByPk((int) $data['id']);
        if (!$packProduct) {
            $result['success'] = false;
            return $result;
        }
        $packProduct->in_trash = 1;
        if ($packProduct->save(false)) {
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($packProduct) {

        if ($packProduct->isNewRecord) {
            // $packProduct->status = 1;
            $packProduct->created_time = time();
        } else if (isset($packProduct->updated_time)) {
            $packProduct->updated_time = time();
        }
        
        if(isset($packProduct->date) && !is_int($packProduct->date)){
            $packProduct->date = strtotime($packProduct->date);
        }
        
        if(isset($packProduct->plant_manager_date) && !is_int($packProduct->plant_manager_date)){
            $packProduct->plant_manager_date = strtotime($packProduct->plant_manager_date);
        }
        return $packProduct;
    }

    public static function convertListPackProduct($packProducts, $isRelated = true) {
        $result = array();
        if ($packProducts != null && count($packProducts) > 0) {
            foreach ($packProducts as $packProduct) {
                $result[] = self::convertPackProduct($packProduct, $isRelated);
            }
        }
        return $result;
    }

    public static function convertPackProduct($packProduct, $isRelated = true) {
        if (is_array($packProduct)) {
            $result = $packProduct;
            $id = isset($packProduct['id']) ? $packProduct['id'] : 0;
            $packProduct = PackProduction::model()->findByPk($id);
        } else {
            $result = $packProduct->attributes;
        }
        if (isset($result['date']) && $result['date']) {
            //                if(is_integer($packProduct['date'])){

            $result['date'] = date('Y-m-d', $result['date']);
            //                }
        }
        
        if (isset($result['plant_manager_date']) && $result['plant_manager_date']) {
            //                if(is_integer($packProduct['date'])){

            $result['plant_manager_date'] = date('Y-m-d', $result['plant_manager_date']);
            //                }
        }
        $result['tmp_file_ids'] = $packProduct->tmp_file_ids;
        return $result;
    }
}
