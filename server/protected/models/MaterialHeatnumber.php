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
class MaterialHeatnumber extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{material_heatnumber}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, heatnumber', 'required'),
			array('status, material_id, quantity', 'numerical', 'integerOnly'=>true),
			array('heatnumber, designation', 'length', 'max'=>255),
			array('quantity_detail','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, heatnumber, drawing, status, quantity', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('status',$this->status);

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
				// Check heatnumber is not dupplicated
				$criteria = new CDbCriteria();
				$criteria->compare('material_id', $this->material_id);
				$criteria->compare('heatnumber', $this->heatnumber);

				$heatnumber = MaterialHeatnumber::model()->find($criteria);
				if(isset($heatnumber)){
					 $this->addError('heatnumber', 'This heatnumber existed!');
					 return false;
				}
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

	protected function afterSave()
	{
		$this->quantity_detail = json_decode($this->quantity_detail);

	    parent::afterSave();
	}
}
