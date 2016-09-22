<?php
/**
**潘红晶 
* 日期 2015年5月
**/
class DiseaseController extends Q_Controller_Smarty{
	var $_disease_obj					= null;
    var $_ask_obj                       = null;
    var $_art_obj                       = null;
    var $_categoryurl_obj				= null;
    var $_zxads_obj				        = null;
    function init(){
		parent::init();
		$this->initView();
		
		$this->_disease_obj			= new App_Model_Disease();
        $this->_ask_obj             = new App_Model_Ask();
        $this->_art_obj             = new App_Model_Article();
        $this->_categoryurl_obj		= new App_Model_Categoryurl();
        $this->_zxads_obj           = new App_Model_Zxads();
	}
	function indexAction(){
        $sOrder = "length(replace(substr(a.keywords, 1,2), '-', '')) ASC, replace(substr(a.keywords, 1,2), '-', '') ASC ";
        $sNeedFields = ' a.keywords';
        $aDisease1=$this->_disease_obj->getlist(0,10,1691,5, " keywords LIKE '%-男-%'", $sOrder, $sNeedFields);//男
        $keshi = '\'%, or b.name like\'%女';
        $aDisease2=$this->_disease_obj->getlist(0,10,$keshi,5, " keywords LIKE '%-女-%'", $sOrder, $sNeedFields);//女
        $aDisease3=$this->_disease_obj->getlist(0,10,1709,5, " keywords LIKE '%-老-%'", $sOrder, $sNeedFields);//老
        $aDisease4=$this->_disease_obj->getlist(0,10,1686,5, " keywords LIKE '%-幼-%'", $sOrder, $sNeedFields);//幼
        // 热门疾病
	    $aTop = array(139483,140896,138595,138615,139010,139724,139767,139788,139765,140061,140320,140397,140979,138652,139000,139185,139642,139755,140039,257555,140747,138612,140081,140764,139041,140875,141120,138696,138849,139050,139187,139451,139756,139731,139893,139989,141001,141011,141131,140910,140676,140041,139944,138875,139250,139482,139112,140145,140172,140778,139109,139435,139414,141041,139817,139022,139939,140256,140238,139146,140357,139698,140388,141146,140855,139921,139910,141076,141149,138828,140875,140040,140041,139242,139244,139581,140852,139826,138673,139078,138785,140643,138604,139334,139525,139358,139330,139287,139767,138862,139954,140322,140269,140174,140406,140863,139254,139292,139563,140062);
	    // 多发疾病
	    $aDuofa = array(139043,139348,139337,139656,139841,140332,140380,140927,138773,138873,139294,139530,139720,139993,139971,140227,140280,140469,140922,140011,141121,141045,138754,138907,139190,139426,139758,139790,258028,140920,140844,141126,140674,140040,139981,139037,139015,141010,140744,140772,139015,139619,138717,138836,138972,139096,139337,139382,139821,139828,140187,140486,140470,139431,139937,139977,140240,140089,140715,139214,139994,140956,139905,139916,139904,138626,140253,140891,139249,139195,139446,140189,139941,141007,139669,139028,139259,139737,139883,140146,139206,140696,140626,141014,140932,257648,138618,138878,139559,139481,139527,140499,140973,138607,138643,138780,138946,138927,139521,139771);
    	$getHot="";
        $getMultiple="";
        foreach($aTop as $iKey => $sValue)
    	{
            $getHot[$iKey]=$this->_disease_obj->getjb($sValue);         	   
    	}
        foreach($aDuofa as $iKey => $sValue)
    	{
            $getMultiple[$iKey]=$this->_disease_obj->getjb($sValue);    	   
    	}
        $this->view->assign('getHot',$getHot); //热门疾病
        $this->view->assign('getMultiple',$getMultiple); //多发疾病
        $this->view->assign('aDisease1',$aDisease1); //男
        $this->view->assign('aDisease2',$aDisease2); //女
        $this->view->assign('aDisease3',$aDisease3); //老
        $this->view->assign('aDisease4',$aDisease4); //幼
        
		echo $this->view->render('Disease/jibingzicha.tpl');
	}
    function letterAction(){
        $capital = trim($this->getParam("capital"));
        $page = intval($this->getParam('page'));
        $capital = $capital =='' ? 'A' : $capital;
        $where_count=" b.contentid=a.contentid and b.capital='$capital' and a.type='1'";
        $total=$this->_disease_obj->getjbcount($where_count);
        $pnum = 100;	//每页显示多少条数据
        $page = $page <=1 ? 1 : $page;
        $total_page = ceil($total/$pnum);
        $page = $page >= $total_page ? $total_page : $page;
        if($page==0){
            $offsize=0;
        }else{
            $offsize = ($page - 1) * $pnum;
        }
        if($capital){
            $where=" b.contentid=a.contentid and b.capital='$capital' and a.type='1' ORDER BY a.updatetime desc LIMIT ".$offsize.",".$pnum."";
        }
        $result=$this->_disease_obj->getjbDetail($where);
        $pagenp=$page+1;
        if($page==$total_page){
            $page_html='<a href="/Disease/letter/?capital='.$capital.'">返回</a>';
        }else{
            $page_html='<a href="/Disease/letter/?capital='.$capital.'&page='.$pagenp.'">显示更多</a>';
        }
        $this->view->assign('result',$result); 
        $this->view->assign('capital',$capital);
        $this->view->assign('page_html',$page_html); 
        $url=md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('Disease/letterchaxun.tpl',$url);
    }
    function disAction(){
        $id = intval($this->getParam("id"));
        if($id){
            $where=" b.contentid=a.contentid and a.contentid=$id and a.type='1'";
        }
        $result=$this->_disease_obj->getjbDetails($where);
        $section = array_filter(explode(',',$result[0]['keshi']));
        foreach($section as $k=>$v)
    	{
    		$result['keshi'] .= $this->_disease_obj->getsectionkeshi($v).' ';
    	}
        $buwei = array_filter(explode(',',$result[0]['buwei']));
        foreach($buwei as $k=>$v)
    	{
    		$result['buwei'] .= $this->_disease_obj->getbuwei($v).' ';
    	}
        $result['title']=$result[0]['title'];
        $result['thumb']=$result[0]['thumb'];
        $result['content']=$result[0]['content'];  //概述
        $result['cause']=$result[0]['cause'];      //病因
        $result['character']=$result[0]['character'];      //症状
        $result['examine']=$result[0]['examine'];      //检查
        $result['cure']=$result[0]['cure'];      //治疗
        $result['healthcare']=$result[0]['healthcare'];      //预防
        $result['diagnose']=$result[0]['diagnose'];      //鉴别
        $result['bingfazheng']=$result[0]['bingfazheng'];      //并发症
        $relevant_ask= array();
        if($result['title']){
//            $where=" title like '%".$result['title']."%' ORDER BY id desc LIMIT 0,5";
//            $relevant_ask=$this->_ask_obj->Getask($where);
            
            $search  = new App_Model_Search();
            $ret = $search->search_ask($result['title'],0,5);
            $ask_list = $ret['list'];
            foreach($ask_list as $k=>$v){
                $relevant_ask[] = $v['ask'];
            }
            
            
            if(file_exists(__ROOT__."/public/cat_11.txt")){
                $catid=file_get_contents(__ROOT__."/public/cat_11.txt");
            }
            if($catid){
                $relevant_art = array();
                $whereart=" title like '%".$result['title']."%' and catid in (".$catid.") and status='20' ORDER BY articleid desc LIMIT 0,10";
//                $relevant_art=$this->_art_obj->getarticle($whereart);
//                $sql = 'select * from (SELECT articleid,title,catid,inputtime,updatetime,keywords,description,thumb FROM article where '." catid in (".$catid.") and status='20' ) t";
//                $sql.= " where  instr(t.title,'".$result['title']."')>0  ORDER BY t.articleid desc LIMIT 0,10";
//                $relevant_art=$this->_art_obj->execute_sql($sql);
                foreach($relevant_art as $key=>$val){
                    $wheres=" catid=".$val['catid'];
                    $res_cat=$this->_categoryurl_obj->getcategory($wheres);
                    $pdir=trim($res_cat[0]['parentdir'],"/");
                    $parentdir=explode("/",$pdir);
                    $relevant_art[$key]['catdir']="/".$parentdir[0]."/".$res_cat[0]['catdir'];
                }
            }
        }
        //获取资讯广告 疾病详情页面 广告位轮闪（图片或者文字链）
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
        $this->view->assign('result',$result); 
        $this->view->assign('relevant_ask',$relevant_ask); //相关问答
        $this->view->assign('relevant_art',$relevant_art); //相关滚动资讯
        $this->view->assign('zx_ads',$zx_ads); //广告位轮闪（图片或者文字链）
        $url=md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('Disease/jibingxq.tpl',$url);
    }
	
}