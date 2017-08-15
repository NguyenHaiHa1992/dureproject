<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CustomerIdentity extends CUserIdentity
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
		$criteria=new CDbCriteria;
		$criteria->compare('email',$this->email);	
		$user=Customer::model()->find($criteria);
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			$this->_email=$user->email;
			$this->errorCode=self::ERROR_NONE;
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