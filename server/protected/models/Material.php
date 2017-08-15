<?php

/**
 * This is the model class for table "{{material}}".
 *
 * The followings are the available columns in table '{{material}}':
 * @property string $id
 * @property string $material_code
 * @property string $category_id
 * @property string $date
 * @property string $vendor
 * @property double $inch_price
 * @property double $total_cost
 * @property integer $status
 * @property string $created_time
 */
class Material extends CActiveRecord
{
    public $_oldAttributes = array();
    public $heatnumbers;
    public $quantity;
    public $total_length;
    public $arr_location_ids;

    public $AM_DESIGNATION_OPTIONS = array('General'=>'C', 'Brass'=>'B','Other'=>'A');

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{material}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_code_id, category_id, status, uol_id, shape_id, am_designation', 'required'),
			array('designation_id', 'unique'),
			array('status, upload_file_id', 'numerical', 'integerOnly'=>true),
			array('category_id', 'numerical'),
			array('material_code', 'length', 'max'=>50),
			array('receiver', 'length', 'max'=>255),
			array('note, location, heat_number', 'length', 'max'=>255),
			array('date, created_time', 'length', 'max'=>11),
			array('shape_id, uom_id, uoq_id, designation_id, heat_number, material_code_id', 'safe'),
			// Size rule
			array('sizes, inches, quantity, total_lbs, cost_lbs, cost_inch, optimum_inventory, stock_in_hand, arr_location_ids', 'safe'),
			array('quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_code, category_id, date, status, created_time', 'safe', 'on'=>'search'),

