<?php

/**
 * This is the model class for table "{{material_location}}".
 *
 * The followings are the available columns in table '{{material_location}}':
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $created_time
 */
class MaterialPrice extends CActiveRecord
{
	public $price_per_lbs;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{material_price}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, vendor_id, total_inch, weight, price_per_inch, date', 'required'),
			array('material_id, vendor_id', 'numerical', 'integerOnly'=>true),
			array('created_time, created_by','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, vendor_id, total_inch, weight, price_per_inch', 'safe', 'on'=>'search'),
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
			'material'=>array(self::BELONGS_TO,'Material','material_id'),
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
			'material_id' => 'Material',
			'vendor_id' => 'Vendor',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('material_id',$this->material_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Machine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeDelete(){
		// // Check in_out_material existed, if existed, avoid deleting
		// $criteria = new CDbCriteria();
		// $criteria->compare('id', $this->id);
		
	 //    if($this->is_required=='no'){
	 //        return true;
	 //    }
	 //    return false;
		return true;
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
			if($this->isNewRecord){
				$this->created_time = time();
				$this->created_by = Yii::app()->user->id;
			}

			$this->price_per_lbs = $this->price_per_inch * $this->total_inch / $this->weight;

			return true;
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		$this->price_per_lbs = $this->price_per_inch * $this->total_inch / $this->weight;

		return parent::afterFind();
	}

	protected function afterSave()
	{
	    parent::afterSave();
	}
}
