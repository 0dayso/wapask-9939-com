<?php
/**
 * @version 0.0.0.1
 */
 
/**
 * 会员日志 Model 类
 * @author gaoqing
 * 2015-09-02
 */
 class App_Model_Memberblog extends App_BaseTable{
 	
 	/** 表名称 */
 	private $tableName = "member_blog";
 	
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
 	 * 得到日志的详细信息 
 	 * @author gaoqing
 	 * 2015年9月6日
 	 * @param int $blogID 日志的 id 
 	 * @return array 日志的详细信息 
 	 */
 	public function getDetailBlog($blogID) {
 		$detailBlog = array();
 		
 		$sql = " SELECT " .
 			   " mb.subject, mb.dateline, mb.praise, mbd.message, mbd.relatedtime ".
 			   " FROM " . 
 			   " member_blog mb, member_blog_detail mbd ". 
 			   " where mb.blogid = mbd.blogid and mb.blogid = ? ";
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($blogID));
 		$temp = $statement->fetch(PDO::FETCH_ASSOC);
 		
 		$temp['dateline'] = date('Y-m-d H:i:s', $temp['dateline']);
 		$temp['relatedtime'] = date('Y-m-d H:i:s', $temp['relatedtime']);
 		empty($temp['relatedtime']) ? $temp['dateline'] : $temp['relatedtime'];
 		
 		$detailBlog = $temp;
 		
 		return $detailBlog;
 	}
 	
 	/**
 	 * 得到医生的日志简短信息
 	 * @author gaoqing
 	 * 2015年9月6日
 	 * @param int $uid 用户的 id
 	 * @param int $start 分页的开始位置
 	 * @param int $pageSize 分页时，每页显示的数量
 	 * @param int $blogID 日志的 id（默认为 0，即没有）
 	 * @return array 医生的日志简短信息集
 	 */
 	public function getDoctorBlogArr($uid, $start, $pageSize, $blogID = 0) {
 		$doctorBlogArr = array();
 		
 		$appendSQL = empty($blogID) ? " " : " AND blogid != " . $blogID;
 		$sql = $this->getSQL(false, " blogid, subject, viewnum, dateline ", $appendSQL . " AND uid = ? ", $start, $pageSize);
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($uid));
 		
 		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)){
 			$temp['subject'] = $this->cutString($temp['subject'], 13, 1);
 			$temp['date'] = date('Y-m-d', $temp['dateline']);
 			$temp['time'] = date('H:i:s', $temp['dateline']);
 			
 			$doctorBlogArr[] = $temp;
 		}
 		return $doctorBlogArr;
 	}
 	
 	/**
 	 * 得到指定会员 ID 的所有日志总数
 	 * @author gaoqing
 	 * 2015年9月2日
 	 * @param int $uid 会员 id
 	 * @return int 日志总数
 	 */
 	public function getMemberBlogCount($uid) {
 		$memberBlogCount = 0;
 		
 		$sql = $this->getSQL(true, "count(*)", " AND uid = ? ");
 		$statement = $this->connection->prepare($sql);
 		$statement->execute(array($uid));
 		
 		while ($tempArr = $statement->fetch(PDO::FETCH_NUM)) {
 			$memberBlogCount = $tempArr[0];
 		}
 		return $memberBlogCount;
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
 			$dbName = "member_blog")
 	{
 		$sql = "";
 	
 		//查询字段
 		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
 	
 		//查询条件
 		$baseWhere = ($dbName == "member_blog" ? " WHERE 1 = 1  " : " WHERE 1 = 1 ");
 		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
 	
 		$defaultOrderStr = " ";
 		if (!$isSimple) {
 			$defaultOrderStr = " ORDER BY blogid ";
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