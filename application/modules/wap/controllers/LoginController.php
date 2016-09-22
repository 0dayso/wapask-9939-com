<?php

/**
 * 登录相关的控制器
 * @author gaoqing
 * 2015年9月28日
 */
class LoginController extends App_Controller_Action{
	
	/** HTML 过滤器 */
	private $htmlFilter = null;
	
	/** int 过滤器 */
	private $intFilter = null;
	
	/** 去除空格的过滤器 */
	private $stringTrimFilter = null;
	
	/** 会员实体类 */
	private $member = null;
	
	public  $_categoryurl_obj = null;
	
	/**
	 * 初始化方法
	 * @see Zend_Controller_Smarty::init()
	 */
	public function init() {
		parent::init();
		
		//初始化过滤器
		$this->htmlFilter = new Zend_Filter_HtmlEntities();
		$this->intFilter = new Zend_Filter_Int();
		$this->stringTrimFilter = new Zend_Filter_StringTrim();
		
		$this->member = new App_Model_Doctor();
		
		$this->_categoryurl_obj = new App_Model_Categoryurl();
	}

    public function forgetpwdAction(){
        echo $this->view->render('login/findpwd.tpl');
    }

    /**
     * 找回密码
     * @author gaoqing
     * @date 2016-07-04
     * @return string 视图
     */
    public function findpwdAction(){
        /*
         *  1、获取手机号码 $telephone
         *  2、随机生成一个六位密码 $newPwd
         *  3、将 $newPwd 保存到该用户名信息中，并以短信的形式，发送到用户手机中
         */

        $request = $this->getRequest();
        $initTelephone = $request->getParam('telephone', '');
        $initUserid = $request->getParam('userid', '0');
        $telephone = $this->htmlFilter->filter($initTelephone);
        $userid = $this->intFilter->filter($initUserid);

        $newPwd = rand(100000, 999999);

        $memeber = new App_Model_Doctor();
        $data = array('password' => md5($newPwd));
        $returnNum = $memeber->updateUserInfo($userid, $data);
        if ($returnNum > 0){
            //发送新密码到用户手机中
            $time = time();
            $data = $newPwd;
            $content = "您正在进行手机找回密码，密码是：". $newPwd ."，请继续登录！\n";
            $sendResult = App_Message_SMS_Client::send($telephone, $data, 0, 0, $content);
            if ($sendResult['flag'] == 0){
                return ;
            }
        }
        $this->_redirect("http://wapask.9939.com/login");
    }
	
	/**
	 * 临时方法，需要删除
	 * @author gaoqing
	 * 2015年11月9日
	 * @param 
	 * @return
	 */
	public function doctormatchAction() {
		
		$keshiName2IDArr = $this->member->doctorMatch();
		
		$dataStr = "";
		$dataStr = "<?php" . PHP_EOL;
		$dataStr .= "return " . PHP_EOL;
		$dataStr .= "array(" . PHP_EOL;
		
		$tempArr = array();
		foreach ($keshiName2IDArr as $key => $val){
			
			$departmentName = $val['doc_keshi'];
			$doctorID = $val['uid'];
			$doctorIDArr = array();
			
			if (isset($tempArr[$departmentName])) {
				$doctorIDArr = $tempArr[$departmentName];
			}
			$doctorIDArr[] = $doctorID;
			$tempArr[$departmentName] = $doctorIDArr;
		}
		
		foreach ($tempArr as $key => $newVal){
			
			$doctorIDStr = "array(";
			$doctorIDStr .= implode(",", $newVal);
			$doctorIDStr .= ")";
			
			$keshi = "'". $key ."' => ". $doctorIDStr .",";
			
			$dataStr .= $keshi . PHP_EOL;
		}
		
	/* 	
		foreach ($keshiName2IDArr as $key => $val){
			
			$keshi = "'". $val['doc_keshi'] ."' => ". $val['uid'] .",";
		
			$dataStr .= $keshi . PHP_EOL;
		} */
		
		$dataStr .= ");" . PHP_EOL;
		$dataStr .= "?>";
		
		//写入到文件中
		$filename = "/home/web/wapask-9939-com/public/KName2DocID.php";
		file_put_contents($filename, $dataStr);
	}
	
