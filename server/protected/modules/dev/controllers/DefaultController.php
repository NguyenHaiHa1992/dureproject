<?php

class DefaultController extends CController
{
	public $layout='main';

	public function getPageTitle()
	{
		if($this->action->id==='index')
			return 'Gii: a Web-based code generator for Yii';
		else
			return 'Gii - '.ucfirst($this->action->id).' Generator';
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=Yii::createComponent('dev.models.LoginForm');
		$this->layout = 'board';
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('dev/default/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->createUrl('dev/default/index'));
	}

	/**
	 *  Action for iphoenix gii
	 */

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
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateModel()
	{
		include('simple_html_dom.php');
        $basepath = realpath(Yii::app()->basePath.'/../');
		$admin_dir = $basepath.'/protected/modules/admin/';
		$sample_dir = $basepath.'/protected/modules/sample/';
		$roles = array();
		if(!isset($model_name)) $model_name = '';
		if (isset($_POST['Model_name']) && isset($_POST['Model_translation'])) {
			$model_name = $_POST['Model_name'];
			$model_translation = $_POST['Model_translation'];

			// Replace sample with model name
			$search = array(
				'sample','Sample','SAMPLE','SAMPLe_TRANSLATE',
			);
			$replace = array(
				strtolower($model_name),$model_name,strtoupper($model_name),$model_translation,
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

			$list_roles = explode(strtolower($model_name), $list_roles);
			$i = -1;
			foreach($list_roles as $role) {
				if($i >= 0) $roles[] = strtolower($model_name).substr($role, 0, strpos($role,"')"));
				$i++;
			}

			// create controller
			$fp = fopen($admin_dir.'/controllers/'.$model_name.'Controller.php', 'w+');
			fputs($fp,$returned_controller);
			fclose($fp);

			// Create View folder
			if (!file_exists($admin_dir.'views/basic/'.strtolower($model_name))){
                mkdir($admin_dir.'views/basic/'.strtolower($model_name));
            }

			// Create View Index file
			$returned_index = file_get_contents($sample_dir.'/index.php');
			$returned_index = str_replace($search,$replace,$returned_index);
			$fp = fopen($admin_dir.'views/basic/'.strtolower($model_name).'/index.php', 'w+');
			fputs($fp,$returned_index);
			fclose($fp);

			// Create View Create file
			$returned_create = file_get_contents($sample_dir.'/create.php');
			$returned_create = str_replace($search,$replace,$returned_create);
			$fp = fopen($admin_dir.'views/basic/'.strtolower($model_name).'/create.php', 'w+');
			fputs($fp,$returned_create);
			fclose($fp);

			// Create View Update file
			$returned_update = file_get_contents($sample_dir.'/update.php');
			$returned_update = str_replace($search,$replace,$returned_update);
			$fp = fopen($admin_dir.'views/basic/'.strtolower($model_name).'/update.php', 'w+');
			fputs($fp,$returned_update);
			fclose($fp);

			// Create Order file
			copy($sample_dir.'sample.inc',$admin_dir.'runtime/'.strtolower($model_name).'.inc');
			Yii::app()->user->setFlash('success',
				'Create model at "'.$admin_dir.'model/'.$model_name.'.php"<br />
				Create controller at "'.$admin_dir.'controller/'.$model_name.'Controller.php"<br />
				Create index, create, update view at "'.$admin_dir.'view/basic/'.$model_name.'/"<br />'
				);
		}
		
		/* Create new role operation */
		if(isset($_POST['Role'])){
			$check = 0; //$check to verify all save are successful
			foreach ($_POST['Role'] as $index_ => $role_) {
				$model = new Role();
				$model->type = Role::TYPE_OPERATION;
				$model->name = $role_;
				$model->category = $_POST['Role_category'];
				$model->parent_id = 0;
				if(!$model->save()){ $check = 1;}
			}
			if($check == 0){
				Yii::app()->user->setFlash('success','Create role: '.implode(", ", $_POST['Role']).' for category '.$_POST['Role_category']);
			}
		}
		$this->render('createModel',array('roles'=>$roles,'model_name'=>$model_name));
	}
}