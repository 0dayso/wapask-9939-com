<?php

/**
 * 基础表，可以在此完成一些公共Controller，供继承词类的类使用
 *
 */
class App_Controller_Action extends Q_Controller_Smarty {

    public $url_path_params = array();
    public $channel_enname = '';
    public $pc_root_channel_url = '';
    public $wap_root_channel_url = '';
    public $cate_info_params = array();

    public function init() {
        parent::init();
        $this->initVaribles();
    }

    private function initVaribles() {
        header('Cache-Control:max-age=3600');
        $this->enableCache();
    }

    /**
     * 
     * @param type $template 模板名称
     * @param type $cache_key 缓存键
     */
    public function display($template, $cache_key) {
        $smart = $this->view->getEngine();
        if ($smart->isCached($template, $cache_key)) {
            $smart->display($template, $cache_key);
            exit;
        }
    }
    /**
     * 开启smarty缓存
     */
    public function enableCache(){
        $smart = $this->view->getEngine();
        $smart->caching = false;
        $smart->cache_lifetime =18000;// 3600;
        $smart->setCacheDir(APP_CACHE_PATH.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.'smarty_pages');
        $smart->setCompileDir(APP_CACHE_PATH.DIRECTORY_SEPARATOR.'templates_c');
    }

    /**
     * 解析拆分 url
     * @author gaoqing
     * 2015年10月26日
     * @param string $url 要被拆分的 url
     * @return array 拆分后的 url 数组
     */
    public function resolveURL($url) {
        $urlArr = array();

        if (isset($url) && !empty($url)) {
            preg_match("/http:\/\/([\s\S]*?).9939.com\/([\s\S]*?)\/?$/", $url, $urlArr);
        }
        return $urlArr;
    }

}
