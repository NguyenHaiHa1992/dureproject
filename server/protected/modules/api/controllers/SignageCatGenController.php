<?php
/**
 * Description of FixtureCatGenController
 *
 * @author hanguyenhai
 */
class SignageCatGenController extends Controller{
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
        $data= SignageCatGenService::data();
        $result= SignageCatGenService::getAll($data);
        $this->returnJson($result);
    }
    
    public function actionUpdate(){
        $data= SignageCatGenService::data();
        $result= SignageCatGenService::update($data);
        $this->returnJson($result);
    }
    
    public function actionRemoveCategory(){
        $data= SignageCatGenService::data();
        $result= SignageCatGenService::removeCategory($data);
        $this->returnJson($result);
    }
}
