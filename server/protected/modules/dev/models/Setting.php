<?php
/**
 * 
 * Setting class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "setting".
 */
class Setting extends CActiveRecord
{
	public $list=array('SEO'=>'SEO','ADMIN'=>'ADMIN','INFORMATION'=>'INFORMATION');
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */	
	public function tableName()
	{
		return '{{setting}}';
	}
	/**
	 * @return array validation rules for model attributes.
	 */	
	public function rules()
	{
		return array(
			array('name,value,type','required'),
			array('name','validateName'),
			array('description,introimage_id, language','safe')
		);
	}
	
	/**
	 *
	 * Function validator type
	 */
	public function validateName($attributes,$params){
		$criteria=new CDbCriteria();
		$criteria->compare('name',$this->name);
		$criteria->compare('type',$this->type);
		$criteria->compare('language',$this->language);
		$model=Setting::model()->find($criteria);
		if($this->isNewRecord && isset($model))
			$this->addError('name', 'Tên tham số đã được sử dụng');
		if(!$this->isNewRecord && isset($model) && $model->id != $this->id)
			$this->addError('name', 'Tên tham số đã được sử dụng');
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */	
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên tham số',
			'value' => 'Giá trị',
			'type'=>'Nhóm',
			'description'=>'Mô tả',
			'introimage_id'=>'Ảnh mô tả',
			'language'=>'Ngôn ngữ'
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		if (isset($_GET['pageSize'])) {
	        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
	        unset($_GET['pageSize']);
	    }
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
		if(isset($condition_search))
			$criteria->addCondition($condition_search);
	
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('language',$this->language);
	
		$sort = new CSort();
		$sort->defaultOrder = 'type';
		$sort->attributes = array(
		    'name',
			'type',
			'language'
		);
		$sort->applyOrder($criteria);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=> Yii::app()->user->getState('pageSize',10)),
			'sort'=>$sort,				
		));
	}
	/**
	 * Suggests a list of existing names matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$type=NULL,$limit=20)
	{
		$list_setting=$this->findAll(array(
			'condition'=>isset($type)?'name LIKE :keyword AND type="'.$type.'"':'name LIKE :keyword',
			'order'=>'name DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_setting as $setting)
			$names[]=$setting->name;
			return $names;
	}	
	public static function s($name,$type) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $name );
		$criteria->compare ( 'type', $type );
		$model = self::model ()->find ( $criteria );
		if (isset ( $model ))
			return $model->value;
		else
		{
			throw new CHttpException(400,'Trong nhóm '.$type.' không tồn tại tham số cấu hình '.$name);
		}
	}

	protected function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord)
			{
				$this->language = "vi";
			}

			return true;
		}
	}

	protected function afterSave()
	{
		if($this->isNewRecord && $this->language == 'vi'){
			$query = "INSERT INTO `tbl_setting` (`id`, `language`, `name`, `value`, `type`, `description`) VALUES (NULL, 'en', '".$this->name."', '".$this->value."', '".$this->type."', '".$this->description."')";
			$command = Yii::app()->db->createCommand($query);
			$command->execute();
		}

		parent::afterSave();
	}
}