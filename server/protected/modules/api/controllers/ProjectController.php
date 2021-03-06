<?php

class ProjectController extends Controller {

    public function behaviors() {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelview.EExcelBehavior',
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
                'actions' => array('delete', 'copy'),
                'roles' => array('Super Admin'),
            ),
            array('allow',
                'actions' => array('create', 'update',
                    'createInit', 'detailInit', 'getAll', 'getEmptyProject',
                    'getEmptyProjectError', 'getProjectById', 'exportPdf',
                    'testpdf', 'importObject', 'downloadfile', 'showhtml', 'test', 'getProjectUpdateById'),
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
        $success = false;
        $data = ProjectService::data();
        $dataProject = $data['project'];
        $dataProductDev = $data['productDevelopment'];
        $dataQa = $data['qa'];
        $dataPackProduct = $data['packProduct'];
        $dataSale = $data['sale'];
        $dataProductAppr = $data['productApproval'];
        if(isset($_GET['export'])){
            $dataProject['export'] = $_GET['export'];
            $dataProductDev['project_id'] = $dataQa['project_id'] = $dataPackProduct['project_id'] = 
                   $dataSale['project_id'] = $dataProductAppr['project_id'] =  null;
        }
        $transaction = Yii::app()->db->beginTransaction();
        $result = ['sucess' => $success, 'message' => ""];
        try {
            $resultProject = ProjectService::create($dataProject);
            $resultProductDev = $resultQa = $resultPackProduct = $resultSale = $resultProductAppr = ['success' => false, 'message' => ""];
            // check if project create Success 
            $projectId = 1;
            if($resultProject['success']){
                $projectId = (int)$resultProject['id'];
                $dataProductDev['_is_save'] = $dataQa['_is_save'] 
                    = $dataPackProduct['_is_save'] = $dataSale['_is_save'] 
                    = $dataProductAppr['_is_save'] = true;
                
                $success = true;
            }
//            if($resultProject['success']) {
                // create product Development model
                $dataProductDev['project_id'] = $projectId;
                $resultProductDev = ProductService::create($dataProductDev);
                if (!$resultProductDev['success']) {
                    $success = false;
                }

                $dataQa['project_id'] = $projectId;
                $resultQa = QaService::create($dataQa);
                if (!$resultQa['success']) {
                    $success = false;
                }

                $dataPackProduct['project_id'] = $projectId;
                $resultPackProduct = PackProductService::create($dataPackProduct);

                $dataSale['project_id'] = $projectId;
                $resultSale = SaleService::create($dataSale);

                $dataProductAppr['project_id'] = $projectId;
                $resultProductAppr = ProductApprovalService::create($dataProductAppr);

                $success = $success && $resultProductDev['success'] && $resultQa['success'] && $resultPackProduct['success'] && $resultSale['success'] && $resultProductAppr['success'];
                // create any other model
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
//            }
            $result = [
                'success' => $success,
                'project' => $resultProject,
                'productDevelopment' => $resultProductDev,
                'qa' => $resultQa,
                'packProduct' => $resultPackProduct,
                'sale' => $resultSale,
                'productApproval' => $resultProductAppr,
            ];
        } catch (CException $e) {
            $result['message'] = $e->getMessage();
            $transaction->rollBack();
        }
        //
        $this->returnJson($result);
    }

    public function actionGetProjectById() {
        $data = ProjectService::data();
        $result = ProjectService::getProjectById($data);
        $this->returnJson($result);
    }

    public function actionGetProjectUpdateById() {
        $data = iPhoenixService::data();
        $resultProject = ProjectService::getProjectById($data);
        $resultProductDev = ProductService::getProductByProjectId($data);
        $resultQa = QaService::getQaByProjectId($data);
        $resultPackProduct = PackProductService::getPackProductByProjectId($data);
        $resultSale = SaleService::getSaleByProjectId($data);
        $resultProductAppr = ProductApprovalService::getProductApprovalByProjectId($data);

        $success = $resultProject['success'] && $resultProductDev['success'] && $resultQa['success'] && $resultPackProduct['success'] && $resultSale['success'] && $resultProductAppr['success'];
        $resutl = [
            'success' => $success,
            'project' => $resultProject,
            'productDevelopment' => $resultProductDev,
            'qa' => $resultQa,
            'packProduct' => $resultPackProduct,
            'sale' => $resultSale,
            'productApproval' => $resultProductAppr,
        ];

        $this->returnJson($resutl);
    }

