<?php

/**
 * 医生的实体类
 * @author gaoqing
 * 2015-08-26
 */
class App_Model_Doctor extends App_BaseTable{
	
	//设置当前 model 的默认值
	protected $_name = null;
	protected $_primary = null;
	protected $_db = null;
	
	/** 表名称 */
	private $table_name = "member";
	
	/** 数据库连接对象 */
	private $conntion = null;
	
	protected function _setup(){
		$this->_name = "member";
		$this->_primary = "uid";
		$this->_db = $GLOBALS['dbwd'];
		
		parent::_setup();
	}
	
	public function init() {
		parent::init();
		$this->conntion = $GLOBALS['dbwd'];
	}
	
	/**
	 * 临时方法：需要删除
	 * @author gaoqing
	 * 2015年11月9日
	 * @param 
	 * @return
	 */
	public function doctorMatch(){
		$keshiName2IDArr = array();
		
		$sql = $this->getSQL(true, " uid ", " AND doc_from = ? ", null, null, null);
		$statement = $this->_db->prepare($sql);
		$statement->execute(array(1));
		
		$memberArr = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$uidArr = array();
		foreach ($memberArr as $val){
			$uidArr[] = $val['uid'];
		}
		
		$where = implode(",", $uidArr);
		$sql = $this->getSQL(true, " uid , doc_keshi", " AND uid in ( ". $where ." ) ", null, null, null, "member_detail_2");
		$statementOne = $this->_db->prepare($sql);
		$statementOne->execute();
		$keshiName2IDArr = $statementOne->fetchAll(PDO::FETCH_ASSOC);
		
		return $keshiName2IDArr;
	}
	
	/**
	 * 得到用户系统消息的详细信息
	 * @author gaoqing
	 * 2015年10月8日
	 * @param int $id 消息id
	 * @return array 系统消息
	 */
	public function getMsg($id) {
		$msg = array();
		
		$sql = $this->getSQL(true, " id, uid, note, dateline ", " AND uid = ? ", null, null, null, "member_notification");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($id));
		
		$msg = $statement->fetch(PDO::FETCH_ASSOC);
		
