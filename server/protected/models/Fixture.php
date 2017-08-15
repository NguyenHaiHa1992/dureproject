<?php

/**
 * This is the model class for table "{{fixture}}".
 *
 * The followings are the available columns in table '{{fixture}}':
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
 * @property string $location
 * @property string $in_trash
 * @property string $vendor
 */
class Fixture extends CActiveRecord {

    public $tmp_file_ids;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{fixture}}';
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
            array('status, image_id, category_id, price', 'numerical', 'integerOnly' => true),
            array('description, location, vendor', 'length', 'max' => 255),
            array('group_number', 'length', 'max' => 20),
            array('size', 'length', 'max' => 100),
            array('tmp_file_ids, description, group_number, note, size, location, vendor', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('code, category_id, description, size, location, in_trash, vendor', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'FixtureCategory', 'category_id'),
            'image' => array(self::BELONGS_TO, 'File', 'image_id'),
            'files' => array(self::MANY_MANY, 'File', 'tbl_fixture_file(fixture_id, file_id)'),
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
     * @return Fixture the static model class
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
            $criteria->compare('fixture_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = FixtureFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new FixtureFile();
                $document_file->fixture_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('fixture_id', $this->id);
                $criteria->compare('file_id', $file_id);
                FixtureFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }

    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('fixture_id =' . $this->id);
        FixtureFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
    }

    public function getListRelatedFixture(){
        // Find list related fixtures
        $group_number = $this->group_number;

        $list_related_fixture = [];
        if($group_number != ''){
          $list_related_fixture = Yii::app()->db->createCommand()
              ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description')
              ->from('tbl_fixture g')
              ->join('tbl_fixture_category c', 'c.id = g.category_id')
              ->where('group_number=:group_number AND g.id <> :id', array(':group_number' => $group_number, ':id' => $this->id))
              ->queryAll();
        }

        return $list_related_fixture;
    }

    public function getListRelatedSignage(){
      // Find list related fixtures
      $group_number = $this->group_number;

      $list_related_signage = [];
      if($group_number != ''){
        $list_related_signage = Yii::app()->db->createCommand()
            ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description')
            ->from('tbl_signage g')
            ->leftJoin('tbl_signage_category c', 'c.id = g.category_id')
            ->where('group_number=:group_number', array(':group_number' => $group_number))
            ->andWhere('g.in_trash = 0')
            ->queryAll();
      }
        foreach ($list_related_signage as $k => $signage) {
            $list_related_signage[$k]['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
            $list_related_signage[$k]['example_image_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
            $fileImgId = isset($signage['image_id']) && $signage['image_id'] 
                    ? File::model()->findByPk($signage['image_id'])
                    : null;
            if($fileImgId && $fileImgId->getThumbUrl(80, 80, false) ){
                $list_related_signage[$k]['image_id_url'] = $fileImgId->getThumbUrl(80, 80, false);
            }
            $fileExampleImg = isset($signage['example_image']) && $signage['example_image'] 
                    ? File::model()->findByPk($signage['example_image'])
                    : null;
            if($fileExampleImg && $fileExampleImg->getThumbUrl(80, 80, false) ){
                $list_related_signage[$k]['example_image_url'] = $fileExampleImg->getThumbUrl(80, 80, false);
            }
        }

      return $list_related_signage;
    }
    
    public function getListRelatedStore() {
        // Find list related stores
        $list_related_store = Yii::app()->db->createCommand()
                ->select('s.*, t.name tier_name, sf.id store_fixture_id, sf.note store_fixture_note, tbl_state.state_short state_name')
                ->from('tbl_store s')
                ->join('tbl_store_fixture sf', 's.id = sf.store_id')
                ->leftJoin('tbl_tier t', 't.id = s.tier_id')
                ->leftJoin('tbl_state', 's.state_id = tbl_state.id')
                ->where('sf.fixture_id=:fixture_id', array(':fixture_id' => $this->id))
                ->andWhere('s.in_trash = 0')
                ->queryAll();
        foreach($list_related_store as $k => $store){
            $list_related_store[$k]['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
            if(!isset($store['image_id']) || !$store['image_id']){
                continue;
            }
            $file = File::model()->findByPk($store['image_id']);
            if($file && $file->getThumbUrl(80, 80, false) ){
                $list_related_store[$k]['image_id_url'] = "server/".$file->getThumbUrl(80, 80, false);
            }
        }
        return $list_related_store;
    }
    
    public static function getAttrsFromImport($worksheet = null, $row = 1){
        if(!$worksheet && !is_numeric($row)){
            return [];
        }
        $result = [];
        $result['code'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $categoryName = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $category = FixtureCategory::model()->findByAttributes(['name' => $categoryName]);
        $result['category_id'] = $category ? $category->id : 0;
        $result['description'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $result['size'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $result['location'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $result['vendor'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        return $result;
    }
}
