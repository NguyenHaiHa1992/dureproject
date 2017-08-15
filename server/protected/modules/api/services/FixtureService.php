<?php

class FixtureService extends iPhoenixService {

    public static function createInit($data) {
        $result = array();
        $get_empty_fixture = FixtureService::getEmptyFixture();
        if (isset($data['id']) && $data['id'] != '') {
            $fixture = FixtureService::getFixtureById(array('id' => $data['id']));
            if ($fixture['success'] == true) {
                $result['fixture'] = $fixture['fixture'];
                $result['is_update'] = true;
                $result['is_create'] = false;
            } else {
                $result['fixture'] = $get_empty_fixture['fixture'];
                $result['is_update'] = false;
                $result['is_create'] = true;
            }
        } else {
            $result['fixture'] = $get_empty_fixture['fixture'];
            $result['is_update'] = false;
            $result['is_create'] = true;
        }

        $result['fixture_empty'] = $get_empty_fixture['fixture'];
        $get_empty_fixture_error = FixtureService::getEmptyFixtureError();
        $result['fixture_error'] = $get_empty_fixture_error['fixture_error'];
        $result['fixture_error_empty'] = $get_empty_fixture_error['fixture_error'];

        $fixture_categories = FixtureCategoryService::getAll(array());
        $result['fixture_categories'] = $fixture_categories['fixture_categories'];

        $result['success'] = true;
        return $result;
    }

