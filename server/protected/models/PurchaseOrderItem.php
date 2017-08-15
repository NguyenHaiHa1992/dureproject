<?php

/**
 * This is the model class for table "{{purchase_order_item}}".
 *
 * The followings are the available columns in table '{{purchase_order_item}}':
 * @property string $id
 * @property string $purchase_order_id
 * @property string $line_number
 * @property string $quantity
 * @property string $uom
 * @property string $part_id
 * @property string $description
 * @property string $revision
 * @property string $drawing_id
 * @property string $price
 * @property double $discount
 * @property string $delivery_date
 * @property integer $take_from_inventory
 * @property integer $status
 * @property string $created_time
 */
class PurchaseOrderItem extends CActiveRecord
{
	public $pulled_quantity;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{purchase_order_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id, item_name, quantity, price', 'required'),
			array('quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_id, item_name, quantity, price', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_id' => 'Purchase Order',
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
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		return parent::afterFind();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseOrderItem the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
}
