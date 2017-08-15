<?php

class SettingController extends Controller{

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app ()->errorHandler->error) {
			if (Yii::app ()->request->isAjaxRequest)
				echo $error ['message'];
			else
				$this->render( 'error', $error );
		}
	}

	public function actionGet(){
		$data= iPhoenixService::data();
		$setting_value = Setting::g($data['name']);
		$result = array(
			'success'=>true,
			'value'=>$setting_value
		);
		$this->returnJson($result);
	}

	public function actionSet(){
		$data= iPhoenixService::data();

		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $data['name'] );
		$setting = Setting::model ()->find ( $criteria );
		if (isset ( $setting )){
			$setting->value = $data['value'];

			if($setting->save()){
				$result = array(
					'success'=>true,
					'message'=>$data['name'].' saved!'
				);
			}
			else{
				$result = array(
					'success'=>false,
					'message'=>CHtml::errorSummary($setting)
				);
			}
		}
		else{
			$result = array(
				'success'=>false,
				'message'=>'Can not find '.$data['name']
			);
		}

		$this->returnJson($result);
	}
}
?>