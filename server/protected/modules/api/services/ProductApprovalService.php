<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductApprovalService
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class ProductApprovalService extends iPhoenixService {
    
    public static function createInit($data) {
        $result = array();
        $get_empty_productApproval = ProductApprovalService::getEmptyProductApproval();
        if (isset($data['id']) && $data['id'] != '') {
            $productApproval = ProductApprovalService::getProductApprovalById(array('id' => $data['id']));
            if ($productApproval['success'] == true) {
                $result['productApproval'] = $productApproval['productApproval'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['productApproval'] = $get_empty_productApproval['productApproval'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['productApproval'] = $get_empty_productApproval['productApproval'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }
        $result['productApproval']['formAttributes'] = self::formAttributes();
        $result['productApproval_empty'] = $get_empty_productApproval['productApproval'];
        $get_empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
        $result['productApproval_error'] = $get_empty_productApproval_error['productApproval_error'];
        $result['productApproval_error_empty'] = $get_empty_productApproval_error['productApproval_error'];
        $result['success'] = true;
        return $result;
    }
    
    public static function getEmptyProductApproval() {
        $result = array();
        $productApproval = new ProductApproval();
        $attribute_names = $productApproval->attributeNames();
        foreach($attribute_names as $attr){
          $result['productApproval'][$attr] = '';
        }
        $result['productApproval']['status'] = 0;
        $result['productApproval']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyProductApprovalError() {
      $result = array();
      $productApproval = new ProductApproval();
      $attribute_names = $productApproval->attributeNames();
      foreach($attribute_names as $attr){
        $result['productApproval_error'][$attr] = [];
      }
      $result['productApproval_error']['tmp_file_ids'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getProductApprovalById($data) {
        $result = array();
        $get_empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
        $result['productApproval_error'] = $get_empty_productApproval_error['productApproval_error'];

        $productApproval;
        $productApproval = ProductApproval::model()->findByPk((int) $data['id']);
        if ($productApproval != null) {
            $result['success'] = true;
            $result['productApproval'] = self::convertProductApproval($productApproval);
        } else {
            $result['success'] = false;
            $result['message'] = 'ProductApproval\'s not found!';
        }
        return $result;
    }

    public static function getProductApprovalByProjectId($data){
        $result = array();
        $get_empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
        $result['productApproval_error'] = $get_empty_productApproval_error['productApproval_error'];

        $productApproval;
        $productApproval = ProductApproval::model()->findByAttributes(['project_id' => (int)$data['id']]);
        if ($productApproval != null) {
            $result['success'] = true;
            $result['productApproval'] = self::convertProductApproval($productApproval);
        } else {
            $result['success'] = false;
            $result['message'] = 'ProductApproval\'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $productApproval = null;
        if(isset($data['id']) && $data['id']){
            $productApproval = ProductApproval::model()->findByPk((int)$data['id']);
        }
        if(!$productApproval){
            $productApproval = new ProductApproval();
        }

        $productApproval->attributes = $data;
        
        $productApproval = ProductApprovalService::beforeSave($productApproval);
        if ($productApproval->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $productApproval->save();
                $result['id'] = $productApproval->id;
                $new_productApproval = self::getProductApprovalById(array('id' => $productApproval->id));
                $result['productApproval'] = $new_productApproval['productApproval'];
            }
            else{
                $result['productApproval'] = $data;
            }
            $result['success'] = true;
            
        } else {
            $empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
            $result['productApproval_error'] = $empty_productApproval_error['productApproval_error'];
            foreach ($productApproval->getErrors() as $key => $error_array) {
                $result['productApproval_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating ProductApproval has some errors';
            $result['error_array'] = $productApproval->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $productApproval = ProductApproval::model()->findByPk((int) $data['id']);
        if(!$productApproval){
            $productApproval = new ProductApproval();
        }
        $productApproval->attributes = $data;
        $productApproval = ProductApprovalService::beforeSave($productApproval);
        if ($productApproval->validate()) {
            if(isset($data['_is_save']) && $data['_is_save']){
                $productApproval->save();
            }
            $result['success'] = true;
            $productApproval_array = ProductApprovalService::getProductApprovalById(array('id' => $productApproval->id));
            $get_empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
            $result['productApproval_error'] = $get_empty_productApproval_error['productApproval_error'];
            $result['productApproval'] = $productApproval_array['productApproval'];
            $result['id'] = $productApproval->id;
        } else {
            $empty_productApproval_error = ProductApprovalService::getEmptyProductApprovalError();
            $result['productApproval_error'] = $empty_productApproval_error['productApproval_error'];
            foreach ($productApproval->getErrors() as $key => $error_array) {
                $result['productApproval_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update ProductApproval has some errors';
            $result['error_array'] = $productApproval->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $productApproval = ProductApproval::model()->findByPk((int)$data['id']);
        if(!$productApproval){
            $result['success'] = false;
            return $result;
        }
        $productApproval->in_trash = 1;
        if($productApproval->save(false)){
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($productApproval) {
        
        if ($productApproval->isNewRecord) {
            // $productApproval->status = 1;
            $productApproval->created_time = time();
        }
        else if(isset($productApproval->updated_time)){
            $productApproval->updated_time = time();
        }
        if(isset($productApproval->president_date) && !is_int($productApproval->president_date)){
            $productApproval->president_date = strtotime($productApproval->president_date) ? strtotime($productApproval->president_date) : 0;
        }
        if(isset($productApproval->qa_supervisor_date) && !is_int($productApproval->qa_supervisor_date)){
            $productApproval->qa_supervisor_date = strtotime($productApproval->qa_supervisor_date) ? strtotime($productApproval->qa_supervisor_date) : 0;
        }
        return $productApproval;
    }

    public static function convertListProductApproval($productApprovals, $isRelated = true) {
        $result = array();
        if ($productApprovals != null && count($productApprovals) > 0) {
            foreach ($productApprovals as $productApproval) {
                $result[] = self::convertProductApproval($productApproval, $isRelated);
            }
        }
        return $result;
    }

    public static function convertProductApproval($productApproval, $isRelated = true) {
        if(is_array($productApproval)){
            $result = $productApproval;
            $id = isset($productApproval['id']) ? $productApproval['id'] : 0;
            $productApproval = ProductApproval::model()->findByPk($id);
        }
        else{
            $result = $productApproval->attributes;
        }
        if(isset($result['president_date']) && $result['president_date']){
            $result['president_date'] = date('Y-m-d' ,$result['president_date']);
        }
        else{
            $result['president_date'] = null;
        }
        
        if(isset($result['qa_supervisor_date']) && $result['qa_supervisor_date']){
            $result['qa_supervisor_date'] = date('Y-m-d' ,$result['qa_supervisor_date']);
        }
        else{
            $result['qa_supervisor_date'] = null;
        }
        $result['tmp_file_ids'] = $productApproval->tmp_file_ids;
        $result['formAttributes'] = self::formAttributes();
        return $result;
    }    
    
    public static function formAttributes(){
        return ['president', 'president_date', 'qa_supervisor', 'qa_supervisor_date', 'note'];
    }  
}
