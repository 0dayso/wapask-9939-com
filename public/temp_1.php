<?php

$str2 = <<<PHP_EOL
<div class="w_article">
				<!--概述-->
				<h3>概 述<i></i></h3>
				<p class="w_articlep1">
由于长期的喝酒，我的大伯患上了脂肪肝，他自己从来不注意，结果最近吃不下饭，去检查，发现已经成了肝硬化了，大家都劝他要平时多注意，我还为他找了一些肝硬化患者的

注意事项，希望他能够及时照着做，赶快好起来。
</p>
				
								<span id="tu_jingyan" class="w_imgspan"><img alt="肝硬化的居家注意事宜" src="upload/jkjy_13753536044705.jpg" onload="AutoResizeImage(450,300,this);"></span>
				

				<!--步骤-->
																<p class="w_articlep2"><i>1</i>
戒酒，这是我告诉大伯的第一项最重要的，因为我看的资料说，得了肝硬化的，如果执意还是喝酒的话，那么可能很快肝脏功能就不行了，甚至生存率都达不到5年，如果戒酒的

话，会好的多的。

 
</p>												<p class="w_articlep2"><i>2</i>不能吃辛辣的食物，我特别在家里监督他，因为我们家里的人，真的是嗜辣如命的，每顿饭都想吃辣椒，可是吃辣椒之类的话，却会使肝脏的损伤的更加厉害，降低生存率的，所

以为了他着想，我们都不吃辣椒，并且我还特别在旁边监督他。
</p>												<p class="w_articlep2"><i>3</i>以前他喝酒的时候，基本不怎么吃饭的，现在我们也是着重的对他的饮食进行了调整，每天都保持他能够吃一些蔬菜水果，每天一盒奶，医生说，这样的话，可以保证他需要的营

养物质，这样对肝脏功能的恢复是有好处的。
</p>												<!--注意事项-->
								<h3 class="w_articleh2">注意事项：<i></i></h3>
				<p class="w_articlep2 w_articlep3"><i></i>
平时病人也注意保持良好的心情，不能过度劳累，注意发生肝硬化的并发症。</p>
PHP_EOL;

$content = array('desc' => '', 'content' => array(), 'tip' => '');

//概述：
$descMatch = matchDatas('/\<p\s*class\=\s*\"w_articlep1\"\>[\s\S]*?\<\/p\>/', $str2);
if(isset($descMatch[0]) && !empty($descMatch[0])){
    $content['desc'] = mfilter($descMatch[0][0]);
}

//概述：
$contentMatch = matchDatas('/\<p\s*class\=\s*\"w_articlep2\"\>[\s\S]*?\<\/p\>/', $str2);
if (isset($contentMatch[0]) && !empty($contentMatch[0])){
    $mcontent = array();
    foreach ($contentMatch[0] as $cval){
        $mcontent[] = mfilter($cval, true, '/\d{1,2}/', '');
    }
    $content['content'] = $mcontent;
}

//注意事项：
$tipMatch = matchDatas('/\<p\s*class\=\s*\".*w_articlep3\"\>[\s\S]*?\<\/p\>/', $str2);
if (isset($tipMatch[0]) && !empty($tipMatch[0])){
    $content['tip'] = mfilter($tipMatch[0][0]);
}

function mfilter($subject, $isfilter = false, $pattern = '//', $replacement = ''){
    $filtered = strip_tags($subject);
    if ($isfilter){
        $filtered = preg_replace($pattern, $replacement, $filtered);
    }
    return trim($filtered);
}

function matchDatas($pattern, $subject){
    $match = array();
    preg_match_all($pattern, $subject, $match);
    return $match;
}




