<?php

class ApiModule extends CWebModule {

    public function init() {
        // import the module-level models and components
        $this->setImport(array(
            'api.services.*',
            'application.components.iphoenix_tool.*',
            'application.components.identity.*',
        ));

        //Disable load jquery.js
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        //var_dump(Yii::app()->user->id); exit;
        // import component
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'api/site/error',
            ),
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here

            return true;
        } else
            return false;
    }

}
