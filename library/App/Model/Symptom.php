<?php
/**
**潘红晶 
* 日期 2015-5-28
**/
class App_Model_Symptom extends App_BaseTable{

	protected $_name				= '9939_symptom_content';
	function init(){
		parent::init();
		$this->_db					= $this->getAdapter();
	}
    /**
     * 获取某部位症状
    **/
    public function get_Symptom($where){
        if($where){
            $sSQL = "SELECT contentid FROM ".$this->_name." where $where";
            $result	= $this->_db->fetchAll($sSQL);
      		return $result;
        }
    }
    /**
     * 获取相关症状标题等
    **/
    public function get_Symptom_dzjb($where){
        if($where){
            $sSQL = "SELECT contentid,title FROM 9939_dzjb where $where";
            $result	= $this->_db->fetchAll($sSQL);
      		return $result;
        }
    }	
    /**
     * 获取当前部位名称 
    **/
    public function get_buwei($where){
        if($where){
            $sSQL = "SELECT name FROM 9939_buwei_category where $where";
            $result	= $this->_db->fetchOne($sSQL);
      		return $result;
        }
    }	
    /**
     * 获取某条症状详情
    **/
    public function get_Symptom_data($where){
        if($where){
            $sSQL = "SELECT a.contentid,b.title,a.content,a.cause,a.diagnose,a.jibing,b.keywords FROM ".$this->_name." a, 9939_dzjb b where a.contentid=b.contentid and b.type='2' and $where";
            $result	= $this->_db->fetchAll($sSQL);
      		return $result;
        }
    }
}