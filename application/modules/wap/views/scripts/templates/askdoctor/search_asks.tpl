<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$searchWords}>搜索结果_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="<{$searchWords}>的问题推荐、<{$searchWords}>的相关推荐、<{$searchWords}>的问题集合,久久问医" />
<meta name="description" content="久久问医为您提供关于<{$searchWords}>的问题推荐、<{$searchWords}>的相关推荐、<{$searchWords}>的问题集合,久久问医" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/page.js"></script>

</head>


<body class="bodb">
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">
        <{if isset($qlx_ads) && !empty($qlx_ads)}>
        <{$qlx_ads}>
        <{/if}>
        <{$searchWords}>
    </h2>
	
	<!-- 右侧快捷按钮 Start -->
	<div class="hd-right">
		<div class="personal">
			<a href="javascript:;" class="personal-btn"></a>
		</div>
     <!--ends-->   
	</div>
</article>
<{include file="navigation/fast_navigation_ask.html"}>
<!-- 右侧快捷按钮 End -->	
	
	<div class="blahe" style = "height: 0.12em;" ></div>
	
	<nav>
		<a href="http://m.9939.com" title = "首页">首页</a>>
		<a href="http://wapask.9939.com" title = "问医">问医</a>>
		<a href="http://wapask.9939.com/department/list.html" title = "疾病科室">疾病科室</a>>
		<a href="javascript:"><{$searchWords}></a>
	</nav>

    <article class="sead">
        <input type="text" id="searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id="searchBtn"></a>
    </article>
	
	<article>
		<{include file="ads/ads_detailDisease_01.html"}>
	</article>
	
	<div class="thre"></div>
	<article class="arnav">
		<span><{$searchWords}></span>相关问题<{$askCount}>个
        <input type="hidden" value="<{$askCount}>" id="ask_count" />
	</article>
	
	<div id = "fatherHTMLID">
        <ul class="lopre">
            <{foreach from = $askAndAnswerArr item = askAndAnswer key = key}>
            <li>
                <h3>
                    <a href = "/id/<{$askAndAnswer.ask.id}>.html" style="color: #333;" ><{$askAndAnswer.ask.title}></a>
                </h3>
                <div class="care">
                    <p><{$askAndAnswer.answer.content}><a href = "/id/<{$askAndAnswer.ask.id}>.html" ><span style="color:#00B489;" >详情</span></a></p>
                </div>
                <div class="agree">
                    <span class="sp_02"><{$askAndAnswer.doctor.doc_keshi}></span>
                    <span class="sp_03"><{$askAndAnswer.doctor.nickname}></span>
                    <span class="sp_04"><{$askAndAnswer.ask.answernum}>个回答</span>
                </div>
            </li>

            <{if $key eq 1 || $key eq 4 || $key eq 6 }>
            <li>
                <{include file="ads/ads_detailDisease_02.html"}>
            </li>
            <{/if}>
            <{/foreach}>
        </ul>
        <article class="paget">
            <{$pageHTML}>
        </article>
	</div>
	
	<!--底部部分 Start-->
	<{include file="footer/ask_doctor_footer.html"}>
	<!--底部部分 End-->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->
	
	<script type="text/javascript">
		$(document).ready(function(){
			
			//设置 搜索 部分的 a 的 href 值
			$("#searchBtn").on('click', function(){
				searchWords = $("#searchWords").val();
				
				$(this).attr("href", "/search/" + encodeURI(searchWords) + "/1");
			});
		});
	</script>
	
	<script src="/js/sea.js"></script>
	<script type="text/javascript">
		seajs.use("play.js");
	</script>	
	
</body>
</html>
