<?php

class FixtureController extends Controller {
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
                'actions'=>array('create', 'update', 'delete', 'addRelatedFixture', 'removeRelatedFixture', 'addRelatedSignage', 'removeRelatedSignage', 'exportExcel', 'copy'),
                'roles'=>array('Super Admin'),
            ),
            array('allow',
                'actions'=>array('createInit', 'detailInit', 'getAll', 'getEmptyFixture', 'getEmptyFixtureError', 
                    'getFixtureById', 'exportExcel', 'exportPdf', 'exportExcelItem', 'importObject'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateInit() {
        $data = FixtureService::data();
        $result = FixtureService::createInit($data);
        $this->returnJson($result);
    }

    public function actionDetailInit() {
        $data = FixtureService::data();
        $result = FixtureService::detailInit($data);
        $this->returnJson($result);
    }

    public function actionGetAll() {
        $data = FixtureService::data();
        $result = FixtureService::getAll($data);
        $catGenAll = FixtureCatGenService::getAll();
        $result['general_categories'] = $catGenAll['categories'];
        $this->returnJson($result);
    }

    public function actionGetEmptyFixture() {
        $result = FixtureService::getEmptyFixture();
        $this->returnJson($result);
    }

    public function actionGetEmptyFixtureError() {
        $result = FixtureService::getEmptyFixtureError();
        $this->returnJson($result);
    }

    public function actionCreate() {
        $data = FixtureService::data();
        $result = FixtureService::create($data);
        $this->returnJson($result);
    }

    public function actionGetFixtureById() {
        $data = FixtureService::data();
        $result = FixtureService::getFixtureById($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = FixtureService::data();
        $result = FixtureService::update($data);
        $this->returnJson($result);
    }

    public function actionAddRelatedFixture() {
        $data = FixtureService::data();
        $result = FixtureService::addRelatedFixture($data);
        $this->returnJson($result);
    }

    public function actionRemoveRelatedFixture() {
        $data = FixtureService::data();
        $result = FixtureService::removeRelatedFixture($data);
        $this->returnJson($result);
    }

    public function actionAddRelatedSignage() {
        $data = FixtureService::data();
        $result = FixtureService::addRelatedSignage($data);
        $this->returnJson($result);
    }

    public function actionRemoveRelatedSignage() {
        $data = FixtureService::data();
        $result = FixtureService::removeRelatedSignage($data);
        $this->returnJson($result);
    }
    
    public function actionExportExcel(){
        $data = FixtureService::data();

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
                default :
                    $columns[] = $col;
            }
        }

        $criteria = new CDbCriteria();
        if(isset($_GET['ids']) && $_GET['ids']){
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
                $criteria->join = 'INNER JOIN tbl_store_fixture AS ss ON t.id = ss.fixture_id AND ss.store_id = '.$_GET['store_id'];
            }
        }
        $criteria->compare('t.in_trash', 0);
        $model = Fixture::model()->findAll($criteria);
        
        $name = 'Export_Fixture_DB';
        if(isset($_GET['related_name']) && $_GET['related_name'] != ''){
            $name = 'Related_Fixtures_of_'.  preg_replace("/[^a-zA-Z0-9\-\_]/", "", $_GET['related_name']);
        }
        
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Fixture_DB',
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
        $fixture = Fixture::model()->findByPk($id);

        if(isset($fixture)){
            $fixture_name_converted = preg_replace('/\s+/', '_', $fixture->code);
            $pdf_file = 'FIXTURE_'.$fixture_name_converted.'_'.date('Ymd', $fixture->created_time).'_'.$fixture->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot').'/data/pdf/'.$check_file.'.pdf')) {
                $check_file = $pdf_file.'_'.$i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot').'/protected/modules/api/views/email/_fixture_pdf_template.php', array(
                'fixture' => $fixture,
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
        $data = FixtureService::data();
        $result = FixtureService::delete($data);
        $this->returnJson($result);
    }
    
    public function actionCopy() {
        $data = FixtureService::data();
        $result = FixtureService::copy($data);
        $this->returnJson($result);
    }
    
    public function actionExportExcelItem($id){
        $fixture = Fixture::model()->findByPk($id);
        if(!$fixture){
            $this->returnJson([
                'success' => false,
                'message' => 'Store is not found',
            ]);
        }
        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        
        $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $model = [];
        $nameFile = 'Export_Fixture_'.$fixture->code;
        $model[] = new FixturePdfItem("", $nameFile, "", "");
//        $model[] = new StorePdfItem("image||file:///F:/setup/xampp/htdocs/pmassetmanager/server/data/images/logo.png","","","");
        $newObjectPdfItem = new FixturePdfItem();
        $newObjectPdfItem->setInfo($model);
        $objectAttributes = FixturePdfItem::getListAttributes($id);
        $newObjectPdfItem->setObjectInfo($model, $objectAttributes);
        
        // Fixture's signage
        $relatedSignages = $fixture->getListRelatedSignage();
        $newObjectPdfItem->setRelatedSignages($model, $relatedSignages, "Fixture's signages");
        
        // Signage's store 
        $relatedStores = $fixture->getListRelatedStore();
        $newObjectPdfItem->setRelatedStores($model, $relatedStores, "Fixture's stores");

        // store document
        $fixtureTmpFileIds = $fixture->tmp_file_ids;
        $documentsTmp = FileService::getFilesByIds(['ids' => $fixtureTmpFileIds]);
        $documents = isset($documentsTmp['success']) && $documentsTmp['success'] && isset($documentsTmp['files'])
                ? $documentsTmp['files'] : array();
        $newObjectPdfItem->setDocuments($model, $documents, "Fixture's documents");
        
        // fixture note
        $note = $fixture->note;
        if($note){
            $newObjectPdfItem->setSmt($model, "Note", $note, "Fixture's note");
        }
        
        // Export it
        $result = $this->toExcel($model,
            $columns,
            'Export_Fixture_Item',
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
            $data= FixtureService::data();
            $result= ObjectCommonService::importObject($data, "Fixture", "code", "Fixture", "FixtureService");
            $this->returnJson($result);
    }
}
