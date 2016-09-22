<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>症状详情</title>
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
		<h2 class="main-hd-bt">症状详情</h2>
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
		<div class="zzxq-w">
		    <h1 class="zzxq-tit"><{if $result}><{$result.title}><{/if}></h1>
		    <ul class="Healthy-tit cfx zzxq-lists tab-hd">
	        	<li class="current"><a href="javascript:;">详细信息</a></li>
	        	<li><a href="javascript:;">病因</a></li>
	        	<li><a href="javascript:;">诊断</a></li>
	        	<li><a href="javascript:;">相关疾病</a></li>
	        </ul>
	        <div class="tab-bd">
	        	<div class="tabbox">
	        		<div class="txtinfo_box zz_xq_txt">
						<p class="zzxq-conten">
							<{if $result}><{$result.content}><{/if}>
						</p>
					</div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="tabbox">
					<div class="txtinfo_box zz_xq_txt">
						<p class="zzxq-conten">
							<{if $result}><{$result.cause}><{/if}>
                        </p>
					</div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="tabbox">
					<div class="txtinfo_box zz_xq_txt">
						<p class="zzxq-conten">
                            <{if $result}><{$result.diagnose}><{/if}>
                        </p>
					</div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
				<div class="tabbox">
					<div class="txtinfo_box zz_xq_txt">
						<p class="zzxq-conten">
							<{if $result_xgjb}>
                                <{foreach from=$result_xgjb item=xgjb}>
                                    <{$xgjb.title}>
                                <{/foreach}> 
                            <{/if}>
						</p>
					</div>
					<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
				</div>
			</div>
            <{if $xg_ask}>
			<h2 class="m-title"><span>相关问答</span></h2>
		    <ul class="mm-list ask">
                <{foreach from=$xg_ask item=asks}>
                    <li><a href="http://wapask.9939.com/id/<{$asks.id}>.html"><{$asks.title}></a></li>
                <{/foreach}>
		    </ul>
            <{/if}>
	   		<div class="Healthy-link want-ask"><a href="http://wapask.9939.com/ask/goAskDoctor">我要提问</a></div>
		</div>
	</div>
	<!-- 内容 ends-->
	<!-- bottom_ad start -->
	<div class="bottom_ad">
		<ul>
            <{if $zx_ads}>
                <{foreach from=$zx_ads item=ads key=key}>
                    <{if $ads.imageurl neq ""}>
                        <li data-index="<{$key}>"><a href="<{$ads.linkurl}>"><img src="<{$ads.imageurl}>" width="100%" alt="<{$ads.adsname}>"><span><{$ads.adsname}></span></a></li>
                    <{else}>
                        <li data-index="<{$key}>"><a href="<{$ads.linkurl}>" title="<{$ads.adsname}>"><span><{$ads.adsname}></span></a></li>
                    <{/if}>
                <{/foreach}>   
            <{/if}> 
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