<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>部位症状</title>
	<meta name="description" content="页面描述" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta content="telephone=no" name="format-detection">
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link rel="stylesheet" type="text/css" href="/css/index.css">
        <link rel="stylesheet" type="text/css" href="/css/other.css">
</head>
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd personal-hd">
        <a href="/" class="c_logo">首页</a>
		<h2 class="main-hd-bt"><{$buwei}>症状</h2>
        <div class="hd-right">
			<!--6.1 修改-->
			<div class="personal">
				<a href="javascript:;" class="personal-btn"><img src="/images/f_sym.png"></a>
			</div>
         <!--ends-->
		</div>
  </header>
  <!--6.1 修改-->
  <!--右上角快速导航 开始-->
   <{include file="navigation/fast_navigation.html"}>
  <!--右上角快速导航 结束-->
	<!-- header ends -->
	<!-- 内容 stars-->
	<div class="main-bd">
		<div class="pfzz-w pdlf25">
			<h1 class="pfzz-tit"><{$buwei}>症状</h1>
			<ul class="pfzz-lists cfx">
                <{if $result_zz}>
                    <{foreach from=$result_zz item=symptom}>
    				    <li><a href="/Symptom/details/?id=<{$symptom.contentid}>"><{$symptom.title}></a></li>
                    <{/foreach}> 
                <{/if}>  
			</ul>
		</div>
	</div>
	<!-- 内容ends-->
	<!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</div>
</body>
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript">
    seajs.use("play.js")
</script>
</html>