<?php
class EmailTemplateService extends iPhoenixService{
	public static function getAll($data){
		$result= array();
		$email_templates= EmailTemplate::model()->findAllByAttributes(array('status'=> 1));
		if($email_templates!= null && count($email_templates)>0){
			$result['email_templates']= self::convertListEmailTemplate($email_templates, $data);
			$result['success']= true;
		}
		else{
			$result['success']= true;
			$result['email_templates']= array();
		}
		return $result;
	}

	public static function getEmailTemplateById($data){
		$result= array();
		$email_template;
		$email_template= EmailTemplate::model()->findByPk((int)$data['id']);
		if($email_template!= null){
			$result['success']= true;
			$result['email_template']= self::convertEmailTemplate($email_template);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại Email Template này!';
		}
		return $result;
	}
	
	public static function getEmailTemplateByName($data){
		$result= array();
		$criterial = new CDbCriteria();
		$criterial->compare('name', $data['name'], true);

		$email_template = EmailTemplate::model()->find($criterial);

		if($email_template!= null){
			$result['success']= true;
			$result['email_template']= self::convertEmailTemplate($email_template);
		}
		else{
			$result['success']= false;
			$result['message']= 'Không tồn tại Email Template này!';
		}
		return $result;
	}

	public static function create($data){
		$result= array();
		$email_template= new EmailTemplate();
		$email_template->attributes= $data;
		
		if($email_template->validate()){
			$email_template->save();	
			$result['success']= true;
			$result['id']= $email_template->id;
			$result['email_template']= self::convertEmailTemplate($email_template);
		}
		else{
			$result['success']= false;
			$result['errors']= $email_template->getErrors();
			$result['message']= 'An error has occured!';
		}
		return $result;
	}
	
	public static function update($data){
		$result= array();
		$email_template= EmailTemplate::model()->findByPk((int)$data['id']);
		$email_template->attributes= $data;

		if($email_template->validate()){
			$email_template->save();	
			$result['success']= true;
			$result['email_template']= self::convertEmailTemplate($email_template);
			$result['id']= $email_template->id;
		}
		else{
			$result['success']= false;
			$result['errors']= $email_template->getErrors();
			$result['message']= 'Có lỗi xảy ra!';
		}

		return $result;
	}
	
	public static function delete($data){
		$result= array();
		$email_template= EmailTemplate::model()->findByPk((int)$data['id']);
		if($email_template->delete()){
			$result['success']= true;
		}
		else
			$result['success']= false;

		return $result;
	}
	
	public static function convertListEmailTemplate($email_templates, $data){
		$result= array();
		$sort_attribute= array();
		if(isset($data['sort_attribute']) && isset($data['sort_type'])){
			foreach($email_templates as $email_template){
				$tmp_email_template= self::convertEmailTemplate($email_template);
				$sort_attribute[]= $tmp_email_template[$data['sort_attribute']];
				$result[]= self::convertEmailTemplate($email_template);
			}
			if($data['sort_type']== 'SORT_ASC')
				array_multisort($sort_attribute, SORT_ASC, $result);
			else
				array_multisort($sort_attribute, SORT_DESC, $result);
		}
		else{
			foreach($email_templates as $email_template){
				$result[]= self::convertEmailTemplate($email_template);
			}
		}
		return $result;
	}
	
	public static function convertEmailTemplate($email_template){return array(
					'id'=> $email_template->id,
					'name'=> $email_template->name,
					'content'=> $email_template->content,
					'content_html'=> nl2br($email_template->content),
					'subject'=> $email_template->subject,
					'description'=> $email_template->description,
					'author'=> isset($email_template->created_by)?$email_template->author->name:"N/A",
					'created_time'=> date('d-m-Y', $email_template->created_time),
					);
	}
}
