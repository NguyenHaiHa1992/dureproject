<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property integer $type
 * @property integer $status
 * @property string $created_time
 */
class User extends CActiveRecord
{
	public $old_password,$new_password,$confirm_password,$clear_password;
	public $role=array();
	public $old_role=array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, role', 'required'),
			array('email', 'unique'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('username, salt, password', 'length', 'max'=>128),
			array('email, clear_password', 'length', 'max'=>50),
			array('created_time', 'length', 'max'=>11),
			array('role', 'validatorRole'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, salt, password, type, status, created_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * 
	 * Function validator role
	 * @param unknown_type $attributes
	 * @param unknown_type $params
	 */
	public function validatorRole($attributes,$params){
		foreach ($this->role as $role) {
			if(!in_array($role, array_keys(AuthItem::getList_all_roles()))){
				$this->addError('role', 'This role does not exist');
			}
		}
	}
	/**
	 * 
	 * Function validator role
	 * @param unknown_type $attributes
	 * @param unknown_type $params
	 */
	public function validatorOldPassword($attributes,$params){
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(!$user->validatePassword($this->old_password)){
			$this->addError('old_password','Password is not correct!');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'salt' => 'Salt',
			'password' => 'Password',
			'type' => 'Type',
			'status' => 'Status',
			'created_time' => 'Created Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @param string salt
	 * @return string hash
	 */
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	public function generateSalt()
	{
		return uniqid('',true);
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind()
	{	
		//Set role of user
		$list_roles = Yii::app()->authManager->getRoles($this->id);
		foreach ($list_roles as $name=>$role){
			$this->role[]=$name;
		}

		//Set old_role 
		$this->old_role=$this->role;
		return parent::afterFind();
	}

	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_time=time();
				$this->created_by=Yii::app()->user->id;
			}	

			return true;
		}
		else
			return false;
	}
	/**
	 * This method is invoked after saving a record successfully.
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do postprocessing after record saving.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterSave()
	{
		$a = $this->addRoles(array_values(array_diff($this->role,$this->old_role)));
		$this->removeRoles(array_values(array_diff($this->old_role,$this->role)));

		parent::afterSave();
	}
	
	protected function afterDelete()
    {
    	parent::afterDelete();

		$criteria=new CDbCriteria();
		$criteria->addCondition('userid ='.$this->id);
		AuthAssignment::model()->deleteAll($criteria);
	}

	//Handler add and romove roles
	public function addRoles($list)
	{
		foreach ($list as $role){
			Yii::app()->authManager->assign($role,$this->id);
		}
	}
	public function removeRoles($list)
	{
		foreach ($list as $role){
			Yii::app()->authManager->revoke($role,$this->id);
		}
	}

	/**
	 * Generates password.
	 * @return string password
	 */
	public static function generatePassword($length)
	{
		$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$i = 0;
		$password = "";
		while ($i <= $length) {
			$password .= $chars{rand(0,strlen($chars)-1)};
			$i++;
		}
		return $password;
	}
}
