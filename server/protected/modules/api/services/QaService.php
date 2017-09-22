<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QaService
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class QaService extends iPhoenixService{

    public static function createInit($data) {
        $result = array();
        $get_empty_qa = QaService::getEmptyQa();
        if (isset($data['id']) && $data['id'] != '') {
            $qa = QaService::getQaById(array('id' => $data['id']));
            if ($qa['success'] == true) {
                $result['qa'] = $qa['qa'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['qa'] = $get_empty_qa['qa'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['qa'] = $get_empty_qa['qa'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }
        $result['qa']['formAttributes'] = self::formAttributes();
        $result['qa_empty'] = $get_empty_qa['qa'];
        $get_empty_qa_error = QaService::getEmptyQaError();
        $result['qa_error'] = $get_empty_qa_error['qa_error'];
        $result['qa_error_empty'] = $get_empty_qa_error['qa_error'];
        $result['success'] = true;
        return $result;
    }
    
    public static function getEmptyQa() {
        $result = array();
        $qa = new Qa();
        $attribute_names = $qa->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['qa'][$attr] = '';
        }
        $result['qa']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyQaError() {
        $result = array();
        $qa = new Qa();
        $attribute_names = $qa->attributeNames();
        foreach ($attribute_names as $attr) {
            $result['qa_error'][$attr] = [];
        }
        $result['qa_error']['tmp_file_ids'] = [];

        $result['success'] = true;
        return $result;
    }

    public static function getQaById($data) {
        $result = array();
        $get_empty_qa_error = QaService::getEmptyQaError();
        $result['qa_error'] = $get_empty_qa_error['qa_error'];

        $qa;
        $qa = Qa::model()->findByPk((int) $data['id']);
        if ($qa != null) {
            $result['success'] = true;
            $result['qa'] = self::convertQa($qa);
        } else {
            $result['success'] = false;
            $result['message'] = 'Qa\'s not found!';
        }
        return $result;
    }

    public static function getQaByProjectId($data) {
        $result = array();
        $get_empty_qa_error = QaService::getEmptyQaError();
        $result['qa_error'] = $get_empty_qa_error['qa_error'];

        $qa;
        $qa = Qa::model()->findByAttributes(['project_id' => (int) $data['id']]);
        if ($qa != null) {
            $result['success'] = true;
            $result['qa'] = self::convertQa($qa);
        } else {
            $result['success'] = false;
            $result['message'] = 'Qa\'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $qa = null;
        if (isset($data['id']) && $data['id']) {
            $qa = Qa::model()->findByPk((int) $data['id']);
        }
        if (!$qa) {
            $qa = new Qa();
        }

        $qa->attributes = $data;

        $qa = QaService::beforeSave($qa);
        if ($qa->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $qa->save();
            }
            $result['success'] = true;
            $result['id'] = $qa->id;
            $new_qa = self::getQaById(array('id' => $qa->id));
            $result['qa'] = $new_qa['qa'];
        } else {
            $empty_qa_error = QaService::getEmptyQaError();
            $result['qa_error'] = $empty_qa_error['qa_error'];
            foreach ($qa->getErrors() as $key => $error_array) {
                $result['qa_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Qa has some errors';
            $result['error_array'] = $qa->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $qa = Qa::model()->findByPk((int) $data['id']);
        if (!$qa) {
            $qa = new Qa();
        }
        $qa->attributes = $data;
        $qa = QaService::beforeSave($qa);
        if ($qa->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $qa->save();
            }
            $result['success'] = true;
            $qa_array = QaService::getQaById(array('id' => $qa->id));
            $get_empty_qa_error = QaService::getEmptyQaError();
            $result['qa_error'] = $get_empty_qa_error['qa_error'];
            $result['qa'] = $qa_array['qa'];
            $result['id'] = $qa->id;
        } else {
            $empty_qa_error = QaService::getEmptyQaError();
            $result['qa_error'] = $empty_qa_error['qa_error'];
            foreach ($qa->getErrors() as $key => $error_array) {
                $result['qa_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Qa has some errors';
            $result['error_array'] = $qa->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if (!isset($data['id'])) {
            $result['success'] = false;
            return $result;
        }
        $qa = Qa::model()->findByPk((int) $data['id']);
        if (!$qa) {
            $result['success'] = false;
            return $result;
        }
        $qa->in_trash = 1;
        if ($qa->save(false)) {
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($qa) {

        if ($qa->isNewRecord) {
            // $qa->status = 1;
            $qa->created_time = time();
        } else if (isset($qa->updated_time)) {
            $qa->updated_time = time();
        }
        return $qa;
    }

    public static function convertListQa($qas, $isRelated = true) {
        $result = array();
        if ($qas != null && count($qas) > 0) {
            foreach ($qas as $qa) {
                $result[] = self::convertQa($qa, $isRelated);
            }
        }
        return $result;
    }

    public static function convertQa($qa, $isRelated = true) {
        if (is_array($qa)) {
            $result = $qa;
            $id = isset($qa['id']) ? $qa['id'] : 0;
            $qa = Qa::model()->findByPk($id);
        } else {
            $result = $qa->attributes;
        }
        if (isset($result['date']) && $result['date']) {
            //                if(is_integer($qa['date'])){

            $result['date'] = date('Y-m-d', $result['date']);
            //                }
        }
        $result['tmp_file_ids'] = $qa->tmp_file_ids;
        $result['formAttributes'] = self::formAttributes();
        return $result;
    }
    
    public static function formAttributes(){
        return ['spec_micro_test', 'spec_sample', 'customer_require_coa', 
            'customer_spec_sensor', 'customer_require_preship', 'physical_spec_product', 'product_spec_sheet',
            'allergen_status', 'package_net_weight', 
            'customer_spec_net_weight', 'customer_provide_label', 'is_upc_scc_code', 'customer_provide_label_primary_pack', 
            'customer_provide_label_inner_pack', 'customer_provide_label_shipper', 'product_have_spec_claim', 
            'spec_hand_instruc', 'customer_request_spec_ship', 'product_have_npn', 'product_nsf_for_sport', 
            'note', 'appr_coa_submit'];
    }  
}
