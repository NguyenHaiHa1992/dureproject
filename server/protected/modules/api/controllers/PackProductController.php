<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PackProductController
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class PackProductController extends Controller{
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
                    'createInit', 'detailInit', 'getEmptyPackProduct',
                    'getEmptyPackProductError', 'getPackProductByProjectId'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = PackProductService::data();
        $result = PackProductService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = PackProductService::data();
        $result = PackProductService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetEmptyPackProduct() {
        $result = PackProductService::getEmptyPackProduct();
        $this->returnJson($result);
    }

    public function actionGetEmptyPackProductError() {
        $result = PackProductService::getEmptyPackProductError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = PackProductService::data();
        $result = PackProductService::create($data);
        $this->returnJson($result);
    }

    public function actionGetPackProductByProjectId() {
        $data = PackProductService::data();
        $result = PackProductService::getPackProductByProjectId($data);
        $this->returnJson($result);
    }
}
