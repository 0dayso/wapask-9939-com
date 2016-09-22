<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><{$result.title}>疾病详情</title>
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
   		 <a href="/Disease/" class="c_logo">疾病库</a>
		<h2 class="main-hd-bt">疾病详情</h2>
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
		<!-- jibing-xq start -->
		<div class="jibing-xq pdall">
			<dl class="jibing-info pd2em cfx">
				<dt><img src="http://www.9939.com/<{$result.thumb}>" alt="<{$result.title}>"></dt>
				<dd>
					<h3><{$result.title}></h3>
					<p>所属部位：<span><{$result.buwei}></span></p>
					<p>就诊科室：<span><{$result.keshi}></span></p>
					<!--<p><span>神经内科&nbsp;&nbsp;&nbsp;&nbsp;其他</span></p>-->
				</dd>
			</dl>
			<ul class="jibing-links tab-hd  cfx">
				<li class="current"><a href="javascript:;">概述</a></li>
				<li><a href="javascript:;">病因</a></li>
				<li><a href="javascript:;">症状</a></li>
				<li><a href="javascript:;">检查</a></li>
				<li><a href="javascript:;">治疗</a></li>
				<li><a href="javascript:;">预防</a></li>
				<li><a href="javascript:;">鉴别</a></li>
				<li><a href="javascript:;">并发症</a></li>
			</ul>
			<div class="tab-bd">
				<div class="j-txt-info" style="display:block;">
					<div class="bibing_txt txtinfo_box">
                        <{$result.content}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
                        <{$result.cause}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
                        <{$result.character}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
					   <{$result.examine}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
					   <{$result.cure}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
                        <{$result.healthcare}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
                        <{$result.diagnose}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="j-txt-info">
					<div class="bibing_txt txtinfo_box">
                        <{$result.bingfazheng}>
                    </div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
			</div>
            <{if $relevant_ask}>
			<h2 class="m-title"><span>相关问答</span></h2>
			<ul class="mm-list ask">
                <{foreach from=$relevant_ask item=asks}>
    			   	<li><a href="http://wapask.9939.com/id/<{$asks.id}>.html"><{$asks.title}></a></li>
                <{/foreach}>
			</ul>
            <{/if}>
			<div class="Healthy-link want-ask"><a href="http://wapask.9939.com/ask/goAskDoctor">我要提问</a></div>
            <{if $relevant_art}>
			<h2 class="m-title"><span>相关滚动资讯</span></h2>
			<div class="txt_scrollTop">
				<div class="scroll_list_box">
					<ul class="mm-list">
                        <{foreach from=$relevant_art item=arts}>
    					   	<li><a href="<{$arts.catdir}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
				    </ul>
			    </div>
			</div>
            <{/if}>
		</div>
		<!-- jibing-xq end -->
	</section>
	<!-- 主内容 ends -->
	<!-- bottom_ad start -->
	<div class="bottom_ad">
		<ul>
        <{foreach from=$zx_ads item=ads}>
            <{if $ads.imageurl neq ""}>
                <li><a href="<{$ads.linkurl}>"><img src="<{$ads.imageurl}>" alt="<{$ads.adsname}>"></a></li>
            <{else}>
                <li><a href="<{$ads.linkurl}>" title="<{$ads.adsname}>"><{$ads.adsname}></a></li>
            <{/if}>
        <{/foreach}>
		</ul>
	</div>
	<!-- bottom_ad end -->
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