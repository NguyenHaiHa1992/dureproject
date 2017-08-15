<?php

class DevModule extends CWebModule {

    public $password;
    public $ipFilters;

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        Yii::app()->setComponents(array(
            'user' => array(
                'class' => 'CWebUser',
                'stateKeyPrefix' => 'dev',
                'loginUrl' => Yii::app()->createUrl($this->getId() . '/default/login'),
            ),
                ), false);
        // import the module-level models and components
        $this->setImport(array(
            'dev.models.*',
            'dev.components.*',
        ));
        //Configure layout path of module screen
        Yii::app()->theme = 'dev';
        $this->viewPath = Yii::app()->theme->basePath . '/views';
        //Disable load jquery.js
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            $route = $controller->id . '/' . $action->id;
            if (!$this->allowIp(Yii::app()->request->userHostAddress) && $route !== 'default/error')
                throw new CHttpException(403, "You are not allowed to access this page.");

            $publicPages = array(
                'default/login',
                'default/error',
            );
            if ($this->password !== false && Yii::app()->user->isGuest && !in_array($route, $publicPages))
                Yii::app()->user->loginRequired();
            else
                return true;
        } else
            return false;
    }

    /**
     * Checks to see if the user IP is allowed by {@link ipFilters}.
     * @param string $ip the user IP
     * @return boolean whether the user IP is allowed by {@link ipFilters}.
     */
    protected function allowIp($ip) {
        if (empty($this->ipFilters))
            return true;
        foreach ($this->ipFilters as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos)))
                return true;
        }
        return false;
    }

}
