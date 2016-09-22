<?php
/**
**潘红晶 
* 日期 2015年5月
**/
class BottomController extends Q_Controller_Smarty{
    function init(){
		parent::init();
		$this->initView();
	}
    //网站简介
	function indexAction(){
        echo $this->view->render('bottom/siteprofile.tpl');
	}
    //战略合作
    function zlhzAction(){
        echo $this->view->render('bottom/zlhz.tpl');
	}
    //联系我们
    function contactAction(){
        echo $this->view->render('bottom/contact_us.tpl');
	}
    //意见反馈
    function feedbackAction(){
        echo $this->view->render('bottom/yijianfangui.tpl');
	}
	
}