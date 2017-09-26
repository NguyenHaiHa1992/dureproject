<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined ( 'YII_DEBUG' ) or define ( 'YII_DEBUG', true );
// specify how many levels of call stack should be shown in each log message
defined ( 'YII_TRACE_LEVEL' ) or define ( 'YII_TRACE_LEVEL', 3 );

if(isset($_SERVER['HTTP_USESSSL']) && $_SERVER['HTTP_USESSSL'] == 'on') {
    define('SCHEME','https');
    $_SERVER['HTTPS'] = 'on';
} else {
    define('SCHEME',isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'));
}
defined('DOMAIN') or define('DOMAIN' , $_SERVER['HTTP_HOST']);
defined('DOMAIN_NAME') or define('DOMAIN_NAME', SCHEME . '://' . DOMAIN );

date_default_timezone_set('EST5EDT');
require_once($yii);
Yii::createWebApplication($config)->run();
