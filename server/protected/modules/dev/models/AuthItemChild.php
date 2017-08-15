<?php

/**
 * This is the model class for table "AuthItemChild".
 *
 * The followings are the available columns in table 'AuthItemChild':
 * @property string $parent
 * @property string $child
 */
class AuthItemChild extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AuthItemChild the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'authitemchild';
	}
	
	public function primaryKey(){
       return array('parent', 'child');
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max'=>64),
		);
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
			'parent' => 'Parent',
			'child' => 'Child',
		);
	}

}