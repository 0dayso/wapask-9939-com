<?php
/**
**潘红晶 
*  日期 2015年5月
**/
class IndexController extends App_Controller_Action {
	var $_zxads_obj				        = null;
    var $_ask_obj                       = null;
    var $_art_obj                       = null;
    var $_categoryurl_obj				= null;
    function init(){
		parent::init();
		$this->initView();
        $this->_zxads_obj           = new App_Model_Zxads();
        $this->_ask_obj             = new App_Model_Ask();
        $this->_art_obj             = new App_Model_Article();
        $this->_categoryurl_obj		= new App_Model_Categoryurl();
	}
	function indexAction(){
		//获取资讯广告 广告位轮闪（图片或者文字链）
        $zx_where=" placeid='3685' ";    //3685
        $zx_adsplace=$this->_zxads_obj->Getadsplace($zx_where);
        $where=" placeid='".$zx_adsplace[0]['placeid']."' order by addtime desc limit 0,".$zx_adsplace[0]['items']."";
        $zx_ads=$this->_zxads_obj->Getads($where);
        if($zx_ads && is_array($zx_ads)){
            foreach($zx_ads as $key_ads=>$val_ads){
                if($val_ads['imageurl']){
                    $zx_ads[$key_ads]['imageurl']="http://www.9939.com/uploadfile/".$val_ads['imageurl'];
                }
            }
        }
        $where_ask=" answernum<>0 ORDER BY id desc LIMIT 0,6";
        $jc_ask=$this->_ask_obj->Getask($where_ask);
        $art_baby=$this->Channel_article(1979);   //母婴频道
        $art_male=$this->Channel_article(1808);   //男性频道
        $art_xa=$this->Channel_article(2464);   //两性频道
        $art_xinli=$this->Channel_article(1947);   //心理频道
        $art_bj=$this->Channel_article(2711);   //保健频道
        $art_jf=$this->Channel_article(2094);   //减肥频道
        $art_meirong=$this->Channel_article(1836);   //美容频道
        $art_nvxing=$this->Channel_article(11470);   //女性频道
        $art_laoren=$this->Channel_article(11411);   //老人频道 
        $art_jianshen=$this->Channel_article(2280);   //健身频道
        $art_yinshi=$this->Channel_article(2791);   //饮食频道
        $art_zhengxing=$this->Channel_article(11430);   //整形频道
        $art_zy=$this->Channel_article(2388);   //中医频道
        $art_huli=$this->Channel_article(2224);   //护理频道
        $art_pf=$this->Channel_article(2266);   //偏方频道
        $art_tijian=$this->Channel_article(9552);   //体检频道
        
        $this->view->assign('art_baby',$art_baby); //获取资讯母婴频道
        $this->view->assign('art_male',$art_male); //获取资讯男性频道
        $this->view->assign('art_xa',$art_xa); //获取资讯两性频道
        $this->view->assign('art_xinli',$art_xinli); //获取资讯心理频道
        $this->view->assign('art_bj',$art_bj); //获取资讯保健频道
        $this->view->assign('art_jf',$art_jf); //获取资讯减肥频道
        $this->view->assign('art_meirong',$art_meirong); //获取资讯美容频道
        $this->view->assign('art_nvxing',$art_nvxing); //获取资讯女性频道
        $this->view->assign('art_laoren',$art_laoren); //获取资讯老人频道 
        $this->view->assign('art_jianshen',$art_jianshen); //获取资讯健身频道
        $this->view->assign('art_yinshi',$art_yinshi); //获取资讯饮食频道
        $this->view->assign('art_zhengxing',$art_zhengxing); //获取资讯整形频道
        $this->view->assign('art_zy',$art_zy); //获取资讯中医频道
        $this->view->assign('art_huli',$art_huli); //获取资讯护理频道
        $this->view->assign('art_pf',$art_pf); //获取资讯偏方频道
        $this->view->assign('art_tijian',$art_tijian); //获取资讯体检频道
        $this->view->assign('zx_ads',$zx_ads); //广告位轮闪（图片或者文字链）
        $this->view->assign('jc_ask',$jc_ask); //精彩问答
		echo $this->view->render('index.tpl');
	}
    private function Channel_article($catid){
        if($catid){
            $where=" catid=".$catid;
            $result=$this->_categoryurl_obj->Getcategory($where);
            $whereart=" catid in (".$result[0]['arrchildid'].") and status='20' ORDER BY articleid desc LIMIT 0,5";
            $relevant_art=$this->_art_obj->getarticle($whereart);
            foreach($relevant_art as $key=>$val){
                $wheres=" catid=".$val['catid'];
                $res_cat=$this->_categoryurl_obj->getcategory($wheres);
                $pdir=trim($res_cat[0]['parentdir'],"/");
                $parentdir=explode("/",$pdir);
                $relevant_art[$key]['catdir']="/".$parentdir[0]."/".$res_cat[0]['catdir'];
                $relevant_art[$key]['channel']="/".$parentdir[0]."/";
                
                $matchArr = $this->resolveURL($res_cat[0]['url']);
                $domain = empty($matchArr) ? $parentdir[0] : $matchArr[1];
                $relevant_art[$key]['art_base_path']="/". $domain ."/article";
            }
            return $relevant_art;
        }
    }
	
}