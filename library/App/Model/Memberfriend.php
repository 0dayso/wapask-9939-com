<?php
/**
 * @version 0.0.0.1
 */
 
/**
 * 会员朋友 Model 类
 * @author gaoqing
 * 2015-09-07
 */
 class App_Model_Memberfriend extends App_BaseTable{
 	
 	/** 表名称 */
 	private $tableName = "member_friend";
 	
 	/** 数据库连接对象 */
 	private $connection = null;
 	
 	/**
 	 * 初始化方法
 	 * @see Zend_Db_Table_Abstract::init()
 	 */
 	public function init() {
 		parent::init();
 		
 		$this->connection = $GLOBALS['dbwd'];
 		
 		//假的：仅做测试用
 		//$this->connection = $this->getAdapter();
 	}
 	
 	/**
 	 * 得到医生好友的id
 	 * @author gaoqing
 	 * 2015年9月21日
 	 * @param int $uid 医生的 id 
 	 * @param int $start 分页的开始位置
 	 * @param int $pageSize 分页的每页显示数
 	 * @return array 医生好友的 ID 集
 	 */
 	public function getDoctorFriendIDs($uid, $tart, $pageSize) {
 		$doctorFriendIDArr = array();
 		
 		$sql = " SELECT fuid FROM member_friend WHERE status != 2 AND uid = ? LIMIT  " . $tart . ", " . $pageSize;
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($uid));
 		
 		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
 			$doctorFriendIDArr[] = $temp['fuid'];
 		}
 		return $doctorFriendIDArr;
 	}
 	
 	/**
 	 * 得到医生好友的信息（分页）
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param int $uid 医生的 id 
 	 * @param int $start 分页的开始位置
 	 * @param int $pageSize 分页的每页显示数
 	 * @return array 医生好友的信息
 	 */
 	public function getDoctorFriends($uid, $start, $pageSize) {
 		$doctorFriendArr = array();
 		
 		$doctorFriendIDStr = "";
 		$doctorFriendIDArr = $this->getDoctorFriendIDs($uid, $start, $pageSize);
 		if (!empty($doctorFriendIDArr)) {
 			$doctorFriendIDStr = implode(",", $doctorFriendIDArr);
 		}
 		
 		$sql = " SELECT uid, nickname, pic FROM member where uid in (". $doctorFriendIDStr .")  AND status = 1 ORDER BY pic ASC LIMIT " . 0 . ", " . $pageSize ;
 		
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($uid));
 		
 		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
 			$temp['pic'] = empty($temp['pic']) ? '/default.jpg' : $temp['pic'];
 			$temp['pic'] =  "http://home.9939.com/upload/pic/" . $temp['pic'];
 			if (preg_match('/[\s\,\。\-\=]+/', $temp['nickname'])) {
 				$arr = preg_split('/[\s\,\。\-\=]+/', $temp['nickname']);
 				$temp['nickname'] =  $arr[0];
 			}
 			$doctorFriendArr[] = $temp;
 		}
 		return $doctorFriendArr;
 	}
 	
 	/**
 	 * 得到医生好友的总数
 	 * @author gaoqing
 	 * 2015年9月7日
 	 * @param int $uid 医生的 id 
 	 * @return int 医生好友的总数
 	 */
 	public function getDoctorFriendsCount($uid) {
 		$doctorFriendsCount = 0;
 		
 		/* $innerSQL = " SELECT tem.fuid FROM (SELECT fuid FROM member_friend WHERE status != 2 AND uid = ? ) as tem ";
 		$sql = " SELECT count(*) FROM member where uid in (". $innerSQL .") AND  uType = 2 AND status = 1 "; 	 */
 		
 		$sql = " SELECT count(fuid) FROM member_friend WHERE status != 2 AND uid = ? ";
 		
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($uid));
 		$temp = $statement->fetch(PDO::FETCH_NUM);
 		
 		if (!empty($temp)) {
 			$doctorFriendsCount = $temp[0];
 		}
 		return $doctorFriendsCount;
 	}
 	
 	
 	
 	/**
 	 * 得到查询的 SQL 语句
 	 * @author gaoqing
 	 * 2015年9月02日
 	 * @param boolean $isSimple 是否使用最简单的条件
 	 * 						      （当为 true 时，如果 $start、$limitLen、$order 都为 null 时，则不使用默认的值，直接不添加相应的条件）
 	 * @param int $selectField 要查询的字段
 	 * @param int $where 查询条件
 	 * @param int $start 查询条数限制的 开始 位置值
 	 * @param int $limitLen limit 中的限制长度值
 	 * @param int $order 排序规则
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
 			$dbName = "member_friend")
 	{
 		$sql = "";
 	
 		//查询字段
 		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
 	
 		//查询条件
 		$baseWhere = ($dbName == "member_friend" ? " WHERE 1 = 1  " : " WHERE 1 = 1 ");
 		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
 	
 		$defaultOrderStr = " ";
 		if (!$isSimple) {
 			$defaultOrderStr = " ORDER BY dateline ";
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