<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><{$result.title}></title>
	<meta name="description" content="页面描述" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta content="telephone=no" name="format-detection">
	<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/common.css">
	<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/index.css">
    <link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/fenxiang.css">
    <link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/1125.css">
    <link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/other.css">
</head>
<!-- head -->
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd personal-hd">
   		 <a href="/" class="j_logo"><img src="/images/jjlo.png"></a>
		<h2 class="main-hd-bt">久久健康网 · <a href="/<{$catdir.parentdir_url}>/"><{$catdir.parentdir_name}></a></h2>
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
    <!--6.1 修改-->
    <div class="m_shor"><a href="/<{$catdir.parentdir_url}>/"><{$catdir.parentdir_name}></a>&gt;<a href="/<{$catdir.parentdir_url}>/<{$catdir.catid}>"><{$catdir.catdir_name}></a>&gt;<a href="">正文</a></div>
    <!--ends-->
<!-- header ends -->
<!-- 主内容 stars -->
<section class="main-bd">
	<!-- neirongye start -->
	<div class="nry-box pdlf25">
		<div class="nry-bt">
			<h3><{$result.title}></h3>
			<p><span><{$result.inputtime}></span>来自：<{$result.copyfrom}></p>
		</div>
    <!--6.2新增-->
    <{if $zx_adstext}>
      <div class="n_add">
        <{foreach from=$zx_adstext item=ads}>
            <a href="<{$ads.newruleurl}>"><p><{$ads.adsname}></p></a>
        <{/foreach}>
      </div>
    <{/if}>
    <!--百度联盟 开始-->
    <script type="text/javascript">
    /*wap WZ 正文标题下方20:3 创建于 2015-05-28*/
        var cpro_id = "u2125585";
    </script>
    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
    <!--百度联盟 结束-->
		<div class="nry-txt txtinfo_box">
        <{if $result.description neq ""}><p><{$result.description}></p><{/if}>
			<{$result.content}>
		</div>
		<div class="Healthy-link show_more_btn"><a href="javascript:;">查看更多</a></div>
    <!--原生广告 开始-->
   <script type="text/javascript">
    var cpro_id="u2310033";
    (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.12",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}
    </script>
    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
    <!--原生广告 结束-->
		<dl class="other-login n-share mt24">
			<dt>分享:</dt>
			<dd class="cfx">
            <a href="#" class="bds_more" id="sha_a" data-cmd="more"></a>
            <a href="#" class="bds_tsina" id="sh_01" data-cmd="tsina" title="分享到新浪微博"></a>
            <a href="#"  id="sh_02" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
            <a href="#"  id="sh_03" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
            <a  id="sh_04" href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
            <a href="#" id="sh_05" class="bds_mshare" data-cmd="mshare" title="分享到一键分享"></a>
			</dd>
		</dl>          
		<div class="search-gjc cfx">
			<p>关键词：</p>
			<ul>
        <{foreach from=$keywords item=ikeywords key=keys}>
            <{if $ikeywords}>
                <{if $keys eq 0}>
				   <li class="current"><a href="#"><{$ikeywords}></a></li>
                <{else}>
				   <li><a href="#"><{$ikeywords}></a></li>
                <{/if}>
            <{/if}>
        <{/foreach}>
			</ul>
		</div>
	</div>
	<h3 class="reply-bt reply-btbg mt24">
		相关文章
	</h3>
	<ul class="mm-list txtcor mt24">
        <{if $article}>
            <{foreach from=$article item=arts}>
                <li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
       	   	<{/foreach}>
        <{/if}>
	</ul>
    <!--6.1 修改-->
    
    	<{if $zx_adsimage}>
	        <h3 class="reply-bt reply-btbg mt24">大家都在看</h3>
			<div class="main_visual">
			    <div class="pretot">
			        <a href="javascript:void(0);" id="btn_prev"></a>
			        <div class="flicking_con">
			        	<{foreach from=$zx_adsimage key=k item=ads}>
				            <a href="#"><{$k + 1}></a>
			            <{/foreach}>
			        </div>
			        <a href="javascript:void(0);" id="btn_next"></a>
				</div>
				<div class="main_image">
					<ul>
						<{foreach from=$zx_adsimage item=ads}>
							<!-- 外部链接 Start -->
	                    	<{if $ads.type == 3 }>
								<li><{$ads.text}></li>
							<{else}>
								<{if $ads.imageurl neq ""}>
									<li><a href="<{$ads.linkurl}>"><img src="<{$ads.imageurl}>" alt="<{$ads.adsname}>" style="opacity: 1; "></a></li>
								<{/if}>	
							<{/if}>
						<{/foreach}>
					</ul>
				</div>
			</div>
		<{/if}>	
		
    <h3 class="reply-bt reply-btbg mt24">
		找健康，问久久
	</h3>
	<div class="nry-btm pdlf25">
		<p>万名专家在线问您解答</p>
		<div class="Healthy-link want-ask"><a href="http://wapask.9939.com/ask/goAskDoctor">我要提问</a></div>
	</div>
	<!-- neirongye end -->
</section>
<!-- 主内容 ends -->
<!-- bottom_ad start -->
<!-- bottom_ad end -->
<!-- footer stars -->
   <{include file="footer/footer.html"}>
   <{include file="ads/wap_ask_stat.html"}>
<!-- footer ends -->
</div>

<script type="text/javascript">
    //内容题词
var cpro_id="u2257133";
(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={tn:"baiduTlinkNeiwen_mob"};
</script><script src="http://cpro.baidustatic.com/cpro/exp/mob_exp/js/cm_js_exp.js" type="text/javascript"></script>

</body>
<!--百度联盟 开始-->
<script type="text/javascript">
    /*WAP WZ 弹窗20:3 创建于 2015-05-25*/
var cpro_id = "u2120655";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
<script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
<script type="text/javascript" src="/js/slide.js"></script>
<!--百度联盟 结束-->
<script type="text/javascript" src="/js/sea.js"></script>
<script>
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>  
<script type="text/javascript">
    seajs.use("play.js")
</script>

</html>