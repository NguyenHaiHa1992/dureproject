<?php

class TierService extends iPhoenixService {

    public static function createInit() {
        $result = array();
        $get_empty_tier = TierService::getEmptyTier();
        $result['tier'] = $get_empty_tier['tier'];
        $get_empty_tier_error = TierService::getEmptyTierError();
        $result['tier_error'] = $get_empty_tier_error['tier_error'];
        $result['success'] = true;
        return $result;
    }

    public static function getEmptyTier() {
        $result = array();
        $tier = array(
            'id' => '',
            'name' => '',
            'status' => '',
            'created_time' => '',
            'is_edit' => '',
        );

        $result['tier'] = $tier;
        $result['success'] = true;
        return $result;
    }

    public static function getEmptyTierError() {
        $result = array();
        $tier = array(
            'id' => array(),
            'name' => array(),
            'status' => array(),
            'created_time' => array(),
            'is_edit' => array(),
        );

        $result['tier_error'] = $tier;
        $result['success'] = true;
        return $result;
    }

    public static function getAll($data = []) {
        $result = array();
        if(!isset($data['status'])){
            $data['status'] = 1;
        }
        if (!isset($data['limitstart']) && !isset($data['limitnum'])) {
            $data['limitstart'] = '0';
            $data['limitnum'] = Tier::model()->count();
        }
        if (!isset($data['sort_attribute']) && !isset($data['sort_type'])) {
            $data['sort_attribute'] = 'created_time';
            $data['sort_type'] = 'DESC';
        }

        $sql = '';
        $sql_order_by = '';
        $sql_order_by = 'ORDER BY tbl_tier.' . $data['sort_attribute'] . ' ' . $data['sort_type'];

        $sql = "SELECT tbl_tier.* FROM tbl_tier";
        $sql = $sql . " Where 1 ";
        if (isset($data['status']) && $data['status'] != '') {
            $sql = $sql . "And tbl_tier.status = " . $data['status'] . " ";
        }
        if (isset($data['name']) && $data['name'] != '') {
            $sql = $sql . "And tbl_tier.name LIKE '%" . $data['name'] . "%' ";
        }

        $sql = $sql . $sql_order_by;
        $sql = $sql . " Limit " . $data['limitstart'] . ", " . $data['limitnum'];
        $tiers = Tier::model()->findAllBySql($sql);

        $criteria = new CDbCriteria();
        if (isset($data['name']) && $data['name'] != '') {
            $criteria->addCondition("name LIKE '%".$data['name']."%'");
        }
        if (isset($data['status']) && $data['status'] != '') {
            $criteria->compare('status', $data['status'], true);
        }

        $total = Tier::model()->count($criteria);

        $result['totalresults'] = $total;
        if ($tiers != null && count($tiers) > 0) {
            $result['tiers'] = self::convertListTier($tiers);
            $result['success'] = true;
        } else {
            $result['success'] = true;
            $result['tiers'] = array();
        }
        return $result;
    }

    public static function getTierById($data) {
        $result = array();
        $get_empty_tier_error = TierService::getEmptyTierError();
        $result['tier_error'] = $get_empty_tier_error['tier_error'];
        $tier = Tier::model()->findByPk($data['id']);
        if ($tier) {
            $result['success'] = true;
            $result['tier'] = self::convertTier($tier);
        } else {
            $result['success'] = false;
            $result['message'] = 'Tier \'s not found!';
        }
        return $result;
    }

    public static function create($data) {
        $result = array();

        $tier = new Tier();
        $tier->attributes = $data;
        $tier = self::beforeSave($tier);
        if ($tier->validate()) {
            $tier->save();
            $result['success'] = true;
            $result['id'] = $tier->id;
        } else {
            $empty_tier_error = TierService::getEmptyTierError();
            $result['tier_error'] = $empty_tier_error['tier_error'];
            foreach ($tier->getErrors() as $key => $error_array) {
                $result['tier_error'][$key] = $error_array;
            }
            $result['success'] = false;
            $result['message'] = 'Creating Tier has some errors';
        }
        return $result;
    }

    public static function update($data) {
        $result = array();
        if (isset($data['id'])) {
            unset($data['created_time']);
            $tier = Tier::model()->findByPk((int) $data['id']);
            if ($tier) {
                $tier->attributes = $data;
                $tier = self::beforeSave($tier);
                if ($tier->validate()) {
                    if ($tier->save()) {
                        $result['success'] = true;
                        $result['id'] = $tier->id;
                        $tier_array = TierService::getTierById(array('id' => $tier->id));
                        $result['tier'] = $tier_array['tier'];
                        $result['message'] = 'Tier updated!';
                    } else {
                        $result['success'] = false;
                        $result['message'] = CHtml::errorSummary($tier);
                    }
                } else {
                    $empty_tier_error = TierService::getEmptyTierError();
                    $result['tier_error'] = $empty_tier_error['tier_error'];
                    foreach ($tier->getErrors() as $key => $error_array) {
                        $result['tier_error'][$key] = $error_array;
                    }
                    $result['success'] = false;
                    $result['message'] = 'Update Tier has some errors';
                }
            } else {
                $result['success'] = false;
                $result['message'] = 'Tier \'s not found!';
            }
        } else {
            // Create new category
            $tier = new Tier();
            $tier->attributes = $data;
            if ($tier->save()) {
                $result['success'] = true;
                $result['id'] = $tier->id;
                $tier_array = TierService::getTierById(array('id' => $tier->id));
                $result['tier'] = $tier_array['tier'];
                $result['message'] = 'Tier created!';
            } else {
                $result['success'] = false;
                $result['message'] = CHtml::errorSummary($tier);
            }
        }

        return $result;
    }

    public static function beforeSave($tier) {
        if ($tier->isNewRecord) {
            $tier->created_time = time();
        }
        $tier->status = 1;
        return $tier;
    }

    public static function convertListTier($tiers) {
        $result = array();
        if ($tiers != null && count($tiers) > 0) {
            foreach ($tiers as $tier) {
                $result[] = self::convertTier($tier);
            }
        }
        return $result;
    }

    public static function convertTier($tier) {
        $result = array(
            'id' => $tier->id,
            'name' => $tier->name,
            'status' => $tier->status,
            'created_time' => date('d-m-Y', $tier->created_time),
            'is_edit' => false,
        );
        return $result;
    }

    public static function removeTier($data) {
        $result = array();
        $tier = Tier::model()->findByPk((int) $data['id']);
        $tier->attributes = $data;

        if ($tier->delete()) {
            $result['success'] = true;
            $result['message'] = 'Tier deleted!';
        } else {
            $result['success'] = false;
            $result['message'] = CHtml::errorSummary($tier);
        }

        return $result;
    }

}
