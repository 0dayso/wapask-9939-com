<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><{$metaTitle}>_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="<{$metaKeywords}>咨询,<{$metaKeywords}>相关问题，<{$metaKeywords}>精彩问答" />
<meta name="description" content="久久问医为您解答关于<{$metaKeywords}>相关问题，<{$metaKeywords}>精彩问答. <{$metaKeywords}>咨询就上久久问医！" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="canonical" href="http://ask.9939.com/hot/" >
<link rel="stylesheet" type="text/css" href="/css/hot.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/js/top_nav.js"></script>

</head>


<body>
   <header>
   	<a href="http://m.9939.com/"></a>
   	<a href="javascript:">问医热搜</a>
   	<a href="javascript:" class="personal-btn"></a>
   </header>
   		
        <!--弹出 开始-->
        <{include file="navigation/fast_navigation_ask.html"}>
       <!--弹出 结束-->
       
       
      <div class="breaw"><a href="http://m.9939.com/" title = "久久首页">久久首页</a>&nbsp;>&nbsp;<a href="http://wapask.9939.com/hot/" title = "问医热搜">问医热搜</a></div>
        <!--字母开始-->
          <article class="letbox">
                <div class="lett-tab-con">
              		   <{foreach $list as $character => $datas}> 
                          <div switc-ass="<{$character}>" class="lett-tab-<{$character}> hotwords <{if $character != 'A' }>curro<{/if}> ">
                          		
                          		<{foreach $datas as $key => $data }>
                          		<a href="<{$data.url}>" title="<{$data.keywords}>"><{$data.short_name}></a>
                          		<{/foreach}>
                          </div>
              		   <{/foreach}>
                   </div>
                   
                <div class="letter-switch">
                	<{foreach $list as $character => $datas}> 
                	<a switc="<{$character}>" title = "<{$character}>" href="#" class="currm <{if $character == 'A' }>move<{/if}>"><{$character}></a>
                	<{/foreach}>
              </div>
              
       </article>
      <!--字母结束-->
      
	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
   <script>
       $(".currm").click(function(){var o=$(this).attr("switc"),t=".lett-tab-"+o;$(".move").removeClass("move"),$(this).addClass("move");var c=$(".lett-tab-con").find(t);$(".lett-tab-con div").addClass("curro"),c&&c.removeClass("curro")}).click(function(){return!1});</script>

	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->
	
</body>
</html>
