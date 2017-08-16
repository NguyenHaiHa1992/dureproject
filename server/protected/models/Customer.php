<?php

/**
 * This is the model class for table "{{customer}}".
 *
 * The followings are the available columns in table '{{customer}}':
 * @property string $id
 * @property string $ship_to
 * @property string $ship_oa
 * @property string $ship_address
 * @property string $bill_to
 * @property string $bill_oa
 * @property string $bill_address
 * @property string $phone
 * @property string $fax
 * @property integer $document_id
 * @property string $note
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_time
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_id, status, created_time, updated_time', 'numerical', 'integerOnly'=>true),
			array('ship_oa, bill_oa, fax', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>50),
			array('ship_to, ship_address, bill_to, bill_address, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ship_to, ship_oa, ship_address, bill_to, bill_oa, bill_address, phone, fax, document_id, note, status, created_time, updated_time', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'ship_to' => 'Ship To',
			'ship_oa' => 'Ship Oa',
			'ship_address' => 'Ship Address',
			'bill_to' => 'Bill To',
			'bill_oa' => 'Bill Oa',
			'bill_address' => 'Bill Address',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'document_id' => 'Document',
			'note' => 'Note',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
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
		$criteria->compare('ship_to',$this->ship_to,true);
		$criteria->compare('ship_oa',$this->ship_oa,true);
		$criteria->compare('ship_address',$this->ship_address,true);
		$criteria->compare('bill_to',$this->bill_to,true);
		$criteria->compare('bill_oa',$this->bill_oa,true);
		$criteria->compare('bill_address',$this->bill_address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
