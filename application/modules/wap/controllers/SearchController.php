<?php

/**
 * 搜索模块的 controller 
 * @author gaoqing
 * 2015-08-28
 */
 class SearchController extends App_Controller_Action{
 	
 	/** 疾病 Model */
 	private $disease = null;
 	
 	/** 问答 Model */
 	private $ask = null;
 	
 	/** 科室 Model */
 	private $department = null;
 	
 	/** HTML 的过滤器 */
 	private $htmlFilter = null;
 	
 	/** 整数 的过滤器 */
 	private $intFilter = null;
 	
 	/**
 	 * 初始化方法
 	 * @see Zend_Db_Table_Abstract::init()
 	 * @author gaoqing
 	 * 2015-08-28
 	 */
 	public function init(){
 		parent::init();
 		$this->initView();
 		
 		$this->disease = new App_Model_Disease();
 		$this->ask = new App_Model_Ask();
 		$this->department = new App_Model_Department();
 		$this->htmlFilter = new Zend_Filter_HtmlEntities();
 		$this->intFilter = new Zend_Filter_Int();
 	}
 	
 	/**
 	 * 疾病详情
 	 * @author gaoqing
 	 * 2015年8月31日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function detaildiseaseAction(){
 		
 		$template_path = "askdoctor/detailDisease.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		/*
 		 * 1、得到并处理前台传递过来的参数（疾病id diseaseID）
 		 * 2、根据疾病id diseaseID ,得到疾病的基本信息（9939_dzjb: title, thumb, description）diseaseBasicInfoArr
 		 * 3、根据疾病id diseaseID ,得到疾病相关的症状信息 （9939_dzjb: title, content_id）symptomArr
 		 * 4、根据疾病id diseaseID ,得到疾病相关的药品信息（9939_yaopin: ypId, ypName, ypPic, ypUrl）drugArr
 		 * 5、根据疾病的名称，查询相关的问答信息（）askAndAnswerArr
 		 */
 		
 		//1、得到并处理前台传递过来的参数（疾病id diseaseID）
 		$request = $this->getRequest();
 		$initDiseaseID = $request->getParam("diseaseID", 0);
 		$diseaseID = $this->intFilter->filter($initDiseaseID);
 		
 		//注：如果传递过来的是科室下的 疾病名称，需要通过疾病名称，查询到其相应的 疾病id
 		$classid = $request->getParam("classid", 0);
 		if (!empty($classid)) {
 			//通过 科室疾病 的 id, 查询科室疾病的名称
 			/*$departmentName = $this->department->getClassNameByClassid($classid);
 			$diseaseID = $this->disease->getDiseaseIDByName($departmentName);*/
            $diseaseID = $classid;
 		}
                
        /**
         * 新添加的逻辑，lc 2016-4-25
         * 根据当前url获取的id先查9939_com_v2sns->wd_keshi得到疾病名称
         * 通过疾病名称再查9939_com_dzjb->9939_dzjb同名的疾病信息
         */
        $diseaseName = $this->department->getClassNameByClassid($diseaseID, false);
        $this->getNewDiseaseInfo($diseaseName, $diseaseID);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
	/**
	 * 疾病详情的分页方法
	 * @author gaoqing
	 * 2015年9月9日
	 * @param void 空
	 * @return void 空
	 */
	 public function detaildiseasepageAction() {
	 	
	 	$template_path = "askdoctor/detailDiseasePage.tpl";
	 	$md5URL = md5($_SERVER['REQUEST_URI']);
	 	$this->display($template_path, $md5URL);
	 	
	 	// /search/detailDisease/diseaseID/139112/currentPage/2
	 	
 		$request = $this->getRequest();
 		
 		$initDiseaseID = $request->getParam("diseaseID", 0);
 		$initDiseaseName = $request->getParam("diseaseName", "");
 		$initCurrentPage = $request->getParam("currentPage", 1);
 		
 		$diseaseID = $this->intFilter->filter($initDiseaseID);
 		$currentPage = $this->intFilter->filter($initCurrentPage);
 		$diseaseName = $this->htmlFilter->filter($initDiseaseName);
	 
		//得到当前疾病名称所对应的所有问答数
 		$askCount = $this->ask->getAskCountByClassid($diseaseID);
 		
 		//分页相关的参数组装
 		$pageSize = 7;
 		$start = ($currentPage - 1) * $pageSize;
 		$pageNum = ceil($askCount / $pageSize);
 		
 		//得到分页的问答信息集
 		$askAndAnswerArr = $this->ask->getAskAndAnswers($diseaseID, $start, $pageSize);
 		
 		//得到分页 HTML
 		$pageBaseURL = "/search/detaildiseasepage/diseaseID/". $diseaseID . "/diseaseName/". urlencode($diseaseName) ."/currentPage/";
 		$pageHTML = $this->getCommonAjaxPageHTML("fatherHTMLID", $pageBaseURL, $currentPage, $pageNum);
 		
 		$this->view->assign("askAndAnswerArr", $askAndAnswerArr);
 		$this->view->assign("pageHTML", $pageHTML);
 		
 		echo $this->view->render($template_path, $md5URL);
	}

 	
 	/**
 	 * 搜索疾病 部分的入口方法 
 	 * @author gaoqing
 	 * 2015年8月28日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function indexAction() {

        $template_path = "askdoctor/search_asks.tpl";
        $md5URL = md5($_SERVER['REQUEST_URI']);
        $this->display($template_path, $md5URL);
 		
 		//得到 request 对象
 		$request = $this->getRequest();
 		
 		//得到搜索的关键词
 		$searchWords = $request->getParam("searchWords", "");
 		$isdisease = $request->getParam("isdisease", 1);
 		$initCurrentPage = $request->getParam("currentPage", 1);

        //过滤参数
        $searchWords = $this->htmlFilter->filter($searchWords);
        $currentPage = $this->intFilter->filter($initCurrentPage);
        $isdisease = $this->intFilter->filter($isdisease);

        $diseaseid = 0;
 		if (!empty($searchWords)) {
            /*
             * 1、根据当前的 $searchWords ，查询 wd_disease 中是否有对应名称的疾病
             *  1.1、如果存在，获取到起 $diseaseID
             *      1.1.1、根据 $diseaseID, 查询对应的问答
             *  1.2、如果不存在，则根据当前 $searchWords 查询对应问答 title 中有该关键字的数据
             */

            if($isdisease == 1){
                $diseaseid = $this->department->getClassidByName($searchWords, true);
            }

            //获取到了对应的疾病
            if (!empty($diseaseid)){
                //$this->getNewDiseaseInfo($searchWords, $diseaseid);
                //echo $this->view->render($template_path, $md5URL);
                $this->_redirect("/disease/" .$diseaseid . ".html");

            //没有获取到对应的疾病
            } else {
                $this->_redirect("/so/" .$searchWords . "/" . $currentPage);
            }
 		}
 	}

     public function likediseaseAction(){
         $request = $this->getRequest();

         $searchWords = $request->getParam("searchWords", "");
         $searchWords = trim($searchWords);
         $initCurrentPage = $request->getParam("currentPage", 1);
         $currentPage = $this->intFilter->filter($initCurrentPage);

         $template_path = "askdoctor/search_asks.tpl";
         $md5URL = md5($_SERVER['REQUEST_URI']);

         //得到当前疾病名称所对应的所有问答数
         $askCount = $this->ask->getAskCountByTittle($searchWords);

         //分页相关的参数组装
         $pageSize = 7;
         $start = ($currentPage - 1) * $pageSize;
         $pageNum = ceil($askCount / $pageSize);

         //得到分页的问答信息集
         $userDifineWhere = array("where" => " AND title like ? ", "condition" => '%'. $searchWords .'%');
         $askAndAnswerArr = $this->ask->getAskAndAnswers(null, $start, $pageSize, $userDifineWhere);

         //得到分页 HTML
         $pageBaseURL = "/so/". urlencode($searchWords) ."/";
         $pageHTML = $this->getPageHTML($pageBaseURL, $currentPage, $pageNum);

         $this->view->assign("askCount", $askCount);
         $this->view->assign("askAndAnswerArr", $askAndAnswerArr);
         $this->view->assign("pageHTML", $pageHTML);
         $this->view->assign("searchWords", $searchWords);

         echo $this->view->render($template_path, $md5URL);
     }
 	
 	/**
 	 * 得到 ajax 分页的 HTML 字符串
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

     /**
      * 得到新疾病库的疾病信息
      * @author gaoqing
      * @date 2016-07-06
      * @param string $name 疾病名称
      * @param string $classidID 科室疾病id
      * @return void 空
      */
     private function getNewDiseaseInfo($name, $classidID)
     {
         $disease = $this->disease->getDiseaseByNewDB($name);

         //5、根据疾病的名称，查询相关的问答信息（）askAndAnswerArr
         $diseaseName = empty($disease) ? "" : $disease['title'];

         //得到当前疾病名称所对应的所有问答数
         $askCount = $this->ask->getAskCountByClassid($classidID);

         //查询 【前列腺炎】的广告位信息
         $qlx_ads = array();
         $qlx_child_arr = array('前列腺炎', '前列腺囊肿');
         if (in_array($diseaseName, $qlx_child_arr)) {
             $zxad = new App_Model_Zxads();
             $qlx_ads = $zxad->ads(270, 3);
         }

         $this->view->assign("qlx_ads", $qlx_ads);
         $this->view->assign("disease", $disease);
         $this->view->assign("askCount", $askCount);
         $this->view->assign("diseaseID", $classidID);
         $this->view->assign("diseaseName", $name);
     }


 }


?>