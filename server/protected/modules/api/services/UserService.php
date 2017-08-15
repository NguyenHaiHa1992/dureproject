<?php

class UserService extends iPhoenixService {

    public static function getEmptyUser() {
        $result = array();
        $user = array(
            'id' => '',
            'name' => '',
            'username' => '',
            'email' => '',
            'clear_password' => '',
            'role' => '',
            'status' => ''
        );
        $result['user'] = $user;
        $result['success'] = true;
        return $result;
    }

    public static function getEmptyUserError() {
        $result = array();
        $user = array(
            'id' => array(),
            'name' => array(),
            'username' => array(),
            'email' => array(),
            'clear_password' => array(),
            'role' => array(),
            'status' => array()
        );

        $result['user_error'] = $user;
        $result['success'] = true;
        return $result;
    }

    public static function getAll($data) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {

            $data['limitstart'] = '0';
            $data['limitnum'] = User::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'Order By tbl_user.' . $data['sort_attribute'] . ' ' . $data['sort_type'];


        $sql = "Select tbl_user.*
			   From tbl_user";
        $sql = $sql . "
			   		Where 1 ";

        if (isset($data['email']) && $data['email'] != '') {
            $sql = $sql . "And tbl_user.email LIKE '%" . $data['email'] . "%'";
        }

        if (isset($data['name']) && $data['name'] != '') {
            $sql = $sql . "And tbl_user.name LIKE '%" . $data['name'] . "%'";
        }

        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
        $users = User::model()->findAllBySql($sql);

        $criteria = new CDbCriteria();
        if (isset($data['email']) && $data['email'] != '') {
            $criteria->compare('email', $data['email'], true);
        }
        if (isset($data['name']) && $data['name'] != '') {
            $criteria->compare('name', $data['name']);
        }
        $total = User::model()->count($criteria);

        if ($users != null) {
            $result['success'] = true;
            $result['users'] = self::convertListUser($users, $data);

            $result['totalresults'] = $total;
            $result['start_user'] = (int) $data['limitstart'] + 1;
            $result['end_user'] = (int) $data['limitstart'] + count($users);
        } else {
            $result['success'] = true;
            $result['users'] = array();
            $result['totalresults'] = $total;
            $result['start_user'] = 0;
            $result['end_user'] = 0;
        }
        return $result;
    }

    public static function getListRole() {
        $list_nodes = AuthItem::getList_all_roles();
        foreach ($list_nodes as $name => $level) {
            $view = "";
            for ($i = 1; $i < $level; $i++) {
                $view .="--";
            }
            $view_parent_nodes[] = array('id' => $name, 'name' => $view . " " . $name . " " . $view);
        }
        return array('success' => true, 'list_role' => $view_parent_nodes);
    }

    public static function getCurrentUserById($data) {//$data['id]
        $result = array();
        $user = User::model()->findByAttributes(array('id' => (int) $data['id'], 'status' => 1));
        if ($user != null) {
            $result['success'] = true;
            $result['user'] = self::convertUser($user);
        } else {
            $result['success'] = false;
            $result['message'] = 'This user does not exist!';
        }
        return $result;
    }

    public static function getUserById($data) {//$data['id]
        $result = array();
        $user = User::model()->findByAttributes(array('id' => (int) $data['id'], 'status' => 1));
        if ($user != null) {
            $result['success'] = true;
            $result['user'] = self::convertUser($user);
        } else {
            $result['success'] = false;
            $result['message'] = 'This user does not exist!';
        }
        return $result;
    }

