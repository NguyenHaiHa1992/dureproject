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
                    'createInit', 'detailInit', 'getAll', 'getEmptyProduct',
                    'getEmptyProductError', 'getProductById', 'exportExcel', 'exportPdf', 'exportExcelItem', 'getProductByProjectId',
                    'testpdf', 'importObject', 'downloadfile', 'showhtml', 'test'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = ProductService::data();
        $result = ProductService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = ProductService::data();
        $result = ProductService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = ProductService::data();
        $result = ProductService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetEmptyProduct() {
        $result = ProductService::getEmptyProduct();
        $this->returnJson($result);
    }

    public function actionGetEmptyProductError() {
        $result = ProductService::getEmptyProductError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = ProductService::data();
        $result = ProductService::create($data);
        $this->returnJson($result);
    }

    public function actionGetProductById() {
        $data = ProductService::data();
        $result = ProductService::getProductById($data);
        $this->returnJson($result);
    }

    public function actionGetProductByProjectId() {
        $data = ProductService::data();
        $result = ProductService::getProductByProjectId($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = ProductService::data();
        $result = ProductService::update($data);
        $this->returnJson($result);
    }

    public function actionUpdateTableFilter() {
        $data = ProductService::data();
        $result = ProductService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = ProductService::data();
        $result = ProductService::delete($data);
        $this->returnJson($result);
    }

    public function actionCopy() {
        $data = ProductService::data();
        $result = ProductService::copy($data);
        $this->returnJson($result);
    }

    public function actionImportObject() {
        $data = ProductService::data();
        $result = ObjectCommonService::importObject($data, "Product", "customer_number", "Product", "ProductService");
        $this->returnJson($result);
    }

    public function actionShowhtml($id) {
        $customer = Product::model()->findByPk($id);

        if (isset($customer)) {
            $customer_name_converted = preg_replace('/\s+/', '_', $customer->name);
            $pdf_file = 'STORE_' . $customer_name_converted . '_' . date('Ymd', $customer->created_time) . '_' . $customer->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $check_file . '.pdf')) {
                $check_file = $pdf_file . '_' . $i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_customer_pdf_template.php', array(
                'customer' => $customer,
                    ), true, true);

            // Create pdf
            $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_pdf_template.php', array(
                'content' => $content,
                    ), true, true);
            echo $detail_pdf;
        } else {
            echo "No model";
        }
    }

}
