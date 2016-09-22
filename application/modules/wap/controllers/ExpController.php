<?php

/**
 * 健康经验 控制器
 */
class ExpController extends App_Controller_Action {

    //0: 常见疾病; 1: 生活保健; 2:  两性健康; 3:  整形美容)
    private $plates = array(
        0 => array('name' => '常见疾病', 'url' => '/expcat/0/'),
        1 => array('name' => '生活保健', 'url' => '/expcat/1/'),
        2 => array('name' => '两性健康', 'url' => '/expcat/2/'),
        3 => array('name' => '整形美容', 'url' => '/expcat/3/'),
    );

    function init() {
        parent::init();
        $this->initView();
    }

    public function indexAction() {
        $this->fillSuffix();
        $this->_zxads_obj = new App_Model_Zxads();
        $this->_exp_obj = new App_Model_Experience();
        //获取首页广告位（图片或者文字链）
        $zx_where = " placeid='4596' ";   //4596
        $zx_adsplace = $this->_zxads_obj->Getadsplace($zx_where);

        $zx_ads = array();
        if (!empty($zx_adsplace)) {
            $where = " placeid='" . $zx_adsplace[0]['placeid'] . "' order by addtime desc limit 0," . $zx_adsplace[0]['items'] . "";
            $zx_ads = $this->_zxads_obj->Getads($where);
            if ($zx_ads && is_array($zx_ads)) {
                foreach ($zx_ads as $key_ads => $val_ads) {
                    if ($val_ads['imageurl']) {
                        $zx_ads[$key_ads]['imageurl'] = "http://www.9939.com/uploadfile/" . $val_ads['imageurl'];
                    }
                }
            }
        }

        $array = array('0' => '常见疾病', '1' => '生活保健', '2' => '两性健康', '3' => '整形美容');
        //查询分类文章，各一篇
        foreach ($array as $i => $val) {
            $plateData[] = $this->_exp_obj->getPlateBy($i);
            $plateData[$i]['content'] = $this->screening($plateData[$i]['content']);
        }
        //查询相关问答
        $ask_array = array('16' => '生活百科', '524' => '两性健康', '537' => '常见疾病', '299' => '整形美容');
        foreach ($ask_array as $k => $array) {
            $ask_list[$array] = $this->_exp_obj->getaskList($k);
        }
//        print_r($ask_list['两性健康']);exit;
        //查询最新文章
        $article_list = $this->_exp_obj->getArticleList(0, 6);
        foreach ($article_list as $k => $detail) {
            $article_list[$k]['content'] = $this->screening($detail['content']);
        }
        $this->view->assign('zx_ads', $zx_ads);
        $this->view->assign('plateData', $plateData);
        $this->view->assign('ask_list', $ask_list);
        $this->view->assign('article_list', $article_list);
        echo $this->view->render('exp/index.tpl');
    }

    public function screening($content) {
        $content = strip_tags($content); //过滤所有的html页面
        $content = str_replace("&nbsp;", "", $content); //过滤空格
        $content = str_replace(PHP_EOL, '', $content); //过滤换行
        $search = array(" ", "　", "\n", "\r", "\t"); //过滤空格
        $replace = array("", "", "", "", "");
        return str_replace($search, $replace, $content);
    }

    /**
     * 内容页
     * @author gaoqing
     * @date 2016-07-22
     * @return string 视图
     */
    public function contentAction() {
        $template = 'exp/content.tpl';
        $md5URL = md5($_SERVER['REQUEST_URI']);

        $request = $this->getRequest();

        $addtime = $request->getParam('addtime', '0');
        $id = $request->getParam('id', '0');

        if (!empty($id)) {

            //1、查询当前文章的内容
            $experience = new App_Model_Experience();
            $exp = $experience->getExperience($id, true, true);

            if (!empty($exp)) {
                $exp['addtime_init'] = $exp['addtime'];
                $exp['addtime'] = date('Y-m-d', $exp['addtime']);

                //2、查询疾病信息
                $disease = $experience->getDiseaseByDisid($exp['diseaseid'], $exp['catid']);

                //3、相关经验
                $relExps = $experience->getRelExps($exp['diseaseid'], 4);

                //4、相关问题
                $relAsks = array();
                if (!empty($disease)) {
                    $ask = new App_Model_Ask();
                    $relAsks = $ask->getList(' classid = ' . $disease['diseaseid'], 'id DESC', 4);
                }

                $this->view->assign("exp", $exp);
                $this->view->assign("disease", $disease);
                $this->view->assign("relExps", $relExps);
                $this->view->assign("relAsks", $relAsks);

                echo $this->view->render($template, $md5URL);
            }
        }
    }

