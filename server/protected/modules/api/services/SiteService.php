<?php

class SiteService extends iPhoenixService{
	public static function checkLoginAdmin(){
		$result= array();
		if(Yii::app()->user->id!= null){
			$result['success']= true;
		}
		else
			$result['success']= false;
		return $result;
	}
	
	public static function loginAdmin($data){
		$result= array();
		if(!Yii::app()->user->isGuest){ 
			$result['success']= true;
		}
		else{
			$model=new LoginForm;
			$model->attributes= $data;
			if($model->validate() && $model->login()){
				$admin= User::model()->findByPk(Yii::app()->user->id);
				$result['success']= true;
				$result['admin']['id']= $admin->id;
				$result['admin']['email']= $admin->email; 
			}
			else{
				$result['success']= false;
				$result['error']= 'ADMIN_LOGIN';
				$result['message']= 'your email or password invalid';
			}
		}
		return $result;
	}
	
	public static function logoutAdmin(){
		$result= array();	
		$user=User::model()->findByPk(Yii::app()->user->id);
		if(isset($user)){
			Yii::app()->user->logout();
			Yii::app()->user->clearStates();
			$result['success']= true;
		}
		else{
			$result['success']= false;
			$result['message']= 'Logout error';
		}
		return $result;
	}
	
	public static function changePasswordAdmin($data){
		$result= array();
		$model = User::model()->findByPk ( Yii::app()->user->id );
		$old_password= $data['old_password'];
		$new_password= $data['new_password'];
		$confirm_password= $data['confirm_password'];
		if(isset($model)){
			if($data['old_password']== $data['confirm_password']){
				if($model->validatePassword($old_password)){
					$model->salt=$model->generateSalt();
					$model->password=$model->hashPassword($new_password,$model->salt);
					if($model->validate()){
						$model->save();
						$result['success']= true;
					}
					else{
						$result['success']= false;
						$result['errors']= $model->getErrors();
					}
				}
				else{
					$result['success']= false;
					$result['message']= 'Your old password invalid';
				}
			}
			else{
				$result['success']= false;
				$result['message']= 'Your confirm password invalid';
			}
		}
		else{
			$result['success']= false;
			$result['message']= 'Change password error';
		}
		return $result;
	}
	
	public static function registerAdmin($data){
		$result= array();
		$user= new User();
		$email= $data['email'];
		$password= $data['password'];
		$confirm_password= $data['confirm_password'];
		if($password== $confirm_password){
			$user->email= $email;
			$user->salt= $user->generateSalt();
			$user->password= $user->hashPassword($password, $user->salt);
			$user->type= 1;
			if($user->validate()){
				$user->save();
				$result['success']= true;
				$result['id']= $user->id;
			}
			else{
				$result['success']= false;
				$result['errors']= $user->getErrors();
			}
		}
		else{
			$result['success']= false;
			$result['message']= 'Your confirm password invalid';
		}
		return $result;
	}
	
	public static function getGeneralSetting($data){
		$result= array();
		$general_setting;
		if(GeneralSetting::model()->find()!= null){
			$general_setting= GeneralSetting::model()->find();
			$result['success']= true;
			$result['general_setting']['email']= $general_setting->email;
			$result['general_setting']['company_name']= $general_setting->company_name;
			$result['general_setting']['tax_code']= $general_setting->tax_code;
			$result['general_setting']['host']= $general_setting->host;
			$result['general_setting']['host_email']= $general_setting->host_email;
			$result['general_setting']['host_email_password']= $general_setting->host_email_password;
			$result['general_setting']['host_port']= $general_setting->host_port;
			$result['general_setting']['host_encryption']= $general_setting->host_encryption;
		}
		else{
			$result['success']= false;
			$result['message']= 'Không có thông tin nào';
		}
		return $result; 
	}

	public static function updateGeneralSetting($data){
		$result= array();
		$general_setting;
		if(GeneralSetting::model()->find()!= null)
			$general_setting= GeneralSetting::model()->find();
		else
			$general_setting= new GeneralSetting();
		$general_setting->attributes= $data;
		if($general_setting->validate()){
			$general_setting->save();
			$result['success']= true;
		}
		else{
			$result['success']= false;
			$result['errors']= $general_setting->getErrors();
			$result['message']= 'Có lỗi xảy ra!';
		}
		return $result;
	}
}
