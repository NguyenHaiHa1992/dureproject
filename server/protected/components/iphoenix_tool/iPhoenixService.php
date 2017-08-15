<?php
class iPhoenixService{

	/**
	 * Get data submited by the client
	 */
	public static function data()
	{
		$request = file_get_contents('php://input');
		$data = array();
		if ($request && $request != '{}') {
			if ($json_post = CJSON::decode($request)){
				$data = $json_post;
			}else{
				parse_str($request,$variables);
				$data = $variables;
			}
		}

		$list_params = array_merge($_GET,$_POST, $_FILES);

		foreach($list_params as $index=>$param){
			if ($param) {
				if(is_array($param)){
					$data[$index]=$param;
				}
				else{
					if (CJSON::decode($param)){
						$data[$index]=CJSON::decode($param);
					}else{
						$data[$index]=$param;
					}
				}
			}
		}

		return $data;
	}
        
        public static function copyRelate($modelName = null, $attr = null, $attrValue = null, $attrValueNew = null){
            if(!$modelName || !$attr || !$attrValue || !$attrValueNew){
                return null;
            }
            $objects = $modelName::model()->findAllByAttributes([
                $attr => $attrValue,
            ]);
            $i = 1;
            foreach ($objects as $object) {
                $objectNew = new $modelName;
                $objectNew->attributes = $object->attributes;
                if($modelName == 'StoreSignage' || $modelName == 'StoreFixture'){
                    $objectNew->code = time()."_".$i."_".CustomEnum::COPY_CODE.$object->code;
                }
                $objectNew->$attr = $attrValueNew;
                $objectNew->save(false);
                $i++;
            }
        }
}
