<!doctype html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>我的提问_久久问医</title>

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
    <link rel="stylesheet" type="text/css" href="/css/other.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/gundong.js"></script>
<script src="/js/page.js"></script>
    <script src="/js/top_nav.js"></script>

</head>


<body>
	<!--header-->
	<header class="myque">
		<a href="http://m.9939.com"></a>
		<a href="javascript:" title = "我的提问" >我的提问</a>
        <div class="hd-right">
            <div class="personal">
                <a href="javascript:;" class="personal-btn"></a>
            </div>
        </div>
	</header>
    <{include file="navigation/fast_navigation_ask.html"}>
	<!--ends-->
	<div class="blahe"></div>

	<ul class="reply">
		<{if count($userAskArr) != 0 }>
			<{foreach $userAskArr as $userAskKey => $userAsk}>
				<li>
					<a href="/user/asks/<{$userAsk.id}>/<{$userid}>">
						<h2><{$userAsk.title}></h2>
						<p>
							<span><{if $userAsk.answernum == 0 }>暂无回复<{/if}><{if $userAsk.answernum != 0 }><{$userAsk.answernum}> 个回复<{/if}></span>
							<span><{$userAsk.status}></span>
							<span><{$userAsk.ctime}></span>
						</p>
					</a>
				</li>
			<{/foreach}>
			
			<{else}>
				<li>暂无提问！</li>
		<{/if}>
		
	</ul>

	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->

</body>
</html>
