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
 * @property string $other_service
 * @property string $other_type_product
 */
class Project extends CActiveRecord
{
        public $tmp_file_ids;
	const TYPE_LIFE_STYLE = 'life_style';
	const TYPE_ORIGINAL = 'original';
	const TYPE_OTHER = 'type_other';
	const SER_PRE_BLEND = 'ser_pre_blend';
	const SER_BLEND_ING = 'ser_blend_ing';
	const SER_BLEND_ING_PACK = 'ser_blend_ing_pack';

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
			array('primary_contact, project_number, life_style, service, other_service, other_type_product', 'length', 'max'=>50),
			array('volume, product_match, created_by', 'length', 'max'=>255),
			array('price_point', 'length', 'max'=>11),
			array('note, tmp_file_ids', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, primary_contact, customer_id, project_number, volume, price_point, life_style, service, product_match, note, document_id, created_time, created_by, updated_by, updated_time, status, other_service, other_type_product', 'safe', 'on'=>'search'),
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
                    'files' => array(self::MANY_MANY, 'File', 'tbl_project_file(project_id, file_id)'),
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
			'other_service' => 'Other Service',
			'other_type_product' => 'Other Type Product',
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
		$criteria->compare('other_service',$this->other_service,true);
		$criteria->compare('other_type_product',$this->other_type_product,true);

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
        
        public static function getTypeOfProduct(){
		return array(
				array(
					'id' => self::TYPE_LIFE_STYLE,
					'name' => 'Life Style',
				),
				array(
					'id' => self::TYPE_ORIGINAL,
					'name' => 'Original',
				),
				array(
					'id' => self::TYPE_OTHER,
					'name' => 'User Input',
				),
		);
	}

	public static function getLabelByType($type){
		$listTypeProduct = self::getTypeOfProduct();
		return isset($listTypeProduct[$type]) && $listTypeProduct[$type] ? $listTypeProduct[$type] : self::TYPE_OTHER;
	}

	public static function getProductMatch(){
		return array(
			array(
				'id' => self::SER_PRE_BLEND ,
				'name' => 'Pre-Blended Product/Co-packing',
			),
			array(
				'id' => self::SER_BLEND_ING ,
				'name' => 'Custom Blends with ingredients supplied to Dure',
			),
			array(
				'id' => self::SER_BLEND_ING_PACK ,
				'name' => 'Custom Blend with ingredients and packaging supplied by Dure',
			),
			array(
				'id' => self::TYPE_OTHER ,
				'name' => 'User Input',
			),
		);
	}
        
    protected function afterSave() {
        $new_list_file_ids = explode(',', $this->tmp_file_ids);
        foreach ($new_list_file_ids as $file_id) {
            $criteria = new CDbCriteria();
            $criteria->compare('project_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = ProjectFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new ProjectFile();
                $document_file->project_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('project_id', $this->id);
                $criteria->compare('file_id', $file_id);
                ProjectFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }
    
    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('project_id =' . $this->id);
        ProjectFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
    }
    
    protected function afterFind() {
        $list = $this->files;

        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        $this->tmp_file_ids = implode(',', $result);

        return parent::afterFind();
    }
}
