<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>最真实的<{$current.curname}>经验分享_久久问医健康经验</title>
        <meta name="keywords" content="<{$current.curname}>经验分享" />
        <meta name="description" content="久久问医健康经验<{$current.curname}>经验分享，分享<{$current.curname}>的各种经验，帮助你解决<{$current.curname}>在现实生活中遇到的各种问题，还可以把自己的<{$current.curname}>经验分享出来让更多的人受益。" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="canonical" href="http://ask.9939.com/exp<{$current.uri}>" >
        <link rel="stylesheet" type="text/css" href="/css/exp.css">
        <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
        <script src="/js/exp/detail.js"></script>
        <!--slide滚动-->
        <script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
        <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
        <script type="text/javascript" src="/js/exp/slide.js"></script>
        <!--ends-->
    </head>
    <body>
        <header class="head"><a href="/jingyan/"></a><a class="clna"></a></header>
        <!--右上角快速导航 开始-->
            <{include file="navigation/fast_navigation_experience.html"}>
        <!--右上角快速导航 结束-->
        
        <article class="selay">
            <form class="focon" action="" method="post">
                <input type="text" id = "searchWords" placeholder="搜索疾病、症状">
                <a href="javascript:" id = "searchBtn">搜索</a>
                <script>
                    //设置 搜索 部分的 a 的 href 值
                    $("#searchBtn").on('click', function(){
                        var searchWords = $("#searchWords").val();

                        $(this).attr("href", "/search/" + encodeURI(searchWords) + "/1");
                    });
                </script>
            </form>
            <a href="/ask/goAskDoctor">免费问医</a>
        </article>
       
        <article class="nav">
            <a href="/jingyan/">首  页</a>
            <a class="curst eper">经验分享</a>
            <a href="/jingyan/shareing/share/">我要分享</a>
            <a href="/jingyan/shareing/meshare/">我的经验</a>
            <!--经验分享弹出-->
            <!--大分类模块-->
            <article class="exsha disn">
                <{foreach from=$plates item=plate}>
                    <a href="<{$plate.url}>"><{$plate.name}></a>
                <{/foreach}>
            </article>
            <div class="clear"></div>
        </article>
        <div class="clear"></div>
        <!--灰色导航条-->
        <article class="nacho">
            <a href="/jingyan/">健康经验</a><span>></span>
            <a href="/expcat/<{$current.plateid}>/"><{$current.plateshow}></a>
            <{if $current.cate neq 'expcat'}>
                <span>></span><a href="/explist/<{$current.catid}>/"><{$current.catshow}></a>
            <{/if}>
            <{if $current.cate eq 'expdis'}>
                <span>></span><a href="/expdis/<{$current.diseaseid}>/"><b><{$current.curname}></b></a>
            <{/if}>
        </article>
        <!--选中科室-->
        <h2 class="hepla heanew clearfix"><b><i><{$current.catshow}></i><span class="nela"></span></b></h2>
        <!--疾病选项-->
        <article class="clsa">
            <{if $current.cate eq 'explist'}>
                <a class="cus" href="/explist/<{$current.catid}>/">全部</a>
            <{elseif $current.cate eq 'expdis'}>
                <a href="/explist/<{$current.catid}>/">全部</a>
            <{/if}>
            <{if $disease|@count neq 0}>
                <{foreach from=$disease item=val}>
                    <{if $current.cate eq 'expdis' and $current.diseaseid eq $val.id}>
                        <a  class="cus" href="/expdis/<{$val.id}>/"><{$val.name}></a>
                    <{else}>
                        <a href="/expdis/<{$val.id}>/"><{$val.name}></a>
                     <{/if}>
                <{/foreach}>
            <{/if}>
            
        </article>


        <div class="ad_03">
            <{include file="ads/ads_exp_content_list_top.html"}>
        </div>
        <article class="health">
            <!--遍历数据 12条-->
            <{foreach from=$list item=val}>
            <a href="<{$val.url}>">
                    <h3><{$val.title|truncate:18:'...':true}></h3>
                    <p class="hte_01"><{$listcontent[$val['id']]['content']|truncate:66:'...':true}></p>
                    <p class="hte_02">
                        <span class="sh_01"><{$val.addtime|date_format:'%Y-%m-%d'}></span><span class="sh_02">分享者：<{$val.username}></span><span class="sh_03"><{$listdisease[$val['diseaseid']]['name']}></span>
                    </p>
                </a>
            <{foreachelse}>
                暂无数据
            <{/foreach}>
        </article>
        <div class="lasp">
            <{if $pageurl.page neq 1}>
                <a href="<{$pageurl.pre}>">&lt;&lt;上一页</a>
            <{/if}>
            <span><b><{$pageurl.page}></b>/<{$pageurl.totalpage}></span>
            <{if $pageurl.page lt $pageurl.totalpage}>
                <a href="<{$pageurl.next}>">下一页&gt;&gt;</a>
            <{/if}>
        </div>

        <{include file="footer/exp_footer.html"}>

        <div class="oubra disn"></div>
        <div class="choico disn">
            <!--模块下科室选项-->
            <h3>请选择其它科室</h3>
            <{if $current.cate == 'expcat'}>
                <a class="cmb" href="/expcat/<{$current.plateid}>/">全部</a>
            <{else}>
                <a href="/expcat/<{$current.plateid}>/">全部</a>
            <{/if}>
            <{foreach from=$categories item=val}>
                <{if $current.cate eq 'explist' and $current.catid eq $val.id}>
                <a  class="cmb" href="/explist/<{$val.id}>/"><{$val.name}></a>
                <{else}>
                    <a href="/explist/<{$val.id}>/"><{$val.name}></a>
                <{/if}>
            <{/foreach}>
        </div>
        <a class="retop" href="javascript:scroll(0,0)"></a>
        <!-- 统计功能 Start -->
        <{include file="ads/wap_ask_stat.html"}>
        <!-- 统计功能 End -->
    </body>
</html>
