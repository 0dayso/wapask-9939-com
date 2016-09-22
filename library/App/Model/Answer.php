<?php

/**
 * @version 0.0.0.1
 */
 
/**
 * 回答的 model 类
 * @author gaoqing
 * 2015年9月6日
 */
class App_Model_Answer extends QModels_Ask_Table{
	
	public  $_name = "wd_answer"; 
	private $primary = 'id';
	
	/**
	 * 初始化方法
	 * @see Zend_Db_Table_Abstract::init()
	 */
	public function init() {
		parent::init();
		$this->_dbwd=$GLOBALS['dbwd'];
	}
	
	public function tablename($name) {
		if ($name) {
			$this->_name = $name;
		} else {
			$this->_name = 'wd_answer';
		}
	}
	
	public function settbname($ask_id) {
		$sqltable = 'select * from wd_ask_tablespace where minid <= ' . $ask_id . ' and maxid >= ' . $ask_id;
		$tableinfo = $this->_db->fetchRow($sqltable);
		if ($tableinfo) {
			$this->tablename($tableinfo['tablename_answer']);
		}else {
			$this->_name = "wd_answer";
		}
	}
	
	public function getbyaskid($ask_id){
		$where = 'askid='. $ask_id;
		$order = ' addtime asc';
		$this->settbname($ask_id);
		$tmp_answer_array = $this->getList($where, $order);
		return $tmp_answer_array;
	}
	
	public function getList($where = '1', $order = '', $count = '', $offset = '') {
		$result = $this->fetchAll($where, $order, $count, $offset);
		return $result->toArray();
	}
	
	//获取好评缓存数据
	public function praisestep_cache($id) {
		$result = $this->_db->fetchAll("select * from `praisestep_cache` where tid='$id' and mark='1'");
		if ($result)
			return $result;
			else
				return false;
	}
	
	/**
	 * 添加文章
	 *
	 * @param 文章信息 array
	 * @return 插入ID int
	 */
	public function add($param) {
	
		$param['addtime'] or ( $param['addtime'] = time());
	
		//去除主键
		unset($param[$this->primary]);
		//去除param数组中键值为非列的值
		$param = $this->trimCol($param);
		//var_dump($param);
		return $this->insert($param);
	}
	
	public function edit($param = array()) {
		$tmp_id = intval($param[$this->primary]);
		$where = $this->primary . '=\'' . $tmp_id . '\'';
	
		//去除主键
		unset($param[$this->primary]);
		//print_r($param); exit;
		//去除param数组中键值为非列的值
		$param = $this->trimCol($param);
		$param = $this->trimValueIsNull($param);
		return $this->update($param, $where);
	}
	
	public function get_one($id = '') {
		if (!$id)
			return;
			$where = $this->primary . '=' . intval($id);
			$sql = 'SELECT `' . implode('`,`', $this->_getCols()) . '` FROM `' . $this->_name . '` WHERE ' . $where;
			$result = $this->_db->fetchRow($sql); //获取一行
			return $result;
	}
	
	public function numRows($where = 1) {
		$result = $this->_db->fetchAll("SELECT count(id) as num FROM `" . $this->_name . "` where " . $where);
		return $result[0]['num'];
	}
	
	/**
	 * 去除param数组中键值为非列名单元
	 */
	private function trimCol($param) {
		foreach ($param as $k => &$v) {
			if (!in_array($k, $this->_getCols())) {
				unset($param[$k]);
			}
		}
		return $param;
	}
	
	private function trimValueIsNull($param = array()) {
		if (!$param)
			return '';
			foreach ($param as $k => $v) {
				if (!$v) {
					unset($param[$k]);
				}
			}
			return $param;
	}
	
	
	public function getAnswerNum($where=1){
		//        echo "SELECT * as num FROM `wd_ask_answernum` where " . $where;
		//        exit;
		$result = $this->_db->fetchAll("SELECT * FROM `wd_ask_answernum` where " . $where);
		return $result[0]['answernum'];
	}
	
	/**
	 * 得到医生的所有回答总数 
	 * @author gaoqing
	 * 2015年9月6日
	 * @param int $uid 医生的 id
	 * @return array 医生的所有回答总数 
	 */
	public function getDoctorAllAnswerCount($uid) {
		$doctorAllAnswerCount = 0;
	
		$sql = $this->getSQL(true, " DISTINCT askid  ", " AND userid = ?  ");
		$statement = $this->_dbwd->prepare($sql);
		$statement->execute(array($uid));
		$doctorAllAnswerCount = $statement->fetchColumn();
	
		return $doctorAllAnswerCount;
	}	
	
	
	
	/**
	 * 得到医生的所有问答信息
	 * @author gaoqing
	 * 2015年9月6日
	 * @param int $uid 医生的 id
	 * @param int $start 分页的开始位置
	 * @param int $pageSize 每页显示的信息数
	 * @return array 医生的所有问答信息
	 */
	public function getDoctorAnswerAsk($uid, $start, $pageSize) {
		$doctorAllAnswer = array();
		
		$innerTable = " SELECT DISTINCT id, askid, content, praise, addtime from wd_answer where userid = ? ORDER BY id DESC " . " LIMIT ". $start . " , " . $pageSize;;
		$sql = "SELECT  ".
				" wsw.id wswid, wsw.askid, wsw.content, wsw.praise, wsw.addtime,  ".
				" wsk.id, wsk.title, wsk.content wskcontent, wsk.answernum, wsk.bestanswer ".
				" FROM (". $innerTable .") wsw, wd_ask wsk ".
				" where wsw.askid = wsk.id AND wsk.examine = 1 ";
		
		$statement = $this->_dbwd->prepare($sql);
		$statement->execute(array($uid));
		
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)){
			$temp['title'] = $this->cutString($temp['title'], 20, 1);
			if (mb_strlen($temp['content'], 'utf-8') >= 59) {
				$temp['content'] = $this->cutString($temp['content'], 59, 1);
			}else{
				$temp['content'] = $temp['content'] . "...";
			}
			$temp['addtime'] = date("Y-m-d H:i", $temp['addtime']);
			
			$temp['satisfied'] = "";
			if (!empty($temp['bestanswer']) && ($temp['bestanswer'] == $temp['wswid'])) {
				$temp['satisfied'] = "采纳";
			}
			$doctorAllAnswer[] = $temp;
		}
		return $doctorAllAnswer;
	}	
	
	/**
	 * 得到查询的 SQL 语句
	 * @author gaoqing
	 * 2015年9月6日
	 * @param boolean $isSimple 是否使用最简单的条件
	 * 						      （当为 true 时，如果 $start、$limitLen、$order 都为 null 时，则不使用默认的值，直接不添加相应的条件）
	 * @param int $selectField 要查询的字段
	 * @param int $where 查询条件
	 * @param int $start 查询条数限制的 开始 位置值
	 * @param int $limitLen limit 中的限制长度值
	 * @param int $order 排序规则
	 * @param string $dbName 表名称
	 * @return string 查询的 SQL 语句
	 */
	private function getSQL(
			$isSimple = true,
			$selectField = null,
			$where = null,
			$start = null,
			$limitLen = null,
			$order = null,
			$dbName = "wd_answer")
	{
		$sql = "";
	
		//查询字段
		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
	
		//查询条件
		$baseWhere = ($dbName == "wd_answer" ? " WHERE 1 = 1  " : " WHERE 1 = 1 ");
		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
	
		$defaultOrderStr = " ";
		if (!$isSimple) {
			$defaultOrderStr = " ORDER BY id ";
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