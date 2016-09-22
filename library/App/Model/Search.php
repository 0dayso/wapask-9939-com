<?php

/**
 * 
 * 搜索索引名称
 * index_9939_com_v2_keywords   
 * index_9939_com_v2_keywords_all
 * index_9939_com_v2_art
 * index_9939_com_dzjb_art
 * index_9939_com_dzjb_disease
 * index_9939_com_jb_art //新疾病库
 * index_9939_com_jb_disease //新疾病库
 * index_9939_com_jb_symptom //新疾病库
 * index_wd_ask
 * index_wd_ask_history_1
 * index_wd_ask_history_2
 * index_wd_ask_history_3
 * index_wd_ask_history_4
 * index_wd_ask_history_5
 * index_wd_ask_history_6
 * 
 */
class App_Model_Search {

    /*
     *  $conditions = array(
      'column_id' => array(1)
      );
     * typeid 1:问答词 2:资讯词
     */

    public static function search_words_byinitial($wd, $offset, $size, array $condition = array()) {
        $total = 0;
        $ret_list = array();
        if (!empty($wd)) {
            $wd_obj = new App_Model_KeyWords();
            $where_arr = array();
            $where_arr[] = sprintf("%s='%s'", 'pinyin_initial', $wd);
            foreach ($condition as $k => $v) {
                if (is_array($v)) {
                    $search_ids = implode(',', $v);
                    $where_arr[] = " $k in ($search_ids)";
                }
            }
            $where = implode(' and ', $where_arr);
            $search_result = $wd_obj->list_forpaging($where, 'id desc', $size, $offset);
            $ret_list = $search_result['list'];
            $total = $search_result['total'];
        }
        return array('list' => $ret_list, 'total' => $total);
    }

    /*
     *  $conditions = array(
      'column_id' => array(1)
      );
     * typeid 1:问答词 2:资讯词
     */

