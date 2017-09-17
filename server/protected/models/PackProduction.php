<?php

/**
 * This is the model class for table "{{pack_production}}".
 *
 * The followings are the available columns in table '{{pack_production}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $customer_id
 * @property integer $date
 * @property string $begin_sample_weight
 * @property string $pack_use
 * @property string $net_weight
 * @property string $density
 * @property string $length_pack
 * @property string $long_heart_temp
 * @property string $cross_heart_temp
 * @property string $dose_volume
 * @property string $rev_dose
 * @property string $auger_speed
 * @property string $pack_per_minute
 * @property string $amount_left
 * @property string $carton_use
 * @property string $amoutn_per_carton
 * @property string $weight_carton
 * @property string $pack_per_carton
 * @property string $customer_request_spec
 * @property string $pack_net_weight
 * @property string $note
 * @property integer $document_id
 * @property integer $in_trash
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_by
 * @property integer $created_by
 * @property integer $plant_manager
 */
class PackProduction extends CActiveRecord
{
        public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pack_production}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, customer_id, date, document_id, in_trash, status, created_time, updated_by, created_by, plant_manager', 'numerical', 'integerOnly'=>true),
			array('begin_sample_weight, pack_use, net_weight, density, length_pack, long_heart_temp, cross_heart_temp, dose_volume, rev_dose, auger_speed, pack_per_minute, amount_left, carton_use, amoutn_per_carton, weight_carton, pack_per_carton, customer_request_spec, pack_net_weight, note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, customer_id, date, begin_sample_weight, pack_use, net_weight, density, length_pack, long_heart_temp, cross_heart_temp, dose_volume, rev_dose, auger_speed, pack_per_minute, amount_left, carton_use, amoutn_per_carton, weight_carton, pack_per_carton, customer_request_spec, pack_net_weight, note, document_id, in_trash, status, created_time, updated_by, created_by, plant_manager', 'safe', 'on'=>'search'),
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
			'project_id' => 'Project',
			'customer_id' => 'Customer',
			'date' => 'Date',
			'begin_sample_weight' => 'Begin Sample Weight',
			'pack_use' => 'Pack Use',
			'net_weight' => 'Net Weight',
			'density' => 'Density',
			'length_pack' => 'Length Pack',
			'long_heart_temp' => 'Long Heart Temp',
			'cross_heart_temp' => 'Cross Heart Temp',
			'dose_volume' => 'Dose Volume',
			'rev_dose' => 'Rev Dose',
			'auger_speed' => 'Auger Speed',
			'pack_per_minute' => 'Pack Per Minute',
			'amount_left' => 'Amount Left',
			'carton_use' => 'Carton Use',
			'amoutn_per_carton' => 'Amoutn Per Carton',
			'weight_carton' => 'Weight Carton',
			'pack_per_carton' => 'Pack Per Carton',
			'customer_request_spec' => 'Customer Request Spec',
			'pack_net_weight' => 'Pack Net Weight',
			'note' => 'Note',
			'document_id' => 'Document',
			'in_trash' => 'In Trash',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'updated_by' => 'Updated By',
			'created_by' => 'Created By',
			'plant_manager' => 'Plant Manager',
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
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('begin_sample_weight',$this->begin_sample_weight,true);
		$criteria->compare('pack_use',$this->pack_use,true);
		$criteria->compare('net_weight',$this->net_weight,true);
		$criteria->compare('density',$this->density,true);
		$criteria->compare('length_pack',$this->length_pack,true);
		$criteria->compare('long_heart_temp',$this->long_heart_temp,true);
		$criteria->compare('cross_heart_temp',$this->cross_heart_temp,true);
		$criteria->compare('dose_volume',$this->dose_volume,true);
		$criteria->compare('rev_dose',$this->rev_dose,true);
		$criteria->compare('auger_speed',$this->auger_speed,true);
		$criteria->compare('pack_per_minute',$this->pack_per_minute,true);
		$criteria->compare('amount_left',$this->amount_left,true);
		$criteria->compare('carton_use',$this->carton_use,true);
		$criteria->compare('amoutn_per_carton',$this->amoutn_per_carton,true);
		$criteria->compare('weight_carton',$this->weight_carton,true);
		$criteria->compare('pack_per_carton',$this->pack_per_carton,true);
		$criteria->compare('customer_request_spec',$this->customer_request_spec,true);
		$criteria->compare('pack_net_weight',$this->pack_net_weight,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('in_trash',$this->in_trash);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('plant_manager',$this->plant_manager);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PackProduction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
