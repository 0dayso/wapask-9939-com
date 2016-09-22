<?php

class QModels_Base_Table extends Zend_Db_Table {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 截取字符串
     * @author gaoqing
     * 2015年8月31日
     * @param string $initStr 被截取的字符串
     * @param int $cutLen 截取的长度
     * @param int $appendFlag 是否追加 " ... " 标识（0：不追加；1：追加）
     * @return string 截取后的字符串
     */
    protected function cutString($initStr, $cutLen, $appendFlag = 0) {
    	$cutStr = "";
    
    	if (isset($initStr) && !empty($initStr)) {
    		 
    		//得到被截取字符串的长度
    		$initStrLen = mb_strlen($initStr, 'utf-8');
    		 
    		//被截取字符串长度 < 指定截取数
    		if ($initStrLen < $cutLen) {
    			$cutStr = $initStr;
    
    			//被截取字符串长度 > 指定截取数
    		}else {
    			if ($appendFlag == 1) {
    				$tempStr = mb_substr($initStr, 0, $cutLen, 'utf-8');
    				$cutStr = $tempStr . "...";
    			}else {
    				$cutStr = mb_substr($initStr, 0, $cutLen, 'utf-8');
    			}
    		}
    	}
    	return $cutStr;
    }
    
    public function init() {
        $this->db_v2_write = $this->factory(Zend_Registry::get('db_v2_write'));
        $this->db_v2_read = $this->factory(Zend_Registry::get('db_v2_read'));

        $this->db_v2sns_write = $this->factory(Zend_Registry::get('db_v2sns_write'));
        $this->db_v2sns_read = $this->factory(Zend_Registry::get('db_v2sns_read'));

        $this->db_dzjb_write = $this->factory(Zend_Registry::get('db_dzjb_write'));
        $this->db_dzjb_read = $this->factory(Zend_Registry::get('db_dzjb_read'));

        $this->db_lady_write = $this->factory(Zend_Registry::get('db_lady_write'));
        $this->db_lady_read = $this->factory(Zend_Registry::get('db_lady_read'));

        $this->db_tongji_write = $this->factory(Zend_Registry::get('db_tongji_write'));
        $this->db_tongji_read = $this->factory(Zend_Registry::get('db_tongji_read'));

        //gaoqing 新增：新疾病库 2016-06-16 Start
        $this->db_v2jb_write = $this->factory(Zend_Registry::get('db_v2jb_write'));
        $this->db_v2jb_read = $this->factory(Zend_Registry::get('db_v2jb_read'));
        $this->db_v2jb = $this->factory(Zend_Registry::get('db_v2jb_read'));
        //gaoqing 新增：新疾病库 2016-06-16 End
    }

    private function factory($config) {
        return Zend_Db::factory('PDO_MYSQL', $config);
    }
}
