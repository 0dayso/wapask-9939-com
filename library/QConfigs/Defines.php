<?php
class QConfigs_Defines {
	public static function setVaribles($env = 'rls') {
		
		//==================================== 2015-12-11: 新增 【热搜】、【专题】部分 Start =================================================//
		//缓存文件路径
		defined("Q_WWW_PATH") or  define("Q_WWW_PATH", APP_ROOT);
		defined("APP_CACHE_PATH") or define("APP_CACHE_PATH", __ROOT__."/cache");//缓存文件路径
        defined("APP_CACHE_PREFIX") or define("APP_CACHE_PREFIX","M-9939-COM_");//缓存前缀
		
		//视图助手
		$view = new Zend_View();
		$view->setScriptPath(APP_ROOT.'/application/modules/wap/views/scripts/templates');
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view)->setViewSuffix('php');
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		Zend_Registry::set("view",$view);
		//==================================== 2015-12-11: 新增 【热搜】、【专题】部分 End =================================================//
        
        define('Q_CONFIG_PATH', APP_ROOT.'/config/');
        switch ($env) {
			case 'local' :
            {
                define('RELEASE_ENV', 'local');
                define('CONFIG_ENV','local');
                define("APP_CONFIG_FILE", APP_ROOT . "/config/app_local.ini");
				break;
            }
			case 'rls' :
            default:
            {
                define('RELEASE_ENV', 'rls');
                define('CONFIG_ENV','');
                define("APP_CONFIG_FILE", APP_ROOT . "/config/app.ini");
				break; 
            }
		}
        
        //数据库配置
        $db_v2_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2_write');
        $db_v2_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2_read');
        $db_v2sns_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2sns_write');
        $db_v2sns_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2sns_read');
        $db_dzjb_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_dzjb_write');
        $db_dzjb_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_dzjb_read');
        $db_lady_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_lady_write');
        $db_lady_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_lady_read');
        $db_tongji_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_tongji_write');
        $db_tongji_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_tongji_read');

        //gaoqing 新增：新疾病库 2016-06-16 Start
        $db_v2jb_write = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2jb_write');
        $db_v2jb_read = new Zend_Config_Ini(APP_CONFIG_FILE, 'db_v2jb_read');
        //gaoqing 新增：新疾病库 2016-06-16 End

        $common_config=new Zend_Config_Ini(APP_CONFIG_FILE, 'common');
        
        Zend_Registry::set("db_v2_write", $db_v2_write->db->toArray());
        Zend_Registry::set("db_v2_read", $db_v2_read->db->toArray());
        Zend_Registry::set("db_v2sns_write", $db_v2sns_write->db->toArray());
        Zend_Registry::set("db_v2sns_read",$db_v2sns_read->db->toArray());
        Zend_Registry::set("db_dzjb_write",$db_dzjb_write->db->toArray());
        Zend_Registry::set("db_dzjb_read",$db_dzjb_read->db->toArray());
        Zend_Registry::set("db_lady_write",$db_lady_write->db->toArray());
        Zend_Registry::set("db_lady_read",$db_lady_read->db->toArray());
        Zend_Registry::set("db_tongji_write",$db_tongji_write->db->toArray());
        Zend_Registry::set("db_tongji_read",$db_tongji_read->db->toArray());
        Zend_Registry::set("common_config",$common_config->common->toArray());

        //gaoqing 新增：新疾病库 2016-06-16 Start
        Zend_Registry::set("db_v2jb_write",$db_v2jb_write->db->toArray());
        Zend_Registry::set("db_v2jb_read",$db_v2jb_read->db->toArray());
        //gaoqing 新增：新疾病库 2016-06-16 End
        
        $GLOBALS['db_jb_obj'] = Zend_Db::factory('PDO_MYSQL',Zend_Registry::get("db_v2jb_read"));
        $GLOBALS['db_www_obj'] = Zend_Db::factory('PDO_MYSQL',Zend_Registry::get("db_v2_read"));
        $db_default = Zend_Db::factory('PDO_MYSQL',Zend_Registry::get("db_v2sns_write"));
        Zend_Db_Table::setDefaultAdapter($db_default);
        
        
        //执行旧的数据库配置
        self::executeOldDBSetting(
        		$db_v2jb_read->db->toArray(), 
        		$db_v2_read->db->toArray(),
        		$db_v2sns_read->db->toArray()
        );
	}
	
	private static function executeOldDBSetting($com_dzjb, $com_v2, $com_v2sns) {
		
		$db = Zend_Db::factory('PDO_MYSQL', $com_dzjb);
		Zend_Db_Table::setDefaultAdapter($db);
		
		$dbzx = Zend_Db::factory('PDO_MYSQL', $com_v2);
		$GLOBALS['dbzx']=$dbzx;
		
		$dbwd = Zend_Db::factory('PDO_MYSQL', $com_v2sns);
		$GLOBALS['dbwd']=$dbwd;
	}
	
}
