<?php

/**
 * This is the model class for table "{{file}}".
 *
 * The followings are the available columns in table '{{file}}':
 * @property integer $id
 * @property string $filename
 * @property string $extension
 * @property string $dirname
 * @property integer $created_by
 * @property integer $created_time
 * @property string $history
 */
class File extends CActiveRecord {

    static public $allowedExtensions = array("mp4", "wmv", "dat", "avi", "flv", "jpg", "jpeg", "gif", "png", "bmp", "pdf", "doc", "docx", "xls", "xlsx");
    static public $sizeLimit = 10485760; //10*1024*1024

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return File the static model class
     */

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{file}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('filename, extension, dirname, filesize', 'required'),
            array('cat_id, restricted', 'numerical', 'integerOnly' => true),
            array('extension', 'validatorExtension'),
            array('filename, dirname', 'length', 'max' => 256),
            array('extension', 'length', 'max' => 32),
        );
    }

    /**
     *
     * Function validator file
     */
    public function validatorExtension($attributes, $params) {
        if (!in_array(strtolower($this->extension), self::$allowedExtensions))
            $this->addError('extension', 'File invalid');
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'created_by'),
            'category' => array(self::BELONGS_TO, 'FileCategory', 'cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'filename' => 'Basename',
            'extension' => 'Extension',
            'dirname' => 'Dirname',
            'created_by' => 'Created By',
            'created_time' => 'Created Time',
            'name' => 'Name',
            'description' => 'Description',
            'filesize' => 'File Size',
            'width' => 'Width', //Only image
            'height' => 'Height', //Only image
        );
    }

    /**
     * This event is raised after the record is instantiated by a find method.
     * @param CEvent $event the event parameter
     */
    protected function afterFind() {
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
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_time = time();
                $this->created_by = Yii::app()->user->id;
            }
            return true;
        }
    }

    protected function afterSave() {
        parent::afterSave();
    }

    protected function afterDelete() {
        parent::afterDelete();

        // Delete file-part
        $criteria = new CDbCriteria();
        $criteria->compare('file_id', $this->id);
        PartFile::model()->deleteAll($criteria);
        // Delete related: store, signage, fixture
        StoreFile::model()->deleteAll($criteria);
        SignageFile::model()->deleteAll($criteria);
        FixtureFile::model()->deleteAll($criteria);
    }

    public function convertArray() {
        return array(
            'id' => $this->id,
            'type' => $this->type,
            'filename' => $this->filename,
            'extension' => $this->extension,
            'dirname' => $this->dirname,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'filesize' => $this->filesize,
            'width' => $this->width,
            'height' => $this->height,
            'name' => $this->name,
            'description' => $this->description,
            'history' => $this->history,
            'message' => $this->getErrors(),
            'cat_id' => $this->cat_id,
            'cat_name' => $this->category->name,
            'restricted' => $this->restricted,
        );
    }

    public function getUrl($absolute = false){
        return Yii::app()->getBaseUrl($absolute).'/'.$this->dirname.'/'.$this->filename.'.'.$this->extension;
    }
    
    public function getPath($absolute = false){
        $base_path = '';
        if($absolute){
            $base_path = Yii::getPathOfAlias('webroot');
        }
        return $base_path.'/'.$this->dirname.'/'.$this->filename.'.'.$this->extension;
    }
    
    /******* Phan xu ly image *******/
    /**
     * Get width of this origin image
     */
    public function getWidth() {
        if (file_exists($this->getPath(true))) {
            $size = getimagesize($this->getPath(true));
            return $size[0];
        }
    }

    /**
     * Get height of this origin image
     */
    public function getHeight() {
        if (file_exists($this->getPath(true))) {
            $size = getimagesize($this->getPath(true));
            return $size[1];
        }
    }

    /**
     * Create thumb
     */
    public static function createThumb($original_path, $dirname, $width, $height, $maintain_ratio = true) {
        $original_absolute_path = Yii::getPathOfAlias('webroot') . '/' . $original_path;
        $absolute_dirname = Yii::getPathOfAlias('webroot') . '/' . $dirname;
        if (!file_exists($original_absolute_path))
            return null;
        if (!is_dir($absolute_dirname))
            return null;
        $info = pathinfo($original_absolute_path);
        $thumb_path = $absolute_dirname . '/' . $info['basename'];
        $size = getimagesize($original_absolute_path);
        $original_width = $size[0];
        $original_height = $size[1];
        if ($maintain_ratio) {
            $ratio = max(1, max(($original_height / $height), ($original_width / $width)));
            $w = $original_width / $ratio;
            $h = $original_height / $ratio;
        } else {
            $w = min($width, $original_width);
            $h = min($height, $original_height);
        }

        $thumb = new ResizeImage($original_absolute_path);
        $thumb->resize_image($w, $h);
        $thumb->save($thumb_path);
        
//        $image = new ResizeImage();
//        $image->load($original_absolute_path);
//        $image->resize($w, $h);
//        $image->save($thumb_path);
        return $dirname . '/' . $info['basename'];
    }

    /**
     * Get absolute thumb path
     */
    public function getThumbPath($width, $height, $maintain_ratio = true, $relative = true) {
        $result = '';

        $original_path = $this->getPath();
        $original_absolute_path = Yii::getPathOfAlias('webroot') . '/' . $original_path;
        $info = pathinfo($original_absolute_path);
        if ($maintain_ratio)
            $dirname = File::createDir('data/thumb', $this->created_time) . '/' . $this->id . 'x' . $width . 'x' . $height . 'x1';
        else
            $dirname = File::createDir('data/thumb', $this->created_time) . '/' . $this->id . 'x' . $width . 'x' . $height . 'x0';
        $absolute_dirname = Yii::getPathOfAlias('webroot') . '/' . $dirname;
        $thumb_path = $dirname . '/' . $info['basename'];
        $absolute_thumb_path = Yii::getPathOfAlias('webroot') . '/' . $thumb_path;

        if (file_exists($absolute_thumb_path))
            $result = $thumb_path;
        else {
            if (!is_dir($absolute_dirname))
                mkdir($absolute_dirname);
            $result = self::createThumb($original_path, $dirname, $width, $height, $maintain_ratio);
        }
        
        if($relative){
            return $result;
        }
        else{
            return Yii::getPathOfAlias('webroot') . '/' . $result;
        }
    }

    /**
     * Get thumb url
     */
    public function getThumbUrl($width, $height, $maintain_ratio = true, $relative = true) {
        if($this->extension != "jpg" && $this->extension != "jpeg" && $this->extension != "png"){
            return "";
        }
        if($relative){
            return $this->getThumbPath($width, $height, $maintain_ratio);
        }
        else{
            return Yii::app()->getBaseUrl(true) . '/' . $this->getThumbPath($width, $height, $maintain_ratio);
        }
    }

    /**
     * Create directory
     */
    static function createDir($dirname, $time = null) {
        $dir = $dirname;
        if ($time == null)
            $time = time();
        $dir .= '/' . date('Y', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        $dir .= '/' . date('m', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        $dir .= '/' . date('d', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        return $dir;
    }
}
