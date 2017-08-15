<?php

class StoreSignageService extends iPhoenixService {
  public static function getAll($data) {//data là thông tin phân trang
      $result = array();
      if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
          $data['limitstart'] = '0';
          $data['limitnum'] = StoreSignage::model()->count();
      }
      if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
          $data['sort_attribute'] = 'created_time';
          $data['sort_type'] = 'DESC';
      }

      $sql_command = Yii::app()->db->createCommand()
            ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, '
                    . 'sg.code store_signage_code, sg.note store_signage_note, sg.id store_signage_id, '
                    . 'sg.store_id, sg.signage_quantity ')
            ->from('tbl_signage g')
            ->join('tbl_signage_category c', 'c.id = g.category_id')
            ->join('tbl_store_signage sg', 'sg.signage_id = g.id')
            ->order('g.' . $data['sort_attribute'] . ' ' . $data['sort_type']);
      if(isset($data['store_id'])){
          $sql_command = $sql_command->where('sg.store_id=:store_id', array(':store_id' => $data['store_id']));
      }
      if(isset($data['get_stores'])){
          $sql_command = $sql_command->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, sg.code store_signage_code, sg.note store_signage_note, sg.id store_signage_id, sg.store_id, s.name store_name ')
                                    ->join('tbl_store s', 's.id = sg.store_id');
      }

      $count_sql_command = Yii::app()->db->createCommand()
            ->select('COUNT(g.id)')
            ->from('tbl_signage g')
            ->join('tbl_signage_category c', 'c.id = g.category_id')
            ->join('tbl_store_signage sg', 'sg.signage_id = g.id')
            ->order('g.' . $data['sort_attribute'] . ' ' . $data['sort_type']);
      if(isset($data['store_id'])){
          $count_sql_command = $count_sql_command->where('sg.store_id=:store_id', array(':store_id' => $data['store_id'])); 
      }

      if (isset($data['category_id']) && $data['category_id'] != '') {
          $sql_command->andWhere('g.category_id = :category_id', array(':category_id' => $data['category_id']));
          $count_sql_command->andWhere('g.category_id = :category_id', array(':category_id' => $data['category_id']));
      }
      if (isset($data['code']) && $data['code'] != '') {
          $sql_command->andWhere("g.code LIKE '%".$data['code']."%'");
          $count_sql_command->andWhere("g.code LIKE '%".$data['code']."%'");
      }
      if (isset($data['description']) && $data['description'] != '') {
          $sql_command->andWhere("g.code LIKE '%".$data['description']."%'");
          $count_sql_command->andWhere("g.code LIKE '%".$data['description']."%'");
      }

      $signages = $sql_command->limit($data['limitnum'], $data['limitstart'])->queryAll();
      $count = $count_sql_command->queryRow();
      $total = $count['COUNT(g.id)'];


      if ($signages != null) {
          $result['success'] = true;
          $result['signages'] = self::convertListSignage($signages);

          $result['totalresults'] = $total;
          $result['start_signage'] = (int) $data['limitstart'] + 1;
          $result['end_signage'] = (int) $data['limitstart'] + count($signages);
      } else {
          $result['success'] = true;
          $result['signages'] = [];
          $result['totalresults'] = $total;
          $result['start_signage'] = 0;
          $result['end_signage'] = 0;
      }
      return $result;
  }

  public static function update($data){
    $result = array();

    if(isset($data['id'])){
      $store_signage = StoreSignage::model()->findByPk((int) $data['id']);
    }
    elseif(isset ($data['store_id']) && isset ($data['signage_id'])){
      $store_signage = StoreSignage::model()->findByAttributes([
          'store_id' => $data['store_id'],
          'signage_id' => $data['signage_id'],
      ]);
    }
    if(!isset($store_signage)){
        $store_signage = new StoreSignage();
    }

    $store_signage->attributes = $data;
    $store_signage->code = "code_".time();

    if($store_signage->save()){
      $result = [
        'success' => true,
        'messsage' => 'Signage added to Store'
      ];
    }
    else{
      $result = [
        'success' => false,
        'errors' => $store_signage->getErrors(),
        'messsage' => 'Add signage to Store failed'
      ];
    }
    return $result;
  }

  public static function delete($data){
    $result = array();

    if(isset($data['id'])){
      $store_signage = StoreSignage::model()->findByPk((int) $data['id']);
      if(isset($store_signage)){
        if($store_signage->delete()){
          $result = [
            'success' => true,
            'messsage' => 'Store Signage deleted'
          ];
        }
        else{
          $result = [
            'success' => false,
            'messsage' => CHtml::errorSummary($store_signage)
          ];
        }
      }
      else{
        $result = [
          'success' => false,
          'messsage' => 'Store Signage does not exist'
        ];
      }
    }
    else{
      $result = [
        'success' => false,
        'messsage' => 'Invalid request'
      ];
    }

    return $result;
  }
    
    public static function convertListSignage($signages) {
        $result = array();
        if ($signages != null && count($signages) > 0) {
            foreach ($signages as $signage) {
                $result[] = self::convertSignage($signage);
            }
        }
        return $result;
    }

    public static function convertSignage($signage) {
        $result = $signage;
        $result['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        if(isset($signage['image_id']) && $signage['image_id']){
            $imageIdObj = File::model()->findByPk($signage['image_id']);
            if($imageIdObj && $imageIdObj->getThumbUrl(80, 80, false)){
                $result['image_id_url'] = "server/".$imageIdObj->getThumbUrl(80, 80, false);
            }
        }
        $result['example_image_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        if(isset($signage['example_image']) && $signage['example_image']){
            $eIObj = File::model()->findByPk($signage['example_image']);
            if($eIObj && $eIObj->getThumbUrl(80, 80, false)){
                $result['example_image_url'] = "server/".$eIObj->getThumbUrl(80, 80, false);
            }
        }
        return $result;
    }
    
    public static function getStoreSignage($data, $isStore = false){
        if($isStore){
            $orderFirst = 'store.id ASC';
        }
        else{
            $orderFirst = 'signage.id ASC';
        }
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = 0;
            $data['limitnum'] = 0;
        }
        $sql_count = Yii::app()->db->createCommand()
                ->select('count(ss.id) total')
                ->from('tbl_store_signage ss')
                ->join('tbl_store store', 'store.id = ss.store_id')
                ->join('tbl_signage signage', 'signage.id = ss.signage_id')
                ->join('tbl_signage_category sc', 'sc.id = signage.category_id')
                ->join('tbl_tier tier', 'tier.id = store.tier_id')
                ->join('tbl_state state', 'state.id = store.state_id')
                ->where('signage.in_trash = 0')
                ->andWhere('store.in_trash = 0');
        $sql_command = Yii::app()->db->createCommand()
                ->select('ss.*, signage.code, signage.description, sc.name category_name, store.name store_name, store.store_number, '
                        . 'store.contact_name, store.franchisee_name, tier.name tier_name, '
                        . 'signage.id signage_id, signage.image_id, signage.example_image, '
                        . 'signage.size, state.state_short province, store.name store_name, store.city')
                ->from('tbl_store_signage ss')
                ->join('tbl_store store', 'store.id = ss.store_id')
                ->join('tbl_signage signage', 'signage.id = ss.signage_id')
                ->join('tbl_signage_category sc', 'sc.id = signage.category_id')
                ->join('tbl_tier tier', 'tier.id = store.tier_id')
                ->join('tbl_state state', 'state.id = store.state_id')
                ->where('signage.in_trash = 0')
                ->andWhere('store.in_trash = 0')
