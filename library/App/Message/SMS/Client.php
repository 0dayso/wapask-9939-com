<?php

class App_Message_SMS_Client {
    
    /*
     * 配置的键值
     * (漫道) WSSDK:webservice发送 HSSDK:httpservice发送; (名商通) MSTSDK:
     * 
     */
    private static $cfg_key = 'MSTSDK';
    
    /*
     * 短信实例
     */
    private static function sms(){
        $config_name = "SMS_".self::$cfg_key."_CONFIG";
        $class_name = "App_Message_SMS_".self::$cfg_key;
        $config = App_Message_SMS_Config::${$config_name};
        return new $class_name($config);
    }
    /**
      * 发送模板短信
      * @param to 手机号码集合,用英文逗号分开
      * @param $data 内容数据 
      * @param $sendtime 发送时间;unix时间戳：0表示接到即发送
      * @param $tplid 模板Id
      */
    public static function send($to,$data,$sendtime=0,$tplid=0, $content = ''){
        $sdk = self::sms();
        if (empty($content)){
            $content = "您正在进行手机验证，验证码是：". $data ."，请在60秒内完成验证，谢谢！\n";
        }
        $sdk = $sdk->mobile($to)->content($content)->times($sendtime);
        $result = $sdk->send();
        return $result;
    }
    
}
