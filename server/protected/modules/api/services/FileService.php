<?php

class FileService extends iPhoenixService {

    public static function findByPk($id) {
        $file = File::model()->findByPk($id);
        return self::returnFile($file, true);
    }

    public static function countAll($data) {
        $criteria = new CDbCriteria();
        $filters = $data['filters'];
        foreach ($filters as $property => $filter) {
            if ($filter['value'] != '') {
                $criteria->compare($property, $filter['value'], true);
            }
        }
        return File::model()->count($criteria);
    }

    public static function findAll($data) {
        $criteria = new CDbCriteria();
        $filters = $data['filters'];
        foreach ($filters as $property => $filter) {
            if ($filter['value'] != '') {
                switch ($filter['operator']) {
                    case "EQUAL":
                        $criteria->compare($property, $filter['value']);
                        break;
                    case "CONTAINS":
                        $criteria->compare($property, $filter['value'], true);
                        break;
                }
            }
        }
        $total = File::model()->count($criteria);

        $orders = $data['orders'];
        $tmp_orders = array();
        foreach ($orders as $property => $value) {
            if ($value != '') {
                $tmp_orders[] = $property . ' ' . $value;
            }
        }
        $criteria->order = implode(',', $tmp_orders);

        $pages = new CPagination($total);
        $pages->setCurrentPage($data['currentPage'] - 1);
        $pages->setPageSize($data['pageSize']);
        $pages->applyLimit($criteria);  // the trick is here!
        $list_files = File::model()->findAll($criteria);
        $files = array();
        foreach ($list_files as $file) {
            $files[] = $file->convertArray();
        }
        return $files;
    }

    public static function getAll($data) {//data là thông tin phân trang
        $result = array();

        // Find category

        $check_category = false;
        if (isset($data['category_code']) && $data['category_code'] != '') {
            $criteria = new CDbCriteria();
            $criteria->compare('code', $data['category_code'], true);
            $category = FileCategory::model()->find($criteria);
            if (isset($category)) {
                $category_id = $category->id;
                $category_name = $category->name;
                $category_code = $category->code;
                $check_category = true;
            }
        }

        // Find files
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = count(File::model()->findAll());
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = ' Order By tbl_file.' . $data['sort_attribute'] . ' ' . $data['sort_type'];

        $sql = "Select tbl_file.* From tbl_file where 1";

        if ($check_category) {
            $sql = $sql . " And tbl_file.cat_id =" . $category_id;
        }

        if (isset($data['cat_id']) && $data['cat_id'] != '') {
            $sql = $sql . " And tbl_file.cat_id = " . $data['cat_id'] . " ";
        }
        if (isset($data['filename']) && $data['filename'] != '') {
            $sql = $sql . " And tbl_file.filename LIKE '%" . $data['filename'] . "%' ";
        }
        if (isset($data['restricted']) && $data['restricted'] != '') {
            $sql = $sql . " And tbl_file.restricted = " . $data['restricted'] . " ";
        }
        
        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
        $files = File::model()->findAllBySql($sql);

        $criteria = new CDbCriteria();
        if (isset($data['cat_id']) && $data['cat_id'] != '') {
            $criteria->compare('cat_id', $data['cat_id']);
        }
        if (isset($data['filename']) && $data['filename'] != '') {
            $criteria->compare('filename', $data['filename'], true);
        }
        if (isset($data['restricted']) && $data['restricted'] != '') {
            $criteria->compare('restricted', $data['restricted']);
        }
        
        $total = File::model()->count($criteria);

        if ($files != null) {
            $result['success'] = true;
            $result['files'] = self::convertListFile($files, $data);

            $result['totalresults'] = $total;
            $result['start_file'] = (int) $data['limitstart'] + 1;
            $result['end_file'] = (int) $data['limitstart'] + count($files);
        } else {
            $result['success'] = true;
            $result['files'] = array();
            $result['totalresults'] = $total;
            $result['start_file'] = 0;
            $result['end_file'] = 0;
        }

        if ($check_category) {
            $result['category_id'] = $category_id;
            $result['category_name'] = $category_name;
            $result['category_code'] = $category_code;
        }

        return $result;
    }

