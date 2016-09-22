<?php
/**
**潘红晶 
* 日期 2015-5 
**/
class App_Model_Disease extends QModels_Base_Table{

	protected $_name				= '9939_disease_content';
	
	/** 疾病表 */
	private $diseaseName = "9939_dzjb";

	
	function init(){
		parent::init();
		$this->_db					= $this->getAdapter();
	}
	
	/**
	 * 2015年12月11日
	 */
	public function getDiseaseFromCache(){
		include(APP_DATA_PATH.'/cache_disease.php');
		return $_CACHE_DISEASE;
	}

    public function getDiseaseByNewDB($diseaseName){
        $disease = array();

        //查询疾病的疾病信息
        $sql = ' SELECT * FROM 9939_disease WHERE name = \'' . $diseaseName . '\'';

        $statement = $this->db_v2jb_read->prepare($sql);
        $statement->execute();
        $disease_basic = $statement->fetch(PDO::FETCH_ASSOC);
        $disease = $disease_basic;
        if (isset($disease_basic) && !empty($disease_basic)){
            $disease_basic['simpleDesc'] = $this->cutString($disease_basic['description'], 25, 1);
            $disease_basic['title'] = $disease_basic['name'];

            //症状
            $disease_basic['symptom'] = array();
            if (isset($disease_basic['typical_symptom']) && !empty($disease_basic['typical_symptom'])){
                $symptom_arr = preg_split('/\s+/', $disease_basic['typical_symptom']);
                if (!empty($symptom_arr)){
                    foreach ($symptom_arr as $key => $value){
                        $temp = trim($value);
                        if (empty($temp)){
                            unset($symptom_arr[$key]);
                        }
                    }
                    $disease_basic['symptom'] = array_slice($symptom_arr, 0, 6);
                }
            }
            $disease = $disease_basic;

            //查询疾病的详细信息
            $sql = ' SELECT medicine FROM 9939_disease_content WHERE id = ' . $disease_basic['id'];
            $statement = $this->db_v2jb_read->prepare($sql);
            $statement->execute();
            $disease_detail = $statement->fetch(PDO::FETCH_ASSOC);

            if (isset($disease_detail) && !empty($disease_detail)){

                //药品
                $disease_detail['medicine_arr'] = array();
                if (isset($disease_detail['medicine']) && !empty($disease_detail['medicine'])){
                    $medicine_arr = preg_split('/\s+/', $disease_detail['medicine']);
                    if (!empty($medicine_arr)){
                        foreach ($medicine_arr as $key => $value){
                            $temp = trim($value);
                            if (empty($temp)){
                                unset($medicine_arr[$key]);
                            }
                        }
                        $disease_detail['medicine_arr'] = array_slice($medicine_arr, 0, 4);
                    }
                }
                $disease = array_merge($disease_basic, $disease_detail);
            }
        }
        return $disease;
    }
	
	
	/**
	 * 得到指定 id 下疾病的相关药品
	 * @author gaoqing
	 * 2015年9月1日
	 * @param int $diseaseID 疾病id
	 * @return array 疾病的相关药品
	 */
	public function getDrugArr($diseaseID){
		$drugArr = array();
		
		/*
		 * 1、根据 $diseaseID 查询 9939_disease_content 中的症状 $drugIDStr
		 * 2、将 $drugIDStr 拆分成数组 $drugIDArr
		 * 3、根据 $drugIDArr 查询 9939_yaopin 中的 ypId, ypName, ypPic, ypUrl 
		*/
		
		//1、根据 $diseaseID 查询 9939_disease_content 中的症状 $drugIDStr
		$sql = $this->getSQL(true, " yaopin ", " AND contentid = ? ", null, null, null, "9939_disease_content");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($diseaseID));
		$tempArr = $statement->fetch(PDO::FETCH_ASSOC);
		
		$drugIDStr = $tempArr['yaopin'];
		
