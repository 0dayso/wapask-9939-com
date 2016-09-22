<?php
/**
 * insertSdaData.php
 * @author 黄云龙 2010-10-26
 * 10827 -- 10840
 */
header("Content-type:text/html;charset=utf-8");
$basepath = dirname(dirname(__FILE__));
$config_path = $basepath . DIRECTORY_SEPARATOR . "config/config.php";
//var_dump($config_path);exit;
require $config_path;
App_Model_KeyWords::createCacheRandWords(array('typeid' => array(0,1)));