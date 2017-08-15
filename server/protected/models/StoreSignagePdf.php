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
class StoreSignagePdf extends CActiveRecord{
    public function tableName()
    {
        return '{{store_signage}}';
    }
    public $objectClass = "";
    public $code = "";
    public $signage_quantity = "";
    public $description = "";
    public $store_name = "";
    public $store_number = "";
    public $tier_name = "";
    public $contact_name = "";
    public $franchisee_name = "";
    public $no = "";
    public $img__image_id = "";
    public $img__example_image = "";
    public $image_id = "";
    public $example_image = "";
    public $size = "";
    public $province = "";

    public function __construct($no = "", $img__image_id = "", $img__example_image = "", $code = "", $size = "", 
            $store_name = "", $province = "", $signage_quantity = "", $description = "", $store_number = "", 
            $tier_name = "", $contact_name = "", $franchisee_name = "") {
        $this->objectClass = 'StoreSignagePdf';
        if(isset($code)){
            $this->code = $code;
        }
        if(isset($img__image_id)){
            $this->img__image_id = $img__image_id;
        }
        if(isset($img__example_image)){
            $this->img__example_image = $img__example_image;
        }
        if(isset($signage_quantity)){
            $this->signage_quantity = $signage_quantity;
        }
        if(isset($description)){
            $this->description = $description;
        }
        if(isset($store_name)){
            $this->store_name = $store_name;
        }
        if(isset($store_number)){
            $this->store_number = $store_number;
        }
        if(isset($tier_name)){
            $this->tier_name = $tier_name;
        }
        if(isset($contact_name)){
            $this->contact_name = $contact_name;
        }
        if(isset($franchisee_name)){
            $this->franchisee_name = $franchisee_name;
        }
        if(isset($no)){
            $this->no = $no;
        }
        if(isset($size)){
            $this->size = $size;
        }
        if(isset($province)){
            $this->province = $province;
        }
    }

    public function rules() {
        return array(
            array('no, code, img__image_id, img__example_image, signage_quantity, description, '
                . 'store_name, store_number, tier_name, contact_name, franchisee_name, '
                . 'image_id, example_image, size, province', 'safe'),
        );
    }
}
