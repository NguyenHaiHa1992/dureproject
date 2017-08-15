<?php

/**
 * This is the model class for table "{{signage}}".
 *
 * The followings are the available columns in table '{{signage}}':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $country
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property integer $status
 * @property string $created_time
 * @property string $size
 * @property string $material
 * @property string $mounting
 * @property string $in_trash
 * @property string $vendor
 * @property string $changes_seasonally
 * @property string $power_required
 * @property string $example_image
 * @property string $language
 */
class Signage extends CActiveRecord {
    const STATUS_DEFAULT = 0;
    const STATUS_LIVE = 1;
    const STATUS_ARCHIVED = 2;
    const STATUS_DEPRECATED = 3;
    const MOUNTING_SELF = 1;
    const MOUNTING_FIXTURE = 2;
    const STATUS_YES = 1;
    const STATUS_NO = 0;
    const LANGUAGE_ENGLISH = "en";
    const LANGUAGE_FRENCH = "fr";
    
    public $tmp_file_ids;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{signage}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code', 'unique'),
            array('code, description, category_id', 'required'),
            array('status, image_id, category_id, price, in_trash, mounting', 'numerical', 'integerOnly' => true),
            array('description, location, vendor', 'length', 'max' => 255),
            array('group_number', 'length', 'max' => 20),
            array('size, material', 'length', 'max' => 100),
            array('tmp_file_ids, description, group_number, note, size, material, mounting, vendor, '
                . 'changes_seasonally, power_required, example_image, language', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('code, category_id, description, size, material, mounting, in_trash, vendor', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'created_by'),
            'category' => array(self::BELONGS_TO, 'SignageCategory', 'category_id'),
            'image' => array(self::BELONGS_TO, 'File', 'image_id'),
            'exampleImage' => array(self::BELONGS_TO, 'File', 'example_image'),
            'files' => array(self::MANY_MANY, 'File', 'tbl_signage_file(signage_id, file_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Signage the static model class
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
            $criteria->compare('signage_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = SignageFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new SignageFile();
                $document_file->signage_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('signage_id', $this->id);
                $criteria->compare('file_id', $file_id);
                SignageFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }

    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('signage_id =' . $this->id);
        SignageFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
    }

    public function getListRelatedSignage(){
        // Find list related signages
        $group_number = $this->group_number;

        $list_related_signage = [];
        if($group_number != ''){
          $list_related_signage = Yii::app()->db->createCommand()
              ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description')
              ->from('tbl_signage g')
              ->leftJoin('tbl_signage_category c', 'c.id = g.category_id')
              ->where('group_number=:group_number AND g.id <> :id', array(':group_number' => $group_number, ':id' => $this->id))
              ->queryAll();
        }

        return $list_related_signage;
    }

    public function getListRelatedFixture(){
        // Find list related fixtures
        $group_number = $this->group_number;

        $list_related_fixture = [];
        if($group_number != ''){
          $list_related_fixture = Yii::app()->db->createCommand()
              ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description')
              ->from('tbl_fixture g')
              ->leftJoin('tbl_fixture_category c', 'c.id = g.category_id')
              ->where('group_number=:group_number', array(':group_number' => $group_number))
              ->andWhere('g.in_trash = 0')
              ->queryAll();
        }
        foreach ($list_related_fixture as $k => $fixture) {
            $list_related_fixture[$k]['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
            $list_related_fixture[$k]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
            if(!isset($fixture['image_id']) || !$fixture['image_id']){
                continue;
            }
            $file = File::model()->findByPk($fixture['image_id']);
            if($file && $file->getThumbUrl(80, 80, false) ){
                $list_related_fixture[$k]['image_id_url'] = $file->getThumbUrl(80, 80, false);
                $list_related_fixture[$k]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.$file->getThumbUrl(80, 80, false);
            }
        }
        return $list_related_fixture;
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
    
    public function getMountingLabel(){
        $labels = [
            self::MOUNTING_SELF => 'Self',
            self::MOUNTING_FIXTURE => 'Fixture',
        ];
        return $labels[$this->mounting];
    }
    
    public function getListRelatedStore() {
        // Find list related stores

        $list_related_store = Yii::app()->db->createCommand()
                ->select('s.*, t.name tier_name, ss.id store_signage_id, ss.note store_signage_note, tbl_state.state_short state_name')
                ->from('tbl_store s')
                ->join('tbl_store_signage ss', 's.id = ss.store_id')
                ->leftJoin('tbl_tier t', 't.id = s.tier_id')
                ->leftJoin('tbl_state', 's.state_id = tbl_state.id')
                ->where('ss.signage_id=:signage_id', array(':signage_id' => $this->id))
                ->andWhere('s.in_trash = 0')
                ->queryAll();
        foreach($list_related_store as $k => $store){
            $list_related_store[$k]['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
            $list_related_store[$k]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
            if(!isset($store['image_id']) || !$store['image_id']){
                continue;
            }
            $file = File::model()->findByPk($store['image_id']);
            if($file && $file->getThumbUrl(80, 80, false) ){
                $list_related_store[$k]['image_id_url'] = "server/".$file->getThumbUrl(80, 80, false);
                $list_related_store[$k]['image_id_src'] = CustomEnum::FILE_SERVER_PATH.$file->getThumbUrl(80, 80, false);
            }
        }
        return $list_related_store;
    }
    
    public function getChangesSeasonallyLabel(){
        $labels = [
            self::STATUS_YES => 'Yes',
            self::STATUS_NO => 'No',
        ];
        return $labels[$this->changes_seasonally];
    }
    
    public function getPowerRequiredLabel(){
        $labels = [
            self::STATUS_YES => 'Yes',
            self::STATUS_NO => 'No',
        ];
        return $labels[$this->power_required];
    }
    
    public static function getAttrsFromImport($worksheet = null, $row = 1){
        if(!$worksheet && !is_numeric($row)){
            return [];
        }
        $result = [];
        $result['code'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $categoryName = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $category = SignageCategory::model()->findByAttributes(['name' => $categoryName]);
        $result['category_id'] = $category ? $category->id : 0;
        $result['description'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $result['size'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $result['material'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $result['vendor'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        $mounting = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        if(strtolower($mounting) == 'self'){
            $result['mounting'] = self::MOUNTING_SELF;
        }
        else{
            $result['mounting'] = self::MOUNTING_FIXTURE;
        }
        $changes_seasonally = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
        if(strtolower($changes_seasonally) == 'yes'){
            $result['changes_seasonally'] = self::STATUS_YES;
        }
        else{
            $result['changes_seasonally'] = self::STATUS_NO;
        }
        $power_required = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
        if(strtolower($power_required) == 'yes'){
            $result['power_required'] = self::STATUS_YES;
        }
        else{
            $result['power_required'] = self::STATUS_NO;
        }
        return $result;
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
}
