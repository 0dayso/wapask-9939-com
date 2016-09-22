<?php
/**
**潘红晶 
* 日期 2015-5-28
**/
class SymptomController extends Q_Controller_Smarty{
    var $_symptom_obj					= null;
    var $_ask_obj                       = null;
    var $_zxads_obj				        = null;
    function init(){
		parent::init();
		$this->initView();
        
        $this->_symptom_obj		= new App_Model_Symptom();
        $this->_ask_obj         = new App_Model_Ask();
        $this->_zxads_obj       = new App_Model_Zxads();
	}
	function indexAction(){
		echo $this->view->render('Symptom/symptomzc.tpl');
	}
	function detailsAction(){
        $id = intval($this->getParam("id"));
        if($id){
            $where=" a.contentid='$id'";
            $result=$this->_symptom_obj->get_Symptom_data($where);
        }
        $jibing_arry=explode(",",$result[0]['jibing']);
        foreach($jibing_arry as $k=>$v){
            if($v){
                $jb_arry[]=$v;
            }
        }
        $jibings=implode(",",$jb_arry);
        if($jibings){
            $where_xgjb=" contentid in($jibings)";
            $result_xgjb=$this->_symptom_obj->get_Symptom_dzjb($where_xgjb);
        }
        $keywords=str_replace(" ",",",$result[0]['keywords']);
        $keywords_arry=explode(",",$keywords);
        $xg_ask= array();
        if($keywords_arry){
            //            $where_ask=" title like '%$keywords_arry[0]%' ORDER BY id desc LIMIT 0,5";
//            $xg_ask=$this->_ask_obj->Getask($where_ask);
            $search  = new App_Model_Search();
            $ret = $search->search_ask($keywords_arry[0],0,5);
            $ask_list = $ret['list'];
            foreach($ask_list as $k=>$v){
                $xg_ask[] = $v['ask'];
            }
        }
        //获取资讯广告 症状详情页面 广告位轮闪（图片或者文字链）
        $zx_where=" placeid='3703' "; //3733
        $zx_adsplace=$this->_zxads_obj->Getadsplace($zx_where);
        $where=" placeid='".$zx_adsplace[0][placeid]."' order by addtime desc limit 0,".$zx_adsplace[0][items]."";
        $zx_ads=$this->_zxads_obj->Getads($where);
        if($zx_ads && is_array($zx_ads)){
            foreach($zx_ads as $key_ads=>$val_ads){
                if($val_ads['imageurl']){
                    $zx_ads[$key_ads]['imageurl']="http://www.9939.com/uploadfile/".$val_ads['imageurl'];
                }
            }
        }
        $this->view->assign('result',$result[0]); 
        $this->view->assign('result_xgjb',$result_xgjb);
        $this->view->assign('xg_ask',$xg_ask);
        $this->view->assign('zx_ads',$zx_ads); //广告位轮闪（图片或者文字链）
        $url=md5($_SERVER['REQUEST_URI']);
		echo $this->view->render('Symptom/symptom_details.tpl',$url);
	}
    function positionAction(){
        $id = intval($this->getParam("id"));
        if($id){
            $where_buwei=" id='$id'";
            $buwei=$this->_symptom_obj->get_buwei($where_buwei);
            $where=" buwei like '%$id%'";
            $result=$this->_symptom_obj->get_Symptom($where);
            foreach($result as $k=>$v){
                $contentid_arry[$k]=$v['contentid'];
            }
            $contentids='';
            if(!empty($contentid_arry)){
                $contentids=implode(",",$contentid_arry);
            }
            if($contentids){
                $where_zz=" contentid in($contentids)";
                $result_zz=$this->_symptom_obj->get_Symptom_dzjb($where_zz);
            }
        }
        $this->view->assign('buwei',$buwei); 
        $this->view->assign('result_zz',$result_zz); 
        $url=md5($_SERVER['REQUEST_URI']);
		echo $this->view->render('Symptom/symptom_position.tpl',$url);
	}
}
