<?php

/**
 * This is the model class for table "{{store_signage}}".
 *
 * The followings are the available columns in table '{{store_signage}}':
 * @property integer $id
 * @property integer $store_id
 * @property integer $image_id
 * @property integer $signage_quantity
 */
class StoreSignage extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StoreSignage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{store_signage}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('code', 'unique'),
            array('store_id, signage_id, signage_quantity', 'required'),
            array('store_id, signage_id, signage_quantity', 'numerical', 'integerOnly' => true),
            array('code, note', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, store_id, signage_id, note', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_id' => 'Store',
            'signage_id' => 'Signage',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('signage_id', $this->signage_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        if(parent::beforeSave())
        {
          if ($this->isNewRecord) {
              $this->status = 1;
              $this->created_time = time();
              $this->created_by = Yii::app()->user->id;
          }
          else{
              $this->updated_time = time();
          }

          return true;
        }
        return false;
    }
}
