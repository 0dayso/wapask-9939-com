<?php

/**
 * 会员详细信息的实体类
 * @author gaoqing
 * 2015-09-29
 */
class App_Model_Memberdetail extends App_BaseTable{
	
	//设置当前 model 的默认值
	protected $_name = null;
	protected $_primary = null;
	protected $_db = null;
	
	/** 表名称 */
	private $table_name = "member_detail_1";
	
	protected function _setup(){
		$this->_name = "member_detail_1";
		$this->_primary = "uid";
		$this->_db = $GLOBALS['dbwd'];
		
		parent::_setup();
	}
	
	public function init() {
		parent::init();
	}
	
	/**
	 * 修改用户的详细信息
	 * @author gaoqing
	 * 2015年9月29日
	 * @param int $uid 要修改的用户 id
	 * @param array $data 要修改的信息
	 * @return int 修改后成功的行数
	 */
	public function updateUserDetail($uid, $data) {
		$updateRowNum = 0;
		
		//判断当前用户的是否存在
		$userDetail = $this->getUserDetail($uid);
		if (empty($userDetail)) {
			$data['level'] = 1;
			$data['uid'] = $uid;
			$updateRowNum = $this->insert($data);
		}else {
			$where = $this->_db->quoteInto("uid = ?", $uid);
			$updateRowNum = $this->update($data, $where);
		}
		$updateRowNum = 1;
		return $updateRowNum;
	}
	
	/**
	 * 得到用户的详细信息
	 * @author gaoqing
	 * 2015年9月30日
	 * @param int $uid 用户的 id
	 * @return array 用户的详细信息
	 */
	public function getUserDetail($uid){
		$userDetail = array();
		
		$where = $this->_db->quoteInto(" uid = ? ", $uid);
		
		$rowObj = $this->fetchRow($where);
		if (isset($rowObj) && !empty($rowObj)) {
			$userDetail = $rowObj->toArray();
		}
		return $userDetail;
	}
	
	
}


?>