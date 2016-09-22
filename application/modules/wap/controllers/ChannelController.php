<?php

/**
 * *潘红晶 
 * 日期 2015年5月
 * */
class ChannelController extends App_Controller_Action {

    var $_article_obj = null;
    var $_categoryurl_obj = null;
    var $_art_obj = null;
    function init() {
        parent::init();
        $this->_article_obj = new App_Model_Article();
        $this->_categoryurl_obj = new App_Model_Categoryurl();
        $this->_art_obj = new App_Model_Article();
    }
    function dispatchAction() {
        $arr_cat_info = $this->cate_info_params;
        $child = $arr_cat_info['child'];
        switch ($child){
            case 1:{
                $this->navAction();
                break;
            }
            default :{
                $this->listAction();
            }
        }
    }

    function indexAction() {
        $caturl = $this->url_path_params;
        
        $tempCatidArr = $this->cate_info_params;
        $parenturl = empty($tempCatidArr) ? '' : $tempCatidArr['wap_url'];
        $catid = empty($tempCatidArr) ? 0 : $tempCatidArr['catid'];
       $caturl[0] = trim($tempCatidArr['parentdir'], "/");

        //得到 catid => /jkhf/bwby/ 的 map 对象  -----	：新增
        $catidMap = $this->_categoryurl_obj->getAllCatidMap();

        if ($catid) {
            $wheres = " catid='" . $catid . "'";
        } else {
            $wheres = " catdir='" . $caturl[0] . "' and parentid='0'";
        }
        if ($wheres) {
            $result = $this->_categoryurl_obj->getcategory($wheres);
            if ($result[0]['child'] > 0) {
                $wheres_catname = " catdir='" . $caturl[0] . "' and parentid='0'";
                $channel_catname = $this->_categoryurl_obj->getcategory($wheres_catname);
                if ($result[0]['parentid'] > 0) {
                    $this->view->assign('upcatname', $result[0]['catname']);  //获取上一级别的栏目名称
                    $this->view->assign('parenturl', $parenturl);  //获取上一级别的ID
                    $this->view->assign('channel_catname', $channel_catname[0]['catname']); //获取频道名称
                } else {
                    $this->view->assign('channel_catname', "");
                }
                $where_channel = " parentid='" . $result[0]['catid'] . "'";
                $channel_arry = $this->_categoryurl_obj->getcategory($where_channel);
                foreach ($channel_arry as $key => $val) {
                    if (isset($caturl) && !empty($caturl) && !in_array("nav.shtml", $caturl)) {
                        $channel_arry[$key]['art'] = $this->Channel_article($val['catid']);
                    }
                    $pdir = trim($channel_arry[$key]['parentdir'], "/");
                    $parentdir = explode("/", $pdir);
                    $channel_arry[$key]['catdir'] = "/" . $parentdir[0] . "/" . $channel_arry[$key]['catdir'];

                    //将 catdir 设置为其所在的域名  	-----	：新增
                    $url = $val['url'];
                    $matchArr = $this->resolveURL($url);
                    $domain = empty($matchArr) ? '' : (isset($matchArr[1]) ? $matchArr[1] : '');

                    $channel_arry[$key]['catdir'] = $domain;
                    $channel_arry[$key]['catid'] = $catidMap[$val['catid']] . "/";
                    $channel_arry[$key]['parentdir'] = '/' . $domain;
                }
            }
        }
        foreach ($result as $key => $val) {
            $settings = $result[$key]['setting'];
            eval("\$setting=$settings;");
            $result[$key]['setting'] = $setting;
        }
        $this->view->assign('channels_url', $tempCatidArr['channel_enname']);
        $this->view->assign('setting', $result[0]['setting']);   //获取网站描述
        $this->view->assign('channels', $result[0]['catname']);  //当前栏目名称
        $this->view->assign('catid', $catidMap[$result[0]['catid']]);  //当前频道ID
        $this->view->assign('channel_arry', $channel_arry);   //当前栏目的子栏目以及信息
//        if ($catid) {
//            $url = md5($_SERVER['REQUEST_URI']);
//            echo $this->view->render('channel/more_channel.tpl', $url);
//        } else {
            $url = md5($_SERVER['REQUEST_URI']);
            echo $this->view->render('channel/channel.tpl', $url);
        //}
    }
    
