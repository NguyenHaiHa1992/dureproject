<?php

/**
 * This is the model class for table "{{part}}".
 *
 * The followings are the available columns in table '{{part}}':
 * @property string $id
 * @property string $part_code
 * @property string $category_id
 * @property string $description
 * @property string $design
 * @property string $revision
 * @property string $uom
 * @property string $optimum_inventory
 * @property string $inventory_on_hand
 * @property string $notes
 * @property string $location
 * @property string $shop_floor
 * @property string $material_id
 * @property string $bar_length_pc
 * @property string $bars_needed
 * @property double $slug_length
 * @property string $heat_code
 * @property string $designation
 * @property integer $status
 * @property string $created_time
 */
class Part extends CActiveRecord
{
	public $tmp_file_ids;
	public $arr_machine_ids;
	public $arr_location_ids;
	public $heatnumbers;
	public $quantity;
    public $_oldAttributes = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{part}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('part_code, category_id, description, drawing, revision, optimum_inventory, material_id, bar_length, part_length, client_id', 'required'),
			array('part_code', 'unique'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('slug_length, uom_id', 'numerical'),
			array('part_code, design, revision, shop_floor, designation', 'length', 'max'=>255),
			array('category_id, optimum_inventory, inventory_on_hand, material_id, bar_length_pc, bars_needed, created_time', 'length', 'max'=>11),
			array('description', 'length', 'max'=>2048),
			array('location, drawing', 'length', 'max'=>255),
			array('tmp_file_ids, arr_machine_ids, arr_location_ids, drawing_file_id, part_length, bar_length','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, part_code, category_id, description, design, revision, uom_id, optimum_inventory, inventory_on_hand, notes, location, shop_floor, material_id, bar_length_pc, bars_needed, slug_length, heat_code, designation, status, created_time', 'safe', 'on'=>'search'),
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
			'category'=>array(self::BELONGS_TO,'PartCategory','category_id'),
			'material'=>array(self::BELONGS_TO,'Material','material_id'),
			'uom'=>array(self::BELONGS_TO,'Uom','uom_id'),
			'files' => array(self::MANY_MANY, 'File', 'tbl_part_file(part_id, file_id)'),
			'machines' => array(self::MANY_MANY, 'Machine', 'tbl_part_machine(part_id, machine_id)'),
			'locations' => array(self::MANY_MANY, 'PartLocation', 'tbl_partlocation_part(part_id, location_id)'),
			'drawing_file'=>array(self::BELONGS_TO,'File','drawing_file_id'),
			'client'=>array(self::BELONGS_TO,'Client','client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'part_code' => 'Part Code',
			'category_id' => 'Category',
			'description' => 'Description',
			'design' => 'Design',
			'revision' => 'Revision',
			'uom' => 'Uom',
			'price' => 'Price',
			'optimum_inventory' => 'Optimum Inventory',
			'inventory_on_hand' => 'Inventory On Hand',
			'notes' => 'Notes',
			'location' => 'Location',
			'shop_floor' => 'Shop Floor',
			'material_id' => 'Material',
			'bar_length_pc' => 'Bar Length Pc',
			'bars_needed' => 'Bars Needed',
			'slug_length' => 'Slug Length',
			'heat_code' => 'Heat Code',
			'designation' => 'Designation',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'tmp_file_ids'=>'Uploaded file',
			'arr_machine_ids'=>'Related machines',
			'drawing_file_id'=>'Drawing file',
			'client'=>'Customer'
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
		$criteria->compare('part_code',$this->part_code,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('design',$this->design,true);
		$criteria->compare('revision',$this->revision,true);
		$criteria->compare('uom_id',$this->uom_id,true);
		$criteria->compare('optimum_inventory',$this->optimum_inventory,true);
		$criteria->compare('inventory_on_hand',$this->inventory_on_hand,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('shop_floor',$this->shop_floor,true);
		$criteria->compare('material_id',$this->material_id,true);
		$criteria->compare('bar_length_pc',$this->bar_length_pc,true);
		$criteria->compare('bars_needed',$this->bars_needed,true);
		$criteria->compare('slug_length',$this->slug_length);
		$criteria->compare('designation',$this->designation,true);
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
		$list = $this->files;
		$result = array();
		foreach ($list as $file) {
			$result[] = $file->id;
		}
		$this->tmp_file_ids = implode(',',$result);

		$list = $this->machines;
		$result = array();
		foreach ($list as $machine) {
			$result[] = $machine->id;
		}
		$this->arr_machine_ids = $result;

		$list = $this->locations;
		$result = array();
		foreach ($list as $location) {
			$result[] = $location->id;
		}
		$this->arr_location_ids = $result;

		// Get all attribute including virtual attributes
		$this->_oldAttributes = $this->getAttributes($this->safeAttributeNames);

		// Get list heatnumbers & total quantity
		$total_quantity = 0;

		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $this->id);
		$full_heatnumbers = PartHeatnumber::model()->findAll($criteria);
		$heatnumbers = array();
		foreach($full_heatnumbers as $heatnumber){
			$heatnumbers[] = array(
				'id'=>$heatnumber->id, 
				'part_id'=>$heatnumber->part_id,
				'heatnumber'=>$heatnumber->heatnumber, 
				'drawing'=>$heatnumber->drawing,
				'quantity'=>$heatnumber->quantity,
				'edit'=>false
			);

			//Update total quantity
			$total_quantity = $total_quantity + $heatnumber->quantity;
		}

		$this->heatnumbers = $heatnumbers;
		$this->quantity = $total_quantity;

		return parent::afterFind();
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
				$this->uom_id = 4; // Fix uom = each for all parts
			}

			return true;
		}
	}

