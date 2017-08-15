<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class ResellerIdentity extends CUserIdentity
{
	private $_id;
	private $_email;
	public function __construct($email,$password)
	{
	    $this->email=$email;
	    $this->password=$password;
	}
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$postfields= array();
		$postfields['email']= $this->email;
		$postfields['password2']= $this->password;
		$postfields['action']= 'validatelogin';
		$result_api= SiteXService::executeService($postfields);
		if($result_api->result== 'success' && !isset($result_api->contactid) && Reseller::model()->findByPk((int)$result_api->userid)!= null){//là reseller
			$this->_id= (string)$result_api->userid;
			//$this->_email= $this->email;
			$this->setEmail($this->email);
			$this->errorCode= self::ERROR_NONE;
		}
		else{
			if(isset($result_api->message))
				$this->errorCode= $result_api->message;
			else
				$this->errorCode= 'Your email or password invalid!';
		}
		
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
	/**
	 * @return string email of the user record
	 */
	public function getEmail()
	{
		return $this->_email;
	}

	public function setEmail($email)
	{
		$this->_email=$email;
	}
}