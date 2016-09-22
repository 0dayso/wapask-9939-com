<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>经验分享_健康经验分享_久久问医_久久健康网</title>
<meta name="keywords" content="经验分享,健康经验分享" />
<meta name="description" content="久久健康经验是帮助网友找到实际生活中有关健康方面怎么办、怎么做一类问题的可借鉴经验，聚集了就医看病、疾病管理、疾病预防、生活保健等健康方面的经验，找健康经验就上久久问医." />
<meta name="mobile-agent" content="format=html5;url=http://ask.9939.com/jingyan/" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="stylesheet" type="text/css" href="/css/exp.css">
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/exp/detail.js"></script>
<!--slide滚动-->
    <script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
    <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
    <script type="text/javascript" src="/js/exp/slide.js"></script>
<!--ends-->
</head>
<body>
    <header><a href="http://m.9939.com/"><h1 class="久久健康网"></h1></a><a class="clna"></a></header>
<!--导航栏展开-->
<{include file="navigation/fast_navigation_experience.html"}>
<!--ends-->
<article class="selay"><form class="focon" action="" method="post"><input type="text" placeholder="搜索疾病、症状"><a>搜索</a></form><a href="http://wapask.9939.com/ask/goAskDoctor">免费问医</a></article>
<article class="nav">
    <a href="/jingyan/" class="curst">首  页</a>
    <a class="eper">经验分享</a>
    <a href="/jingyan/shareing/share/">我要分享</a>
    <a href="/jingyan/shareing/meshare/">我的经验</a>
			<!--经验分享弹出-->
    <article class="exsha disn">
        <a href='/expcat/0/'>常见疾病</a>
        <a href='/expcat/1/'>生活保健</a>
        <a href='/expcat/2/'>两性健康</a>
        <a href='/expcat/3/'>整形美容</a>
    </article>
</article>


<div class="clear"></div>
<div class="main_visual">
	<div class="flicking_con">
		<a href="#">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
        <a href="#">4</a>
	</div>
	<div class="main_image">
		<ul>
                    <{foreach from=$zx_ads item=ads key=key}>
                        <{if $ads.imageurl neq ""}>
                            <li><a href="<{$ads.linkurl}>"><span class="img_3"><img src="<{$ads.imageurl}>"  width="100%" alt="<{$ads.adsname}>"><p><span><{$ads.adsname}></span><span><em><{$key +1}></em>/4</span></p></span></a></li>
                        <{else}>
                            <li><a href="<{$ads.linkurl}>"><span class="img_3"><p><span><{$ads.adsname}></span><span><em>1</em>/4</span></p></span></a></li>
                        <{/if}>
                    <{/foreach}>  
		</ul>
        <a href="javascript:void(0);" id="btn_prev"></a>
		<a href="javascript:void(0);" id="btn_next"></a>
	</div>
</div>
<article class="health">
    <{foreach from=$plateData item=data }>
    <a href="/exp/<{$data.addtime}><{$data.id}>.html"><h3><{$data.title}></h3><p class="hte_01">建议：<{$data.content|truncate:50}></p><p class="hte_02"><span class="sh_01"><{$data.addtime|date_format:'%Y-%m-%d'}></span><span class="sh_02">分享者：<{$data.username}></span><span class="sh_03"><{if $data.plateid=='0'}>常见疾病<{elseif $data.plateid=='1'}>生活保健<{elseif $data.plateid=='2'}>两性健康<{else}>整形美容<{/if}></span></p></a>
    <{/foreach}>
</article>
<div class="advin">
    <{include file="ads/ads_exp_content_list_top.html"}>
</div>
<div class="thre"></div>
<div class="main_v">
	<div class="flicking_c">
            <a href="#" class="on">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
	</div>
	<div class="main_i">
		<ul>
                    <li>
                        <{foreach from=$ask_list['生活百科'] item='shbk'}>
                        <div class="banl_01 fl"><a href="/id/<{$shbk.id}>.html"><h3><{$shbk.title}></h3><p>建议：<{$shbk.content|truncate:20}></p><div><span>生活百科</span><b>久久问医</b></div></a></div>
                        <{/foreach}>
                    </li>
                    <li>
                        <{foreach from=$ask_list['两性健康'] item='lxjk'}>
                            <div class="banl_01 fl"><a href="/id/<{$shbk.id}>.html"><h3><{$lxjk.title}></h3><p>建议：<{$lxjk.content|truncate:20}></p><div><span>两性健康</span><b>久久问医</b></div></a></div>
                        <{/foreach}>
                    </li>
                    <li>
                        <{foreach from=$ask_list['常见疾病'] item='cjjb'}>
                            <div class="banl_01 fl"><a href="/id/<{$shbk.id}>.html"><h3><{$cjjb.title}></h3><p>建议：<{$cjjb.content|truncate:20}></p><div><span>常见疾病</span><b>久久问医</b></div></a></div>
                        <{/foreach}>
                    </li>
                    <li>
                        <{foreach from=$ask_list['整形美容'] item='zxmr'}>
                            <div class="banl_01 fl"><a href="/id/<{$shbk.id}>.html"><h3><{$zxmr.title}></h3><p>建议：<{$zxmr.content|truncate:20}></p><div><span>整形美容</span><b>久久问医</b></div></a></div>
                        <{/foreach}>
                    </li>
		</ul>
        <a href="javascript:void(0);" id="btn_p"></a>
		<a href="javascript:void(0);" id="btn_n"></a>
	</div>
</div>
<div class="thre"></div>
<article class="exname"><div class="expin"><a href=""><img src="/images/logre.png" alt=""></a><p>专家与您一对一答疑</p><p><span>免费提问</span>及时解答</p></div></article>
<div class="thre"></div>
<article class="health">
    <{foreach from = $article_list item=list}>
    <a href="/exp/<{$list.addtime}><{$list.id}>.html"><h3><{$list.title}></h3><p class="hte_01">建议：<{$list.content|truncate:50}></p><p class="hte_02"><span class="sh_01"><{$list.addtime|date_format:'%Y-%m-%d'}></span><span class="sh_02">分享者：<{$list.username}></span><span class="sh_03"><{if $list.plateid=='0'}>常见疾病<{elseif $list.plateid=='1'}>生活保健<{elseif $list.plateid=='2'}>两性健康<{else}>整形美容<{/if}></span></p></a>
    <{/foreach}>
</article>

<{include file="footer/exp_footer.html"}>

<!-- 统计功能 Start -->
<{include file="ads/wap_ask_stat.html"}>
<!-- 统计功能 End -->
</body>
</html>
