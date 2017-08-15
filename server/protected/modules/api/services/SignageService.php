<?php

class SignageService extends iPhoenixService {
    
    public static function createInit($data) {
        $result = array();
        $get_empty_signage = SignageService::getEmptySignage();
        if (isset($data['id']) && $data['id'] != '') {
            $signage = SignageService::getSignageById(array('id' => $data['id']));
            if ($signage['success'] == true) {
                $result['signage'] = $signage['signage'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['signage'] = $get_empty_signage['signage'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['signage'] = $get_empty_signage['signage'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['signage_empty'] = $get_empty_signage['signage'];
        $get_empty_signage_error = SignageService::getEmptySignageError();
        $result['signage_error'] = $get_empty_signage_error['signage_error'];
        $result['signage_error_empty'] = $get_empty_signage_error['signage_error'];

        $signage_categories = SignageCategoryService::getAll(array());
        $result['signage_categories'] = $signage_categories['signage_categories'];

        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = false) {//data là thông tin phân trang        
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Signage::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'ORDER BY tbl_signage.' . $data['sort_attribute'] . ' ' . $data['sort_type'];


        $sql = "SELECT tbl_signage.* FROM tbl_signage";
        if(isset($data['store_id']) && $data['store_id']){
            $sql = $sql . " INNER JOIN tbl_store_signage AS ss ON ss.signage_id=tbl_signage.id AND ss.store_id=".$data['store_id'];
        }
        if(isset($data['general_category_id']) && $data['general_category_id']){
            $sql = $sql . " INNER JOIN tbl_signage_category AS sc ON sc.id=tbl_signage.category_id AND sc.general_id=".$data['general_category_id'];
        }
        $sql = $sql . " Where 1 ";

        if (isset($data['category_id']) && $data['category_id'] != '') {
            $sql = $sql . "And tbl_signage.category_id = " . $data['category_id'] . " ";
        }
        if (isset($data['code']) && $data['code'] != '') {
            $sql = $sql . "And tbl_signage.code LIKE '%" . $data['code'] . "%' ";
        }
        if (isset($data['description']) && $data['description'] != '') {
            $sql = $sql . "And tbl_signage.description LIKE '%" . $data['description'] . "%' ";
        }
        if(isset($data['all_related'])){
            $sql = $sql . "And tbl_signage.group_number IS NOT NULL  AND tbl_signage.group_number <> \"\"";
        }
        if(isset($data['group_number']) && $data['group_number'] != ""){
            $sql = $sql . "AND tbl_signage.group_number='".$data['group_number']."'";
        }
        elseif(isset($data['group_number']) && $data['group_number'] == "" && isset ($data['fixture_id']) && $data['fixture_id']){
            $sql = $sql . "AND tbl_signage.id = 0 ";
        }
        if(isset($data['status']) && $data['status'] != ""){
            $sql = $sql . "AND tbl_signage.status='".$data['status']."'";
        }
        if(isset($data['material']) && $data['material'] != ""){
            $sql = $sql . "And tbl_signage.material LIKE '%" . $data['material'] . "%' ";
        }
        if(isset($data['language']) && $data['language'] != ""){
            $sql = $sql . "AND tbl_signage.language='".$data['language']."'";
        }
        if(isset($data['add_relate'])){
            $sql = $sql . "AND tbl_signage.mounting='2' ";
        }
        $sql = $sql . "And tbl_signage.in_trash = 0 ";
        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
        $signages = Signage::model()->findAllBySql($sql);

        $criteria = new CDbCriteria();
        if(isset($data['store_id']) && $data['store_id']){
            $criteria->join = "INNER JOIN tbl_store_signage AS ss ON ss.signage_id=t.id AND ss.store_id=".$data['store_id'];
        }
        if(isset($data['general_category_id']) && $data['general_category_id']){
            $criteria->join = "INNER JOIN tbl_signage_category AS sc ON sc.id=t.category_id AND sc.general_id=".$data['general_category_id'];
        }
        if (isset($data['category_id']) && $data['category_id'] != '') {
            $criteria->compare('category_id', $data['category_id']);
        }
        if (isset($data['code']) && $data['code'] != '') {
            $criteria->compare('code', $data['code'], true);
        }
        if (isset($data['description']) && $data['description'] != '') {
            $criteria->compare('description', $data['description'], true);
        }
        if(isset($data['all_related'])){
            $criteria->addCondition("t.group_number IS NOT NULL  AND t.group_number <> \"\"");
        }
        if(isset($data['group_number']) && $data['group_number'] != ""){
            $criteria->compare('group_number', $data['group_number'], true);
        }
        elseif(isset($data['group_number']) && $data['group_number'] == "" && isset ($data['fixture_id']) && $data['fixture_id']){
            $criteria->compare('id', 0);
        }
        if(isset($data['status']) && $data['status'] != ""){
            $criteria->compare('t.status', $data['status'], true);
        }
        if(isset($data['material']) && $data['material'] != ""){
            $criteria->compare('t.material', $data['material'], true);
        }
        if(isset($data['language']) && $data['language'] != ""){
            $criteria->compare('t.language', $data['language'], true);
        }
        if(isset($data['add_relate'])){
            $criteria->compare('mounting', 2);
        }
        $criteria->compare('t.in_trash', 0);
        $total = Signage::model()->count($criteria);

        if ($signages != null) {
            $result['success'] = true;
            $result['signages'] = self::convertListSignage($signages, $isRelated);

            $result['totalresults'] = $total;
            $result['start_signage'] = (int) $data['limitstart'] + 1;
            $result['end_signage'] = (int) $data['limitstart'] + count($signages);
        } else {
            $result['success'] = true;
            $result['signages'] = array();
            $result['totalresults'] = $total;
            $result['start_signage'] = 0;
            $result['end_signage'] = 0;
        }
        return $result;
    }

    public static function getEmptySignage() {
        $result = array();
        $signage = new Signage();
        $attribute_names = $signage->attributeNames();
        foreach($attribute_names as $attr){
          $result['signage'][$attr] = '';
        }
        $result['signage']['mounting'] = 1;
        $result['signage']['tmp_file_ids'] = '';
        $result['signage']['category_name'] = '';
        $result['signage']['changes_seasonally'] = 1;
        $result['signage']['power_required'] = 1;
        
        $result['success'] = true;
        return $result;
    }

    public static function getEmptySignageError() {
      $result = array();
      $signage = new Signage();
      $attribute_names = $signage->attributeNames();
      foreach($attribute_names as $attr){
        $result['signage_error'][$attr] = [];
      }
      $result['signage_error']['tmp_file_ids'] = [];
      $result['signage_error']['category_name'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getSignageById($data) {
        $result = array();
        $get_empty_signage_error = SignageService::getEmptySignageError();
        $result['signage_error'] = $get_empty_signage_error['signage_error'];

        $signage = Signage::model()->findByPk((int) $data['id']);
        if ($signage != null) {
            $result['success'] = true;
            $result['signage'] = self::convertSignage($signage);
            $result['languages'] = (new Signage())->getLanguages();
        } else {
            $result['success'] = false;
            $result['message'] = 'Signage\'s not found!';
        }
        return $result;
    }

    public static function getSignagesByCategoryId($data) {//data['id']
        $result = array();
        $signages = Signage::model()->findAllByAttributes(array('category_id' => $data['id']));
        if ($signages != null && count($signages) > 0) {
            $result['success'] = true;
            $result['signages'] = self::convertListSignage($signages, $data);
        } else {
            $result['success'] = true;
            $result['signages'] = array();
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $signage = new Signage();
        $signage->attributes = $data;
        $signage = SignageService::beforeSave($signage);
        if ($signage->validate()) {
            $signage->save();
            $result['success'] = true;
            $result['id'] = $signage->id;
            $new_signage = self::getSignageById(array('id' => $signage->id));
            $result['signage'] = $new_signage['signage'];
        } else {
            $empty_signage_error = SignageService::getEmptySignageError();
            $result['signage_error'] = $empty_signage_error['signage_error'];
            foreach ($signage->getErrors() as $key => $error_array) {
                $result['signage_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Signage has some errors';
            $result['error_array'] = $signage->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $signage = Signage::model()->findByPk((int) $data['id']);
        $signage->attributes = $data;

        $signage = SignageService::beforeSave($signage);
        //remove Related if Mounting == self
        if($signage->mounting == 1){
            $removeRelated = SignageService::removeFromGroup([
                'signage_id' => $signage->id
            ]);
            if($removeRelated['success'] == false){
                return $removeRelated;
            }
        }
        if ($signage->validate()) {
            $signage->save();
            $result['success'] = true;
            $signage_array = SignageService::getSignageById(array('id' => $signage->id));
            $get_empty_signage_error = SignageService::getEmptySignageError();
            $result['signage_error'] = $get_empty_signage_error['signage_error'];
            $result['signage'] = $signage_array['signage'];
            $result['id'] = $signage->id;
        } else {
            $empty_signage_error = SignageService::getEmptySignageError();
            $result['signage_error'] = $empty_signage_error['signage_error'];
            foreach ($signage->getErrors() as $key => $error_array) {
                $result['signage_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Signage has some errors';
            $result['error_array'] = $signage->getErrors();
        }

        return $result;
    }

    public static function beforeSave($signage) {
        if ($signage->isNewRecord) {
            $signage->group_number = '';
            $signage->status = 1;
            $signage->created_time = time();
            $signage->created_by = Yii::app()->user->id;
        }
        else{
            $signage->updated_time = time();
        }
        return $signage;
    }

    public static function convertListSignage($signages, $isRelated = true) {
        $result = array();
        if ($signages != null && count($signages) > 0) {
            foreach ($signages as $signage) {
                $result[] = self::convertSignage($signage, $isRelated);
            }
        }
        return $result;
    }

    public static function convertSignage($signage, $isRelated = true) {
        $result = $signage->attributes;

        $result['status_label'] = $signage->getStatusLabel();
        $result['short_description'] = iPhoenixString::createIntrotext($signage->description, 30);
        $result['category_name'] =  isset($signage->category) ? $signage->category->name : "N/A";
        $result['tmp_file_ids'] = $signage->tmp_file_ids;
        $result['created_by_converted'] = $signage->author ? $signage->author->name : "";
        $result['created_time_converted'] = date('H:i d/m/Y', $signage->created_time);
        $result['updated_time_converted'] = isset($signage->updated_time) ? date('H:i d/m/Y', $signage->updated_time): '';
//        $result['related_signages'] = $signage->getListRelatedSignage(); // Commented by NamNT 2017-01-22
//        $result['related_fixtures'] = $signage->getListRelatedFixture();
        $result['mounting_label'] = $signage->getMountingLabel();
//        $result['related_stores'] = $signage->getListRelatedStore();
        $result['changes_seasonally_label'] = $signage->getChangesSeasonallyLabel();
        $result['power_required_label'] = $signage->getPowerRequiredLabel();
        $result['image_id_url'] = $signage->image && $signage->image->getThumbUrl(80, 80, false)
                ? "server/".$signage->image->getThumbUrl(80, 80, false)
                : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        $result['example_image_url'] = $signage->exampleImage && $signage->exampleImage->getThumbUrl(80, 80, false)
                ? "server/".$signage->exampleImage->getThumbUrl(80, 80, false)
                : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        $result['language_label'] = $signage->getLanguageLabel();
        $result['general_category_id'] = $signage->category ? $signage->category->general_id : 0;
        if($isRelated){
            // get fixtures
            $getFixtures = FixtureService::getAll([
                'limitstart' => 0,
                'limitnum' => CustomEnum::RELATED_BY_PAGE,
                'group_number' => $signage->group_number,
            ], false);
            $result['related_fixtures'] = $getFixtures['fixtures'];
            $result['fsPagination'] = $getFixtures;
            $getFixturesCategories = FixtureCategoryService::getAll([]);
            $result['related_fixtures_categories'] = $getFixturesCategories['fixture_categories'];

            // get store
            $getStores = StoreService::getAll([
                'limitstart' => 0,
                'limitnum' => CustomEnum::RELATED_BY_PAGE,
                'signage_id' => $signage->id
            ], false);
            $result['related_stores'] = $getStores['stores'];
            $result['storePagination'] = $getStores;
        }
        return $result;
    }

    public static function addRelatedSignage($data){
      $list_added_signage = [];

      $signage_id = $data['signage_id'];
      $added_signage_id = $data['added_signage_id'];
      $signage = Signage::model()->findByPk($signage_id);
      $added_signage = Signage::model()->findByPk($added_signage_id);

      if(isset($signage) && isset($added_signage)){
        if($added_signage->group_number == '' && $signage->group_number == ''){
          $group_number = 'SIGNAGE_'.(($signage_id > $added_signage_id) ? $signage_id : $added_signage_id);

          $signage->group_number = $group_number;
          $added_signage->group_number = $group_number;
          if($signage->save() && $added_signage->save()){
            return [
              'success' => true,
              'message' => 'Signage added'
            ];
          }
          else{
            return [
              'success' => true,
              'message' => 'Add signage failed'
            ];
          }
        }
        else{
          if($added_signage->group_number == ''){
            $added_signage->group_number = $signage->group_number;
            if($added_signage->save()){
              $list_added_signage[] = self::convertSignage($added_signage);
              return [
                'success' => true,
                'message' => 'Signage added',
                'related_signages' => $signage->getListRelatedSignage(),
                'related_fixtures' => $signage->getListRelatedFixture(),                  
              ];
            }
            else{
              return [
                'success' => true,
                'message' => 'Add signage failed'
              ];
            }
          }
          else{
            if($signage->group_number == ''){
              $signage->group_number = $added_signage->group_number;
              if($signage->save()){
                return [
                  'success' => true,
                  'message' => 'Signage added',
                  'related_signages' => $signage->getListRelatedSignage(),
                  'related_fixtures' => $signage->getListRelatedFixture(),
                ];
              }
              else{
                return [
                  'success' => true,
                  'message' => 'Add signage failed'
                ];
              }
            }
            else{
              // 2 signage deu lien quan den 2 nhom khac nhau
              $a_group_number = explode('_', $signage->group_number);
              $a_added_group_number = explode('_', $added_signage->group_number);

              if($a_group_number[1] > $a_added_group_number[1]){
                    $list_related_signage = $added_signage->getListRelatedSignage();
                    //$list_related_fixture = $added_signage->getListRelatedFixture();

                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                      foreach($list_related_signage as $item){
                        $o_item = Signage::model()->findByPk($item['id']);
                        $o_item->group_number = $signage->group_number;
                        $o_item->save();
                      }
                      $added_signage->group_number = $signage->group_number;
                      $added_signage->save();

                      $transaction->commit();
                    }
                    catch(Exception $e)
                    {
                       $transaction->rollback();
                    }
              }
              else{
                $list_related_signage = $signage->getListRelatedSignage();
                //$list_related_fixture = $signage->getListRelatedFixture();

                $transaction = Yii::app()->db->beginTransaction();
                try{
                  foreach($list_related_signage as $item){
                    $o_item = Signage::model()->findByPk($item['id']);
                    $o_item->group_number = $added_signage->group_number;
                    $o_item->save();
                  }

                  $signage->group_number = $added_signage->group_number;
                  $signage->save();

                  $transaction->commit();
                  return [
                    'success' => true,
                    'message' => 'Signage added',
                    'related_signages' => $signage->getListRelatedSignage(),
                    'related_fixtures' => $signage->getListRelatedFixture(),
                  ];
                }
                catch(Exception $e)
                {
                   $transaction->rollback();
                   return [
                     'success' => true,
                     'message' => 'Add signage failed'
                   ];
                }
              }
            }
          }
        }
      }
      else{
        return [
          'success' => false,
          'message' => 'Invalid Signage ID'
        ];
      }
    }

    public static function removeRelatedSignage($data){
      $signage_id = $data['signage_id'];
      $removed_signage_id = $data['removed_signage_id'];
      $signage = Signage::model()->findByPk($signage_id);
      $removed_signage = Signage::model()->findByPk($removed_signage_id);

      if(isset($signage) && isset($removed_signage)){
        // Kiem tra xem removed_signage_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_signage->group_number);
        if($a_removed_group_number[0] != 'SIGNAGE' || $a_removed_group_number[1] != $removed_signage->id){
          $removed_signage->group_number = '';

          if($removed_signage->save()){
            return [
              'success' => true,
              'message' => 'Signage removed',
              'related_signages' => $signage->getListRelatedSignage(),
              'related_fixtures' => $signage->getListRelatedFixture(),
            ];
          }
          else{
            return [
              'success' => true,
              'message' => 'Remove signage failed'
            ];
          }
        }
        else{
          // Neu removed_signage_id la Id lon nhat cua Group
          // Tim tat ca signage co cung group voi nhom nay, sau do tim ID lon nhat de set lam group number moi
          $list_related_signage = $removed_signage->getListRelatedSignage();
          $list_related_fixture = $removed_signage->getListRelatedFixture();
          $maximum_id = 0;
          $group_type = '';
          foreach($list_related_signage as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'SIGNAGE';
            }
          }
          foreach($list_related_fixture as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'FIXTURE';
            }
          }

          $new_group_number = $group_type.$maximum_id;

          $transaction = Yii::app()->db->beginTransaction();
          try
          {
            foreach($list_related_signage as $related_item){
              $o_related_item = Signage::model()->findByPk($related_item['id']);
              $o_related_item->group_number = $new_group_number;
              $o_related_item->save();
            }
            foreach($list_related_fixture as $related_item){
              $o_related_item = Fixture::model()->findByPk($o_related_item['id']);
              $o_related_item->group_number = $new_group_number;
              $o_related_item->save();
            }

            $removed_signage->group_number = '';
            $removed_signage->save();

            $transaction->commit();

            return [
              'success' => true,
              'message' => 'Signage removed',
              'related_signages' => $signage->getListRelatedSignage(),
              'related_fixtures' => $signage->getListRelatedFixture(),
            ];
          }
          catch(Exception $e)
          {
             $transaction->rollback();
             return [
               'success' => false,
               'message' => 'Remove signage failed'
             ];
          }
        }
      }
    }

    public static function addRelatedFixture($data){
      $list_added_fixture = [];

      $signage_id = $data['signage_id'];
      $added_fixture_id = $data['added_fixture_id'];
      $signage = Signage::model()->findByPk($signage_id);
      $added_fixture = Fixture::model()->findByPk($added_fixture_id);

      if(isset($signage) && isset($added_fixture)){
        if($added_fixture->group_number == '' && $signage->group_number == ''){
          $group_number = ($signage_id > $added_fixture_id) ? 'SIGNAGE_'.$signage_id : 'FIXTURE_'.$added_fixture_id;

          $signage->group_number = $group_number;
          $added_fixture->group_number = $group_number;
          if($signage->save() && $added_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture added',
                'group_number' => $group_number,
            ];
          }
          else{
            return [
              'success' => true,
              'message' => 'Add signage failed'
            ];
          }
        }
        else{
          if($added_fixture->group_number == ''){
            $added_fixture->group_number = $signage->group_number;
            if($added_fixture->save()){
              $list_added_fixture[] = FixtureService::convertFixture($added_fixture);
              return [
                'success' => true,
                'message' => 'Fixture added',
                'related_signages' => $signage->getListRelatedSignage(),
                'related_fixtures' => $signage->getListRelatedFixture(),
              ];
            }
            else{
              return [
                'success' => true,
                'message' => 'Add fixture failed'
              ];
            }
          }
          else{
            if($signage->group_number == ''){
              $signage->group_number = $added_fixture->group_number;
              if($signage->save()){
                return [
                  'success' => true,
                  'message' => 'Fixture added',
                  'related_signages' => $signage->getListRelatedSignage(),
                  'related_fixtures' => $signage->getListRelatedFixture(),
                ];
              }
              else{
                return [
                  'success' => true,
                  'message' => 'Add fixture failed'
                ];
              }
            }
            else{
              // 2 signage deu lien quan den 2 nhom khac nhau
              $a_group_number = explode('_', $signage->group_number);
              $a_added_group_number = explode('_', $added_fixture->group_number);

              if($a_group_number[1] > $a_added_group_number[1]){
                    $list_related_signage = $added_fixture->getListRelatedSignage();
                    $list_related_fixture = $added_fixture->getListRelatedFixture();

                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                      foreach($list_related_signage as $item){
                        $o_item = Signage::model()->findByPk($item['id']);
                        $o_item->group_number = $signage->group_number;
                        $o_item->save();
                      }
                      foreach($list_related_fixture as $item){
                        $o_item = Fixture::model()->findByPk($item['id']);
                        $o_item->group_number = $signage->group_number;
                        $o_item->save();
                      }
                      $added_fixture->group_number = $signage->group_number;
                      $added_fixture->save();

                      $transaction->commit();
                    }
                    catch(Exception $e)
                    {
                       $transaction->rollback();
                    }
              }
              else{
                $list_related_signage = $signage->getListRelatedSignage();
                $list_related_fixture = $signage->getListRelatedFixture();

                $transaction = Yii::app()->db->beginTransaction();
                try{
                  foreach($list_related_signage as $item){
                    $o_item = Signage::model()->findByPk($item['id']);
                    $o_item->group_number = $added_fixture->group_number;
                    $o_item->save();
                  }
                  foreach($list_related_fixture as $item){
                    $o_item = Fixture::model()->findByPk($item['id']);
                    $o_item->group_number = $added_fixture->group_number;
                    $o_item->save();
                  }

                  $signage->group_number = $added_fixture->group_number;
                  $signage->save();

                  $transaction->commit();
                  return [
                    'success' => true,
                    'message' => 'Signage added',
                    'related_signages' => $signage->getListRelatedSignage(),
                    'related_fixtures' => $signage->getListRelatedFixture(),
                  ];
                }
                catch(Exception $e)
                {
                   $transaction->rollback();
                   return [
                     'success' => true,
                     'message' => 'Add signage failed'
                   ];
                }
              }
            }
          }
        }
      }
      else{
        return [
          'success' => false,
          'message' => 'Invalid Signage ID'
        ];
      }
    }

    public static function removeRelatedFixture($data){
      $signage_id = $data['signage_id'];
      $removed_fixture_id = $data['removed_fixture_id'];
      $signage = Signage::model()->findByPk($signage_id);
      $removed_fixture = Fixture::model()->findByPk($removed_fixture_id);

      if(isset($signage) && isset($removed_fixture)){
        // Kiem tra xem removed_fixture_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_fixture->group_number);
        if($a_removed_group_number[0] != 'FIXTURE' || $a_removed_group_number[1] != $removed_fixture->id){
          $removed_fixture->group_number = '';

          if($removed_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture removed',
              'related_signages' => $signage->getListRelatedSignage(),
              'related_fixtures' => $signage->getListRelatedFixture(),
            ];
          }
          else{
            return [
              'success' => true,
              'message' => 'Remove fixture failed'
            ];
          }
        }
        else{
          // Neu removed_fixture_id la Id lon nhat cua Group
          // Tim tat ca signage co cung group voi nhom nay, sau do tim ID lon nhat de set lam group number moi
          $list_related_signage = $removed_fixture->getListRelatedSignage();
          $list_related_fixture = $removed_fixture->getListRelatedFixture();
          $maximum_id = 0;
          $group_type = '';
          foreach($list_related_signage as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'SIGNAGE_';
            }
          }
          foreach($list_related_fixture as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'FIXTURE_';
            }
          }
          $new_group_number = $group_type.$maximum_id;

          $transaction = Yii::app()->db->beginTransaction();
          try
          {
            foreach($list_related_signage as $related_signage){
              $o_related_signage = Signage::model()->findByPk($related_signage['id']);
              $o_related_signage->group_number = $new_group_number;
              $o_related_signage->save();
            }
            foreach($list_related_fixture as $related_fixture){
              $o_related_fixture = Fixture::model()->findByPk($related_fixture['id']);
              $o_related_fixture->group_number = $new_group_number;
              $o_related_fixture->save();
            }

            $removed_fixture->group_number = '';
            $removed_fixture->save();

            $transaction->commit();

            return [
              'success' => true,
              'message' => 'Fixture removed',
              'related_signages' => $signage->getListRelatedSignage(),
              'related_fixtures' => $signage->getListRelatedFixture()
            ];
          }
          catch(Exception $e)
          {
             $transaction->rollback();
             return [
               'success' => false,
               'message' => 'Remove fixture failed'
             ];
          }
        }
      }
    }
    
    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $store = Signage::model()->findByPk((int)$data['id']);
        if(!$store){
            $result['success'] = false;
            return $result;
        }
        $store->in_trash = 1;
        $store->code = CustomEnum::DELETED_CODE.$store->code;
        if($store->save()){
            $result['success'] = true;
        }
        return $result;
    }
    
    public static function copy($data) {
        $result = array();
        $id = isset($data['id']) ? (int)$data['id'] : null;
        $signageCopy = Signage::model()->findByPk($id);
        if(!$signageCopy){
            $result['success'] = false;
            $result['message'] = 'Signage copy is not found';
            return $result;
        }
        $signage = new Signage();
        $signage->attributes = $signageCopy->attributes;
        $signage->code = time()."_".CustomEnum::COPY_CODE.$signageCopy->code;
        $signage = SignageService::beforeSave($signage);
        $signage->group_number = $signageCopy->group_number;
        if ($signage->validate()) {
            $signage->save();
            $result['success'] = true;
            $result['id'] = $signage->id;
            $new_signage = self::getSignageById(array('id' => $signage->id));
            $result['signage'] = $new_signage['signage'];
            // create StoreSignage
            self::copyRelate('StoreSignage', 'signage_id', $signageCopy->id, $signage->id);
            // create SignageFile
            self::copyRelate('SignageFile', 'signage_id', $signageCopy->id, $signage->id);
        } else {
            $empty_signage_error = SignageService::getEmptySignageError();
            $result['signage_error'] = $empty_signage_error['signage_error'];
            foreach ($signage->getErrors() as $key => $error_array) {
                $result['signage_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Signage has some errors';
            $result['error_array'] = $signage->getErrors();
        }

        return $result;
    }
    
    /*
     * 08/01/2017
     * NamNT bổ sung tính năng xóa Signage khỏi group liên quan
     */
    public static function removeFromGroup($data){
      $removed_signage_id = $data['signage_id'];
      $removed_signage = Signage::model()->findByPk($removed_signage_id);

      if(isset($removed_signage)){
        // Kiem tra xem removed_signage_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_signage->group_number);
        if($a_removed_group_number[0] != 'SIGNAGE' || $a_removed_group_number[1] != $removed_signage->id){
          $removed_signage->group_number = '';

          if($removed_signage->save()){
            return [
              'success' => true,
              'message' => 'Signage removed from group'
            ];
          }
          else{
            return [
              'success' => true,
              'message' => 'Remove signage from group failed'
            ];
          }
        }
        else{
          // Neu removed_signage_id la Id lon nhat cua Group
          // Tim tat ca fixture co cung group voi nhom nay, sau do tim ID lon nhat de set lam group number moi
          $list_related_fixture = $removed_signage->getListRelatedFixture();
          $list_related_signage = $removed_signage->getListRelatedSignage();
          $maximum_id = 0;
          $group_type = '';
          foreach($list_related_fixture as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'FIXTURE_';
            }
          }
          foreach($list_related_signage as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'SIGNAGE_';
            }
          }
          $new_group_number = $group_type.$maximum_id;

          $transaction = Yii::app()->db->beginTransaction();
          try
          {
            foreach($list_related_fixture as $related_fixture){
              $o_related_fixture = Fixture::model()->findByPk($related_fixture['id']);
              $o_related_fixture->group_number = $new_group_number;
              $o_related_fixture->save();
            }
            foreach($list_related_signage as $related_signage){
              $o_related_signage = Signage::model()->findByPk($related_signage['id']);
              $o_related_signage->group_number = $new_group_number;
              $o_related_signage->save();
            }

            $removed_signage->group_number = '';
            $removed_signage->save();

            $transaction->commit();

            return [
              'success' => true,
              'message' => 'Signage removed from group'
            ];
          }
          catch(Exception $e)
          {
             $transaction->rollback();
             return [
               'success' => false,
               'message' => 'Remove signage from group failed'
             ];
          }
        }
      }
      return [
          'success' => true
      ];
    }
}
