<?php

/**
 * This is the model class for table "AuthItem".
 *
 * The followings are the available columns in table 'AuthItem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 */
class AuthItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AuthItem the static model class
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
		return 'authitem';
	}

   	public function primaryKey(){
       return array('name', 'type');
    }
   
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type', 'required'),
			array('name','validateName'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data', 'safe'),
		);
	}
	
	/**
	 *
	 * Function validator category
	 */
	public function validateName($attributes,$params){
		$criteria=new CDbCriteria();
		$criteria->compare('name',$this->name);
		$criteria->compare('type',CAuthItem::TYPE_OPERATION);
		$model=AuthItem::model()->find($criteria);
		if($this->isNewRecord && isset($model))
			$this->addError('name', 'Tên chức năng đã được sử dụng');
		if(!$this->isNewRecord && isset($model) && $model->name != $this->name)
			$this->addError('name', 'Tên chức năng đã được sử dụng');
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
			'name' => 'Name',
			'type' => 'Type',
			'parent_name' => 'Parent',
			'description' => 'Description',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
		);
	}

	/*
	 * get parent name
	 */
	 public function getParent_name(){
	 	$criteria=new CDbCriteria();
		$criteria->compare('child',$this->name);
		$tmp=AuthItemChild::model()->find($criteria);
		if(isset($tmp))
			return $tmp->parent;
		else 
			return '';
	 }
	 /*
	 * get parent name
	 */
	 public function getChild_name(){
	 	$criteria=new CDbCriteria();
		$criteria->compare('parent',$this->name);
		$tmp=AuthItemChild::model()->find($criteria);
		if(isset($tmp))
			return $tmp->parent;
		else 
			return '';
	 }
	 
	 /**
	 * Returns all roles
	 * @return array $result all roles
	 */
	static function getList_all_roles(){
		$criteria=new CDbCriteria();
		$criteria->compare('type',CAuthItem::TYPE_ROLE);
		$list=AuthItem::model()->findAll($criteria);
		$list_all_roles=array();
		foreach ($list as $item){
			if($item->parent_name == ''){
				$list_all_roles += array($item->name => 1);			
				$list_all_roles += self::treeTraversal($item->name, 1, PHP_INT_MAX);
			}
		}

		return $list_all_roles;
	}
	
	/**
	 * Returns all operations
	 * @return array $result all operations
	 */
	static function getList_all_operations(){
		$criteria=new CDbCriteria();
		$criteria->compare('type',CAuthItem::TYPE_OPERATION);
		$criteria->order='name';
		$list=AuthItem::model()->findAll($criteria);
		$list_operations=array();
		foreach ($list as $item){
			$list_operations[$item->name]=$item->name;
		}
		return $list_operations;
	}
	
	/*
	 * Get list operations
	 */
	public function getList_operations(){
		$list_operations=array();
		if($this->name != ''){
			$criteria=new CDbCriteria();
			$criteria->compare('parent',$this->name);
			$list=AuthItemChild::model()->findAll($criteria);
			foreach($list as $item){
				$criteria=new CDbCriteria();
				$criteria->compare('name',$item->child);
				$tmp=AuthItem::model()->find($criteria);
				if(isset($tmp) && $tmp->type == CAuthItem::TYPE_OPERATION)
					$list_operations[]=$tmp->name;
			}
		}
		return $list_operations;
	}
	/**
	 * Recursive algorithms for tree traversals
	 */
	static function treeTraversal($node_name,$level,$rank){
		$result=array();
		if($node_name != ''){
			$new_level=$level+1;
			$criteria=new CDbCriteria;
			$criteria->compare('parent', $node_name);
			$list=AuthItemChild::model()->findAll($criteria);
			foreach ($list as $item){
				$criteria=new CDbCriteria();
				$criteria->compare('name',$item->child);
				$tmp=AuthItem::model()->find($criteria);
				if(isset($tmp) && $tmp->type == CAuthItem::TYPE_ROLE){
					$result[$item->child]=$new_level;
					if($new_level<$rank){
						$result += self::treeTraversal($item->child, $new_level, $rank);
					}
				}
			}
		}
		return $result;
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
	
		$sort = new CSort();
		$sort->defaultOrder = 'name';
		$sort->attributes = array(
		    'name',
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
	public function suggestName($keyword,$category=NULL,$limit=20)
	{
		$list_operations=$this->findAll(array(
			'condition'=>isset($category)?'name LIKE :keyword AND type="'.CAuthItem::TYPE_OPERATION.'"':'name LIKE :keyword',
			'order'=>'name DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_operations as $operation)
			$names[]=$operation->name;
			return $names;
	}	
 	protected function afterDelete()
    {
	    parent::afterDelete();
		//Delete
		$criteria=new CDbCriteria();
		$criteria->compare('child',$this->name);
		AuthItemChild::model()->deleteAll($criteria);
	
		$criteria=new CDbCriteria();
		$criteria->compare('parent',$this->name);
		AuthItemChild::model()->deleteAll($criteria);
    }
}