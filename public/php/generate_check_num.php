<?php
//header("Content-Type:text/html;charset=utf-8");

require_once 'ValidateCode.php';

$validateCode = new ValidateCode(92, 37, 4);

//生成验证码
$validateCode->showImg();

//得到验证码
$check_num = $validateCode->getCaptcha();

//将数据写到 json 文件中
$data = '{"check_num": "'. $check_num .'"}';
$filename = "check_num.json";
file_put_contents($filename, $data);



?>