    public function actionUpdate() {
        $success = false;
        $data = iPhoenixService::data();

        $dataProject = $data['project'];
        $dataProductDev = $data['productDevleopment'];
        $dataQa = $data['qa'];
        $dataPackProduct = $data['packProduct'];
        $dataSale = $data['sale'];
        $dataProductAppr = $data['productApproval'];

        $projectId = (int) $dataProject['id'];
        if (!$dataProductDev['project_id']) {
            $dataProductDev['project_id'] = $projectId;
        }

        if (!$dataQa['project_id']) {
            $dataQa['project_id'] = $projectId;
        }

        if (!$dataPackProduct['project_id']) {
            $dataPackProduct['project_id'] = $projectId;
        }

        if (!$dataSale['project_id']) {
            $dataSale['project_id'] = $projectId;
        }

        if (!$dataProductAppr['project_id']) {
            $dataProductAppr['project_id'] = $projectId;
        }
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $resultProject = ProjectService::update($dataProject);
            $isSave = false;
            if($resultProject['success']){
                $isSave = true;
                $projectId = (int)$resultProject['id'];
                $dataProductDev['_is_save'] = $dataQa['_is_save'] 
                    = $dataPackProduct['_is_save'] = $dataSale['_is_save'] 
                    = $dataProductAppr['_is_save'] = true;
                
                $success = true;
            }
//            if($resultProject['success']) {
                // update other model if project update success
                
                $resultProductDev = ProductService::update($dataProductDev);

                $resultQa = QaService::update($dataQa);

                $resultPackProduct = PackProductService::update($dataPackProduct);

                $resultSale = SaleService::update($dataSale);

                $resultProductAppr = ProductApprovalService::update($dataProductAppr);

                $success = $success && $resultProductDev['success'] && $resultQa['success'] && $resultPackProduct['success'] && $resultSale['success'] && $resultProductAppr['success'];
                // update any other model

                $transaction->commit();
//            }
            $result = [
                'success' => $success,
                'project' => $resultProject,
                'productDevelopment' => $resultProductDev,
                'qa' => $resultQa,
                'packProduct' => $resultPackProduct,
                'sale' => $resultSale,
                'productApproval' => $resultProductAppr,
            ];
        } catch (CException $e) {
            $transaction->rollBack();
            $result = ['success' => false, 'message' => $e->getMessage()];
        }

        $this->returnJson($result);
    }

    public function actionUpdateTableFilter() {
        $data = ProjectService::data();
        $result = ProjectService::update($data);
        $this->returnJson($result);
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

    public function actionImportObject() {
        $data = ProjectService::data();
        $result = ObjectCommonService::importObject($data, "Project", "customer_number", "Project", "ProjectService");
        $this->returnJson($result);
    }

    public function actionShowhtml($id) {
        $customer = Project::model()->findByPk($id);

        if (isset($customer)) {
            $customer_name_converted = preg_replace('/\s+/', '_', $customer->name);
            $pdf_file = 'STORE_' . $customer_name_converted . '_' . date('Ymd', $customer->created_time) . '_' . $customer->id;
            $check_file = $pdf_file;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $check_file . '.pdf')) {
                $check_file = $pdf_file . '_' . $i;
                $i++;
            }

            $pdf_file = $check_file;

            // Create content
            $content = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_customer_pdf_template.php', array(
                'customer' => $customer,
                    ), true, true);

            // Create pdf
            $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_pdf_template.php', array(
                'content' => $content,
                    ), true, true);
            echo $detail_pdf;
        } else {
            echo "No model";
        }
    }

    public function actionExportPdf($project_id) {
        // Project Info
        $project = Project::model()->findByAttributes(["id" => $project_id, "in_trash" => 0]);

        //  sale info
        $sale = Sale::model()->findByAttributes(["project_id" => $project_id, "in_trash" => 0]);

        // product Develope
        $productDev = ProductDevelopment::model()->findByAttributes(["project_id" => $project_id, "in_trash" => 0]);

        // Q/A
        $qa = Qa::model()->findByAttributes(["project_id" => $project_id, "in_trash" => 0]);

        // Note
        // product Approval
        $productAppr = ProductApproval::model()->findByAttributes(["project_id" => $project_id, "in_trash" => 0]);
        
        // pack Product 
        $packProduct = PackProduction::model()->findByAttributes(["project_id" => $project_id, "in_trash" => 0]);
        // photo and document

        $pdf_file = 'EXPORT_' . date('Ymd', $project->created_time) . '_' . $project->id;
        $check_file = $pdf_file;
        $i = 1;
        while (file_exists(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $check_file . '.pdf')) {
            $check_file = $pdf_file . '_' . $i;
            $i++;
        }

        $pdf_file = $check_file;
        
        $projectService = $project->service;

        // Create content
        $projectContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_project_pdf.php',
                array(
                    'project' => $project,
                )
                ,true , true);
        
        
        $saleContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_sale_pdf.php',
                array(
                    'sale' => $sale,
                    'projectService' => $projectService,
                )
                ,true , true);
        
        $productDevContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_productDev_pdf.php',
                array(
                    'productDev' => $productDev,
                    'projectService' => $projectService,
                )
                ,true , true);
        $qaContent = "";
        $productApprContent = "";
        
        $qaContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_qa_pdf.php',
                array(
                    'qa' => $qa,
                    'projectService' => $projectService,
                )
                ,true , true);
        
        $packProductContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_packProduct_pdf.php',
                array(
                    'packProduct' => $packProduct,
                    'projectService' => $projectService,
                )
                ,true, true);
        
        $productApprContent = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/_productAppr_pdf.php',
                array(
                    'productAppr' => $productAppr,
                )
                ,true , true);
        
        $css = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . 
                            '/protected/modules/api/views/email/style.php', true, true);
        $content = $projectContent . "<br />" . $saleContent . "<br />" . $productDevContent . "<br />" . $qaContent . "<br />" . $packProductContent . "<br />" . $productApprContent."<br />" . $css;
        
        // Create pdf
        $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_pdf_template.php', array(
            'content' => $content,
                ), true, true);
