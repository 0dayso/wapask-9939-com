<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

//设置 session 文件保存地址
//ini_set("session.save_path", "/home/web/wapask-9939-com/sess");
//设置cookie 的过期时间 【2 周】
//ini_set("session.cookie_lifetime", 1209600);
//session_get_cookie_params(1209600);
//设置 session 的过期时间 【2 周】
//session_cache_expire(1209600);
//设置 session 文件的过期时间【2 周】
//ini_set('session.gc_maxlifetime',1209600);

defined("FRAMEWORK_PATH") or define("FRAMEWORK_PATH", "/data/www/develop/code/trunk");
//defined("FRAMEWORK_PATH") or define("FRAMEWORK_PATH","/data/web/framework");
defined("ZEND_PATH") or define("ZEND_PATH", FRAMEWORK_PATH . '/QFramework2.0');

//定义系统模块路径
defined('__PUBLIC__') || define('__PUBLIC__', dirname(__FILE__));
defined('__ROOT__') || define('__ROOT__', dirname(dirname(__FILE__)));
defined('APP_ROOT') || define('APP_ROOT', __ROOT__);
defined('__CONFIG__') || define('__CONFIG__', __ROOT__ . '/config');

//设置包含文件查询路径
set_include_path(implode(PATH_SEPARATOR, array(
    __ROOT__ . '/library', ZEND_PATH,
    get_include_path(),
)));

/* * **************************************************
 * 说明：此自动加载会与Smarty的自动加载冲突
 * 2013-05-01
  require_once 'Zend/Loader.php';
  function __autoload($classname)
  {
  Zend_Loader::loadClass($classname);
  }
 * ************************************************** */

require_once "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace(array('App', 'Helei', 'Q', 'QConfigs', 'QLib', 'QModels'));


// +-------------------------------------------------------------------------
// | 读取站点配置文件，获取配置信息
// | Edit By Helei @ 2014-01-21
// +-------------------------------------------------------------------------
$siteconf = new Zend_Config_Xml(__CONFIG__ . '/SiteConfig.xml');
defined('__TITLE__') || define('__TITLE__', $siteconf->Title);
defined('__KEYWORDS__') || define('__KEYWORDS__', $siteconf->Keywords);
defined('__DESCRIPTION__') || define('__DESCRIPTION__', $siteconf->Description);
defined('__SKIN__') || define('__SKIN__', $siteconf->Skin);
defined('__UploadDir__') || define('__UploadDir__', $siteconf->UploadDir);


// +-------------------------------------------------------------------------
// | 定义前端控制器 
// | Edit By Helei @ 2013/02/24 16:20
// +-------------------------------------------------------------------------
$front = Zend_Controller_Front::getInstance();

//设置视图属性
$front->setParam('noViewRenderer', true);

//创建路由
$router = $front->getRouter();
$routers = require '../application/router.php';
$router->addRoutes($routers);

//============================ 2015-12-11: 新增 【热搜】、【专题】部分 Start ==========================//
QConfigs_Defines::setVaribles('local');
//============================ 2015-12-11: 新增 【热搜】、【专题】部分 End ==========================//

/* * ************* 新增部分 @author gaoqing 2015-08-27 Start *********************** */
//设置默认的控制器
$front->setDefaultControllerName("Askdoctor");

//定义 home 的基本地址
defined("HOME_BASE_URL") or define("HOME_BASE_URL", "http://home.9939.com");
//定义 问答 的基本地址
defined("ASK_BASE_URL") or define("ASK_BASE_URL", "http://ask.9939.com");

//Zend_Session::start();
//开启局部缓存
$config = new Zend_Config_Ini('session.ini', 'production');
Zend_Session::setOptions($config->toArray());

/* * ************* 新增部分 @author gaoqing 2015-08-27 End *********************** */

//设置参数
$front->addModuleDirectory(__ROOT__ . '/application/modules');
$front->setDefaultModule('wap');
$front->throwExceptions(true);

$front->dispatch();







