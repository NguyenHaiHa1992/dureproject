<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaleService
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class SaleService extends iPhoenixService{
    
    public static function createInit($data) {
        $result = array();
        $get_empty_sale = SaleService::getEmptySale();
        if (isset($data['id']) && $data['id'] != '') {
            $sale = SaleService::getSaleById(array('id' => $data['id']));
            if ($sale['success'] == true) {
                $result['sale'] = $sale['sale'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['sale'] = $get_empty_sale['sale'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['sale'] = $get_empty_sale['sale'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }
        $result['sale']['formAttributes'] = self::formAttributes();
        $result['sale_empty'] = $get_empty_sale['sale'];
        $get_empty_sale_error = SaleService::getEmptySaleError();
        $result['sale_error'] = $get_empty_sale_error['sale_error'];
        $result['sale_error_empty'] = $get_empty_sale_error['sale_error'];

        $result['libTypeProductInfo'] = Sale::getTypeProductInfo();
        $result['libTypeOfPacking'] = Sale::getTypeOfPacking();
        $result['libPackPlain'] = Sale::getPackPlain();
        $result['libPackCustomer'] = Sale::getPackCustomer();

        $result['success'] = true;
        return $result;
    }
    
    public static function getEmptySale() {
        $result = array();
        $sale = new Sale();
        $attribute_names = $sale->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['sale'][$attr] = '';
        }
        $result['sale']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptySaleError() {
        $result = array();
        $sale = new Sale();
        $attribute_names = $sale->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['sale_error'][$attr] = [];
        }
        $result['sale_error']['tmp_file_ids'] = [];

        $result['success'] = true;
        return $result;
    }

    public static function getSaleById($data) {
        $result = array();
        $get_empty_sale_error = SaleService::getEmptySaleError();
        $result['sale_error'] = $get_empty_sale_error['sale_error'];

        $sale;
        $sale = Sale::model()->findByPk((int) $data['id']);
        if ($sale != null) {
            $result['success'] = true;
            $result['sale'] = self::convertSale($sale);
        } else {
            $result['success'] = false;
            $result['message'] = 'Sale\'s not found!';
        }
        return $result;
    }

    public static function getSaleByProjectId($data) {
        $result = array();
        $get_empty_sale_error = SaleService::getEmptySaleError();
        $result['sale_error'] = $get_empty_sale_error['sale_error'];

        $sale;
        $sale = Sale::model()->findByAttributes(['project_id' => (int) $data['id']]);
        if ($sale != null) {
            $result['success'] = true;
            $result['sale'] = self::convertSale($sale);
        } else {
            $result['success'] = false;
            $result['message'] = 'Sale\'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $sale = null;
        if (isset($data['id']) && $data['id']) {
            $sale = Sale::model()->findByPk((int) $data['id']);
        }
        if (!$sale) {
            $sale = new Sale();
        }

        $sale->attributes = $data;

        $sale = SaleService::beforeSave($sale);
        if ($sale->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $sale->save();
            }
            $result['success'] = true;
            $result['id'] = $sale->id;
            $new_sale = self::getSaleById(array('id' => $sale->id));
            $result['sale'] = $new_sale['sale'];
        } else {
            $empty_sale_error = SaleService::getEmptySaleError();
            $result['sale_error'] = $empty_sale_error['sale_error'];
            foreach ($sale->getErrors() as $key => $error_array) {
                $result['sale_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Sale has some errors';
            $result['error_array'] = $sale->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $sale = Sale::model()->findByPk((int) $data['id']);
        if (!$sale) {
            $sale = new Sale();
        }
        $sale->attributes = $data;
        $sale = SaleService::beforeSave($sale);
        if ($sale->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $sale->save();
            }
            $result['success'] = true;
            $sale_array = SaleService::getSaleById(array('id' => $sale->id));
            $get_empty_sale_error = SaleService::getEmptySaleError();
            $result['sale_error'] = $get_empty_sale_error['sale_error'];
            $result['sale'] = $sale_array['sale'];
            $result['id'] = $sale->id;
        } else {
            $empty_sale_error = SaleService::getEmptySaleError();
            $result['sale_error'] = $empty_sale_error['sale_error'];
            foreach ($sale->getErrors() as $key => $error_array) {
                $result['sale_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Sale has some errors';
            $result['error_array'] = $sale->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if (!isset($data['id'])) {
            $result['success'] = false;
            return $result;
        }
        $sale = Sale::model()->findByPk((int) $data['id']);
        if (!$sale) {
            $result['success'] = false;
            return $result;
        }
        $sale->in_trash = 1;
        if ($sale->save(false)) {
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($sale) {

        if ($sale->isNewRecord) {
            // $sale->status = 1;
            $sale->created_time = time();
        } else if (isset($sale->updated_time)) {
            $sale->updated_time = time();
        }
        return $sale;
    }

    public static function convertListSale($sales, $isRelated = true) {
        $result = array();
        if ($sales != null && count($sales) > 0) {
            foreach ($sales as $sale) {
                $result[] = self::convertSale($sale, $isRelated);
            }
        }
        return $result;
    }

    public static function convertSale($sale, $isRelated = true) {
        if (is_array($sale)) {
            $result = $sale;
            $id = isset($sale['id']) ? $sale['id'] : 0;
            $sale = Sale::model()->findByPk($id);
        } else {
            $result = $sale->attributes;
        }
        foreach($result as $attr => $value){
            $result[$attr] = (string)$value;
        }
        if (isset($result['date']) && $result['date']) {
            //                if(is_integer($sale['date'])){

            $result['date'] = date('Y-m-d', $result['date']);
            //                }
        }
        $result['tmp_file_ids'] = $sale->tmp_file_ids;
        $result['formAttributes'] = self::formAttributes();
        return $result;
    }
    
    public static function formAttributes(){
        return ['product_sample_product', 'product_infor_provide_product', 'product_sample_submit_pack', 
            'product_coa_submit', 'product_spec_qa', 'product_allergen_qa', 'product_product_kosher',
            'product_product_spec_provide_qa', 'product_physical_spec', 'product_allergen_status', 
            'product_product_kosher_input', 'product_type_pack', 'product_net_weight', 'product_product_spec_claim', 
            'product_spec_hand_instruc', 'product_spec_ingredient', 'pack_type_pack', 'pack_plan_print', 
            'pack_provide_primary_pack', 'pack_provide_inner_pack', 'pack_provide_shipper', 'pack_customer_aware', 
            'pack_spec_ship', 'pack_customer_spec_pallet', 'note'];
    }   
}
