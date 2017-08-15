<?php
/**
 * Description of FixtureCatGenService
 *
 * @author hanguyenhai
 */
class FixtureCatGenService extends iPhoenixService{
    public static function getAll($data = []){
        $result= array();
        $categories= FixtureGeneralCategory::model()->findAllByAttributes(array('status'=> 1));
        if($categories!= null && count($categories)>0){
            $result['categories']= self::convertList($categories);
            $result['success']= true;
        }
        else{
            $result['success']= true;
            $result['categories']= array();
        }
        return $result;
    }
    
    public static function update($data){
        $result = array();
        if (isset($data['id'])) {
            $categoryFind = FixtureGeneralCategory::model()->findByPk((int) $data['id']);
            if(!$categoryFind){
                $result['success'] = false;
                $result['message'] = 'Category \'s not found!';
                return $result;
            }
            $categoryFind->attributes = $data;
            $category = self::beforeSave($categoryFind);
            if ($category->validate()) {
                if(!$category->save()){
                    $result['success'] = false;
                    $result['message'] = CHtml::errorSummary($fixture_category);
                    return $result;
                }
                $result['success'] = true;
                $result['id'] = $category->id;
                $result['category'] = self::convertItem($category);
                $result['message'] = 'General category updated!';
            } else {
                $getEmptyCategoryError = self::getEmptyCategoryError();
                $result['category_error'] = $getEmptyCategoryError['category_error'];
                foreach ($category->getErrors() as $key => $error_array) {
                    $result['category_error'][$key] = $error_array;
                }
                $result['success'] = false;
                $result['message'] = 'Update general category has some errors';
            }
        } else {
            // Create new category
            $new_category = new FixtureGeneralCategory();
            $new_category->attributes = $data;
            if ($new_category->save()) {
                $result['success'] = true;
                $result['id'] = $new_category->id;
                $result['category'] = self::convertItem($new_category);
                $result['message'] = 'General category created!';
            } else {
                $result['success'] = false;
                $result['message'] = CHtml::errorSummary($new_category);
            }
        }
        return $result;
    }

    public static function convertList($categories){
        $result= array();
        if($categories!= null && count($categories)>0){
            foreach($categories as $category){
                $result[]= self::convertItem($category);
            }
        }
        return $result;
    }

    public static function convertItem($category){
        $result= array(
            'id'=> $category->id,
            'name'=> $category->name,
            'status'=> $category->status,
            'created_time_converted'=> date('d-m-Y', $category->created_time),
            'is_edit'=>false,
        );
        return $result;
    }
    
    public static function getEmptyCategoryError() {
        $result = array();
        $category = array(
            'id' => array(),
            'name' => array(),
            'status' => array(),
            'created_time' => array(),
            'is_edit' => array(),
        );
        $result['category_error'] = $category;
        $result['success'] = true;
        return $result;
    }
    
    public static function beforeSave($category){
        if($category->isNewRecord){
            $category->created_time= time();
        }
        $category->status= 1;
        return $category;
    }
    
    public static function removeCategory($data) {
        $result = array();
        $category = FixtureGeneralCategory::model()->findByPk((int) $data['id']);
        if ($category->delete()) {
            $result['success'] = true;
            $result['message'] = 'General category deleted!';
        } else {
            $result['success'] = false;
            $result['message'] = CHtml::errorSummary($category);
        }
        return $result;
    }

}
