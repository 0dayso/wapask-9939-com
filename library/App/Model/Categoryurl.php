<?php
/**
**潘红晶 
* 日期 2015-5 
**/
class App_Model_Categoryurl extends App_BaseTable{

	protected $_name				= 'category';
	
	/** 数据库连接对象 */
	private $conntion = null;
	
    function init(){
        $this->_dbzx=$GLOBALS['dbzx'];
        $this->conntion = $GLOBALS['dbzx'];
    }
    public function getcategory($where){
        if($where){
            $sSQL = "SELECT catid,parentid,arrparentid,arrchildid,catname,parentdir,catdir,url,child,setting FROM ".$this->_name." WHERE ".$where;
            $result	= $this->_dbzx->fetchAll($sSQL);
      		return $result;
        }
    }	
    
    /**
     * 得到以频道 catid key , 后 url (/yfbj/yszy/) 为 value 的 map 值
     * @author gaoqing
     * 2015年10月22日
     * @return array catid 键值对数组
     */
    public function getAllCatidMap() {
    	
    	$sSQL = "SELECT catid,url FROM category " ;
    	$result	= array();
    	$statement = $this->conntion->prepare($sSQL);
    	$statement->execute();
    	
    	while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
    		
    		$url = $temp['url'];
    		$domainArr = array();
    		preg_match("/http:\/\/([\S]*?).9939.com\/([\S]*?)\/?$/", $url, $domainArr);
    		$endURLPart = "";
    		if (!empty($domainArr)) {
    			$endURLPart = isset($domainArr[2]) ? $domainArr[2] : "";
    		}
    		$result[$temp['catid']] = $endURLPart;
    	}
    	return $result;
    }
    
    /**
     * 根据 url 得到频道的 catdir 的值
     * @author gaoqing
     * 2015年10月22日
     * @param string $url url的值
     * @return array catdir 的值
     */
    public function getCatdirByURL($url) {
    	$url = trim($url,'/');
    	$fullUrl = $url . "/";
    	$sSQL = "SELECT catid,parentid,arrparentid,arrchildid,catname,parentdir,catdir,url,child,setting FROM category WHERE url in ('". $url ."','".$fullUrl."')  AND parentid = 0 ";
    	$statement = $this->conntion->prepare($sSQL);
    	$statement->execute();
    	$result	= $statement->fetch(PDO::FETCH_ASSOC);
    	
    	return $result;
    }
    
    /**
     * 根据 url 得到频道的 catid 的值
     * @author gaoqing
     * 2015年10月22日
     * @param string $url url的值
     * @return array catid 的值
     */
    public function getCatidByURL($url) {
    	//去掉 "/"
    	$length = strlen($url);
        $url = trim($url,'/');
    	$fullUrl = $url . "/";
    	$sSQL = "SELECT catid,parentid,arrparentid,arrchildid,catname,parentdir,catdir,url,child,setting  FROM category WHERE  url in ('". $url ."','".$fullUrl."') " ;
    	$statement = $this->conntion->prepare($sSQL);
    	$statement->execute();
    	$result	= $statement->fetch(PDO::FETCH_ASSOC);
    	
    	return $result;
    }
    
    
    public function getAllChannel(){
    		$sSQL = "SELECT arrchildid,url, child FROM ".$this->_name . " where parentid = 0";
    		$result	= $this->_dbzx->fetchAll($sSQL);
    		
    		return $result;
    }
    
    public function getAllCategory($arrchildidStr){
    		$result = array();
    		
    		if (isset($arrchildidStr) && !empty($arrchildidStr)) {
    			
    			$arrchildidArr = explode(",", $arrchildidStr);
    			
    			$where = implode(",", $arrchildidArr);
    			
    			
    			$sSQL = "SELECT catid,parentid,parentdir,catdir,url,arrchildid,child FROM ".$this->_name . " WHERE catid in (". $where .") ";
    			$result	= $this->_dbzx->fetchAll($sSQL);
    		}
    		
    		return $result;
    }
}