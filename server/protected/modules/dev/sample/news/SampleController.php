<?php
/**
 * 
 * SampleController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
class SampleController extends Controller
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
	/*ACCESSRULES*/
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('create'),
				'roles'=>array('sample_create'),
			),
			array('allow',  
				'actions'=>array('copy'),
				'roles'=>array('sample_copy'),
			),
			array('allow', 
				'actions'=>array('update'),
				'roles'=>array('sample_update'),
			),
			array('allow', 
				'actions'=>array('autoSave'),
				'roles'=>array('sample_autoSave'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'roles'=>array('sample_delete'),
			),
			array('allow',  
				'actions'=>array('checkbox'),
				'roles'=>array('sample_checkbox'),
			),
			array('allow',  
				'actions'=>array('index'),
				'roles'=>array('sample_index'),
			),
			array('allow',  
				'actions'=>array('reverseStatus'),
				'roles'=>array('sample_reverseStatus'),
			),
			array('allow',  
				'actions'=>array('reverseHome'),
				'roles'=>array('sample_reverseHome'),
			),
			array('allow',  
				'actions'=>array('reverseNew'),
				'roles'=>array('sample_reverseNew'),
			),
			array('allow',  
				'actions'=>array('suggestTitle'),
				'roles'=>array('sample_suggestTitle'),
			),
			array('allow',  
				'actions'=>array('updateSuggest'),
				'roles'=>array('sample_updateSuggest'),
			),
			array('allow',  
				'actions'=>array('edit'),
				'roles'=>array('sample_edit'),
			),
			array('deny', 
				'users'=>array('*'),
			),			
		);
	}
	/*!ACCESSRULES*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Sample();
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sample']))
		{
			$model->attributes=$_POST['Sample'];
			if($model->save())
				$this->redirect(iPhoenixUrl::createUrl('admin/sample/update',array('id'=>$model->id)));
		}
		//Group categories that contains sample
		$list_category=SAMPLe_Category::getList_nodes();
		
		//Handler list suggest sample
		$this->initCheckbox('checked-suggest-list','SuggestSample',$model->list_current_suggest_ids);
		$suggest=new Sample('search');
		$suggest->unsetAttributes();  
		if(isset($_GET['SuggestSample']))
			$suggest->attributes=$_GET['SuggestSample'];	

		$this->render('create',array(
			'model'=>$model,
			'list_category'=>$list_category,	
			'suggest' => $suggest	
		));
	}
	/**
	 * Copy a new model
	 * @param integer $id the ID of model to be copied
	 */
	public function actionCopy($id)
	{
		$sample=Sample::model()->findByPk($id);
		$copy=$sample->copy();
		if(isset($copy))
		{
				$this->redirect(iPhoenixUrl::createUrl('admin/sample/update',array('id'=>$copy->id)));
		}
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);	
		//if (Yii::app ()->user->checkAccess ( 'sample_update', array ('sample' => $model ) )) {
		if(true){
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Sample']))
		{
			$model->attributes=$_POST['Sample'];
			if($model->save()){				
				$this->redirect(iPhoenixUrl::createUrl('admin/sample/update',array('id'=>$model->id)));
			}
		}
		//Group categories that contains sample
		$list_category=SAMPLe_Category::getList_nodes();
		
		//Handler list suggest sample
		$this->initCheckbox('checked-suggest-list','SuggestSample',$model->list_current_suggest_ids);
		$suggest=new Sample('search');
		$suggest->unsetAttributes();  
		if(isset($_GET['SuggestSample']))
			$suggest->attributes=$_GET['SuggestSample'];	

		$this->render('update',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'suggest' => $suggest
		));	
		}	
		else
			throw new CHttpException(400,iPhoenixLang::admin_t('You do not have authorization to perform this action','main'));	
	}

	/**
	 * Auto save a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAutoSave($id='')
	{
		if($id==''){
			$model=new Sample();
			if(isset($_POST['Sample']))
			{
				$model->attributes=$_POST['Sample'];
				if($model->save())
					echo json_encode(array('success' => true, 'message'=>'Success', 'url' => iPhoenixUrl::createUrl('admin/sample/update',array('id'=>$model->id))));
				else
					echo json_encode(array('success' => false, 'message'=>'Error'));
			}
		}
		else{
			$model=$this->loadModel($id);
			if(isset($_POST['Sample']))
			{
				$model->attributes=$_POST['Sample'];
				if($model->save())
					echo json_encode(array('success' => true, 'message'=>'Success'));
				else
					echo json_encode(array('success' => false, 'message'=>'Error'));
			}
		}
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
			throw new CHttpException(400,iPhoenixLang::admin_t('Invalid request. Please do not repeat this request again','main'));
	}

	/**
	 * Performs the action with multi-selected sample from checked models in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-sample-list','Sample');
		$list_checked = Yii::app()->session["checked-sample-list"];
		$result=array();
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'sample_delete')) {
					foreach ( $list_checked as $id ) {
						$item = Sample::model ()->findByPk ( (int)$id );
						if (isset ( $item ))
							if ( $item->delete ()) {
								$result['success']=true;
								$result['message']=iPhoenixLang::admin_t('Delete successfully','main');
							}
							else{
								$result['success']=false;
								break;
							}
					}
					Yii::app ()->session ["checked-sample-list"] = array ();
				} else {
					$result['success']=false;
					$result['message']=iPhoenixLang::admin_t('You do not have authorization to perform this action','main');
					break;
				}
				break;
			case 'copy' :
				if (Yii::app ()->user->checkAccess ( 'sample_copy')) {
					foreach ( $list_checked as $id ) {
						$sample=Sample::model()->findByPk($id);
						$copy=$sample->copy();
						if(isset($copy))
						{
							$result['success']=true;
							$result['message']=iPhoenixLang::admin_t('Copy successfully','main');
						}
						else{
							$result['success']=false;
							break;
						}
					}
					Yii::app ()->session ["checked-sample-list"] = array ();
				}
				else {
					$result['success']=false;
					$result['message']=iPhoenixLang::admin_t('You do not have authorization to perform this action','main');
					break;
				}
				break;
		}
		echo json_encode($result);
		Yii::app()->end();
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-sample-list','Sample');
		$model=new Sample('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sample']))
			$model->attributes=$_GET['Sample'];	
		//Group categories that contains sample
		$list_category=SAMPLe_Category::getList_nodes();
		$this->render('index',array(
			'model'=>$model,
			'list_category'=>$list_category,
		));
	}
	/**
	 * Reverse status of sample
	 * @param integer $id, the ID of sample to be reversed
	 */
	public function actionReverseStatus($id)
	{
		$sample=Sample::model()->findByPk($id);
		$old_status=$sample->status;
		$sample->status=!$old_status;
		if($sample->save()) 
			echo json_encode(array('success'=>true,'src'=>$sample->imageStatus));
		else 
			echo json_encode(array('success'=>false));
	}
	
	/**
	 * Reverse status home of sample
	 * @param integer $id, the ID of sample to be reversed
	 */
	public function actionReverseHome($id)
	{
		$sample=Sample::model()->findByPk($id);
		$old_home=$sample->home;
		$sample->home=!$old_home;
		if($sample->save()) 
			echo json_encode(array('success'=>true,'src'=>$sample->imageHome));
		else 
			echo json_encode(array('success'=>false));
	}
	
	/**
	 * Reverse status new of sample
	 * @param integer $id, the ID of sample to be reversed
	 */
	public function actionReverseNew($id)
	{
		$sample=Sample::model()->findByPk($id);
		$old_new=$sample->new;
		$sample->new=!$old_new;
		if($sample->save()) 
			echo json_encode(array('success'=>true,'src'=>$sample->imageNew));
		else 
			echo json_encode(array('success'=>false));
	}
	
	/**
	 * Suggests title of sample.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Sample::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	
	/*
	 * Update suggest sample
	 */
	public function actionUpdateSuggest()
	{
		$this->initCheckbox('checked-suggest-list','SuggestSample');
		$list_checked = Yii::app()->session["checked-suggest-list"];
		echo implode(',',$list_checked);
	}
	
	/*
	 * Edit attribute
	 */
	public function actionEdit($id,$attribute,$value)
	{
		$model = Sample::model()->findByPk($id);
		$model->$attribute = $value;
		if($model->save()){
			echo $value;
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
		$model=Sample::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,iPhoenixLang::admin_t('The requested page does not exist','main'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest() )
		{
		if( !isset($_GET['ajax'] )  || $_GET['ajax'] != 'sample-list'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
}