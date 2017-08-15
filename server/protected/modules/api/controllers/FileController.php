<?php

class FileController extends Controller{
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
				//'roles'=>array('AMP Master Admin'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionGetAll(){
		$data= FileService::data();
		$result= FileService::getAll($data);
		$this->returnJson($result);
	}

	public function actionGetFilesOfEmailTemplate(){
		$data= FileService::data();
		$result= FileService::getFilesOfEmailTemplate($data);
		$this->returnJson($result);
	}

	public function actionGetFilesByIds(){
		$data= FileService::data();
		$result= FileService::getFilesByIds($data);
		$this->returnJson($result);
	}

	public function actionGetFileById(){
		$data= FileService::data();
		$result= FileService::getFileById($data);
		$this->returnJson($result);
	}

	public function actionUpload(){
		$result = array();
		if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])){
			$result['success'] = false;
			$result['message'] = 'Invalid parameters.';
			echo json_encode($result);
			Yii::app()->end();
		}

		//Check $_FILES['file']['error'] value.
	    switch ($_FILES['file']['error']) {
	        case UPLOAD_ERR_OK:
	            break;
	        case UPLOAD_ERR_NO_FILE:
				$result['success'] = false;
				$result['message'] = 'No file sent.';
				echo json_encode($result);
				Yii::app()->end();

	        case UPLOAD_ERR_INI_SIZE:
	        case UPLOAD_ERR_FORM_SIZE:
				$result['success'] = false;
				$result['message'] = 'Exceeded filesize limit.';
				echo json_encode($result);
				Yii::app()->end();

	        default:
				$result['success'] = false;
				$result['message'] = 'Unknown errors.';
				echo json_encode($result);
				Yii::app()->end();
	    }

	    // You should also check filesize here.
	    if ($_FILES['file']['size'] > 2000000) {
			$result['success'] = false;
			$result['message'] = 'Exceeded filesize limit.<br> Maximum upload file size 2MB.';
			echo json_encode($result);
			Yii::app()->end();
	    }

	    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
	    // Check MIME Type by yourself.
	    /** only for >= PHP 5.3
	    $finfo = new finfo(FILEINFO_MIME_TYPE);
	    if (false === $ext = array_search(
	        $finfo->file($_FILES['file']['tmp_name']),
	        array(
	            'jpg' => 'image/jpeg',
	            'png' => 'image/png',
	            'gif' => 'image/gif',
	        ), true)){
			$result['success'] = false;
			$result['message'] = 'Invalid file format.';
			echo json_encode($result);
			Yii::app()->end();
	    }
		*/
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

	    // Check file type and get prefix
	    $prefix = '';
	    if(isset($_POST['file_cat_id'])){
	    	$category = FileCategory::model()->findByPk($_POST['file_cat_id']);
	    	if(isset($category))
	    		$prefix = $category->code.'_';
	    }
	    else
	    	$prefix = '';
		// Move upload files
		if(in_array($ext, array('jpg','png','gif'))) $type = 'image';
		else $type = 'other';

		$dir = 'data/upload/'.$type;
		$folder = FileService::createDir($dir);

		$org_filename = basename($_FILES['file']['name'],'.'.$ext);
		$filename = $prefix.$org_filename;

		if(file_exists($folder.'/'.$filename.'.'.$ext)){
			$i = 1;
			while(file_exists($folder.'/'.$filename.'.'.$ext)){
				$filename = $org_filename.'_'.$i;
				$i++;
			}
		}

	    if (!move_uploaded_file($_FILES['file']['tmp_name'], $folder.'/'.$filename.'.'.$ext)) {
			$result['success'] = false;
			$result['message'] = 'Failed to move uploaded file.';
			echo json_encode($result);
			Yii::app()->end();
	    }
		else{
			$file = new File();
			$file->filename = $filename;
			$file->extension = $ext;
			$file->dirname = $folder;
			$file->filesize = $_FILES['file']['size'];
			$file->cat_id = isset($_POST['file_cat_id'])?$_POST['file_cat_id']:0;
			$file->restricted = isset($_POST['file_restricted'])?1:0;

			if($file->save()){
				$result['success'] = true;
				$result['message'] = 'File is uploaded successfully.';
				$result['file'] = FileService::convertFile($file);
			}
			else{
				$result['success'] = false;
				$result['message'] = CHtml::errorSummary($file);
			}

			echo json_encode($result);
			Yii::app()->end();
		}

		$this->returnJson($result);
	}

	public function actionDeleteFileById(){
		$data= FileService::data();
		$result= FileService::DeleteFileById($data);
		$this->returnJson($result);
	}

	public function actionInit(){
		$list_category = FileCategory::model()->findAll();
		$result = FileCategoryService::convertListfileCategory($list_category);
		$this->returnJson($result);
	}

	public function actionPushFile($file){
		$file = urldecode($file);

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file, true);
		}
	}

	public function actionDownloadPdf(){
		$data= FileService::data();
		$result= FileService::downloadPdf($data);
		$this->returnJson($result);
	}
        
        public function actionDeleterelated(){
            $data= FileService::data();
            $result= FileService::deleteRelated($data);
            $this->returnJson($result);
        }
        
        public function actionClearfilerelated(){
            $storeRelateds = StoreFile::model()->findAll();
            foreach ($storeRelateds as $storeRelated) {
                $file = File::model()->findByPk($storeRelated->file_id);
                if(!$file){
                    $storeRelated->delete();
                }
            }
            $signageRelateds = SignageFile::model()->findAll();
            foreach ($signageRelateds as $signageRelated) {
                $file = File::model()->findByPk($signageRelated->file_id);
                if(!$file){
                    $signageRelated->delete();
                }
            }
            $fixtureRelateds = FixtureFile::model()->findAll();
            foreach ($fixtureRelateds as $fixtureRelated) {
                $file = File::model()->findByPk($fixtureRelated->file_id);
                if(!$file){
                    $fixtureRelated->delete();
                }
            }
            var_dump("ok"); exit;
        }
}
?>
