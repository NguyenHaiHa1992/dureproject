<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Yii Blog Demo',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.modules.dev.models.AuthItem',
        'application.modules.dev.models.AuthItemChild',
        'application.modules.dev.models.AuthAssignment',
        'application.components.*',
        'application.extensions.yii-mail.*',
        'application.extensions.YiiMailer.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin123',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        //'ipFilters'=>array('118.70.185.68','::1'),
        ),
        'admin' => array(
            'defaultController' => 'site/index',
        ),
        'api',
        'dev' => array(
            'password' => 'admin123',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),
    'defaultController' => 'post',
    // application components
    'components' => array(
        'user' => array(
            'class' => 'iPhoenixUser',
            'loginUrl' => false,
            'stateKeyPrefix' => 'admin_',
            'allowAutoLogin' => true,
        ),
        // 'db'=>array(
        // 'connectionString' => 'sqlite:protected/data/blog.db',
        // 'tablePrefix' => 'tbl_',
        // ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dureproject',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                'post/<id:\d+>/<title:.*?>' => 'post/view',
                'posts/<tag:.*?>' => 'post/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => 'authassignment',
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'mail.bmdemosite12.com',
                'username' => 'system@bmdemosite12.com',
                'password' => 'sfl@123',
                'port' => '25',
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);
