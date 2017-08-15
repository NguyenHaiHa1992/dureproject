<?php

/**
 * This is the model class for table "{{material_location}}".
 *
 * The followings are the available columns in table '{{material_location}}':
 * @property integer $id
 * @property integer $material_id
 * @property integer $image_id
 */
class MaterialHeatnumberLocation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaterialMachine the static model class
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
		return '{{material_heatnumber_location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_heatnumber_id, location_id', 'required'),
			array('material_heatnumber_id, location_id, quantity', 'numerical', 'integerOnly'=>true),
			array('quantity_detail','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, material_heatnumber_id, location_id', 'safe', 'on'=>'search'),
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
			'location'=>array(self::BELONGS_TO,'MaterialLocation','location_id'),
			'material_heatnumber'=>array(self::BELONGS_TO,'MaterialHeatnumber','material_heatnumber_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'material_heatnumber_id' => 'Material Heatnumber',
			'location_id' => 'Location',
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
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('material_heatnumber_id',$this->material_heatnumber_id);
		$criteria->compare('location_id',$this->location_id);

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
			}

			if($this->quantity_detail != array())
				$this->quantity_detail = json_encode($this->quantity_detail);
			else
				$this->quantity_detail = '';

			return true;
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		$this->quantity_detail = json_decode($this->quantity_detail);
		return parent::afterFind();
	}

	protected function afterSave(){
		$this->quantity_detail = json_decode($this->quantity_detail);
	    parent::afterSave();
	}
}