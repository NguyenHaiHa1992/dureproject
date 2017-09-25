<?php

/**
 * This is the model class for table "{{sale}}".
 *
 * The followings are the available columns in table '{{sale}}':
 * @property string $id
 * @property integer $project_id
 * @property integer $product_sample_product
 * @property integer $product_infor_provide_product
 * @property integer $product_sample_submit_pack
 * @property integer $product_coa_submit
 * @property integer $product_spec_qa
 * @property integer $product_allergen_qa
 * @property integer $product_product_kosher
 * @property integer $product_product_spec_provide_qa
 * @property string $product_physical_spec
 * @property string $product_allergen_status
 * @property string $product_product_kosher_input
 * @property string $product_type_pack
 * @property double $product_net_weight
 * @property string $product_sample_provide_pack
 * @property string $product_sample_coa_submit
 * @property string $product_product_spec_claim
 * @property string $product_spec_hand_instruc
 * @property string $product_spec_ingredient
 * @property string $pack_type_pack
 * @property string $pack_plan_print
 * @property string $pack_provide_primary_pack
 * @property string $pack_provide_inner_pack
 * @property string $pack_provide_shipper
 * @property string $pack_customer_aware
 * @property string $pack_spec_ship
 * @property string $pack_customer_spec_pallet
 * @property string $pack_spec_ship_other
 * @property string $pack_custome_spec_pallet_other
 * @property string $note
 * @property integer $document_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $in_trash
 * @property integer $created_by
 */
class Sale extends CActiveRecord
{

	const TYPE_YES = 1;
	const TYPE_NO = 0;
	const TYPE_NA = 2;

	const PACK_TYPE_PILOW = "pack_type_pilow";
	const PACK_TYPE_SACHET = "pack_type_sachet";
	const PACK_TYPE_STICK = "pack_type_stick";
	const PACK_TYPE_CAN = "pack_type_can";
	const PACK_TYPE_JAR = "pack_type_jar";
	const TYPE_OTHER = 'type_other';

	const PACK_TYPE_PLAIN = 'pack_type_plain';
	const PACK_TYPE_PREPRINT = "pack_type_preprint";
	const PACKT_TYPE_CUSTOMER = "pack_type_customer";
	const PACK_TYPE_DURE = "pack_type_dure";

