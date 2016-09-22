<?php

/**
 * *潘红晶 
 * 日期 2015-5 
 * */
class App_Model_Zxads extends App_BaseTable {

    protected $_name = 'ads';
    const PCDOMAIN = 'http://www.9939.com/'; //uploadfile/

    function init() {
        parent::init();
        $this->_dbzx = $GLOBALS['dbzx'];
    }

    public function ads($id = 0, $num = 1, $ofset = 0, $class_name=''){
        $data = $this->ads_content($id, $num);
        $arr_method_ref = array(
            '1'=>'default_ads_text',
            '2'=>'default_ads_pic',
            '3'=>'default_ads_ref',
            '4'=>'default_ads_flash'
        );
        $arr_ret = array();
        foreach($data as $k=>$v){
            $type = $v['type'];
            $ret = $this->{$arr_method_ref[$type]}($v);
            array_push($arr_ret,$ret);
        }
        if(count($arr_ret)>0){
            return implode('', $arr_ret);
        }
        return '';
    }

    // 获取 广告内容
    public function ads_content($id = 0, $num = 1) {
        return $this->getAdsList($id, $num);
    }

    //默认的文字链广告
    //广告类型type为1
    private function default_ads_text($ads){
        extract($ads);
        $ret = '';
        $ret.='<a href="'.$linkurl.'" target="_blank" title ="'.$adsname.'">';
        $ret.= $adsname;
        $ret.='</a>';
        return $ret;
    }
    /*
     * 默认的图片广告
     * 广告类型type为2
     */
    private function default_ads_pic($ads){
        extract($ads);
        $ret = '';
        $ret.='<a href="'.$linkurl.'" target="_blank">';
        $ret.='    <img src="'.$imageurl.'" alt="'.$adsname.'" title="'.$adsname.'"/>';
        $ret.='</a>';
        return $ret;
    }

    /*
     * 默认的外部调用广告
     * 广告类型type为3
     */
    private function default_ads_ref($ads){
        extract($ads);
        $ret = str_replace('http://union.9939.com/cpro/ui/cm.js', 'http://jsm.9939.com/cpro/ui/cm.js', $text);
        return $ret;
    }

    /*
     * 默认的flash广告
     * 广告类型type为3
     */
    private function default_ads_flash($ads){
        return '';
    }

    /**
     * 得到广告位
     */
    public function Getads($where) {
        if ($where) {
            $sSQL = "SELECT adsid,adsname,linkurl,imageurl, type, text  FROM " . $this->_name . " WHERE " . $where;
            $result = $this->_dbzx->fetchAll($sSQL);
            return $result;
        }
    }

    /**
     * 得到推荐位
     */
    public function Getadsplace($where) {
        $sSQL = "SELECT placeid,items FROM adsplace WHERE " . $where;
        $result = $this->_dbzx->fetchAll($sSQL);
        return $result;
    }

    //获取处理后的的ads
    public function getAdsHandle($placeid, $item) {
        $res = $this->getAdsList($placeid, $item);
        foreach ($res as $k => $v) {
            $res[$k]['imageurl'] = self::PCDOMAIN . 'uploadfile/' . $res[$k]['imageurl'];
        }
        return $res;
    }

    //获取原生的ads
    public function getAdsList($placeid, $item) {
        $limit = "  ";
        if(isset($item) && !empty($item)){
            $limit .= " LIMIT 0,{$item}";
        }
        $sql = "select adsid,adsname,introduce,placeid,width,height,type,linkurl,imageurl,text,sortid from ads where placeid= {$placeid} order by adsid desc " . $limit;
        
        $return_ad_list = $this->_dbzx->fetchAll($sql);
        foreach ($return_ad_list as &$val){
			$val['text'] = str_replace(array('\"', "\'"), array('"', "'"), $val['text']);
		}
        return $return_ad_list;
    }
    //获取广告总条数
    public function getAdsItems($placeid) {
        $sql = "select placeid,items from `Adsplace` where placeid = {$placeid}";
        $item = $this->_dbzx->fetchAll($sql);
        return $item['0']['items'];
    }
    
    //轮播图
    public function getPic($parentid,$catid,$num = 4,$from = 'idnex') {
        
        include_once './data/picPlaceid.php';
        $placeid = '';
        if (!array_key_exists($parentid, $pidPlaceid)) {
            $parentid = '1979';
            $catid = '1981';
        }
        if ($from == 'index') {
            $placeid = end($pidPlaceid[$parentid]);
        } elseif (!array_key_exists($catid, $pidPlaceid[$parentid])) {
            $placeid = end($pidPlaceid[$parentid]);
        } else {
            $placeid = $pidPlaceid[$parentid][$catid];
        }
        $res = $this->getAdsHandle($placeid, $num);
        return $res;
    }

}
