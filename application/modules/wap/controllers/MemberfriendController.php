<?php

/**
 * @version 0.0.0.1
 */

/**
 * 会员朋友的 controller 
 * @author gaoqing
 * 2015年9月7日
 */
class MemberfriendController extends App_Controller_Action{
	
	/** 医生实体类 */
	private $doctor = null;	
	
	/** HTML 的过滤器 */
	private $htmlFilter = null;
	
	/** 整数 的过滤器 */
	private $intFilter = null;
	
	/** 会员好友实体类 */
	private $memberfriend = null;	
	
	/**
	 * 初始化方法
	 * @see Zend_Controller_Smarty::init()
	 */
	public function init(){
		parent::init();
		
		$this->htmlFilter = new Zend_Filter_HtmlEntities();
		$this->intFilter = new Zend_Filter_Int();
		$this->memberfriend = new App_Model_Memberfriend();		
		$this->doctor = new App_Model_Doctor();		
	}
	
	
	/**
	 * 默认的方法(查看指定数目的好友)
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	public function indexAction() {
		
		$template_path = "memberfriend/friend.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);
		
		$request = $this->getRequest();
		
		$initUid = $request->getParam("uid", 0);
		$initCurrentPage = $request->getParam("currentPage", 1);
		
		$uid = $this->intFilter->filter($initUid);
		$currentPage = $this->intFilter->filter($initCurrentPage);
		
		//1、查询医生的疾病信息
		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid);		
		
		//2、查询当前用户下，所有好友的个数
		$doctorFriendsCount = $this->memberfriend->getDoctorFriendsCount($uid);
		
		//3、得到当前用户的所有朋友
		$pageSize = 8;
		$start = ($currentPage - 1) * $pageSize;
		$pageNum = ceil($doctorFriendsCount/$pageSize);
		$doctorAllFriendArr = $this->memberfriend->getDoctorFriends($uid, $start, $pageSize);
		
		//4、得到分页的 HTML
		$pageHTML = $this->getPageHTML("/doctor/friends/" . $uid . "-", $currentPage, $pageNum);
		
		$this->view->assign("uid", $uid);
		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
		$this->view->assign("doctorFriendsCount", $doctorFriendsCount);
		$this->view->assign("pageHTML", $pageHTML);
		$this->view->assign("doctorAllFriendArr", $doctorAllFriendArr);
		$this->view->assign("initCurrentPage", $initCurrentPage);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 得到分页的 HTML 字符串
	 * @author gaoqing
	 * 2015年9月06日
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

?>