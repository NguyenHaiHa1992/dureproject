<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QaController
 *
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class QaController extends Controller {

    //put your code here
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
                    'createInit', 'detailInit', 'getEmptyQa',
                    'getEmptyQaError', 'getQaByProjectId'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = QaService::data();
        $result = QaService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = QaService::data();
        $result = QaService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = QaService::data();
        $result = QaService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetEmptyQa() {
        $result = QaService::getEmptyQa();
        $this->returnJson($result);
    }

    public function actionGetEmptyQaError() {
        $result = QaService::getEmptyQaError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = QaService::data();
        $result = QaService::create($data);
        $this->returnJson($result);
    }

    public function actionGetQaByProjectId() {
        $data = QaService::data();
        $result = QaService::getQaByProjectId($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = QaService::data();
        $result = QaService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = QaService::data();
        $result = QaService::delete($data);
        $this->returnJson($result);
    }
}
