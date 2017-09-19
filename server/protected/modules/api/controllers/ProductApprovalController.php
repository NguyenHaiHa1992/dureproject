<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductApprovalController
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class ProductApprovalController extends Controller {
    
    public function behaviors()
    {
        return array(
            'eexcelview'=>array(
                'class'=>'ext.eexcelview.EExcelBehavior',
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */ 
    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('delete', 'copy'),
                'roles'=>array('Super Admin'),
            ),
            array('allow',
                'actions'=>array('create', 'update', 
                    'createInit', 'detailInit', 'getAll', 'getEmptyProduct', 
                    'getEmptyProductError', 'getProductApprovalById', 'getProductApprovalByProjectId'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),  
            ),
        );
    }

    public function actionCreateInit() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetEmptyProduct() {
        $result = ProductApprovalService::getEmptyProduct();
        $this->returnJson($result);
    }

    public function actionGetEmptyProductError() {
        $result = ProductApprovalService::getEmptyProductError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::create($data);
        $this->returnJson($result);
    }

    public function actionGetProductApprovalById() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::getProductApprovalById($data);
        $this->returnJson($result);
    }

    public function actionGetProductApprovalByProjectId(){
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::getProductApprovalByProjectId($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = ProductApprovalService::data();
        $result = ProductApprovalService::delete($data);
        $this->returnJson($result);
    }
}
