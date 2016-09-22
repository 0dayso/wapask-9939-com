<?php
/**
**潘红晶 
* 日期 2015年5月
**/
class AskController extends App_Controller_Action{
    var $_ask_obj                       = null;
    
    /** 医生实体类 */
    private $doctor = null;
    
    /** HTML 的过滤器 */
    private $htmlFilter = null;
    
    /** 整数 的过滤器 */
    private $intFilter = null;    
    
    /** 整理字符串 */
    private $stringTrim = null;
    
    function init(){
		parent::init();
		$this->initView();

        $this->_ask_obj             = new App_Model_Ask();
        
        $this->htmlFilter = new Zend_Filter_HtmlEntities();
        $this->intFilter = new Zend_Filter_Int();
        $this->stringTrim = new Zend_Filter_StringTrim();
        $this->doctor = new App_Model_Doctor();        
	}
	
	/**
	 * 用户问答详情页
	 * @author gaoqing
	 * 2015年9月10日
	 * @param void 空
	 * @return void 空
	 */
	public function useraskdetailAction() {
		$request = $this->getRequest();
		
		$template_path = "Ask/userAskDetail.tpl";
		$md5URL = md5(uniqid());
		
		$initUserid = $request->getParam("userid", 0);
		$initAskid = $request->getParam("askid", 0);
		
		$userid = $this->intFilter->filter($initUserid);
		$askid = $this->intFilter->filter($initAskid);
		
		//1、根据问题 id ，查询出问题的信息
		$askInfo = $this->_ask_obj->getAskInfo($askid, true);
		
		//2、根据问题 id，查询出所有回答（回答信息中，包括回答信息、回答医生信息）
		$bestAnswerID = empty($askInfo['bestanswer']) ? 0 : $askInfo['bestanswer'];
		$answerInfo = $this->_ask_obj->getAskDoctorAnswer($askid, $bestAnswerID);
		
		$this->view->assign("userid", $userid);
		$this->view->assign("askid", $askid);
		$this->view->assign("askInfo", $askInfo);
		$this->view->assign("answerInfo", $answerInfo);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 验证用户是否存在
	 * @author gaoqing
	 * 2015年9月10日
	 * @param void 空
	 * @return void 空
	 */
	public function checkuserexistAction() {
		$request = $this->getRequest();
		
		$initUsername = $request->getParam("username", "");
		$username = $this->htmlFilter->filter($initUsername);
		
		//用户存在标识（1：存在；0：不存在）
		$userExistFlag = "0";
		$user = $this->_ask_obj->getUserByName($username);
		if (!empty($user)) {
			$userExistFlag = "1";
		}
		$result = array('flag' => $userExistFlag);
		echo json_encode($result);
	}
	
	/**
	 * 更改用户名及密码的方法
	 * @author gaoqing
	 * 2015年9月10日
	 * @param void 空
	 * @return void 空
	 */
	public function updateuserAction() {
		$request = $this->getRequest();
		
		//1、得到用户名 、密码
		$initUserid = $request->getParam("userid", 0);
		$initUserName = $request->getParam("username", "");
		$initPassword = $request->getParam("password", "");

		$userid = $this->intFilter->filter($initUserid);
		$username = $this->htmlFilter->filter($initUserName);
		$password = $this->htmlFilter->filter($initPassword);

        //2、根据用户的 id ，修改该用户的 用户名、密码
        $updateRowNum = $this->doctor->updateUserInfo($userid, array("username" => $username, "nickname" => $username, "password" => md5($password)));

        echo $updateRowNum;
	}

	/**
	 * 绑定手机号码
	 * @author gaoqing
	 * 2016年6月22日
	 * @return void 空
	 */
	public function updateusertelAction() {
		$request = $this->getRequest();

		$initUserid = $request->getParam("userid", 0);
		$initTelephone = $request->getParam("telephone", "");
        $initPassword = $request->getParam('password', '0');

		$userid = $this->intFilter->filter($initUserid);
		$telephone = $this->htmlFilter->filter($initTelephone);
        $password = $this->htmlFilter->filter($initPassword);
        $password = trim($password);

        $datas = array("mobile" => $telephone, "checkmobile" => 1, 'is_binding_mobile' => 1);
        if ($password != '0' && !empty($password)){
            $datas['password'] = md5($password);
        }

        $updateRowNum = $this->doctor->updateUserInfo($userid, $datas);

        echo $updateRowNum;
	}

    /**
     * 检查当前用户是否已经绑定该 号码 了
     * @author gaoqing
     * @date 2016-06-22
     * @return int 是否存在标识(1：存在；0：不存在)
     */
    public function checktelexistAction(){
        $isTelExist = 0;
        $request = $this->getRequest();

        $userid = $request->getParam("userid", "0");
        $telephone = $request->getParam('telephone', 0);

        $user = $this->_ask_obj->getUserByTel($userid, $telephone);
        if (!empty($user)){
            $isTelExist = $user[0]['uid'];
        }
        echo $isTelExist;
    }
	
	/**
	 * 用户问答列表
	 * @author gaoqing
	 * 2015年9月16日
	 * @param void 空
	 * @return void 空
	 */
	public function userasklistAction(){
		$request = $this->getRequest();
		$userAskArr = array();
		$initUserid = $request->getParam("userid", 0);
		$userid = $this->intFilter->filter($initUserid);
		
		//判断用户是否登录，如果未登录，则跳转到登录界面
		Zend_Session::start();
		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
		$key = "userid".$userid;
		if (isset($authNamespace->$key)) {
			if (!empty($userid)) {
				$userAskArr = $this->_ask_obj->getAllAskByUserid($userid);
			}
			$this->view->assign("userAskArr", $userAskArr);
			$this->view->assign("userid", $userid);
			
			$md5URL = md5(uniqid());
			echo $this->view->render("Ask/userAsk.tpl", $md5URL);
		}else {
			$this->_redirect("http://wapask.9939.com/login");
		}		
	}
	
	/**
	 * 问答详情
	 * @author gaoqing
	 * 2015年9月8日
	 * @param void 空
	 * @return void 空
	 */
	public function askdetailAction() {
		$request = $this->getRequest();
		
		$template_path = "Ask/askAnswerDetail.tpl";
		$md5URL = md5($_SERVER['REQUEST_URI']);
		$this->display($template_path, $md5URL);		
		
		$initAskID = $request->getParam("askid", 0);
		$initClassID = $request->getParam("classid", 0);
		$askID = $this->intFilter->filter($initAskID);
		$classid = $this->intFilter->filter($initClassID);
		
		//1、获取当前问题的具体信息
		$askInfo = $this->_ask_obj->getAskInfo($askID);
		
		//2、获取当前问题的所有医生回答信息
		$askDoctorAnswer = $this->_ask_obj->getAskDoctorAnswer($askID);
		
		if (!empty($askInfo) && empty($classid)) {
			$classid = $askInfo['classid'];
		}
		//3、相关问题信息
		$relateAskInfoArr = $this->_ask_obj->getRelateAskInfoArr($askID, $classid, 0, 6);

        //查询 【前列腺炎】的广告位信息
        $qlx_ads = array();
        $qlx_child_arr = array('前列腺科', '前列腺炎', '前列腺囊肿');
        $zxad = new App_Model_Zxads();
        if (in_array($askInfo['classname'], $qlx_child_arr)){
            $qlx_ads = $zxad->ads(270, 3);
        }
        $ads_hotpic = $zxad->getAdsHandle(4527, 6);
        $this->view->assign("ads_hotpic", $ads_hotpic);
        $this->view->assign("qlx_ads", $qlx_ads);
        $this->view->assign("askInfo", $askInfo);
		$this->view->assign("askDoctorAnswer", $askDoctorAnswer);
		$this->view->assign("relateAskInfoArr", $relateAskInfoArr);
		
		echo $this->view->render($template_path, $md5URL);
	}
	
	/**
	 * 向医生提问
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	public function askdoctorAction(){
		$request = $this->getRequest();

        $content = $request->getParam('content', '');
        $content = trim($content);
        if (empty($content)){
            $this->_redirect('http://wapask.9939.com/ask/goAskDoctor');
            return ;
        }

        $classid = 15;

		/*
		 * 1、判断当前用户是否之前已经登录过
		 * 	1.1、如果未登录：
		 * 		1.1.1、生成一个随机用户，更新到数据库中
		 * 		1.1.2、得到当前新生成的用户的 id, 并将当前问题与当前用户进行关联
		 * 		1.1.3、更新当前提问的问题到数据库中，并跳转到 更新随机用户的用户信息中
		 * 	1.2、如果已登录：
		 * 		1.2.1、验证当前传递的用户信息，是否正确，如果不正确，则分配一个随机用户
		 * 		1.2.2、得到当前登录的用户 id,将提问的问题与用户 id 进行关联，更新到数据库中
		 * 		1.2.3、根据当前用户的 id ，得到当前用户下，所有的问题
		 * 		1.2.4、直接跳转到当前用户的问题列表中
		 */
		$md5URL = "";
		$initUserid = $request->getParam("userid", 0);

		$userid = $this->intFilter->filter($initUserid);

		//1、判断当前用户是否之前已经登录过
		if (empty($userid)) {
			//1.1、如果未登录：
            $classid = $this->userNotExistHandle($request);
		}else {
		
			//判断用户是否登录，如果未登录，则跳转到登录界面
			Zend_Session::start();
			$authNamespace = new Zend_Session_Namespace('userid'.$userid);
			$key = "userid".$userid;
			if (isset($authNamespace->$key)) {
				//1.2、如果已登录：
				
				//1.2.1、验证当前传递的用户信息，是否正确，如果不正确，则分配一个随机用户
				$userInfo = $this->doctor->checkUserExist($userid, null, null);
				
				//用户信息正确：
				if (!empty($userInfo)) {
					$flag = 0;

					//1.2.2、得到当前登录的用户 id,将提问的问题与用户 id 进行关联，更新到数据库中
					$askArr = $this->getAskArr($request, $userid);
                    $classid = $askArr['classid'];
					$askID = $this->_ask_obj->askDoctor($askArr);
                    if ($askID > 0){
                        $flag = 1;
                    }
                    $datas = array(
                        'flag' => $flag,
                        'isLogin' => 1,
                        'classid' => $classid,
                        'userid' => $userid,
                        'classid' => $classid,
                    );
                    echo json_encode($datas);

				//用户信息不正确：	
				}else {
                    $classid = $this->userNotExistHandle($request);
				}
			}
			//未登录：
			else {
                $classid = $this->userNotExistHandle($request);
			}
		}
	}
	
