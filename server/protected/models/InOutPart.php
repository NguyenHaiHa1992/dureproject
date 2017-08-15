<?php

/**
 * This is the model class for table "{{part}}".
 *
 * The followings are the available columns in table '{{part}}':
 * @property string $id
 * @property string $part_code
 * @property string $category_id
 * @property string $date
 * @property string $vendor
 * @property double $inch_price
 * @property double $total_cost
 * @property integer $status
 * @property string $created_time
 */
class InOutPart extends CActiveRecord
{
	const TYPE_CHECK_IN = 0;
	const TYPE_CHECK_OUT = 1;

	public $quantity;
	public $location_labels;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{in_out_part}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('part_id, received_by, heatnumbers', 'required', 'on'=>'checkin'),
			array('part_id, received_by, heatnumbers, purchase_order_id', 'required', 'on'=>'checkout'),
			array('heatnumber_ids', 'required', 'message'=>'At least one heatnumber must be selected.'),
			//array('location_ids', 'required', 'on'=>'checkin', 'message'=>'At least one location must be selected.'),
			array('type, received_by', 'numerical', 'integerOnly'=>true),
			array('received_date', 'numerical', 'integerOnly'=>true,'message'=>'Received Date must be a valid Date'),
			array('note', 'length', 'max'=>255),
			array('heatnumber_ids, location_ids, coc_files', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, part_id', 'safe', 'on'=>'search'),
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
			'employee'=>array(self::BELONGS_TO,'Employee','received_by'),
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
		$criteria->compare('part_id',$this->part_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InOutPart the static model class
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
			}

			$this->updated_time = time();

			if($this->heatnumber_ids != array())
				$this->heatnumber_ids = json_encode($this->heatnumber_ids);
			else
				$this->heatnumber_ids = '';

			if($this->heatnumbers != array())
				$this->heatnumbers = json_encode($this->heatnumbers);
			else
				$this->heatnumbers = '';

			if($this->coc_files != array())
				$this->coc_files = json_encode($this->coc_files);
			else
				$this->coc_files = '';

			return true;
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		$this->heatnumber_ids = json_decode($this->heatnumber_ids);
		$this->heatnumbers = json_decode($this->heatnumbers);
		$this->coc_files = json_decode($this->coc_files);

		$total_quantity = 0;
		$heatnumbers = $this->heatnumbers;
		if(is_array($heatnumbers)){
			$i = 0;
			foreach ($heatnumbers as $heatnumber) {
				$total_quantity = $total_quantity + $heatnumber->quantity;

				if(isset($heatnumber->quantity_details))
					$quantity_details = $heatnumber->quantity_details;
				else
					$quantity_details = array();

				if(is_array($quantity_details)){
					$j = 0;
					foreach($quantity_details as $detail){
						if(isset($detail->location_id)){
							$location = PartLocation::model()->findByPk($detail->location_id);
						}
						if(isset($location)){
							$detail->location = $location->name;
						}
						else{
							if(is_object($detail))
								$detail->location = "N/A";
						}

						$quantity_details[$j] = $detail;
						$j++;
					}
				}

				$heatnumber->quantity_details = $quantity_details;
				$heatnumbers[$i] = $heatnumber;
				$i++;
			}
		}

		$this->heatnumbers = $heatnumbers;
		$this->quantity = $total_quantity;

		return parent::afterFind();
	}

	protected function afterSave()
	{
		$this->heatnumber_ids = json_decode($this->heatnumber_ids);
		$this->heatnumbers = json_decode($this->heatnumbers);
		$this->coc_files = json_decode($this->coc_files);

	    parent::afterSave();
	}

	public function getTypeLabel(){
		if($this->type == self::TYPE_CHECK_IN)
			return 'Check-in';

		if($this->type == self::TYPE_CHECK_OUT)
			return 'Check-out';
	}
}
