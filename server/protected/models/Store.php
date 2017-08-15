<?php

/**
 * This is the model class for table "{{store}}".
 *
 * The followings are the available columns in table '{{store}}':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $country
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property integer $status
 * @property integer $layout_id
 * @property string $created_time
 * @property string $in_trash
 * @property string $store_number
 * @property string $open_date
 * @property string $layout_file_id
 */
class Store extends CActiveRecord {

    public $tmp_file_ids;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{store}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, contact_name, franchisee_name, tier_id', 'required'),
            array('status, state_id, tier_id, image_id, layout_id, layout_file_id', 'numerical', 'integerOnly' => true),
            array('name, contact_name,franchisee_name', 'length', 'max' => 50),
            array('address1, address2', 'length', 'max' => 1024),
            array('email, country, phone, fax', 'length', 'max' => 50),
            array('zipcode, city', 'length', 'max' => 255),
            array('created_time, updated_time, created_by', 'length', 'max' => 11),
            array('tmp_file_ids, note, store_number, open_date, layout_file_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address1, address2, country, city, zipcode, franchisee_name, contact_name, email, phone, fax, status, created_time, in_trash, store_number, open_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tier' => array(self::BELONGS_TO, 'Tier', 'tier_id'),
            'state' => array(self::BELONGS_TO, 'State', 'state_id'),
            'files' => array(self::MANY_MANY, 'File', 'tbl_store_file(store_id, file_id)'),
            'image' => array(self::BELONGS_TO, 'File', 'image_id'),
            'layout' => array(self::BELONGS_TO, 'File', 'layout_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'contact_name' => 'Contact name',
            'franchisee_name' => 'Franchisee name',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('tier_id', $this->tier_id);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('franchisee_name', $this->franchisee_name, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('email', $this->email);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Store the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * This event is raised after the record is instantiated by a find method.
     * @param CEvent $event the event parameter
     */
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
            $criteria->compare('store_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = StoreFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new StoreFile();
                $document_file->store_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('store_id', $this->id);
                $criteria->compare('file_id', $file_id);
                StoreFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }

    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('store_id =' . $this->id);
        StoreFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
    }

    public function getListSignage(){
        $store_signages = Yii::app()->db->createCommand()
            ->select('sg.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, '
                    . 'g.code signage_code, SUBSTR(g.note, 1, 30) signage_note, '
                    . 'g.image_id signage_image_id, g.example_image signage_example_image, '
                    . 'g.material, g.size')
            ->from('tbl_store_signage sg')
            ->join('tbl_signage g', 'sg.signage_id = g.id')
            ->join('tbl_signage_category c', 'c.id = g.category_id')
            ->where('store_id = :store_id', array(':store_id' => $this->id))
            ->andWhere('g.in_trash = 0')
            ->queryAll();
        foreach ($store_signages as $ssKey => $ssValue) {
            $image = File::model()->findByPk($ssValue['signage_image_id']);
            if($image && $image->getThumbUrl(80, 80, false)){
                $store_signages[$ssKey]['signage_image_id'] = CustomEnum::FILE_SERVER_PATH.$image->getThumbUrl(80, 80, false);
            }
            else{
                $store_signages[$ssKey]['signage_image_id'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
            }
            $exampleImage = File::model()->findByPk($ssValue['signage_example_image']);
            if($exampleImage && $exampleImage->getThumbUrl(80, 80, false)){
                $store_signages[$ssKey]['signage_example_image'] = CustomEnum::FILE_SERVER_PATH.$exampleImage->getThumbUrl(80, 80, false);
            }
            else{
                $store_signages[$ssKey]['signage_example_image'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
            }
        }
        return $store_signages;
    }
    
    public function getListFixture(){
      $store_signages = Yii::app()->db->createCommand()
            ->select('sf.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, '
                    . 'g.image_id fixture_image_id')
            ->from('tbl_store_fixture sf')
            ->join('tbl_fixture g', 'sf.fixture_id = g.id')
            ->join('tbl_fixture_category c', 'c.id = g.category_id')
            ->where('store_id = :store_id', array(':store_id' => $this->id))
            ->andWhere('g.in_trash = 0')
            ->queryAll();
        foreach ($store_signages as $ssKey => $ssValue) {
            $image = File::model()->findByPk($ssValue['fixture_image_id']);
            if($image && $image->getThumbUrl(80, 80, false)){
                $store_signages[$ssKey]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.$image->getThumbUrl(80, 80, false);
            }
            else{
                $store_signages[$ssKey]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
            }
        }
        return $store_signages;
    }
    
    public static function getAttrsFromImport($worksheet = null, $row = 1){
        if(!$worksheet && !is_numeric($row)){
            return [];
        }
        $result = [];
        $result['name'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $result['store_number'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $tierName = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $tier = Tier::model()->findByAttributes(['name' => $tierName]);
        $result['tier_id'] = $tier ? $tier->id : 0;
        $result['contact_name'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $result['franchisee_name'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $result['address1'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        $result['country'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        $result['email'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
        $result['phone'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
        return $result;
    }
}