	/**
	 * 用户不存在时的操作
	 * @author gaoqing
	 * 2015年9月14日
	 * @param Zend_Controller_Request_Abstract $request request对象
	 * @return void 空
	 */
	 private function userNotExistHandle($request) {
		$classid = 15;
         $flag = 0;

		//1、随机生成用户
		$randUser = $this->randExecuteUser();
		//未加密前的密码
		$initPassword = $randUser['initpassword'];
		unset($randUser['initpassword']);

		//插入到 member 表中
		$randUserID = $this->doctor->addMember($randUser);
		
		//2、得到提交的数据
		$askArr = $this->getAskArr($request, $randUserID);
         $classid = $askArr['classid'];

		//3、更新到数据库中
		$askID = $this->_ask_obj->askDoctor($askArr);
         if ($askID > 0){
             $flag = 1;
         }
		
 		//设置用户 userid 到 session 中
		Zend_Session::start();
		$authNamespace = new Zend_Session_Namespace('userid'.$randUserID);
		$key = "userid".$randUserID;
		if (!isset($authNamespace->$key)) {
			$authNamespace->$key = $randUserID;
			$authNamespace->setExpirationSeconds(2*7*24*60*60);
		}
         $datas = array(
             'userid' => $randUserID,
             'username' => $randUser['username'],
             'md5password' => md5($initPassword),
             'password' => $initPassword,
             'isLogin' => 0,
             'flag' => $flag,
             'classid' => $classid,
         );
         echo json_encode($datas);
	}

