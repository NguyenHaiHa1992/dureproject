<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomHelper
 *
 * @author nguye
 */
class CustomHelper {
    public static function getColumnImgAttribute($column){
        if(!$column){
            return "";
        }
        $tmp = explode(CustomEnum::COLUMN_IMG, $column->name);
        return isset($tmp[1]) ? $tmp[1] : $column->name;
    }

    public static function convertColumnImgHead($column){
        if(!$column){
            return "";
        }
        $tmp = explode(CustomEnum::COLUMN_IMG, $column->name);
        $head1 = $column->grid->dataProvider->model->getAttributeLabel($tmp[1]);
        if(strlen($head1) >= CustomEnum::COLUMN_IMG_LENGTH){
            return $head1;
        }
        $head = $head1;
        for($i = 0; $i < CustomEnum::COLUMN_IMG_LENGTH - strlen($head1); $i++){
            $head .= " ";
        }
        return $head;
    }
}