    public static function getAll($data, $isRelated = false) {//data là thông tin phân trang
        $result = array();
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Fixture::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'ORDER BY tbl_fixture.' . $data['sort_attribute'] . ' ' . $data['sort_type'];


        $sql = "SELECT tbl_fixture.* FROM tbl_fixture";
        if(isset($data['store_id']) && $data['store_id']){
            $sql = $sql . " INNER JOIN tbl_store_fixture AS ss ON ss.fixture_id=tbl_fixture.id AND ss.store_id=".$data['store_id'];
        }
        if(isset($data['general_category_id']) && $data['general_category_id']){
            $sql = $sql . " INNER JOIN tbl_fixture_category AS fc ON fc.id=t.category_id AND fc.general_id=".$data['general_category_id'];
        }
        $sql = $sql . " Where 1 ";

        if (isset($data['category_id']) && $data['category_id'] != '') {
            $sql = $sql . "And tbl_fixture.category_id = " . $data['category_id'] . " ";
        }
        if (isset($data['code']) && $data['code'] != '') {
            $sql = $sql . "And tbl_fixture.code LIKE '%" . $data['code'] . "%' ";
        }
        if (isset($data['description']) && $data['description'] != '') {
            $sql = $sql . "And tbl_fixture.description LIKE '%" . $data['description'] . "%' ";
        }
        if(isset($data['all_related'])){
            $sql = $sql . "And tbl_fixture.group_number IS NOT NULL  AND tbl_fixture.group_number <> \"\"";
        }
        if(isset($data['group_number']) && $data['group_number'] != ""){
            $sql = $sql . "AND tbl_fixture.group_number='".$data['group_number']."' ";
        }
        elseif(isset($data['group_number']) && $data['group_number'] == "" && isset ($data['signage_id']) && $data['signage_id']){
            $sql = $sql . "AND tbl_fixture.id = 0 ";
        }
        $sql = $sql . "And tbl_fixture.in_trash = 0 ";
        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
        $fixtures = Fixture::model()->findAllBySql($sql);

        $criteria = new CDbCriteria();
        if(isset($data['store_id']) && $data['store_id']){
            $criteria->join = "INNER JOIN tbl_store_fixture AS ss ON ss.fixture_id=t.id AND ss.store_id=".$data['store_id'];
        }
        if(isset($data['general_category_id']) && $data['general_category_id']){
            $criteria->join = "INNER JOIN tbl_fixture_category AS fc ON fc.id=tbl_fixture.category_id AND fc.general_id=".$data['general_category_id'];
        }
        if (isset($data['category_id']) && $data['category_id'] != '') {
            $criteria->compare('category_id', $data['category_id']);
        }
        if (isset($data['code']) && $data['code'] != '') {
            $criteria->compare('t.code', $data['code'], true);
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
        elseif(isset($data['group_number']) && $data['group_number'] == "" && isset ($data['signage_id']) && $data['signage_id']){
            $criteria->compare('id', 0);
        }
        $criteria->compare('t.in_trash', 0);
        $total = Fixture::model()->count($criteria);

        if ($fixtures != null) {
            $result['success'] = true;
            $result['fixtures'] = self::convertListFixture($fixtures, $isRelated);

            $result['totalresults'] = $total;
            $result['start_fixture'] = (int) $data['limitstart'] + 1;
            $result['end_fixture'] = (int) $data['limitstart'] + count($fixtures);
        } else {
            $result['success'] = true;
            $result['fixtures'] = array();
            $result['totalresults'] = $total;
            $result['start_fixture'] = 0;
            $result['end_fixture'] = 0;
        }
        return $result;
    }

    public static function getEmptyFixture() {
        $result = array();
        $fixture = new Fixture();
        $attribute_names = $fixture->attributeNames();
        foreach($attribute_names as $attr){
          $result['fixture'][$attr] = '';
        }
        $result['fixture']['tmp_file_ids'] = '';
        $result['fixture']['category_name'] = '';

        $result['success'] = true;
        return $result;
    }

    public static function getEmptyFixtureError() {
      $result = array();
      $fixture = new Fixture();
      $attribute_names = $fixture->attributeNames();
      foreach($attribute_names as $attr){
        $result['fixture_error'][$attr] = [];
      }
      $result['fixture_error']['tmp_file_ids'] = [];
      $result['fixture_error']['category_name'] = [];

      $result['success'] = true;
      return $result;
    }

    public static function getFixtureById($data) {
        $result = array();
        $get_empty_fixture_error = FixtureService::getEmptyFixtureError();
        $result['fixture_error'] = $get_empty_fixture_error['fixture_error'];

        $fixture;
        $fixture = Fixture::model()->findByPk((int) $data['id']);
        if ($fixture != null) {
            $result['success'] = true;
            $result['fixture'] = self::convertFixture($fixture);
        } else {
            $result['success'] = false;
            $result['message'] = 'Fixture\'s not found!';
        }
        return $result;
    }

    public static function getFixturesByCategoryId($data) {//data['id']
        $result = array();
        $fixtures = Fixture::model()->findAllByAttributes(array('category_id' => $data['id']));
        if ($fixtures != null && count($fixtures) > 0) {
            $result['success'] = true;
            $result['fixtures'] = self::convertListFixture($fixtures, $data);
        } else {
            $result['success'] = true;
            $result['fixtures'] = array();
        }
        return $result;
    }

    public static function create($data) {
        $result = array();
        $fixture = new Fixture();
        $fixture->attributes = $data;
        $fixture = FixtureService::beforeSave($fixture);
        if ($fixture->validate()) {
            $fixture->save();
            $result['success'] = true;
            $result['id'] = $fixture->id;
            $new_fixture = self::getFixtureById(array('id' => $fixture->id));
            $result['fixture'] = $new_fixture['fixture'];
        } else {
            $empty_fixture_error = FixtureService::getEmptyFixtureError();
            $result['fixture_error'] = $empty_fixture_error['fixture_error'];
            foreach ($fixture->getErrors() as $key => $error_array) {
                $result['fixture_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Fixture has some errors';
            $result['error_array'] = $fixture->getErrors();
        }

        return $result;
    }

    public static function update($data) {
        $result = array();
        $fixture = Fixture::model()->findByPk((int) $data['id']);
        $fixture->attributes = $data;

        $fixture = FixtureService::beforeSave($fixture);
        if ($fixture->validate()) {
            $fixture->save();
            $result['success'] = true;
            $fixture_array = FixtureService::getFixtureById(array('id' => $fixture->id));
            $get_empty_fixture_error = FixtureService::getEmptyFixtureError();
            $result['fixture_error'] = $get_empty_fixture_error['fixture_error'];
            $result['fixture'] = $fixture_array['fixture'];
            $result['id'] = $fixture->id;
        } else {
            $empty_fixture_error = FixtureService::getEmptyFixtureError();
            $result['fixture_error'] = $empty_fixture_error['fixture_error'];
            foreach ($fixture->getErrors() as $key => $error_array) {
                $result['fixture_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Update Fixture has some errors';
            $result['error_array'] = $fixture->getErrors();
        }

        return $result;
    }

    public static function beforeSave($fixture) {
        if ($fixture->isNewRecord) {
            $fixture->group_number = '';
            $fixture->status = 1;
            $fixture->created_time = time();
            $fixture->created_by = Yii::app()->user->id;
        }
        else{
            $fixture->updated_time = time();
        }
        return $fixture;
    }

    public static function convertListFixture($fixtures, $isRelated = true) {
        $result = array();
        if ($fixtures != null && count($fixtures) > 0) {
            foreach ($fixtures as $fixture) {
                $result[] = self::convertFixture($fixture, $isRelated);
            }
        }
        return $result;
    }

    public static function convertFixture($fixture, $isRelated = true) {
        $result = $fixture->attributes;

        $result['short_description'] = iPhoenixString::createIntrotext($fixture->description, 30);
        $result['category_name'] =  isset($fixture->category) ? $fixture->category->name : "N/A";
        $result['tmp_file_ids'] = $fixture->tmp_file_ids;
        $result['created_by_converted'] = $fixture->author->name;
        $result['created_time_converted'] = date('H:i d/m/Y', $fixture->created_time);
        $result['updated_time_converted'] = isset($fixture->updated_time) ? date('H:i d/m/Y', $fixture->updated_time): '';
        //$result['related_fixtures'] = $fixture->getListRelatedFixture(); // Commented by NamNT 2017-01-22
//        $result['related_signages'] = $fixture->getListRelatedSignage();
//        $result['related_stores'] = $fixture->getListRelatedStore();
        $result['image_id_url'] = isset($fixture->image) && $fixture->image->getThumbUrl(80, 80, false) 
                ? "server/".$fixture->image->getThumbUrl(80, 80, false)
                : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        $result['general_category_id'] = $fixture->category ? $fixture->category->general_id : 0;
        if($isRelated){
            // get signages
            $getSignages = SignageService::getAll([
                'limitstart' => 0,
                'limitnum' => CustomEnum::RELATED_BY_PAGE,
                'group_number' => $fixture->group_number,
            ], false);
            $result['related_signages'] = $getSignages['signages'];
            $result['fsPagination'] = $getSignages;
            $getSignagesCategories = SignageCategoryService::getAll([]);
            $result['related_signages_categories'] = $getSignagesCategories['signage_categories'];

            // get store
            $getStores = StoreService::getAll([
                'limitstart' => 0,
                'limitnum' => CustomEnum::RELATED_BY_PAGE,
                'fixture_id' => $fixture->id
            ]);
            $result['related_stores'] = $getStores['stores'];
            $result['storePagination'] = $getStores;
        }
        return $result;
    }

    /*
    public static function addRelatedFixture($data){
      $list_added_fixture = [];

      $fixture_id = $data['fixture_id'];
      $added_fixture_id = $data['added_fixture_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $added_fixture = Fixture::model()->findByPk($added_fixture_id);

      if(isset($fixture) && isset($added_fixture)){
        if($added_fixture->group_number == '' && $fixture->group_number == ''){
          $group_number = 'FIXTURE_'.(($fixture_id > $added_fixture_id) ? $fixture_id : $added_fixture_id);

          $fixture->group_number = $group_number;
          $added_fixture->group_number = $group_number;
          if($fixture->save() && $added_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture added'
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
          if($added_fixture->group_number == ''){
            $added_fixture->group_number = $fixture->group_number;
            if($added_fixture->save()){
              $list_added_fixture[] = self::convertFixture($added_fixture);
              return [
                'success' => true,
                'message' => 'Fixture added',
                'related_fixtures' => $fixture->getListRelatedFixture()
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
            if($fixture->group_number == ''){
              $fixture->group_number = $added_fixture->group_number;
              if($fixture->save()){
                return [
                  'success' => true,
                  'message' => 'Fixture added',
                  'related_fixtures' => $fixture->getListRelatedFixture()
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
              // 2 fixture deu lien quan den 2 nhom khac nhau
              $a_group_number = explode('_', $fixture->group_number);
              $a_added_group_number = explode('_', $added_fixture->group_number);

              if($a_group_number[1] > $a_added_group_number[1]){
                    $list_related_fixture = $added_fixture->getListRelatedFixture();
                    $list_related_signage = $added_fixture->getListRelatedSignage();

                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                      foreach($list_related_fixture as $item){
                        $o_item = Fixture::model()->findByPk($item['id']);
                        $o_item->group_number = $fixture->group_number;
                        $o_item->save();
                      }
                      foreach($list_related_signage as $item){
                        $o_item = Signage::model()->findByPk($item['id']);
                        $o_item->group_number = $fixture->group_number;
                        $o_item->save();
                      }
                      $added_fixture->group_number = $fixture->group_number;
                      $added_fixture->save();

                      $transaction->commit();
                    }
                    catch(Exception $e)
                    {
                       $transaction->rollback();
                    }
              }
              else{
                $list_related_fixture = $fixture->getListRelatedFixture();
                $list_related_signage = $fixture->getListRelatedSignage();

                $transaction = Yii::app()->db->beginTransaction();
                try{
                  foreach($list_related_fixture as $item){
                    $o_item = Fixture::model()->findByPk($item['id']);
                    $o_item->group_number = $added_fixture->group_number;
                    $o_item->save();
                  }
                  foreach($list_related_signage as $item){
                    $o_item = Signage::model()->findByPk($item['id']);
                    $o_item->group_number = $added_fixture->group_number;
                    $o_item->save();
                  }

                  $fixture->group_number = $added_fixture->group_number;
                  $fixture->save();

                  $transaction->commit();
                  return [
                    'success' => true,
                    'message' => 'Fixture added',
                    'related_fixtures' => $fixture->getListRelatedFixture()
                  ];
                }
                catch(Exception $e)
                {
                   $transaction->rollback();
                   return [
                     'success' => true,
                     'message' => 'Add fixture failed'
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
          'message' => 'Invalid Fixture ID'
        ];
      }
    }

    public static function removeRelatedFixture($data){
      $fixture_id = $data['fixture_id'];
      $removed_fixture_id = $data['removed_fixture_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $removed_fixture = Fixture::model()->findByPk($removed_fixture_id);

      if(isset($fixture) && isset($removed_fixture)){
        // Kiem tra xem removed_fixture_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_fixture->group_number);
        if($a_removed_group_number[0] != 'FIXTURE' || $a_removed_group_number[1] != $removed_fixture->id){
          $removed_fixture->group_number = '';

          if($removed_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture removed',
              'related_fixtures' => $fixture->getListRelatedFixture()
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
          // Tim tat ca fixture co cung group voi nhom nay, sau do tim ID lon nhat de set lam group number moi
          $list_related_fixture = $removed_fixture->getListRelatedFixture();
          $maximum_id = 0;
          foreach($list_related_fixture as $related_fixture){
            if($related_fixture['id'] > $maximum_id){
              $maximum_id = $related_fixture['id'];
            }
          }

          $new_group_number = 'SIGNAGE_'.$maximum_id;

          $transaction = Yii::app()->db->beginTransaction();
          try
          {
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
              'related_fixtures' => $fixture->getListRelatedFixture()
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
    */
    public static function addRelatedFixture($data){
      $list_added_fixture = [];

      $fixture_id = $data['fixture_id'];
      $added_fixture_id = $data['added_fixture_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $added_fixture = Fixture::model()->findByPk($added_fixture_id);

      if(isset($fixture) && isset($added_fixture)){
        if($added_fixture->group_number == '' && $fixture->group_number == ''){
          $group_number = 'FIXTURE_'.(($fixture_id > $added_fixture_id) ? $fixture_id : $added_fixture_id);

          $fixture->group_number = $group_number;
          $added_fixture->group_number = $group_number;
          if($fixture->save() && $added_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture added'
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
          if($added_fixture->group_number == ''){
            $added_fixture->group_number = $fixture->group_number;
            if($added_fixture->save()){
              $list_added_fixture[] = self::convertFixture($added_fixture);
              return [
                'success' => true,
                'message' => 'Fixture added',
                'related_fixtures' => $fixture->getListRelatedFixture(),
                'related_signages' => $fixture->getListRelatedSignage()
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
            if($fixture->group_number == ''){
              $fixture->group_number = $added_fixture->group_number;
              if($fixture->save()){
                return [
                  'success' => true,
                  'message' => 'Fixture added',
                  'related_fixtures' => $fixture->getListRelatedFixture(),
                  'related_signages' => $fixture->getListRelatedSignage()
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
              // 2 fixture deu lien quan den 2 nhom khac nhau
              $a_group_number = explode('_', $fixture->group_number);
              $a_added_group_number = explode('_', $added_fixture->group_number);

              if($a_group_number[1] > $a_added_group_number[1]){
                    $list_related_fixture = $added_fixture->getListRelatedFixture();
                    //$list_related_signage = $added_fixture->getListRelatedSignage();

                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                      foreach($list_related_fixture as $item){
                        $o_item = Fixture::model()->findByPk($item['id']);
                        $o_item->group_number = $fixture->group_number;
                        $o_item->save();
                      }
                      $added_fixture->group_number = $fixture->group_number;
                      $added_fixture->save();

                      $transaction->commit();
                    }
                    catch(Exception $e)
                    {
                       $transaction->rollback();
                    }
              }
              else{
                $list_related_fixture = $fixture->getListRelatedFixture();
                //$list_related_signage = $fixture->getListRelatedSignage();

                $transaction = Yii::app()->db->beginTransaction();
                try{
                  foreach($list_related_fixture as $item){
                    $o_item = Fixture::model()->findByPk($item['id']);
                    $o_item->group_number = $added_fixture->group_number;
                    $o_item->save();
                  }

                  $fixture->group_number = $added_fixture->group_number;
                  $fixture->save();

                  $transaction->commit();
                  return [
                    'success' => true,
                    'message' => 'Fixture added',
                    'related_fixtures' => $fixture->getListRelatedFixture(),
                    'related_signages' => $fixture->getListRelatedSignage()
                  ];
                }
                catch(Exception $e)
                {
                   $transaction->rollback();
                   return [
                     'success' => true,
                     'message' => 'Add fixture failed'
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
          'message' => 'Invalid Fixture ID'
        ];
      }
    }

    public static function removeRelatedFixture($data){
      $fixture_id = $data['fixture_id'];
      $removed_fixture_id = $data['removed_fixture_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $removed_fixture = Fixture::model()->findByPk($removed_fixture_id);

      if(isset($fixture) && isset($removed_fixture)){
        // Kiem tra xem removed_fixture_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_fixture->group_number);
        if($a_removed_group_number[0] != 'FIXTURE' || $a_removed_group_number[1] != $removed_fixture->id){
          $removed_fixture->group_number = '';

          if($removed_fixture->save()){
            return [
              'success' => true,
              'message' => 'Fixture removed',
              'related_fixtures' => $fixture->getListRelatedFixture(),
              'related_signages' => $fixture->getListRelatedSignage()
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
          // Tim tat ca fixture co cung group voi nhom nay, sau do tim ID lon nhat de set lam group number moi
          $list_related_fixture = $removed_fixture->getListRelatedFixture();
          $list_related_signage = $removed_fixture->getListRelatedSignage();
          $maximum_id = 0;
          $group_type = '';
          foreach($list_related_fixture as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'FIXTURE';
            }
          }
          foreach($list_related_signage as $related_item){
            if($related_item['id'] > $maximum_id){
              $maximum_id = $related_item['id'];
              $group_type = 'SIGNAGE';
            }
          }

          $new_group_number = $group_type.$maximum_id;

          $transaction = Yii::app()->db->beginTransaction();
          try
          {
            foreach($list_related_fixture as $related_item){
              $o_related_item = Fixture::model()->findByPk($related_item['id']);
              $o_related_item->group_number = $new_group_number;
              $o_related_item->save();
            }
            foreach($list_related_signage as $related_item){
              $o_related_item = Signage::model()->findByPk($o_related_item['id']);
              $o_related_item->group_number = $new_group_number;
              $o_related_item->save();
            }

            $removed_fixture->group_number = '';
            $removed_fixture->save();

            $transaction->commit();

            return [
              'success' => true,
              'message' => 'Fixture removed',
              'related_fixtures' => $fixture->getListRelatedFixture(),
              'related_signages' => $fixture->getListRelatedSignage()
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

    public static function addRelatedSignage($data){
      $list_added_signage = [];

      $fixture_id = $data['fixture_id'];
      $added_signage_id = $data['added_signage_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $added_signage = Signage::model()->findByPk($added_signage_id);

      if(isset($fixture) && isset($added_signage)){
        if($added_signage->group_number == '' && $fixture->group_number == ''){
          $group_number = ($fixture_id > $added_signage_id) ? 'FIXTURE_'.$fixture_id : 'SIGNAGE_'.$added_signage_id;

          $fixture->group_number = $group_number;
          $added_signage->group_number = $group_number;
          if($fixture->save() && $added_signage->save()){
            return [
              'success' => true,
              'message' => 'Signage added',
                'group_number' => $group_number
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
          if($added_signage->group_number == ''){
            $added_signage->group_number = $fixture->group_number;
            if($added_signage->save()){
              $list_added_signage[] = SignageService::convertSignage($added_signage);
              return [
                'success' => true,
                'message' => 'Signage added',
                'related_fixtures' => $fixture->getListRelatedFixture(),
                'related_signages' => $fixture->getListRelatedSignage(),
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
            if($fixture->group_number == ''){
              $fixture->group_number = $added_signage->group_number;
              if($fixture->save()){
                return [
                  'success' => true,
                  'message' => 'Signage added',
                  'related_fixtures' => $fixture->getListRelatedFixture(),
                  'related_signages' => $fixture->getListRelatedSignage(),
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
              // 2 fixture deu lien quan den 2 nhom khac nhau
              $a_group_number = explode('_', $fixture->group_number);
              $a_added_group_number = explode('_', $added_signage->group_number);

              if($a_group_number[1] > $a_added_group_number[1]){
                    $list_related_fixture = $added_signage->getListRelatedFixture();
                    $list_related_signage = $added_signage->getListRelatedSignage();

                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                      foreach($list_related_fixture as $item){
                        $o_item = Fixture::model()->findByPk($item['id']);
                        $o_item->group_number = $fixture->group_number;
                        $o_item->save();
                      }
                      foreach($list_related_signage as $item){
                        $o_item = Signage::model()->findByPk($item['id']);
                        $o_item->group_number = $fixture->group_number;
                        $o_item->save();
                      }
                      $added_signage->group_number = $fixture->group_number;
                      $added_signage->save();

                      $transaction->commit();
                    }
                    catch(Exception $e)
                    {
                       $transaction->rollback();
                    }
              }
              else{
                $list_related_fixture = $fixture->getListRelatedFixture();
                $list_related_signage = $fixture->getListRelatedSignage();

                $transaction = Yii::app()->db->beginTransaction();
                try{
                  foreach($list_related_fixture as $item){
                    $o_item = Fixture::model()->findByPk($item['id']);
                    $o_item->group_number = $added_signage->group_number;
                    $o_item->save();
                  }
                  foreach($list_related_signage as $item){
                    $o_item = Signage::model()->findByPk($item['id']);
                    $o_item->group_number = $added_signage->group_number;
                    $o_item->save();
                  }

                  $fixture->group_number = $added_signage->group_number;
                  $fixture->save();

                  $transaction->commit();
                  return [
                    'success' => true,
                    'message' => 'Fixture added',
                    'related_fixtures' => $fixture->getListRelatedFixture(),
                    'related_signages' => $fixture->getListRelatedSignage(),
                  ];
                }
                catch(Exception $e)
                {
                   $transaction->rollback();
                   return [
                     'success' => true,
                     'message' => 'Add fixture failed'
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
          'message' => 'Invalid Fixture ID'
        ];
      }
    }

    public static function removeRelatedSignage($data){
      $fixture_id = $data['fixture_id'];
      $removed_signage_id = $data['removed_signage_id'];
      $fixture = Fixture::model()->findByPk($fixture_id);
      $removed_signage = Signage::model()->findByPk($removed_signage_id);

      if(isset($fixture) && isset($removed_signage)){
        // Kiem tra xem removed_signage_id co phai la ID lon nhat
        $a_removed_group_number = explode('_', $removed_signage->group_number);
        if($a_removed_group_number[0] != 'SIGNAGE' || $a_removed_group_number[1] != $removed_signage->id){
          $removed_signage->group_number = '';

          if($removed_signage->save()){
            return [
              'success' => true,
              'message' => 'Signage removed',
              'related_fixtures' => $fixture->getListRelatedFixture(),
              'related_signages' => $fixture->getListRelatedSignage(),
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
              'message' => 'Signage removed',
              'related_fixtures' => $fixture->getListRelatedFixture(),
              'related_signages' => $fixture->getListRelatedSignage()
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
    
    public static function delete($data) {
        $result = array('success' => false);
        if(!isset($data['id'])){
            $result['success'] = false;
            return $result;
        }
        $store = Fixture::model()->findByPk((int)$data['id']);
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
        $fixtureCopy = Fixture::model()->findByPk($id);
        if(!$fixtureCopy){
            $result['success'] = false;
            $result['message'] = 'Fixture copy is not found';
            return $result;
        }
        $fixture = new Fixture();
        $fixture->attributes = $fixtureCopy->attributes;
        $fixture->code = time()."_".CustomEnum::COPY_CODE.$fixtureCopy->code;
        $fixture = FixtureService::beforeSave($fixture);
        $fixture->group_number = $fixtureCopy->group_number;
        if ($fixture->validate()) {
            $fixture->save();
            $result['success'] = true;
            $result['id'] = $fixture->id;
            $new_fixture = self::getFixtureById(array('id' => $fixture->id));
            $result['fixture'] = $new_fixture['fixture'];
            // create StoreFixture
            self::copyRelate('StoreFixture', 'fixture_id', $fixtureCopy->id, $fixture->id);
            // create FixtureFile
            self::copyRelate('FixtureFile', 'fixture_id', $fixtureCopy->id, $fixture->id);
        } else {
            $empty_fixture_error = FixtureService::getEmptyFixtureError();
            $result['fixture_error'] = $empty_fixture_error['fixture_error'];
            foreach ($fixture->getErrors() as $key => $error_array) {
                $result['fixture_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Fixture has some errors';
            $result['error_array'] = $fixture->getErrors();
        }

        return $result;
    }
}
