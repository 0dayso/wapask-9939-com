<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>我要分享_健康经验分享_久久问医</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="canonical" href="http://ask.9939.com/jingyan/shareing/share/" >
<link rel="stylesheet" type="text/css" href="/css/exp.css">
<script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/exp/detail.js"></script>
</head>
<body>
<header><a href="http://m.9939.com/"><h1 class="久久健康网"></h1></a><a class="clna"></a></header>
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
    <a class="eper">经验分享</a>
    <a href="#" class="curst">我要分享</a>
    <a href="/jingyan/shareing/meshare/">我的经验</a>
    <!--经验分享弹出-->
    <article class="exsha disn">
        <a href="/expcat/0/">常见疾病</a>
        <a href="/expcat/1/">生活保健</a>
        <a href="/expcat/2/">两性健康</a>
        <a href="/expcat/3/">整形美容</a>
    </article>
</article>

<div class="clear"></div>
<form class="consha" action="#" method="">
	<article class="oufir">
	<input type="text" placeholder="请输入标题..."><textarea placeholder="请输入分享内容...（不能少于20字）"></textarea>
	<div class="check"><div class="sex fl"><label>性别：</label><input type="radio" value="男" name="sex"><span>男</span><input type="radio" value="女" name="sex"><span>女</span></div><div class="age fr"><label>年龄：</label><select><option value="20">20</option><option value="30">30</option><option value="40">40</option></select></div></div>
    </article>
    <input type="submit" class="subs" value="立即提交">
</form>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $('.subs').click(function(){
            location.href = 'http://wapask.9939.com/jingyan/';
        });
    });
</script>
