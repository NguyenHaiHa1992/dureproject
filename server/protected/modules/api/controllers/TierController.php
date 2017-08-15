<?php

class TierController extends Controller {

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
                //'roles'=>array('AMP Master Admin'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = TierService::data();
        $result = TierService::createInit();
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = TierService::data();
        $result = TierService::getAll($data);
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = TierService::data();
        $result = TierService::create($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = TierService::data();
        $result = TierService::update($data);
        $this->returnJson($result);
    }

    public function actionGetTierById() {
        $data = TierService::data();
        $result = TierService::getTierById($data);
        $this->returnJson($result);
    }

    public function actionRemoveTier() {
        $data = TierService::data();
        $result = TierService::removeTier($data);
        $this->returnJson($result);
    }

}

?>