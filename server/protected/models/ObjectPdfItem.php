<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjectPdfItem
 *
 * @author hanguyenhai
 */
class ObjectPdfItem extends CActiveRecord{
    public $objectClass = 'StorePdfItem';
    
    public function setInfo(&$model){
        if(!is_array($model)){
            return false;
        }
        $model[] = new $this->objectClass("Address:", "", "100-2240 Argentia Road", "Mississauga ON Canada L5N 2K7");
        $model[] = new $this->objectClass("Email:", CustomEnum::COMPANY_EMAIL, "", "");
        $model[] = new $this->objectClass("Phone:", CustomEnum::COMPANY_PHONE, "", "");
        $model[] = new $this->objectClass("", "", "Sent by Date", date('Y-m-d', time()));
        return true;    
    }
    
    public function setObjectInfo(&$model, $attributes = []){
        if($attributes && is_array($attributes)){
            foreach ($attributes as $name => $value) {
                $model[] = new $this->objectClass($name, $value);
            }
        }
        return true;
    }
    
    public function setRelatedSignages(&$model, $relatedSignages = [], $title = ""){
        if($relatedSignages && is_array($relatedSignages)){
            $model[] = new $this->objectClass();
            $model[] = new $this->objectClass($title);
            $model[] = new $this->objectClass("#", "Specification Image", "Example Image", "Code", "Category", 
                    "Material", "Size", "Description");
            $rsKey = 1;
            foreach ($relatedSignages as $relatedSignage) {
                $model[] = new $this->objectClass(
                    $rsKey,
                    isset($relatedSignage['signage_image_id']) ? "image||".$relatedSignage['signage_image_id'] : "",
                    isset($relatedSignage['signage_example_image']) ? "image||".$relatedSignage['signage_example_image'] : "", 
//                    isset($relatedSignage['signage_code']) ? $relatedSignage['signage_code'] : "", 
                    isset($relatedSignage['code']) ? $relatedSignage['code'] : "",
                    isset($relatedSignage['category_name']) ? $relatedSignage['category_name'] : "",
                    isset($relatedSignage['material']) ? $relatedSignage['material'] : "",
                    isset($relatedSignage['size']) ? $relatedSignage['size'] : "",
                    isset($relatedSignage['short_description']) ? $relatedSignage['short_description'] : ""
                );
                $rsKey++;
            }
        }
        return true;
    }
    
    public function setRelatedFixtures(&$model, $relatedFixtures = [], $title = ""){
        if($relatedFixtures && is_array($relatedFixtures)){
            $model[] = new $this->objectClass();
            $model[] = new $this->objectClass($title, "", "", "");
            $model[] = new $this->objectClass("#", "Image", "Code", "Category", "Description");
            $rfKey = 1;
            foreach ($relatedFixtures as $relatedFixture) {
                $model[] = new $this->objectClass(
                    $rfKey,
                    isset($relatedFixture['image_id_src']) ? "image||".$relatedFixture['image_id_src'] : "", 
                    isset($relatedFixture['code']) ? $relatedFixture['code'] : "", 
//                    isset($relatedFixture['store_fixture_code']) ? $relatedFixture['store_fixture_code'] : "",
                    isset($relatedFixture['category_name']) ? $relatedFixture['category_name'] : "",
                    isset($relatedFixture['short_description']) ? $relatedFixture['short_description'] : ""
                );
                $rfKey++;
            }
        }
        return true;
    }
    
    public function setRelatedStores(&$model, $relatedStores = [], $title = ""){
        if($relatedStores && is_array($relatedStores)){
            $model[] = new $this->objectClass();
            $model[] = new $this->objectClass($title);
            $model[] = new $this->objectClass("#", "Image", "Name", "Store Number", "Tier", "Area Manager", 
                    "Franchisee Name", "Store Address", "Country", "State/ Province", "City", "Email", "Phone");
            $rsKey = 1;
            foreach ($relatedStores as $relatedStore) {
                $model[] = new $this->objectClass(
                    $rsKey,
                    isset($relatedStore['image_id_src']) ? "image||".$relatedStore['image_id_src'] : "",
                    isset($relatedStore['name']) ? $relatedStore['name'] : "",
                    isset($relatedStore['number_store']) ? $relatedStore['number_store'] : "", 
                    isset($relatedStore['tier_name']) ? $relatedStore['tier_name'] : "",
                    isset($relatedStore['contact_name']) ? $relatedStore['contact_name'] : "",
                    isset($relatedStore['franchisee_name']) ? $relatedStore['franchisee_name'] : "",
                    isset($relatedStore['address1']) ? $relatedStore['address1'] : "",
                    isset($relatedStore['country']) ? $relatedStore['country'] : "",
                    isset($relatedStore['state_name']) ? $relatedStore['state_name'] : "",
                    isset($relatedStore['city']) ? $relatedStore['city'] : "",
                    isset($relatedStore['email']) ? $relatedStore['email'] : "",
                    isset($relatedStore['phone']) ? $relatedStore['phone'] : ""
                );
                $rsKey++;
            }
        }
        return true;
    }
    
    public function setDocuments(&$model, $documents = [], $title = ""){
        if($documents){
            $model[] = new $this->objectClass();
            $model[] = new $this->objectClass($title, "", "", "");
            if(Yii::app()->user->checkAccess('Super Admin')){
                $model[] = new $this->objectClass("No", "Name", "Restricted", "Category", "Size");
                $rdKey = 1;
                foreach ($documents as $document) {
                    $model[] = new $this->objectClass(
                        $rdKey,
                        isset($document['filename']) && isset($document['extension']) ? $document['filename'].".".$document['extension'] : "", 
                        isset($document['restricted_label']) ? $document['restricted_label'] : "",
                        isset($document['cat_name']) ? $document['cat_name'] : "",
                        isset($document['filesize_label']) ? $document['filesize_label'] : ""
                    );
                    $rdKey++;
                }
            }
            else{
                $model[] = new $this->objectClass("Name", "Category", "Size");
                foreach ($documents as $document) {
                    $model[] = new $this->objectClass(
                        isset($document['filename']) ? $document['filename'] : "", 
                        isset($document['cat_name']) ? $document['cat_name'] : "",
                        isset($document['filesize_label']) ? $document['filesize_label'] : ""
                    );
                }
            }
        }
        return true;
    }
    
    public function setSmt(&$model, $attribute = "", $value = "", $title = ""){
        if($value){
            $model[] = new $this->objectClass();
            $model[] = new $this->objectClass($title, "", "", "");
            $model[] = new $this->objectClass($attribute, $value);
        }
        return true;
    }
}
