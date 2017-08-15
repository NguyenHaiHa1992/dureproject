<?php

class SignageController extends Controller {
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
                'actions'=>array('create', 'update', 'delete', 'addRelatedSignage', 'removeRelatedSignage', 'addRelatedFixture', 'removeRelatedFixture', 'copy'),
                'roles'=>array('Super Admin'),
            ),
            array('allow',
                'actions'=>array('createInit', 'detailInit', 'getAll', 'getEmptySignage', 'getEmptySignageError', 
                    'getSignageById', 'exportExcel', 'exportPdf', 'exportExcelItem', 'importObject'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = SignageService::data();
        $result = SignageService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = SignageService::data();
        $result = SignageService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = SignageService::data();
        $result = SignageService::getAll($data);
        $catGenAll = SignageCatGenService::getAll();
        $result['general_categories'] = $catGenAll['categories'];
        $result['languages'] = (new Signage())->getLanguages();
        $this->returnJson($result);
    }

    public function actionGetEmptySignage() {
        $result = SignageService::getEmptySignage();
        $this->returnJson($result);
    }

    public function actionGetEmptySignageError() {
        $result = SignageService::getEmptySignageError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = SignageService::data();
        $result = SignageService::create($data);
        $this->returnJson($result);
    }

    public function actionGetSignageById() {
        $data = SignageService::data();
        $result = SignageService::getSignageById($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = SignageService::data();
        $result = SignageService::update($data);
        $this->returnJson($result);
    }

    public function actionAddRelatedSignage() {
        $data = SignageService::data();
        $result = SignageService::addRelatedSignage($data);
        $this->returnJson($result);
    }

    public function actionRemoveRelatedSignage() {
        $data = SignageService::data();
        $result = SignageService::removeRelatedSignage($data);
        $this->returnJson($result);
    }

    public function actionAddRelatedFixture() {
        $data = SignageService::data();
        $result = SignageService::addRelatedFixture($data);
        $this->returnJson($result);
    }

    public function actionRemoveRelatedFixture() {
        $data = SignageService::data();
        $result = SignageService::removeRelatedFixture($data);
        $this->returnJson($result);
    }

    public function actionExportExcel(){
        $data = SignageService::data();

        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        if (isset($_GET['type']) && $_GET['type'] == 'pdf') {
            $type = 'PDF';
        }
        
        $columns = [];
        foreach($data['ExportExcelColumn'] as $col => $val){
            if(!(int)$val){
                continue;
            }
            switch ($col){
                case 'category_name' :
                    $columns[] = [
                       'header' => 'Category',
                       'value' => 'isset($data->category) ? $data->category->name : "-"',
                    ];
                    break;

                case 'status_label' :
                    $columns[] = [
                       'header' => 'Category',
                       'value' => '$data->getStatusLabel()',
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
                case 'mounting':
                    $columns[] = [
                        'header' => 'Mounting',
                        'value' => '$data->getMountingLabel()',
                    ];
                    break;
                case 'changes_seasonally':
                    $columns[] = [
                        'header' => 'Changes Seasonally',
                        'value' => '$data->getChangesSeasonallyLabel()',
                    ];
                    break;
                case 'power_required':
                    $columns[] = [
                        'header' => 'Power Required',
                        'value' => '$data->getPowerRequiredLabel()',
                    ];
                    break;
                case 'language':
                    $columns[] = [
                        'header' => 'Language',
                        'value' => '$data->getLanguageLabel()',
                    ];
                    break;
                case CustomEnum::COLUMN_IMG.'image_id':
                    if($type == 'PDF'){
                        $columns[] = [
                            'header' => 'Image',
                            'type' => 'raw',
                            'value' => '(isset($data->image) && $data->image->getThumbUrl(80, 80, false))'
                                        . '? CHtml::image(CustomEnum::FILE_SERVER_PATH.$data->image->getThumbUrl(80, 80, false),"",array("style"=>"width:80px;height:80px;"))'
                                        . ': CHtml::image(CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE,"",array("style"=>"width:80px;height:80px;"))',
                        ];
                    }
                    else{
                        $columns[] = $col;
                    }
                    break;
                case CustomEnum::COLUMN_IMG.'example_image':
                    if($type == 'PDF'){
                        $columns[] = [
                            'header' => 'Example Image',
                            'type' => 'raw',
                            'value' => '(isset($data->exampleImage) && $data->exampleImage->getThumbUrl(80, 80, false))'
                                        . '? CHtml::image(CustomEnum::FILE_SERVER_PATH.$data->exampleImage->getThumbUrl(80, 80, false),"",array("style"=>"width:80px;height:80px;"))'
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
//            $criteria->condition = 'id IN ('+$_GET['ids']+')';
            $criteria->compare('id', explode(",", $_GET['ids']));
        }
        else{
            if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
                $criteria->compare('category_id', $_GET['category_id']);
            }
            if (isset($_GET['code']) && $_GET['code'] != '') {
                $criteria->compare('code', $data['code'], true);
            }
            if (isset($_GET['description']) && $_GET['description'] != '') {
                $criteria->compare('description', $_GET['description'], true);
            }
            if(isset($_GET['store_id']) && $_GET['store_id'] != ''){
                $criteria->join = 'INNER JOIN tbl_store_signage AS ss ON t.id = ss.signage_id AND ss.store_id = '.$_GET['store_id'];
            }
            if(isset($_GET['general_category_id']) && $_GET['general_category_id']){
                $criteria->join = "INNER JOIN tbl_signage_category AS sc ON sc.id=t.category_id AND sc.general_id=".$_GET['general_category_id'];
            }
        }
        $criteria->compare('t.in_trash', 0);
        $model = Signage::model()->findAll($criteria);

        $name = 'Export_Signage_DB';
        if(isset($_GET['related_name']) && $_GET['related_name'] != ''){
            $name = 'Related_Signages_of_'.  preg_replace("/[^a-zA-Z0-9\-\_]/", "", $_GET['related_name']);
        }
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Signage_DB',
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
        $signage = Signage::model()->findByPk($id);

        if(isset($signage)){
            $signage_name_converted = preg_replace('/\s+/', '_', $signage->code);
            $pdf_file = 'SIGNAGE_'.$signage_name_converted.'_'.date('Ymd', $signage->created_time).'_'.$signage->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
                $check_file = $pdf_file.'_'.$i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_signage_pdf_template.php', array(
                'signage' => $signage,
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
        $data = SignageService::data();
        $result = SignageService::delete($data);
        $this->returnJson($result);
    }
    
    public function actionCopy() {
        $data = SignageService::data();
        $result = SignageService::copy($data);
        $this->returnJson($result);
    }
    
    public function actionExportExcelItem($id){
        $signage = Signage::model()->findByPk($id);
        if(!$signage){
            $this->returnJson([
                'success' => false,
                'message' => 'Store is not found',
            ]);
        }
        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        
        $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'];
        $model = [];
        $nameFile = 'Export_Signage_'.$signage->code;
        $model[] = new SignagePdfItem("", $nameFile, "", "");
//        $model[] = new StorePdfItem("image||file:///F:/setup/xampp/htdocs/pmassetmanager/server/data/images/logo.png","","","");
        $newObjectPdfItem = new SignagePdfItem();
        $newObjectPdfItem->setInfo($model);
        $objectAttributes = SignagePdfItem::getListAttributes($id);
        $newObjectPdfItem->setObjectInfo($model, $objectAttributes);
        
        // Signage's fixture
        $relatedFixtures = $signage->getListRelatedFixture();
        $newObjectPdfItem->setRelatedFixtures($model, $relatedFixtures, "Signage's fixtures");
        
        // Signage's store 
        $relatedStores = $signage->getListRelatedStore();
        $newObjectPdfItem->setRelatedStores($model, $relatedStores, "Signage's stores");

        // store document
        $signageTmpFileIds = $signage->tmp_file_ids;
        $documentsTmp = FileService::getFilesByIds(['ids' => $signageTmpFileIds]);
        $documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
                ? $documentsTmp['files'] : array();
        $newObjectPdfItem->setDocuments($model, $documents, "Signage's documents");
        
        // signage note
        $note = $signage->note;
        if($note){
            $newObjectPdfItem->setSmt($model, "Note", $note, "Signage's note");
        }
        
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Signage_Item',
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
            $data= StoreService::data();
            $result= ObjectCommonService::importObject($data, "Signage", "code", "Signage", "SignageService");
            $this->returnJson($result);
    }
}
