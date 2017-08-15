<?php
/**
 * 
 * BannerController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * IHBController includes actions relevant to Banner:
 *** create new model  
 */
class IHBController extends Controller
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
				'actions'=>array('uploadTheme'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('createNewsModel'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('createCategoryModel'),
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
	public function actionUploadTheme()
	{
        $basepath = realpath(Yii::app()->basePath.'/../');
        $themes_dir = $basepath.'/themes/';
		$theme_default_dir = $basepath.'/themes/default/';
		if(isset($_FILES['Theme_file'])){
			if($_FILES["Theme_file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["Theme_file"]["error"] . "<br>";
			}
			else
			{
				// Create theme directory
				if(isset($_POST['Theme_name']))
				{
					$theme_name = $_POST['Theme_name'];
					mkdir($themes_dir.$theme_name, 0755);
					$theme_dir = $themes_dir.$theme_name;
				}

				// Copy default config to theme directory
				phpExpand::copy_directory($theme_default_dir,$theme_dir);

				// Move uploaded theme to theme directory
				move_uploaded_file($_FILES["Theme_file"]["tmp_name"], $theme_dir.'/'.$_FILES["Theme_file"]["name"]);
				$zip = new ZipArchive;
				if ($zip->open($theme_dir.'/'.$_FILES["Theme_file"]["name"]) === TRUE) {
				    $zip->extractTo($theme_dir);
				    $zip->close();
					unlink($theme_dir.'/'.$_FILES["Theme_file"]["name"]); //Remove zipped theme after extraction
					mkdir($theme_dir.'/views/');
					mkdir($theme_dir.'/views/layout/');
				    Yii::app()->user->setFlash('success', 'Extract theme OK');
					
					// Customize index.html file
					include('simple_html_dom.php');
					$returned_content = file_get_contents($theme_dir.'/index.html');
					$returned_content = preg_replace("/[[:blank:]]+/"," ",$returned_content);
					$search = array(
						'"css/','"js/',
					);
					$replace = array(
						'"<?php echo Yii::app()->theme->baseUrl?>/css/',
						'"<?php echo Yii::app()->theme->baseUrl?>/js/',
					);
					$_data = str_replace($search,$replace,$returned_content);

					$fp = fopen($theme_dir.'/views/layout/main.php', 'w+');
					fputs($fp,$_data);
					fclose($fp);
				} else {
				    Yii::app()->user->setFlash('error', 'Extract theme FAIL');
				}
			}
		}
		$this->render('upload');
	}

	/**
	 * Creates a new model.
	 */
	public function actionCreateNewsModel()
	{
		include_once('simple_html_dom.php');
        $basepath = realpath(Yii::app()->basePath.'/../');
		$admin_dir = $basepath.'/protected/modules/admin/';
		$admin_view_dir = $basepath.'/themes/admin/views/';
		$sample_dir = $basepath.'/protected/modules/dev/sample/news/';
		$roles = array();

		if(!isset($model_name)) $model_name = '';
		if (isset($_POST['Model_name']) && isset($_POST['Model_translation'])) {
			if($_POST['Model_name']!='' && $_POST['Model_translation'] != ''){
				$model_name = $_POST['Model_name'];
				$model_category_type = $_POST['Model_category_type'];
				$model_translation = $_POST['Model_translation'];
	
				/*** Create table ***/
				// Check if table exists
				if(!Yii::app()->db->schema->getTable('{{'.strtolower($model_name).'}}')){
					// Create table
					$db = Yii::app()->db->createCommand();
					$db->createTable('{{'.strtolower($model_name).'}}', array(
					    'id' => 'int(11) AUTO_INCREMENT',
					    'id' => 'pk',
					    'language'=>'char(8) NOT NULL',
					    'status'=>'tinyint(1) NOT NULL',
						'title'=>'varchar(256) NOT NULL',
						'cat_id'=>'int(11) NOT NULL',
						'introimage_id'=>'int(11) NOT NULL',
						'order_view'=>'int(11) NOT NULL',
						'new'=>'tinyint(1) NOT NULL',
						'home'=>'tinyint(1) NOT NULL',
						'other'=>'text NOT NULL',	
						'visits'=>'int(11) NOT NULL',
						'created_by'=>'int(11) NOT NULL',
						'created_time'=>'int(11) NOT NULL',
					), 
					'charset=utf8',
					'ENGINE=InnoDB');
				}
				else{
					Yii::app()->user->setFlash('error','CHÚ Ý: table "{{'.strtolower($model_name).'}}" đã tồn tại!!!');
					$this->render('createNewsModel',array('roles'=>$roles,'model_name'=>$model_name));
					return;
				}
				//Check if suggest table exists
				if(!Yii::app()->db->schema->getTable('{{suggest_'.strtolower($model_name).'}}')){
					// Create suggest table
					$db = Yii::app()->db->createCommand();
					$db->createTable('{{suggest_'.strtolower($model_name).'}}', array(
					    'id' => 'int(11) AUTO_INCREMENT',
					    'id' => 'pk',
						strtolower($model_name).'_id'=>'int(11) NOT NULL',
						'to_'.strtolower($model_name).'_id'=>'int(11) NOT NULL',
					), 
					'charset=utf8',
					'ENGINE=InnoDB');
				}
				else{
					Yii::app()->user->setFlash('error','CHÚ Ý: table "{{suggest_'.strtolower($model_name).'}}" đã tồn tại!!!');
					$this->render('createNewsModel',array('roles'=>$roles,'model_name'=>$model_name));
					return;
				}

				/*** Check type of Model Category ***/
				// If the model using the existed category
				if($model_category_type == 0)
					$model_category = $_POST['Model_category'];
				else{
					// If the model using the new category --> create new category
					$model_category = $model_name.'Category';
					$this->_createCategory($model_name.'Category', $model_translation);
				}

				// Replace sample with model name
				$search = array(
					'sample','Sample','SAMPLE','SAMPLe_TRANSLATE', 'SAMPLe_Category'
				);
				$replace = array(
					strtolower($model_name),$model_name,strtoupper($model_name),$model_translation,$model_category
				);
				
				// Create suggest model file
				$returned_model = file_get_contents($sample_dir.'/SuggestSample.php');
				$returned_model = str_replace($search,$replace,$returned_model);
				$fp = fopen($admin_dir.'/models/Suggest'.$model_name.'.php', 'w+');
				fputs($fp,$returned_model);
				fclose($fp);

				// Create Model file
				$returned_model = file_get_contents($sample_dir.'/Sample.php');
				$returned_model = str_replace($search,$replace,$returned_model);
				$fp = fopen($admin_dir.'/models/'.$model_name.'.php', 'w+');
				fputs($fp,$returned_model);
				fclose($fp);
	
				// Create Controller file
				$returned_controller = file_get_contents($sample_dir.'/SampleController.php');
				$returned_controller = str_replace($search,$replace,$returned_controller);
	
				// Split roles from Controller
				$list_roles = strstr($returned_controller, '/*ACCESSRULES*/');
				$end_role = strpos($list_roles, '/*!ACCESSRULES*/');
				$list_roles = substr($list_roles, 0, $end_role);

				$list_roles = explode(strtolower($model_name), $list_roles);
				$i = -1;
				foreach($list_roles as $role) {
					if($i >= 0) $roles[] = strtolower($model_name).substr($role, 0, strpos($role,"')"));
					$i++;
				}
	
				// create controller file and save
				$fp = fopen($admin_dir.'/controllers/'.$model_name.'Controller.php', 'w+');
				fputs($fp,$returned_controller);
				fclose($fp);
	
				/*** Create View folder ***/
				// Check folder exist
				if (!file_exists($admin_view_dir.strtolower($model_name))){
	                mkdir($admin_view_dir.strtolower($model_name));
	            }
	
				// Create View Index file
				$returned_index = file_get_contents($sample_dir.'/index.php');
				$returned_index = str_replace($search,$replace,$returned_index);
				$fp = fopen($admin_view_dir.strtolower($model_name).'/index.php', 'w+');
				fputs($fp,$returned_index);
				fclose($fp);
	
				// Create View Create file
				$returned_create = file_get_contents($sample_dir.'/create.php');
				$returned_create = str_replace($search,$replace,$returned_create);
				$fp = fopen($admin_view_dir.strtolower($model_name).'/create.php', 'w+');
				fputs($fp,$returned_create);
				fclose($fp);
	
				// Create View Update file
				$returned_update = file_get_contents($sample_dir.'/update.php');
				$returned_update = str_replace($search,$replace,$returned_update);
				$fp = fopen($admin_view_dir.strtolower($model_name).'/update.php', 'w+');
				fputs($fp,$returned_update);
				fclose($fp);
	
				// Create _list_suggest file
				$returned_update = file_get_contents($sample_dir.'/_list_suggest_sample.php');
				$returned_update = str_replace($search,$replace,$returned_update);
				$fp = fopen($admin_view_dir.strtolower($model_name).'/_list_suggest_'.strtolower($model_name).'.php', 'w+');
				fputs($fp,$returned_update);
				fclose($fp);
	
				// Create translate file
				$returned_update = file_get_contents($sample_dir.'/translate.php');
				$returned_update = str_replace($search,$replace,$returned_update);
				$fp = fopen($admin_dir.'messages/'.strtolower($model_name).'.php', 'w+');
				fputs($fp,$returned_update);
				fclose($fp);

				Yii::app()->user->setFlash('success',
					'Create model at "'.$admin_dir.'model/'.$model_name.'.php"<br />
					Create controller at "'.$admin_dir.'controller/'.$model_name.'Controller.php"<br />
					Create index, create, update view at "'.$admin_view_dir.'/'.Yii::app()->params['admin_lang'].'/'.strtolower($model_name).'/"<br />'
				);
			}
			else {
				Yii::app()->user->setFlash('error', 'Tên model và model translation không được rỗng!');
			}
		}
		
		/* Create new role operation */

		if(isset($_POST['Role'])){
			$check = 0; //$check to verify all save are successful
			foreach ($_POST['Role'] as $index_ => $role_) {
				$criteria=new CDbCriteria();
				$criteria->compare('name',$role_);
				$criteria->compare('type',CAuthItem::TYPE_OPERATION);
				$tmp=AuthItem::model()->find($criteria);
				if(!isset($tmp)){
					$tmp=new AuthItem();
					$tmp->name = $role_;
					$tmp->type=CAuthItem::TYPE_OPERATION;
					if(!$tmp->save()){ $check = 1;}
				}
			}
			if($check == 0){
				Yii::app()->user->setFlash('success','Create role: '.implode(", ", $_POST['Role']).' for category '.$_POST['Role_category']);
			}
		}

		$this->render('createNewsModel',array('roles'=>$roles,'model_name'=>$model_name));
	}

	/**
	 * Action Creates a Category model.
	 */
	public function actioncreateCategoryModel()
	{
		include_once('simple_html_dom.php');
        $basepath = realpath(Yii::app()->basePath.'/../');
		$admin_dir = $basepath.'/protected/modules/admin/';
		$admin_view_dir = $basepath.'/themes/admin/views/';
		$sample_dir = $basepath.'/protected/modules/dev/sample/category/';
		$roles = array();
		if(!isset($model_name)) $model_name = '';
		if (isset($_POST['Model_name']) && isset($_POST['Model_translation'])) {
			if($_POST['Model_name'] !='' && $_POST['Model_translation'] != ''){
				$model_name = $_POST['Model_name'];
				$model_translation = $_POST['Model_translation'];
				// Replace sample with model name
				$search = array(
					'sample','Sample','SAMPLE','SAMPLe_TRANSLATE',
				);
				$replace = array(
					lcfirst($model_name),$model_name,strtoupper($model_name),$model_translation,
				);
	
				// Create Model file
				$returned_model = file_get_contents($sample_dir.'/Sample.php');
				$returned_model = str_replace($search,$replace,$returned_model);
				$fp = fopen($admin_dir.'/models/'.$model_name.'.php', 'w+');
				fputs($fp,$returned_model);
				fclose($fp);
	
				// Create Controller file
				$returned_controller = file_get_contents($sample_dir.'/SampleController.php');
				$returned_controller = str_replace($search,$replace,$returned_controller);
	
				// Split roles from Controller
				$list_roles = strstr($returned_controller, '/*ACCESSRULES*/');
				$end_role = strpos($list_roles, '/*!ACCESSRULES*/');
				$list_roles = substr($list_roles, 0, $end_role);

				$list_roles = explode(lcfirst($model_name), $list_roles);
				$i = -1;
				foreach($list_roles as $role) {
					if($i >= 0) $roles[] = lcfirst($model_name).substr($role, 0, strpos($role,"')"));
					$i++;
				}
	
				// create controller file and save
				$fp = fopen($admin_dir.'/controllers/'.$model_name.'Controller.php', 'w+');
				fputs($fp,$returned_controller);
				fclose($fp);
	
				/*** Create View folder ***/
				// Check folder exist
				if (!file_exists($admin_view_dir.lcfirst($model_name))){
	                mkdir($admin_view_dir.lcfirst($model_name));
	            }
	
				// Create View _form file
				$returned_index = file_get_contents($sample_dir.'/_form.php');
				$returned_index = str_replace($search,$replace,$returned_index);
				$fp = fopen($admin_view_dir.lcfirst($model_name).'/_form.php', 'w+');
				fputs($fp,$returned_index);
				fclose($fp);
	
				// Create View _tree file
				$returned_create = file_get_contents($sample_dir.'/_tree.php');
				$returned_create = str_replace($search,$replace,$returned_create);
				$fp = fopen($admin_view_dir.lcfirst($model_name).'/_tree.php', 'w+');
				fputs($fp,$returned_create);
				fclose($fp);
	
				// Create View index file
				$returned_update = file_get_contents($sample_dir.'/index.php');
				$returned_update = str_replace($search,$replace,$returned_update);
				$fp = fopen($admin_view_dir.lcfirst($model_name).'/index.php', 'w+');
				fputs($fp,$returned_update);
				fclose($fp);

				// Create translate file
				$returned_update = file_get_contents($sample_dir.'/translate.php');
				$returned_update = str_replace($search,$replace,$returned_update);
				$fp = fopen($admin_dir.'messages/'.lcfirst($model_name).'.php', 'w+');
				fputs($fp,$returned_update);
				fclose($fp);

				Yii::app()->user->setFlash('success',
					'Create model at "'.$admin_dir.'model/'.$model_name.'.php"<br />
					Create controller at "'.$admin_dir.'controller/'.$model_name.'Controller.php"<br />
					Create index, create, update view at "'.$admin_view_dir.'/'.strtolower($model_name).'/"<br />'
					);
			}
			else {
				Yii::app()->user->setFlash('error', 'Tên Category và translation không được rỗng!');
			}
		}
		/* Create new role category operation */
		if(isset($_POST['Role'])){
			$check = 0; //$check to verify all save are successful
			foreach ($_POST['Role'] as $index_ => $role_) {
				$criteria=new CDbCriteria();
				$criteria->compare('name',$role_);
				$criteria->compare('type',CAuthItem::TYPE_OPERATION);
				$tmp=AuthItem::model()->find($criteria);
				if(!isset($tmp)){
					$tmp=new AuthItem();
					$tmp->name = $role_;
					$tmp->type=CAuthItem::TYPE_OPERATION;
					if(!$tmp->save()){ $check = 1;}
				}
			}
			if($check == 0){
				Yii::app()->user->setFlash('success','Create role: '.implode(", ", $_POST['Role']).' for category '.$_POST['Role_category']);
			}
		}
		$this->render('createCategoryModel',array('roles'=>$roles,'model_name'=>$model_name));
	}

	/**
	 * Internal function Creates a Category model.
	 */
	public function _createCategory($model_name,$model_translation)
	{
		include_once('simple_html_dom.php');
        $basepath = realpath(Yii::app()->basePath.'/../');
		$admin_dir = $basepath.'/protected/modules/admin/';
		$admin_view_dir = $basepath.'/themes/admin/views/';
		$sample_dir = $basepath.'/protected/modules/dev/sample/category/';
		$roles = array();

		if($model_name !='' && $model_translation != ''){
			// Replace sample with model name
			$search = array(
				'sample','Sample','SAMPLE','SAMPLe_TRANSLATE',
			);
			$replace = array(
				lcfirst($model_name),$model_name,strtoupper($model_name),$model_translation,
			);

			// Create Model file
			$returned_model = file_get_contents($sample_dir.'/Sample.php');
			$returned_model = str_replace($search,$replace,$returned_model);
			$fp = fopen($admin_dir.'models/'.$model_name.'.php', 'w+');
			fputs($fp,$returned_model);
			fclose($fp);

			// Create Controller file
			$returned_controller = file_get_contents($sample_dir.'/SampleController.php');
			$returned_controller = str_replace($search,$replace,$returned_controller);

			// Split roles from Controller
			$list_roles = strstr($returned_controller, '/*ACCESSRULES*/');
			$end_role = strpos($list_roles, '/*!ACCESSRULES*/');
			$list_roles = substr($list_roles, 0, $end_role);

			$list_roles = explode(lcfirst($model_name), $list_roles);
			$i = -1;
			foreach($list_roles as $role) {
				if($i >= 0) $roles[] = lcfirst($model_name).substr($role, 0, strpos($role,"')"));
				$i++;
			}

			// create controller file and save
			$fp = fopen($admin_dir.'/controllers/'.$model_name.'Controller.php', 'w+');
			fputs($fp,$returned_controller);
			fclose($fp);

			/*** Create View folder ***/
			// Check folder exist
			if (!file_exists($admin_view_dir.lcfirst($model_name))){
                mkdir($admin_view_dir.lcfirst($model_name));
            }

			// Create View _form file
			$returned_index = file_get_contents($sample_dir.'/_form.php');
			$returned_index = str_replace($search,$replace,$returned_index);
			$fp = fopen($admin_view_dir.lcfirst($model_name).'/_form.php', 'w+');
			fputs($fp,$returned_index);
			fclose($fp);

			// Create View _tree file
			$returned_create = file_get_contents($sample_dir.'/_tree.php');
			$returned_create = str_replace($search,$replace,$returned_create);
			$fp = fopen($admin_view_dir.lcfirst($model_name).'/_tree.php', 'w+');
			fputs($fp,$returned_create);
			fclose($fp);

			// Create View index file
			$returned_update = file_get_contents($sample_dir.'/index.php');
			$returned_update = str_replace($search,$replace,$returned_update);
			$fp = fopen($admin_view_dir.lcfirst($model_name).'/index.php', 'w+');
			fputs($fp,$returned_update);
			fclose($fp);

			// Create translate file
			$returned_update = file_get_contents($sample_dir.'/translate.php');
			$returned_update = str_replace($search,$replace,$returned_update);
			$fp = fopen($admin_dir.'messages/'.lcfirst($model_name).'.php', 'w+');
			fputs($fp,$returned_update);
			fclose($fp);

			/* Create new role category operation */
			$check = 0; //$check to verify all save are successful
			foreach ($roles as $index_ => $role_) {
				$criteria=new CDbCriteria();
				$criteria->compare('name',$role_);
				$criteria->compare('type',CAuthItem::TYPE_OPERATION);
				$tmp=AuthItem::model()->find($criteria);
				if(!isset($tmp)){
					$tmp=new AuthItem();
					$tmp->name = $role_;
					$tmp->type=CAuthItem::TYPE_OPERATION;
					if(!$tmp->save()){ $check = 1;}
				}
			}
		}
		else {
			Yii::app()->user->setFlash('error', 'Tên Category và translation không được rỗng!');
		}
	}
}