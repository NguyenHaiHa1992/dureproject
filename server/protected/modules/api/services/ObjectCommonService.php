<?php
/**
 * Description of ObjectCommonService
 *
 * @author hanguyenhai
 */
class ObjectCommonService extends iPhoenixService{
    public static function importObject($data, $modelName = "Store", $modelAttribute = "store_number", 
            $objectName = "Store", $objectService = "StoreService") {
        $result = array();
        if (!isset($data['uploaded_file']) || !isset($data['option'])) {
            return $result;
        }
        $path = $_FILES['uploaded_file']['name'];
        $file = $_FILES['uploaded_file']['tmp_name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $option = $data['option'];
        if ($ext != 'xls' && $ext != 'xlsx' && $ext != 'csv') {
            $result['success'] = false;
            $result['message'] = 'Wrong file format!';
            return $result;
        }
//            $filename = $_FILES["uploaded_file"]["tmp_name"];
        require_once(Yii::getPathOfAlias('ext.phpexcel') . '/Classes/PHPExcel.php');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $worksheet = $objPHPExcel->getActiveSheet();
//                $worksheetTitle = $worksheet->getTitle();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10 For all rows
//                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
//                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $list_error = array();
        $list_objects = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($worksheet->getCellByColumnAndRow(0, $row)->getValue() == null) {
                continue;
            }
            // Get value
            $storeValues = $modelName::getAttrsFromImport($worksheet, $row);

            // Validate unique heatnumber for this material
            $checkImport = self::checkImport($list_error, $storeValues, $row, $option, $modelAttribute, $modelName, $objectName);
            if(!$checkImport['success']){
                continue;
            }
            // Save record
            if($checkImport['object']){
                $object = $checkImport['object'];
            }
            else{
                $object = new $modelName;
            }
            $object->setAttributes($storeValues);
            $object = $objectService::beforeSave($object);
            if (!$object->save()) {
                $list_error[] = CHtml::errorSummary($object);
            }
            elseif($objectService == "StoreService"){
                $list_objects[] = $objectService::convertStore($object);
            }
            elseif($objectService == "SignageService"){
                $list_objects[] = $objectService::convertSignage($object);
            }
            elseif($objectService == "FixtureService"){
                $list_objects[] = $objectService::convertFixture($object);
            }
        }

        if (count($list_error)) {
            $result = array(
                'success' => false,
                'message' => '<b>List Excel Rows can not be imported:</b><br />' . implode('<br />', $list_error),
            );
        } 
        else {
            $result = array(
                'success' => true,
                'message' => 'Import finishes',
            );
        }
        $result['list_objects'] = $list_objects;
        return $result;
    }
    
    public static function checkImport(&$list_error, &$values, $row, $option, $attribute = "", 
            $modelName = "", $objectName = "Store"){
        $result = ['success' => false, 'object' => null];
        if(!$values || !is_array($values) || !$modelName){
            return $result;
        }
        $object = null;
        if($attribute && isset($values[$attribute])){
            $object = $modelName::model()->findByAttributes([
                $attribute => $values[$attribute]
            ]);
        }
        
        if(!$object && $option == "update"){
            $list_error[] = $objectName.' "' . $values[$attribute] . '" has not existed. Row #' . ($row - 1) . ' dismissed';
            return $result;
        }
        if($object && $option == "new"){
            $values[$attribute] .= "_IMPORT";
            $object = null;
        }
        $result['success'] = true;
        $result['object'] = $object;
        return $result;
    }
}
