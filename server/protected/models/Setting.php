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
			array('name,value','required'),
			array('status', 'boolean'),
			array('name','validateName'),
			array('description, status','safe')
		);
	}
	
	/**
	 *
	 * Function validator type
	 */
	public function validateName($attributes,$params){
		$criteria=new CDbCriteria();
		$criteria->compare('name',$this->name);
		$model=Setting::model()->find($criteria);
		if($this->isNewRecord && isset($model))
			$this->addError('name', iPhoenixLang::admin_t('This name has been used'));
		if(!$this->isNewRecord && isset($model) && $model->id != $this->id)
			$this->addError('name', iPhoenixLang::admin_t('This name has been used'));
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */	
	public function attributeLabels()
	{
		return array(
			'name' => iPhoenixLang::admin_t('Name'),
			'value' => iPhoenixLang::admin_t('Value'),
			'type'=> iPhoenixLang::admin_t('Type'),
			'description'=> iPhoenixLang::admin_t('Description'),
			'introimage_id'=> iPhoenixLang::admin_t('Thumb image'),
			'language'=> iPhoenixLang::admin_t('Language')
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
		$criteria->compare('status',$this->status);
	
		$sort = new CSort();
		$sort->defaultOrder = 'type';
		$sort->attributes = array(
		    'name',
		);
		$sort->applyOrder($criteria);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=> Yii::app()->user->getState('pageSize', 50)),
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

	public static function g($name) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $name );
		$model = self::model ()->find ( $criteria );
		if (isset ( $model ))
			return $model->value;
		else{
			throw new CHttpException(400,'Can not find the parameter '.$name);
		}
	}

	public static function s($name, $value) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $name );
		$model = self::model ()->find ( $criteria );
		if (isset ( $model )){
			$model->value = $value;

			if(!$model->save())
				throw new CHttpException(400, CHtml::errorSummary($model));
		}
		else{
			throw new CHttpException(400,'Can not find the parameter '.$name);
		}
	}

	protected function beforeSave()
	{
		if(parent::beforeSave()){
			return true;
		}
	}
}