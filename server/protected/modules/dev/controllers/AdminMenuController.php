<?php
/**
 * 
 * AdminMenuController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * AdminMenuController includes actions relevant to AdminMenu:
 *** create new AdminMenu
 *** update information of a AdminMenu
 *** delete AdminMenu
 *** validate menu
 *** index menu
 *** write 
 *** update list order view
 *** load model Banner from banner's id
 *** perform action to list of selected banner from checkbox  
 */
class AdminMenuController extends Controller
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
				'actions'=>array('create'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('delete'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('validate'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('write'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('updateListOrderView'),
				'users'=>array('@'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
			$action="create";
			$model=new AdminMenu();			
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
			),true);
			
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
			$action="update";
			$model=$this->loadModel($id);
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
			),true);
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$current_id)
	{
			$result=array();
			$model=$this->loadModel($id);
			switch ((int)$model->checkDelete($id))	{
				case AdminMenu::DELETE_OK:		
					if($model->delete()) {
						$result['status']=true;
						if($id!=$current_id && $current_id!=0){
							$model=$this->loadModel($current_id);
							$action="update";
						}
						else {
							$model=new AdminMenu();
							$action="create";
						}
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						$html_tree=$this->renderPartial('_tree',array(
							'list_nodes'=>$model->list_nodes,
							),true);
						$html_form = $this->renderPartial('_form',array(
							'model'=>$model,'action'=>$action
							),true,true); 
						$result['content']=$html_form.$html_tree;	
					}
					else {
						$result['status']='false';
						$action['content']='Hệ thống đang quá tải';
					}
					break;
				case AdminMenu::DELETE_HAS_CHILD:
					$result['status']= false;
					$result['content'] = "Bạn phải xóa hết các menu con.";
					break;
				default:
					$result['status']='false';
					$action['content']='Hệ thống đang quá tải';
					break;
			}
			echo CJSON::encode($result);
	}

	/**
	 * Validate menu
	 * @return 
	 */
	public function actionValidate()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			if($_POST['id']>0){
				$model=AdminMenu::model()->findByPk($_POST['id']);
			}
			else {
				$model=new AdminMenu();
			}
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Display list of menu.
	 * @return
	 */
	public function actionIndex()
	{
		$model=new AdminMenu();
		$this->render('index',array(
			'model'=>$model,
			'action'=>'create'
		));
	}
	/**
	 * Creates and updates a new AdminMenu model.
	 * @return 
	 */
	public function actionWrite()
	{	
		if(isset($_GET['AdminMenu']))
		{
			$id=(int)$_GET['id'];
			if ( is_int($id) && $id>0){
				$action="update";
				$model=$this->loadModel($id);
			}
			else {
				$action="create";
				$model=new AdminMenu();
			}	
			$model->attributes=$_GET['AdminMenu'];
			if($model->save()){
				if($action=="create"){
					$model=new AdminMenu();
				}
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list_nodes'=>$model->list_nodes,
				),true)
				;
			$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
		}
	}
	
	/**
	 * Updates list order view.
	 * @param integer $parent_id id of parent menu
	 */
	public function actionUpdateListOrderView($parent_id)
	{	
		$list=AdminMenu::model()->findAll('parent_id='.$parent_id);
		$max_order=sizeof($list)+1;
		echo $max_order;
	}
		
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminMenu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
