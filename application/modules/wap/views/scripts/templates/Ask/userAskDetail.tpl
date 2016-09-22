<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$askInfo.title}></title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="description" content="页面描述" />
<meta
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
	name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/gundong.js"></script>
<script src="/js/page.js"></script>

</head>


<body>
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">回复详情</h2>
	
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

	<article class="whafi">
		<h2>
			<span><{$askInfo.answernum}>人回复</span><{$askInfo.title}>
		</h2>
		<p>
			<span>提问于：<{$askInfo.ctime}></span><{$askInfo.sexnn}> <{if $askInfo.age != 0}><{$askInfo.age}>岁<{/if}> 
		</p>
		<p><{$askInfo.content}></p>
		
		<{if isset($askInfo.help) && !empty($askInfo.help) }>
			<div style = "height: 20px;"></div>
			<div style = "height: 30px; font-size: 20px; color:#999; ">想要得到的帮助：</div><p><{$askInfo.help}></p>
		<{/if}>
		
	</article>

	<h3 class="reask">所有回答</h3>
	<ul class="beshad">
		<{if count($answerInfo) == 0 }>
		暂无！
		<{/if}>
		<{if count($answerInfo) != 0 }>
			<{foreach $answerInfo as $tempkey => $answerVal }>
				<li>
					<p><{$answerVal.answer.best}></p>
					<p>
						<{$answerVal.doctor.truename}><span><{$answerVal.doctor.zhicheng}></span>
					</p>
					<p><{$answerVal.doctor.doc_hos}> <{$answerVal.doctor.doc_keshi}></p>
					<p>
						<span>病情分析：</span><{$answerVal.answer.content}>
					</p>
					
					<{if isset($answerVal.answer.suggest) && !empty($answerVal.answer.suggest) }>
						<div style = "height: 10px;"></div>
						<p style="font-size:.95em;line-height: 1.5em;color: #585858;"> 
							<b style="line-height: 1.5em;color: #FF9B00;" >指导意见：</b> 
							<{$answerVal.answer.suggest}>
						</p>
					<{/if}>
					
					<p><{$answerVal.answer.addtime}></p>
				</li>
			<{/foreach}>
		<{/if}>
	</ul>

	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->
	
	<script src="/js/sea.js"></script>
	<script type="text/javascript">
		seajs.use("play.js");
	</script>

</body>
</html>
