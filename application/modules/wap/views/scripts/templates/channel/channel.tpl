<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><{$setting.meta_title}></title>
<meta name="description" content="<{$setting.meta_description}>" />
<meta content="width=device-width,user-scalable=no" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/body.css">
<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/other.css">
</head>
<body>
<article class="main">
<header class="main-hd personal-hd">
    <a href="/" class="j_logo"><img src="/images/jjlo.png"></a>
    <h2 class="main-hd-bt">久久健康网 · <a href="/<{$channels_url}>/"><{$channels}></a></h2>
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
<nav class="navc">
<{if $channel_arry}>
    <{foreach from=$channel_arry item=channel key=key}>
        <{if $key lt 7}>
            <a href="<{if $channel.child eq 0}>/<{$channel.catdir}>/<{$channel.catid}>list.shtml <{else}>/<{$channels_url}>/<{$channel.catid}><{/if}>"><{$channel.catname}></a>
            <{if <{count($channel_arry)}> gt 7}>
                <{if $key eq 6}>
                    <a href="<{$channel.parentdir}>/nav.shtml">更多&nbsp;></a>
                <{/if}>
            <{else}>
                <{if $key eq <{count($channel_arry)}>-1}>
                    <a href="<{$channel.parentdir}>/nav.shtml">更多&nbsp;></a>
                <{/if}>
            <{/if}>
        <{/if}>
    <{/foreach}>
<{else}>
    <a>暂无信息</a>
<{/if}>
</nav>
<!-- 百度联盟 开始-->
<script type="text/javascript">
    /*WAP PD 导航下部20:5 创建于 2015-05-25*/
var cpro_id = "u2120613";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
<!-- 百度联盟 结束-->
<{if $channel_arry}>
    <{foreach from=$channel_arry item=channel key=key}>
        <section class="sec<{if $key eq <{count($channel_arry)}>-1}> seco<{/if}>"><a href="<{if $channel.child eq 0}>/<{$channel.catdir}>/<{$channel.catid}>list.shtml <{else}>/<{$channels_url}>/<{$channel.catid}><{/if}>"><{$channel.catname}></a>
        <ul class="cop">
        <{foreach from=$channel.art item=article}>
            <li><span></span><a href="<{$article.art_base_path}>/<{$article.articleid}>.shtml"><{$article.title}></a></li>
        <{/foreach}>
        </ul><a href="<{if $channel.child eq 0}>/<{$channel.catdir}>/<{$channel.catid}>list.shtml <{else}>/<{$channels_url}>/<{$channel.catid}><{/if}>" class="loup">查看更多</a></section> 
        <{if $key is odd and $key neq <{count($channel_arry)}>-1 and $key lt 6}>
           <section style="margin-top:40px;margin-bottom:-40px;">
                <script type="text/javascript">
                /*wap 频道页广告 20:3 创建于 2015-06-04*/
                var cpro_id = "u2137699";
                </script>
                <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
            </section>
        <{/if}>
        <{if $key neq <{count($channel_arry)}>-1}>
            <a class="gocl" name="pre_02"></a>
        <{/if}>
    <{/foreach}>
<{/if}>
<div class="retop"><a href="javascript:scroll(0,0)"></a></div>

    <!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</article>
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript">
	seajs.use("play.js")	
</script>
<!--百度联盟 弹窗广告 开始-->
<script type="text/javascript">
var cpro_id="u2120632";
(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={cpro_close_time:"10",cpro_show_dist:"5",cpro_enable_hidden_float:"true",xuanting:"3",pat:"6",rss1:"#FFFFFF",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",scale:"20.3",titSU:"0",ptbg:"90",ptp:"0",at:"image",tn:"template_inlay_all_mobile"}
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
<!--百度联盟 弹窗广告 结束-->
</body>
</html>
