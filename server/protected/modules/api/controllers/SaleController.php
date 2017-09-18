<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaleController
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class SaleController extends Controller{

    public function behaviors() {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelview.EExcelBehavior',
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
                'actions' => array('delete', 'copy'),
                'roles' => array('Super Admin'),
            ),
            array('allow',
                'actions' => array('create', 'update',
                    'createInit', 'detailInit', 'getEmptySale',
                    'getEmptySaleError', 'getSaleByProjectId'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = SaleService::data();
        $result = SaleService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = SaleService::data();
        $result = SaleService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = SaleService::data();
        $result = SaleService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetEmptySale() {
        $result = SaleService::getEmptySale();
        $this->returnJson($result);
    }

    public function actionGetEmptySaleError() {
        $result = SaleService::getEmptySaleError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = SaleService::data();
        $result = SaleService::create($data);
        $this->returnJson($result);
    }

    public function actionGetSaleByProjectId() {
        $data = SaleService::data();
        $result = SaleService::getSaleByProjectId($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = SaleService::data();
        $result = SaleService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = SaleService::data();
        $result = SaleService::delete($data);
        $this->returnJson($result);
    }
}
