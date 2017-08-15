<?php

/**
 * This is the model class for table "{{material_attribute}}".
 *
 * The followings are the available columns in table '{{material_attribute}}':
 * @property string $id
 * @property string $material_id
 * @property double $size_in_ft
 * @property string $count
 * @property string $weight
 * @property double $lbs_price
 * @property string $purpose
 * @property string $optimum_inventory
 * @property integer $stock_in_hand
 * @property integer $status
 * @property string $created_time
 */
class MaterialAttribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{material_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, size_in_ft, count, weight, optimum_inventory, stock_in_hand, status, created_time', 'required'),
			array('stock_in_hand, status', 'numerical', 'integerOnly'=>true),
			array('size_in_ft', 'numerical'),
			array('material_id, count, weight, optimum_inventory, created_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, size_in_ft, count, weight, optimum_inventory, stock_in_hand, status, created_time', 'safe', 'on'=>'search'),
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
			'material_id' => 'Material',
			'size_in_ft' => 'Size In Ft',
			'count' => 'Count',
			'weight' => 'Weight',
			'optimum_inventory' => 'Optimum Inventory',
			'stock_in_hand' => 'Stock In Hand',
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
		$criteria->compare('material_id',$this->material_id,true);
		$criteria->compare('size_in_ft',$this->size_in_ft);
		$criteria->compare('count',$this->count,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('optimum_inventory',$this->optimum_inventory,true);
		$criteria->compare('stock_in_hand',$this->stock_in_hand);
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
	 * @return MaterialAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