    public $tmp_file_ids;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('project_id, product_sample_product, product_infor_provide_product, product_sample_submit_pack, product_coa_submit, product_spec_qa, product_allergen_qa, product_product_kosher, product_product_spec_provide_qa, document_id, created_time, updated_time, in_trash, created_by', 'numerical', 'integerOnly'=>true),
			array('product_net_weight', 'numerical'),
			array('product_physical_spec, product_allergen_status, product_product_kosher_input, product_type_pack, product_sample_provide_pack, product_sample_coa_submit, product_product_spec_claim, product_spec_hand_instruc, product_spec_ingredient, pack_spec_ship_other, pack_custome_spec_pallet_other', 'length', 'max'=>255),
			array('pack_type_pack, pack_plan_print, pack_provide_primary_pack, pack_provide_inner_pack, pack_provide_shipper, pack_customer_aware, pack_spec_ship, pack_customer_spec_pallet', 'length', 'max'=>50),
			array('note, tmp_file_ids', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_id, product_sample_product, product_infor_provide_product, product_sample_submit_pack, product_coa_submit, product_spec_qa, product_allergen_qa, product_product_kosher, product_product_spec_provide_qa, product_physical_spec, product_allergen_status, product_product_kosher_input, product_type_pack, product_net_weight, product_sample_provide_pack, product_sample_coa_submit, product_product_spec_claim, product_spec_hand_instruc, product_spec_ingredient, pack_type_pack, pack_plan_print, pack_provide_primary_pack, pack_provide_inner_pack, pack_provide_shipper, pack_customer_aware, pack_spec_ship, pack_customer_spec_pallet, pack_spec_ship_other, pack_custome_spec_pallet_other, note, document_id, created_time, updated_time, in_trash, created_by', 'safe', 'on'=>'search'),
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
                    'files' => array(self::MANY_MANY, 'File', 'tbl_sale_file(sale_id, file_id)'),
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
			'product_sample_product' => 'Product Sample Product',
			'product_infor_provide_product' => 'Product Infor Provide Product',
			'product_sample_submit_pack' => 'Product Sample Submit Pack',
			'product_coa_submit' => 'Product Coa Submit',
			'product_spec_qa' => 'Product Spec Qa',
			'product_allergen_qa' => 'Product Allergen Qa',
			'product_product_kosher' => 'Product Product Kosher',
			'product_product_spec_provide_qa' => 'Product Product Spec Provide Qa',
			'product_physical_spec' => 'Product Physical Spec',
			'product_allergen_status' => 'Product Allergen Status',
			'product_product_kosher_input' => 'Product Product Kosher Input',
			'product_type_pack' => 'Product Type Pack',
			'product_net_weight' => 'Product Net Weight',
			'product_sample_provide_pack' => 'Product Sample Provide Pack',
			'product_sample_coa_submit' => 'Product Sample Coa Submit',
			'product_product_spec_claim' => 'Product Product Spec Claim',
			'product_spec_hand_instruc' => 'Product Spec Hand Instruc',
			'product_spec_ingredient' => 'Product Spec Ingredient',
			'pack_type_pack' => 'Pack Type Pack',
			'pack_plan_print' => 'Pack Plan Print',
			'pack_provide_primary_pack' => 'Pack Provide Primary Pack',
			'pack_provide_inner_pack' => 'Pack Provide Inner Pack',
			'pack_provide_shipper' => 'Pack Provide Shipper',
			'pack_customer_aware' => 'Pack Customer Aware',
			'pack_spec_ship' => 'Pack Spec Ship',
			'pack_customer_spec_pallet' => 'Pack Customer Spec Pallet',
			'pack_spec_ship_other' => 'Pack Spec Ship Other',
			'pack_custome_spec_pallet_other' => 'Pack Custome Spec Pallet Other',
			'note' => 'Note',
			'document_id' => 'Document',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'in_trash' => 'In Trash',
			'created_by' => 'Created By',
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
		$criteria->compare('product_sample_product',$this->product_sample_product);
		$criteria->compare('product_infor_provide_product',$this->product_infor_provide_product);
		$criteria->compare('product_sample_submit_pack',$this->product_sample_submit_pack);
		$criteria->compare('product_coa_submit',$this->product_coa_submit);
		$criteria->compare('product_spec_qa',$this->product_spec_qa);
		$criteria->compare('product_allergen_qa',$this->product_allergen_qa);
		$criteria->compare('product_product_kosher',$this->product_product_kosher);
		$criteria->compare('product_product_spec_provide_qa',$this->product_product_spec_provide_qa);
		$criteria->compare('product_physical_spec',$this->product_physical_spec,true);
		$criteria->compare('product_allergen_status',$this->product_allergen_status,true);
		$criteria->compare('product_product_kosher_input',$this->product_product_kosher_input,true);
		$criteria->compare('product_type_pack',$this->product_type_pack,true);
		$criteria->compare('product_net_weight',$this->product_net_weight);
		$criteria->compare('product_sample_provide_pack',$this->product_sample_provide_pack,true);
		$criteria->compare('product_sample_coa_submit',$this->product_sample_coa_submit,true);
		$criteria->compare('product_product_spec_claim',$this->product_product_spec_claim,true);
		$criteria->compare('product_spec_hand_instruc',$this->product_spec_hand_instruc,true);
		$criteria->compare('product_spec_ingredient',$this->product_spec_ingredient,true);
		$criteria->compare('pack_type_pack',$this->pack_type_pack,true);
		$criteria->compare('pack_plan_print',$this->pack_plan_print,true);
		$criteria->compare('pack_provide_primary_pack',$this->pack_provide_primary_pack,true);
		$criteria->compare('pack_provide_inner_pack',$this->pack_provide_inner_pack,true);
		$criteria->compare('pack_provide_shipper',$this->pack_provide_shipper,true);
		$criteria->compare('pack_customer_aware',$this->pack_customer_aware,true);
		$criteria->compare('pack_spec_ship',$this->pack_spec_ship,true);
		$criteria->compare('pack_customer_spec_pallet',$this->pack_customer_spec_pallet,true);
		$criteria->compare('pack_spec_ship_other',$this->pack_spec_ship_other,true);
		$criteria->compare('pack_custome_spec_pallet_other',$this->pack_custome_spec_pallet_other,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('document_id',$this->document_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('in_trash',$this->in_trash);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public static function getTypeProductInfo(){
		return array(
					array(
						'id' => (string)self::TYPE_YES,
						'name' => 'Yes',
					),
					array(
						'id' => (string)self::TYPE_NO,
						'name' => 'No',
					),
					array(
						'id' => (string)self::TYPE_NA,
						'name' => 'N/A',
					),
		);
	}

	 public static function getLabelByType($type, $id){
                $listType = self::getTypeProductInfo();
                
                 switch ($type) {
                     case "product_info" :  $listType = self::getTypeProductInfo();break;
                     case "of_packing" :  $listType = self::getTypeOfPacking();break;
                     case "pack_plain" : $listType = self::getPackPlain();break;
                     case "pack_customer" : $listType = self:: getPackCustomer();break;
                 }
                 foreach($listType as $idx => $ele){
                     if($ele['id'] == $id){
                         return $ele['name'];
                     }
                 }
                 return 'Other';
	 }

	public static function getTypeOfPacking(){
		return array(
			array(
				'id' => self::PACK_TYPE_PILOW ,
				'name' => '2lbs Pillow Pouch',
			),
			array(
				'id' => self::PACK_TYPE_SACHET ,
				'name' => 'Sachet',
			),
			array(
				'id' => self::PACK_TYPE_STICK ,
				'name' => 'Stick Pack',
			),
			array(
				'id' => self::PACK_TYPE_CAN ,
				'name' => 'Can',
			),
			array(
				'id' => self::PACK_TYPE_JAR,
				'name' => 'Jar',
			),
			array(
				'id' => self::TYPE_OTHER,
				'name' => 'Other',
			),
		);
	}

	public static function getPackPlain(){
		return array(
			array(
				'id' 	=> self::PACK_TYPE_PLAIN,
				'name'	=> "Plan with dure food printing",
			),
			array(
				'id' 	=> self::PACK_TYPE_PREPRINT,
				'name'	=> "Pre-printed",
			),
			array(
				'id' 	=> self::TYPE_OTHER,
				'name'	=> "Other",
			),
		);
	}

	public static function getPackCustomer(){
		return array(
			array(
				'id' 	=> self::PACKT_TYPE_CUSTOMER,
				'name'	=> "Customer",
			),
			array(
				'id' 	=> self::PACK_TYPE_DURE,
				'name'	=> "Dure",
			),
			array(
				'id' 	=> self::TYPE_OTHER,
				'name'	=> "Other",
			),
		);
	}
        
    protected function afterSave() {
        $new_list_file_ids = explode(',', $this->tmp_file_ids);
        foreach ($new_list_file_ids as $file_id) {
            $criteria = new CDbCriteria();
            $criteria->compare('sale_id', $this->id);
            $criteria->compare('file_id', $file_id);
            $document_file = SaleFile::model()->find($criteria);
            if (!isset($document_file)) {
                $document_file = new SaleFile();
                $document_file->sale_id = $this->id;
                $document_file->file_id = $file_id;
                $document_file->save();
            }
        }
        $list_current_file_ids = $this->list_current_file_ids;
        foreach ($list_current_file_ids as $file_id) {
            if (!in_array($file_id, $new_list_file_ids)) {
                $criteria = new CDbCriteria();
                $criteria->compare('sale_id', $this->id);
                $criteria->compare('file_id', $file_id);
                ProjectFile::model()->deleteAll($criteria);
            }
        }

        parent::afterSave();
    }
    
    protected function afterDelete() {
        parent::afterDelete();

        $criteria = new CDbCriteria();
        $criteria->addCondition('sale_id =' . $this->id);
        SaleFile::model()->deleteAll($criteria);
    }

    public function getList_current_file_ids() {
        $list = $this->files;
        $result = array();
        foreach ($list as $file) {
            $result[] = $file->id;
        }
        return $result;
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
}