    /**
     * 经验分享
     */
    public function categoryAction() {
        $this->fillSuffix();
        $template = 'exp/category.tpl';
        $uri = $_SERVER['REQUEST_URI'];
        $md5URL = md5($uri);
        $cate = $this->getParam('cate', 'expcat');
        $id = $this->getParam('id', '0');
        $page = $this->getParam('page', '1');

        $plates = $this->plates;

        $exp_obj = new App_Model_Experience();
        $plateid = $id;
        $catid = '';
        $catshow = '全部';
        $curname = '';
        $diseaseid = '';
        if ($cate == 'explist') {
            $category = $exp_obj->getCategoryByCatid($id);
            $plateid = $category['plateid'];
            $catid = $id;
            $catshow = $category['name'];
            $curname = $category['name'];
        } elseif ($cate == 'expdis') {
            $disease = $exp_obj->getDiseaseByDisid($id);
            $category = $exp_obj->getCategoryByCatid($disease['catid']);
            $plateid = $disease['plateid'];
            $catid = $disease['catid'];
            $diseaseid = $id;
            $catshow = $category['name'];
            $curname = $disease['name'];
        }

        $curname = $curname ? $curname : $plates[$id]['name'];

        //plateid->科室
        $categories = array();
        $categories = $exp_obj->getCategoriesByPlateid($plateid);
        //catid->疾病
        $disease = array();
        if ($cate !== 'expcat') {
            $disease = $exp_obj->getDiseaseByCatid($catid);
        }

        //列表数据部分
        $idtype = '';
        switch ($cate) {
            case 'explist':
                $idtype = 'catid';
                break;
            case 'expdis':
                $idtype = 'diseaseid';
                break;
            default:
                $idtype = 'plateid';
                break;
        }
        $size = 12;
        $count = $exp_obj->getCountByCon($idtype, $id); //总数
        $totalpage = ceil($count / $size);
        $page = min($page, $totalpage);
        $page = empty($page) ? 1 : $page;
        $offset = $size * ($page - 1);
        $list = $exp_obj->getListByCon($idtype, $id, $offset, $size);
        $expids = '';
        $diseaseids = '';
        foreach ($list as $k => $v) {
            $expids .= $v['id'] . ',';
            $diseaseids .=$v['diseaseid'] . ',';
            $list[$k]['url'] = '/exp/' . $v['addtime'] . $v['id'] . '.html';
        }
        $expids = trim($expids, ',');
        $diseaseids = trim($diseaseids, ',');
        $listcontent = $exp_obj->getContentList($expids);
        $listcontent = array_map(function($v) {
            $v['content'] = strip_tags($v['content']);
            return $v;
        }, $listcontent);
        $listcontent = self::setColumntoKey($listcontent, 'id');

        $listdisease = $exp_obj->getDislistByDisid($diseaseids);
        $listdisease = self::setColumntoKey($listdisease, 'id');

        $pre = ($page > 1) ? ($page - 1) : 1;
        $next = ($page == $totalpage) ? $totalpage : ($page + 1);
        $pageurl = array(
            'pre' => sprintf('/%s/%d-%d/', $cate, $id, $pre),
            'next' => sprintf('/%s/%d-%d/', $cate, $id, $next),
            'page' => $page,
            'totalpage' => $totalpage,
        );
        $current = array(
            'cate' => $cate,
            'plateid' => $plateid,
            'catid' => $catid,
            'diseaseid' => $diseaseid,
            'plateshow' => $plates[$plateid]['name'],
            'catshow' => $catshow,
            'curname' => $curname,
            'uri' => $uri,
        );
        $this->view->assign('current', $current); //当前分类
        $this->view->assign('plates', $this->plates); //4模块
        $this->view->assign('categories', $categories); //科室部分
        $this->view->assign('disease', $disease); //疾病部分
        $this->view->assign('list', $list); //列表部分
        $this->view->assign('listcontent', $listcontent); //列表部分
        $this->view->assign('listdisease', $listdisease); //列表部分
        $this->view->assign('pageurl', $pageurl); //页码部分
        echo $this->view->render($template, $md5URL);
    }

    /**
     * 我要分享
     */
    public function shareAction() {
        $this->fillSuffix();
        $uri = $_SERVER['REQUEST_URI'];
        $template = 'exp/share.tpl';
        $md5URL = md5($uri);
        echo $this->view->render($template, $md5URL);
    }

    /**
     * 我的经验
     */
    public function mysharingAction() {
        $this->fillSuffix();
        $uri = $_SERVER['REQUEST_URI'];
        $template = 'exp/mysharing.tpl';
        $md5URL = md5($uri);
        echo $this->view->render($template, $md5URL);
    }

    private static function setColumntoKey($array = array(), $column = 'id') {
        $newarr = array();
        foreach ($array as $k => $v) {
            $newarr[$v[$column]] = $v;
        }
        return $newarr;
    }

    private function fillSuffix() {
        $uristr = $_SERVER['REQUEST_URI'];
        $str_params = '';
        if ($pos = strpos($uristr, '?')) {
            $str_params = substr($uristr, $pos);
            $uristr = substr($uristr, 0, $pos);
        }
        if (($last_char = substr($uristr, -1) ) != '/' && (stripos($uristr, '.shtml') === false)) {
            $redirect_url = 'http://' . $_SERVER['HTTP_HOST'] . $uristr . '/';
            $redirect_url.= $str_params;
            header("Location:$redirect_url", true, 301);
            exit;
        }
    }

}
