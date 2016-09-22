<?php

/**
 * @version 0.0.0.1
 */

/**
 * 会员日志的 controller 
 * @author gaoqing
 * 2015年9月6日
 */
class MemberblogController extends App_Controller_Action{
	
	/** 医生实体类 */
	private $doctor = null;	
	
	/** HTML 的过滤器 */
	private $htmlFilter = null;
	
	/** 整数 的过滤器 */
	private $intFilter = null;
	
	/** 会员日志实体类 */
	private $memberBlog = null;	
	
	/**
	 * 初始化方法
	 * @see Zend_Controller_Smarty::init()
	 */
	public function init(){
		parent::init();
		
		$this->htmlFilter = new Zend_Filter_HtmlEntities();
		$this->intFilter = new Zend_Filter_Int();
		$this->memberBlog = new App_Model_Memberblog();		
		$this->doctor = new App_Model_Doctor();		
	}
	
	/**
	 * 日志的详细信息  
	 * @author gaoqing
	 * 2015年9月6日
	 * @param void 空
	 * @return void 空
	 */
	public function detailAction(){
		
		$template_path = "memberblog/blogDetail.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);
		
		$request = $this->getRequest();
		
		$initUid = $request->getParam("uid", 0);
		$initBlogID = $request->getParam("blogid", 0);
		
		$uid = $this->intFilter->filter($initUid);
		$blogID = $this->intFilter->filter($initBlogID);
		
		//1、得到医生的简短信息
		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid);
		
		//2、得到指定 ID 下的日志详细信息
		$detailBlog = $this->memberBlog->getDetailBlog($blogID);
		
		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
		$this->view->assign("detailBlog", $detailBlog);

		$this->view->assign("doctorid", $uid);
		$this->view->assign("blogid", $blogID);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 日志详情页中的分页部分
	 * @author gaoqing
	 * 2015年9月10日
	 * @param void 空
	 * @return void 空
	 */
	public function detailpageAction() {
		
		$template_path = "memberblog/blogDetailPage.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);
		
		$request = $this->getRequest();
		
		$initUid = $request->getParam("uid", 0);
		$initBlogID = $request->getParam("blogid", 0);
		$initCurrentPage = $request->getParam("currentPage", 1);
		
		$uid = $this->intFilter->filter($initUid);
		$blogID = $this->intFilter->filter($initBlogID);
		$currentPage = $this->intFilter->filter($initCurrentPage);
		
		//3、得到当前用户下的其他日志列表
		$doctorBlogCount = $this->memberBlog->getMemberBlogCount($uid);
		$doctorBlogCount = empty($doctorBlogCount) ? 0 : ($doctorBlogCount - 1);
		$pageSize = 3;
		$start = ($currentPage - 1) * $pageSize;
		$pageNum = ceil($doctorBlogCount/$pageSize);
		$doctorBlogArr = $this->memberBlog->getDoctorBlogArr($uid, $start, $pageSize, $blogID);
		
		//得到分页的 HTML
		$pageHTML = $this->getCommonAjaxPageHTML("fatherHTMLID", "/memberblog/detailpage/uid/" . $uid . "/blogid/" . $blogID . "/currentPage/", $currentPage, $pageNum);
		
		$this->view->assign("doctorBlogArr", $doctorBlogArr);
		$this->view->assign("pageHTML", $pageHTML);
		$this->view->assign("doctorBlogCount", $doctorBlogCount);
		$this->view->assign("doctorid", $uid);
		$this->view->assign("blogid", $blogID);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 默认的方法
	 * @author gaoqing
	 * 2015年9月6日
	 * @param void 空
	 * @return void 空
	 */
	public function indexAction() {
		
		$template_path = "memberblog/blogList.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);
		
		$request = $this->getRequest();
		
		//得到参数
		$initUid = $request->getParam("uid", 0);
		$initCurrentPage = $request->getParam("currentPage", 1);
		
		$uid = $this->intFilter->filter($initUid);
		$currentPage = $this->intFilter->filter($initCurrentPage);
		
		//1、得到医生的基本信息
		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid);
		
		//2、得到医生的所有日志信息（分页信息）
		$doctorBlogCount = $this->memberBlog->getMemberBlogCount($uid);
		$pageSize = 14;
		$start = ($currentPage - 1) * $pageSize;
		$pageNum = ceil($doctorBlogCount/$pageSize);
		$doctorBlogArr = $this->memberBlog->getDoctorBlogArr($uid, $start, $pageSize);
		
		//得到分页的 HTML 
		$pageHTML = $this->getPageHTML("/doctor/blog/" . $uid . "/", $currentPage, $pageNum);
		
		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);		
		$this->view->assign("doctorBlogCount", $doctorBlogCount);		
		$this->view->assign("doctorBlogArr", $doctorBlogArr);		
		$this->view->assign("pageHTML", $pageHTML);		
		$this->view->assign("doctorid", $uid);		
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 得到 通用 ajax 分页的 HTML 字符串
	 * @author gaoqing
	 * 2015年9月06日
	 * @param string $pageBaseURL 分页的基路径
	 * @param int $currentPage 当前页
	 * @param int $pageNum 总的记录数
	 * @return string 疾病分页的 HTML 字符串
	 */
	private function getCommonAjaxPageHTML($fatherHTMLID, $pageBaseURL, $currentPage, $pageNum) {
	
		//上一页
		$preCurrentPage = $currentPage == 1 ? 1 : ($currentPage - 1);
		$prePage = '<a href="javascript:" id = "prePage"  >上一页</a>';
	
		//下一页
		$nextCurrentPage = $currentPage == $pageNum ? $pageNum :  ($currentPage + 1);
		$nextPage = '<a href="javascript:" id = "nextPage"  >下一页</a>';
	
		if ($pageNum == 0) {
			$currentPage = 0;
		}
		$pageHTML =
		$prePage .
		'<span>' . $currentPage . '/' . $pageNum . '</span>'.
		$nextPage;
	
		if ($pageNum != 0) {
			//添加 ajax js 部分
			$pageHTML .= '<script type="text/javascript" > ';
	
			if ($currentPage != 1) {
				$pageHTML .= ' $("#prePage").click(function(){    $.ajax({url: "'. $pageBaseURL .  $preCurrentPage .'", cache: false, success: function(html){$("#'. $fatherHTMLID .'").html(html);}  });    });  ' ;
			}
			if ($currentPage != $pageNum){
				$pageHTML .= ' $("#nextPage").click(function(){    $.ajax({url: "'. $pageBaseURL . $nextCurrentPage .'", cache: false, success: function(html){$("#'. $fatherHTMLID .'").html(html);}  });    });  ' ;
			}
			$pageHTML .= ' </script>';
		}
		return $pageHTML;
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