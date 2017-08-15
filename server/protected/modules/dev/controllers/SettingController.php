<?php
/**
 * 
 * SettingController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * SettingController includes actions relevant to system setting
 *** create
 *** update
 *** delete
 *** index
 *** suggest name
 *** load model
 *** perform action to list of selected models from checkbox   
 */
class SettingController extends Controller
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
		if(isset($_GET['Setting']['id']) && $_GET['Setting']['id'] != ''){
			$model=$this->loadModel($_GET['Setting']['id']);	
			if(isset($_GET['Setting']))
			{
				$model->attributes=$_GET['Setting'];
				if($model->save()){
					$result['success']=true;
				}
				else{
					$result['success']=false;
					$result['errors']=$model->getErrors();
				}
			}
		}
		else{
			$model=new Setting();
			if(isset($_GET['Setting']))
			{
				$model->attributes=$_GET['Setting'];
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
	public function actionUpdateForm($id)
	{
		$model=$this->loadModel($id);	
		$result['id']=$model->id;
		$result['type']=$model->type;
		$result['name']=$model->name;
		$result['value']=$model->value;
		$result['description']=$model->description;
		echo json_encode($result);
		Yii::app()->end();
	}
	
		
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
		$this->initCheckbox('checked-setting-list','Setting');
		$list_checked = Yii::app()->session["checked-setting-list"];
		$result=array();
		switch ($action) {
			case 'delete' :
				foreach ( $list_checked as $id ) {
					$item = Setting::model ()->findByPk ( (int)$id );
					if (isset ( $item ))
						if ( $item->delete ()) {
							$result['success']=true;
							$result['message']='Xóa tham số thành công';
						}
						else{
							$result['success']=false;
							break;
						}
				}
				Yii::app ()->session ["checked-setting-list"] = array ();
				break;
		}
		echo json_encode($result);
		Yii::app()->end();		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex($type=NULL)
	{
		$this->initCheckbox('checked-setting-list','Setting');
		$model=new Setting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Setting']))
			$model->attributes=$_GET['Setting'];
		$this->render('index',array(
			'model'=>$model
		));
	}
	/**
	 * Suggests name of setting.
	 */
	public function actionSuggestName($type=NULL)
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$names=Setting::model()->suggestName($keyword,$type);
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
	public function loadModel($id)
	{
		$model=Setting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/*
	 * Edit attribute
	 */
	public function actionEdit($id,$attribute,$value)
	{
		$model = Setting::model()->findByPk($id);
		$model->$attribute = $value;
		if($model->save()){
			echo $value;
		}
		else var_dump($model->getErrors());
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest() )
		{
		if( !isset($_GET['ajax'] )  || $_GET['ajax'] != 'setting-list'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
}
