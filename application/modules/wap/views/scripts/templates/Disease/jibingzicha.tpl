<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>疾病自查</title>
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
<!-- head -->
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd personal-hd">
   		 <a href="/" class="j_logo"><img src="/images/jjlo.png"></a>
		<h2 class="main-hd-bt">疾病自查</h2>
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
	<!-- 主内容 stars -->
	<section class="main-bd">
		<!-- jibing-zc start -->
		<div class="jibing-zc">
            <!--
			<p class="j-zc-top pdlf25">
				共收录疾病25690个
			</p>
			<div class="jibing-search">
				<div class="main-searchbox jsearchbox">
					<form action="">
						<input type="submit" class="sch-btn" value="搜疾病">
						<div class="sch-txt-box">
							<input type="text" value="" placeholder="请输入疾病名称" class="sch-txt">
							<span class="sch-bg"></span>
						</div>
					<form action="">
				</div>
			</div>
            -->
			<h3 class="reply-bt reply-btbg mt24">
				人群常见疾病
			</h3>
			<div class="j-count pdlf25">
				<dl>
					<dt>男 MAN</dt>
					<dd>
						<ul class="cfx">
                        <{foreach from=$aDisease1 item=aDisease}>
							<li><a href="/jb/<{$aDisease.contentid}>.shtml"><{$aDisease.newTitle}></a></li>
                        <{/foreach}>
						</ul>
					</dd>
				</dl>
				<dl>
					<dt>女 WOMAN</dt>
					<dd>
						<ul class="cfx">
                        <{foreach from=$aDisease2 item=aDisease}>
							<li><a href="/jb/<{$aDisease.contentid}>.shtml"><{$aDisease.newTitle}></a></li>
                        <{/foreach}>
						</ul>
					</dd>
				</dl>
				<dl>
					<dt>老 ELDER</dt>
					<dd>
						<ul class="cfx">
						<{foreach from=$aDisease3 item=aDisease}>
							<li><a href="/jb/<{$aDisease.contentid}>.shtml"><{$aDisease.newTitle}></a></li>
                        <{/foreach}>
						</ul>
					</dd>
				</dl>
				<dl>
					<dt>幼 CHILD</dt>
					<dd>
						<ul class="cfx">
						<{foreach from=$aDisease4 item=aDisease}>
							<li><a href="/jb/<{$aDisease.contentid}>.shtml"><{$aDisease.newTitle}></a></li>
                        <{/foreach}>
						</ul>
					</dd>
				</dl>
				<dl class="d-tab">
					<dt>
						<ol class="cfx tab-hd">
							<li class="current"><a href="javascript:;">热门疾病</a></li>
							<li><a href="javascript:;">多发疾病</a></li>
						</ol>
					</dt>
					<dd class="tab-bd">
						<ul class="cfx" style="display:block;">
                        <{foreach from=$getHot item=getHots}>
                            <{if $getHots.contentid!=''}>
					           <li><a href="/jb/<{$getHots.contentid}>.shtml"><{$getHots.newTitle}></a></li>
                            <{/if}>
                        <{/foreach}>
						</ul>
						<ul class="cfx">
                        <{foreach from=$getMultiple item=getMultiples}>
                            <{if $getMultiples.contentid!=''}>
					           <li><a href="/jb/<{$getMultiples.contentid}>.shtml"><{$getMultiples.newTitle}></a></li>
                            <{/if}>
                        <{/foreach}>
						</ul>
					</dd>
				</dl>
			</div>
			<h3 class="reply-bt reply-btbg">按字母查询</h3>
			<div class="select-letter cfx mt24">
				<ul>
					<li class="current">
                    <a href="/jb/letter/?capital=A">A</a></li>
					<li><a href="/jb/letter/?capital=B">B</a></li>
					<li><a href="/jb/letter/?capital=C">C</a></li>
					<li><a href="/jb/letter/?capital=D">D</a></li>
					<li><a href="/jb/letter/?capital=E">E</a></li>
					<li><a href="/jb/letter/?capital=F">F</a></li>
					<li><a href="/jb/letter/?capital=G">G</a></li>
					<li><a href="/jb/letter/?capital=H">H</a></li>
					<li><a href="/jb/letter/?capital=I">I</a></li>
					<li><a href="/jb/letter/?capital=J">J</a></li>
					<li><a href="/jb/letter/?capital=K">K</a></li>
					<li><a href="/jb/letter/?capital=L">L</a></li>
					<li><a href="/jb/letter/?capital=M">M</a></li>
					<li><a href="/jb/letter/?capital=N">N</a></li>
					<li><a href="/jb/letter/?capital=O">O</a></li>
					<li><a href="/jb/letter/?capital=P">P</a></li>
					<li><a href="/jb/letter/?capital=Q">Q</a></li>
					<li><a href="/jb/letter/?capital=R">R</a></li>
					<li><a href="/jb/letter/?capital=S">S</a></li>
					<li><a href="/jb/letter/?capital=T">T</a></li>
					<li><a href="/jb/letter/?capital=U">U</a></li>
					<li><a href="/jb/letter/?capital=V">V</a></li>
					<li><a href="/jb/letter/?capital=W">W</a></li>
					<li><a href="/jb/letter/?capital=X">X</a></li>
					<li><a href="/jb/letter/?capital=Y">Y</a></li>
					<li><a href="/jb/letter/?capital=Z">Z</a></li>
				</ul>
			</div>
		</div>
		<!-- jibing-zc end -->
	</section>
	<!-- 主内容 ends -->
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