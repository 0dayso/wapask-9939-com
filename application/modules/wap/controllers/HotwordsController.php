<?php

/**
 * @Desc :  搜索热词控制器
 */
class HotwordsController extends App_Controller_Action {

    public function init() {
    	parent::init();
    	$this->initView();
    	
        //$this->view = Zend_Registry::get('view');
        
        $this->view->controllername = $this->getRequest()->getControllerName();
        $this->view->actionname = $this->getRequest()->getActionName();
        
        $this->ask_obj = new  App_Model_Ask();
        $this->answer_obj = new App_Model_Answer();
        $this->wd_obj = new App_Model_KeyWords();
        $domainname = 'wapask';
        $this->view->domainname =  $domainname;
        $this->view->domainurl = 'http://' . $domainname . '.9939.com/hot/';
        $this->view->base_include_path = 'http://wapask.9939.com/';
        $this->view->searchurl = 'http://' . $domainname . '.9939.com/hot/';
        $this->view->letterurl = 'http://' . $domainname . '.9939.com/hot/';
    }

    public function indexAction() {
        
    	$template_path = "hot/hot_words.tpl";
    	$md5URL = md5($_SERVER['REQUEST_URI']);
    	$this->display($template_path, $md5URL);
        
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $filter_array = $this->getFilterArray();
        $cache_rand_words = App_Model_KeyWords::getCacheRandWords(100, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $ret = $cache_rand_words[$wd];
            if (count($ret) > 0) {
            	$arr = array_splice($ret, 0, 15);
                $return_list[$wd] = $this->dealData($arr, 10);
            }
        }
        $this->loadletterlist();
        
        $this->view->assign("list", $return_list);
        $this->view->assign("metaTitle", '字母检索');
        $this->view->assign("metaKeywords", '字母检索');
        $this->view->assign("metaDescription", '字母检索');
        
        echo $this->view->render($template_path, $md5URL);
    }
    
    private function dealData($datas, $cut_len) {
    	$arr = array();
       
    	if (isset($datas) && !empty($datas)) {
	        foreach ($datas as $key => $val){
	        	$name = $val['keywords'];
	        	$short_name = QLib_Utils_String::cutString($name, $cut_len, 0) ;
	        	$url = sprintf('%s%s/', $this->view->searchurl,  str_replace(' ', '', $val['pinyin']));
	        	
	        	$val['short_name'] = $short_name;
	        	$val['url'] = $url;
	        	
	        	$arr[] = $val;
	        }
    	}
        return $arr;
    }
    
    public function searchwordAction() {
    	$request = $this->getRequest();
    	$searchWords = $request->getParam("searchWords", "");
    	$initCurrentPage = $request->getParam("currentPage", 1);
    	
    	$template_path = "hot/search_list.tpl";
    	$md5URL = md5($_SERVER['REQUEST_URI']);
    	/* $md5URL = md5($_SERVER['REQUEST_URI']);
    	$this->display($template_path, $md5URL); */
    	
    	$currentPage = empty($initCurrentPage) ? 1 : $initCurrentPage;
    	$pageSize = 8;
    	$start = ($currentPage - 1) * $pageSize;
    	
    	$return_info = $this->search_ask($searchWords, $start, $pageSize);
    	
    	$count = isset($return_info) ?  $return_info['total'] : 0;
    	$pageNum = ceil($count / $pageSize);
    	
    	$pageBaseURL = "/hot/sd/" . urlencode($searchWords) . "/";
    	
    	$pageHTML = $this->getPageHTML($pageBaseURL, $currentPage, $pageNum);
    	$this->view->assign("paging", $pageHTML);
    	
    	/*相关热词*/
    	$rel_keywords_len = 7;
    	$relateWords = $this->relate_words($searchWords, 0, 8);
    	$relateDiseaseWords = array_slice($relateWords['list'], 0, $rel_keywords_len);
    	$relateDiseaseWords = $this->dealData($relateDiseaseWords, 7);
    	$this->view->assign("relateDiseaseWords", $relateDiseaseWords);
    	
    	$this->view->assign("searchList", $return_info['list']);
    	$this->view->assign("keywords", $searchWords);
    	
    	/*页面meta及标题*/
    	$this->view->assign("metaTitle", $searchWords);
    	$this->view->assign("metaKeywords", $searchWords);
    	$this->view->assign("metaDescription", $searchWords);
    	
    	echo $this->view->render($template_path, $md5URL);
    }
    
