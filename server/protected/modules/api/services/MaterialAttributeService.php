<?php
class MaterialAttributeService extends iPhoenixService{
	public static function getSizeIds($data){
		$result= array();

		$criteria = new CDbCriteria();
		$criteria->compare('material_id', (int)$data['id']);
		$sizes = MaterialAttribute::model()->findAll($criteria);
		$size_ids = array();
		foreach ($sizes as $size) {
			$size_ids[] = $size->id;
		}

		return $result['size_ids'] = $size_ids;
	}
}
