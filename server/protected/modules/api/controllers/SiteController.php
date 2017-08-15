<?php

class SiteController extends Controller{

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

	public function actionOrderReply($id, $key, $action){
		$salt = Yii::app()->params['default_salt'];
		$hash = sha1($id.'_'.$action.'_'.$salt);

		if($hash == $key){
			$purchase_order = PurchaseOrder::model()->findByPk($id);
			if(isset($purchase_order)){
				$po_code = $purchase_order->po_code;
			}
			else
				$po_code = '';

			if(isset($id)){
				switch ($action) {
					case 'accept':
						$purchase_order->reply_status = PurchaseOrder::REPLY_STATUS_ACCEPT;
						$purchase_order->reply_time = time();
						if($purchase_order->save()){
							Yii::app()->user->setFlash('success', "Thank you. You have accepted the order ".$po_code."!");
							$this->redirect(Yii::app()->createUrl('api/site/index'));
						}
						break;

					case 'decline':
						$purchase_order->reply_status = PurchaseOrder::REPLY_STATUS_DECLINE;
						$purchase_order->reply_time = time();
						if($purchase_order->save()){
							Yii::app()->user->setFlash('success', "Thank you. You have declined the order ".$po_code."!");
							$this->redirect(Yii::app()->createUrl('api/site/index'));
						}
						break;

					default:
						# code...
						break;
				}
			}
		}
	}

	public function actionIndex(){
		$this->layout = 'main';
		$this->render('index');
	}

	public function actionUpdateMaterialCode(){
		$list_material = Material::model()->findAll();
		foreach($list_material as $material){
			$material_code = new MaterialCode();
			$material_code->code = $material->material_code;
			$material_code->status = 1;
			if($material_code->save()){
				$material->material_code_id = $material_code->id;
				$material->saveAttributes(array('material_code_id'));
			}
		}
	}

	public function actionTest(){
		$part_heatnumber_id = 2;

		$criteria = new CDbCriteria();
		$criteria->addCondition('heatnumber_ids Like \'%"'.$part_heatnumber_id.'"%\'');
		$find = InOutPart::model()->count($criteria);
		if($find > 0){
			$result['success'] = false;
			$result['message'] = 'This Heatnumber can not be delete because It existed in Material In/Out History!';
			echo json_encode($result);
		}
	}
}
?>