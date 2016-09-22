<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>全部科室列表_ 久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="全部科室,科室列表" />
<meta name="description" content="久久问医为您提供各类科室的问答,包括内科,外科,妇科,男科,儿科,不孕不育,五官,整形,传染,肿瘤,心理,中医,药品等科室问题,有疑惑上久久问医." />
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
<script src="/js/page.js"></script>

</head>


<body class="bodb">
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">科室列表</h2>
	
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
		<a href="javascript:" title = "更多科室">更多科室</a>
	</nav>

    <article class="sead">
        <input type="text" id = "searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id = "searchBtn"></a>
    </article>

	<article class="know adv">
		<{include file="ads/ads_moreDepartment_01.html"}>
	</article>
	
	<div class="thre"></div>

	<section class="doct">
		<ul class="sympt">
		
			<{if count($allDepartmentArr) != 0 }>
				<{foreach $allDepartmentArr as $key => $allDepartment}>
					<li><a class="cont"><{$allDepartment.father.name}></a>
					<dl>
							<{foreach $allDepartment.child as $childKey => $child}>
								<dd>
									<a href="/classid/<{$child.id}>.html" title = "<{$child.name}>" ><{$child.name}></a>
								</dd>
							<{/foreach}>
						</dl>
					</li>
				<{/foreach}>
			<{/if}>
		</ul>
	</section>

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