    public static function search_words_all($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $search_result = QLib_Utils_SearchHelper::Search($wd, 'index_9939_com_v2_keywords_all', $offset, $size, $condition, $explainflag, $explain_ext_config);
            if (!empty($search_result['matches'])) {
                $arr_ids = array();
                $wd_obj = new App_Model_KeyWords();
                foreach ($search_result['matches'] as $k => $v) {
                    $arr_ids[] = $k;
                }
                $ret_list = $wd_obj->List_ByIds($arr_ids);
                $total = $search_result['total'];
            }
            $explain_words = $search_result['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }
    
    /*
     * 查询老疾病文章
     */

    public static function search_dzjb_article($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $ret = QLib_Utils_SearchHelper::Search($wd, 'index_9939_com_dzjb_art', $offset, $size, $condition, $explainflag, $explain_ext_config);
            $art_obj = new App_Model_Article();
            if (!empty($ret['matches'])) {
                $arr_ids = array();
                foreach ($ret['matches'] as $k => $v) {
                    $arr_ids[] = $k;
                }
                $disease_list = $art_obj->List_DiseaseArticleByIds($arr_ids);
                if ($disease_list) {
                    foreach ($disease_list as $k => $v) {
                        $v['tmp_source_id']=2;
                        $date_path = date('Y/md',$v['inputtime']);
                        $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                        $v['url'] = $article_path;
                        $v['url'] = 'http://jb.9939.com/' . $v['url'];
                        $ret_list[] = $v;
                    }
                }
                $total = $ret['total'];
            }
            $explain_words = $ret['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }

    /*
     * 查询疾病文章
     */

    public static function search_jb_article($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $ret = QLib_Utils_SearchHelper::Search($wd, 'index_9939_com_jb_art', $offset, $size, $condition, $explainflag, $explain_ext_config);
            $art_obj = new App_Model_Article();
            if (!empty($ret['matches'])) {
                $arr_ids = array();
                foreach ($ret['matches'] as $k => $v) {
                    $arr_ids[] = $k;
                }
                $disease_list = $art_obj->List_DiseaseArticleByIds($arr_ids);
                if ($disease_list) {
                    foreach ($disease_list as $k => $v) {
                        $v['tmp_source_id']=2;
                        $date_path = date('Y/md',$v['inputtime']);
                        $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                        $v['url'] = sprintf('%s/%s', 'http://jb.9939.com', $article_path);
                        $ret_list[] = $v;
                    }
                }
                $total = $ret['total'];
            }
            $explain_words = $ret['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }

    /*
     * 查询资讯文章
     */

    public static function search_zx_article($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $ret = QLib_Utils_SearchHelper::Search($wd, 'index_9939_com_v2_art', $offset, $size, $condition, $explainflag, $explain_ext_config);
            $art_obj = new App_Model_Article();
            if (!empty($ret['matches'])) {
                $arr_ids = array();
                foreach ($ret['matches'] as $k => $v) {
                    $arr_ids[] = $k;
                }
                $disease_list = $art_obj->List_ArticleByIds($arr_ids);
                if ($disease_list) {
                    foreach ($disease_list as $k => $v) {
                        $v['tmp_source_id']=1;
                        $v['url'] = $v['url'];
                        $ret_list[] = $v;
                    }
                }
                $total = $ret['total'];
            }
            $explain_words = $ret['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }

    /*
     * 查询词相关文章；优先疾病文章,然后资讯文章
     */

    public static function search_relarticle($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $return_list = self::search_jb_article($wd, $offset, $size, $condition, $explainflag, $explain_ext_config);
            $ret_list = $return_list['list'];
            $total = $return_list['total'];
            $diff_num = $size - count($ret_list);
            if ($diff_num > 0) {
                $return_art_list = self::search_zx_article($wd, $offset, $diff_num, $condition, $explainflag, $explain_ext_config);
                $art_list = $return_art_list['list'];
                $art_total = $return_art_list['total'];
                if ($art_total > 0) {
                    foreach ($art_list as $k => $v) {
                        $v['url'] = $v['url'];
                        $ret_list[] = $v;
                    }
                }
                $total+=$art_total;
            }
            $explain_words = $return_list['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }

    public static function search_article($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ret_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $ret = QLib_Utils_SearchHelper::Search($wd, 'index_9939_com_dzjb_art,index_9939_com_v2_art', $offset, $size, $condition, $explainflag, $explain_ext_config);
            $art_obj = new App_Model_Article();
            if (!empty($ret['matches'])) {
                $zx_art_ids = array();
                $jb_art_ids = array();
                foreach ($ret['matches'] as $k => $v) {
                    $attr = $v['attrs'];
                    if ($attr['tmp_source_id'] == 1) {
                        $zx_art_ids[] = $k;
                    } else {
                        $jb_art_ids[] = $k;
                    }
                }
                if (count($zx_art_ids) > 0) {
                    $disease_list = $art_obj->List_ArticleByIds($zx_art_ids);
                    if ($disease_list) {
                        foreach ($disease_list as $k => $v) {
                            $v['tmp_source_id']=1;
                            $v['url'] = $v['url'];
                            $ret_list[] = $v;
                        }
                    }
                }
                if (count($jb_art_ids) > 0) {
                    $disease_list = $art_obj->List_DiseaseArticleByIds($jb_art_ids);
                    if ($disease_list) {
                        foreach ($disease_list as $k => $v) {
                            $v['tmp_source_id']=2;
                            $date_path = date('Y/md',$v['inputtime']);
                            $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                            $v['url'] = $article_path;
                            $v['url'] = 'http://jb.9939.com/' . $v['url'];
                            $ret_list[] = $v;
                        }
                    }
                }
                $total = $ret['total'];
            }
            $explain_words = $ret['explain_words'];
        }
        return array('list' => $ret_list, 'total' => $total, 'explain_words' => $explain_words);
    }

    /*
     * 查询词相关问答
     */

    public static function search_ask($wd, $offset, $size, array $condition = array(), $explainflag = 1, $explain_ext_config = array()) {
        $total = 0;
        $ask_res_list = array();
        $explain_words = array($wd);
        if (!empty($wd)) {
            $ret = QLib_Utils_SearchHelper::Search($wd, 'index_wd_ask,index_wd_ask_history_1,index_wd_ask_history_2,index_wd_ask_history_3,index_wd_ask_history_4,index_wd_ask_history_5,index_wd_ask_history_6,index_wd_ask_history_7', $offset, $size, $condition, $explainflag, $explain_ext_config);
            $ret_list = array();
            $ask_obj = new App_Model_Ask();
            $answer_obj = new App_Model_Answer();
            if (!empty($ret['matches'])) {
                foreach ($ret['matches'] as $k => $v) {
                    $r = $ask_obj->list_one($k);
                    if (count($r) > 0) {
                        $ret_list[] = $r;
                    }
                }
                if (!empty($ret_list)) {
                    foreach ($ret_list as $key => $value) {
                    	$dealVal = self::dealData($value, $wd);
                    	$id = isset($dealVal['id']) ? $dealVal['id'] : 0;
                        $ask_res_list[$key]['ask'] = $dealVal;
                        $answer_list = $answer_obj->getbyaskid(intval($id));
                        $len = count($answer_list);
                        if ($len > 0) {
                             $ask_res_list[$key]['answer'] = !empty($answer_list[0])?QLib_Utils_String::cutString(strip_tags($answer_list[0]['content'],''), 45):'';
                            
                            //医生信息：
                            $ask_res_list[$key]['doctor'] = array();
                            $userid = empty($answer_list[0]) ? 0 : $answer_list[0]['userid'];
                            
                            if (!empty($userid)) {
	                            $doctor = $ask_obj->getDoctorByUid($userid);
	                            $ask_res_list[$key]['doctor'] = isset($doctor) && !empty($doctor) ? $doctor[$userid] : array();
                            }
                        }
                    }
                }
                $total = $ret['total'];
            }
            $explain_words = $ret['explain_words'];
        }
        return array('list' => $ask_res_list, 'total' => $total, 'explain_words' => $explain_words);
    }
    
    /**
     * 得到处理后的相应信息
     * @author gaoqing
     * 2015年12月14日
     * @param array $val 初始值
     * @return void 空
     */
    private static function dealData(&$val, $wd) {
    	$title = $val['title'];
    	$short_title  = QLib_Utils_String::cutString($title, 20);
    	$short_title = str_replace($wd, '<font>'.$wd.'</font>', $short_title);
    	$content = QLib_Utils_String::cutString(strip_tags($val['content'],''), 45);
    	$url = "http://wapask.9939.com/id/".$val['id'] . ".html";
    	
    	$val['short_title'] = $short_title;
    	$val['short_content'] = $content;
    	$val['url'] = $url;
    	
    	return $val;
    }

}