//                ->order('ss.' . $data['sort_attribute'] . ' ' . $data['sort_type']);
                ->order($orderFirst.', ss.created_time DESC');
        $empty = true;
        if (isset($data['ids']) && $data['ids']) {
            $empty = false;
            $sql_command = $sql_command->andWhere('ss.id IN ('.$data['ids'].')');
            $sql_count = $sql_count->andWhere('ss.id IN ('.$data['ids'].')');
        }
        else{
            if (isset($data['general_category_id']) && $data['general_category_id']) {
                $empty = false;
                $sql_command = $sql_command->andWhere('sc.general_id=:general_category_id', array(':general_category_id' => $data['general_category_id']));
                $sql_count = $sql_count->andWhere('sc.general_id=:general_category_id', array(':general_category_id' => $data['general_category_id']));
            }
            if (isset($data['category_id']) && $data['category_id']) {
                $empty = false;
                $sql_command = $sql_command->andWhere('sc.id=:category_id', array(':category_id' => $data['category_id']));
                $sql_count = $sql_count->andWhere('sc.id=:category_id', array(':category_id' => $data['category_id']));
            }
            if (isset($data['code']) && $data['code']) {
                $empty = false;
                $sql_command->andWhere("signage.code LIKE '%" . $data['code'] . "%'");
                $sql_count->andWhere("signage.code LIKE '%" . $data['code'] . "%'");
            }
            if (isset($data['store_number']) && $data['store_number']) {
                $empty = false;
                $sql_command->andWhere("store.store_number LIKE '%" . $data['store_number'] . "%'");
                $sql_count->andWhere("store.store_number LIKE '%" . $data['store_number'] . "%'");
            }
            if (isset($data['store_name']) && $data['store_name']) {
                $empty = false;
                $sql_command->andWhere("store.name LIKE '%" . $data['store_name'] . "%'");
                $sql_count->andWhere("store.name LIKE '%" . $data['store_name'] . "%'");
            }
            if (isset($data['city']) && $data['city']) {
                $empty = false;
                $sql_command->andWhere("store.city LIKE '%" . $data['city'] . "%'");
                $sql_count->andWhere("store.city LIKE '%" . $data['city'] . "%'");
            }
            if (isset($data['tier_id']) && $data['tier_id'] && $data['tier_id'] != 'null') {
                $empty = false;
                $sql_command->andWhere("tier.id = :tier_id", array(':tier_id' => $data['tier_id']));
                $sql_count->andWhere("tier.id = :tier_id", array(':tier_id' => $data['tier_id']));
            }
            if (isset($data['province']) && $data['province']) {
                $empty = false;
                $sql_command->andWhere("state.state_short LIKE '%" . $data['province'] . "%'");
                $sql_count->andWhere("state.state_short LIKE '%" . $data['province'] . "%'");
            }
            if (isset($data['store_id']) && $data['store_id']) {
                $empty = false;
                $sql_command = $sql_command->andWhere('store.id=:store_id', array(':store_id' => $data['store_id']));
                $sql_count = $sql_count->andWhere('store.id=:store_id', array(':store_id' => $data['store_id']));
            }
            if (isset($data['fixture_id']) && $data['fixture_id']) {
                $empty = false;
                $fixture = Fixture::model()->findByPk($data['fixture_id']);
                if($fixture && $fixture->group_number){
                    $sql_command = $sql_command->andWhere('signage.group_number=:group_number', array(':group_number' => $data['$fixture->group_number']));
                    $sql_count = $sql_count->andWhere('signage.group_number=:group_number', array(':group_number' => $data['$fixture->group_number']));
                }
                elseif($fixture && !$fixture->group_number){
                    $sql_command = $sql_command->andWhere('0');
                    $sql_count = $sql_count->andWhere('0');
                }
            }
            if (isset($data['description']) && $data['description']) {
                $empty = false;
                $sql_command->andWhere("signage.description LIKE '%" . $data['description'] . "%'");
                $sql_count->andWhere("signage.description LIKE '%" . $data['description'] . "%'");
            } 
            if (isset($data['material']) && $data['material']) {
                $empty = false;
                $sql_command->andWhere("signage.material LIKE '%" . $data['material'] . "%'");
                $sql_count->andWhere("signage.material LIKE '%" . $data['material'] . "%'");
            }
            if (isset($data['language']) && $data['language']) {
                $empty = false;
                $sql_command = $sql_command->andWhere('signage.language=:language', array(':language' => $data['language']));
                $sql_count = $sql_count->andWhere('signage.language=:language', array(':language' => $data['language']));
            }
        }
        
        if((int)$data['limitnum']){
            $sql_command->limit($data['limitnum'], $data['limitstart']);
        }
        
        if(!$empty){
            $total = $sql_count->queryRow();
            $signagesTmp = $sql_command->queryAll();
            $signages = [];
            foreach ($signagesTmp as $signageTmp) {
                $signageModel = Signage::model()->findByPk($signageTmp['signage_id']);
                $signageTmp['image_id_url'] = $signageModel->image && $signageModel->image->getThumbUrl(80, 80, false)
                        ? "server/".$signageModel->image->getThumbUrl(80, 80, false)
                        : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
                $signageTmp['example_image_url'] = $signageModel->exampleImage && $signageModel->exampleImage->getThumbUrl(80, 80, false)
                        ? "server/".$signageModel->exampleImage->getThumbUrl(80, 80, false)
                        : "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
                $signages[] = $signageTmp;
            }
        }
        else{
            $signages = [];
            $total = 0;
        }
        $result['success'] = true;
        $result['signages'] = $signages;
        $result['start_item'] = $total ? (int) $data['limitstart'] + 1 : 0;
        $result['end_item'] = (int) $data['limitstart'] + count($signages);
        $result['totalresults'] = isset($total) ? (int)$total['total'] : 0;
        return $result;
    }
}