    function navAction(){
        $caturl = $this->url_path_params;
        //临时变量：
        $tempCatidArr = $this->cate_info_params;
        $parenturl = empty($tempCatidArr) ? '' : $tempCatidArr['wap_url'];
        $catid = empty($tempCatidArr) ? 0 : $tempCatidArr['catid'];
        $caturl[0] = trim($tempCatidArr['parentdir'], "/");
        $channel_id = empty($tempCatidArr) ?'0':$tempCatidArr['channel_id'];
        //得到 catid => /jkhf/bwby/ 的 map 对象  -----	：新增
        $catidMap = $this->_categoryurl_obj->getAllCatidMap();

        if ($catid) {
            $wheres = " catid='" . $catid . "'";
        } else {
            $wheres = " catdir='" . $caturl[0] . "' and parentid='0'";
        }
        if ($wheres) {
            $result = $this->_categoryurl_obj->getcategory($wheres);
            if ($result[0]['child'] > 0) {
                if($channel_id>0){
                    $wheres_catname = " catid='" . $channel_id. "' and parentid='0'";
                }else{
                    $wheres_catname = " catdir='" . $caturl[0] . "' and parentid='0'";
                }
                $channel_catname = $this->_categoryurl_obj->getcategory($wheres_catname);
                if ($result[0]['parentid'] > 0) {
                    $this->view->assign('upcatname', $result[0]['catname']);  //获取上一级别的栏目名称
                    $this->view->assign('parenturl', $parenturl);  //获取上一级别的ID
                    $this->view->assign('channel_catname', $channel_catname[0]['catname']); //获取频道名称
                } else {
                    $this->view->assign('channel_catname', "");
                }
                $where_channel = " parentid='" . $result[0]['catid'] . "'";
                $channel_arry = $this->_categoryurl_obj->getcategory($where_channel);
                foreach ($channel_arry as $key => $val) {
                	if (isset($caturl) && !empty($caturl) && !in_array("nav.shtml", $caturl)) {
                        $channel_arry[$key]['art'] = $this->Channel_article($val['catid']);
                    }
                    $pdir = trim($channel_arry[$key]['parentdir'], "/");
                    $parentdir = explode("/", $pdir);
                    $channel_arry[$key]['catdir'] = "/" . $parentdir[0] . "/" . $channel_arry[$key]['catdir'];

                    //将 catdir 设置为其所在的域名  	-----	：新增
                    $url = $val['url'];
                    $matchArr = $this->resolveURL($url);
                    $domain = empty($matchArr) ? '' : (isset($matchArr[1]) ? $matchArr[1] : '');

                    $channel_arry[$key]['catdir'] = $domain;
                    $channel_arry[$key]['catid'] = $catidMap[$val['catid']] . "/";
                    $channel_arry[$key]['parentdir'] = '/' . $domain;
                }
            }
        }
        foreach ($result as $key => $val) {
            $settings = $result[$key]['setting'];
            eval("\$setting=$settings;");
            $result[$key]['setting'] = $setting;
        }
        $this->view->assign('channels_url', $tempCatidArr['channel_enname']);
        $this->view->assign('setting', $result[0]['setting']);   //获取网站描述
        $this->view->assign('channels', $result[0]['catname']);  //当前栏目名称
        $this->view->assign('catid', $catidMap[$result[0]['catid']]);  //当前频道ID
        $this->view->assign('channel_arry', $channel_arry);   //当前栏目的子栏目以及信息
        $url = md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('channel/more_channel.tpl', $url);
    }
    /*
     * 显示栏目文章列表
     * 
     * 
     */
    function listAction() {
        $page = intval($this->getParam('page'));
        
        $caturl = $this->url_path_params;
        $domain = empty($caturl) ? "" : $caturl[0];
        $tempCatidArr = $this->cate_info_params;
        $id = empty($tempCatidArr) ? 0 : $tempCatidArr['catid'];
        
        if ($id) {
            $wheres = " catid='" . $id . "'";
        }
        if ($wheres) {
            $result = $this->_categoryurl_obj->getcategory($wheres);
            if ($result[0]['arrparentid']) {
                $catid_array = explode(',', $result[0]['arrparentid']);
                $where_cat = " catid='" . $catid_array[1] . "'";
                $catname_array = $this->_categoryurl_obj->getcategory($where_cat);

                //获取域名信息 ---xinzeng bufen 
                $channelPath = $pdir = $domain;
                $catdir = explode("/", $pdir);
                $channel_catdir = "/" . $catdir[0] . "/";
                $result[0]['catdir'] = "/" . $catdir[0];
                $result[0]['art_base_path'] = $channel_catdir . "article";
            }
            $where_count = " catid in ('" . $result[0]['arrchildid'] . "') and status='20'";
            $total = $this->_article_obj->getcount($where_count);
            $pnum = 18; //每页显示多少条数据
            $page = $page <= 1 ? 1 : $page;
            $total_page = ceil($total / $pnum);
            $page = $page >= $total_page ? $total_page : $page;
            if ($page == 0) {
                $offsize = 0;
            } else {
                $offsize = ($page - 1) * $pnum;
            }
            $where_art = " catid in ('" . $result[0]['arrchildid'] . "') and status='20' ORDER BY articleid desc LIMIT " . $offsize . "," . $pnum . "";
            $article_arry = $this->_article_obj->getarticle($where_art);
        }
        foreach ($result as $key => $val) {
            $settings = $result[$key]['setting'];
            eval("\$setting=$settings;");
            $result[$key]['setting'] = $setting;
        }

        //新增部分 ：
        $matchArr = $this->resolveURL($result[0]['url']);
        $catid = empty($matchArr) ? "" : (isset($matchArr[2]) ? $matchArr[2] : '');
        $result[0]['catid'] = $catid . "/";
        $result[0]['catdir'] = "/" . $domain;

        $pageup = $page - 1;
        $pagenp = $page + 1;
        if ($page == $total_page) {
            $page_html = '<a href="' . $result[0]['catdir'] . '/' . $result[0]['catid'] . 'list.shtml?page=' . $pageup . '" class="curr">上一页</a><a href="">' . $page . '/' . $total_page . '页</a>';
        } else if ($page == 0) {
            $page_html = '<a href="">' . $page . '/' . $total_page . '页</a><a href="' . $result[0]['catdir'] . '/' . $result[0]['catid'] . 'list.shtml?page=' . $pagenp . '" class="curr">下一页</a>';
        } else {
            $page_html = '<a href="' . $result[0]['catdir'] . '/' . $result[0]['catid'] . 'list.shtml?page=' . $pageup . '" class="curr">上一页</a><a href="">' . $page . '/' . $total_page . '页</a><a href="' . $result[0]['catdir'] . '/' . $result[0]['catid'] . 'list.shtml?page=' . $pagenp . '" class="curr"">下一页</a>';
        }
        $this->view->assign('setting', $result[0]['setting']);   //获取网站描述
        $this->view->assign('channels_name', $catname_array[0]['catname']);  //所在频道
        $this->view->assign('channel_catdir', $channel_catdir);  //所在频道URL
        $this->view->assign('channels', $result[0]['catname']);  //当前栏目名称
        $this->view->assign('catdir', $result[0]['catdir']);  //当前栏目URL
        $this->view->assign('art_base_path', $result[0]['art_base_path']);  //当前文章的根目录

        $this->view->assign('catid', $catid);  //当前栏目
        $this->view->assign('article_arry', $article_arry);   //获取文章列表
        $this->view->assign('page_html', $page_html);   //分页
        $url = md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('channel/catlist.tpl', $url);
    }

