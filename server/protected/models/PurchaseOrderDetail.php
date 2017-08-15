<?php

/**
 * This is the model class for table "{{purchase_order_detail}}".
 *
 * The followings are the available columns in table '{{purchase_order_detail}}':
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
class PurchaseOrderDetail extends CActiveRecord
{
	public $pulled_quantity;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{purchase_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id, quantity, part_id, delivery_date', 'required'),
			array('take_from_inventory, status', 'numerical', 'integerOnly'=>true),
			array('discount', 'numerical'),
			array('purchase_order_id, quantity, part_id, drawing_id, price, delivery_date, created_time', 'length', 'max'=>11),
			array('line_number, item_number', 'length', 'max'=>5),
			array('uom, revision', 'length', 'max'=>20),
			array('description', 'length', 'max'=>2048),
			array('price, revised_price, revised_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_id, line_number, item_number, quantity, uom, part_id, drawing_id, price, discount, delivery_date, status, created_time', 'safe', 'on'=>'search'),
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
			'part'=>array(self::BELONGS_TO,'Part','part_id'),
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
			'line_number' => 'Line Number',
			'quantity' => 'Quantity',
			'uom' => 'Uom',
			'part_id' => 'Part',
			'description' => 'Description',
			'revision' => 'Revision',
			'drawing_id' => 'Drawing',
			'price' => 'Price',
			'discount' => 'Discount',
			'delivery_date' => 'Delivery Date',
			'take_from_inventory' => 'Take From Inventory',
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
		$criteria->compare('purchase_order_id',$this->purchase_order_id,true);
		$criteria->compare('line_number',$this->line_number,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('uom',$this->uom,true);
		$criteria->compare('part_id',$this->part_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('revision',$this->revision,true);
		$criteria->compare('drawing_id',$this->drawing_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('take_from_inventory',$this->take_from_inventory);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		// Caculate pulled quantity
		$criteria = new CDbCriteria();
		$criteria->compare('purchase_order_id', $this->purchase_order_id);
		$criteria->compare('part_id', $this->part_id);

		$list_check_out = InOutPart::model()->findAll($criteria);
		$pulled_quantity = 0;
		foreach($list_check_out as $check_out){
			$pulled_quantity = $pulled_quantity + (int)$check_out->quantity;
		}

		$this->pulled_quantity = $pulled_quantity;

		return parent::afterFind();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
