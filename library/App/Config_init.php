<?php

require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

$params = array (
    'host'     => '192.168.220.185',
    'username' => '9939_com_dzjb',
    'password' => 'dzjb!(&20101008new$%^',
    'dbname'   => '9939_com_dzjb',
	'charset'  => 'utf8'
);

$db = Zend_Db::factory('PDO_MYSQL', $params);
Zend_Db_Table::setDefaultAdapter($db);

$params_zx = array (
    'host'     => '192.168.220.185',
    'username' => '9939_com_v2',
    'password' => 'newslihge#$%&sineweqw',
    'dbname'   => '9939_com_v2',
	'charset'  => 'utf8'
);
$dbzx = Zend_Db::factory('PDO_MYSQL', $params_zx);
$GLOBALS['dbzx']=$dbzx;

$params_wd = array (
    'host'     => '192.168.220.189',
    'username' => '9939_com_v2sns',
    'password' => 'snsrewou#*&#inewk',
    'dbname'   => '9939_com_v2sns',
	'charset'  => 'utf8'
);
$dbwd = Zend_Db::factory('PDO_MYSQL', $params_wd);
$GLOBALS['dbwd']=$dbwd;