    private function Channel_article($catid) {
        if ($catid) {
            $where = " catid=" . $catid;
            $result = $this->_categoryurl_obj->Getcategory($where);
            $whereart = " catid in (" . $result[0]['arrchildid'] . ") and status='20' ORDER BY articleid desc LIMIT 0,6";
            $relevant_art = $this->_art_obj->getarticle($whereart);
            foreach ($relevant_art as $key => $val) {
                $wheres = " catid=" . $val['catid'];
                $res_cat = $this->_categoryurl_obj->getcategory($wheres);
                $pdir = trim($res_cat[0]['parentdir'], "/");
                $parentdir = explode("/", $pdir);
                $relevant_art[$key]['catdir'] = "/" . $parentdir[0] . "/" . $res_cat[0]['catdir'];
                $relevant_art[$key]['channel'] = "/" . $parentdir[0] . "/";
                $relevant_art[$key]['art_base_path'] = "/" . $parentdir[0] . "/article";

                //xinzeng bufen 
                $matchArr = $this->resolveURL($res_cat[0]['url']);
                $domain = empty($matchArr) ? "" : $matchArr[1];
                $catid = empty($matchArr) ? "" : (isset($matchArr[2]) ? $matchArr[2] : "");

                $relevant_art[$key]['art_base_path'] = "/" . $domain . "/article";
                $relevant_art[$key]['channel'] = "/" . $domain . "/";
                $relevant_art[$key]['catdir'] = "/" . $domain;
                $relevant_art[$key]['catid'] = "/" . $catid;
            }
            return $relevant_art;
        }
    }

    function showAction() {


        echo $this->view->render('channel/show.html');
    }

}