	public function serializeAction(){
		
		$categoryArr = array();
		
		$cate=Array(0=>'2791',1=>'1979',2=>'11470',3=>'2464',4=>'1808',5=>'1836',6=>'11411',7=>'11430',8=>'2711',9=>'2094',10=>'2280',11=>'1947',12=>'9687',13=>'2388',14=>'2711',15=>'11430',16=>'2388',17=>'2224',18=>'2266',19=>'9456',20=>'9552',21=>'10936',22=>'9782',23=>'11161',24=>'11135',25=>'10819',26=>'10797',27=>'11003',28=>'10249',29=>'9785',30=>'11037',31=>'10820',32=>'11091',33=>'9783',34=>'10976',35=>'9780',36=>'10896',37=>'10916',38=>'9788',39=>'11169',40=>'9789',41=>'9784',42=>'11066',43=>'10236',44=>'9776',45=>'9790',46=>'9787',47=>'11334',48=>'11277',49=>'9786',50=>'11364');
        foreach($cate as $k1 => $v1){
    	    $where=" catid=".$v1;
            $result=$this->_categoryurl_obj->getcategory($where);
            foreach($result as $k => $v){
            	
            	$domainArr = array();
            	preg_match('/http:\/\/([\s\S]*?).9939.com\/?/', $v['url'], $domainArr);
            	$domainName = "";
            	if (!empty($domainArr)) {
            		$domainName = $domainArr[1];
            	}
            	
            	
                $catidarry = array_filter(explode(',',$v['arrchildid']));
                $innerArr = array();
                foreach($catidarry as $key => $val){
                    if($val!=$v['catid']){
                        $wheres=" catid in (".$val.")";
                        $catidall=$this->_categoryurl_obj->getcategory($wheres);
                        
                        
                        foreach($catidall as $keys => $vals){
                            /* $catdirs[$v['catdir']][$key-1]['parentdir'] =$v['catdir'];s
                            $catdirs[$v['catdir']][$key-1]['catdir'] =$vals['catdir'];
                            $catdirs[$v['catdir']][$key-1]['catid'] =$vals['catid']; */
                            
                            
                            $matchArr = array();
                            preg_match("/http:\/\/([\s\S]*?).9939.com\/([\s\S]*?)\/?$/", $vals['url'], $matchArr);
                            	
                            $vals['parentdir_init'] = $vals['parentdir'];
                            $vals['catdir_init'] = $vals['catdir'];
                            	
                            if (!empty($matchArr)) {
                            	$vals['parentdir'] = $matchArr[1];
                            	$vals['catdir'] = $matchArr[2] . "/";
                            }
                            $innerArr[] = $vals;
                            
                        }
                    }
                }              
                  $categoryArr[$domainName] = $innerArr;
            }
        }
		
		
		
		
		
		
		
		
		
		
		//获取到栏目
		/* $channelArr = $obj->getAllChannel();
		
		$categoryArr = array();
		foreach ($channelArr as $channel){
			
			$matchArr = array();
			$url = $channel['url'];
			
			if (strstr($url, "http://")) {
				$domainArr = array();
				preg_match('/http:\/\/([\s\S]*?).9939.com\/?/', $url, $domainArr);
				$domainName = "";
				if (!empty($domainArr)) {
					$domainName = $domainArr[1];
				}
				
				//查询子栏目
				$childArr = $obj->getAllCategory($channel['arrchildid']);
				
				$innerArr = array();
				foreach ($childArr as $category){
					
					$matchArr = array();
					preg_match("/http:\/\/([\s\S]*?).9939.com\/([\s\S]*?)\/?$/", $category['url'], $matchArr);
					
					$category['parentdir_init'] = $category['parentdir'];
					$category['catdir_init'] = $category['catdir'];
					
					$catidStr = $category['catid'];
					
					if (!empty($matchArr)) {
						$category['parentdir'] = $matchArr[1];
						$category['catdir'] = $matchArr[2] . "/";
					}
					$innerArr[] = $category;
				}
				$categoryArr[$domainName] = $innerArr;
			}
		} */
		
		$serialize = serialize($categoryArr);
		file_put_contents("/home/web/m-9939-com/public" . "/category.txt", $serialize);
		
	}
	
	/**
	 * 注销方法
	 * @author gaoqing
	 * 2015年10月12日
	 * @param void 空
	 * @return void 空
	 */	
	public function logoutAction() {
		
		$request = $this->getRequest();
		$initUserid = $request->getParam("userid", 0);
		$userid = $this->intFilter->filter($initUserid);
		
		//清楚当前用户的 session ，并跳转到登录页面
		Zend_Session::start();
		$authNamespace = new Zend_Session_Namespace('userid'.$userid);
		$authNamespace->unsetAll();
		
		$this->_redirect("http://wapask.9939.com/login");
	}
	
	/**
	 * 注册页面
	 * @author gaoqing
	 * 2015年9月28日
	 * @param void 空
	 * @return void 空
	 */
	public function registerAction(){
		$request = $this->getRequest();
		
		//1、获取到用户注册的信息集
		$user = $this->getRegisterUserInfo($request);

        //2.2、如果不存在，则进行注册操作
        $userid = $this->member->addMember($user);

        //2.2.1、注册成功，跳转到【用户个人中心】
        if (!empty($userid)) {

            //设置用户 userid 到 session 中
            Zend_Session::start();
            $authNamespace = new Zend_Session_Namespace('userid'.$userid);
            $key = "userid".$userid;
            if (!isset($authNamespace->$key)) {
                $authNamespace->$key = $userid;
                $authNamespace->setExpirationSeconds(2*7*24*60*60);
            }

            $url = "http://wapask.9939.com/doctor/usercenter?userid=" . $userid;
            $this->_redirect($url);
        }else{
            echo("注册失败，请重试！");
            return ;
        }
	}

