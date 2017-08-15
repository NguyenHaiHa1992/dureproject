<?php
/**
 * 
 * OperationController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * OperationController includes actions relevant to system operation
 *** create
 *** update
 *** delete
 *** index
 *** suggest name
 *** load model
 *** perform action to list of selected models from checkbox   
 */
class OperationController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',  
				'actions'=>array('write'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('updateForm'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('checkbox'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('suggestName'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('edit'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('init'),
				'users'=>array('@'),
			),
			array('deny', 
				'users'=>array('*'),
			),			
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionWrite()
	{
		if($_GET['type'] == 'update'){
			$model=$this->loadModel($_GET['AuthItem']['name']);	
			if(isset($_GET['AuthItem']))
			{
				$model->attributes=$_GET['AuthItem'];
				if($model->save()){
					$result['success']=true;				
				}
				else{
					$result['success']=false;
					$result['errors']=$model->getErrors();
				}
			}
			else{
				$result['sucess']=false;
			}
		}
		else{
			$model=new AuthItem();
			$model->type=CAuthItem::TYPE_OPERATION;
			if(isset($_GET['AuthItem']))
			{
				$model->attributes=$_GET['AuthItem'];
				if($model->save()){
					$result['success']=true;
				}
				else{
					$result['success']=false;
					$result['errors']=$model->getErrors();
				}
			}	
		}
		echo json_encode($result);
		Yii::app()->end();
	}
	
	/**
	 * Get update form
	 */
	public function actionUpdateForm($name)
	{
		$model=$this->loadModel($name);	
		$result['name']=$model->name;
		$result['bizrule']=$model->bizrule;
		$result['data']=$model->data;
		$result['description']=$model->description;
		echo json_encode($result);
		Yii::app()->end();
	}
	
		
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($name)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($name)->delete();							
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Performs the action with multi-selected model from checked models in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */	
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-operation-list','AuthItem');
		$list_checked = Yii::app()->session["checked-operation-list"];
		$result=array();
		switch ($action) {
			case 'delete' :
				foreach ( $list_checked as $name ) {
					$item = $this->loadModel($name);
					if (isset ( $item ))
						if ( $item->delete ()) {
							$result['success']=true;
							$result['message']='Xóa chức năng thành công';
						}
						else{
							$result['success']=false;
							break;
						}
				}
				Yii::app ()->session ["checked-operation-list"] = array ();
				break;
		}
		echo json_encode($result);
		Yii::app()->end();		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex($category=NULL)
	{
		$this->initCheckbox('checked-operation-list','AuthItem');
		$model=new AuthItem('search');
		$model->unsetAttributes();  // clear any default values
		$model->type=CAuthItem::TYPE_OPERATION;
		if(isset($_GET['AuthItem']))
			$model->attributes=$_GET['AuthItem'];
		$this->render('index',array(
			'model'=>$model
		));
	}
	/**
	 * Suggests name of operation.
	 */
	public function actionSuggestName($category=NULL)
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$names=AuthItem::model()->suggestName($keyword,$category);
			if($names!==array())
				echo implode("\n",$names);
		}
	}	

	/**
	 * Init checkbox selection
	 * @param string $name_params, name of section to work	 
	 */
	public function initCheckbox($name_params,$class,$default=array()){
		if (! isset ( Yii::app ()->session [$name_params] ))
			Yii::app ()->session [$name_params] = $default;
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
		{
				Yii::app ()->session [$name_params] = $default;
		}
		else {
			if (isset ( $_POST [$class] ['list-checked'] )) {
				$list_new = array_diff ( explode ( ',', $_POST [$class] ['list-checked'] ), array ('') );
				$list_old = Yii::app ()->session [$name_params];
				$list = $list_old;
				foreach ( $list_new as $id ) {
					if (! in_array ( $id, $list_old ))
						$list [] = $id;
				}
				Yii::app ()->session [$name_params] = $list;
			}
			if (isset ( $_POST [$class] ['list-unchecked'] )) {
				$list_unchecked = array_diff ( explode ( ',', $_POST [$class] ['list-unchecked'] ), array ('') );
				$list_old = Yii::app ()->session [$name_params];
				$list = array ();
				foreach ( $list_old as $id ) {
					if (! in_array ( $id, $list_unchecked )) {
						$list [] = $id;
					}
				}
				Yii::app ()->session [$name_params] = $list;
			}
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($name)
	{
		$criteria=new CDbCriteria();
		$criteria->compare('name',$name);
		$criteria->compare('type',CAuthItem::TYPE_OPERATION);
		$model=AuthItem::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/*
	 * Edit attribute
	 */
	public function actionEdit($name,$attribute,$value)
	{
		$model = $this->loadModel($name);
		$model->$attribute = $value;
		if($model->save()){
			echo $value;
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest() )
		{
		if( !isset($_GET['ajax'] )  || $_GET['ajax'] != 'operation-list'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
	public function actionInit()
	{		
		$configFile = dirname(__FILE__).'/../data/init_role.php';
		$list_operations=require($configFile);
		foreach ($list_operations as $operation){
			$data=array_diff(explode('|',$operation),array(''));
			$size=sizeof($data);
			switch($size){
				case 1:
					$criteria=new CDbCriteria();
					$criteria->compare('name',$data[0]);
					$criteria->compare('type',CAuthItem::TYPE_OPERATION);
					$tmp=AuthItem::model()->find($criteria);
					if(!isset($tmp)){
						$tmp=new AuthItem();
						$tmp->name=$data[0];
						$tmp->type=CAuthItem::TYPE_OPERATION;
						$tmp->save();
					}
					break;
				case 2:					
					$criteria=new CDbCriteria();
					$criteria->compare('name',$data[0]);
					$criteria->compare('type',CAuthItem::TYPE_OPERATION);
					$criteria->compare('bizrule',$data[2]);
					$tmp=AuthItem::model()->find($criteria);
					if(!isset($tmp)){
						$tmp=new AuthItem();
						$tmp->name=$data[0];
						$tmp->type=CAuthItem::TYPE_OPERATION;
						$tmp->bizrule=$data[1];
						$tmp->save();
					}
					break;
			}
		}
	}
}
