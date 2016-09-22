<!doctype html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$departmentName}>_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="<{$departmentName}>,久久问医" />
<meta name="description" content="久久问医<{$departmentName}>科室向您提供全面的<{$departmentName}>方面问答内容，主要包括<{$departmentName}>疾病症状、预防、保健、治疗、诊断、用药等方面的问题及在线医生解答." />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<link rel="canonical" href="http://ask.9939.com/classid/<{$classid}>-all-<{$currpage}>" >

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
        <{$departmentName}>
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
		<a href="javascript:" title = "<{$departmentName}>"><{$departmentName}></a>
	</nav>
    <article class="sead">
        <input type="text" id = "searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id = "searchBtn"></a>
    </article>
	
	<article>
		<{include file="ads/ads_twoLevel_01.html"}>
	</article>
	
	<div class="thre"></div>

	<section class="doct">
		<ul class="sympt uniqu">
			<li><a class="cont"><{$departmentName}></a>
				<dl>
						<{if count($childArr) != 0 }>
							<{foreach $childArr as $key => $child }>
								<dd>
									<a href="/disease/<{$child.id}>.html"><{$child.name}></a>
								</dd>
							<{/foreach }>					
						<{/if}>
				</dl>
			</li>
		</ul>
	</section>

	<article class="arnav">
		<span><{$departmentName}></span>相关问题<{$askCount}>个
	</article>
	<ul class="lopre">
		
		<{foreach from = $askAndAnswerArr item = askAndAnswer key = key}>
			<li>
				<h3>
					<a href = "/id/<{$askAndAnswer.ask.id}>.html" style="color:#333;" ><{$askAndAnswer.ask.title}></a>
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
		<{/foreach}>		
	</ul>
	<article class="paget">
		<{$pageHTML}>
	</article>

	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->	
	
	<script>
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
