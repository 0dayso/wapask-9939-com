<?php
/**
**潘红晶 
* 日期 2015年5月
**/
class CategoryurlController extends Q_Controller_Smarty{
	var $_categoryurl_obj					= null;
    function init(){
		parent::init();
		$this->initView();
		
		$this->_categoryurl_obj			= new App_Model_Categoryurl();
	}
	function indexAction(){
	    if(file_exists(__ROOT__."/public/cat_11.txt")){
            unlink(__ROOT__."/public/cat_11.txt");
        }
	    $cate=Array(0=>'2791',1=>'1979',2=>'11470',3=>'2464',4=>'1808',5=>'1836',6=>'11411',7=>'11430',8=>'2711',9=>'2094',10=>'2280',11=>'1947',12=>'9687',13=>'2388',14=>'2711',15=>'11430',16=>'2388',17=>'2224',18=>'2266',19=>'9456',20=>'9552',21=>'10936',22=>'9782',23=>'11161',24=>'11135',25=>'10819',26=>'10797',27=>'11003',28=>'10249',29=>'9785',30=>'11037',31=>'10820',32=>'11091',33=>'9783',34=>'10976',35=>'9780',36=>'10896',37=>'10916',38=>'9788',39=>'11169',40=>'9789',41=>'9784',42=>'11066',43=>'10236',44=>'9776',45=>'9790',46=>'9787',47=>'11334',48=>'11277',49=>'9786',50=>'11364');
        foreach($cate as $k1 => $v1){
    	    $where=" catid=".$v1;
            $result=$this->_categoryurl_obj->getcategory($where);
            foreach($result as $k => $v){
                $catidarry = array_filter(explode(',',$v['arrchildid']));
                $arrchildid=$v['arrchildid'];
                if($k1==0){
                    file_put_contents(__ROOT__."/public/cat_11.txt",$arrchildid,FILE_APPEND);
                }else{
                    file_put_contents(__ROOT__."/public/cat_11.txt",",".$arrchildid,FILE_APPEND);
                }
                foreach($catidarry as $key => $val){
                    if($val!=$v['catid']){
                        $wheres=" catid in (".$val.")";
                        $catidall=$this->_categoryurl_obj->getcategory($wheres);
                        foreach($catidall as $keys => $vals){
                            $catdirs[$v['catdir']][$key-1]['parentdir'] =$v['catdir'];
                            $catdirs[$v['catdir']][$key-1]['catdir'] =$vals['catdir'];
                            $catdirs[$v['catdir']][$key-1]['catid'] =$vals['catid'];
                            /*$wherecat=" catdir='".$vals['catdir']."'";
                            $results=$this->_categoryurl_obj->getcategory($wherecat);
                            if(count($results)>1){
                                print_r($results);
                                
                            }*/
                            //$catdirs[$v['catdir']][$key-1]['url'] =$vals['url'];
                            //$catdirs[$v['catdir']][$key-1]['catname'] =$vals['catname'];
                            
                        }
                    }
                }              
            }
        }
        $catdirs=serialize($catdirs);
        file_put_contents(__ROOT__."/public/cat_44.txt",$catdirs); 
        if(file_exists(__ROOT__."/public/cat_44.txt")){
            echo "生成成功";
            //echo "\n";
            //echo __ROOT__."/public/cat_44.txt";
            //echo "\n";
            //echo file_get_contents(__ROOT__."/public/cat_44.txt");
           // die;
        /*if(file_exists(__ROOT__."/public/cat_44.txt")){
            $catdirs=file_get_contents(__ROOT__."/public/cat_44.txt");
        }
        if($catdirs) {
            $catdirs_arry=unserialize($catdirs);
        }
        print_r($catdirs_arry);
        exit;*/
        }else{
            echo "生成失败";
        }      
	}
	
}