		if (!empty($drugIDStr)) {
				
			//2、将 $drugIDStr 拆分成数组 $drugIDArr
			$drugIDArr = array();
			$tempDrugIDArr = explode(",", $drugIDStr);
			foreach ($tempDrugIDArr as $drugIDVal){
				$temp = trim($drugIDVal);
				if (!empty($temp)) {
					$drugIDArr[] = $temp;
				}
			}
			
			if (!empty($drugIDArr)) {
				//得到药品 id 对应的药品集
				$this->getDrugsByID($drugArr, $drugIDArr );
			}

		}
		return $drugArr;		
	}
	/**
	 * 根据药品的 id ，获取所有对应的药品
	 * @author gaoqing
	 * 2015年9月9日
	 * @param array $drugArr 药品数据集
	 * @param array $drugIDArr 药品的 id集
	 * @return void 空 
	 */
	 private function getDrugsByID(&$drugArr, $drugIDArr) {
	 	$param = implode(",", $drugIDArr);
	 	
		//3、根据 $drugIDArr 查询 9939_yaopin 中的 ypId, ypName, ypPic, ypUrl 
		$sql = $this->getSQL(true, " ypId, ypName, ypPic, ypUrl ", " AND contentid in (". $param .") AND ypStatus = 1  ", 0, 4, " ORDER BY ypPrice DESC ", "9939_yaopin");
		$statement = $this->_db->prepare($sql);
		$statement->execute();
		
		while ($tempYaoPin = $statement->fetch(PDO::FETCH_ASSOC)) {
			$tempYaoPin['ypShortName'] = $this->cutString($tempYaoPin['ypName'], 5, 1);
			$tempYaoPin['ypPic'] = "http://www.9939.com/" . $tempYaoPin['ypPic'];
			
			$drugArr[] = $tempYaoPin;
		} 
	}

	
	/**
	 * 得到指定 id 下疾病的相关症状
	 * @author gaoqing
	 * 2015年9月1日
	 * @param int $diseaseID 疾病id
	 * @return array 疾病的相关症状
	 */
	public function getSymptomArr($diseaseID){
		$symptomArr = array();
		
		/*
		 * 1、根据 $diseaseID 查询 9939_disease_content 中的症状 $symptomIDStr
		 * 2、将 $symptomIDStr 拆分成数组 $symptomIDArr
		 * 3、根据 $symptomIDArr 查询 9939_dzjb 中的 title, content_id 
		 */
		
		//1、根据 $diseaseID 查询 9939_disease_content 中的症状 $symptomIDStr
		$sql = $this->getSQL(true, " zhengzhuang ", " AND contentid = ? ", null, null, null, "9939_disease_content");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($diseaseID));
		$tempArr = $statement->fetch(PDO::FETCH_ASSOC);
		
		$symptomIDStr = $tempArr['zhengzhuang'];
		
		if (!empty($symptomIDStr)) {
			
			//2、将 $symptomIDStr 拆分成数组 $symptomIDArr
			$symptomIDArr = array();
			$tempSymptomIDArr = explode(",", $symptomIDStr);
			foreach ($tempSymptomIDArr as $symptomIDVal){
				$temp = trim($symptomIDVal);
				if (!empty($temp)) {
					$symptomIDArr[] = $temp;
				}
			}
			
			//3、根据 $symptomIDArr 查询 9939_dzjb 中的 title, content_id 
			$sql = $this->getSQL(true, " title, contentid ", " AND contentid in (?) AND type = 2 ");
			$statement = $this->_db->prepare($sql);
			$param = implode(",", $symptomIDArr);
			$statement->execute(array($param));
			$symptomArr = $statement->fetchAll(PDO::FETCH_ASSOC);
		}
		return $symptomArr;
	}
	
	/**
	 * 得到指定 id 下 疾病的基本信息
	 * @author gaoqing
	 * 2015年9月1日
	 * @param int $diseaseID 疾病id
	 * @return array 疾病的基本信息
	 */
	public function getDiseaseBasicInfoArr($diseaseID) {
		$diseaseBasicInfoArr = array();
		
		$sql = $this->getSQL(true, " title, thumb, description ", " AND contentid = ? AND type in (1,2) ", null, null, " ORDER BY type ASC ");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array($diseaseID));
		while ($diseaseBasicInfo = $statement->fetch(PDO::FETCH_ASSOC)) {
			$initDescription = ltrim($diseaseBasicInfo['description'], "　");
			
			$diseaseBasicInfo['thumb'] = "http://www.9939.com/" . $diseaseBasicInfo['thumb'];
			$diseaseBasicInfo['description'] = $initDescription;
			$diseaseBasicInfo['simpleDesc'] = $this->cutString($initDescription, 25, 1);
			
			$diseaseBasicInfoArr = $diseaseBasicInfo;
		}
		//处理：当没有查到数据时：
		if (empty($diseaseBasicInfoArr)) {
			$diseaseBasicInfoArr['title'] = "";
			$diseaseBasicInfoArr['thumb'] = "";
			$diseaseBasicInfoArr['description'] = "";
			$diseaseBasicInfoArr['simpleDesc'] = "";
		}
		return $diseaseBasicInfoArr;
	}
	
	/**
	 * 根据疾病名称，获取疾病的 ID
	 * @author gaoqing
	 * 2015年9月08日
	 * @param string $diseaseName 疾病名称
	 * @return array 常见疾病数据集
	 */
	public function getDiseaseIDByName($diseaseName) {
		$diseaseID = 0;
		
		if (!empty($diseaseName)) {
			
			$sql = $this->getSQL(false, " contentid ", " AND title = ? AND type in (1,2) ", 0, 1, "  ORDER BY type ASC ");
			$statement = $this->_db->prepare($sql);
			$statement->execute(array($diseaseName));
			$temp = $statement->fetch(PDO::FETCH_ASSOC);
			
			if (!empty($temp)) {
				$diseaseID = $temp['contentid'];
			}
			if (empty($diseaseID)) {
				$diseaseID = $this->getDiseaseIDByLikeName($diseaseName);
			}
		}
		return $diseaseID;
	}
	
	/**
	 * 根据疾病名称，mohuchaxun 获取疾病的 ID
	 * @author gaoqing
	 * 2015年9月16日
	 * @param string $diseaseName 疾病名称
	 * @return array 常见疾病数据集
	 */
	public function getDiseaseIDByLikeName($diseaseName) {
		$diseaseID = 0;
	
		if (!empty($diseaseName)) {
			$sql = $this->getSQL(false, " contentid ", " AND title like ? AND type in (1,2) ", 0, 1, "  ORDER BY type ASC ");
			$statement = $this->_db->prepare($sql);
			
			//拆分疾病名称
			$splitDiseaseNameArr = $this->splitStringUTF8($diseaseName);
			$diseaseName = implode("%", $splitDiseaseNameArr);
			
			$statement->execute(array("%". $diseaseName ."%"));
			$temp = $statement->fetch(PDO::FETCH_ASSOC);
				
			if (!empty($temp)) {
				$diseaseID = $temp['contentid'];
			}
		}
		return $diseaseID;
	}
	
	/**
	 * 拆分字符串
	 * @author gaoqing
	 * 2015-09-16
	 * @param string $str 初始字符串
	 * @return array 拆分后的字符串数组
	 */
	function splitStringUTF8($str) {
		$split = 1;
		$array = array ();
	
		for($i=0; $i<strlen($str); ){
			$value = ord ( $str [$i] );
			if ($value > 127) {
				if ($value >= 192 && $value <= 223)
					$split = 2;
				elseif ($value >= 224 && $value <= 239)
				$split = 3;
				elseif ($value >= 240 && $value <= 247)
				$split = 4;
			} else {
				$split = 1;
			}
			$key = NULL;
			for($j = 0; $j < $split; $j ++, $i ++) {
				$key .= $str [$i];
			}
			array_push ( $array, $key );
		}
		return $array;
	}
	
	
	/**
	 * 根据搜索的关键词，得到其所对应的所有疾病数
	 * @author gaoqing
	 * 2015年8月31日
	 * @param string $searchWords 搜索词
	 * @return int 所有疾病数
	 */
	public function getDiseaseCountByKeywords($searchWords){
		$diseaseCount = 0;
		
		$sql = $this->getSQL(true, " COUNT(*) ", " AND type in(1, 2) AND title LIKE ? ");
		$statement = $this->_db->prepare($sql);
		$statement->execute(array("%". $searchWords ."%"));
		$diseaseCountArr = $statement->fetch(PDO::FETCH_NUM);
		
		$diseaseCount = $diseaseCountArr[0];
		
		return $diseaseCount;
	}
	
	/**
	 * 根据搜索的关键词，得到其所对应的所有疾病
	 * @author gaoqing
	 * 2015年8月31日
	 * @param string $searchWords 搜索词
	 * @param int $start 分页的开始位置
	 * @param int $pageSize 每页显示的信息数
	 * @return array 搜索词对应的疾病集
	 */
	public function getDiseasesByKeywords($searchWords, $start, $pageSize) {
		$diseaseArr = array();
		
		/*
		 * 1、设置好分页相关的值
		 * 2、得到数据库连接对象及相应的 statement 对象
		 * 3、查询，得到结果集
		 */
		
		//1、设置好分页相关的值
		$sql = $this->getSQL(false,
							" contentid, title, description, inputtime ", 
							" AND type in(1, 2) AND title LIKE ? ", 
							$start,
							$pageSize
				);
		//2、得到数据库连接对象及相应的 statement 对象
		$statement = $this->_db->prepare($sql);
		$statement->execute(array("%". $searchWords ."%"));
		
		//3、查询，得到结果集
		while ($disease = $statement->fetch(PDO::FETCH_ASSOC)) {
			
			$initDescription = ltrim($disease['description'], "　");
			$disease['description'] = $this->cutString($initDescription, 65, 1);
			$disease['inputtime'] = date("Y-m-d H:i", $disease['inputtime']);
			
			$diseaseArr[] = $disease;
		}
		
		return $diseaseArr;
	}
	
	/**
	 * 得到查询的 SQL 语句
	 * @author gaoqing
	 * 2015年8月31日
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
				$dbName = "9939_dzjb") 
	{
		$sql = "";
	
		//查询字段
		$selectFieldStr = empty($selectField) ? " * " : $selectField ;
	
		//查询条件
		$baseWhere = ($dbName == "9939_dzjb" ? " WHERE status = 99  " : " WHERE 1 = 1 ");
		$whereStr = empty($where) ? $baseWhere : $baseWhere . $where ;
		
		$defaultOrderStr = " ";
		if (!$isSimple) {
			$defaultOrderStr = " ORDER BY contentid ";
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
	
	
	
	/**
	 * 疾病列表
	 *	
	 * @param 从第几条记录开始 $iStartNo
	 * @param 条数 $iNum
	 * @param 所属类别 $iCID 
	 * @param 标题长度 $iTitleLen
	 * @param 简介长度 $iIntroLen
	 * @param 条件 $sWhere	 
	 * @param 排序 $sOrder
	 * @param 需要显示的字段 $sNeedField 	 	 
	 * @param 状态 $status	 
	 * @return array
	 */
	public function getlist($iStartNo,$iNum,$iSection=0,$iTitleLen=0,$sWhere="",$sOrder="",$sNeedField="",$iStatus='99'){
	    $sBasicField = "a.contentid,a.title, a.url ";
		$sNeedField = $sNeedField ? $sNeedField.",".$sBasicField : $sBasicField;
							
		$sBasicOrder = " a.contentid desc";
		$sOrder = ($sOrder) ? $sOrder : $sBasicOrder;
		
		$sWhere = ($sWhere) ? $sWhere : 1;		
		$sWhere .= ($iStatus == -1) ? "" : " AND a.status='$iStatus'";			
		$sWhere .= ($iSection > 0) ? " AND b.keshi like'%$iSection%'" : "";
		
		$sLimit = ($iNum >0) ? "LIMIT $iStartNo,$iNum" : "";
		$sSQL = "SELECT $sNeedField FROM 9939_dzjb a, 9939_disease_content b where a.contentid=b.contentid and a.type='1'  and $sWhere ORDER BY $sOrder $sLimit";	
		$result	= $this->_db->fetchAll($sSQL);
        for($i=0; $i<count($result); $i++)
		{		
			$result[$i]['newTitle'] =  ($iTitleLen > 0) ? mb_substr($result[$i]['title'],0, $iTitleLen,'utf-8') : $result[$i]['title'];					
		}
        return $result;
	}
    /**
     * 获取热门疾病,多发疾病
     * 
     * */
    public function getjb($sValue){
        if($sValue){
            $sSQL = "select contentid,url,title from 9939_dzjb where contentid=".$sValue;
            $result	= $this->_db->fetchAll($sSQL);
            for($i=0; $i<count($result); $i++)
            {
                $result[$i]['newTitle'] = mb_substr($result[$i]['title'],0,6);
            }
      		return $result[0];
        }
    }
    /**
     * 获取某条疾病详情
     * 
     * */
    public function getjbDetails($where){
        if($where){
            $sSQL = "SELECT * FROM 9939_dzjb a,9939_disease_content b WHERE $where";
            $result	= $this->_db->fetchAll($sSQL);
      		return $result;
        }
    }
    public function getjbDetail($where){
        if($where){
            //$sSQL = "SELECT a.title,a.contentid,a.description,b.content FROM 9939_dzjb a,9939_disease_content b WHERE $where";
            $sSQL = "SELECT a.title,a.contentid FROM 9939_dzjb a,9939_disease_content b WHERE $where";
            $result	= $this->_db->fetchAll($sSQL);
      		return $result;
        }
    }
    public function getjbcount($where){
        if($where){
            $sSQL = "SELECT count(a.contentid) FROM 9939_dzjb a,9939_disease_content b WHERE $where";
            $result	= $this->_db->fetchOne($sSQL);
      		return $result;
        }
    }
     /**
     * 获取就诊科室
     * 
     * */
    public function getsectionkeshi($id){
        if($id){
            $sSQL = "SELECT name FROM 9939_section_category  WHERE id=$id";
            $result	= $this->_db->fetchOne($sSQL);
      		return $result;
        }
    }
    /**
     * 获取所属部位
     * 
     * */
    public function getbuwei($id){
        if($id){
            $sSQL = "SELECT name FROM 9939_buwei_category  WHERE id=$id";
            $result	= $this->_db->fetchOne($sSQL);
      		return $result;
        }
    }
	
}