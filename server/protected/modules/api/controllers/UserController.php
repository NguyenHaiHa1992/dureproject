<?php

class UserController extends Controller {

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
            array('allow',
                'actions' => array('login', 'logout', 'isUser'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionGetAll() {
        $data = UserService::data();
        $result = UserService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetCurrentUserById() {
        $data = UserService::data(); //data['id']
        $data['id'] = Yii::app()->user->id;
        $result = UserService::getCurrentUserById($data);
        $this->returnJson($result);
    }

    public function actionGetUserById() {
        $data = UserService::data();
        $result = UserService::getCurrentUserById($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = UserService::data();
        $result = UserService::update($data);
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = UserService::data();
        $result = UserService::create($data);
        $this->returnJson($result);
    }

    public function actionLogin() {
        $data = UserService::data();
        $result = UserService::login($data);
        $this->returnJson($result);
    }

    public function actionLogout() {
        $result = UserService::logout();
        $this->returnJson($result);
    }

    public function actionIsUser() {
        $result = UserService::isUser();
        $this->returnJson($result);
    }

    public function actionChangeStatus() {
        $data = UserService::data();
        $result = UserService::changeStatus($data);
        $this->returnJson($result);
    }

    public function actionGetListRole() {
        $data = UserService::data();
        $result = UserService::getListRole($data);
        $this->returnJson($result);
    }

    public function actionEdit() {
        $data = UserService::data();
        $result = UserService::edit($data);
        $this->returnJson($result);
    }

    public function actionUpdateProfile() {
        $data = UserService::data();
        $result = UserService::updateProfile($data);
        $this->returnJson($result);
    }

    public function actionChangePassword() {
        $data = UserService::data();
        $result = UserService::changePassword($data);
        $this->returnJson($result);
    }

    public function actionResetPassword() {
        $data = UserService::data();
        $result = UserService::resetPassword($data);
        $this->returnJson($result);
    }

}

?>