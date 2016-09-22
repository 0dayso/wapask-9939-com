<?php

/**
 * @version 0.0.0.1
 */

/**
 * 科室相关信息的 controller 
 * @author gaoqing
 * 2015年9月6日
 */
class DepartmentController extends App_Controller_Action{
	
	/** 科室的实体类 */
	private $department = null;
	
	/** HTML 的过滤器 */
	private $htmlFilter = null;
	
	/** 整数 的过滤器 */
	private $intFilter = null;	
	
	/** 问答 model 类 */
	private $ask = null;	
	
	/**
	 * 初始化方法
	 * @see Zend_Controller_Smarty::init()
	 */
	public function init(){
		parent::init();
		
		$this->department = new App_Model_Department();
		$this->ask = new App_Model_Ask();
		
		$this->htmlFilter = new Zend_Filter_HtmlEntities();
		$this->intFilter = new Zend_Filter_Int();
	}
	
	/**
	 * 默认的方法
	 * @author gaoqing
	 * 2015年9月6日
	 * @param void 空
	 * @return void 空
	 */
	public function indexAction() {
		$request = $this->getRequest();
		
		/*
		 * 1、如果 【科室名称】不为空的话，则说明是通过 【科室名称】来定位到科室信息
		 * 	1.1、通过 【科室名称】，得到当前科室的 $classid 
		 * 2、如果【科室名称】为空的话，则得到 $classid 
		 * 3、通过 当前 $classid 得到当前科室下 pid = $classid 的所有科室名称及 classid
		 */
		
		$initDepartmentName = $request->getParam("department", "");
		$initClassid = $request->getParam("classid", 0);
		
		$initCurrentPage = $request->getParam("currentPage", 1);
		if (empty($initCurrentPage)) {
			$initCurrentPage = 1;
		}
		$currentPage = $this->intFilter->filter($initCurrentPage);
		
		$departmentName = $this->htmlFilter->filter($initDepartmentName);
		$classid = $this->intFilter->filter($initClassid);
		
		//根据 classid ，判断当前科室是一级科室还是二级科室
		$department = $this->department->getDepartmentSimpleInfo($classid);
		$level = "two";
		if (isset($department) && !empty($department) && $department['pID'] == 0) {
			$level = "one";
		}
		
		//1、如果 【科室名称】不为空的话，则说明是通过 【科室名称】来定位到科室信息
		if (empty($classid) && !empty($departmentName)) {
			$classid = $this->department->getClassidByName($departmentName);
		}else {
			//得到科室的名称
			$departmentName = $this->department->getClassNameByClassid($classid, false);
		}
		
		/*
		 * 3、通过 当前 $classid 得到当前科室下 pid = $classid 的所有科室名称及 classid
		 * 	3.1、如果是一级科室的话，就查询 前 8 个疾病
		 * 	3.2、如果是二级科室的话，就直接查询二级科室下，所有的疾病
		 */
		$childArr = null;
		if ($level == "one") {
			$childArr = $this->department->getOneLevelDisease($classid);
		}else {
			$childArr = $this->department->getLatestLevelChild($classid);
		}
		
		//得到问题的信息
		$departmentAskAnswerList = $this->getDepartmentAskAndAnswer($classid, $departmentName, $childArr, $level, $request);

        //查询 【前列腺炎】的广告位信息
        $qlx_ads = array();
        $qlx_child_arr = array(232,551,553);
        if (in_array($classid, $qlx_child_arr)){
            $zxad = new App_Model_Zxads();
            $qlx_ads = $zxad->ads(270, 3);
        }
        $this->view->assign("qlx_ads", $qlx_ads);
		$this->view->assign("departmentName", $departmentName);
		$this->view->assign("classid", $classid);
		$this->view->assign("currpage", $currentPage);
		$this->view->assign("childArr", $childArr);
		$this->view->assign("askCount", $departmentAskAnswerList['num']);
		$this->view->assign("askAndAnswerArr", $departmentAskAnswerList['data']);
		$this->view->assign("pageHTML", $departmentAskAnswerList['html']);
		
		$md5URL = md5($_SERVER['REQUEST_URI']);
		echo $this->view->render("department/twoLevel.tpl", $md5URL);
	}
	