//        echo $detail_pdf;
//        exit;
        iPhoenixUrl::exportPdfFromHTML($detail_pdf, $pdf_file, 'portrait');

        echo json_encode([
            'success' => true,
            'result' => [
                'dirname' => 'data/pdf',
                'extension' => 'pdf',
                'file_absolute_url' => Yii::app()->getBaseUrl(true) . '/data/pdf/' . $pdf_file . '.pdf',
                'file_name' => $pdf_file,
                'file_url' => Yii::app()->baseUrl . '/data/pdf/' . $pdf_file . '.pdf',
            ]
        ]);
    }

    
    public function actionExportExcel(){
        $data = ProjectService::data();

        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        if(isset($_GET['type']) && $_GET['type'] == 'pdf'){
            $type = 'PDF';
        }
        
        $columns = [];
        if(isset($data['ExportExcelColumn'])){
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
        }
        else{
            $columns = [
                'project_name', 'project_number', 'primary_contact',
                ['header' => 'Date', 'value' => '$data->date ? date("Y-m-d", $data->date) : "-"'],
                ['header' => 'Company', 'value' => 'isset($data->customer_id) ? $data->customer->ship_address : "-"'],
                'volume', 'price_point', 
                ['header' => 'note', 'type' => 'raw', 'value' => '$data->note']
            ];
        }

        $criteria = new CDbCriteria();
        if(isset($_GET['ids']) && $_GET['ids']){
            $criteria->compare('id', explode(",", $_GET['ids']));
        }
        else{
            $searchAttributes = ProjectService::searchAttributes();
            foreach($searchAttributes as $searchAttribute){
                if (isset($_GET[$searchAttribute]) && $_GET[$searchAttribute] != '') {
                    $criteria->compare($searchAttribute, $_GET[$searchAttribute], true);
                }
            }
//            if(isset($_GET['signage_id']) && $_GET['signage_id'] != ''){
//                $criteria->join = 'INNER JOIN tbl_store_signage AS ss ON t.id = ss.store_id AND ss.signage_id = '.$_GET['signage_id'];
//            }
//            if(isset($_GET['fixture_id']) && $_GET['fixture_id'] != ''){
//                $criteria->join = 'INNER JOIN tbl_store_fixture AS sf ON t.id = sf.store_id AND sf.fixture_id = '.$_GET['fixture_id'];
//            }
        }
        $criteria->compare('t.in_trash', 0);
        $model = Project::model()->findAll($criteria);
        $name = 'Export_Project_DB';
//        if(isset($_GET['related_name']) && $_GET['related_name'] != ''){
//            $name = 'Related_Stores_of_'.  preg_replace("/[^a-zA-Z0-9\-\_]/", "", $_GET['related_name']);
//        }
        
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
}
