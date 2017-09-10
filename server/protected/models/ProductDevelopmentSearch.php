<?php

/**
 * @author tunglexuan <tunghus1993@gmail.com>
 */
class ProductDevelopmentSearch extends ProductDevelopment {
    
    public function attributeLabels() {
        $array =  parent::attributeLabels();
        return array_merge([
            
        ],$array);
    }
}
