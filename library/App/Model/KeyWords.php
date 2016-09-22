<?php

/**
 *
 * ==============================================
 * @Desc :   关键词
 * ==============================================
 */
class App_Model_KeyWords extends QModels_Ask_Table {

    protected $_name = "keywords";
    protected $_primary = 'id';

    /**
     * 查看文章
     *
     * @param 条件
     * @return 文章信息 array
     */
    public function List_All($where = '1', $order = '', $count = '', $offset = '') {
        $result = $this->fetchAll($where, $order, $count, $offset);
        return $result->toArray();
    }

    public function List_ByIds($wdids = array()) {
        if (count($wdids) == 0) {
            return false;
        }
        $ids = implode(',', $wdids);
        $sql = "select id,keywords,pinyin,pinyin_initial,typeid from keywords where id in ($ids) order by id desc";
        $result = $this->db_v2sns_read->fetchAll($sql);
        return $result;
    }
    /**
     * 
     * @param string $where
     * @param string $order
     * @param int $count
     * @param int $offset
     * @return array
     * 例如:EXPLAIN
     * SELECT * FROM keywords WHERE  pinyin_initial='A' and typeid in (2,3)  and  id >=(
     * SELECT id FROM keywords where pinyin_initial='A' and typeid in (2,3)  
     * ORDER BY id asc limit 600,1
     * ) ORDER BY id asc limit 0,200;
     * 
     */
    public function list_forpaging($where = '', $order = 'id desc', $count = 0, $offset = 0) {
        $sql = 'select id,keywords,pinyin,pinyin_initial,typeid from keywords';
        if (!empty($where)) {
            $sql.=' where ' . $where;
        }
        if(!empty($order)){
            $sql.=' order by '.$order;
        }
        if($count>0){
            $sql.=" limit $offset,$count";
        }
        $result = $this->db_v2sns_read->fetchAll($sql);
        $total = $this->GetCount($where);
        return array('list'=>$result,'total'=>$total);
    }

    public function list_one($id) {
        $where = $this->_primary . '=' . intval($id);
        $sql = 'SELECT * FROM `' . $this->_name . '` WHERE ' . $where;

        $result = $this->db_v2sns_read->fetchRow($sql); //获取一行
        return $result;
    }

    public function getKeywordName($value) {
        $where = " `pinyin` = '" . $value . "'";
        $sql = 'SELECT `keywords` FROM `' . $this->_name . '` WHERE ' . $where;
        $result = $this->db_v2sns_read->fetchRow($sql); //获取一行
        return $result;
    }

    //获取数据总和
    public function GetCount($where = '') {
        $sql = 'SELECT count(' . $this->_primary . ') as num FROM `' . $this->_name . '`';
        if (!empty($where)) {
            $sql.=' WHERE ' . $where;
        }
        $result = $this->db_v2sns_read->fetchRow($sql);
        return $result['num'];
    }

    public static function createCacheRandWords(array $condition = array(),$expired=24){
        $return_pagenum_list = array();
        $save_root_path = 'rand_words';
        $rand_words_save_path = $save_root_path.DIRECTORY_SEPARATOR.'caches/randwords';
        //拼音首字母页码
        $cache_key_letter_pagenum = 'pagenum';
        $pagenum_expired = 2 * $expired;
        $cache_letter_pagenum_data = QLib_Cache_Client::getCache($rand_words_save_path, $cache_key_letter_pagenum, $pagenum_expired);
        if ($cache_letter_pagenum_data) {
            $return_pagenum_list = $cache_letter_pagenum_data;
        }
        $letter_list = 'abcdefghijklmnopqrstuvwxyz';
        $len = strlen($letter_list);
        $return_list = array();
        $max_kw_length = 100; // $size;
        for ($i = 0; $i < $len; $i++) {
            $wd = strtoupper($letter_list{$i});
            $pagenum = isset($return_pagenum_list[$wd]) ? $return_pagenum_list[$wd] : 0;
            $pagenum = intval($pagenum) + 1;
            $tmp_offset = $pagenum * $max_kw_length;
            $return_info = App_Model_Search::search_words_byinitial($wd, $tmp_offset, $max_kw_length, $condition);
            if (count($return_info['list']) == 0 && $pagenum > 0) {
                $return_info = App_Model_Search::search_words_byinitial($wd, 0, $max_kw_length, $condition);
                $pagenum = 0;
            }
            $ret = $return_info['list'];
            $return_list[$wd] = $ret;
            $return_pagenum_list[$wd] = $pagenum;
        }
        QLib_Cache_Client::setCache($rand_words_save_path, 'words',$return_list, $expired);
        QLib_Cache_Client::setCache($rand_words_save_path, $cache_key_letter_pagenum, $return_pagenum_list, $pagenum_expired);
        return $return_list;
    }

    /**
     * 
     * 获取随机关键词
     * @param type $size
     * @param array $condition 
     *  $conditions = array(
      'column_id' => array(1)
      );
     * @return type
     */
    public static function getCacheRandWords($size = 100, array $condition = array()) {
        $expired = 24; //小时
        $save_root_path = 'rand_words';
        $cache_key = sprintf('%s|%s|%s', 'caches', 'randwords', 'words');
        //生成的缓存文件为24小时，由crontab：createcacherandwords.php控制缓存更新,此处缓存文件永不过期
        $data = QLib_Cache_Client::getPageCache($save_root_path, $cache_key, $expired*2);
        if ($data) {
            return $data;
        } else {
            $return_list = self::createCacheRandWords($condition, $expired);
            return $return_list;
        }
    }

    
}