    public function successAction(){
        $renderTPL = "Ask/updateUserInfo.tpl";
        $md5URL = md5(rand(0, 1000000));

        $request = $this->getRequest();
        $classid_str = $request->getParam("classid", "");
        if (!empty($classid_str)){
            $classid_arr = explode('-', $classid_str);
            $classid = $classid_arr[0];
            $userid = $classid_arr[1];
            $md5URL = md5($userid);

            //获取当前科室下的最新 5 条有回答的问答
            $relAsks = $this->_ask_obj->getList('classid = ' . $classid . ' AND answernum > 0', 'id DESC', 5);
            $this->view->assign("relAsks", $relAsks);
            $this->view->assign("classid", $classid);
            $this->view->assign("userid", $userid);
        }
        echo $this->view->render($renderTPL, $md5URL);
    }

	
	/**
	 * 匿名用户的话，随机生成用户信息
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	private function randExecuteUser(){
		$randUser = array();
		
		//随机生成用户名和密码
		$aChars = range('a','z');
		shuffle($aChars);
		$sImpchars = implode('',$aChars);
		$username = substr($sImpchars,0,5);
		$pwd = rand(100000, 999999);
		
		//设置用户信息
		$randUser['username'] = $username;
		$randUser['initpassword'] = $pwd;
		$randUser['password'] = md5($pwd);
		$randUser['dateline'] = time();
		$randUser['nickname'] = $username;
		$randUser['uType'] = 1;
		$randUser['zdpassword'] = md5($pwd);	
		$randUser['from'] = 'wap';
		
		return $randUser;
	}
	
	/**
	 * 得到提交的问题信息
	 * @author gaoqing
	 * 2015年9月7日
	 * @param Zend_Controller_Request_Abstract $request request 对象
	 * @param int $randUserID 随机生成的用户 ID
	 * @return array 提交的问题信息
	 */
    private function getAskArr($request, $randUserID) {
		$askArr = array();
		
		$initContent = $request->getParam("content", "");
		$initSex = $request->getParam("sex", '未知');
        $initTelephone = $request->getParam('telephone', '');
        $initDoctorID = $request->getParam("doctorID", 0);

        $askArr['content'] = $this->htmlFilter->filter($initContent);
        $askArr['ctime'] = time();
        $askArr['sexnn'] = ($initSex == '男') ? 1 : ($initSex == '女' ? 2 : 0);
        $askArr['mobile'] = $initTelephone;

        //处理年龄及年龄单位：
        $ageUnitArr = array('岁' => 0, '月' => 1, '天' => 2);
        $initAge = $request->getParam("age", '0-岁');
        $ageArr = explode('-', $initAge);
        $askArr['age'] = $ageArr[0];
        $askArr['age_unit'] = $ageUnitArr[$ageArr[1]];

        if ($initDoctorID != 0){
            $askArr['answerUid'] = $initDoctorID;
        }

        //通过分诊，得到当前提问的 title 及 相应的科室信息
        $askArr = $this->getTriageDatas($askArr);

        //设置默认的值
        $askArr['isReal'] = 1;
		
		//来自 wap 站
		$askArr['source'] = 2;
		
		//分配默认的用户
		$askArr['userid'] = empty($randUserID) ? 0 : $randUserID;

		return $askArr;
	}