	/**
	 * 得到科室下的所有疾病的问答
	 * @author gaoqing
	 * 2015年9月9日
	 * @param int $classid 科室的 id 
	 * @param string $departmentName 科室的名称
	 * @param array $diseaseArr 当前科室下的疾病集
	 * @param string $level 当前请求的科室级别
	 * @param Zend_Controller_Request_Abstract $request 请求对象
	 * @return array 科室下的所有疾病的问答及分页代码
	 */
	private function getDepartmentAskAndAnswer($classid, $departmentName, $diseaseArr, $level, $request) {
		$departmentAskAndAnswer = array();
		
		$initCurrentPage = $request->getParam("currentPage", 1);
		if (empty($initCurrentPage)) {
			$initCurrentPage = 1;
		}
		$currentPage = $this->intFilter->filter($initCurrentPage);
		
		//1、组织 科室的 id 字符串集
		$askidStr = "";
		foreach ($diseaseArr as $key => $ask){
			if (is_array($ask)) {
				$askidStr .= $ask['id'] . ",";
			}
		}
		if (!empty($askidStr) && $askidStr != ",") {
			$askidStr = substr($askidStr, 0, strlen($askidStr) - 1);
		}else{
			$askidStr = $classid;
		}
		
		//2、得到总的问答数
		$askCount = $this->ask->getAskCountByClassid($askidStr);
			
		//3、分页相关的参数组装
		$pageSize = 7;
		$start = ($currentPage - 1) * $pageSize;
		$pageNum = ceil($askCount / $pageSize);
			
		//4、得到分页的问答信息集
		$userDifineWhere = array("where" => " AND classid in (?) AND examine = 1 ", "condition" => $askidStr);
		$askAndAnswerArr = $this->ask->getAskAndAnswers(null, $start, $pageSize, $userDifineWhere);
			
		//5、得到分页 HTML
		//$pageBaseURL = "/department/index/level/" . $level . "/department/". urlencode($departmentName) . "/currentPage/";
		$pageBaseURL = "/classid/". $classid . "-";
		$pageHTML = $this->getPageHTML($pageBaseURL, $currentPage, $pageNum, true);		
		
		$departmentAskAndAnswer['data'] = $askAndAnswerArr;
		$departmentAskAndAnswer['num'] = $askCount;
		$departmentAskAndAnswer['html'] = $pageHTML;
		
		return $departmentAskAndAnswer;
	}
	
	/**
	 * 更多科室
	 * @author gaoqing
	 * 2015年9月6日
	 * @param void 空
	 * @return void 空
	 */
	public function moreAction() {
		
		$template_path = "department/moreDepartment.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);
		
		/*
		 * 查询所有的一级科室，并将所有一级科室下的二级科室查询出来
		 */
		$allDepartmentArr = $this->department->getAllDepartment();
		
		$this->view->assign("allDepartmentArr", $allDepartmentArr);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 得到分页的 HTML 字符串
	 * @author gaoqing
	 * 2015年9月06日
	 * @param string $pageBaseURL 分页的基路径
	 * @param int $currentPage 当前页
	 * @param int $pageNum 总的记录数
	 * @param boolean $isAddSuffix 是否添加后缀（.html）
	 * @return string 疾病分页的 HTML 字符串
	 */
	private function getPageHTML($pageBaseURL, $currentPage, $pageNum, $isAddSuffix = false) {
	
		//上一页
		$preCurrentPage = $currentPage == 1 ? 1 : ($currentPage - 1);
		$prePageURL = $pageBaseURL . $preCurrentPage;
		if ($isAddSuffix) {
			$prePageURL .= ".html";
		}
		if ($currentPage == 1) {
			$prePageURL = "javascript:";
		}
		$prePage = '<a href="'. $prePageURL .'">上一页</a>';
	
		//下一页
		$nextCurrentPage = $currentPage == $pageNum ? $pageNum :  ($currentPage + 1);
		$nextPageURL = $pageBaseURL . $nextCurrentPage;
		if ($isAddSuffix) {
			$nextPageURL .= ".html";
		}
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