<?php

/**
 * 久久问医模块的 controller 
 * @author gaoqing
 * 2015-08-26
 */
 class AskdoctorController extends App_Controller_Action{
 	
 	/** 医生的 model 类 */
 	private $doctor = null;
 	
 	/** 问答 model 类 */
 	private $ask = null;
 	
 	/** 疾病的 model 类 */
 	private $disease = null;
 	
 	/**
 	 * 初始化方法
 	 * @see Zend_Db_Table_Abstract::init()
 	 * @author gaoqing
 	 * 2015-08-26
 	 */
 	public function init(){
 		parent::init();
 		$this->initView();
 		
 		$this->doctor = new App_Model_Doctor();
 		$this->disease = new App_Model_Disease();
 		$this->ask = new App_Model_Ask();
 	}
 	
 	/**
 	 * 久久问医部分的入口方法 
 	 * @author gaoqing
 	 * 2015年8月26日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function indexAction() {
 		
 		//1、得到医生的简单信息
 		//$doctorSimpleInfoArr = $this->doctor->getDoctorSimpleInfos(4);
 		//$this->view->assign("doctorSimpleInfoArr", $doctorSimpleInfoArr);
 		
 		$template_path = "askdoctor/askdoctor.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		//2、【常见疾病】部分 的数据
 		$commonDiseaseIDMap = array(
 				array(464 => "咳嗽", 78 => "感冒", 341 => "白癜风", 44 => "甲亢"),
 				array(195 => "月经不调", 219 => "流产", 285 => "鼻炎", 149 => "肛肠疾病")
 		);
 		$start = 0;
 		$pageSize = 6;
 		$commonDiseaseArr = $this->getCommonDiseases($commonDiseaseIDMap, $start, $pageSize);

 		//3、根据 2 中，常见疾病的名称，得到疾病所对应的 id (9939_dzjb)
 		//$diseaseIDMap = $this->getDiseaseIDMapByName($commonDiseaseIDMap);
 			
 		$this->view->assign("commonDiseaseArr", $commonDiseaseArr);
 		$this->view->assign("commonDiseaseIDMap", $commonDiseaseIDMap);

 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 常见疾病的方法
 	 * @author gaoqing
 	 * 2015年9月10日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function commondiseaseAction() {
 		
 		$template_path = "askdoctor/commonDisease.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		//2、【常见疾病】部分 的数据
 		$commonDiseaseIDMap = array(
 				array(464 => "咳嗽", 78 => "感冒", 341 => "白癜风", 44 => "甲亢"),
 				array(195 => "月经不调", 219 => "流产", 285 => "鼻炎", 149 => "肛肠疾病")
 		);
 		$start = 0;
 		$pageSize = 6;
 		$commonDiseaseArr = $this->getCommonDiseases($commonDiseaseIDMap, $start, $pageSize);
 		
 		//3、根据 2 中，常见疾病的名称，得到疾病所对应的 id (9939_dzjb)
 		$diseaseIDMap = $this->getDiseaseIDMapByName($commonDiseaseIDMap); 	
 		
 		$this->view->assign("commonDiseaseArr", $commonDiseaseArr);
 		$this->view->assign("commonDiseaseIDMap", $commonDiseaseIDMap);
 		$this->view->assign("diseaseIDMap", $diseaseIDMap);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 得到疾病的 classid 对应的 9939_dzjb 表中的 id 集
 	 * @author gaoqing
 	 * 2015年9月8日
 	 * @param array $commonDiseaseIDMap 常见疾病的 ID 集
 	 * @return array 疾病的 classid 对应的 9939_dzjb 表中的 id 集
 	 */
 	public function getDiseaseIDMapByName($commonDiseaseIDMap) {
 		$diseaseIDMap = array();
 		
 		foreach ($commonDiseaseIDMap as $commonDiseaseID => $diseaseName){
 			foreach ($diseaseName as $diseaseKey => $diseaseVal){
 				$diseaseIDMap[$diseaseKey] = $this->disease->getDiseaseIDByName($diseaseVal);
 			}
 		}
 		return $diseaseIDMap;
 	}
 	
 	/**
 	 * 得到常见疾病的信息集
 	 * @author gaoqing
 	 * 2015年9月8日
 	 * @param array $commonDiseaseIDMap 常见疾病的 ID 集
 	 * @param int $start 分页的开始位置
 	 * @param int $pageSize 每页显示数
 	 * @return array 常见疾病的信息集
 	 */
 	public function getCommonDiseases($commonDiseaseIDMap, $start, $pageSize){
 		$commonDiseaseArr = array();
 		
 		/*
 		 * 1、根据疾病的 id ，查询出相应的疾病信息集
 		 * 2、将对应的 id ，分组存放到数组中
 		 */	

 		foreach ($commonDiseaseIDMap as $key => $commonDiseaseIDArr){
 			$innerTempArr = array();
 			
	 		//1、根据疾病的 id ，查询出相应的疾病信息集
 			foreach ($commonDiseaseIDArr as $classID => $commonDiseaseName){
 				$tempArr = $this->ask->getCommonDiseases($classID, $start, $pageSize);
 				$innerTempArr[] = array("classid" => $classID, "data" => $tempArr);
 			}
	 		//2、将对应的 id ，分组存放到数组中
 			$commonDiseaseArr[] = $innerTempArr;
 		}
 		return $commonDiseaseArr;
 	}
 	

 	

 	
 	
 	
 	
 	
 }


?>