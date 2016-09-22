<?php
/**
**潘红晶 
* 日期 2015-5 
**/
class App_Model_Article extends QModels_Article_Table{

	protected $_name				= 'article';

	
	function init(){
		parent::init();
		$this->_dbzx=$GLOBALS['dbzx'];
	}
	
	//============================ 2015-12-11: 新增 【热搜】、【专题】部分 Start ==========================//
    public function List_ArticleByIds($articleids=array()){
        if(count($articleids)==0){
            return false;
        }
        $ids = implode(',', $articleids);
        $sql = "select articleid as id,title,url,description,inputtime from article where articleid in ($ids) order by articleid desc";
        $result = $this->db_v2_read->fetchAll($sql);
        return $result;
    }
    
    public function List_DiseaseArticleByIds($articleids=array()) {
        if(count($articleids)==0){
            return false;
        }
        $ids = implode(',', $articleids);
        $sql = "select id,title,url,description,inputtime from 9939_disease_article where id in ($ids) order by id desc";
        $result = $this->db_v2jb_read->fetchAll($sql);
        return $result;
    }
	//============================ 2015-12-11: 新增 【热搜】、【专题】部分 End ==========================//
	
    public function getarticle($where){
        if($where){
            $sSQL = "SELECT articleid,title,catid,inputtime,updatetime,keywords,description,thumb, url FROM ".$this->_name." WHERE ".$where;
            $result	= $this->_dbzx->fetchAll($sSQL);
      		return $result;
        }  
    }
    public function getcount($where){
        if($where){
            $sSQL = "SELECT count(*) FROM ".$this->_name." WHERE ".$where;
            $result	= $this->_dbzx->fetchOne($sSQL);
      		return $result;
        }
    }
    public function getarticle_detail($where){
        if($where){
            $sSQL = "SELECT * FROM article_detail WHERE ".$where;
            $result	= $this->_dbzx->fetchAll($sSQL);
      		return $result;
        }  
    }
	
}