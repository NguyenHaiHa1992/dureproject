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
class StorePdfItem extends ObjectPdfItem{
    public function tableName()
    {
        return '{{store}}';
    }
    public $a = "";
    public $b = "";
    public $c = "";
    public $d = "";
    public $e = "";
    public $f = "";
    public $g = "";
    public $h = "";
    
    public function __construct($a = "", $b = "", $c = "", $d = "", $e = "", $f = "", 
            $g = "", $h = "") {
        $this->objectClass = 'StorePdfItem';
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
        $store = Store::model()->findByPk($id);
        if(!$store){
            return [];
        }
        return [
            'Name' => $store->name,
            'Store Number' => $store->store_number,
            'Contact Name' => $store->contact_name,
            'Franchisee Name' => $store->franchisee_name,
            'Tier' => $store->tier ? $store->tier->name : "-",
            'Email' => $store->email,
            'Phone' => $store->phone,
            'Address' => $store->address1,
            'City' => $store->city,
            'Zipcode' => $store->zipcode,
            'State' => $store->state ? $store->state->state_full : "-",
            'Country' => $store->country
        ];
    }
}
