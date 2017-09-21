<?php

class ProjectService extends iPhoenixService {

    public static function createInit($data) {
        $result = array();
        $get_empty_project = ProjectService::getEmptyProject();
        if (isset($data['id']) && $data['id'] != '') {
            $project = ProjectService::getProjectById(array('id' => $data['id']));
            if ($project['success'] == true) {
                $result['project'] = $project['project'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['project'] = $get_empty_project['project'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['project'] = $get_empty_project['project'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['project_empty'] = $get_empty_project['project'];
        $get_empty_project_error = ProjectService::getEmptyProjectError();
        $result['project_error'] = $get_empty_project_error['project_error'];
        $result['project_error_empty'] = $get_empty_project_error['project_error'];
        // data selection
            $result['project_customers'] = Customer::getAll();
            $result['project_typeProducts'] = Project::getTypeOfProduct();
            $result['project_services'] = Project::getProductMatch();
        // end data selection
        $result['formAttributes'] = self::formAttributes();
        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = true) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Project::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $criteria = new CDbCriteria();
        if (isset($data['ship_to']) && $data['ship_to'] != '') {
            $criteria->compare('ship_to', $data['ship_to'], true);
        }
        if (isset($data['ship_oa']) && $data['ship_oa'] != '') {
            $criteria->compare('ship_oa', $data['ship_oa'], true);
        }
        if (isset($data['ship_address']) && $data['ship_address'] != '') {
            $criteria->compare('ship_address', $data['ship_address'], true);
        }
        
        if (isset($data['bill_to']) && $data['bill_to'] != '') {
            $criteria->compare('bill_to', $data['bill_to'], true);
        }
        if (isset($data['bill_oa']) && $data['bill_oa'] != '') {
            $criteria->compare('bill_oa', $data['bill_oa'], true);
        }
        if (isset($data['bill_address']) && $data['bill_address'] != '') {
            $criteria->compare('bill_address', $data['bill_address'], true);
        }
        if (isset($data['phone']) && $data['phone'] != '') {
            $criteria->compare('phone', $data['phone'], true);
        }
        if (isset($data['fax']) && $data['fax'] != '') {
            $criteria->compare('fax', $data['fax'], true);
        }
        $criteria->order = $data['sort_attribute'] . ' ' . $data['sort_type'];
        $criteria->limit = $data['limitnum'];
        $criteria->offset = $data['limitstart'];
        
        $criteria->compare('in_trash', 0);

        $projects = Project::model()->findAll($criteria);
        $total = count($projects);

        if ($projects != null) {
            $result['success'] = true;
            $result['projects'] = self::convertListProject($projects, $isRelated);

            $result['totalresults'] = $total;
            $result['start_project'] = (int) $data['limitstart'] + 1;
            $result['end_project'] = (int) $data['limitstart'] + count($projects);
        } else {
            $result['success'] = true;
            $result['projects'] = array();
            $result['totalresults'] = $total;
            $result['start_project'] = 0;
            $result['end_project'] = 0;
        }
        return $result;
    }

    public static function getEmptyProject() {
        $result = array();
        $project = new Project();
        $attribute_names = $project->attributeNames();
        foreach($attribute_names as $attr){
          $result['project'][$attr] = '';
        }
        $result['project']['tmp_file_ids'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyProjectError() {
      $result = array();
      $project = new Project();
      $attribute_names = $project->attributeNames();
      foreach($attribute_names as $attr){
        $result['project_error'][$attr] = [];
      }
      $result['project_error']['tmp_file_ids'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getProjectById($data) {
        $result = array();
        $get_empty_project_error = ProjectService::getEmptyProjectError();
        $result['project_error'] = $get_empty_project_error['project_error'];

        $project;
        $project = Project::model()->findByPk((int) $data['id']);
        if ($project != null) {
            $result['success'] = true;
            $result['project'] = self::convertProject($project);
        } else {
            $result['success'] = false;
            $result['message'] = 'Project\'s not found!';
        }
        return $result;
    }

    public static function getProjectsByCategoryId($data) {//data['id']
        $result = array();
        $projects = Project::model()->findAllByAttributes(array('category_id' => $data['id']));
        if ($projects != null && count($projects) > 0) {
            $result['success'] = true;
            $result['projects'] = self::convertListProject($projects, $data);
        } else {
            $result['success'] = true;
            $result['projects'] = array();
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $project = null;
        if(isset($data['id']) && $data['id']){
            $project = Project::model()->findByPk((int)$data['id']);
        }
        if(!$project){
            $project = new Project();
        }

        $project->attributes = $data;
        if(!is_integer($project->date)){
            $project->date = strtotime($project->date);
        }
        $project = ProjectService::beforeSave($project);
        if ($project->validate()) {
            $project->save();
            $result['success'] = true;
            $result['id'] = $project->id;
            $new_project = self::getProjectById(array('id' => $project->id));
            $result['project'] = $new_project['project'];
        } else {
            $empty_project_error = ProjectService::getEmptyProjectError();
            $result['project_error'] = $empty_project_error['project_error'];
            foreach ($project->getErrors() as $key => $error_array) {
                $result['project_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Project has some errors';
            $result['error_array'] = $project->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $project = Project::model()->findByPk((int) $data['id']);
        $project->attributes = $data;
        $project = ProjectService::beforeSave($project);
        if ($project->validate()) {
            $project->save();
            $result['success'] = true;
            $project_array = ProjectService::getProjectById(array('id' => $project->id));
            $get_empty_project_error = ProjectService::getEmptyProjectError();
            $result['project_error'] = $get_empty_project_error['project_error'];
            $result['project'] = $project_array['project'];
            $result['id'] = $project->id;
        } else {
            $empty_project_error = ProjectService::getEmptyProjectError();
            $result['project_error'] = $empty_project_error['project_error'];
            foreach ($project->getErrors() as $key => $error_array) {
                $result['project_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Project has some errors';
            $result['error_array'] = $project->getErrors();
        }

        return $result;
    }

    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $project = Project::model()->findByPk((int)$data['id']);
        if(!$project){
            $result['success'] = false;
            return $result;
        }
        $project->in_trash = 1;
        if($project->save(false)){
            // delete productDevelopment
            $productDev = ProductDevelopment::model()->findByAttributes(['project_id' => (int)$data['id']]);
            if($productDev){
                if(isset($productDev->in_trash)){
                    $productDev->in_trash  = 1;
                    $productDev->save(false);
                }
            }
            // delete qa
            $qa = Qa::model()->findByAttributes(['project_id' => (int)$data['id']]);
            if($qa){
                if(isset($qa->in_trash)){
                    $qa->in_trash  = 1;
                    $qa->save(false);
                }
            }
            $result['success'] = true;
        }
        return $result;
    }

    public static function beforeSave($project) {
        
        if($project->date &&  !is_int($project->date)){
            $project->date = strtotime($project->date);
        }
        if ($project->isNewRecord) {
            $project->status = 1;
            $project->created_time = time();
//            $project->created_by = Yii::app()->user->id;
        }
        else if(isset($project->updated_time)){
            $project->updated_time = time();
        }
        return $project;
    }

    public static function convertListProject($projects, $isRelated = true) {
        $result = array();
        if ($projects != null && count($projects) > 0) {
            foreach ($projects as $project) {
                $result[] = self::convertProject($project, $isRelated);
            }
        }
        return $result;
    }

    public static function convertProject($project, $isRelated = true) {
        if(is_array($project)){
            $result = $project;
            $id = isset($project['id']) ? $project['id'] : 0;
            $project = Project::model()->findByPk($id);
        }
        else{
            $result = $project->attributes;
        }
       if(isset($result['date']) && $result['date']){
        //                if(is_integer($project['date'])){

                            $result['date'] = date('Y-m-d' ,$result['date']);
        //                }
        }
        $serviceLabel = Project::getLabelByType($result['service']);
        $result['service_label']  = $serviceLabel;
        $result['tmp_file_ids'] = $project->tmp_file_ids;
        return $result;
    }
    
    public static function copy($data) {
        $result = array();
        $id = isset($data['id']) ? (int)$data['id'] : null;
        $projectCopy = Project::model()->findByPk($id);
        if(!$projectCopy){
            $result['success'] = false;
            $result['message'] = 'Project copy is not found';
            return $result;
        }
        $project = new Project();
        $project->attributes = $projectCopy->attributes;
//        $project->name = time()."_".CustomEnum::COPY_CODE.$projectCopy->name;
        $project = ProjectService::beforeSave($project);
        if ($project->validate()) {
            $project->save();
            $result['success'] = true;
            $result['id'] = $project->id;
            $new_project = self::getProjectById(array('id' => $project->id));
            $result['project'] = $new_project['project'];
        } else {
            $empty_project_error = ProjectService::getEmptyProjectError();
            $result['project_error'] = $empty_project_error['project_error'];
            foreach ($project->getErrors() as $key => $error_array) {
                $result['project_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Project has some errors';
            $result['error_array'] = $project->getErrors();
        }

        return $result;
    }
    
    public static function formAttributes(){
        return ['date', 'primary_contact', 'customer_id', 'project_number', 'project_name', 'volume', 
            'price_point', 'life_style', 'service', 'product_match', 'note'];
    }
}
