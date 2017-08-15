<?php

class StoreFixtureController extends Controller {

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
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionGetAll() {
        $data = StoreFixtureService::data();
        $result = StoreFixtureService::getAll($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = StoreFixtureService::data();
        $result = StoreFixtureService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = StoreFixtureService::data();
        $result = StoreFixtureService::delete($data);
        $this->returnJson($result);
    }
}
