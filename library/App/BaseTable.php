<?php
/**
 * 基础表，可以在此完成一些公共类，供继承词类的类使用
 * @author Helei
 *
 */

//require_once __ROOT__.'/library/App/Config.php';

class App_BaseTable extends Zend_Db_Table {
	
	/**
	 * 截取字符串
	 * @author gaoqing
	 * 2015年8月31日
	 * @param string $initStr 被截取的字符串
	 * @param int $cutLen 截取的长度
	 * @param int $appendFlag 是否追加 " ... " 标识（0：不追加；1：追加）
	 * @return string 截取后的字符串
	 */
	protected function cutString($initStr, $cutLen, $appendFlag = 0) {
		$cutStr = "";
		
		if (isset($initStr) && !empty($initStr)) {
			
			//得到被截取字符串的长度
			$initStrLen = mb_strlen($initStr, 'utf-8');
			
			//被截取字符串长度 < 指定截取数
			if ($initStrLen < $cutLen) {
				$cutStr = $initStr;
			
			//被截取字符串长度 > 指定截取数	
			}else {
				if ($appendFlag == 1) {
					$tempStr = mb_substr($initStr, 0, $cutLen, 'utf-8');
					$cutStr = $tempStr . "...";
				}else {
					$cutStr = mb_substr($initStr, 0, $cutLen, 'utf-8');
				}
			}
		}
		return $cutStr;
	}

}

?>