			// Unique (material_code_id, shape_id)
			array('material_code_id', 'validatorMaterialCode'),
		);
	}

	public function validatorMaterialCode($attribute,$params)
	{
		if($this->material_code_id != 0){
			$criteria = new CDbCriteria();
			$criteria->compare('material_code_id', $this->material_code_id);
			$criteria->compare('shape_id', $this->shape_id);
			if(isset($this->id))
				$criteria->addCondition('id <>'.$this->id);
			$material = Material::model()->find($criteria);

			if (isset($material)){
				$this->addError('material_code_id', "The pair (material code, shape) must be unique!");
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category'=>array(self::BELONGS_TO,'MaterialCategory','category_id'),
			'materialCode'=>array(self::BELONGS_TO,'MaterialCode','material_code_id'),
			'uom'=>array(self::BELONGS_TO,'Uom','uom_id'),
			'uoq'=>array(self::BELONGS_TO,'Uoq','uoq_id'),
			'uol'=>array(self::BELONGS_TO,'Uol','uol_id'),
			'upload_file'=>array(self::BELONGS_TO,'File','upload_file_id'),
			'shape'=>array(self::BELONGS_TO,'Shape','shape_id'),
			'locations' => array(self::MANY_MANY, 'MaterialLocation', 'tbl_materiallocation_material(material_id, location_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'material_code' => 'Material Code',
			'category_id' => 'Material Type',
			'date' => 'Date',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'uoq_id' =>'Quoted in',
			'uom_id' => 'UoM',
			'shape_id' =>'Shape'
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
		$criteria->compare('material_code',$this->material_code,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('shape_id',$this->shape_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Material the static model class
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
				$this->status = 1;
				$this->created_time=time();
			}

			$this->sizes = json_encode($this->sizes);

			// If material_code_id change, Update material code from material code db
			//if(isset($this->_oldAttributes['material_code_id']) && $this->material_code_id != $this->_oldAttributes['material_code_id']){
				if(isset($this->materialCode))
					$this->material_code = $this->materialCode->code;

				return true;				
			//}
		}
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	protected function afterFind(){
		// Get all attribute including virtual attributes
		$this->_oldAttributes = $this->getAttributes($this->safeAttributeNames);

		if(!isset($this->designation_id) || $this->designation_id == ''){
			$label_list = $this->AM_DESIGNATION_OPTIONS;
			if(isset($label_list[$this->am_designation])){
				$label = $label_list[$this->am_designation];
				$this->designation_id = $label.$this->id;
			}
		}

		$this->sizes = json_decode($this->sizes);

		// Get list heatnumbers & total quantity & total length
		$quantity = 0;
		$total_length = 0;

		$criteria = new CDbCriteria();
		$criteria->compare('material_id', $this->id);
		$full_heatnumbers = MaterialHeatnumber::model()->findAll($criteria);
		$heatnumbers = array();
		foreach($full_heatnumbers as $heatnumber){
			// Update heatnumber designation
			if(!isset($heatnumber->designation) || $heatnumber->designation == ''){
				$label_list = $this->AM_DESIGNATION_OPTIONS;
				if(isset($label_list[$this->am_designation])){
					$label = $label_list[$this->am_designation];
					$heatnumber->designation = $label.$heatnumber->id;
				}
			}

			$heatnumber_length = 0;
			$heatnumber_list_length = array();
			// Update total length
			$heatnumber_quantity_detail = $heatnumber->quantity_detail;
			if(is_array($heatnumber_quantity_detail)){
				foreach ($heatnumber_quantity_detail as $quantity_detail) {
					$heatnumber_list_length[] = $quantity_detail->length;
					$heatnumber_length = $heatnumber_length + $quantity_detail->quantity * $quantity_detail->length;
					$total_length = $total_length + $quantity_detail->quantity * $quantity_detail->length;
				}	
			}

			// Update heatnumbers
			$heatnumbers[] = array(
				'id'=>$heatnumber->id, 
				'material_id'=>$heatnumber->material_id,
				'heatnumber'=>$heatnumber->heatnumber, 
				'designation'=>$heatnumber->designation,
				'quantity'=>$heatnumber->quantity,
				'total_length'=>$heatnumber_length,
				'list_length'=>$heatnumber_list_length,
				'quantity_detail'=>$heatnumber->quantity_detail,
				'edit'=>false
			);

			// Update quantity
			$quantity = $quantity + $heatnumber->quantity;
		}

		$this->heatnumbers = $heatnumbers;
		$this->quantity = $quantity;
		$this->total_length = $total_length;

		// Update locations
		$list = $this->locations;
		$result = array();
		foreach ($list as $location) {
			$result[] = $location->id;
		}
		$this->arr_location_ids = $result;

		return parent::afterFind();
	}

	protected function afterSave()
	{
		// Update heatnumber
		foreach($this->heatnumbers as $h){
			if(isset($h['is_edit']) && $h['is_edit']){
				if(isset($h['id'])){
					$heatnumber = MaterialHeatnumber::model()->findByPk($h['id']);
					if(isset($heatnumber) && $heatnumber->material_id == $h['material_id']){
						$heatnumber->heatnumber = $h['heatnumber'];
						$heatnumber->designation = $h['designation'];
						$heatnumber->save();
					}
				}
				else{
					$heatnumber = new MaterialHeatnumber();
					$heatnumber->material_id = $this->id;
					$heatnumber->heatnumber = $h['heatnumber'];
					$heatnumber->designation = $h['designation'];
					$heatnumber->save();
				}
			}
		}

		// Save multi locaton
		$new_list_location_ids = $this->arr_location_ids;

		foreach ($new_list_location_ids as $location_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('material_id',$this->id);
			$criteria->compare('location_id',$location_id);
			$location = MaterialLocationMaterial::model()->find($criteria);
			if(!isset($location)){
				$location = new MaterialLocationMaterial();
				$location->material_id = $this->id;
				$location->location_id = $location_id;
				$location->save();
			}
			
		}

		$list_current_location_ids = $this->list_current_location_ids;
		foreach ($list_current_location_ids as $location_id) {
			if(!in_array($location_id, $new_list_location_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('material_id',$this->id);
				$criteria->compare('location_id',$location_id);
				MaterialLocationMaterial::model()->deleteAll($criteria);
			}
		}

		// Save to history
		History::trackChange($this);

	    parent::afterSave();
	}

	public function getShapeImage(){
		if(isset($this->shape))
			return FileService::getAbsoluteUrl($this->shape->image_id);
		else
			return '';
	}


	public function getList_current_location_ids(){
		$list = $this->locations;
		$result=array();
		foreach ($list as $location) {
			$result[]=$location->id;
		}
		return $result;
	}
}
