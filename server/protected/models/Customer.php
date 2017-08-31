<?php

/**
 * This is the model class for table "{{customer}}".
 *
 * The followings are the available columns in table '{{customer}}':
 * @property string $id
 * @property string $ship_to
 * @property string $ship_oa
 * @property string $ship_address
 * @property string $bill_to
 * @property string $bill_oa
 * @property string $bill_address
 * @property string $phone
 * @property string $fax
 * @property integer $document_id
 * @property string $note
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $in_trash
 */
class Customer extends CActiveRecord
{
    const STATUS_DEFAULT = 0;
    const STATUS_LIVE = 1;
    const STATUS_ARCHIVED = 2;
    const STATUS_DEPRECATED = 3;
    const STATUS_YES = 1;
    const STATUS_NO = 0;
    const LANGUAGE_ENGLISH = "en";
    const LANGUAGE_FRENCH = "fr";
    
    public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('ship_to, ship_address, bill_to, bill_address, phone', 'required'),
                array('document_id, status, created_time, updated_time', 'numerical', 'integerOnly'=>true),
                array('ship_oa, bill_oa, fax', 'length', 'max'=>255),
                array('phone', 'length', 'max'=>50),
                array('tmp_file_ids, ship_to, ship_address, bill_to, bill_address, note', 'safe'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('id, ship_to, ship_oa, ship_address, bill_to, bill_oa, bill_address, phone, fax, document_id, note, status, created_time, updated_time', 'safe', 'on'=>'search'),
            );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'files' => array(self::MANY_MANY, 'File', 'tbl_customer_file(customer_id, file_id)'),
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ship_to' => 'Ship To',
			'ship_oa' => 'Ship Oa',
			'ship_address' => 'Ship Address',
			'bill_to' => 'Bill To',
			'bill_oa' => 'Bill Oa',
			'bill_address' => 'Bill Address',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'document_id' => 'Document',
			'note' => 'Note',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'in_trash' => 'In Trash',
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
		$criteria->compare('ship_to',$this->ship_to,true);
		$criteria->compare('ship_oa',$this->ship_oa,true);
		$criteria->compare('ship_address',$this->ship_address,true);
		$criteria->compare('bill_to',$this->bill_to,true);
		$criteria->compare('bill_oa',$this->bill_oa,true);
		$criteria->compare('bill_address',$this->bill_address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('in_trash',$this->in_trash);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
    
    protected function afterSave() {
        $new_list_file_ids = explode(',', $this->tmp_file_ids);
        foreach ($new_list_file_ids as $file_id) {
            $criteria = new CDbCriteria();
            $criteria->compare('customer_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = CustomerFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new CustomerFile();
                $document_file->customer_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('customer_id', $this->id);
                $criteria->compare('file_id', $file_id);
                CustomerFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }
    
    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('customer_id =' . $this->id);
        CustomerFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
    }
    
    public function getStatusLabel(){
        $labels = [
            self::STATUS_DEFAULT => '',
            self::STATUS_LIVE => 'live',
            self::STATUS_ARCHIVED => 'archived',
            self::STATUS_DEPRECATED => 'deprecated',
        ];
        
        return $labels[$this->status];
    }
    
    public function getLanguageLabel(){
        $labels = [
            self::LANGUAGE_ENGLISH => 'English',
            self::LANGUAGE_FRENCH => 'French',
        ];
        return $labels[$this->language];
    }
    
    public function getLanguages(){
        return [
            (object)['id' => self::LANGUAGE_ENGLISH, 'name' => 'English'],
            (object)['id' => self::LANGUAGE_FRENCH, 'name' => 'French']
        ];
    }

    /**
    *   @description getALl Customer 
    *   @return array('id' => 'name')
    *   @author tunglexuan <tunghus1993@gmail.com>
    */
    public static function getAll(){
        $criteria = new CDbCriteria();
        $criteria->select = array('id', 'ship_address');
        $criteria->compare('status', 1);
        $criteria->compare('in_trash',0);
        $customers = Customer::model()->findAll($criteria);
        $return = array();
        foreach($customers as $customer){
            $return[] = (object)array(
                'id' => $customer['id'],
                'name' => $customer['ship_address'],
            );
        }
        return $return;
    }
}
