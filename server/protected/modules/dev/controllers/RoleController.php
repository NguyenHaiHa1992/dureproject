<?php
/**
 * 
 * RoleController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
class RoleController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('write'),
				'users'=>array('@'),
			),
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
				'actions'=>array('init'),
				'users'=>array('@'),
			),			
			array('deny', 
				'users'=>array('*'),
			),				
		);
	}
	
	public function actionIndex()
	{
		$model=new AuthItem();
				
		$this->render('index',array(
				'model'=>$model,
				'action'=>'create'
		));
	}

	/**
	 * Creates and updates a new AuthItem model.
	 * @return 
	 */
	public function actionWrite()
	{	
		if (isset($_POST['current_name']) && $_POST['current_name'] != ''){
			$action="update";
			$criteria=new CDbCriteria();
			$criteria->compare('type',CAuthItem::TYPE_ROLE);
			$criteria->compare('name',$_POST['current_name']);
			$model=AuthItem::model()->find($criteria);
		}
		else {
			$action="create";
			$model=new AuthItem();
			$model->type=CAuthItem::TYPE_ROLE;
		}	
		
		$model->attributes=$_POST['AuthItem'];
		if($model->save()){			
			$criteria=new CDbCriteria();
			$criteria->compare('type',CAuthItem::TYPE_ROLE);
			$criteria->compare('name',$model->name);
			$role=AuthItem::model()->find($criteria);
			if(isset($role)){	
				//Delete old parent
				$criteria=new CDbCriteria();
				$criteria->compare('child',$role->name);
				$tmp=AuthItemChild::model()->find($criteria);
				if(isset($tmp))	$tmp->delete();
				if($_POST['AuthItem']['parent_name'] != ''){		
					$criteria=new CDbCriteria();
					$criteria->compare('type',CAuthItem::TYPE_ROLE);
					$criteria->compare('name',$_POST['AuthItem']['parent_name']);
					$tmp=AuthItem::model()->find($criteria);
					if(isset($tmp)){
						$tmp=new AuthItemChild();
						$tmp->parent=$_POST['AuthItem']['parent_name'];
						$tmp->child=$model->name;
						$tmp->save();
					}
				}		
				//Update list operations
				$list_old_operations=array();
				$criteria=new CDbCriteria();
				$criteria->compare('parent',$role->name);
				$list=AuthItemChild::model()->findAll($criteria);
				foreach($list as $item){
					$criteria=new CDbCriteria();
					$criteria->compare('name',$item->child);
					$tmp=AuthItem::model()->find($criteria);

					if(isset($tmp)){
						if($tmp->type == CAuthItem::TYPE_OPERATION){
							$list_old_operations[]=$tmp->name;
						}
					}
					else{
						echo 'Không tồn tại Role sau '.$item->child;
					}
				}			
				$list_new_operations=array();
				if(isset($_POST['AuthItem']['list_operations']))
					$list_new_operations=$_POST['AuthItem']['list_operations'];
				//Create operation
				foreach ($list_new_operations as $operation){
					$criteria=new CDbCriteria();
					$criteria->compare('parent',$model->name);
					$criteria->compare('child',$operation);
					$tmp=AuthItemChild::model()->find($criteria);
					if(!isset($tmp)){
						$tmp=new AuthItemChild();
						$tmp->parent=$model->name;
						$tmp->child=$operation;
						$tmp->save();
					}
				}
				//Delete operation
				$delete_operations=array_diff($list_old_operations, $list_new_operations);
				foreach ($delete_operations as $operation){
					$criteria=new CDbCriteria();
					$criteria->compare('parent',$model->name);
					$criteria->compare('child',$operation);
					$tmp=AuthItemChild::model()->find($criteria);
					if(isset($tmp))	$tmp->delete();
				}
			}
			
			if($action=="create"){
				$model=new AuthItem();
			}
		}
			
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		
		$html_tree=$this->renderPartial('_tree',true,true);
		$html_form = $this->renderPartial('_form',array(
				'model'=>$model,'action'=>$action
			),true,true); 
		echo $html_form.$html_tree;
	}

	public function actionCreate(){
		$action="create";
		$model=new AuthItem();
										
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$html_tree=$this->renderPartial('_tree',true,true);
		
		$html_form = $this->renderPartial('_form',array(
				'model'=>$model,'action'=>$action
			),true,true); 
		echo $html_form.$html_tree;
	}
	
	public function actionUpdate($name)
	{
		$action="update";
		$criteria=new CDbCriteria();
		$criteria->compare('type',CAuthItem::TYPE_ROLE);
		$criteria->compare('name',$name);
		$model=AuthItem::model()->find($criteria);
								
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$html_tree=$this->renderPartial('_tree',true,true);
		
		$html_form = $this->renderPartial('_form',array(
			'model'=>$model,'action'=>$action)
			,true,true); 
		echo $html_form.$html_tree;
	}

	public function actionDelete($name,$current_name)
	{		
		$criteria=new CDbCriteria();
		$criteria->compare('type',CAuthItem::TYPE_ROLE);
		$criteria->compare('name',$name);
		$role=AuthItem::model()->find($criteria);
		if(isset($role)){
			$criteria=new CDbCriteria();
			$criteria->compare('itemname',$name);
			$list=AuthAssignment::model()->findAll($criteria);
			if(sizeof($list) == 0){
				//Delete
				$criteria=new CDbCriteria();
				$criteria->compare('child',$name);
				AuthItemChild::model()->deleteAll($criteria);
			
				$criteria=new CDbCriteria();
				$criteria->compare('parent',$name);
				AuthItemChild::model()->deleteAll($criteria);
									
				$criteria=new CDbCriteria();
				$criteria->compare('name',$name);
				AuthItem::model()->deleteAll($criteria);
				
				if($name!=$current_name && $current_name!=0){
					$criteria=new CDbCriteria();
					$criteria->compare('type',CAuthItem::TYPE_ROLE);
					$criteria->compare('name',$name);
					$model=AuthItem::model()->find($criteria);
					$action="update";
				}
				else {
					$model=new AuthItem();
					$action="create";
				}
								
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				
				$html_tree=$this->renderPartial('_tree',true,true);
				
				$html_form = $this->renderPartial('_form',array(
					'model'=>$model,'action'=>$action)
					,true,true); 
					
				$result['status']=true;
				$result['content']=$html_form.$html_tree;
			}
			else{
				$result['status']=false;
				$result['content']='Quyền đang được sử dụng';
			}
		}
		else {
			$result['status']=false;
			$result['content']='Không tồn tại';			
		}
		echo CJSON::encode($result);
	}
}