    /**
     * 问答热搜词页
     */
    public function searchAction() {
        $wd = $this->_getParam('wd', '');
        $page = $this->_getParam('page', 1);
        
        $template_path = "hot/list.tpl";
        $md5URL = md5($_SERVER['REQUEST_URI']);
        $this->display($template_path, $md5URL);
        
        $wd_name = '';
        if (!empty($wd)) {
            $wd_list = $this->wd_obj->getKeywordName($wd);
            $wd_name = $wd_list['keywords'];
            
            //每页数量
            $size = 8;
            $start = ($page - 1) * $size;
            $return_info = $this->search_ask($wd_name, $start, $size);
        }
        
        $this->view->assign("cache_page", $page);
        $this->view->assign("total", $total = $return_info['total']);
        
        $pageBaseURL = "/hot/" . urlencode($wd) . "/";
        $currentPage = $page;
        $preCount = 7;
        $pageNum= ceil($total / $preCount);
        $pageHTML = $this->getPageHTML($pageBaseURL, $currentPage, $pageNum);
        $this->view->assign("paging", $pageHTML);
        
        $this->view->assign("searchList", $return_info['list']);
        $this->view->assign("keywords", $wd_name);
        $this->view->assign("pinyinKeywords", $wd);
        $this->view->assign("letter", strtoupper($wd{0}));
        $this->view->assign("adnum", '32');
        
        $this->loadletterlist();
        
        /*相关热词*/
        $rel_keywords_len = 7;
        $relateWords = $this->relate_words($this->view->keywords, 0, 8);
        $relateDiseaseWords = array_slice($relateWords['list'], 0, $rel_keywords_len);
        $relateDiseaseWords = $this->dealData($relateDiseaseWords, 7);
        $this->view->assign("relateDiseaseWords", $relateDiseaseWords);
        
        /*页面meta及标题*/
        $this->view->assign("metaTitle", $this->view->keywords);
        $this->view->assign("metaKeywords", $this->view->keywords);
        $this->view->assign("metaDescription", $this->view->keywords);
        
        echo $this->view->render($template_path, $md5URL);
    }
    
    private function loadletterlist() {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        for ($i = 0; $i < $len; $i++) {
            $l = strtoupper($letter_list{$i});
            $return_list[$l] = array(
                'url' => sprintf('%s%s/', $this->view->letterurl, $l),
                'selected' => ($this->view->letter == $l) ? 1 : 0
            );
        }
        $this->view->letter_list = $return_list;
    }

    //随机热词
    private function rand_words() {
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 100;
        $max_dis_length = 30;
        $filter_array = $this->getFilterArray();
        $cache_rand_words = App_Model_KeyWords::getCacheRandWords($max_kw_length, $filter_array);
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $ret = $cache_rand_words[$wd];
            if (count($ret) > 0) {
                $rand_num = count($ret) > $max_dis_length ? 30 : count($ret);
                $rand_keys = array_rand($ret, $rand_num);
                if (is_array($rand_keys)) {
                    foreach ($rand_keys as $k) {
                        $return_list[$wd][] = $ret[$k];
                    }
                } else {
                    $return_list[$wd][] = $ret[0];
                }
            } else {
                $return_list[$wd] = array();
            }
        }
        return $return_list;
    }

    //相关热词
    public function relate_words($wd, $page, $size) {
        $config = $this->getExplainConfig();
        $explain_ext_config = $config['explain_ext_config'];
        $explainflag = $config['explainflag'];
        $filter_array = $this->getFilterArray();
        return App_Model_Search::search_words_all($wd, $page, $size,$filter_array,$explainflag,$explain_ext_config);
    }

    private function search_relarticle($wd, $offset, $size) {
        return App_Model_Search::search_relarticle($wd, $offset, $size);
    }

    private function search_ask($wd, $page, $size) {
        $config = $this->getExplainConfig();
        $explain_ext_config = $config['explain_ext_config'];
        $explainflag = $config['explainflag'];
        $condition = array();
        return App_Model_Search::search_ask($wd, $page, $size,$condition,$explainflag,$explain_ext_config);
    }
    
    private function getFilterArray(){
        return array('typeid' => array(1));
//        return array('typeid' => array(0,1));
        
    }
    
     private function getExplainConfig(){
        $explain_ext_config = array(
            'is_ext_words'=>1
        );
        $explainflag = 1;
        return array(
            'explainflag'=>$explainflag,
            'explain_ext_config'=>$explain_ext_config
        );
    }
    
    /**
     * 得到分页的 HTML 字符串
     * @author gaoqing
     * 2015年12月14日
     * @param string $pageBaseURL 分页的基路径
     * @param int $currentPage 当前页
     * @param int $pageNum 总的记录数
     * @return string 疾病分页的 HTML 字符串
     */
    private function getPageHTML($pageBaseURL, $currentPage, $pageNum) {
    
    	//上一页
    	$preCurrentPage = $currentPage == 1 ? 1 : ($currentPage - 1);
    	$prePageURL = $pageBaseURL . $preCurrentPage;
    	if ($currentPage == 1) {
    		$prePageURL = "javascript:";
    	}
    	$prePage = '<a href="'. $prePageURL .'">上一页</a>';
    
    	//下一页
    	$nextCurrentPage = $currentPage == $pageNum ? $pageNum :  ($currentPage + 1);
    	$nextPageURL = $pageBaseURL . $nextCurrentPage;
    	if ($currentPage == $pageNum) {
    		$nextPageURL = "javascript:";
    	}
    	$nextPage = '<a href="'. $nextPageURL .'">下一页</a>';
    
    	if ($pageNum == 0) {
    		$currentPage = 0;
    	}
    	$pageHTML =
    	$prePage .
    	'<span>' . $currentPage . '/' . $pageNum . '</span>'.
    	$nextPage;
    
    	return $pageHTML;
    }

}
