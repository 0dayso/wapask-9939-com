<?php
/**
**潘红晶 
* 日期 2015年5月
**/
class ArticleController extends App_Controller_Action{
	var $_article_obj					= null;
    var $_categoryurl_obj               = null;
    var $_zxads_obj				        = null;
    var $_ask_obj                       = null;
    function init(){
		parent::init();
		$this->initView();
		
		$this->_article_obj			= new App_Model_Article();
        $this->_categoryurl_obj     = new App_Model_Categoryurl();
        $this->_zxads_obj           = new App_Model_Zxads();
        $this->_ask_obj             = new App_Model_Ask();
	}
    function showAction(){
         //获取相关文章 开始
        $caturl=explode("/",trim($_SERVER['REQUEST_URI'],'/'));
        
        $id = intval($this->getParam('id'));
        if($id){
            $where=" articleid=".$id;
            $result=$this->_article_obj->getarticle($where);
            if($result && is_array($result)) {
                $art_where=" articleid=".$result[0]['articleid'];
                $result_art=$this->_article_obj->getarticle_detail($art_where); 
            }
        }
        
        $curr_catid = $result[0]['catid'];
        if($curr_catid==0){
            $base_domain_url = sprintf('http://%s.9939.com/',$caturl[0]);
            $cate_result = $this->_categoryurl_obj->getCatdirByURL($base_domain_url);
            $cat_result= $cate_result;
        }else{
            $cate_where=" catid=".$curr_catid;
            $cate_result=$this->_categoryurl_obj->getcategory($cate_where);
            $arrparentid=explode(",",$cate_result[0]['arrparentid']);
            $cat_where=" catid=".$arrparentid[1];
            $cat_result=$this->_categoryurl_obj->getcategory($cat_where);
        }
        $domain = "";
        $catid = "";
        $initURL = isset($cate_result[0]['url']) ? $cate_result[0]['url'] : '';
        if (!empty($initURL)) {
        	$initURLArr = explode("9939.com", $initURL);
        	$initDomain = trim($initURLArr[0], "http://");
        	$initPartURL = isset($initURLArr[1]) ? $initURLArr[1] : '';
        	$domain = trim($initDomain, ".");
        	$tempCatid = ($initPartURL == '/') ? '' : $initPartURL;
        	$catid = trim($tempCatid, "/");
        }
        $catdir = array();
        $catdir['parentdir_url']=$domain;
        $catdir['catid']=$catid . "/";
        $catdir['parentdir_name']=mb_substr($cat_result[0]['catname'],0,2);
        $catdir['catdir_url']=$cate_result[0]['catdir'];
        $catdir['catdir_name']=$cate_result[0]['catname'];
        
        $result[0]['content']=$result_art[0]['content'];
        $result[0]['copyfrom']=$result_art[0]['copyfrom'];
        $result[0]['inputtime']=date("Y-m-d H:i:s", $result[0]['inputtime']);
        $keywords=explode(" ",$result[0]['keywords']);
        //获取资讯广告 文章详情页面（文章来源广告位）
        $zx_adstext=$this->article_ads(4213);
        //获取资讯广告 文章详情页面（相关文章下边广告位）
        $zx_adsimage=$this->article_ads(4214);
       
        $base_cat_dir = $cat_result[0]['catdir'];
        $wheres_url=" parentdir like '%".$base_cat_dir."%' ";
        if($curr_catid>0){
            $wheres_url=" parentdir like '%".$base_cat_dir."%' and catid='".$curr_catid."'";
        }
        if($wheres_url){
            $result_url=$this->_categoryurl_obj->getcategory($wheres_url);
            if($result_url[0]['child']>0){
                $where_art=" catid in ('".$result_url[0]['arrchildid']."') and status='20' ORDER BY articleid desc LIMIT 0,6";
            }else{
                $where_art=" catid = '".$result_url[0]['arrchildid']."' and status='20' ORDER BY articleid desc LIMIT 0,6";
            }
            $article_list=$this->_article_obj->getarticle($where_art);
            $article = array();
            foreach($article_list as $key=>$val){
                $wheres=" catid=".$val['catid'];
                $res_cat=$this->_categoryurl_obj->getcategory($wheres);
                $pdir=trim($res_cat[0]['parentdir'],"/");
                $parentdir=explode("/",$pdir);
                $val['catdir']="/".$parentdir[0]."/".$res_cat[0]['catdir'];
                $val['channel']="/".$parentdir[0]."/";
                $val['art_base_path']="/".$caturl[0]."/article";
                $tmp_article_id = $val['articleid'];
                
                if($tmp_article_id!=$id && count($article)<5){
                    $article[] = $val;
                }
            }
        }
        $this->view->assign('article',$article); //相关文章
        //相关文章结束
        $this->view->assign('result',$result[0]); 
        $this->view->assign('keywords',$keywords); //文章关键子
        $this->view->assign('catdir',$catdir); //面包屑导航
        $this->view->assign('zx_adstext',$zx_adstext); //获取资讯广告 文章详情页面（文章来源广告位）
        $this->view->assign('zx_adsimage',$zx_adsimage); //获取资讯广告 文章详情页面（相关文章下边广告位）
        $zx_adscount = !empty($zx_adsimage)?count($zx_adsimage):0;
        $this->view->assign('zx_adscount',$zx_adscount);
        $url=md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('Article/article.tpl',$url);  
	}
    //获取资讯广告信息
    private function article_ads($placeid){
        if($placeid){
            $zx_where=" placeid='$placeid' ";
            $zx_adsplace=$this->_zxads_obj->Getadsplace($zx_where);
            $where=" placeid='".$zx_adsplace[0][placeid]."' order by addtime desc limit 0,".$zx_adsplace[0][items]."";
            $zx_ads=$this->_zxads_obj->Getads($where);
            if($zx_ads && is_array($zx_ads)){
                foreach($zx_ads as $key_ads=>$val_ads){
                    if($val_ads['imageurl']){
                        $zx_ads[$key_ads]['imageurl']="http://www.9939.com/uploadfile/".$val_ads['imageurl'];
                    }
                    //设置新规则下的 url 
                    $zx_ads[$key_ads]['newruleurl'] = $val_ads['linkurl'];
                }
            }
            return $zx_ads;
        }
    }
    
    private function getNewRuleURL($linkurl) {
    	$newRuleURL = $linkurl;
    	
    	if (isset($linkurl) && !empty($linkurl)) {
    		
    		//具体的文章内容路径处理方式：
    		if (strpos($linkurl, ".shtml")) {
    			
    			$linkURArr = explode("/", $linkurl);
    			$linkURArrLength = count($linkURArr);
    			$articleidStr = $linkURArr[$linkURArrLength - 1];
    			$articleidArr = explode(".", $articleidStr);
    			$articleid = empty($articleidArr) ? 0: $articleidArr[0];
    			//根据 $articleid 查询当前文章的 url
    			$articleArr = $this->_article_obj->getarticle(" articleid = " . $articleid);
    			$articleURL = empty($articleArr) ? "" : $articleArr[0]['url'];
    			
    			//获取域名
    			$arr = explode("/", $articleURL);
    			$fullDomain = $arr[2];
    			$domainArr = explode(".", $fullDomain);
    			$domain = $domainArr[0];
    			
    			//获取文章 id
    			$length = count($arr);
    			$id = $arr[$length - 1];
    			
    			$newRuleURL = "http://m.9939.com/" . $domain . "/article/" . $id;
    			return $newRuleURL;
    		}
    		
    		
    	}
    	
       return $newRuleURL;	
    }
	
}