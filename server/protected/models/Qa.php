<?php

/**
 * This is the model class for table "{{qa}}".
 *
 * The followings are the available columns in table '{{qa}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $spec_micro_test
 * @property integer $spec_sample
 * @property integer $customer_require_coa
 * @property integer $customer_spec_sensor
 * @property integer $customer_require_preship
 * @property string $physical_spec_product
 * @property integer $product_spec_sheet
 * @property integer $allergen_status
 * @property integer $customer_provide_confirm
 * @property integer $customer_supply_letter
 * @property string $package_net_weight
 * @property integer $customer_spec_net_weight
 * @property integer $customer_provide_label
 * @property integer $is_upc_scc_code
 * @property integer $customer_provide_label_primary_pack
 * @property integer $customer_provide_label_inner_pack
 * @property integer $customer_provide_label_shipper
 * @property integer $product_have_spec_claim
 * @property integer $spec_hand_instruc
 * @property integer $customer_request_spec_ship
 * @property integer $product_have_npn
 * @property integer $product_nsf_for_sport
 * @property string $note
 * @property integer $document_id
 * @property integer $status
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by
 * @property integer $appr_coa_submit
 * @property string $spec_micro_test_other
 * @property string $spec_sample_other
 * @property string $customer_require_coa_other
 * @property string $customer_spec_sensor_other
 * @property string $allergen_status_other
 * @property string $customer_spec_net_weight_other
 * @property string $customer_provide_label_other
 * @property string $is_upc_scc_code_other
 * @property string $customer_provide_label_primary_pack_other
 * @property string $customer_provide_label_inner_pack_other
 * @property string $customer_provide_label_shipper_other
 * @property string $product_have_spec_claim_other
 * @property string $spec_hand_instruc_other
 * @property string $customer_request_spec_ship_other
 * @property string $product_have_npn_other
 */