	protected function afterSave()
	{
		$new_list_file_ids=explode(',',$this->tmp_file_ids);
		foreach ($new_list_file_ids as $file_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('part_id',$this->id);
			$criteria->compare('file_id',$file_id);
			$document_file=PartFile::model()->find($criteria);
			if(!isset($document_file)){
				$document_file=new PartFile();
				$document_file->part_id=$this->id;
				$document_file->file_id=$file_id;
				$document_file->save();
			}
			
		}		
		$list_current_file_ids=$this->list_current_file_ids;
		foreach ($list_current_file_ids as $file_id) {
			if(!in_array($file_id,$new_list_file_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('part_id',$this->id);
				$criteria->compare('file_id',$file_id);
				PartFile::model()->deleteAll($criteria);
			}
		}

		// Save multi machine
		$new_list_machine_ids = $this->arr_machine_ids;

		foreach ($new_list_machine_ids as $machine_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('part_id',$this->id);
			$criteria->compare('machine_id',$machine_id);
			$machine = PartMachine::model()->find($criteria);
			if(!isset($machine)){
				$machine = new PartMachine();
				$machine->part_id = $this->id;
				$machine->machine_id = $machine_id;
				$machine->save();
			}
			
		}		
		$list_current_machine_ids = $this->list_current_machine_ids;
		foreach ($list_current_machine_ids as $machine_id) {
			if(!in_array($machine_id, $new_list_machine_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('part_id',$this->id);
				$criteria->compare('machine_id',$machine_id);
				PartMachine::model()->deleteAll($criteria);
			}
		}

		// Save multi locaton
		$new_list_location_ids = $this->arr_location_ids;

		foreach ($new_list_location_ids as $location_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('part_id',$this->id);
			$criteria->compare('location_id',$location_id);
			$location = PartLocationPart::model()->find($criteria);
			if(!isset($location)){
				$location = new PartLocationPart();
				$location->part_id = $this->id;
				$location->location_id = $location_id;
				$location->save();
			}
			
		}

		$list_current_location_ids = $this->list_current_location_ids;
		foreach ($list_current_location_ids as $location_id) {
			if(!in_array($location_id, $new_list_location_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('part_id',$this->id);
				$criteria->compare('location_id',$location_id);
				PartLocationPart::model()->deleteAll($criteria);
			}
		}

		// Update heatnumber
		foreach($this->heatnumbers as $h){
			if(isset($h['is_edit']) && $h['is_edit']){
				if(isset($h['id'])){
					$heatnumber = PartHeatnumber::model()->findByPk($h['id']);
					if(isset($heatnumber) && $heatnumber->part_id == $h['part_id']){
						$heatnumber->heatnumber = $h['heatnumber'];
						if(isset($h['drawing']))
							$heatnumber->drawing = $h['drawing'];
						if(isset($h['designation']))
							$heatnumber->designation = $h['designation'];
						$heatnumber->save();
					}
				}
				else{
					$heatnumber = new PartHeatnumber();
					$heatnumber->part_id = $this->id;
					if(isset($h['drawing']))
						$heatnumber->drawing = $h['drawing'];
					if(isset($h['designation']))
						$heatnumber->designation = $h['designation'];
					$heatnumber->save();
				}
			}
		}

		// Save to history
		History::trackChange($this);

	    parent::afterSave();
	}

	protected function afterDelete()
    {
    	parent::afterDelete();

		$criteria=new CDbCriteria();
		$criteria->addCondition('part_id ='.$this->id);
		PartFile::model()->deleteAll($criteria);

		$criteria=new CDbCriteria();
		$criteria->addCondition('part_id ='.$this->id);
		PartMachine::model()->deleteAll($criteria);
	}

	public function getList_current_file_ids(){
		$list=$this->files;
		$result=array();
		foreach ($list as $file) {
			$result[]=$file->id;
		}
		return $result;
	}

	public function getList_current_machine_ids(){
		$list=$this->machines;
		$result=array();
		foreach ($list as $machine) {
			$result[]=$machine->id;
		}
		return $result;
	}

	public function getList_current_location_ids(){
		$list=$this->locations;
		$result=array();
		foreach ($list as $location) {
			$result[]=$location->id;
		}
		return $result;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Part the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPrice($qty = null){
		if($qty == null)
			$qty = 0;

		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $this->id);
		$prices = PartPrice::model()->findAll($criteria);
		$i = 0;
		$j = 0;
		$tmp = 0;
		$tmp_price = 0;
		$biggest_price = 0;

		foreach($prices as $price){
			if($price->max >= $qty){
				if($i == 0){
					$tmp = $price->max;
					$tmp_price = $price->price;

				}
				if($tmp > $price->max){
					$tmp = $price->max;
					$tmp_price = $price->price;
				}
				$i++;
			}

			// Find the biggest quantity
			if($j == 0){
				$biggest_max = $price->max;
				$biggest_price = $price->price;
			}
			if($biggest_max < $price->max){
				$biggest_max = $price->max;
				$biggest_price = $price->price;
			}
			$j++;
		}

		if($i==0){
			$tmp_price = $biggest_price;
		}

		return $tmp_price;
	}

	public function getTablePrice(){
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $this->id);
		$criteria->order = "max desc, id desc";
		$prices = PartPrice::model()->findAll($criteria);

		$table_body = '';
		$i = 0;
		foreach($prices as $price){
			$i++;
			$table_body .= '<tr><td>'.$i.'</td><td align="left">'.$price->max.'</td><td align="right">$'.number_format($price->price,2,".",",").'</td></tr>';
		}

		$table = '<table cellpadding=5 cellspacing=0 style="border-collapse: collapse;">
					<thead>
						<tr>
							<th>No</th>
							<th style="width: 70px; text-align: left;">Up to</th>
							<th style="width: 100px; text-align: right;" align="right">$ Price</th>
						</tr>
					</thead>
					<tbody>
						'.$table_body.'
					</tbody>
				  </table>';

		return $table;
	}

	public function getTableInformation(){
		$criteria = new CDbCriteria();
		$criteria->compare('part_id', $this->id);
		$criteria->order = "max desc, id desc";
		$prices = PartPrice::model()->findAll($criteria);

		$table_body = '';
		$i = 0;
		foreach($prices as $price){
			$i++;
			$table_body .= '<tr>
								<td align="left">'.$price->max.'</td>
								<td align="right">$'.number_format($price->price,2,".",",").'</td>
							</tr>';
		}

		$table = '<table cellpadding=5 cellspacing=0 style="border-collapse: collapse;">
					<thead>
						<tr>
							<th style="width: 70px; text-align: left;">Field</th>
							<th style="width: 100px; text-align: left;">Content</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Part code</td>
							<td>'.$this->part_code.'</td>
						</tr>
						<tr>
							<td>Material code</td>
							<td>'.$this->material->material_code.'</td>
						</tr>
						<tr>
							<td>Optimum</td>
							<td>'.$this->optimum_inventory.'</td>
						</tr>
						<tr>
							<td>Stock in hand</td>
							<td>'.$this->quantity.'</td>
						</tr>
						<tr>
							<td>Heat numbers</td>
							<td>'.$this->getHeatCodeConverted().'</td>
						</tr>
						<tr>
							<td>Drawing</td>
							<td>'.$this->drawing.'</td>
						</tr>
					</tbody>
				  </table>';

		return $table;
	}

	public function getHeatCodeConverted(){
		if(is_array($this->heatnumbers)){
			$list = array();
			foreach($this->heatnumbers as $heatnumber){
				$list[] = $heatnumber['heatnumber'];
			}
			return implode(', ', $list);
		}
	}
}