    public static function update($data) {//$data={'email', 'password']
        $result = array();
        $user = User::model()->findByAttributes(array('id' => Yii::app()->user->id, 'status' => 1));
        if ($user != null) {
            $user->email = $data['email'];
            if (isset($data['password']) && $data['password'] != '') {
                $password = $data['password'];
                $user->salt = $user->generateSalt();
                $user->password = $user->hashPassword($password, $user->salt);
            }
            $user->type = 1;
            if ($user->validate()) {
                $user->save();
                $result['success'] = true;
                $result['user'] = self::convertUser($user);
                $result['user_error'] = self::getEmptyUserError();
            } else {
                $result['success'] = false;
                $result['errors'] = $user->getErrors();
                $result['message'] = 'Có lỗi xảy ra!';
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'Không tồn tại User này';
        }
        return $result;
    }

    public static function create($data) {//email, password
        $result = array();
        $user = new User();
        $user->attributes = $data;
        $user->salt = $user->generateSalt();
        $user->password = $user->hashPassword($data['password'], $user->salt);
        if ($user->save()) {
            $result['success'] = true;
            $result['id'] = $user->id;
            $result['user_error'] = self::getEmptyUserError();
        } else {
            $result['success'] = false;
            $result['errors'] = $user->getErrors();
            $result['type'] = 'show';
        }
        return $result;
    }

    public static function login($data) {//email, password
        $result = array();
        if (!Yii::app()->user->isGuest) {
            $result['success'] = true;
            $result['id'] = Yii::app()->user->id;
        } else {
            $model = new LoginForm;
            $model->attributes = $data;
            if ($model->validate() && $model->login()) {
                $user = User::model()->findByPk(Yii::app()->user->id);
                // Yii::app()->request->cookies['user_id'] = new CHttpCookie('user_id', $_SESSION['admin___id']);
                // Yii::app()->request->cookies['user_email'] = new CHttpCookie('user_email', $user->email);
                // Yii::app()->request->cookies['user_name'] = new CHttpCookie('user_name', $user->name);
                $result['success'] = true;
                $result['message'] = 'You have been successfully logged in';
                $result['id'] = $user->id;
                $result['user_email'] = $user->email;
                $result['user_name'] = $user->name;
            } else {
                $result['success'] = false;
                ;
                $result['message'] = 'Invalid email or password';
            }
        }
        return $result;
    }

    public static function logout() {
        $result = array();

        if (!Yii::app()->user->isGuest) {
            $user = User::model()->findByPk(Yii::app()->user->id);

            if (($user)) {
                Yii::app()->user->logout();
                Yii::app()->user->clearStates();
                //unset(Yii::app()->request->cookies['user_id']);
                $result['success'] = true;
            } else {
                Yii::app()->user->logout();
                Yii::app()->user->clearStates();
                // unset(Yii::app()->request->cookies['user_id']);
                // unset(Yii::app()->request->cookies['user_name']);
                // unset(Yii::app()->request->cookies['user_email']);
                $result['success'] = false;
                $result['type'] = 'alert';
                $result['message'] = 'you are not a user';
            }
        } else {
            $result['success'] = true;
        }

        return $result;
    }

    public static function isUser() {
        $result = array();
        if (Yii::app()->user->id) {
            $result['success'] = true;
            $result['id'] = Yii::app()->user->id;
            $result['user_name'] = Yii::app()->user->name;
            $result['user_email'] = Yii::app()->user->email;
            if (Yii::app()->user->checkAccess('Super Admin')) {
                $result['is_superadmin'] = true;
            }
            else{
                $result['is_superadmin'] = false;
            }
        } else {
            $result['success'] = false;
            $result['type'] = 'nothing';
        }
        return $result;
    }

    public static function convertListUser($users, $data) {
        $result = array();
        if ($users != null && count($users) > 0) {
            foreach ($users as $user) {
                $result[] = self::convertUser($user);
            }
        }
        return $result;
    }

    public static function convertUser($user) {
        return array(
            'id' => $user->id,
            'email' => $user->email,
            'created_time' => date('d-m-Y', $user->created_time),
            'name' => $user->name,
            'username' => $user->username,
            'status' => $user->status,
            'role' => $user->role,
            'clear_password' => $user->clear_password
        );
    }

    public static function changeStatus($data) {
        $result = array();
        $user = User::model()->findByPk($data['user_id']);

        if (isset($user)) {
            if ($user->status)
                $user->status = 0;
            else
                $user->status = 1;

            if ($user->save()) {
                $result = array('success' => true);
            } else
                $result = array('success' => false, 'message' => CHtml::errorSummary($user));
        }
        else {
            $result['success'] = false;
            $result['massage'] = 'This user does not existed!';
        }

        return $result;
    }

    public static function edit($data) {
        $result = array();
        if (isset($data['id']) && $data['id'] != '') {
            $user = User::model()->findByPk($data['id']);
            if (isset($user)) {

                if (isset($data['name']))
                    $user->name = $data['name'];
                if (isset($data['username']))
                    $user->username = $data['username'];
                if (isset($data['email']))
                    $user->email = $data['email'];
                if (isset($data['status']))
                    $user->status = $data['status'];
                if (isset($data['role']))
                    $user->role = $data['role'];
                if (isset($data['clear_password']) && $data['clear_password'] != '')
                    $user->clear_password = $data['clear_password'];

                if (isset($user->clear_password) && $user->clear_password != '') {
                    $clear_password = $user->clear_password;
                    $user->salt = $user->generateSalt();
                    $user->password = $user->hashPassword($clear_password, $user->salt);
                }

                if ($user->save()) {
                    $result['success'] = true;
                    $result['message'] = 'User info updated!';
                    $result['user'] = self::convertUser($user);
                    $result['user_error'] = self::getEmptyUserError();
                } else {
                    $result['success'] = false;
                    $result['message'] = CHtml::errorSummary($user);
                    $result['user'] = $user;
                    $empty_user_error = UserService::getEmptyUserError();
                    $result['user_error'] = $empty_user_error['user_error'];
                    foreach ($user->getErrors() as $key => $error_array) {
                        $result['user_error'][$key] = $error_array;
                    }
                }
            } else {
                $result['success'] = false;
                $result['message'] = 'This user does not exist';
            }
        } else {
            $user = new User();

            if (isset($data['name']))
                $user->name = $data['name'];
            if (isset($data['username']))
                $user->username = $data['username'];
            if (isset($data['email']))
                $user->email = $data['email'];
            if (isset($data['status']))
                $user->status = $data['status'];
            if (isset($data['role']))
                $user->role = $data['role'];
            if (isset($data['clear_password']) && $data['clear_password'] != '')
                $user->clear_password = $data['clear_password'];

            if (!isset($user->clear_password) || $user->clear_password == '')
                $clear_password = User::generatePassword(10);
            else
                $clear_password = $user->clear_password;

            $user->salt = $user->generateSalt();
            $user->password = $user->hashPassword($clear_password, $user->salt);

            if ($user->save()) {
                $result['success'] = true;
                $result['message'] = 'User created!';
                $result['user'] = $user;
                $result['user_error'] = self::getEmptyUserError();
            } else {
                $result['success'] = false;
                $result['message'] = CHtml::errorSummary($user);
                $result['user'] = $user;
                $empty_user_error = UserService::getEmptyUserError();
                $result['user_error'] = $empty_user_error['user_error'];
                foreach ($user->getErrors() as $key => $error_array) {
                    $result['user_error'][$key] = $error_array;
                }
            }
        }

        return $result;
    }

    public static function updateProfile($data) {//$data={'email', 'password']
        $result = array();
        $user = User::model()->findByAttributes(array('id' => Yii::app()->user->id, 'status' => 1));
        if ($user != null) {
            $user->name = $data['name'];
            if ($user->validate()) {
                $user->save();
                $result['success'] = true;
                $result['user'] = array(
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                );
                $result['user_error'] = self::getEmptyUserError();

                //Yii::app()->request->cookies['user_email'] = new CHttpCookie('user_email', $user->email);
                //Yii::app()->request->cookies['user_name'] = new CHttpCookie('user_name', $user->name);
            } else {
                $result['success'] = false;
                $result['message'] = CHtml::errorSummary($user);
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'This user does not exist!';
        }
        return $result;
    }

    public static function changePassword($data) {
        $result = array();
        $user = User::model()->findByAttributes(array('id' => Yii::app()->user->id, 'status' => 1));
        if ($user != null) {
            if (isset($data['password']) && isset($data['confirm_password']) && $data['password'] != '' && $data['confirm_password'] != '') {
                if ($data['password'] == $data['confirm_password']) {
                    $password = $data['password'];
                    $user->salt = $user->generateSalt();
                    $user->password = $user->hashPassword($password, $user->salt);

                    if ($user->validate()) {
                        $user->save();
                        $result['success'] = true;
                        $result['user'] = array(
                            'id' => $user->id,
                            'email' => $user->email,
                            'name' => $user->name,
                        );
                        $result['user_error'] = self::getEmptyUserError();
                    } else {
                        $result['success'] = false;
                        $result['message'] = CHtml::errorSummary($user);
                    }
                } else {
                    $result['success'] = false;
                    $result['message'] = 'Confirm password does not match';
                }
            } else {
                $result['success'] = false;
                $result['message'] = 'Password and confirm password can not be empty!';
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'This user does not exist!';
        }
        return $result;
    }

    public static function resetPassword($data) {
        $result = array();
        $user = User::model()->findByPk($data['id']);
        if ($user != null) {
            if (isset($data['password']) && $data['password'] != '') {
                $password = $data['password'];
                $user->salt = $user->generateSalt();
                $user->password = $user->hashPassword($password, $user->salt);

                if ($user->validate()) {
                    $user->save();
                    $result['success'] = true;
                    $result['user'] = array(
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                    );
                    $result['user_error'] = self::getEmptyUserError();
                } else {
                    $result['success'] = false;
                    $result['message'] = CHtml::errorSummary($user);
                }
            } else {
                $result['success'] = false;
                $result['message'] = 'Password can not be empty!';
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'This user does not exist!';
        }
        return $result;
    }

}
