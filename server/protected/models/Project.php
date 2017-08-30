<?php

/**
 * This is the model class for table "{{project}}".
 *
 * The followings are the available columns in table '{{project}}':
 * @property string $id
 * @property integer $date
 * @property string $primary_contact
 * @property integer $customer_id
 * @property string $project_number
 * @property string $volume
 * @property string $price_point
 * @property string $life_style
 * @property string $service
 * @property string $product_match
 * @property string $note
 * @property integer $document_id
 * @property integer $created_time
 * @property string $created_by
 * @property integer $updated_by
 * @property integer $updated_time
 * @property integer $status
 */
class Project extends CActiveRecord
{
	public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, customer_id, document_id, created_time, updated_by, updated_time, status', 'numerical', 'integerOnly'=>true),
			array('primary_contact, project_number, life_style, service', 'length', 'max'=>50),
			array('volume, product_match, created_by', 'length', 'max'=>255),
			array('price_point', 'length', 'max'=>11),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, primary_contact, customer_id, project_number, volume, price_point, life_style, service, product_match, note, document_id, created_time, created_by, updated_by, updated_time, status', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'primary_contact' => 'Primary Contact',
			'customer_id' => 'Customer',
			'project_number' => 'Project Number',
			'volume' => 'Volume',
			'price_point' => 'Price Point',
			'life_style' => 'Life Style',
			'service' => 'Service',
			'product_match' => 'Product Match',
			'note' => 'Note',
			'document_id' => 'Document',
			'created_time' => 'Created Time',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
			'updated_time' => 'Updated Time',
			'status' => 'Status',
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
		$criteria->compare('date',$this->date);
		$criteria->compare('primary_contact',$this->primary_contact,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('project_number',$this->project_number,true);
		$criteria->compare('volume',$this->volume,true);
		$criteria->compare('price_point',$this->price_point,true);
		$criteria->compare('life_style',$this->life_style,true);
		$criteria->compare('service',$this->service,true);
		$criteria->compare('product_match',$this->product_match,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
