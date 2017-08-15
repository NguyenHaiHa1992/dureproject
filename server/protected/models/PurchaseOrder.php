<?php

/**
 * This is the model class for table "{{purchase_order}}".
 *
 * The followings are the available columns in table '{{purchase_order}}':
 * @property string $id
 * @property string $po_code
 * @property string $client_id
 * @property string $ship_via
 * @property string $order_date
 * @property string $file_id
 * @property integer $status
 * @property string $created_time
 */
class PurchaseOrder extends CActiveRecord
{
	public $tmp_file_ids;

	const REPLY_STATUS_WAITING = 0;
	const REPLY_STATUS_ACCEPT = 1;
	const REPLY_STATUS_DECLINE = 2;

	const CATEGORY_ORDER = 0;
	const CATEGORY_QUOTE = 1;

	public static $category_list = array(
		array(
			'id'=>self::CATEGORY_ORDER,
			'label'=>'Order',
		),
		array(
			'id'=>self::CATEGORY_QUOTE,
			'label'=>'Quote',
		)
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{purchase_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('po_code, client_id, ship_via, order_date, delivery_date, entered_date, category', 'required'),
			array('status, reply_status', 'numerical', 'integerOnly'=>true),
			array('po_code, ship_via', 'length', 'max'=>20),
			array('customer_po, shipping_address', 'length', 'max'=>255),
			array('note', 'length', 'max'=>80000),
			array('client_id, order_date, file_id, created_time', 'length', 'max'=>11),
			array('tmp_file_ids, tax, comment, category','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, po_code, client_id, ship_via, order_date, file_id, status, created_time', 'safe', 'on'=>'search'),
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
			'client'=>array(self::BELONGS_TO,'Client','client_id'),
			'files' => array(self::MANY_MANY, 'File', 'tbl_purchase_order_file(purchase_order_id, file_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'po_code' => 'Po Code',
			'client_id' => 'Client',
			'ship_via' => 'Ship Via',
			'order_date' => 'Order Date',
			'file_id' => 'File',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'tmp_file_ids'=>'Uploaded file',
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
		$criteria->compare('po_code',$this->po_code,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('ship_via',$this->ship_via,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('file_id',$this->file_id,true);
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
	 * @return PartOrder the static model class
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

	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord){
				if($this->tax == '')
					$this->tax = Setting::g('TAX');
			}

			return true;
		}
	}

	protected function afterSave()
	{
		$new_list_file_ids=explode(',',$this->tmp_file_ids);
		foreach ($new_list_file_ids as $file_id) {
			$criteria=new CDbCriteria();
			$criteria->compare('purchase_order_id',$this->id);
			$criteria->compare('file_id',$file_id);
			$document_file=PurchaseOrderFile::model()->find($criteria);
			if(!isset($document_file)){
				$document_file=new PurchaseOrderFile();
				$document_file->purchase_order_id=$this->id;
				$document_file->file_id=$file_id;
				$document_file->save();
			}
			
		}		
		$list_current_file_ids=$this->list_current_file_ids;
		foreach ($list_current_file_ids as $file_id) {
			if(!in_array($file_id,$new_list_file_ids)){
				$criteria=new CDbCriteria();
				$criteria->compare('purchase_order_id',$this->id);
				$criteria->compare('file_id',$file_id);
				PurchaseOrderFile::model()->deleteAll($criteria);
			}
		}

	    parent::afterSave();
	}

	protected function afterDelete()
    {
    	parent::afterDelete();

		$criteria=new CDbCriteria();
		$criteria->addCondition('purchase_order_id ='.$this->id);
		PurchaseOrderFile::model()->deleteAll($criteria);
	}

	public function getList_current_file_ids(){
		$list=$this->files;
		$result=array();
		foreach ($list as $file) {
			$result[]=$file->id;
		}
		return $result;
	}

	public function generateOrderFile(){
		$result = array();

		// Create attachment pdf
		// Check whether file exists
		$po_code = preg_replace('/\s+/', '_', $this->po_code);
		$po_file = $po_code.'_Order';
		$check_file = $po_file;
		$i = 1;
		while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
			$check_file = $po_file.'_'.$i;
			$i++;
		}

		$po_file = $check_file;
		$detail_html = $this->renderPartial('_email_frame', array(
			'content'=>$detail,
		), true);
		iPhoenixUrl::exportPdfFromHTML($detail_html, $po_file);

		$result = array(
			'success'=>true, 
			'url'=> Yii::app()->getBaseUrl(true).'/server/data/pdf/'.$po_file.'.pdf',
			'path'=>Yii::getPathOfAlias('webroot').'/data/pdf/'.$po_file.'.pdf'
		);

		return $result;
	}

	public function getCategoryName(){
		if($this->category == self::CATEGORY_ORDER)
			return 'Order';
		if($this->category == self::CATEGORY_QUOTE)
			return 'Quote';
	}
}
