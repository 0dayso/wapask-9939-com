<?php 
if(!defined("G_CONFIG_INIT")){
    date_default_timezone_set('Asia/Shanghai');
    defined('__PUBLIC__') || define('__PUBLIC__', dirname(__FILE__));
    defined('__ROOT__')   || define('__ROOT__', dirname(dirname(__FILE__)));
    defined('__CONFIG__') || define('__CONFIG__', __ROOT__.'/config');
    defined('__DOMAINURL__') or define('__DOMAINURL__','http://m.9939.com');
    defined('APP_ROOT')   || define('APP_ROOT', __ROOT__);

    //defined("FRAMEWORK_PATH") or define("FRAMEWORK_PATH", "/data/www/develop/code/trunk");
    defined("FRAMEWORK_PATH") or define("FRAMEWORK_PATH","/data/web/framework");
    defined("ZEND_PATH") or define("ZEND_PATH", FRAMEWORK_PATH . '/QFramework2.0');
    //设置包含文件查询路径
    set_include_path(implode(PATH_SEPARATOR, array(
        __ROOT__.'/library',ZEND_PATH,
        get_include_path(),
    )));

    /****************************************************
     * 说明：此自动加载会与Smarty的自动加载冲突
     * 2013-05-01
        require_once 'Zend/Loader.php';
        function __autoload($classname)
        {
            Zend_Loader::loadClass($classname);
        }
    ****************************************************/

    require_once "Zend/Loader/Autoloader.php";
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace(array('App','Helei', 'Q',  'QConfigs',  'QLib',  'QModels'));
    QConfigs_Defines::setVaribles();
    define("G_CONFIG_INIT", 'Y');//是否初始化
}