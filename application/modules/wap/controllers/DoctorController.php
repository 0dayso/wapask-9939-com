<?php
/**
 * @version 0.0.0.1
 */
 

/**
 * 医生相关的 控制器类
 * @author gaoqing
 * 2015-09-02
 */
 class DoctorController extends App_Controller_Action{
 	
 	/** 医生实体类 */
 	private $doctor = null;
 	
 	/** 会员日志实体类 */
 	private $memberBlog = null;
 	
 	/** 问题实体类 */
 	private $ask = null;
 	
 	/** 回复实体类 */
 	private $answer = null;
 	
 	/** HTML 的过滤器 */
 	private $htmlFilter = null;
 	
 	/** 整数 的过滤器 */
 	private $intFilter = null; 	
 	
 	/** 会员好友实体类 */
 	private $memberfriend = null; 	
 	
 	/** 会员的详细信息实体类 */
 	private $memberdetail = null;
 	
 	/**
 	 * 初始化方法
 	 * @see Zend_Controller_Smarty::init()
 	 */
 	public function init() {
 		parent::init();
 		
 		$this->doctor = new App_Model_Doctor();
 		$this->htmlFilter = new Zend_Filter_HtmlEntities();
 		$this->intFilter = new Zend_Filter_Int();
 		$this->memberBlog = new App_Model_Memberblog();
 		$this->ask = new App_Model_Ask();
 		$this->answer = new App_Model_Answer();
 		$this->memberfriend = new App_Model_Memberfriend();
 		$this->memberdetail = new App_Model_Memberdetail();
 	}

     public function bindusertelAction(){
         $request = $this->getRequest();

         $initUserid = $request->getParam('userid', 0);
         $initTelephone = $request->getParam('telephone', '');
         $userid = $this->intFilter->filter($initUserid);
         $telephone = $this->htmlFilter->filter($initTelephone);

         $datas = array("mobile" => $telephone, "checkmobile" => 1, 'is_binding_mobile' => 1);
         $updateRowNum = $this->doctor->updateUserInfo($userid, $datas);

        if ($updateRowNum > 0){
            $this->_redirect("http://wapask.9939.com/doctor/usercenter?userid=" . $userid);
        }
     }

     public function bindtelAction(){
         $request = $this->getRequest();
         $renderTPL = "doctor/bindtel.tpl";

         $initUserid = $request->getParam('userid', 0);
         $userid = $this->intFilter->filter($initUserid);

         //查询当前用户，是否已经绑定手机
         $telephone = 0;
         $is_binding_mobile = 0;
         if (!empty($userid)){
             $user = $this->doctor->checkUserExist($userid);
            if (isset($user) && !empty($user)){
                $telephone = $user['mobile'];
                $is_binding_mobile = $user['is_binding_mobile'];
            }
         }

         $this->view->assign("telephone", $telephone);
         $this->view->assign("userid", $userid);
         $this->view->assign("is_binding_mobile", $is_binding_mobile);

         $md5URL = md5($_SERVER['REQUEST_URI']);
         echo $this->view->render($renderTPL, $md5URL);
     }

 	/**
 	 * 发送验证码
 	 * @author gaoqing
 	 * 2015年10月9日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function sendAction() {
 		$request = $this->getRequest();
 		
 		$initDst = $request->getParam("dst", 0);
 		$dst = $this->htmlFilter->filter($initDst);
 		
 		//发送验证码
 		$time = time();
 		$data = $this->randCode();
 		$sendResult = App_Message_SMS_Client::send($dst, $data);
 		
 		//返回发送后的执行结果
 		$result = json_encode(
 				array(
 						//'checknum' => $data,
 						'checknummd5' => md5($data),
 						'time' => $time,
 						'result' => $sendResult,
 				)
 			);
 		echo $result;
 	}
 	
 	/**
 	 * 随机码
 	 * @param void
 	 * @return string
 	 */
 	private function randCode()
 	{
 		$vcode = '';
 		$char = "0,1,2,3,4,5,6,7,8,9";//验证码出现的字符
 		$list = explode(",",$char);
 		for ($i=0;$i<6;$i++) {
 			$randnum = rand(0,count($list)-1);
 			$vcode .= $list[$randnum];
 		}
 		return $vcode;
 	}
 	
 	/**
 	 * 修改用户的密码
 	 * @author gaoqing
 	 * 2015年10月8日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function updatepasswdAction(){
 		$request = $this->getRequest();
 		
 		/*
 		 * 1、获取用户要修改的密码信息，并通过原始密码验证密码是否正确
 		 * 	1.1、如果原始密码正确，则进行更新 新密码 的操作
 		 * 	1.2、如果原始密码错误，直接返回当前修改的页面
 		 * 2、密码修改成功后，则直接跳转到登录界面，进行重新登录
 		 */
 		$renderTPL = "doctor/updatepasswd.tpl";
 		
 		//1、获取用户要修改的密码信息，并通过原始密码验证密码是否正确
 		$initUserPasswd = array();
 		$userPasswd = $this->getUserPasswd($request);
 		$initUserPasswd = $userPasswd;
 		
 		//1.1、如果原始密码正确，则进行更新 新密码 的操作
 		$userid = $userPasswd['uid'];
 		$oldPasswd = md5($userPasswd['oldpasswd']);
 		$userInfo = $this->doctor->checkUserExist($userid, null, $oldPasswd);
 		
 		//密码正确
 		if ($userInfo != null) {
 		
 			//2、密码修改成功后，则直接跳转到登录界面，进行重新登录
 			unset($userPasswd['uid']);
 			unset($userPasswd['oldpasswd']);
 			$userPasswd['password'] = md5($userPasswd['password']);
 			
 			$intRow = $this->doctor->updateUserInfo($userid, $userPasswd);
 			if ($intRow > 0) {
 				//跳转到登录界面
 				$url = "http://wapask.9939.com/doctor/usercenter?userid=" . $userid;
 				$this->_redirect($url);
 			}
 		}
 		
 		//密码不对，不能修改
 		$this->view->assign("userid", $userid);
 		
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		echo $this->view->render($renderTPL, $md5URL);
 	}
 	
 	/**
 	 * 用户系统消息的详细信息
 	 * @author gaoqing
 	 * 2015年10月8日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function detailmsgAction() {
 		$request = $this->getRequest();
 		
 		$template_path = "doctor/detailmsg.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		$initId = $request->getParam("id", 0);
 		$id = $this->intFilter->filter($initId);
 		
 		$msg = $this->doctor->getMsg($id);
 		$this->view->assign("msg", $msg);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 跳转到用户的系统消息的界面
 	 * @author gaoqing
 	 * 2015年10月8日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function gousermsgAction() {
 		$request = $this->getRequest();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$userid = $this->intFilter->filter($initUserid);
 		
 		//判断用户是否登录，如果未登录，则跳转到登录界面
 		Zend_Session::start();
 		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
 		$key = "userid".$userid;
 		if (isset($authNamespace->$key)) {
	 		$usermsg = $this->doctor->getUserMsg($userid);
	 		$this->view->assign("usermsg", $usermsg);
	 		$renderTPL = "doctor/usermsg.tpl";
	 		$md5URL = md5($_SERVER['REQUEST_URI']);
	 		echo $this->view->render($renderTPL, $md5URL);
 		}else{
 			$this->_redirect("http://wapask.9939.com/login");
 		}
 	}
 	
 	/**
 	 * 跳转到更改密码的界面
 	 * @author gaoqing
 	 * 2015年10月8日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function goupdatepdAction() {
 		$request = $this->getRequest();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$userid = $this->intFilter->filter($initUserid);
 		
 		//判断用户是否登录，如果未登录，则跳转到登录界面
 		Zend_Session::start();
 		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
 		$key = "userid".$userid;
 		if (isset($authNamespace->$key)) {
 			$this->view->assign("userid", $userid);
 			$renderTPL = "doctor/updatepasswd.tpl";
	 		$md5URL = md5($_SERVER['REQUEST_URI']);
	 		echo $this->view->render($renderTPL, $md5URL);
 		}else {
 			$this->_redirect("http://wapask.9939.com/login");
 		}
 	}
 	
 	/**
 	 * 得到用户更改密码信息
 	 * @author gaoqing
 	 * 2015年10月8日
 	 * @param Zend_Controller_Request_Abstract $request request对象
 	 * @return array 密码信息
 	 */
 	private function getUserPasswd($request) {
 		$userPasswd = array();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$oldPasswd = $request->getParam("oldpasswd", "");
 		$passwd = $request->getParam("newpasswd", "");
 		
 		$userPasswd['uid'] = $this->intFilter->filter($initUserid);
 		$userPasswd['oldpasswd'] = $this->htmlFilter->filter($oldPasswd);
 		$userPasswd['password'] = $this->htmlFilter->filter($passwd);
 		
 		return $userPasswd;
 	}
 	
 	/**
 	 * 更新用户的详细信息
 	 * @author gaoqing
 	 * 2015年9月29日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function updateuserdetailAction(){
 		$request = $this->getRequest();
 		
 		/*
 		 * 1、获取更新的用户信息
 		 * 2、先更新用户的详细信息
 		 * 	2.1、如果当前更新成功，则更新用户的基本信息（昵称）
 		 * 		2.1.1、如果更新用户的基本信息成功，则跳转到【个人中心中】
 		 * 		2.1.2、如果更新用户的基本信息失败，则跳到当前更新用户的详细页面中
 		 * 	2.2、如果当前更新失败，则跳转到更新用户的详细页面中
 		 */
 		$renderTPL = "doctor/userdetail.tpl";
 		
 		//1、获取更新的用户信息
 		$userDetail = $this->getUserDetail($request);
 		$initUserDetail = $userDetail;
 		
 		$user = array('nickname' => $userDetail['nickname'], 'username' => $userDetail['nickname']);
 		$uid = $userDetail['uid'];
 		
 		unset($userDetail['nickname']);
 		unset($userDetail['uid']);
 		
 		//2、先更新用户的详细信息
 		$updateMemberDetail = $this->memberdetail->updateUserDetail($uid, $userDetail);
 		if (!empty($updateMemberDetail)) {
 			//2.1、如果当前更新成功，则更新用户的基本信息（昵称）
 			$updateUser = $this->doctor->updateUserInfo($uid, $user);
 			if (!empty($updateUser)) {
 				echo $uid;
 			}
 		}
 		/*$initUserDetail['pic'] = $request->getParam("pic", "");
 		$initUserDetail['username'] = $request->getParam("username", "");
 		$this->view->assign("userDetail", $initUserDetail);
 		$this->view->assign("error", "保存失败，请重试！");
 		
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		echo $this->view->render($renderTPL, $md5URL);*/
 	}
 	
 	/**
 	 * 得到更新用户的详细信息
 	 * @author gaoqing
 	 * 2015年9月29日
 	 * @param Zend_Controller_Request_Abstract $request 请求对象
 	 * @return array 要更新的用户详细信息
 	 */
 	private function getUserDetail($request) {
 		$userDetail = array();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$initGender = $request->getParam("gender", 1);
 		$initHight = $request->getParam("hight", 0);
 		$initNickname = $request->getParam("nickname", "");
 		$initWeight = $request->getParam("weight", 0);
 		$initBirthday = $request->getParam("birthday", "");
 		$initBlood = $request->getParam("blood", 0);
 		$initMarriage = $request->getParam("marriage", 1);
 		
 		$userDetail['uid'] = $this->intFilter->filter($initUserid);
 		$userDetail['gender'] = $this->intFilter->filter($initGender);
 		$userDetail['hight'] = $this->intFilter->filter($initHight);
 		$userDetail['nickname'] = $this->htmlFilter->filter($initNickname);
 		$userDetail['weight'] = $this->intFilter->filter($initWeight);
 		$userDetail['birthday'] = $this->htmlFilter->filter($initBirthday);
 		$userDetail['blood'] = $this->intFilter->filter($initBlood);
 		$userDetail['marriage'] = $this->intFilter->filter($initMarriage);
 		
 		return $userDetail;
 	}
 	
 	/**
 	 * 用户详细信息
 	 * @author gaoqing
 	 * 2015年9月29日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function userdetailAction(){
 		$request = $this->getRequest();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$userid = $this->intFilter->filter($initUserid);
 		
 		//判断用户是否登录，如果未登录，则跳转到登录界面
 		Zend_Session::start();
 		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
 		$key = "userid".$userid;
 		if (isset($authNamespace->$key)) {
 			//获取当前用户的详细信息
 			$userDetail = $this->doctor->getUserDetail($userid);
 				
 			$this->view->assign("userDetail", $userDetail);
 			$renderTPL = "doctor/userdetail.tpl";
	 		$md5URL = md5($_SERVER['REQUEST_URI']).uniqid();
	 		
	 		echo $this->view->render($renderTPL, $md5URL);
 		}else {
 			$this->_redirect("http://wapask.9939.com/login");
 		} 		
 		
 	}
 	
 	/**
 	 * 会员中心
 	 * @author gaoqing
 	 * 2015年9月29日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function usercenterAction(){
 		/*
 		 * 1、用户基本信息
 		 */
 		$request = $this->getRequest();
 		
 		$initUserid = $request->getParam("userid", 0);
 		$login = $request->getParam("login", 0);
 		
 		$userid = $this->intFilter->filter($initUserid);
 		
 		//判断用户是否登录，如果未登录，则跳转到登录界面
 		Zend_Session::start();
 		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
 		$key = "userid".$userid;
 		if (isset($authNamespace->$key)) {
 			
            $userid= $authNamespace->$key;
            
            if(empty($userid)){
                $this->_redirect("http://wapask.9939.com/login?r=" . time());
                exit;
            }
 			//如果登录了，则进行用户的信息验证
	 		$user = $this->doctor->getUser($userid);
	 		//判断是否存在用户
	 		if (isset($user) && !empty($user)) {
		 		$this->view->assign("user", $user);
		 		$this->view->assign("login", 1);
		 		$renderTPL = "doctor/usercenter.tpl";
		 		$md5URL = md5($_SERVER['REQUEST_URI']).  time();
		 		echo $this->view->render($renderTPL, $md5URL);
	 		}else {
                $this->_redirect("http://wapask.9939.com/login?r=" . time());
	 		}
 		}else{
            $this->_redirect("http://wapask.9939.com/login?r=" . time());
 		}
 	}
 	
 	
 	/**
 	 * 更多医生
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function moredoctorAction() {
 		$request = $this->getRequest();
 		
 		$template_path = 'askdoctor/moredoctor.tpl';
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 			
 		$from_flag  = $request->getParam("from", 1); //1:keshi 2:area
 		
 		//1、全部科室
 		//$allDepartmentDoctorArr = $this->getAllDepartmentDoctors($from_flag, $request);
        $allDepartmentDoctorArr = array();
        $allDepartmentDoctorArr['doctor'] = array(
            array(
                'pic' => 'http://home.9939.com//upload/pic/201504/200343_avatar_middle.jpg',
                'truename' => '宋元宗',
                'zhicheng' => '副主任医师 ',
                'best_dis' => '小儿内分泌疾病',
                'uid' => '200343',
            ),
            array(
                'pic' => 'http://home.9939.com//upload/pic/201504/200348_avatar_middle.jpg',
                'truename' => '曾艺东',
                'zhicheng' => '主任医师',
                'best_dis' => '婴幼儿综合',
                'uid' => '200348',
            ),
            array(
                'pic' => 'http://home.9939.com//upload/pic/201504/823486_avatar_middle.jpg',
                'truename' => '刘巧平',
                'zhicheng' => '医师',
                'best_dis' => '外科检查、外科伤口处理 ',
                'uid' => '823486',
            ),
            array(
                'pic' => 'http://home.9939.com//upload/pic/201411/830735_avatar_middle.jpg',
                'truename' => '陈水鸥',
                'zhicheng' => '医师',
                'best_dis' => '中医针灸 ',
                'uid' => '830735',
            ),
            array(
                'pic' => 'http://home.9939.com//upload/pic/200911/200357_avatar_middle.jpg',
                'truename' => '宋健美',
                'zhicheng' => '医师',
                'best_dis' => '泌尿系统综合，肾脏常见病',
                'uid' => '200357',
            ),
        );

 		//2、全部地区
 		//$allAreaDoctorArr = $this->getAreaDoctors($from_flag, $request);
 		
 		$this->view->assign("allDepartmentDoctorArr", $allDepartmentDoctorArr);
 		//$this->view->assign("allAreaDoctorArr", $allAreaDoctorArr);
 			
 		echo $this->view->render($template_path, $md5URL);
 	} 	
 	
 	/**
 	 * 更多医生（区域）
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function moredoctorareaAction() {
 		$request = $this->getRequest();
 		
 		$template_path = 'askdoctor/moredoctorArea.tpl';
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 			
 		$from_flag  = $request->getParam("from", 2); //1:keshi 2:area
		 		
 		//2、全部地区
 		$allAreaDoctorArr = $this->getAreaDoctors($from_flag, $request);
 		
 		$this->view->assign("allAreaDoctorArr", $allAreaDoctorArr);
 			
 		echo $this->view->render($template_path, $md5URL);
 	} 	
 	
 	
 	/**
 	 * 查看更多医生的分页方法
 	 * @author gaoqing
 	 * 2015年9月8日
 	 * @param void 空 
 	 * @return void 空
 	 */
 	public function showmoredoctorpageAction(){
 		
 		$template_path = 'askdoctor/doctor.tpl';
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		$request = $this->getRequest();
 		
 		$from_flag  = $request->getParam("from", 1); //1:keshi 2:area
 		$return_data = array();
 		
 		switch ($from_flag){
 			case 1:{
 				$return_data = $this->getAllDepartmentDoctors($from_flag, $request);
 				break;
 			}
 			case 2:{
 				$return_data = $this->getAreaDoctors($from_flag, $request);
 				break;
 			}
 		}
 		
 		$this->view->assign("from", $from_flag);
 		$this->view->assign("doctor", $return_data);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 得到所有科室的医生
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param int $from 从哪个页签中来（1:keshi 2:area）
 	 * @param Zend_Controller_Request_Abstract $request request对象
 	 * @return array 所有科室的医生及分页HTML
 	 */
 	private function getAllDepartmentDoctors($from, $request) {
 		$allDepartmentDoctorArr = array();
 		
 		//1、得到所有科室的所有医生数
 		$allDepartmentDoctorsCount = $this->doctor->getAllDepartmentDoctorsCount();

 		$initCurrentPage = $request->getParam("currentPage", 1);
 		$currentPage = $this->intFilter->filter($initCurrentPage);
 			
 		$pageSize = 5;
 		$start = ($currentPage - 1) * $pageSize;
 		$pageNum = ceil($allDepartmentDoctorsCount/$pageSize);
 		
 		//2、得到分页的医生信息
 		$allDepartmentDoctors = $this->doctor->getAllDepartmentDoctors($start, $pageSize);
 		
 		//3、得到分页的 HTML
 		$pageHTML = $this->getAjaxPageHTML($from, "/doctor/showmoredoctorpage?from=" . $from. "&currentPage=", $currentPage, $pageNum);
 		
 		$allDepartmentDoctorArr['doctor'] = $allDepartmentDoctors;
 		$allDepartmentDoctorArr['html'] = $pageHTML;
 		
 		return $allDepartmentDoctorArr;
 	}
 	
 	/**
 	 * 得到所有地区的医生
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param int $from 从哪个页签中来（1:keshi 2:area）
 	 * @param Zend_Controller_Request_Abstract $request request对象
 	 * @return array 所有地区的医生及分页HTML
 	 */
 	private function getAreaDoctors($from, $request) {
 		$allAreaDoctorArr = array();
 		
 		//1、得到所有科室的所有医生数
 		$allAreaDoctorsCount = $this->doctor->getAllAreaDoctorsCount();
		
 		$initCurrentPage = $request->getParam("currentPage", 1);
 		$currentPage = $this->intFilter->filter($initCurrentPage);
 			
 		$pageSize = 5;
 		$start = ($currentPage - 1) * $pageSize;
 		$pageNum = ceil($allAreaDoctorsCount/$pageSize);
 		
 		//2、得到分页的医生信息
 		$allAreaDoctors = $this->doctor->getAllAreaDoctors($start, $pageSize);
 		
 		//3、得到分页的 HTML
 		$pageHTML = $this->getAjaxPageHTML($from, "/doctor/showmoredoctorpage?from=" . $from. "&currentPage=", $currentPage, $pageNum);
 		
 		$allAreaDoctorArr['doctor'] = $allAreaDoctors;
 		$allAreaDoctorArr['html'] = $pageHTML;
 		
 		return $allAreaDoctorArr;
 	}
 	
 	/**
 	 * 医生简介信息
 	 * @author gaoqing
 	 * 2015年9月6日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function doctorabstractAction(){
 		
 		$template_path = "doctor/abstract.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		$request = $this->getRequest();
 		$initUid = $request->getParam("doctorid", 0);
 		$uid = $this->intFilter->filter($initUid);
 		
 		//1、获取医生的信息及擅长信息
 		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid, true);
 			
 		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
 			
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 医生擅长信息
 	 * @author gaoqing
 	 * 2015年9月6日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function doctorgoodatAction(){
 		
 		$template_path = "doctor/goodAt.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		$request = $this->getRequest();
 		$initUid = $request->getParam("doctorid", 0);
 		$uid = $this->intFilter->filter($initUid);
 		
 		//获取医生的信息及擅长信息
 		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid, true);
 		
 		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 默认的 action 方法
 	 * @author gaoqing
 	 * 2015年9月2日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function indexAction() {
 		
 		$template_path = "doctor/doctor.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		/*
 		 * 医生主页信息: 
 		 * 	（1）医生基本信息 $doctorBasicInfo
 		 * 	（1）医生的所有日志数 $doctorLogNum
 		 * 	（1）医生基本信息 $doctorBasicInfo
 		 */
 		
 		$request = $this->getRequest();
 		
 		$initUID = $request->getParam("uid", 0);
 		$uid = $this->intFilter->filter($initUID);
 		
 		//得到医生的基本信息
 		$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($uid);
 		
 		//得到医生的好友（也是医生）
 		$doctorFriendsCount = $this->memberfriend->getDoctorFriendsCount($uid);
 		if (!empty($doctorFriendsCount)) {
 			$doctorBasicInfo['friendnum'] = $doctorFriendsCount;
 		}
 		
 		//得到医生的日志数
  		$doctorLogNum = $this->memberBlog->getMemberBlogCount($uid);
 		
 		$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
 		$this->view->assign("doctorLogNum", $doctorLogNum);
 		$this->view->assign("doctorid", $uid);
 		
 		echo $this->view->render($template_path, $md5URL);
 	}
 	
 	/**
 	 * 医生详情页中的分页部分（ajax 方式）
 	 * @author gaoqing
 	 * 2015年9月9日
 	 * @param void 空
 	 * @return void 空
 	 */
 	public function detaildoctorpageAction() {
 		
 		$template_path = "doctor/doctorPage.tpl";
 		$md5URL = md5($_SERVER['REQUEST_URI']);
 		$this->display($template_path, $md5URL);
 		
 		$request = $this->getRequest();
 			
 		$initUID = $request->getParam("uid", 0);
 		$initCurrentPage = $request->getParam("currentPage", 1);
 		$uid = $this->intFilter->filter($initUID);
 		$currentPage = $this->intFilter->filter($initCurrentPage);
 			
 		//分页信息组装
 		$doctorAnswerAskCount = $this->answer->getDoctorAllAnswerCount($uid);
 		$currentPage = empty($currentPage) ? 1 : $currentPage;
 		$pageSize = 6;
 		$start = ($currentPage - 1) * $pageSize;
 		$pageNum = ceil($doctorAnswerAskCount/$pageSize);
 			
 		//得到医生所有回答
 		$doctorAnswerAsk = $this->answer->getDoctorAnswerAsk($uid, $start, $pageSize);
 			
 		//得到分页的 HTML
 		$pageHTML = $this->getCommonAjaxPageHTML("fatherHTMLID", "/doctor/detaildoctorpage/uid/" . $uid . "/currentPage/", $currentPage, $pageNum);
 		
 		$this->view->assign("doctorAnswerAskCount", $doctorAnswerAskCount);
 		$this->view->assign("doctorAnswerAsk", $doctorAnswerAsk);
 		$this->view->assign("pageHTML", $pageHTML);
 		
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
 	 * 得到 ajax 分页的 HTML 字符串
 	 * @author gaoqing
 	 * 2015年9月06日
 	 * @param string $pageBaseURL 分页的基路径
 	 * @param int $currentPage 当前页
 	 * @param int $pageNum 总的记录数
 	 * @return string 疾病分页的 HTML 字符串
 	 */
 	private function getAjaxPageHTML($from, $pageBaseURL, $currentPage, $pageNum) {
 	
 		//上一页
 		$preCurrentPage = $currentPage == 1 ? 1 : ($currentPage - 1);
 		$prePage = '<a href="javascript:" id = "prePage'. $from .'"  >上一页</a>';
 	
 		//下一页
 		$nextCurrentPage = $currentPage == $pageNum ? $pageNum :  ($currentPage + 1);
 		$nextPage = '<a href="javascript:" id = "nextPage'. $from .'"  >下一页</a>';
 	
 		if ($pageNum == 0) {
 			$currentPage = 0;
 		}
 		$pageHTML =
 		$prePage .
 		'<span>' . $currentPage . '/' . $pageNum . '</span>'.
 		$nextPage;
 		
 		if ($pageNum != 0) {
	 		//添加 ajax js 部分
	 		$idStr = "n3Tab33ContentDep";
	 		if ($from == 2) { 
	 			$idStr = "n3Tab33ContentArea";
	 		}
	 		$pageHTML .= '<script type="text/javascript" > ';
	 		
	 		if ($currentPage != 1) {
		 		$pageHTML .= ' $("#prePage'.$from.'").click(function(){    $.ajax({url: "'. $pageBaseURL .  $preCurrentPage .'", cache: false, success: function(html){$("#'. $idStr .'").html(html);}  });    });  ' ;
	 		}
	 		if ($currentPage != $pageNum){
	 			$pageHTML .= ' $("#nextPage'.$from.'").click(function(){    $.ajax({url: "'. $pageBaseURL . $nextCurrentPage .'", cache: false, success: function(html){$("#'. $idStr .'").html(html);}  });    });  ' ;
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