class Qa extends CActiveRecord
{
    public $tmp_file_ids;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{qa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, spec_micro_test, spec_sample, customer_require_coa, customer_spec_sensor, customer_require_preship, product_spec_sheet, allergen_status, customer_provide_confirm, customer_supply_letter, customer_spec_net_weight, customer_provide_label, is_upc_scc_code, customer_provide_label_primary_pack, customer_provide_label_inner_pack, customer_provide_label_shipper, product_have_spec_claim, spec_hand_instruc, customer_request_spec_ship, product_have_npn, product_nsf_for_sport, document_id, status, created_time, updated_time, created_by, appr_coa_submit', 'numerical', 'integerOnly'=>true),
			array('physical_spec_product, spec_micro_test_other, spec_sample_other, customer_require_coa_other, customer_spec_sensor_other, allergen_status_other, customer_spec_net_weight_other, customer_provide_label_other, is_upc_scc_code_other, customer_provide_label_primary_pack_other, customer_provide_label_inner_pack_other, customer_provide_label_shipper_other, product_have_spec_claim_other, spec_hand_instruc_other, customer_request_spec_ship_other, product_have_npn_other', 'length', 'max'=>255),
			array('package_net_weight', 'length', 'max'=>50),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, spec_micro_test, spec_sample, customer_require_coa, customer_spec_sensor, customer_require_preship, physical_spec_product, product_spec_sheet, allergen_status, customer_provide_confirm, customer_supply_letter, package_net_weight, customer_spec_net_weight, customer_provide_label, is_upc_scc_code, customer_provide_label_primary_pack, customer_provide_label_inner_pack, customer_provide_label_shipper, product_have_spec_claim, spec_hand_instruc, customer_request_spec_ship, product_have_npn, product_nsf_for_sport, note, document_id, status, created_time, updated_time, created_by, appr_coa_submit, spec_micro_test_other, spec_sample_other, customer_require_coa_other, customer_spec_sensor_other, allergen_status_other, customer_spec_net_weight_other, customer_provide_label_other, is_upc_scc_code_other, customer_provide_label_primary_pack_other, customer_provide_label_inner_pack_other, customer_provide_label_shipper_other, product_have_spec_claim_other, spec_hand_instruc_other, customer_request_spec_ship_other, product_have_npn_other', 'safe', 'on'=>'search'),
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
			'spec_micro_test' => 'Spec Micro Test',
			'spec_sample' => 'Spec Sample',
			'customer_require_coa' => 'Customer Require Coa',
			'customer_spec_sensor' => 'Customer Spec Sensor',
			'customer_require_preship' => 'Customer Require Preship',
			'physical_spec_product' => 'Physical Spec Product',
			'product_spec_sheet' => 'Product Spec Sheet',
			'allergen_status' => 'Allergen Status',
			'customer_provide_confirm' => 'Customer Provide Confirm',
			'customer_supply_letter' => 'Customer Supply Letter',
			'package_net_weight' => 'Package Net Weight',
			'customer_spec_net_weight' => 'Customer Spec Net Weight',
			'customer_provide_label' => 'Customer Provide Label',
			'is_upc_scc_code' => 'Is Upc Scc Code',
			'customer_provide_label_primary_pack' => 'Customer Provide Label Primary Pack',
			'customer_provide_label_inner_pack' => 'Customer Provide Label Inner Pack',
			'customer_provide_label_shipper' => 'Customer Provide Label Shipper',
			'product_have_spec_claim' => 'Product Have Spec Claim',
			'spec_hand_instruc' => 'Spec Hand Instruc',
			'customer_request_spec_ship' => 'Customer Request Spec Ship',
			'product_have_npn' => 'Product Have Npn',
			'product_nsf_for_sport' => 'Product Nsf For Sport',
			'note' => 'Note',
			'document_id' => 'Document',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'created_by' => 'Created By',
			'appr_coa_submit' => 'Appr Coa Submit',
			'spec_micro_test_other' => 'Spec Micro Test Other',
			'spec_sample_other' => 'Spec Sample Other',
			'customer_require_coa_other' => 'Customer Require Coa Other',
			'customer_spec_sensor_other' => 'Customer Spec Sensor Other',
			'allergen_status_other' => 'Allergen Status Other',
			'customer_spec_net_weight_other' => 'Customer Spec Net Weight Other',
			'customer_provide_label_other' => 'Customer Provide Label Other',
			'is_upc_scc_code_other' => 'Is Upc Scc Code Other',
			'customer_provide_label_primary_pack_other' => 'Customer Provide Label Primary Pack Other',
			'customer_provide_label_inner_pack_other' => 'Customer Provide Label Inner Pack Other',
			'customer_provide_label_shipper_other' => 'Customer Provide Label Shipper Other',
			'product_have_spec_claim_other' => 'Product Have Spec Claim Other',
			'spec_hand_instruc_other' => 'Spec Hand Instruc Other',
			'customer_request_spec_ship_other' => 'Customer Request Spec Ship Other',
			'product_have_npn_other' => 'Product Have Npn Other',
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
		$criteria->compare('spec_micro_test',$this->spec_micro_test);
		$criteria->compare('spec_sample',$this->spec_sample);
		$criteria->compare('customer_require_coa',$this->customer_require_coa);
		$criteria->compare('customer_spec_sensor',$this->customer_spec_sensor);
		$criteria->compare('customer_require_preship',$this->customer_require_preship);
		$criteria->compare('physical_spec_product',$this->physical_spec_product,true);
		$criteria->compare('product_spec_sheet',$this->product_spec_sheet);
		$criteria->compare('allergen_status',$this->allergen_status);
		$criteria->compare('customer_provide_confirm',$this->customer_provide_confirm);
		$criteria->compare('customer_supply_letter',$this->customer_supply_letter);
		$criteria->compare('package_net_weight',$this->package_net_weight,true);
		$criteria->compare('customer_spec_net_weight',$this->customer_spec_net_weight);
		$criteria->compare('customer_provide_label',$this->customer_provide_label);
		$criteria->compare('is_upc_scc_code',$this->is_upc_scc_code);
		$criteria->compare('customer_provide_label_primary_pack',$this->customer_provide_label_primary_pack);
		$criteria->compare('customer_provide_label_inner_pack',$this->customer_provide_label_inner_pack);
		$criteria->compare('customer_provide_label_shipper',$this->customer_provide_label_shipper);
		$criteria->compare('product_have_spec_claim',$this->product_have_spec_claim);
		$criteria->compare('spec_hand_instruc',$this->spec_hand_instruc);
		$criteria->compare('customer_request_spec_ship',$this->customer_request_spec_ship);
		$criteria->compare('product_have_npn',$this->product_have_npn);
		$criteria->compare('product_nsf_for_sport',$this->product_nsf_for_sport);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('appr_coa_submit',$this->appr_coa_submit);
		$criteria->compare('spec_micro_test_other',$this->spec_micro_test_other,true);
		$criteria->compare('spec_sample_other',$this->spec_sample_other,true);
		$criteria->compare('customer_require_coa_other',$this->customer_require_coa_other,true);
		$criteria->compare('customer_spec_sensor_other',$this->customer_spec_sensor_other,true);
		$criteria->compare('allergen_status_other',$this->allergen_status_other,true);
		$criteria->compare('customer_spec_net_weight_other',$this->customer_spec_net_weight_other,true);
		$criteria->compare('customer_provide_label_other',$this->customer_provide_label_other,true);
		$criteria->compare('is_upc_scc_code_other',$this->is_upc_scc_code_other,true);
		$criteria->compare('customer_provide_label_primary_pack_other',$this->customer_provide_label_primary_pack_other,true);
		$criteria->compare('customer_provide_label_inner_pack_other',$this->customer_provide_label_inner_pack_other,true);
		$criteria->compare('customer_provide_label_shipper_other',$this->customer_provide_label_shipper_other,true);
		$criteria->compare('product_have_spec_claim_other',$this->product_have_spec_claim_other,true);
		$criteria->compare('spec_hand_instruc_other',$this->spec_hand_instruc_other,true);
		$criteria->compare('customer_request_spec_ship_other',$this->customer_request_spec_ship_other,true);
		$criteria->compare('product_have_npn_other',$this->product_have_npn_other,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Qa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
