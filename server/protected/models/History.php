<?php

/**
 * This is the model class for table "{{history}}".
 *
 * The followings are the available columns in table '{{history}}':
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $created_time
 */
class History extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class, object_id', 'required'),
			array('content, created_by, created_time, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, class, object_id', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('code',$this->code);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return History the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

			$this->content = json_encode($this->content);
			return true;
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind()
	{	
		$this->content = json_decode($this->content);
		return parent::afterFind();
	}

	public static function trackChange($object){
		$history = new History();
		$history->class = get_class($object);
		$class = $history->class;
		$history->object_id = $object->id;

		$change = array();
		$i = 0;
		$old_attributes = $object->_oldAttributes;
		$attributes = $object->attributes;

		foreach($old_attributes as $attr=>$value){
			if(isset($old_attributes[$attr])){
				if($old_attributes[$attr] != $object->$attr){
					$attr_name = $class::model()->getAttributeLabel($attr);
					$change[$attr] = array('name'=>$attr_name, 'old'=>$old_attributes[$attr], 'new'=>$object->$attr);
				}
			}
			$i++;
		}
		if(count($change) > 0){
			$history->content = $change;
			$history->save();
		}
	}

	public static function trackOthers($object, $description){
		$history = new History();
		$history->class = get_class($object);
		$history->object_id = $object->id;
		$history->description = $description;
		$history->content = array();

		$history->save();
	}
}
