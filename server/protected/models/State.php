<?php

/**
 * 
 * State class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "tbl_user".
 */
class State extends CActiveRecord
{		
	private $config_other_attributes=array();
	
	/**
	 * PHP setter magic method for other attributes
	 * @param $name the attribute name
	 * @param $value the attribute value
	 * set value into particular attribute
	 */
	public function __set($name,$value)
	{
		if(in_array($name,$this->config_other_attributes)){
			$other=$this->other;
			$other[$name]=$value;
			$this->other=$other;
		}
		else 
			parent::__set($name,$value);
	}
	
	/**
	 * PHP getter magic method for other attributes
	 * @param $name the attribute name
	 * @return value of {$name} attribute
	 */
	public function __get($name)
	{
		if(in_array($name,$this->config_other_attributes))
			if(isset($this->other[$name])) 
				return $this->other[$name];
			else 
		 		return null;
		else
			return parent::__get($name);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{state}}';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state_short, state_full, country_short, country_full, seasonal_cpm_change','required'),
			array('state_short, state_full', 'unique'),
			array('seasonal_cpm_change', 'numerical', 'integerOnly'=>true),
			array('state_short, state_full, country_short, country_full', 'length', 'max'=>100),
			array('state_short, state_full, country_short, country_full', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			''
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($condition_search=null)
	{
		if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('state_short',$this->state_short, true);
		$criteria->compare('state_full',$this->state_full, true);
		$criteria->compare('country_short',$this->country_short, true);
		$criteria->compare('country_full',$this->country_full, true);

		if(isset($condition_search))
			$criteria->addCondition($condition_search);
		
		$sort = new CSort();
		$sort->defaultOrder = 'id DESC';
		$sort->attributes = array(
	    	'state_short',
	    	'state_full',
	    	'country_short',
	    	'country_full',
		);
		$sort->applyOrder($criteria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
    		'pagination'=>array('pageSize'=> Yii::app()->user->getState('pageSize',10)),	
			'sort'=>$sort,	
		));
	}

	public function getListZone(){
		$criteria = new CDbCriteria();
		$criteria->compare('state_id', $this->id);
		$criteria->limit = 500;
		$list_zone = Zone::model()->findAll($criteria);
		$list = array();
		foreach($list_zone as $zone){
			$list[] = $zone->zone;
		}
		return $list;
	}


	public function getListCity(){
		$criteria = new CDbCriteria();
		$criteria->compare('state_id', $this->id);
		$criteria->limit = 500;
		$list_city = City::model()->findAll($criteria);
		$list = array();
		foreach($list_city as $city){
			$list[$city->id] = $city->city_name;
		}
		return $list;
	}
}