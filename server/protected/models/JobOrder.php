<?php

/**
 * This is the model class for table "{{job_order}}".
 *
 * The followings are the available columns in table '{{job_order}}':
 * @property integer $id
 * @property integer $client_id
 * @property integer $image_id
 */
class JobOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JobOrder the static model class
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
		return '{{job_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id', 'required'),
			array('total_part', 'numerical', 'integerOnly'=>true),
			array('jo_code', 'unique'),
			array('jo_code', 'length', 'max'=>20),
			array('created_time, created_by, updated_time, jo_group','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, purchase_order_id, created_time, created_by, updated_time', 'safe', 'on'=>'search'),
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
			'purchase_order'=>array(self::BELONGS_TO,'PurchaseOrder','purchase_order_id'),
			'author'=>array(self::BELONGS_TO,'User','created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
			$this->updated_time=time();

			if($this->isNewRecord)
			{
				$this->created_time = time();
				$this->created_by = Yii::app()->user->id;
			}

			return true;
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		if(!isset($this->jo_code) || $this->jo_code == ''){
			$this->jo_code = 'JO'.$this->id;
		}

		return parent::afterFind();
	}
}