<?php

class StoreSignageController extends Controller {
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
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionGetAll() {
        $data = StoreSignageService::data();
        $result = StoreSignageService::getAll($data);
        $this->returnJson($result);
    }

    public function actionUpdate() {
        $data = StoreSignageService::data();
        $result = StoreSignageService::update($data);
        $this->returnJson($result);
    }

    public function actionDelete() {
        $data = StoreSignageService::data();
        $result = StoreSignageService::delete($data);
        $this->returnJson($result);
    }
    
    public function actionInitStoreSignage(){
        $result = ['success' => true];
        $signageCategories = SignageCategoryService::getAll([]);
        $result['signage_categories'] = $signageCategories['signage_categories'];
        $general_categories = SignageCatGenService::getAll();
        $result['general_categories'] = $general_categories['categories'];
        $getTier = TierService::getAll([]);
        $result['tiers'] = $getTier['tiers'];
        $result['languages'] = (new Signage())->getLanguages();
        $this->returnJson($result);
    }
    
    public function actionGetStoreSignage(){
        $data= StoreService::data();
        $result= StoreSignageService::getStoreSignage($data);
        $this->returnJson($result);
    }
    
    public function actionExportExcel(){
        $data = SignageService::data();
        require_once(Yii::getPathOfAlias('ext.phpexcel.Classes') . '/PHPExcel.php');
        $type = 'Excel5';
        if (isset($_GET['type']) && $_GET['type'] == 'pdf') {
            $type = 'PDF';
        }
        if (isset($_GET['is_store']) && $_GET['is_store']) {
            $isStore = true;
            $exportExcelColumn = 'ExportExcelColumnStore';
        }
        else{
            $isStore = false;
            $exportExcelColumn = 'ExportExcelColumn';
        }
        $columns = [];
        foreach($data[$exportExcelColumn] as $col => $val){
            if(!(int)$val){
                continue;
            }
            $columns[] = $col;
        }
//        $columns = ['no', 'code', 'signage_quantity', 'store_name', 'store_number', 'tier_name', 'contact_name', 'franchisee_name'];
        $model = [];
        $nameFile = 'Export_Store_Signage';

        // NamNT add ngay 24/01/2017
        // Bo sung loc gia tri cua data day len
        if(isset($data['category_id']) && $data['category_id'] == 'null'){
            unset($data['category_id']);
        }
        elseif(isset($data['category_id'])){
            $data['category_id'] = (int)$data['category_id'];
        }
        if(isset($data['general_category_id']) && $data['general_category_id'] == 'null'){
            unset($data['general_category_id']);
        }
        elseif(isset($data['general_category_id'])){
            $data['general_category_id'] = (int)$data['general_category_id'];
        }

        $getStoreSignage = StoreSignageService::getStoreSignage($data, $isStore);
        if(!$getStoreSignage['success']){
            $this->returnJson([
                'success' => false,
                'message' => 'System error.',
            ]);
        }
        $signages = $getStoreSignage['signages'];
        $signageQuantityTotal = 0;
        $quantityTotalAll = 0;
        $signageCount = count($signages);
        $modelNewNoFileEmpty = new StoreSignagePdf();
        $modelNewNoFileEmpty->image_id = CustomEnum::IMAGE_NO_FILE;
        $modelNewNoFileEmpty->example_image = CustomEnum::IMAGE_NO_FILE;
        $attribute = $isStore ? 'store_name' : 'code';
        foreach ($signages as $sKey => $signages) {
            $modelNew = new StoreSignagePdf();
            $modelNew->setAttributes($signages, true);
            $modelNew->img__image_id = $signages['image_id'];
            $modelNew->img__example_image = $signages['example_image'];
            $modelNew->no = $sKey + 1;
            
            $c = count($model);
            
            if(($c > 0 && $modelNew->$attribute != $model[$c-1]->$attribute)){
//                $model[] = new StoreSignagePdf();
//                $model[] = new StoreSignagePdf("", "NAME OF SIGN", $model[$c-1]->code);
                $modelNewNoFile = self::setItemTotal($model[$c-1], $signageQuantityTotal, $isStore);
                $modelNewNoFile->image_id = CustomEnum::IMAGE_NO_FILE;
                $modelNewNoFile->example_image = CustomEnum::IMAGE_NO_FILE;
                $model[] = $modelNewNoFile;
                $model[] = $modelNewNoFileEmpty;
                $signageQuantityTotal = 0;
            }
            $model[] = $modelNew;
            $signageQuantityTotal += (int)$modelNew->signage_quantity;
            if($signageCount == ($sKey + 1)){
                $modelNewNoFile = self::setItemTotal($model[$c-1], $signageQuantityTotal, $isStore);
                $modelNewNoFile->image_id = CustomEnum::IMAGE_NO_FILE;
                $modelNewNoFile->example_image = CustomEnum::IMAGE_NO_FILE;
                $model[] = $modelNewNoFile;
                $model[] = $modelNewNoFileEmpty;
            }
            $quantityTotalAll += (int)$modelNew->signage_quantity;
        }
        $model[] = $modelNewNoFileEmpty;
        $model[] = $modelNewNoFileEmpty;
        $modelNewNoFile = self::setTotal($quantityTotalAll, $isStore);
        $modelNewNoFile->image_id = CustomEnum::IMAGE_NO_FILE;
        $modelNewNoFile->example_image = CustomEnum::IMAGE_NO_FILE;
        $model[] = $modelNewNoFile;
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
    
    public static function setItemTotal($model, $total, $isStore = false){
        if(!$isStore){
            return new StoreSignagePdf("", "", "", $model->code, "", "TOTAL QUANTITY NEEDED", "", $total);
        }
        else{
            return new StoreSignagePdf("", "", "", "", "", $model->store_name, "TOTAL QUANTITY NEEDED", $total);
        }
    }
    
    public static function setTotal($total, $isStore = false){
        if(!$isStore){
            return new StoreSignagePdf("", "", "", "", "", "TOTAL QUANTITY NEEDED", "", $total);
        }
        else{
            return new StoreSignagePdf("", "", "", "", "", "", "TOTAL QUANTITY NEEDED", $total);
        }
    }
}
