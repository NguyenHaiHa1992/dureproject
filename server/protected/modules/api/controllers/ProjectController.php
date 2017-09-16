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
                    'testpdf', 'importObject', 'downloadfile', 'showhtml', 'test','getProjectUpdateById'),
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
        $dataProductDev  = $data['productDevelopment'];
        $dataQa = $data['qa'];
        $transaction = Yii::app()->db->beginTransaction();

        try{
            $resultProject = ProjectService::create($dataProject);
            $resultProductDev = ['success' => false , 'message' => ""];
            // check if project create Success 
            if($resultProject['success']) {
                $success = true;
                $projectId = (int)$resultProject['id'];

                // create product Development model
                $dataProductDev['project_id'] = $projectId;

                $resultProductDev = ProductService::create($dataProductDev);
                if(!$resultProductDev) {
                     $success = false;
                }
                
                $resultQa = QaService::create($dataQa);
                $dataQa['project_id'] = $projectId;
                if(!$resultQa) {
                     $success = false;
                }
                // create any other model
                
                $transaction->commit();
            }
            $result = [
                'success' => $success,
                'project' => $resultProject,
                'productDevelopment' => $resultProductDev,
                'qa' => $resultQa,
            ];
        }catch(CException $e){
            $transaction->rollBack();
        }
        //
        $this->returnJson($result );
    }

    public function actionGetProjectById() {
        $data = ProjectService::data();
        $result = ProjectService::getProjectById($data);
        $this->returnJson($result);
    }

    public function actionGetProjectUpdateById(){
        $data = iPhoenixService::data();
        $resultProject = ProjectService::getProjectById($data);
        $resultProductDev = ProductService::getProductByProjectId($data);
        $resultQa = QaService::getQaByProjectId($data);
        $success = $resultProject['success'] && $resultProductDev['success'] && $resultQa['success'];
        $resutl = [
            'success' => $success,
            'project' => $resultProject,
            'productDevelopment' => $resultProductDev,
            'qa' => $resultQa,
        ];
        
        $this->returnJson($resutl);
    }

    public function actionUpdate() {
        $success = false;
        $data = iPhoenixService::data();
        
        $dataProject = $data['project'];
        $dataProductDev  = $data['productDevleopment'];
        $dataQa = $data['qa'];
        $projectId = (int)$dataProject['id'];
        if(!$dataProductDev['project_id']){
            $dataProductDev['project_id'] = $projectId;
        }
        
        if(!$dataQa['project_id']){
            $dataQa['project_id'] = $projectId;
        }
        
        $transaction = Yii::app()->db->beginTransaction();

        try{
            $resultProject = ProjectService::update($dataProject);

            if($resultProject['success']) {
                // update other model if project update success
                $success = true;
                $resultProductDev = ProductService::update($dataProductDev);
                if(!$resultProductDev['success']) {
                    $success = false;
                }
                
                $resultQa = QaService::update($dataQa);
                if(!$resultQa['success']) {
                    $success = false;
                }
                // update any other model
                
                $transaction->commit();
            }
            $result = [
                'success' => $success,
                'project' => $resultProject,
                'productDevelopment' => $resultProductDev,
                'qa' => $resultQa,
            ];
        }catch(CException $e){
            $transaction->rollBack();
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

    public function actionImportObject(){
            $data= ProjectService::data();
            $result= ObjectCommonService::importObject($data, "Project", "customer_number", "Project", "ProjectService");
            $this->returnJson($result);
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
}
