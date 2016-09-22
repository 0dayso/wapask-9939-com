<?php
/**
**潘红晶 
* 日期 2015-5 
**/
class App_Model_Ask extends QModels_Ask_Table{

	protected $_name				= 'wd_ask';
	protected $primary = "id";
	protected $_db = null;
	
	private $map_table = array(
            'wd_ask_history_1' => array(0, 502014, 'wd_ask_history_1_answer'),
            'wd_ask_history_2' => array(502015, 1007110, 'wd_ask_history_2_answer'),
            'wd_ask_history_3' => array(1007111, 1517111, 'wd_ask_history_3_answer'),
            'wd_ask_history_4' => array(1517112, 2042111, 'wd_ask_history_4_answer'),
            'wd_ask_history_5' => array(2042112, 3372111, 'wd_ask_history_5_answer'),
            'wd_ask_history_6' => array(3372112, 4702068, 'wd_ask_history_6_answer'),
            'wd_ask_history_7' => array(4702069, 5702233, 'wd_ask_history_7_answer'),
            'wd_ask' => array(5702234, 100000000, 'wd_answer')
    );
	
	/** 疾病的实体类 */
	protected $disease = null;
	
	/** 科室的尸体类 */
	protected $department = null;
	
	/** 医生的实体类 */
	private $doctor = null;
	