		return $msg;
	}
	
	/**
	 * 得到用户的系统消息
	 * @author gaoqing
	 * 2015年10月8日
	 * @param int $userid 用户的id
	 * @return array 用户的系统消息
	 */
	public function getUserMsg($userid) {
		$userMsg = array();
		
		$sql = $this->getSQL(true, " id, uid, note, dateline ", " AND uid = ? ", null, null, " ORDER BY id DESC ", "member_notification");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($userid));
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			
			$temp['note'] = $this->cutString($temp['note'], 24, 1);
			$temp['dateline'] = date('Y-m-d H:i', $temp['dateline']);
			
			$userMsg[] = $temp;
		}
		return $userMsg;
	}
	
	/**
	 * 得到用户的详细信息
	 * @author gaoqing
	 * 2015年9月29日
	 * @param int $userid 用户的 id 
	 * @return array 用户的详细信息
	 */
	public function getUserDetail($userid){
		$userInfo = array();

        $user = $this->getUser($userid);
        if (!empty($user)){
            $sql = " SELECT md.telephone, md.gender, md.hight, md.weight, md.birthday, md.blood, md.marriage FROM member_detail_1 md WHERE md.uid = ? ";
            $statement = $this->_db->prepare($sql);
            $statement->execute(array($userid));
            $userDetail = $statement->fetch(PDO::FETCH_ASSOC);

            if (empty($userDetail)) {
                $userDetail['telephone'] = "";
                $userDetail['gender'] = 1;
                $userDetail['hight'] = 0;
                $userDetail['weight'] = 0;
                $userDetail['birthday'] = "";
                $userDetail['blood'] = 0;
                $userDetail['marriage'] = 1;
            }
            $userInfo = array_merge($user, $userDetail);
        }
        return $userInfo;
	}
	
	/**
	 * 得到用户信息
	 * @author gaoqing
	 * 2015年9月29日
	 * @param int $userid 用户 id
	 * @return array 用户信息
	 */
	public function getUser($userid){
		$user = array();
		
		$sql = $this->getSQL(true, "uid, uType, nickname, username, email, pic, wappic, groupname, mobile", " AND uid = ? ");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($userid));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if(isset($user) && !empty($user)){
			if (isset($user['pic']) && !empty($user['pic'])) {
				$user['pic'] = "http://home.9939.com/upload/pic/". $user['pic'];
			}else {
				$user['pic'] = "http://home.9939.com/upload/pic//default.jpg";
			}
			if (!isset($user['groupname']) || empty($user['groupname'])) {
				$user['groupname'] = "一级";
			}
			$user['random'] = rand(0, 10000000);
		}
		return $user;
	}
	
	/**
	 * 用户登录方法
	 * @author gaoqing
	 * 2015年9月28日
	 * @param string $username 用户名（邮箱、手机号）
	 * @param string $password 密码
	 * @return array 用户的信息
	 */
	public function userLogin($username, $password){
		$userInfo = array();
		
		/*
		 * 1、首先根据 $username 的值，判断当前登录是用，用户名或邮箱或手机号，并组织成查询的 SQL 语句
		 * 2、根据组织后的查询语句，查询出当前登录用户的信息
		 */
		
		if (isset($username) && !empty($username)) {
			//1、首先根据 $username 的值，判断当前登录是用，用户名或邮箱或手机号，并组织成查询的 SQL 语句
			$conditionStr = "";
			$conditionArr = array();
			
			if (preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $username)) {
				$conditionStr .= " AND email = ? ";
				$conditionArr[] = $username;
			}elseif (preg_match('/^1[0-9]{10}$/', $username)){
				$conditionStr .= " AND mobile = ? ";
				$conditionArr[] = $username;
			}else {
				$conditionStr .= " AND username = ? ";
				$conditionArr[] = $username;
			}
//			$conditionStr .= " AND password = ? ";
//			$conditionArr[] = md5($password);
			
			$sql = " SELECT uid, uType, nickname, username, email, password FROM member where 1 = 1 " . $conditionStr ;
			$statement = $this->_db->prepare($sql);
			$statement->execute($conditionArr);
			$userInfo = $statement->fetch(PDO::FETCH_ASSOC);
            if($userInfo['password']!=md5($password)){
                return array();
            }
		}
		return $userInfo;
	}
	
	/**
	 * 根据用户的id, name, password ，验证用户是否存在
	 * @author gaoqing
	 * 2015年9月14日
	 * @param int $userid 用户的 id
	 * @param string $userName 用户名
	 * @param string $password 用户密码
	 * @param boolean $isByUserName 是否是通过用户名来判断（默认是 false）
	 * @return object 用户的信息
	 */
	public function checkUserExist($userid = 0, $userName = "", $password = "", $isByUserName = false) {
		$userInfo = null;
		$where = "";
		
		//通过用户名判断
		if ($isByUserName) {
			$where = $this->_db->quoteInto(" username = ? ", $userName);
		}else {
			$where = $this->_db->quoteInto(" uid = ? ", $userid);
			
			if (isset($userName) && !empty($userName)) {
				$where .= $this->_db->quoteInto(" AND username = ? ", $userName);
			}
			if (isset($password) && !empty($password)) {
				$where .= $this->_db->quoteInto(" AND password = ? ", $password) ;
			}
		}
		$userInfo = $this->fetchRow($where);
		return $userInfo;
	}
	
	/**
	 * 修改用户的信息
	 * @author gaoqing
	 * 2015年9月10日
	 * @param int $uid 要修改的用户 id
	 * @param array $data 要修改的信息
	 * @return int 修改后成功的行数
	 */
	public function updateUserInfo($uid, $data) {
		$updateRowNum = 0;
	
		$where = $this->_db->quoteInto("uid = ?", $uid);
		$updateRowNum = $this->update($data, $where);
		$updateRowNum = 1;
	
		return $updateRowNum;
	}

	/**
	 * 得到所有科室的医生分页信息 
	 * @author gaoqing
	 * 2015年9月7日
	 * @param int $start 分页的开始位置
	 * @param int $pageSize 分页时每页显示数
	 * @return array 所有科室的医生分页信息 
	 */
	public function getAllDepartmentDoctors($start, $pageSize) {
		$doctorBasicInfoArr = array();
		
		$sql = " SELECT m.uid, m.nickname, m.credit, m.friendnum, m.pic, m.groupname, ".
				" md2.truename, md2.zhicheng, md2.doc_hos, md2.doc_keshi, md2.memo, md2.best_dis, md2.description ".
				" FROM member m, member_detail_2 md2 ".
				" where m.uid = md2.uid and m.status = 1 and m.uType = 2 and md2.doc_keshi != '' ".
				" ORDER BY m.credit DESC, m.experience DESC LIMIT  " . $start . ", " . $pageSize;
		
		$statement = $this->conntion->prepare($sql);
		$statement->execute();
		
		while ($doctorBasicInfo = $statement->fetch(PDO::FETCH_ASSOC)) {
			$doctorBasicInfo['pic'] = "http://home.9939.com/upload/pic". $doctorBasicInfo['pic'];
				
			$doctorBasicInfo['best_dis'] = $this->cutString($doctorBasicInfo['best_dis'], 11, 1);
			$doctorBasicInfo['truename'] = empty($doctorBasicInfo['truename']) ? $doctorBasicInfo['nickname'] : $doctorBasicInfo['truename'];
				
			$doctorBasicInfoArr[] = $doctorBasicInfo;
		}
		return $doctorBasicInfoArr;		
	}
	
	/**
	 * 得到所有地区的医生分页信息 
	 * @author gaoqing
	 * 2015年9月7日
	 * @param int $start 分页的开始位置
	 * @param int $pageSize 分页时每页显示数
	 * @return array 所有科室的医生分页信息 
	 */
	public function getAllAreaDoctors($start, $pageSize) {
		$doctorBasicInfoArr = array();
		
		$sql = " SELECT m.uid, m.nickname, m.credit, m.friendnum, m.pic, m.groupname, ".
				" md2.truename, md2.zhicheng, md2.doc_hos, md2.doc_keshi, md2.memo, md2.best_dis, md2.description ".
				" FROM member m, member_detail_2 md2 ".
				" where m.uid = md2.uid and m.status = 1 and m.uType = 2 and md2.address != '' ".
				" ORDER BY m.viewnum, m.experience DESC, m.credit DESC LIMIT  " . $start . ", " . $pageSize;
		
		$statement = $this->conntion->prepare($sql);
		$statement->execute();
		
		while ($doctorBasicInfo = $statement->fetch(PDO::FETCH_ASSOC)) {
			$doctorBasicInfo['pic'] = "http://home.9939.com/upload/pic". $doctorBasicInfo['pic'];
				
			$doctorBasicInfo['best_dis'] = $this->cutString($doctorBasicInfo['best_dis'], 11, 1);
			$doctorBasicInfo['truename'] = empty($doctorBasicInfo['truename']) ? $doctorBasicInfo['nickname'] : $doctorBasicInfo['truename'];
				
			$doctorBasicInfoArr[] = $doctorBasicInfo;
		}
		return $doctorBasicInfoArr;		
	}
	
	/**
	 * 得到所有地区的医生数 
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	public function getAllAreaDoctorsCount() {
		$allAreaDoctorsCount = 0;
		
		$sql = $this->getSQL(true, " count(*) ", ' AND address != "" ', null, null, null, "member_detail_2");
		$statement = $this->conntion->prepare($sql);
		$statement->execute();
		$temp = $statement->fetch(PDO::FETCH_NUM);
		
		if (!empty($temp)) {
			$allAreaDoctorsCount = $temp[0];
		}
		return $allAreaDoctorsCount;
	}
	
	/**
	 * 得到所有科室的医生数 
	 * @author gaoqing
	 * 2015年9月7日
	 * @param void 空
	 * @return void 空
	 */
	public function getAllDepartmentDoctorsCount() {
		$allDepartmentDoctorsCount = 0;
		
		$sql = $this->getSQL(true, " count(*) ", ' AND doc_keshi != "" ', null, null, null, "member_detail_2");
		$statement = $this->conntion->prepare($sql);
		$statement->execute();
		$temp = $statement->fetch(PDO::FETCH_NUM);
		
		if (!empty($temp)) {
			$allDepartmentDoctorsCount = $temp[0];
		}
		return $allDepartmentDoctorsCount;
	}
	
	/**
	 * 添加会员
	 * @author gaoqing
	 * 2015年9月7日
	 * @param array $user 会员信息
	 * @return int 会员 ID
	 */
	public function addMember($user) {
		$userID = 0;
		if (!empty($user)) {
			$userID = $this->insert($user);
		}
		return $userID;
	}
	
	/**
	 * 根据医生的 id, 得到当前医生的基本信息
	 * @author gaoqing
	 * 2015年9月2日
	 * @param int $uid 医生的 id
	 * @param boolean $isComplete 是否是需要完整信息 （擅长、简介 完整输出）默认不是完整信息
	 * @return array 当前医生的基本信息
	 */
	public function getDoctorBasicInfoByid($uid, $isComplete = false) {
		$doctorBasicInfoArr = array();
		
		$sql = " SELECT m.uid, m.nickname, m.credit, m.friendnum, m.pic, m.groupname, ". 
			   " md2.truename, md2.zhicheng, md2.doc_hos, md2.doc_keshi, md2.memo, md2.best_dis, md2.description ".
			   " FROM member m, member_detail_2 md2 ".
			   " where m.uid = md2.uid and m.status = 1 and m.uType = 2 and m.uid = ?   ";
		
		$statement = $this->conntion->prepare($sql);
		$statement->execute(array($uid));
		
		while ($doctorBasicInfo = $statement->fetch(PDO::FETCH_ASSOC)) {
			$doctorBasicInfo['pic'] = "http://home.9939.com/upload/pic/". $doctorBasicInfo['pic'];
			$doctorBasicInfo['memo'] = empty($doctorBasicInfo['memo']) ? $doctorBasicInfo['description'] : $doctorBasicInfo['memo'];
			
			//显示简短信息
			if (!$isComplete) {
				$blank = "&nbsp;";
				for ($i = 0; $i < 30; $i++){
					$blank .= "&nbsp;";
				}
				if (!empty($doctorBasicInfo['best_dis']) && mb_strlen($doctorBasicInfo['best_dis'], 'utf-8') < 15) {
					$doctorBasicInfo['best_dis'] = $doctorBasicInfo['best_dis'] . $blank;
				}else{
					$doctorBasicInfo['best_dis'] = $this->cutString($doctorBasicInfo['best_dis'], 73, 1);
				}
				if (!empty($doctorBasicInfo['memo']) && mb_strlen($doctorBasicInfo['memo'], 'utf-8') < 15) {
					$doctorBasicInfo['memo'] = $doctorBasicInfo['memo'] . $blank;
				}else{
					$doctorBasicInfo['memo'] = $this->cutString($doctorBasicInfo['memo'], 55, 1);
				}
			}
			$doctorBasicInfo['truename'] = empty($doctorBasicInfo['truename']) ? $doctorBasicInfo['nickname'] : $doctorBasicInfo['truename'];
			
			$doctorBasicInfoArr = $doctorBasicInfo;
		}
		//处理为空的情况
		if (empty($doctorBasicInfoArr)) {
			$doctorBasicInfoArr['uid'] = 0;
			$doctorBasicInfoArr['nickname'] = "";
			$doctorBasicInfoArr['credit'] = 0;
			$doctorBasicInfoArr['friendnum'] = 0;
			$doctorBasicInfoArr['pic'] = "";
			$doctorBasicInfoArr['groupname'] = "";
			$doctorBasicInfoArr['truename'] = "";
			$doctorBasicInfoArr['zhicheng'] = "";
			$doctorBasicInfoArr['doc_hos'] = "";
			$doctorBasicInfoArr['doc_keshi'] = "";
			$doctorBasicInfoArr['memo'] = "";
			$doctorBasicInfoArr['best_dis'] = "";
			$doctorBasicInfoArr['description'] = "";
		}
		return $doctorBasicInfoArr;
	}
	
	/**
	 * 得到医生的详细信息
	 * @author gaoqing
	 * 2015年9月6日
	 * @param int $uid 医生的 id
	 * @return array 医生的简短详细信息
	 */
	public function getDoctorDetail($uid) {
		$simpleDoctorDetail = array();
		
		$sql = $this->getSQL(true, " md2.truename, md2.zhicheng, md2.doc_hos, md2.doc_keshi, md2.memo, md2.best_dis, md2.description ", "", 0, 1, null);
		$statement = $this->conntion->prepare($sql);
		$statement->execute(array($uid));
		$simpleDoctorDetail = $statement->fetch(PDO::FETCH_ASSOC);
		
		return $simpleDoctorDetail;
	}
	
	/**
	 * 得到指定数量医生的简单信息 
	 * @author gaoqing
	 * 2015年8月26日
	 * @param int $num 要获取医生的数量
	 * @param mixed $other 其他条件
	 * @return array 指定数量医生的简单信息集
	 */
	public function getDoctorSimpleInfos($num) {
		$doctorSimpleInfoArr = array();
		
		$sql = " SELECT m.uid, m.nickname, m.pic, md2.zhicheng FROM member m, member_detail_2 md2 where m.uid = md2.uid and m.status = 1 and m.uType = 2 order by m.experience DESC limit 0, " . $num;
		$statement = $this->conntion->prepare($sql);
		$statement->execute();
		
		while ($doctorSimpleInfo = $statement->fetch(PDO::FETCH_ASSOC)) {
			$doctorSimpleInfo['pic'] = "http://home.9939.com/upload/pic" . $doctorSimpleInfo['pic'];
			
			$doctorSimpleInfoArr[] = $doctorSimpleInfo;
		}
		return $doctorSimpleInfoArr;
	}
	
	/**
	 * 得到查询的 SQL 语句
	 * @author gaoqing
	 * 2015年8月31日
	 * @param boolean $isSimple 是否使用最简单的条件
	 * 						      （当为 true 时，如果 $start、$limitLen、$order 都为 null 时，则不使用默认的值，直接不添加相应的条件）
	 * @param string $selectField 要查询的字段
	 * @param string $where 查询条件
	 * @param int $start 查询条数限制的 开始 位置值
	 * @param int $limitLen limit 中的限制长度值
	 * @param string $order 排序规则
	 * @param string $dbName 表名称
	 * @return string 查询医生的 SQL 语句
	 */
	private function getSQL(
				$isSimple = true, 
				$selectField = null, 
				$where = null, 
				$start = null,
				$limitLen = null, 
				$order = null,
				$dbName = "member") 
	{
		$sql = "";
	
		//查询字段
		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
	
		//查询条件
		$baseWhere = ($dbName == "member" ? " WHERE status = 1  " : " WHERE 1 = 1 ");
		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
		
		$defaultOrderStr = " ";
		if (!$isSimple) {
			$defaultOrderStr = " ORDER BY uid ";
		}
		//排序条件
		$orderStr = empty($order) ? $defaultOrderStr : $order ;
	
		//查询条数限制
		$limitStr = "";
		if (!empty($limitLen)) {
			$startNum = empty($start) ? 0 : $start;
			$limitStr = " LIMIT " . $startNum ." , " . $limitLen;
		}
		$sql = " SELECT ". $selectFieldStr ." FROM " . $dbName . $whereStr . $orderStr . $limitStr;
		return $sql;
	}	
	
	
	
	
}


?>