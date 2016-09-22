<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$searchWords}>搜索结果_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="description" content="页面描述" />
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
	<h2 class="main-hd-bt">搜索详情</h2>
	
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

    <article class="sead">
        <input type="text" id = "searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id = "searchBtn"></a>
    </article>

	<article class="arnav">
		共搜索到<{$diseaseCount}>条<span><{$searchWords}></span>的相关信息
	</article>

    <{if !empty($diseaseCount) }>
        <ul class="lopre sneep">

            <{foreach from = $diseaseArr item = diseaseVal key = key}>
            <li>
                <h3>
                    <span><{$diseaseVal.title}></span>
                </h3>
                <div class="snom">
                    <p>
                        <{$diseaseVal.description}>
                    </p>
                        <span>
                            <{$diseaseVal.inputtime}>
                            <a href="/disease/<{$diseaseVal.diseaseID}>.html">详情</a>
                        </span>
                </div>
            </li>
            <{/foreach}>
        </ul>

        <article class="paget">
            <{$pageHTML}>
        </article>
    <{/if}>

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