	protected function _setup() {
		$this->_db = $GLOBALS['dbwd'];
		
		parent::_setup();
	}


	
	function init(){
		parent::init();
		
		try {
			parent::init();
			
			$this->doctor = new App_Model_Doctor();
			$this->disease = new App_Model_Disease();
			$this->department = new App_Model_Department();
			
			$this->_dbwd=$GLOBALS['dbwd'];
			//$this->_dbwd=$this->getAdapter();
			
			$this->db_www = $this->db_v2_read;
			$this->db_jb = $this->db_v2jb_read;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		

	}
	
	public function list_one($id = '') {
		if (!$id)
			return;
			$id = intval($id);
			foreach ($this->map_table as $k => $v) {
				if ($id >= $v[0] && $id <= $v[1]) {
					$this->setName($k);
					break;
				}
			}
			$where = $this->primary . '=' . intval($id);
			$sql = 'SELECT `' . implode('`,`', $this->_getCols()) . '` FROM `' . $this->_name . '` WHERE ' . $where;
			$result = $this->_db->fetchRow($sql); //获取一行
			return $result;
	}
	
	/**
	 * 2015年12月11日
	 */
	public function setName($tbname) {
		$this->_name = $tbname;
	}
	
	/**
	 * 2015年12月11日
	 */
	public function getList($where = '', $order = '', $count = '', $offset = '') {
		$this->setName("wd_ask");
		$result = $this->fetchAll($where, $order, $count, $offset);
		return $result->toArray();
	}
	
	
	/**
	 * 根据用户的 id ，查询其所有的问题信息
	 * @author gaoqing
	 * 2015年9月10日
	 * @param int $userid 用户的 id 
	 * @return array 所有的问题信息
	 */
	public function getAllAskByUserid($userid) {
		$userAskArr = array();
		
		$sql = $this->getSQL(false, " id, title, ctime, content, answernum, status ", " AND userid = ? ", null, null, " ORDER BY id DESC", "wd_ask", false);
		
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($userid));
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			$temp['ctime'] = date('Y-m-d H:i:s', $temp['ctime']);
			$temp['cnstatus'] = empty($temp['status']) ? '未解决' : '已解决';
			
			$userAskArr[] = $temp;
		}
		return $userAskArr;
	}
	
	/**
	 * 根据用户 id 查询用户信息
	 * @author gaoqing
	 * 2015年9月10日
	 * @param int $userid 用户的 id 
	 * @return array 用户信息
	 */
	public function getUserByID($userid) {
		$user = array();
		
		$user = $this->find($userid);
		
		return $user;
	}
	
	/**
	 * 根据用户名查询用户信息
	 * @author gaoqing
	 * 2015年10月09日
	 * @param string $username 用户名
	 * @return array 用户信息
	 */
	public function getUserByName($username) {
		$user = array();
		
		$sql = $this->getSQL(true, " uid, username, password ", " AND username = ? ", null, null, null, "member");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($username));
		$user = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		return $user;
	}

	/**
	 * 查询当前用户是否绑定指定手机号
	 * @author gaoqing
	 * 2016年06月22日
	 * @param int $userid 用户id
     * @param string $telephone 手机号码
	 * @return array 用户信息
	 */
	public function getUserByTel($userid, $telephone) {
		$user = array();

		//$sql = $this->getSQL(true, " uid, username ", " AND uid = ? AND mobile = ? ", null, null, null, "member");
		$sql = $this->getSQL(true, " uid, username ", " AND mobile = ? ", null, null, null, "member");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($telephone));
		$user = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $user;
	}

	/**
	 * 根据科室的 id ，得到该科室下的所有问答数
	 * @author gaoqing
	 * 2015年9月9日
	 * @param string $askidStr 科室 id 字符串集
	 * @return int 该科室下的所有问答数
	 */
	public function getAskCountByClassid($askidStr) {
		$askCount = 0;
		
		$sql = $this->getSQL(true, " count(*) ", " AND classid in(?) ");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($askidStr));
		$temp = $statement->fetch(PDO::FETCH_NUM);
		
		if (!empty($temp)) {
			$askCount = $temp[0];
		}
		return $askCount;
	}
	
	/**
	 * 得到当前问答的相关问答
	 * @author gaoqing
	 * 2015年9月8日
	 * @param int $askid 问答 id 
	 * @param int $classid 问答所在的疾病 id 
	 * @param int $start 查询的开始位置
	 * @param int $pageSize 每次查询的个数
	 * @return array 相关问答
	 */
	public function getRelateAskInfoArr($askid, $classid, $start = 0, $pageSize = 6) {
		$relateAskInfoArr = array();
		
//		$sql = $this->getSQL(false, " id, title, classid, class_level1, class_level2, class_level3, answernum ", " AND id != ? AND classid = ? ", $start, $pageSize);
		
        $sql = $this->getSQL(false, " id, title, classid, class_level1, class_level2, class_level3, answernum ", " AND classid = ? ", $start, $pageSize+1);
        $statement = $this->_db->prepare($sql);
//		$statement->execute(array($askid, $classid));
        $statement->execute(array($classid));
		
        $row_index = 1;
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
            if($row_index<=$pageSize){
                if($temp['id']!=$askid){
                    $temp['shorttitle'] = $temp['title'];

                    if (empty($temp['classid'])) {
                        if (!empty($temp['class_level1'])) {
                            $temp['classid'] = $temp['class_level1'];
                        } else{
                            if (!empty($temp['class_level2'])) {
                                $temp['classid'] = $temp['class_level2'];
                            }else if(!empty($temp['class_level3'])){
                                $temp['classid'] = $temp['class_level3'];
                            }
                        }
                    }
                    $relateAskInfoArr[] = $temp;
                    $row_index++;
                }
            }
		}
		
		//处理数据为空时的情况
		if (empty($relateAskInfoArr)) {
			$relateAskInfoArr['id'] = 0;
			$relateAskInfoArr['title'] = "";
			$relateAskInfoArr['shorttitle'] = "";
			$relateAskInfoArr['classid'] = 0;
			$relateAskInfoArr['answernum'] = 0;
		}
		return $relateAskInfoArr;
	}
	
	/**
	 * 得到当前问题的所有医生的回答
	 * @author gaoqing
	 * 2015年9月8日
	 * @param int $askID 问题的 id
	 * @param int $bestAnswerID 采纳的回答 id（默认没有被采纳）
	 * @return array 所有医生的回答信息集
	 */
	public function getAskDoctorAnswer($askID, $bestAnswerID = 0) {
		$askDoctorAnswerArr = array();
		
	    $id = intval($askID);
        $tabalname_answer = 'wd_answer';
        foreach ($this->map_table as $k => $v) {
            if ($id >= $v[0] && $id <= $v[1]) {
                $tabalname_answer = $v[2];
                break;
            }
        }
		
		/*
		 * 1、根据 $askID 得到回答信息的 content, 及 userid （从 wd_answer 中获取）
		 * 2、根据得到的 userid，得到医生的基本信息
		 */
		
		//1、根据 $askID 得到回答信息的 content, 及 userid （从 wd_answer 中获取）
		$sql = $this->getSQL(true, "id, userid, content, addtime, suggest ", " AND askid = ? ", null, null, null, $tabalname_answer );
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($askID));
		
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			$userid = 0;
			$temp['addtime'] = date('Y-m-d H:i', $temp['addtime']);
			if (isset($temp['userid']) && !empty($temp['userid'])) {
				$userid = $temp['userid'];
			}
			
			$temp['best'] = "";
			if (!empty($bestAnswerID) && $bestAnswerID == $temp['id'] ) {
				$temp['best'] = "最佳答案";
			}
			
			//2、根据得到的 userid，得到医生的疾病信息
			$doctorBasicInfo = $this->doctor->getDoctorBasicInfoByid($userid);
			
			$mergeArr = array();
			$mergeArr['answer'] = $temp;
			$mergeArr['doctor'] = $doctorBasicInfo;
			
			$askDoctorAnswerArr[] = $mergeArr;
		}
		return $askDoctorAnswerArr;
	}
	
	/**
	 * 得到问题的信息
	 * @author gaoqing
	 * 2015年9月8日
	 * @param int $askID 问题的 id
	 * @param boolean $isUserAsk 是否查询用户自己的问题（如果是显示给用户看的话，审核或者未审核，都有显示给用户看，即：eaxmine 可以为 0, 不用限制）
	 * @return array 问题的信息
	 */
	public function getAskInfo($askID, $isUserAsk = false) {
		$askInfo = array();
		
		$id = intval($askID);
		foreach ($this->map_table as $k => $v) {
			if ($id >= $v[0] && $id <= $v[1]) {
				$this->setName($k);
				break;
			}
		}
		
		$sql = $this->getSQL(true, " id, title, classid, class_level1, class_level2, class_level3, content, ctime, age, sexnn, answernum, bestanswer, help ", " AND id = ? ", null, null, null, $this->_name);
		if ($isUserAsk) {
			$sql = $this->getSQL(true, " id, title, classid, class_level1, class_level2, class_level3, content, ctime, age, sexnn, answernum, bestanswer, help ", " AND id = ? ", null, null, null, $this->_name, false);
		}
		
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($askID));
		
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			$temp['sexnn'] = ($temp['sexnn'] == 1) ? "男" : "女";
			$temp['ctime'] = date('Y-m-d H:i', $temp['ctime']);
			
			//通过科室 id 查询科室的名称
			$temp['classid'] = empty($temp['classid']) ? (  empty($temp['class_level1']) ? ( empty($temp['class_level2']) ? $temp['class_level3'] : $temp['class_level2'] )  : $temp['class_level1'] ) : $temp['classid'];
			$classid = $temp['classid'];
			$temp['classname'] = $this->department->getClassNameByClassid($classid, false);
			
			$askInfo = $temp;
		}
		return $askInfo;
	}
	
	/**
	 * 得到常见疾病
	 * @author gaoqing
	 * 2015年9月8日
	 * @param int $classid 疾病的 ID
	 * @param int $start 分页的开始位置
	 * @param int $pageSize 分页的每页显示数
	 * @return array 常见疾病数据集
	 */
	public function getCommonDiseases($classid, $start, $pageSize) {
		$commonDisease = array();
		
		$sql = $this->getSQL(false, " id, title, classid, ctime ", " AND classid = ? ", $start, $pageSize, " order by ctime desc " );
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($classid));
		
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			$temp['shorttitle'] = $this->cutString($temp['title'], 18, 1);
			
			$commonDisease[] = $temp;
		}
		return $commonDisease;
	}
	
	/**
	 * 向医生提问
	 * @author gaoqing
	 * 2015年9月7日
	 * @param array $askArr 提问的信息集
	 * @return int 插入记录的 id 
	 */
	public function askDoctor($askArr) {
		$insertAskID = 0;
		if (!empty($askArr)) {
			$insertAskID = $this->insert($askArr);
		}
		return $insertAskID;
	}
	
	/**
	 * 得到指定 疾病名称 对应的问答信息集
	 * @author gaoqing
	 * 2015年9月1日
	 * @param string $diseaseid 疾病id (归属在 科室表中的疾病id)
	 * @param int $start 疾病名称
	 * @param int $pageSize 疾病名称
	 * @param array $userDifineWhere 自定义查询条件及参数（默认为 null）
	 * @return array 指定 疾病名称 对应的问答信息集
	 */
	public function getAskAndAnswers($diseaseid, $start, $pageSize, $userDifineWhere = null) {
		$askAndAnswerArr = array();
		
		/*
		 * 1、根据疾病名称，得到 疾病名称 下对应的分页问题信息集 $askArr 
		 * 2、根据问题的 classid 字符串集 ，查询相对应的 回答信息 $answer
		 * 3、根据 $answer 的回答信息，得到对应的回答人信息 （科室、姓名）
		 * 4、将上述得到的信息，组织到一个数组中 $askAndAnswerArr 
		 */
		
		//默认的查询条件及相应的参数
		$where = " AND classid = ? AND examine = 1 ";
		$condition = $diseaseid;
		
		//自定义的查询条件及相应的查询参数
		if (isset($userDifineWhere) && !empty($userDifineWhere)) {
			$where = $userDifineWhere['where'];
			$condition = $userDifineWhere['condition'];
		}
		
		//1、根据疾病名称，得到 疾病名称 下对应的分页问题信息集 $askArr 
		$askArr = array();
		$askidArr = array();
		$bestansweridArr = array();
		$sql = $this->getSQL(false, " id, title, content, answernum, bestanswer ", $where, $start, $pageSize);
		$statement = $this->_dbwd->prepare($sql);
		$statement->execute(array($condition));
        $tempArr = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($tempArr) && !empty($tempArr)){
            foreach ($tempArr as $temp){
                $askid = $temp['id'];
                $bestanswerid = $temp['bestanswer'];

                $temp['title'] = $this->cutString($temp['title'], 20, 1);

                if (isset($diseaseName) && !empty($diseaseName)) {
                    $temp['title'] = str_replace($diseaseName, "<span>". $diseaseName ."</span>", $temp['title']);
                }
                //是否满意
                $temp['satisfied'] = "";

                if (!empty($bestanswerid)) {
                    $temp['satisfied'] = "采纳";
                    $bestansweridArr[] = $bestanswerid;
                }
                $askidArr[] = $askid;
                $askArr[] = $temp;
            }
            //2、根据问题的 classid 字符串集 ，查询相对应的 回答信息 $answer
            $askidStr = implode(",", $askidArr);
            $bestansweridStr = "";
            $bestansweridStr = implode(",", $bestansweridArr);
            $answer = $this->getAnswerByClassid($askidStr, $bestansweridStr);

            $userID = $answer['userid'];
            //3、根据 $answer 的回答信息，得到对应的回答人信息 （科室、姓名）
            $doctor = $this->getDoctorByUid($userID);

            //4、将上述得到的信息，组织到一个数组中 $askAndAnswerArr
            if (!empty($askArr)) {

                //循环所有的问题，通过 askid, 得到其相应的回答信息，通过 userid, 得到问题回答人信息
                foreach ($askArr as $askKey => $askVal){
                    $askAndAnswer = array();
                    $answerMetaData = $answer['answer'][$askVal['id']];

                    $askAndAnswer['ask'] = $askVal;
                    $askAndAnswer['answer'] = $answerMetaData;
                    $askAndAnswer['doctor'] = $doctor[$answerMetaData['userid']];

                    $askAndAnswerArr[] = $askAndAnswer;
                }
            }
        }
		return $askAndAnswerArr;
	}
	
	/**
	 * 根据医生的 id ，得到对应的医生相关信息
	 * @author gaoqing
	 * 2015年9月2日
	 * @param string $uid 医生的 id 字符串集
	 * @return array 医生相关信息
	 */
	public function getDoctorByUid($uid) {
		$doctor = array();
		
		$uidArr = array();
		if (!empty($uid)) {
			$uidArr = explode(",", $uid);
		}
		
		$sql = " SELECT m.uid, m.nickname, md2.doc_keshi FROM  member m, member_detail_2 md2 where m.uid = md2.uid and  m.status = 1 and m.uType = 2 and m.uid in (". $uid .") ";
		$statement = $this->_dbwd->prepare($sql);
		$statement->execute();
		while ($temp = $statement->fetch(PDO::FETCH_ASSOC)) {
			$doctor[$temp['uid']] = $temp;
		}	
		//判断没有匹配的医生信息,并作相应的处理
		foreach ($uidArr as $uidVal){
			if (!isset($doctor[$uidVal])) {
				$doctor[$uidVal] = array(
						'uid' => 0,
						'nickname' => '',
						'doc_keshi' => ''
				);
			}
		}
		return $doctor;
	}
	
	/**
	 * 根据问题的 id ,得到当前问题对应的回答信息
	 * @author gaoqing
	 * 2015年9月2日
	 * @param string $askidStr 问题的 id 字符串集
	 * @return array 当前问题对应的回答信息
	 */
	 private function getAnswerByClassid($askidStr, $bestAnsweridStr) {
	 	$answerAndAskidArr = array();
	 	$resultArr = array();
	 	
	 	if (!empty($askidStr)) {
	 		$askidArr = explode(",", $askidStr);
	 	}
	 	
	 	$bestAnswerPart = "";
	 	if (!empty($bestAnsweridStr)) {
	 		$bestAnswerPart = " or id in (". $bestAnsweridStr .") ";
	 	}
	 
		$sql = "SELECT userid, content, praise, askid FROM wd_answer WHERE askid IN (". $askidStr .") ". $bestAnswerPart ." GROUP BY askid";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();
		$answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$answerUserIdArr = array();
		if (!empty($answer)) {
			foreach ($answer as $key => $val){
				if (mb_strlen($val['content'], 'utf-8') >= 59) {
					$val['content'] = $this->cutString($val['content'], 59, 1);
				}else {
					$val['content'] = $val['content'] . "...";
				}
				$answerAndAskidArr[$val['askid']] = $val;
				
				$answerUserIdArr[] = $val['userid'];
			}
		}
		foreach ($askidArr as $askid){
			if (!isset($answerAndAskidArr[$askid])) {
				$answerAndAskidArr[$askid] = array(
						'userid' => 0,
						'content' => '',
						'praise' => 0,
						'askid' => 0
				);
			}
		}
		$answerUserIdArr = implode(",", $answerUserIdArr);
		
		$resultArr['answer'] = $answerAndAskidArr;
		$resultArr['userid'] = $answerUserIdArr;
		
		return $resultArr;
	}

	
	/**
	 * 根据疾病的名称，得到疾病所对应的所有问题数
	 * @author gaoqing
	 * 2015年9月1日
	 * @param string $diseaseName 疾病的名称
	 * @return int 疾病所对应的所有问题数
	 */
	public function getAskCountByTittle($diseaseName) {
		$askCount = 0;
		
		$sql = $this->getSQL(true, " COUNT(*) ", " AND title LIKE ? ");
		$statement = $this->_dbwd->prepare($sql);
		$statement->execute(array("%". $diseaseName ."%"));
		$tempArr = $statement->fetch(PDO::FETCH_NUM);
		
		$askCount = $tempArr[0];
		
		return $askCount;
	}
	
	/**
	 * 得到查询的 SQL 语句
	 * @author gaoqing
	 * 2015年9月1日
	 * @param boolean $isSimple 是否使用最简单的条件
	 * 						      （当为 true 时，如果 $start、$limitLen、$order 都为 null 时，则不使用默认的值，直接不添加相应的条件）
	 * @param int $selectField 要查询的字段
	 * @param int $where 查询条件
	 * @param int $start 查询条数限制的 开始 位置值
	 * @param int $limitLen limit 中的限制长度值
	 * @param int $order 排序规则
	 * @param string $dbName 表名称
	 * @param boolean $isNeedBaseWhere 是否需要基础的查询条件
	 * @return string 查询的 SQL 语句
	 */
	private function getSQL(
			$isSimple = true,
			$selectField = null,
			$where = null,
			$start = null,
			$limitLen = null,
			$order = null,
			$dbName = "wd_ask",
			$isNeedBaseWhere = true)
	{
		$sql = "";
	
		//查询字段
		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
	
		//查询条件
		$baseWhere = " WHERE 1 = 1 ";
		if ($isNeedBaseWhere) {
			$baseWhere = ($dbName == "wd_ask" ? " WHERE examine = 1  " : " WHERE 1 = 1 ");
		}
		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
	
		$defaultOrderStr = " ";
		if (!$isSimple) {
			$defaultOrderStr = " ORDER BY id DESC ";
		}
		//排序条件
		$orderStr = empty($order) ? $defaultOrderStr : $order ;
	
		//查询条数限制
		$limitStr = "";
		if (!empty($limitLen)) {
			$startNum = empty($start) ? 0 : $start;
			$limitStr = " LIMIT " . $startNum ." , " . $limitLen;
		}
        
        /*if(stripos($dbName,'wd_ask')!==false && stripos($whereStr, 'classid')!==false && stripos($whereStr, 'examine')!==false ){
            $dbName .='  force index(index_examine_classid_id) ';
        }*/
        
		$sql = " SELECT ". $selectFieldStr ." FROM " . $dbName . $whereStr . $orderStr . $limitStr;
		return $sql;
	}	
	
    public function Getask($where){
        if($where){
            $sSQL = "SELECT id,title,content,sexnn,age,answernum,bestanswer,ctime FROM ".$this->_name." WHERE ".$where;
            $result	= $this->_dbwd->fetchAll($sSQL);
  		    return $result;
        }
    }

    //新增部分：分诊相应操作： gaoqing - 2016-06-17 Start
    /**
     * 分诊
     * @param type $askinfo 问答的信息
     */
    public function triage($content){
        $wd_keshi_ret_default = array('class_level1'=>'15','class_level2'=>'0','class_level3'=>'0');

        $explain_result = QLib_Utils_SearchHelper::scws($content);

        $callback = array($this,'filter');
        //获取过滤数据
        $explain_result = array_filter($explain_result,$callback);
//        print_r($explain_result);exit;
        //如果无法从用户输入的内容里分出有意义的词，返回默认科室
        if(!isset($explain_result[0])){
            return $wd_keshi_ret_default;
        }

        $all = array();
        foreach($explain_result as $k=>$v){
            $all[$v['attr']][] = $v;
        }

        $wd_keshi_ret['class_level3'] = '0';//默认三级疾病为0
        //
        //Ⅰ
        //如果有疾病词
        if(isset($all['XB'][0])){
            //第一个病的词的名称
            $disease_name = $all['XB'][0]['word'];

            //通过疾病名查疾病id
            $disease_sql = "select id from 9939_disease where name='{$disease_name}'";
            $disease_ret = $this->db_v2jb->fetchRow($disease_sql);
            $disease_id = $disease_ret['id'];//9725

            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$disease_id}";
            $disease_name_ret = $this->db_v2jb->fetchRow($disease_name_sql);
            $disease_name = $disease_name_ret['name'];

            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $this->_db->fetchRow($class_level3_sql);
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3;
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $this->db_v2jb->fetchRow($department_sql);
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $this->_db->fetchRow($wd_keshi_sql);
                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }else{
                    if(isset($wd_keshi_ret['class_level3']) && !empty($wd_keshi_ret['class_level3'])){
                        $class_level3_sql = "select id from wd_disease where id='{$wd_keshi_ret['class_level3']}'";
                        $class_level3 = $this->_db->fetchRow($class_level3_sql);
                    }
                }
                return $wd_keshi_ret;
            }
        }

        //Ⅱ
        //如果没有疾病词，症状词，只有部位词
        if(!isset($all['XZ'][0]) && isset($all['XS'][0])){
            //第一个部位的词的名称
            $condition_part_name = $all['XS'][0]['word'];

            //通过部位名查部位id
            $condition_part_sql = "select id from 9939_part where name='{$condition_part_name}'";
            $condition_part_ret = $this->db_v2jb->fetchRow($condition_part_sql);
            $condition_part_id = $condition_part_ret['id'];//39

            //通过部位查找所有的疾病
            $part_disease_sql = "SELECT unique_key FROM 9939_part_rel_merge WHERE source_flag=1 AND partid={$condition_part_id}";
            $part_disease_ret = $this->db_v2jb->fetchRow($part_disease_sql);
            $disease_id = str_replace('disease', '', $part_disease_ret['unique_key']);//7211

            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$disease_id}";
            $disease_name_ret = $this->db_v2jb->fetchRow($disease_name_sql);
            $disease_name = $disease_name_ret['name'];

            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $this->_db->fetchRow($class_level3_sql);
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3;
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $this->db_v2jb->fetchRow($department_sql);
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $this->_db->fetchRow($wd_keshi_sql);
                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }
                return $wd_keshi_ret;
            }
        }

        //Ⅲ
        //如果没有疾病词，部位词，只有症状词
        if(!isset($all['XS'][0]) && isset($all['XZ'][0])){
            //症状的词的名称
            $symtpom_name = $all['XZ'][0]['word'];


            //通过症状名查症状id
            $symtpom_sql = "select id from 9939_symptom where name='{$symtpom_name}'";
            $symtpom_ret = $this->db_v2jb->fetchRow($symtpom_sql);
            $symtpom_id = $symtpom_ret['id'];//6521

            //通过症状id查关联疾病,取第一个病
//            $rel_disease_sql = "SELECT diseaseid FROM 9939_disease_symptom_rel WHERE symptomid ={$symtpom_id}";
            $rel_disease_sql = "SELECT 9939_disease.id,9939_disease.`name`,9939_disease_symptom_rel.diseaseid FROM 9939_disease LEFT JOIN 9939_disease_symptom_rel ON 9939_disease_symptom_rel.diseaseid=9939_disease.id WHERE symptomid = {$symtpom_id}";
            $rel_disease_ret = $this->db_v2jb->fetchRow($rel_disease_sql);//获取所有症状关联的疾病id
            $rel_disease_id = $rel_disease_ret['diseaseid'];//取第一个病
            $rel_disease_name = $rel_disease_ret['name'];//取第一个病

            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$rel_disease_name}'";
            $class_level3 = $this->_db->fetchRow($class_level3_sql);

            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3;
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$rel_disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";
                $department_ret = $this->db_v2jb->fetchRow($department_sql);

                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $this->_db->fetchRow($wd_keshi_sql);

                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }
                return $wd_keshi_ret;
            }
        }
        //Ⅳ
        //如果没有疾病词，有症状词和部位词
        if(isset($all['XZ'][0]) && isset($all['XS'][0])){

            //**************1、根据症状取出所有的疾病**************
            foreach($all['XZ'] as $k=>$v){
                //症状的词的名称
                $symtpom_name = $v['word'];

                //通过症状名查症状id
                $symtpom_sql = "select id from 9939_symptom where name='{$symtpom_name}'";
                $symtpom_ret = $this->db_v2jb->fetchRow($symtpom_sql);
                $symtpom_id = $symtpom_ret['id'];//6521

                //通过症状id查关联疾病,取第一个病
                $rel_disease_sql = "SELECT diseaseid FROM 9939_disease_symptom_rel WHERE symptomid ={$symtpom_id}";
                $rel_disease_ret = $this->db_v2jb->fetchAll($rel_disease_sql);//获取所有症状关联的疾病id
                if(isset($rel_disease_ret[0])){
                    break;
                }
            }
            foreach($rel_disease_ret as $k=>$v){
                $rel_disease_id_arr[] = $v['diseaseid'];
            }


            //**************2、根据部位取出所有的疾病**************
            //第一个部位的名称
            $condition_part_name = $all['XS'][0]['word'];

            //通过部位名查部位id
            $condition_part_sql = "select id from 9939_part where name='{$condition_part_name}'";
            $condition_part_ret = $this->db_v2jb->fetchRow($condition_part_sql);

            //3、如果根据部位查不到疾病，设置疾病id为根据症状查出来的第一个疾病
            if(!$condition_part_ret){
                $last_disease_id = $rel_disease_id_arr[0];
            }else{
                $condition_part_id = $condition_part_ret['id'];//67

                //3.1、通过部位查找所有的疾病
                $part_disease_sql = "SELECT unique_key FROM 9939_part_rel_merge WHERE source_flag=1 AND partid={$condition_part_id}";
                $part_disease_ret = $this->db_v2jb->fetchAll($part_disease_sql);
                foreach($part_disease_ret as $k=>$v){
                    $part_disease_id_arr[] = str_replace('disease', '', $v['unique_key']);
                }

                //**************3.2、取二者的交集的第一个疾病作为最终疾病**************
                $last_disease_id_arr = array_intersect($rel_disease_id_arr, $part_disease_id_arr);
                sort($last_disease_id_arr);

                //如果没有交集时：
                if (empty($last_disease_id_arr)){
                    if (!empty($rel_disease_id_arr)){
                        $last_disease_id_arr[0] = $rel_disease_id_arr[0];
                    }else if (!empty($part_disease_id_arr)){
                        $last_disease_id_arr[0] = $part_disease_id_arr[0];
                    }
                }
                $last_disease_id = $last_disease_id_arr[0];
            }


            //先直接查疾病表是否有该疾病
            //如果有直接返回查询结果
            //如果没有，通过从症状表查
            //通过查wd_disease表得到disease_id
            $disease_name_sql = "select id,name from 9939_disease where id={$last_disease_id}";
            $disease_name_ret = $this->db_v2jb->fetchRow($disease_name_sql);
            $disease_name = $disease_name_ret['name'];

            $class_level3_sql = "select class_level1,class_level2,id from wd_disease where name='{$disease_name}'";
            $class_level3 = $this->_db->fetchRow($class_level3_sql);
            if(isset($class_level3['id'])){
                $wd_keshi_ret = $class_level3;
                $wd_keshi_ret['class_level3'] = $class_level3['id'];
                unset($wd_keshi_ret['id']);
                return $wd_keshi_ret;
            }else{
                //通过疾病id查科室
                $disease_condition = 'disease'.$last_disease_id;
                $department_sql = "select depart.name from 9939_department depart,9939_depart_rel_merge merge where merge.source_flag=1 and merge.unique_key='{$disease_condition}' and merge.departmentid=depart.id";

                $department_ret = $this->db_v2jb->fetchRow($department_sql);
                $department_name = $department_ret['name'];

                //通过科室名称进入wd_keshi查询最终的
                $wd_keshi_sql = "select class_level1,class_level2 from wd_keshi where name='{$department_name}'";
                $wd_keshi_ret = $this->_db->fetchRow($wd_keshi_sql);

                //如果查不到数据放到默认科室里
                if(!isset($wd_keshi_ret['class_level1'])){
                    $wd_keshi_ret = $wd_keshi_ret_default;
                }

                return $wd_keshi_ret;
            }
        }
        //未考虑到的情形，直接返回默认科室
        return $wd_keshi_ret_default;
    }

    public function filter($v){
        return in_array($v['attr'], array('XB','XZ','XS'));
    }

    //新增部分：分诊相应操作： gaoqing - 2016-06-17 End

}