    /**
     * 得到分诊后的相关（title, classid, class_level1, ...）信息
     * @author gaoqing
     * @date 2016-06-17
     * @param array $askParams 提问信息集
     * @return array 绑定分诊信息后的提问数据集
     */
    private function getTriageDatas($askParams){
        $bindDepInfoParams = $askParams;

        $content = $askParams['content'];
        if (!empty($content)){
            //标题长度
            $titleLen = 20;

            //1、标题为，$content 前 15 个字
            $bindDepInfoParams['title'] = mb_substr($content, 0, $titleLen, 'utf-8');

            //2、获取科室相关信息
            $departmentInfo = $this->_ask_obj->triage($content);
            if (isset($departmentInfo) && !empty($departmentInfo)){
                $classid = $departmentInfo['class_level1'];
                for ($i = 3; $i > 0; $i--){
                    if (!empty($departmentInfo['class_level' . $i])){
                        $classid = $departmentInfo['class_level' . $i];
                        break;
                    }
                }
                $bindDepInfoParams['classid'] = $classid;
                $bindDepInfoParams['class_level1'] = $departmentInfo['class_level1'];
                $bindDepInfoParams['class_level2'] = $departmentInfo['class_level2'];
                $bindDepInfoParams['class_level3'] = isset($departmentInfo['class_level3']) ? $departmentInfo['class_level3'] : 0;
            }
        }
        return $bindDepInfoParams;
    }

    /**
     * 得到验证码信息
     * @author gaoqing
     * @date 2016-06-20
     * @return void 空
     */
    public function getchkAction(){
        $validateCode = new App_Model_ValidateCode(56, 25, 4);

        //生成验证码
        echo $validateCode->showImg();
    }

    /**
     * 验证 验证码是否输入正确
     * @author gaoqing
     * @date 2016-06-20
     * @return boolean 是否验证成功（0：失败；1：成功）
     */
    public function checknumAction(){
        session_start();
        $isCheckSuccess = 0;

        $request = $this->getRequest();
        $chknum = $request->getParam('chknum', "");
        $chknum = strtolower($chknum);

        if (isset($_SESSION['check_num']) && $chknum == $_SESSION['check_num']){
            $isCheckSuccess = 1;
        }
        echo $isCheckSuccess;
    }

	
	/**
	 * 向医生提问的跳转页方法
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	public function goaskdoctorAction(){
		$request = $this->getRequest();
		
		$initDoctorID = $request->getParam("doctorID");
		
		$doctorID = $this->intFilter->filter($initDoctorID);
		
		$renderTpl = "Ask/askDoctor.tpl";

		//向医生提问部分
		if (isset($initDoctorID) && !empty($initDoctorID)) {
			
			//1、获取医生的疾病信息
			$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($doctorID, true);	
			$this->view->assign("doctorBasicInfo", $doctorBasicInfo);
			$this->view->assign("doctorID", $doctorID);
		}else {
			
			//我要提问部分
			$renderTpl = "Ask/singleAskPage.tpl";
		}
		
		$md5URL = md5($_SERVER['REQUEST_URI']);
		echo $this->view->render($renderTpl, $md5URL);
	}
	
	function showAction(){
        $id = intval($this->getParam("askid"));
        $where=" id=".$id;
        $result=$this->_ask_obj->Getask($where);
        $result[0]['ctime']=date("Y-m-d H:i:s", $result[0]['ctime']);
        $this->view->assign('result',$result[0]);
        $url=md5($_SERVER['REQUEST_URI']);
        echo $this->view->render('Ask/Ask_details.tpl',$url);
	}
	
}