    public function serviceAction(){
        echo $this->view->render("login/service.tpl");
    }
	
	/**
	 * 得到用户注册的信息
	 * @author gaoqing
	 * 2015年9月28日
	 * @param Zend_Controller_Request_Abstract $request 请求对象  
	 * @return array 用户注册的信息
	 */
	public function getRegisterUserInfo($request){
		$user = array();
		
		$initUserName = $request->getParam("username", "");
		$initPassword = $request->getParam("password", "");
		$initTelephone = $request->getParam("telephone", "");

		$username = $this->htmlFilter->filter($initUserName);
		$password = $this->htmlFilter->filter($initPassword);
		$telephone = $this->htmlFilter->filter($initTelephone);

        //如果没有用户名，则随机分配一个新的用户名
        if (empty($username)){
            $aChars = range('a','z');
            shuffle($aChars);
            $sImpchars = implode('',$aChars);
            $user['username'] = substr($sImpchars,0,5);
            $user['nickname'] = $user['username'];
        }
        $user['mobile'] = $telephone;
        $user['checkmobile'] = 1;
        $user['is_binding_mobile'] = 1;

		$user['password'] = md5($password);
		$user['dateline'] = time();
		$user['uType'] = 1;
		$user['zdpassword'] = md5($password);
		$user['from'] = 'wap';

		return $user;
	}
	
	/**
	 * 跳转到注册页面
	 * @author gaoqing
	 * 2015年9月28日
	 * @param void 空
	 * @return void 空
	 */
	public function goregisterAction(){
		$this->view->assign("username", "");
		$this->view->assign("nickname", "");
		$this->view->assign("email", "");
		$this->view->assign("password", "");
		
		$md5URL = md5($_SERVER['REQUEST_URI']);
		echo $this->view->render("login/register.tpl", $md5URL);
	}

    public function isuserexistAction(){
        $request = $this->getRequest();

        $initUserName = $request->getParam("username", "");
        $initPassword = $request->getParam("password", "");

        $username = $this->stringTrimFilter->filter($initUserName);
        $password = $this->stringTrimFilter->filter($initPassword);

        //验证用户是否存在
        $userInfo = $this->member->userLogin($username, $password);
        if (isset($userInfo) && !empty($userInfo)) {
            $msg = array(
                'flag' => 1, //0: 失败；1：成功
                'msg' => '登录成功！',
                'userid' =>  $userInfo['uid']
            );
        } else {
            $msg = array(
                'flag' => 0, //0: 失败；1：成功
                'msg' => '登录信息有误！',
                'userid' => 0
            );
        }
        echo json_encode($msg);
    }
	
	/**
	 * 登录操作
	 * @author gaoqing
	 * 2015年9月28日
	 * @param void 空
	 * @return void 空
	 */
	public function loginAction(){
		$request = $this->getRequest();
		
		$initUserid = $request->getParam("userid", "0");
		$login = $request->getParam("login", 0);

		$userid = $this->stringTrimFilter->filter($initUserid);

		if (isset($userid) && !empty($userid)) {
			
			//设置用户 userid 到 session 中
			Zend_Session::start();
			$authNamespace = new Zend_Session_Namespace('userid'.$userid);
			$authNamespace->setExpirationSeconds(2*7*24*60*60);
			$key = "userid".$userid;
			if (!isset($authNamespace->$key)) {
				$authNamespace->$key = $userid;
				//$authNamespace->setExpirationSeconds(2*7*24*60*60);
			}
			
			//2.1、如果存在登录的用户，则跳转到【用户个人中心】
			//$url = "http://wapask.9939.com/doctor/usercenter?userid=" . $userid . "&login=" . $login;
            $url =  "http://wapask.9939.com/doctor/usercenter?userid=" . $userid;
			$this->_redirect($url);
		} else {
            $msg = array(
                'flag' => 0, //0: 失败；1：成功
                'msg' => '登录信息有误！',
            );
            echo json_encode($msg);
        }
	}
	
	/**
	 * 跳转到登录页面
	 * @author gaoqing
	 * 2015年9月28日
	 * @param void 空
	 * @return void 空
	 */
	public function indexAction() {
        $request = $this->getRequest();
        $r = $request->getParam("r", "0");
        $this->view->assign("r", $r);
        $md5URL = md5($_SERVER['REQUEST_URI']);
		echo $this->view->render("login/login.tpl", $md5URL);
	}
	
}

?>