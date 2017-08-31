<?php 
/*
 * Description of CustomEnum
 *
 * @author tunglexuan<tunghus1993@gmail.com>
 */

 public class StatusEnum
 {
 	const STATUS_ACTIVE = 1;
 	const STATUS_INACTIVE = 0;

 	public static function getStatusLabel($type = 'status'){
 		$type = $type ? $type : 'status';
 		return array(
 			self::STATUS_ACTIVE => Yii::t($type,'active'),
 			self::STATUS_INACTIVE => Yii::t($type,'inactive'),
 		);
 	}
 }