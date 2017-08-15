<?php

class StoreFixtureService extends iPhoenixService {
  public static function getAll($data) {//data là thông tin phân trang
      $result = array();
      if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
          $data['limitstart'] = '0';
          $data['limitnum'] = StoreFixture::model()->count();
      }
      if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
          $data['sort_attribute'] = 'created_time';
          $data['sort_type'] = 'DESC';
      }

      $sql_command = Yii::app()->db->createCommand()
            ->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, sg.code store_fixture_code, sg.note store_fixture_note, sg.id store_fixture_id, sg.store_id')
            ->from('tbl_fixture g')
            ->join('tbl_fixture_category c', 'c.id = g.category_id')
            ->join('tbl_store_fixture sg', 'sg.fixture_id = g.id')
            ->order('g.' . $data['sort_attribute'] . ' ' . $data['sort_type']);
      if(isset($data['store_id'])){
          $sql_command = $sql_command->where('sg.store_id=:store_id', array(':store_id' => $data['store_id']));
      }
      if(isset($data['get_stores'])){
          $sql_command = $sql_command->select('g.*, c.name category_name, SUBSTR(g.description, 1, 30) short_description, sg.code store_fixture_code, sg.note store_fixture_note, sg.id store_fixture_id, sg.store_id, s.name store_name ')
                                    ->join('tbl_store s', 's.id = sg.store_id');
      }

      $count_sql_command = Yii::app()->db->createCommand()
            ->select('COUNT(g.id)')
            ->from('tbl_fixture g')
            ->join('tbl_fixture_category c', 'c.id = g.category_id')
            ->join('tbl_store_fixture sg', 'sg.fixture_id = g.id')
            ->order('g.' . $data['sort_attribute'] . ' ' . $data['sort_type']);
      if(isset($data['store_id'])){
          $count_sql_command = $count_sql_command->where('sg.store_id=:store_id', array(':store_id' => $data['store_id']));
      }

      if (isset($data['category_id']) && $data['category_id'] != '') {
          $sql_command->andWhere('g.category_id = :category_id', array(':category_id' => $data['category_id']));
          $count_sql_command->andWhere('g.category_id = :category_id', array(':category_id' => $data['category_id']));
      }
      if (isset($data['code']) && $data['code'] != '') {
          $sql_command->andWhere('g.code LIKE "%'.$data['code'].'%"');
          $count_sql_command->andWhere('g.code LIKE "%'.$data['code'].'%"');
      }
      if (isset($data['description']) && $data['description'] != '') {
          $sql_command->andWhere('g.code LIKE "%'.$data['description'].'%"');
          $count_sql_command->andWhere('g.code LIKE "%'.$data['description'].'%"');
      }

      $fixtures = $sql_command->limit($data['limitnum'], $data['limitstart'])->queryAll();
      $count = $count_sql_command->queryRow();
      $total = $count['COUNT(g.id)'];


      if ($fixtures != null) {
          $result['success'] = true;
          $result['fixtures'] = self::convertListFixture($fixtures);

          $result['totalresults'] = $total;
          $result['start_fixture'] = (int) $data['limitstart'] + 1;
          $result['end_fixture'] = (int) $data['limitstart'] + count($fixtures);
      } else {
          $result['success'] = true;
          $result['fixtures'] = [];
          $result['totalresults'] = $total;
          $result['start_fixture'] = 0;
          $result['end_fixture'] = 0;
      }
      return $result;
  }

  public static function update($data){
    $result = array();

    if(isset($data['id'])){
      $store_fixture = StoreFixture::model()->findByPk((int) $data['id']);
    }
    else{
      $store_fixture = new StoreFixture();
    }

    $store_fixture->attributes = $data;

    if($store_fixture->save()){
      $result = [
        'success' => true,
        'messsage' => 'Fixture added to Store'
      ];
    }
    else{
      $result = [
        'success' => false,
        'errors' => $store_fixture->getErrors(),
        'messsage' => 'Add fixture to Store failed'
      ];
    }
    return $result;
  }

  public static function delete($data){
    $result = array();

    if(isset($data['id'])){
      $store_fixture = StoreFixture::model()->findByPk((int) $data['id']);
      if(isset($store_fixture)){
        if($store_fixture->delete()){
          $result = [
            'success' => true,
            'messsage' => 'Store Fixture deleted'
          ];
        }
        else{
          $result = [
            'success' => false,
            'messsage' => CHtml::errorSummary($store_fixture)
          ];
        }
      }
      else{
        $result = [
          'success' => false,
          'messsage' => 'Store Fixture does not exist'
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
  
    public static function convertListFixture($fixtures) {
        $result = array();
        if ($fixtures != null && count($fixtures) > 0) {
            foreach ($fixtures as $fixture) {
                $result[] = self::convertFixture($fixture);
            }
        }
        return $result;
    }

    public static function convertFixture($fixture) {
        $result = $fixture;
        $result['image_id_url'] = "server/".CustomEnum::IMAGE_NOT_AVAILABLE;
        $result['image_id_src'] = CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
        if(isset($fixture['image_id']) && $fixture['image_id']){
            $imageIdObj = File::model()->findByPk($fixture['image_id']);
            if($imageIdObj && $imageIdObj->getThumbUrl(80, 80, false)){
                $result['image_id_url'] = "server/".$imageIdObj->getThumbUrl(80, 80, false);
                $result['image_id_src'] = CustomEnum::FILE_SERVER_PATH.$imageIdObj->getThumbUrl(80, 80, false);
            }
        }
        return $result;
    }
}
