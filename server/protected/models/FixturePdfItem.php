<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StorePdfItem
 *
 * @author hanguyenhai
 */
class FixturePdfItem extends ObjectPdfItem{
    public function tableName()
    {
        return '{{fixture}}';
    }
    public $a = "";
    public $b = "";
    public $c = "";
    public $d = "";
    public $e = "";
    public $f = "";
    public $g = "";
    public $h = "";

    public function __construct($a = "", $b = "", $c = "", $d = "", $e = "", $f = "", $g = "", $h = "") {
        $this->objectClass = 'FixturePdfItem';
        if(isset($a)){
            $this->a = $a;
        }
        if(isset($b)){
            $this->b = $b;
        }
        if(isset($c)){
            $this->c = $c;
        }
        if(isset($d)){
            $this->d = $d;
        }
        if(isset($e)){
            $this->e = $e;
        }
        if(isset($f)){
            $this->f = $f;
        }
        if(isset($g)){
            $this->g = $g;
        }
        if(isset($h)){
            $this->h = $h;
        }
    }


    public static function getListAttributes($id){
        $object = Fixture::model()->findByPk($id);
        if(!$object){
            return [];
        }
        return [
            'Code' => $object->code,
            'Category' => $object->category ? $object->category->name : "",
            'Size' => $object->size,
            'Location' => $object->location,
            'Vendor' => $object->vendor,
            'Description' => $object->description,
        ];
    }
}
