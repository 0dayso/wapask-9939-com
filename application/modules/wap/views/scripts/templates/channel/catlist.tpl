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
<h2 class="main-hd-bt">久久健康网 · <a href="<{$channel_catdir}>"><{$channels_name|truncate:2:""}></a></h2>
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
<div class="m_shor"><a href="<{$channel_catdir}>"><{$channels_name|truncate:2:""}></a>><a href="<{$catdir}>/<{$catid}>/list.shtml"><{$channels}></a>><a href="">文章列表</a></div>
<article class="sear"><!--<form action="" method="post"><input type="text" placeholder="感冒"><input type="submit" value="搜索"></form>--></article>

<section class="sec">
    <ul class="cop">
        <article><span></span>
			<a>
				<script type="text/javascript">
					var cpro_id="u2324872";
					(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",hn:"0",wn:"0",imgRatio:"1.7",scale:"20.6",pat:"6",tn:"template_inlay_all_mobile_lu_native",rss1:"#FFFFFF",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"70",ptp:"0"}
				</script>
				<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
			</a>
        </article>
        <{if $article_arry}>
            <{foreach from=$article_arry item=arts}>
                <li><span></span><a href="<{$art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
            <{/foreach}>
        <{/if}>
    </ul>
</section>
<article class="pagt"><{$page_html}></article>

    <!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</article>
<!--6.1 修改-->
<script type="text/javascript">setTimeout(show_tanchuang,10000);function toggleMenu(the,id){for(i=1;i<=2;i++){if(i==the){document.getElementById('tab'+i+id).className='hhh';document.getElementById('the'+i+id).className=''}else{document.getElementById('tab'+i+id).className='';document.getElementById('the'+i+id).className='hidden'}}}var sec=1000;var cou=20;function close_tanchuang(s){document.getElementById("tanchuang").className='hidden';if(s==1){setTimeout(show_tanchuang,sec*cou);cou=cou+18}}function show_tanchuang(){document.getElementById("tanchuang").className=''}</script>
<!--ends-->
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript">
    seajs.use("play.js")
</script>
<!--百度联盟 弹窗广告 开始-->
<script type="text/javascript">
    /*WAP PD D弹窗20:3 创建于 2015-05-25*/
var cpro_id = "u2120632";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
<!--百度联盟 弹窗广告 结束-->
</body>
</html>
