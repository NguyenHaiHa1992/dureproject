<?php

/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $country
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property integer $status
 * @property string $created_time
 */
class Client extends CActiveRecord
{
	public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, contact_name, company_name', 'required'),
			array('status, state_id', 'numerical', 'integerOnly'=>true),
			array('name, contact_name,company_name', 'length', 'max'=>50),
			array('address1, address2', 'length', 'max'=>1024),
			array('email, country, phone, fax', 'length', 'max'=>50),
			array('zipcode, city', 'length', 'max'=>255),

			array('created_time', 'length', 'max'=>11),
			array('tmp_file_ids','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address1, address2, country, city, zipcode, company_name, contact_name, email, phone, fax, status, created_time', 'safe', 'on'=>'search'),
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
			'state'=>array(self::BELONGS_TO,'State','state_id'),
			'categories' => array(self::MANY_MANY, 'ClientCategory', 'tbl_client_clientcategory(client_id, category_id)'),
			'files' => array(self::MANY_MANY, 'File', 'tbl_client_file(client_id, file_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address' => 'Address',
			'contact_name' => 'Contact name',
			'company_name' => 'Company name',
			'country' => 'Country',
			'email' => 'Email',
			'phone' => 'Phone',
			'fax' => 'Fax',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
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
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

		return parent::afterFind();
	}

	protected function afterSave()
	{
		$new_list_file_ids=explode(',',$this->tmp_file_ids);
		foreach ($new_list_file_ids as $file_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('client_id',$this->id);
			$criteria->compare('file_id',$file_id);
			$document_file=ClientFile::model()->find($criteria);
			if(!isset($document_file)){
				$document_file=new ClientFile();
				$document_file->client_id=$this->id;
				$document_file->file_id=$file_id;
				$document_file->save();
			}
			
		}		
		$list_current_file_ids=$this->list_current_file_ids;
		foreach ($list_current_file_ids as $file_id) {
			if(!in_array($file_id,$new_list_file_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('client_id',$this->id);
				$criteria->compare('file_id',$file_id);
				ClientFile::model()->deleteAll($criteria);
			}
		}

	    parent::afterSave();
	}

	protected function afterDelete()
    {
    	parent::afterDelete();

		$criteria=new CDbCriteria();
		$criteria->addCondition('client_id ='.$this->id);
		ClientFile::model()->deleteAll($criteria);
	}

	public function getList_current_file_ids(){
		$list=$this->files;
		$result=array();
		foreach ($list as $file) {
			$result[]=$file->id;
		}
		return $result;
	}
}
