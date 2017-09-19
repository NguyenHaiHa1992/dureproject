<?php

/**
 * This is the model class for table "{{product_approval}}".
 *
 * The followings are the available columns in table '{{product_approval}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $status
 * @property integer $president_date
 * @property integer $qa_supervisor_date
 * @property string $note
 * @property integer $document_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $in_trash
 */
class ProductApproval extends CActiveRecord
{
        public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_approval}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, status, president_date, qa_supervisor_date, document_id, created_time, updated_time, in_trash', 'numerical', 'integerOnly'=>true),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, status, president_date, qa_supervisor_date, note, document_id, created_time, updated_time, in_trash', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
			'president_date' => 'President Date',
			'qa_supervisor_date' => 'Qa Supervisor Date',
			'note' => 'Note',
			'document_id' => 'Document',
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
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('president_date',$this->president_date);
		$criteria->compare('qa_supervisor_date',$this->qa_supervisor_date);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
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
	 * @return ProductApproval the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
