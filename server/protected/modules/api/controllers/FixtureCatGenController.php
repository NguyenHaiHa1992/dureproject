<?php
/**
 * Description of FixtureCatGenController
 *
 * @author hanguyenhai
 */
class FixtureCatGenController extends Controller{
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
    
    public function actionGetAll(){
        $data= FixtureCatGenService::data();
        $result= FixtureCatGenService::getAll($data);
        $this->returnJson($result);
    }
    
    public function actionUpdate(){
        $data= FixtureCatGenService::data();
        $result= FixtureCatGenService::update($data);
        $this->returnJson($result);
    }
    
    public function actionRemoveCategory(){
        $data= FixtureCatGenService::data();
        $result= FixtureCatGenService::removeCategory($data);
        $this->returnJson($result);
    }
}
