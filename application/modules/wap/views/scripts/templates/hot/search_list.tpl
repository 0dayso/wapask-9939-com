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
      
        <div class="breaw">
        	<a href="http://m.9939.com/" title = "久久首页">久久首页</a>&nbsp;>&nbsp;
        	<a href="http://wapask.9939.com/hot/" title = "问医热搜">问医热搜</a>&nbsp;>&nbsp;
        	<a href="">内容</a>
        </div>
        
        <section class="desech topad">
        	<input placeholder="请描述疾病或症状..." value = "<{$keywords}>" id = "searchWords" /><a href="" id = "searchBtn" title = "搜索" >搜索</a>
        	<a href="/ask/goAskDoctor" title = "提问" >提问</a>
        </section>
        
         <article>
             <h1 class="amtit"><{$keywords}></h1>
            <div class="advim">
                    <{include file="ads/ads_hot_search_01.html"}>
            </div>
             <{foreach $searchList as $key => $val }>
	             <div class="relate">
	                <h3 class="smtit"><a href="<{$val.ask.url}>" title="<{$val.ask.title}>"><{$val.ask.short_title}></a></h3>
	                <div class="narow"></div>
	                <div class="bodtext">
	                <p> <{if isset($val.answer)}><{$val.answer}><a href="<{$val.ask.url}>" title="<{$val.ask.title}>">[详情]</a><{/if}></p>
	                <p>
	                	<{if !empty($val.doctor) && isset($val.doctor.nickname) && !empty($val.doctor.nickname) }>
	                		<!--<span><i> <{$val.doctor.nickname}></i>医生</span>-->
	                		<span><i> </i> </span>
	                	<{else}>
	                		<span><i> </i> </span>	
	                	<{/if}>
	                	<span><{$val.ask.answernum}>个回答</span></p>
	                </div>
	             </div> 
	             
	            <{if $key == 3}>
		            <div class="advim">
		            	<{include file="ads/ads_hot_search_02.html"}>
		            </div>
	            <{/if}>	             
	             
             <{/foreach }>
             <div class="paget"><{$paging}></div>     
       </article>
       
       <!-- 相关热词部分 Start -->
       <article>
           <h1 class="amtit">相关热词</h1>
            <ul class="reahots">
            
            <{foreach $relateDiseaseWords as $key => $val}>
           	 <li><a href="<{$val.url}>" title = "<{$val.keywords}>"><{$val.short_name}></a></li>
            <{/foreach}>
        </ul>
       </article>
       <!-- 相关热词部分 End -->
       
        <div class="advim mTop">
        	<{include file="ads/ads_hot_search_03.html"}>
        </div>
        
	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
   
    <script>
	//设置 搜索 部分的 a 的 href 值
			$("#searchBtn").on('click', function(){
				var searchWords = $("#searchWords").val();
				
				$(this).attr("href", "/hot/sd/" + encodeURI(searchWords) + "/1");
			});
	
    	  $(".personal-btn").click(function(){ $(".personal-box").toggle();})
	      $(".personal-box li").click(function(){$(".personal-box").hide();})
	</script>

	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->	
	
</body>
</html>
