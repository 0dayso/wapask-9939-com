<?php

$str = <<<PHP_EOL
                <dl>
                    <dt><strong><span>概述</span></strong></dt>
                    <dd><p>龟头炎症状怎么办是男性比较关心的问题，龟头粘膜的炎症称龟头炎，龟头炎对男性有着非常大的危害，所以得了疾病一定要及时的治疗，关于龟头炎症状怎么办一定要认真对待。</p></dd>
                </dl>
                
                <dl class="steps">
                    <dt><strong><span>龟头炎症状</span></strong></dt>
                                <dd>
                                    <div class="st">1</div>
                                    <p>首先，很多人误认为性病而误诊，当出现此病时，多数患者认为是性病，自用外用消毒消炎的清洁剂，这样局部皮肤受到强烈的化学刺激出现红肿、渗出加剧了炎症反应，最终可形成慢性包皮龟头炎。而且也有些诊疗技术不佳的医生，或者因利益因素故意当作性病诊疗，给患者身体和经济上造成很大的伤害。</p>
                                        <p>
                                            <img src="upload/49723.jpg" alt="" width="400" />
                                        </p>
                                </dd>
                                <dd>
                                    <div class="st">2</div>
                                    <p>然后，现在很多医生还在使用不规范的传统疗法，临床上不规范的诊疗使得病情反复发作，同时由于此病的病程长，药品的不规范使用和滥用，病菌容易产生耐药性等，使得传统的诊疗达不到理想的效果，长期慢性炎症对泌尿生殖健康造成影响，出现前列腺炎，阳痿早泄等疾病。
</p>
                                </dd>
                                <dd>
                                    <div class="st">3</div>
                                    <p>其次，西药以消炎杀菌为主，滴虫性包皮龟头炎的治疗首选灭滴灵，每服0.2g，每日3次，连用10天。对于白色念珠菌引起的包皮龟头炎的治疗常用曲古霉素或伊曲康唑治疗。中医认为此症因肝经湿热、郁火结聚龟头所致。以阴茎龟头紫肿、疼痛、化脓、溃烂为主要表现的痈病类症状。  </p>
                                </dd>

                </dl>
                
                <dl>
                    <dt><strong><span>注意事项</span></strong></dt>
                    <dd><p>如果发现自己有了龟头炎症状，一定要及时看医生，听从医嘱，毕竟医生是专业人士，还要好好休息，加强锻炼。</p></dd>
                </dl>
PHP_EOL;

$match = array();

$pattern = '/\<dl\s*(class\s*\=\s*"steps")?\s*\>[\s\S]*?\<\/dl\>/';

preg_match_all($pattern, $str, $match);

$content = array('desc' => '', 'content' => array(), 'tip' => '');
if (isset($match[0]) && !empty($match[0]) ){

    $matchContent = $match[0];

    //概述：
    if (!empty($matchContent[0])){
        $content['desc'] = mfilter('/概述/', '', $matchContent[0]);
    }
    //内容：
    if (isset($matchContent[1]) && !empty($matchContent[1])){
        $content['content'] = handleMainContent($matchContent[1]);
    }
    //注意事项：
    if (isset($matchContent[2]) && !empty($matchContent[2])){
        $content['tip'] = mfilter('/注意事项/', '', $matchContent[2]);
    }
}

function handleMainContent($mainContent){
    $mcontent = array();

    $mpattern = '/\<dd\>[\s\S]*?\<\/dd\>/';
    $mmatch = array();
    preg_match_all($mpattern, $mainContent, $mmatch);

    if (isset($mmatch[0]) && !empty($mmatch[0])){
        foreach ($mmatch[0] as $cval){
            $mcontent[] = mfilter('/\d{1,2}/', '', $cval);
        }
    }
    return $mcontent;
}

function mfilter($pattern, $replacement, $subject){
    $filtered = strip_tags($subject);
    $filtered = preg_replace($pattern, $replacement, $filtered);
    return trim($filtered);
}

print_r($content);










