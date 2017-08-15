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
class SignagePdfItem extends ObjectPdfItem{
    public function tableName()
    {
        return '{{signage}}';
    }
    public $a = "";
    public $b = "";
    public $c = "";
    public $d = "";
    public $e = "";
    public $f = "";
    public $g = "";
    public $h = "";
    public $i = "";
    public $j = "";
    public $k = "";
    public $l = "";
    public $m = "";

    public function __construct($a = "", $b = "", $c = "", $d = "", $e = "", $f = "", $g = "", $h = "",
                                $i = "", $j = "", $k = "", $l = "", $m = "") {
        $this->objectClass = 'SignagePdfItem';
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
        if(isset($i)){
            $this->i = $i;
        }
        if(isset($j)){
            $this->j = $j;
        }
        if(isset($k)){
            $this->k = $k;
        }
        if(isset($l)){
            $this->l = $l;
        }
        if(isset($m)){
            $this->m = $m;
        }
    }


    public static function getListAttributes($id){
        $object = Signage::model()->findByPk($id);
        if(!$object){
            return [];
        }
        return [
            'Code' => $object->code,
            'Category' => $object->category ? $object->category->name : "",
            'Location' => $object->location,
            'Size' => $object->size,
            'Material' => $object->material,
            'Vendor' => $object->vendor,
            'Mounting' => $object->getMountingLabel(),
            'Changes Seasonally' => $object->getChangesSeasonallyLabel(),
            'Power Required' => $object->getPowerRequiredLabel(),
            'Language' => $object->getLanguageLabel(),
            'Description' => $object->description,
        ];
    }
}
