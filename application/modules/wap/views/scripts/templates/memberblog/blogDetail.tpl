<!doctype html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>日志详细信息</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="description" content="页面描述" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/page.js"></script>
    <{include file="ads/ads_against_covered.html"}>
</head>


<body>
<article class="actit">
	<a href="javascript: window.history.go(-1);"></a>
	<span><{$detailBlog.subject}></span>
</article>

<div class="blahe"></div>

<section class="arti">
	<article class="bocon">
        <h1><{$detailBlog.subject}></h1>
        <aside>发布于<{$detailBlog.relatedtime}></aside>
        <{$detailBlog.message}>
        
        <!-- 隐藏参数的部分 Start -->
        <input type = "hidden" id = "uid" value = "<{$doctorid}>" />
        <input type = "hidden" id = "blogid" value = "<{$blogid}>" />
        <!-- 隐藏参数的部分 End -->
      
      <!-- 广告位部分 Start -->  
     <div>
     	<{include file="ads/ads_blogDetail_01.html"}>
     </div>
      <!-- 广告位部分 End -->  
      
     <!-- 分享部分 Start -->   
    <div class="share"><div class="bdsharebuttonbox"><span class="sha">分享到：</span><a href="#" class="bds_weixin" data-cmd="weixin" id="wex"></a><a href="#" class="bds_tqq" data-cmd="tqq" id="tqq"></a><a href="#" class="bds_tsina" data-cmd="tsina" id="tsin"></a><a href="#" class="bds_qzone" data-cmd="qzone" id="qzon"></a></div>
	<script type="text/javascript">
	window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":""},"share":{},"image":{"viewList":["qzone","tsina","tqq","weixin"],"viewText":"分享到：","viewSize":""},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
	</script>
    </div>
     <!-- 分享部分 Start -->   

</article>
</section>

<!-- ajax 分页 部分 Start -->
<div id = "fatherHTMLID"></div>
<!-- ajax 分页 部分 End -->

	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->	
	
	<script type="text/javascript">
		$(document).ready(function(){
			//异步分页操作
			$.ajax({
				  url: "/memberblog/detailpage?uid=" + $("#uid").val() + "&blogid=" + $("#blogid").val(),
				  cache: false, 
				  success: function(html){
				  		//将得到的信息，添加到 n3Tab33ContentDep 下面
				  		$("#fatherHTMLID").html(html);
				  }
			});
		
			
		});
	</script>	
	
</body>
</html>
