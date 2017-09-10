<?php

/**
 * This is the model class for table "{{product_development}}".
 *
 * The followings are the available columns in table '{{product_development}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $spec_for_product
 * @property integer $customer_submit_product
 * @property integer $customer_provide_control
 * @property string $physical_spec_product
 * @property string $allergent_product
 * @property integer $customer_require_spec
 * @property integer $spec_handing_instruction
 * @property integer $spec_ingredients_require
 * @property string $approve_customer_formula_code
 * @property integer $risk_or_hazard_ingredient
 * @property integer $additional_test_require
 * @property string $note
 * @property integer $document_id
 * @property string $created_time
 * @property string $created_by
 * @property string $customer_require_spec_other
 * @property string $spec_handing_instruction_other
 * @property string $spec_ingredients_require_other
 * @property string $risk_or_hazard_ingredient_other
 * @property string $additional_test_require_other
 */
class ProductDevelopment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_development}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, spec_for_product, customer_submit_product, customer_provide_control, customer_require_spec, spec_handing_instruction, spec_ingredients_require, risk_or_hazard_ingredient, additional_test_require, document_id', 'numerical', 'integerOnly'=>true),
			array('physical_spec_product, allergent_product, approve_customer_formula_code, created_by, customer_require_spec_other, spec_handing_instruction_other, spec_ingredients_require_other, risk_or_hazard_ingredient_other, additional_test_require_other', 'length', 'max'=>255),
			array('note, created_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, spec_for_product, customer_submit_product, customer_provide_control, physical_spec_product, allergent_product, customer_require_spec, spec_handing_instruction, spec_ingredients_require, approve_customer_formula_code, risk_or_hazard_ingredient, additional_test_require, note, document_id, created_time, created_by, customer_require_spec_other, spec_handing_instruction_other, spec_ingredients_require_other, risk_or_hazard_ingredient_other, additional_test_require_other', 'safe', 'on'=>'search'),
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
			'spec_for_product' => 'Spec For Product',
			'customer_submit_product' => 'Customer Submit Product',
			'customer_provide_control' => 'Customer Provide Control',
			'physical_spec_product' => 'Physical Spec Product',
			'allergent_product' => 'Allergent Product',
			'customer_require_spec' => 'Customer Require Spec',
			'spec_handing_instruction' => 'Spec Handing Instruction',
			'spec_ingredients_require' => 'Spec Ingredients Require',
			'approve_customer_formula_code' => 'Approve Customer Formula Code',
			'risk_or_hazard_ingredient' => 'Risk Or Hazard Ingredient',
			'additional_test_require' => 'Additional Test Require',
			'note' => 'Note',
			'document_id' => 'Document',
			'created_time' => 'Created Time',
			'created_by' => 'Created By',
			'customer_require_spec_other' => 'Customer Require Spec Other',
			'spec_handing_instruction_other' => 'Spec Handing Instruction Other',
			'spec_ingredients_require_other' => 'Spec Ingredients Require Other',
			'risk_or_hazard_ingredient_other' => 'Risk Or Hazard Ingredient Other',
			'additional_test_require_other' => 'Additional Test Require Other',
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
		$criteria->compare('spec_for_product',$this->spec_for_product);
		$criteria->compare('customer_submit_product',$this->customer_submit_product);
		$criteria->compare('customer_provide_control',$this->customer_provide_control);
		$criteria->compare('physical_spec_product',$this->physical_spec_product,true);
		$criteria->compare('allergent_product',$this->allergent_product,true);
		$criteria->compare('customer_require_spec',$this->customer_require_spec);
		$criteria->compare('spec_handing_instruction',$this->spec_handing_instruction);
		$criteria->compare('spec_ingredients_require',$this->spec_ingredients_require);
		$criteria->compare('approve_customer_formula_code',$this->approve_customer_formula_code,true);
		$criteria->compare('risk_or_hazard_ingredient',$this->risk_or_hazard_ingredient);
		$criteria->compare('additional_test_require',$this->additional_test_require);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('customer_require_spec_other',$this->customer_require_spec_other,true);
		$criteria->compare('spec_handing_instruction_other',$this->spec_handing_instruction_other,true);
		$criteria->compare('spec_ingredients_require_other',$this->spec_ingredients_require_other,true);
		$criteria->compare('risk_or_hazard_ingredient_other',$this->risk_or_hazard_ingredient_other,true);
		$criteria->compare('additional_test_require_other',$this->additional_test_require_other,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductDevelopment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