    public static function delete($id) {
        $file = File::model()->findByPk($id);
        return (isset($file) && $file->delete());
    }

    public static function create($data) {
        $file = new File();
        return self::save($file, $data);
    }

    public static function update($id, $data) {
        $file = File::model()->findByPk($id);
        if (isset($file)) {
            return self::save($file, $data);
        } else {
            return self::returnFile($file, false);
        }
    }

    public static function save($file, $data) {
        $file->attributes = $data;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if ($file->save()) {
                $transaction->commit();
                return self::returnFile($file, true);
            } else {
                $transaction->rollback();
                $file->addError("id", "Error create/update file");
                return self::returnFile($file, false);
            }
        } catch (Exception $e) {
            $transaction->rollback();
            $file->addError("id", "Error database");
            return self::returnFile($file, false);
        }
    }

    public static function returnFile($file, $status) {
        $result = array();
        if (isset($file)) {
            $result = $file->convertArray();
        }
        $result['success'] = $status;
        return $result;
    }

    /** Returns absolute path of the file
     * @return string absolute path.
     */
    public static function getAbsoluteDirname($id) {
        $file = File::model()->findByPk($id);
        return Yii::getPathOfAlias('webroot') . '/' . $file->dirname;
    }

    /** Returns relative path of the file
     * @return string relative path.
     */
    public static function getPath($id) {
        $file = File::model()->findByPk($id);
        return $file->dirname . '/' . $file->filename . '.' . $file->extension;
    }

    /** Returns absolute path of the file
     * @return string absolute path.
     */
    public static function getAbsolutePath($id) {
        $file = File::model()->findByPk($id);
        return self::getAbsoluteDirname($id) . '/' . $file->filename . '.' . $file->extension;
    }

    /** Returns relative url of the file
     * @return string relative url
     */
    public static function getUrl($id) {
        $file = File::model()->findByPk($id);
        return $file->dirname . '/' . $file->filename . '.' . $file->extension;
    }

    /** Returns absolute  url of the file
     * @return string absolute url
     */
    public static function getAbsoluteUrl($id) {
        $file = File::model()->findByPk($id);
        return Yii::app()->getBaseUrl(true) . '/' . $file->dirname . '/' . $file->filename . '.' . $file->extension;
    }

    /** Returns fullname of the file
     * @return fullname
     */
    public static function getFullname($id) {
        $file = File::model()->findByPk($id);
        return $file->filename . '.' . $file->extension;
    }

    /**
     * Copy file
     * @return File file
     */
    public static function create1($original_absolute_path, $dirname, $filename, $extension = null) {
        if (file_exists($original_absolute_path)) {
            $absolute_dirname = Yii::getPathOfAlias('webroot') . '/' . $dirname;
            if (!is_dir($absolute_dirname))
                return null;
            $path_parts = pathinfo($original_absolute_path);
            if (!isset($extension)) {
                if (isset($path_parts['extension']))
                    $extension = $path_parts['extension'];
                else
                    return null;
            }
            $absolute_path = $absolute_dirname . '/' . $filename . '.' . $extension;
            $index = 0;
            while (file_exists($absolute_path)) {
                $index++;
                $filename .= '_' . $index;
                $absolute_path = $absolute_dirname . '/' . $filename . '.' . $extension;
            }
            if (copy($original_absolute_path, $absolute_path)) {
                $file = new File();
                $file->dirname = $dirname;
                $file->extension = $extension;
                $file->filename = $filename;
                if ($file->save())
                    return $file;
                else
                    return null;
            } else
                return null;
        } else
            return null;
    }

    /**
     * Copy file
     * @return File file
     */
    public function copy($new_dirname = null, $new_filename = null) {
        $original_absolute_path = $this->getAbsolutePath();
        if (!isset($new_dirname))
            $new_dirname = $this->dirname;
        if (!isset($new_filename))
            $new_filename = $this->filename . '_copy';
        $copy_file = File::create($original_absolute_path, $new_dirname, $new_filename);
        return $copy_file;
    }

    /**
     * Rename file
     * @return boolean success or fail
     */
    public function rename($id, $new_filename) {
        $file = File::model()->findByPk($id);
        if ($file->filename == $new_filename)
            return true;

        $new_file = $file->getAbsoluteDirname() . '/' . $new_filename . '.' . $file->extension;
        if (file_exists($new_file))
            return false;

        $old_file = $file->getAbsolutePath();
        if (copy($old_file, $new_file)) {
            $file->filename = $new_filename;
            if ($file->save()) {
                unlink($old_file);
                return true;
            } else {
                unlink($new_file);
                return false;
            }
        } else
            return false;
    }

    /**
     * Move file to a new directory
     * @return boolean success or fail
     */
    public function move($id, $new_dirname) {
        $file = File::model()->findByPk($id);
        if ($file->dirname == $new_dirname)
            return true;

        if (!is_dir(Yii::getPathOfAlias('webroot') . '/' . $new_dirname))
            return false;

        $filename = $file->filename;
        $new_file = Yii::getPathOfAlias('webroot') . '/' . $new_dirname . '/' . $filename . '.' . $file->extension;

        while (file_exists($new_file)) {
            $filename .= '_copy';
            $new_file = Yii::getPathOfAlias('webroot') . '/' . $new_dirname . '/' . $filename . '.' . $file->extension;
        }

        $old_file = $file->getAbsolutePath();
        if (copy($old_file, $new_file)) {
            $file->filename = $filename;
            $file->dirname = $new_dirname;
            if ($file->save()) {
                unlink($old_file);
                return true;
            } else {
                unlink($new_file);
                return false;
            }
        } else
            return false;
    }

    /**
     * Create directory
     */
    static function createDir($dirname, $time = null) {
        $dir = $dirname;
        if ($time == null)
            $time = time();
        $dir .= '/' . date('Y', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        $dir .= '/' . date('m', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        $dir .= '/' . date('d', $time);
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/' . $dir)) {
            mkdir(Yii::getPathOfAlias('webroot') . '/' . $dir);
        }
        return $dir;
    }

    // New
    public static function getFilesByIds($data) {
        if (isset($data['ids'])) {
            $limitStart = isset($data['limitstart']) ? (int)$data['limitstart'] : 0;
            $limitNum = isset($data['limitnum']) ? (int)$data['limitnum'] : 10;
            $list_id_tmp = explode(',', $data['ids']);
            $list_id = array_slice($list_id_tmp, $limitStart, $limitNum);
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $list_id);
            if(isset($data['cat_id']) && $data['cat_id']){
                $criteria->compare('cat_id', $data['cat_id']);
            }
            if(isset($data['restricted'])){
                $criteria->compare('restricted', $data['restricted']);
            }
            if(isset($data['name']) && $data['name']){
                $criteria->addCondition("filename LIKE '%".$data['name']."%'");
//                $criteria->compare('filename', $data['name']);
            }
//            if (!Yii::app()->user->checkAccess('Super Admin')) {
//                $criteria->compare('restricted', 1);
//            }
//            $criteria->order = "created_time DESC";
            $list_file = File::model()->findAll($criteria);
            $result['success'] = false;
            if (sizeof($list_file) != 0) {
                $result['success'] = true;
                $result['files'] = self::convertListFile($list_file, $data);
                $result['totalresults'] = count($list_id_tmp);
                $result['start_file'] = $limitStart + 1;
                $result['end_file'] = $limitStart + count($list_id);
            }

            return $result;
        }
    }

    public static function getFileById($data) {
        if (isset($data['id'])) {
            $file = File::model()->findByPk($data['id']);
            $result['success'] = false;
            if (isset($file)) {
                $result['success'] = true;
                $result['file'] = self::convertFile($file);
            }

            return $result;
        }
    }

    public static function convertListFile($files, $data) {
        $result = array();
        if ($files != null && count($files) > 0) {
            foreach ($files as $file) {
                $result[] = self::convertFile($file);
            }
        }
        return $result;
    }

    static function convertFile($file) {
        $result = array(
            'id' => $file->id,
            'filename' => $file->filename,
            'extension' => $file->extension,
            'dirname' => $file->dirname,
            'filesize' => $file->filesize,
            'filesize_label' => number_format((int)$file->filesize/1024/1024, 2, '.', ',').' MB',
            'cat_id' => $file->cat_id,
            'cat_name' => isset($file->category) ? $file->category->name : "",
            'restricted' => $file->restricted,
            'restricted_label' => $file->restricted ? "Yes" : "No",
            'absolute_url' => self::getAbsoluteUrl($file->id),
            'created_time' => date('H:i Y-m-d', $file->created_time),
            'author_name' => isset($file->author) ? $file->author->name : 'No name',
            'download_link' => Yii::app()->createUrl('/api/store/downloadfile', [
                'id' => $file->id,
            ]),
        );
        if(($file->extension == 'jpeg' || $file->extension == 'jpg' || $file->extension == 'png')
                && $file->getThumbUrl(80, 80, false)){
            $result['thumbnail'] = "server/".$file->getThumbUrl(80, 80, false);
        }
        elseif($file->extension == 'pdf'){
            $result['thumbnail'] = "server/".CustomEnum::THUMMNAIL_PDF;
        }
        else{
            $result['thumbnail'] = "server/".CustomEnum::THUMMNAIL_FILE;
        }
        return $result;
    }

    public static function DeleteFileById($data) {
        if (isset($data['id'])) {
            $file = File::model()->findByPk($data['id']);
            if (isset($file) && $file->delete()) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
            return $result;
        }
    }

    public static function downloadPdf($data) {
        $result = array();
        if (isset($data['html'])) {
            // Check whether file exists
            if (isset($data['file_name']))
                $file_name = $data['file_name'];
            else
                $file_name = 'Download';
            $file_name = preg_replace('/\s+/', '_', $file_name);
            $download_file = $file_name;
            $check_file = $file_name;
            $i = 1;
            while (file_exists(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $check_file . '.pdf')) {
                $check_file = $download_file . '_' . $i;
                $i++;
            }

            $download_file = $check_file;

            if (isset($data['option']))
                iPhoenixUrl::exportPdfFromHTML($data['html'], $download_file, $data['option']);
            else
                iPhoenixUrl::exportPdfFromHTML($data['html'], $download_file);

            $result = array(
                'success' => true,
                'message' => 'PDF file is generated.<br />If browser doesn\'t download file. <a href="' . Yii::app()->getBaseUrl(true) . '/data/pdf/' . $download_file . '.pdf" style="color: blue; text-decoration: underline" download>Please click here to download</a>.',
                'url' => Yii::app()->createUrl('api/file/pushFile', array('file' => urlencode(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $download_file . '.pdf'))),
                'filename' => $download_file,
                'dirname' => '/data/pdf/',
                'extension' => 'pdf'
            );
        }
        else {
            $result = array(
                'success' => false,
                'message' => 'Invalid request!'
            );
        }

        return $result;
    }
    
    public static function deleteRelated($data){
        $result = ['success' => false];
        if(!isset($data['file_id']) || !isset($data['related']) || !isset($data['model_id']) 
                || !$data['file_id'] || !$data['related'] || !$data['model_id']){
            return $result;
        }
        if($data['related'] == "store_file"){
            $model = StoreFile::model()->findByAttributes([
                'store_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "signage_file"){
            $model = SignageFile::model()->findByAttributes([
                'signage_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "fixture_file"){
            $model = FixtureFile::model()->findByAttributes([
                'fixture_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "customer_file"){
            $model = CustomerFile::model()->findByAttributes([
                'customer_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "project_file"){
            $model = ProjectFile::model()->findByAttributes([
                'project_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "product_development_file"){
            $model = ProductDevelopmentFile::model()->findByAttributes([
                'product_development_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "qa_file"){
            $model = QaFile::model()->findByAttributes([
                'qa_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        elseif($data['related'] == "pack_product_file"){
            $model = PackProductFile::model()->findByAttributes([
                'pack_product_id' => $data['model_id'],
                'file_id' => $data['file_id']
            ]);
        }
        else{
            $model = null;
        }
        if($model){
            $model->delete();
        }
        
        $result['success'] = true;
        return $result;
    }

}
