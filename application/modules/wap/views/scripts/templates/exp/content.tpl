<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    <title><{$exp.title}>_健康经验分享_久久问医</title>
    <meta name="keywords" content="<{$exp.title}>" />
    <meta name="description" content="<{$exp.title}>,概述" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="canonical" href="http://ask.9939.com/exp/<{$exp.addtime_init}><{$exp.id}>.html" >

    <link rel="stylesheet" type="text/css" href="/css/exp.css">
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/exp/detail.js"></script>

</head>

<body>

<header class="head">
    <a href="javascript:window.history.back();"></a>
    <a class="clna"></a>
</header>

<!--导航栏展开-->
<{include file="navigation/fast_navigation_experience.html"}>
<!--ends-->

<article class="nacho">
    <a href="http://wapask.9939.com/jingyan/">健康经验</a>
    <{if !empty($disease)}>
        <span>></span>
        <a href="/expcat/<{$disease['cat']['plateid']}>/"><{$disease['cat']['plate_name']}></a>
        <span>></span>
        <a href="/explist/<{$disease['cat']['id']}>/"><{$disease['cat']['name']}></a>
        <span>></span>
        <a href="/expdis/<{$disease['id']}>/"><b><{$disease['name']}></b></a>
    <{/if}>
</article>

<h1 class="titl"><{$exp.title}></h1>
<article class="shaco">
    <a class="max">
        T <sup>+</sup>
    </a>
    <a class="min">
        T <sup>-</sup>
    </a>
    <span>分享者：<{$exp.username}></span>
    <span><{$exp.addtime}></span>
</article>

<div class="clear"></div>
<div class="ad_03">
    <{include file="ads/ads_exp_content_list_top.html"}>
</div>

<h2 class="desc">概述</h2>
<article class="expla">
    <p>
        <{$exp.content.desc}>
    </p>
</article>
<div class="ad_04">
    <{include file="ads/ads_exp_content_list_top.html"}>
</div>
<h2 class="desc"><{$exp.title}></h2>
<article class="sugges">
    <{foreach $exp.content.content as $key => $content}>
        <article class="node">
            <b><{$key + 1}></b>
            <p>
                <{$content}>
            </p>
        </article>
        <div class="clear"></div>
    <{/foreach}>
</article>

<h2 class="desc">注意事项</h2>
<article class="expla">
    <p>
        <{$exp.content.tip}>
    </p>
</article>

<div class="ad_04">
    <{include file="ads/ads_exp_content_list_top.html"}>
</div>

<div class="thre"></div>
<h2 class="hepla">相关经验</h2>
<Article class="repri">
    <{if !empty($relExps)}>
        <{foreach $relExps as $relExp}>
            <a href="/exp/<{$relExp.addtime}><{$relExp.id}>.html" title="<{$relExp.title}>"><{$relExp.title}></a>
        <{/foreach}>
    <{/if}>
</Article>

<div class="adag">
    <{include file="ads/ads_exp_content_rel_bottom.html"}>
</div>

<div class="thre"></div>
<h2 class="hepla">相关问题</h2>
<Article class="repri">

    <{if !empty($relAsks)}>
        <{foreach $relAsks as $relAsk}>
            <a href="/id/<{$relAsk.id}>.html" title="<{$relAsk.title}>"><{$relAsk.title}></a>
        <{/foreach}>
    <{/if}>
</Article>
<div class="adag">
    <{include file="ads/ads_exp_content_rel_bottom.html"}>
</div>

<{include file="footer/exp_footer.html"}>

<!-- 统计功能 Start -->
<{include file="ads/wap_ask_stat.html"}>
<!-- 统计功能 End -->

</body>
</html>