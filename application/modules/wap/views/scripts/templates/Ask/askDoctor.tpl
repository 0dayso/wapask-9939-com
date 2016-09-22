<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>向<{$doctorBasicInfo.nickname}>医生提问_久久问医</title>
    <meta name="baidu-site-verification" content="wRAn557dE3" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
     <link rel="stylesheet" type="text/css" href="/css/other.css">

    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>
    <script src="/js/top_nav.js"></script>
</head>
<body>

<article class="head">
    <a href="javascript:window.history.back();"></a>
    <span>专家咨询</span>
    <a class="clna"></a>
</article>

<{include file="navigation/fast_navigation_ask_new.html"}>

<p class="tips">
    <a href="javascript:void(0)"></a>
    在线
    <span>1112名</span>
    医生，
    <span>5分钟</span>
    内帮你解答！
</p>

<article class="expert">
    <img src="<{$doctorBasicInfo.pic}>" alt="<{$doctorBasicInfo.nickname}>" title = "<{$doctorBasicInfo.nickname}>" >
    <h3><{$doctorBasicInfo.nickname}></h3>
    <p><{$doctorBasicInfo.zhicheng}>  <{$doctorBasicInfo.doc_keshi}></p>
</article>

<form action="" method="post" class="formst tede" id="form">
    <div class="terea detai">
        <textarea placeholder="请描述您的主要病情、发病时间和病情变化！" id="content" name="content"></textarea>
        <p>
            <span>20</span>
            /200
        </p>
    </div>
    <ul class="choic">
        <li class="curs">男</li>
        <li>女</li>
        <input type="hidden" name="sex" id="sex" />
        <li class="age">
            <input type="text" class="tct" placeholder="25" id="age_num">
            <span>岁</span>
            <input type="hidden" id="age" name="age" >
            <input type="hidden" id="userid" name="userid" >
            <input type="hidden" id="doctorID" name="doctorID" value="<{$doctorID}>" >
        </li>
    </ul>
    <div class="imus">
        <input type="text" placeholder="（非必填）输入手机号码，解答后短信提醒你" value="" id="telephone" name="telephone">
        <div class="check">
            <input type="text" placeholder="输入右侧验证码" value="" id="chknum">
            <input type="hidden" id="isCheckSuccess" value="0"/>
            <p>
                <img src="/ask/getchk" id = "checkCode"  />
                <input type = "hidden" name = "initCheckNum" id = "initCheckNum" value = "" />
            </p>
            <a id="refresh" style="cursor: pointer;">刷新</a>
        </div>

        <input type="submit" class="subs" value="提交问题" id="submit"></div>
</form>

<!--message box-->
<div class="messa" id="tipmsg" style="display: none;" >
    <a>请清晰描述你所提问的问题</a>
</div>
<!--age box-->

<div class="outl disn"></div>
<div class="confirm disn">
    <p>
        <a>取消</a>
        <a>确定</a>
    </p>
    <div id="age_unit"><a>月</a><a class="curr">岁</a><a>天</a></div>
</div>

<script src="/js/ask_askDoctor.js"></script>

<!-- 统计功能 Start -->
<{include file="ads/wap_ask_stat_question.html"}>
<!-- 统计功能 End -->

</body>
</html>