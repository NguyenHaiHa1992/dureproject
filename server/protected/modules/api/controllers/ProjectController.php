<?php

class ProjectController extends Controller {
    public function behaviors()
    {
        return array(
            'eexcelview'=>array(
                'class'=>'ext.eexcelview.EExcelBehavior',
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('delete', 'copy'),
                'roles'=>array('Super Admin'),
            ),
            array('allow',
                'actions'=>array('create', 'update', 
                    'createInit', 'detailInit', 'getAll', 'getEmptyProject', 
                    'getEmptyProjectError', 'getProjectById', 'exportExcel', 'exportPdf', 'exportExcelItem', 
                    'testpdf', 'importObject', 'downloadfile', 'showhtml', 'test'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = ProjectService::data();
        $result = ProjectService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = ProjectService::data();
        $result = ProjectService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = ProjectService::data();
        $result = ProjectService::getAll($data);
        $this->returnJson($result);
    }

    public function actionGetEmptyProject() {
        $result = ProjectService::getEmptyProject();
        $this->returnJson($result);
    }

    public function actionGetEmptyProjectError() {
        $result = ProjectService::getEmptyProjectError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = ProjectService::data();
        $result = ProjectService::create($data);
        $this->returnJson($result);
    }

    public function actionGetProjectById() {
        $data = ProjectService::data();
        $result = ProjectService::getProjectById($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = ProjectService::data();
        $result = ProjectService::update($data);
        $this->returnJson($result);
    }

    public function actionUpdateTableFilter() {
        $data = ProjectService::data();
        $result = ProjectService::update($data);
        $this->returnJson($result);
    }

    public function actionExportExcel(){
        $data = ProjectService::data();

        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        if(isset($_GET['type']) && $_GET['type'] == 'pdf'){
            $type = 'PDF';
        }
        
        $columns = [];
        foreach($data['ExportExcelColumn'] as $col => $val){
            if(!(int)$val){
                continue;
            }
            switch ($col){
                case 'tier_name' :
                    $columns[] = [
                       'header' => 'Tier',
                       'value' => 'isset($data->tier) ? $data->tier->name : "-"',
                    ];
                    break;
                case '_no' :
                    if($type == 'PDF'){
                        $columns[] = [
                            'header' => 'No',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        ];
                    }
                    else{
                        $columns[] = $col;
                    }
                    break;
                case 'state_name' :
                    $columns[] = [
                       'header' => 'State/Province',
                       'value' => 'isset($data->state) ? $data->state->state_short : "-"',
                    ];
                    break;
                case CustomEnum::COLUMN_IMG.'image_id':
                    if($type == 'PDF'){
                        $columns[] = [
                            'header' => 'Image',
                            'type' => 'raw',
                            'value' => '(isset($data->image) && $data->image->getThumbUrl(80, 80, false))'
                                        . '? CHtml::image(CustomEnum::FILE_SERVER_PATH.$data->image->getThumbUrl(80, 80, false),"",array("style"=>"width:80px;height:80px;"))'
//                                        . '? echo \'<img src="\'.CustomEnum::FILE_SERVER_PATH.$data->image->getThumbUrl(80, 80, false).\'" />\''
                                        . ': CHtml::image(CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE,"",array("style"=>"width:80px;height:80px;"))',
                        ];
                    }
                    else{
                        $columns[] = $col;
                    }
                    break;
                default :
                    $columns[] = $col;
                    break;
            }
        }

        $criteria = new CDbCriteria();
        if(isset($_GET['ids']) && $_GET['ids']){
            $criteria->compare('id', explode(",", $_GET['ids']));
        }
        else{
            if (isset($_GET['tier_id']) && $_GET['tier_id'] != '') {
                $criteria->compare('tier_id', $_GET['tier_id']);
            }
            if (isset($_GET['name']) && $_GET['name'] != '') {
                $criteria->compare('name', $data['name'], true);
            }
            if (isset($_GET['city']) && $_GET['city'] != '') {
                $criteria->compare('city', $_GET['city'], true);
            }
            if (isset($_GET['email']) && $_GET['email'] != '') {
                $criteria->compare('email', $_GET['email'], true);
            }
            if(isset($_GET['signage_id']) && $_GET['signage_id'] != ''){
                $criteria->join = 'INNER JOIN tbl_customer_signage AS ss ON t.id = ss.customer_id AND ss.signage_id = '.$_GET['signage_id'];
            }
            if(isset($_GET['fixture_id']) && $_GET['fixture_id'] != ''){
                $criteria->join = 'INNER JOIN tbl_customer_fixture AS sf ON t.id = sf.customer_id AND sf.fixture_id = '.$_GET['fixture_id'];
            }
        }
        $criteria->compare('t.in_trash', 0);
        $model = Project::model()->findAll($criteria);
        
        $name = 'Export_Project_DB';
        if(isset($_GET['related_name']) && $_GET['related_name'] != ''){
            $name = 'Related_Projects_of_'.  preg_replace("/[^a-zA-Z0-9\-\_]/", "", $_GET['related_name']);
        }
        
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Project_DB',
            array(
                'creator' => 'NamNT',
            ),
            $type,
            'export',
            false,
            $name    
        );

        echo json_encode([
            'success' => true,
            'result' => $result
        ]);
    }
    
    public static function actionExportPdf($id){
        $customer = Project::model()->findByPk($id);

        if(isset($customer)){
            $customer_name_converted = preg_replace('/\s+/', '_', $customer->name);
            $pdf_file = 'STORE_'.$customer_name_converted.'_'.date('Ymd', $customer->created_time).'_'.$customer->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
                $check_file = $pdf_file.'_'.$i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_customer_pdf_template.php', array(
                'customer' => $customer,
            ),true, true);
            
            // Create pdf
            $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_pdf_template.php', array(
                'content' => $content,
            ),true, true);
            iPhoenixUrl::exportPdfFromHTML($detail_pdf, $pdf_file, 'portrait');

            echo json_encode([
                'success' => true,
                'result' => [
                    'dirname' => 'data/pdf',
                    'extension' => 'pdf',
                    'file_absolute_url' => Yii::app()->getBaseUrl(true).'/data/pdf/'.$pdf_file.'.pdf',
                    'file_name' => $pdf_file,
                    'file_url' => Yii::app()->baseUrl.'/data/pdf/'.$pdf_file.'.pdf',
                ]
            ]);
        }
    }
    
    public function actionDelete() {
        $data = ProjectService::data();
        $result = ProjectService::delete($data);
        $this->returnJson($result);
    }
    
    public function actionCopy() {
        $data = ProjectService::data();
        $result = ProjectService::copy($data);
        $this->returnJson($result);
    }
    
    public function actionExportExcelItem($id){
        $customer = Project::model()->findByPk($id);
        if(!$customer){
            $this->returnJson([
                'success' => false,
                'message' => 'Project is not found',
            ]);
        }
        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        
        $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $model = [];
        $nameFile = 'Export_Project_'.$customer->name;
        $model[] = new ProjectPdfItem("", $nameFile, "", "");
//        $model[] = new ProjectPdfItem("image||file:///F:/setup/xampp/htdocs/pmassetmanager/server/data/images/logo.png","","","");
        $newObjectPdfItem = new ProjectPdfItem();
        $newObjectPdfItem->setInfo($model);
        $objectAttributes = ProjectPdfItem::getListAttributes($id);
        $newObjectPdfItem->setObjectInfo($model, $objectAttributes);
        
        // Project's signage 
        $relatedSignages = $customer->getListSignage();
        $newObjectPdfItem->setRelatedSignages($model, $relatedSignages, "Project's signages");
        
        // Project's fixture 
        $relatedFixtures = $customer->getListFixture();
        $newObjectPdfItem->setRelatedFixtures($model, $relatedFixtures, "Project's fixtures");
        
        // customer document
        $customerTmpFileIds = $customer->tmp_file_ids;
        $documentsTmp = FileService::getFilesByIds(['ids' => $customerTmpFileIds]);
        $documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
                ? $documentsTmp['files'] : array();
        $newObjectPdfItem->setDocuments($model, $documents, "Project's documents");
        
        // customer note
        $note = $customer->note;
        if($note){
            $newObjectPdfItem->setSmt($model, "Note", $note, "Project's note");
        }
        
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Project_Item',
            array(
                'creator' => 'NamNT',
            ),
            $type,
            'export',
            false,
            $nameFile    
        );

        echo json_encode([
            'success' => true,
            'result' => $result
        ]);
    }

    public function actionImportObject(){
            $data= ProjectService::data();
            $result= ObjectCommonService::importObject($data, "Project", "customer_number", "Project", "ProjectService");
            $this->returnJson($result);
    }

    public function actionTestpdf(){
        $customer = Project::model()->findByPk(44);
        $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_customer_pdf_template.php', array(
            'customer' => $customer,
        ),true, true);

        // Create pdf
        $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_pdf_template.php', array(
            'content' => $content,
        ),true, true);
        echo($detail_pdf); exit;
    }
    
    public function actionDownloadfile($id){
        $fileModel = File::model()->findByPk($id);
        if($fileModel){
            $file = $fileModel->dirname."/".$fileModel->filename.".".$fileModel->extension;
            $name = $fileModel->filename.".".$fileModel->extension;
//            header("Cache-Control: public");
//            header("Content-Description: File Transfer");
//            header("Content-Disposition: attachment; filename=$name");
//            header("Content-Type: application/zip");
//            header("Content-Transfer-Encoding: binary");
//
//            // read the file from disk
//            readfile($file);
            Yii::app()->request->sendFile($name, @file_get_contents($file), 'application/zip', false);
        }
        echo "File is not found";
        exit;
    }
    
    public function actionShowhtml($id){
        $customer = Project::model()->findByPk($id);

        if(isset($customer)){
            $customer_name_converted = preg_replace('/\s+/', '_', $customer->name);
            $pdf_file = 'STORE_'.$customer_name_converted.'_'.date('Ymd', $customer->created_time).'_'.$customer->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
                $check_file = $pdf_file.'_'.$i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_customer_pdf_template.php', array(
                'customer' => $customer,
            ),true, true);
            
            // Create pdf
            $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_pdf_template.php', array(
                'content' => $content,
            ),true, true);
            echo $detail_pdf;
        }
        else{
            echo "No model";
        }
    }

    public function actionTest(){
        $a=array("red","green","blue","yellow","brown");
        print_r(array_slice($a,1,15));
    }
}
