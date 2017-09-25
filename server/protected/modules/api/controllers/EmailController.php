<?php

class EmailController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                //'roles'=>array('AMP Master Admin'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionInit() {
        $data = EmailService::data();
        $result = EmailService::init($data);
        $this->returnJson($result);
    }

    public function actionSend() {
        set_time_limit(0);
        $data = EmailService::data();
        $check_result = true;
        $error_message = array();

        $email = $data['email'];
        $email_subject = $email['subject'];
        $email_content = $email['content'];
        $email_from = $email['from'];

        if (isset($email['to']) && $email['to'] != '') {
            $email_address = $email['to'];
            // Get list cc emails
            $cc_emails = array();
            if (isset($email['cc']) && is_array($email['cc'])) {
                foreach ($email['cc'] as $email) {
                    $cc_emails[] = $email['text'];
                }
            }
            $email_to_array = explode(',', $email['to']);
            $email_to = array();
            foreach($email_to_array as $email_to_array_item){
                $email_to[] = trim($email_to_array_item);
            }
            switch ($data['type']) {
                case 'document':
                    // Send email
                    $email_to_send = new YiiMailMessage ();
                    $email_to_send->setTo($email_to);
                    foreach ($cc_emails as $c_e) {
                        $email_to_send->addCC($c_e);
                    }
                    $email_to_send->from = $email_from;
                    $email_to_send->setSubject($email_subject);
                    $email_to_send->setBody($email_content, 'text/html');
                    foreach ($email['documents'] as $document) {
                        $swiftAttachment = Swift_Attachment::fromPath(Yii::getPathOfAlias('webroot') . '/' . $document['dirname'] . '/' . $document['filename'] . '.' . $document['extension']);
                        $email_to_send->attach($swiftAttachment);
                    }

                    if (Yii::app()->mail->send($email_to_send)) {
                        $check_result = true;
                    } else {
                        $check_result = false;
                        $error_message[] = 'Can not send email to ' . $email['to'];
                    }

                    break;

                default:
                    # code...
                    break;
            }

            if ($check_result)
                $result = array('success' => true, 'message' => 'Your message has been sent!');
            else
                $result = array('success' => false, 'message' => $error_message);
        }
        else {
            $result = array('success' => false, 'message' => 'Address To can not be empty!');
        }

        $this->returnJson($result);
    }

    public function actionPreview() {
        $data = EmailService::data();
        $check_result = true;
        $error_message = array();

        $email = $data['email'];

        if (isset($email['to']) && $email['to'] != '') {
            $email_address = $email['to'];
            switch ($data['type']) {
                case 'order':
                    $option = isset($data['option']) ? $data['option'] : "";

                    $purchase_order = PurchaseOrder::model()->findByPk($data['id']);

                    if (isset($purchase_order)) {
                        if (isset($purchase_order->client)) {
                            // Get client info
                            $client = $purchase_order->client;

                            // Create detail PO html
                            $criteria = new CDbCriteria();
                            $criteria->compare('purchase_order_id', $purchase_order->id);
                            $list_po_detail = PurchaseOrderDetail::model()->findAll($criteria);

                            $criteria = new CDbCriteria();
                            $criteria->compare('purchase_order_id', $purchase_order->id);
                            $list_po_items = PurchaseOrderItem::model()->findAll($criteria);

                            $detail = $this->renderPartial('_purchase_oder_detail_template', array(
                                'purchase_order' => $purchase_order,
                                'list_po_detail' => $list_po_detail,
                                'list_po_items' => $list_po_items,
                                'option' => $option
                                    ), true, true);

                            // Create html
                            $html = $this->renderPartial('_email_template', array(
                                'header' => $purchase_order->po_code . ' - Request Order',
                                'name' => $client->name,
                                'email' => $client->email,
                                'address' => $client->address1,
                                'phone' => $client->phone,
                                'subject' => $email['subject'],
                                'po_code' => $purchase_order->po_code,
                                'content' => '<div style="padding:5px"><p>' . nl2br($email['content']) . '</p></div><div style="padding: 5px;">' . $detail . "</div>",
                                'link' => Yii::app()->createAbsoluteUrl('api/site/orderReply', array(
                                    'id' => $purchase_order->id,
                                    'key' => sha1($purchase_order->id . '_accept_' . Yii::app()->params['default_salt']),
                                    'action' => 'accept'
                                )),
                                'decline_link' => Yii::app()->createAbsoluteUrl('api/site/orderReply', array(
                                    'id' => $purchase_order->id,
                                    'key' => sha1($purchase_order->id . '_decline_' . Yii::app()->params['default_salt']),
                                    'action' => 'decline'
                                )),
                                    ), true);

                            // Create attachment pdf
                            // Check whether file exists
                            $po_code = preg_replace('/\s+/', '_', $purchase_order->po_code);
                            $po_file = $po_code . '_Order' . ucfirst($option);
                            $check_file = $po_file;
                            $i = 1;
                            while (file_exists(Yii::getPathOfAlias('webroot') . '/data/pdf/' . $check_file . '.pdf')) {
                                $check_file = $po_file . '_' . $i;
                                $i++;
                            }

                            $po_file = $check_file;

                            $detail_pdf = Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/modules/api/views/email/_purchase_order_pdf_template.php', array(
                                'purchase_order' => $purchase_order,
                                'list_po_detail' => $list_po_detail,
                                'list_po_items' => $list_po_items,
                                'option' => $option
                                    ), true, true);

                            iPhoenixUrl::exportPdfFromHTML($detail_pdf, $po_file, 'landscape');

                            $result = array(
                                'success' => true,
                                'email_preview' => array(
                                    'attachment' => array(
                                        'url' => Yii::app()->getBaseUrl(true) . '/data/pdf/' . $po_file . '.pdf',
                                        'filename' => $po_file . '.pdf'
                                    ),
                                    'from' => $email['from'],
                                    'to' => $email['to'],
                                    'subject' => $email['subject'],
                                    'content' => $html,
                                )
                            );
                        } else {
                            $result = array(
                                'success' => false,
                                'message' => 'Can not find client of this Order!'
                            );
                        }
                    }

                    break;

                default:
                    # code...
                    break;
            }
        } else {
            $result = array('success' => false, 'message' => 'Address To can not be empty!');
        }

        $this->returnJson($result);
    }

    public function actionChangeVersionTemplate() {
        $data = EmailService::data();
        $result = EmailService::changeVersionTemplate($data);
        $this->returnJson($result);
    }

}

?>