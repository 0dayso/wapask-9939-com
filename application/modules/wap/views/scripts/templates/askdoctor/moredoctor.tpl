<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>在线咨询医生_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="久久问医,在线咨询医生,在线问医生" />
<meta name="description" content="久久问医为您提供全面的名医团队,名医在线咨询平台,实现在线咨询医生,在线问医生的疾病问答平台." />
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
<script src="/js/gundong.js"></script>
<script src="/js/page.js"></script>

</head>


<body class="bodb">
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">科室医生</h2>
	
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
	
	
	<!-- 主内容部分 Start -->
	<div class="blahe" style = "height: 0.12em;" ></div>
	<nav>
		<a href="http://m.9939.com" title = "首页">首页</a>>
		<a href="http://wapask.9939.com" title = "问医">问医</a>>
		<a href="javascript:" title = "科室医生">科室医生</a>
	</nav>
    <article class="sead">
        <input type="text" id = "searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id = "searchBtn"></a>
    </article>
	<article class="total">
		<a onClick="divTag('n3Tab33', 'indexahover', '', 1, 0)" name="n3Tab33"
			id="n3Tab33" class="indexahover">全部科室</a><a
			onClick="divTag('n3Tab33', 'indexahover', '', 2, 0)" name="n3Tab33"
			id="n3Tab33">全部地区</a>
	</article>
	
	<section name="n3Tab33Content" id="n3Tab33ContentDep">
		<{foreach $allDepartmentDoctorArr.doctor as $allDepartmentDoctor}>
			<article class="doctor docbo hospi">
				<div>
					<img src="<{$allDepartmentDoctor.pic}>" alt="<{$allDepartmentDoctor.truename}>" title = "<{$allDepartmentDoctor.truename}>"  width = 85 height = 85 >
				</div>
				<div class="clid">
					<p>
						<span><{$allDepartmentDoctor.truename}></span><{$allDepartmentDoctor.zhicheng}>
					</p>
					<p>擅长：<{$allDepartmentDoctor.best_dis}></p>
				</div>
				<a href="/ask/doctor/<{$allDepartmentDoctor.uid}>" class="refer">向TA提问</a>
			</article>
		<{/foreach}>
	
		<article class="finmo shmor">
			<a href="javascript:" id="showMoreDepartment">显示更多医生</a>
		</article>		
	</section>
	
	
	<div id = "fatherHTMLID">
	</div>
	<!-- 主内容部分 End -->


	<!--底部部分 Start-->
	<{include file="footer/ask_doctor_footer.html"}>
	<!--底部部分 End-->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->	

	<script type="text/javascript" language="javascript">
		
		//设置 搜索 部分的 a 的 href 值
		$("#searchBtn").on('click', function(){
			searchWords = $("#searchWords").val();
			
			$(this).attr("href", "/search/" + encodeURI(searchWords) + "/1");
		});
		
		//异步分页操作
		$.ajax({
			  url: "/doctor/moredoctorarea?from=2" ,
			  cache: false, 
			  success: function(html){
			  		//将得到的信息，添加到 n3Tab33ContentDep 下面
			  		$("#fatherHTMLID").html(html);
			  }
		});
		
		$("#showMoreDepartment").click(function(){
			$.ajax({
				  url: "/doctor/showmoredoctorpage?from=1&currentPage=2",
				  cache: false, 
				  success: function(html){
				  		//将得到的信息，添加到 n3Tab33ContentDep 下面
				  		$("#n3Tab33ContentDep").html(html);
				  }
			});
		});
		
	</script>
	
	<script src="/js/sea.js"></script>
	<script type="text/javascript">
		seajs.use("play.js");
	</script>	
</body>
</html>
