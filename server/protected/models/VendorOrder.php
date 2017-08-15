<?php

/**
 * This is the model class for table "{{vendor_order}}".
 *
 * The followings are the available columns in table '{{vendor_order}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property integer $image_id
 */
class VendorOrder extends CActiveRecord
{
	const STATUS_WAITING = 0;
	const STATUS_ACCEPT = 1;
	const STATUS_DECLINE = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VendorOrder the static model class
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
		return '{{vendor_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, order_id', 'required'),
			array('vendor_id, order_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vendor_id, order_id', 'safe', 'on'=>'search'),
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
			'order'=>array(self::BELONGS_TO,'PurchaseOrder','order_id'),
			'vendor'=>array(self::BELONGS_TO,'Vendor','vendor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vendor_id' => 'Vendor',
			'order_id' => 'Order',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('order_id',$this->order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
		if(parent::beforeSave()){
			if($this->isNewRecord)
			{
				$this->created_time=time();
				$this->created_by=Yii::app()->user->id;
			}
			return true;
		}
	}

}