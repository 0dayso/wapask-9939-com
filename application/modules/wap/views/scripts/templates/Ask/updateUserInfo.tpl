<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>提问成功提示</title>
    <meta name="baidu-site-verification" content="wRAn557dE3" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/other.css">
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>
    <script src="/js/md5.js"></script>

    <!-- 引入 jnotify 插件 -->
    <script type="text/javascript" src="/jnotify/js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/jnotify/css/jNotify.jquery.css" />
    <script type="text/javascript" src="/jnotify/js/jNotify.jquery.js"></script>
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
<div class="succe subm">提交成功</div>
<p class="fimoi">
    请稍后查看医生回复的结果
    <a href="http://wapask.9939.com/ask/userasklist?userid=<{$userid}>">查看更多</a>
</p>

    <div class="hainfo" style="display: none;">
        <p class="userna">
            用户名：
            <span class="sp_01" id="show_username"></span>
            <input type="hidden" id="userid" value="<{$userid}>"/>
            密码：
            <span id="show_password"></span>
            <a href="javascript:void(0)" class="chbt_01">修改></a>
        </p>
        <p class="bind">
            绑定手机后，及时获得医生回复通知
            <a href="javascript:void(0)" class="chbt_02">绑定手机></a>
        </p>
        <p class="userna" id="show_success_tel" style="display: none;">
            恭喜你！成功绑定，手机号是：
            <span id="show_telephone"></span>
        </p>
        <input type="hidden" id="chknum" value="" />
        <input type="hidden" id="chktime" value="" />
        <input type="hidden" id="chkresult" value="" />
    </div>

<div class="thre"></div>
<h2 class="frea">
    <a href="/ask/goaskdoctor">免费提问</a>
    相同问题
</h2>
<ul class="repro funct">
    <{if isset($relAsks) && !empty($relAsks)}>
        <{foreach $relAsks as $relAsk}>
            <li>
                <span><{$relAsk.answernum}>个答案</span>
                <a href="http://wapask.9939.com/id/<{$relAsk.id}>.html"><{$relAsk.title|mb_substr:0:16:'utf-8'}></a>
            </li>
        <{/foreach}>
    <{/if}>
</ul>
<div class="bana">
    <{include file="ads/ads_updateUserInfo.html"}>
</div>

<!--绑定手机弹出-->
<div class="outl disn"></div>
<div class="chau chau_01 disn">
    <p>
        绑定手机， <b>专家回答及时短信通知！</b>
    </p>
    <form action="" method="post" class="formst suinf">
        <div class="indis">
            <input type="text" placeholder="手机号" value="" id="telephone">
            <a></a>
        </div>
        <div class="checo">
            <input type="text" placeholder="验证码" value="" id="input_chknum">
            <a id="getchk" style="cursor: pointer">获取验证码</a>
        </div>
        <div class="indis caba bacan">
            <input type="password" placeholder="新密码" value="" class="psd" id="tel_password">
            <a></a>
        </div>
        <input type="submit" class="subs conf" value="确   认" id="update_tel"></form>
    <div class="clos"></div>
</div>

<div class="chau chau_02 disn">
    <p>
        修改用户名， <b>可使用用户名登入！</b>
    </p>
    <form action="" method="post" class="formst suinf">
        <div class="indis">
            <input type="text" placeholder="用户名" value="" id="username">
            <a></a>
        </div>
        <div class="indis capab">
            <input type="password" placeholder="密码" id="password">
            <a></a>
        </div>
        <div class="indis capab">
            <input type="password" placeholder="确认密码" value="" id="repassword">
            <a></a>
        </div>
        <input type="submit" class="subs conf" value="确   认" id="update_user"></form>
    <div class="clos"></div>
</div>

<iframe id="child" src="" style = "display: none;"></iframe>

<script>
    $(document).ready(function() {
        window.localStorage.removeItem("userid");
        window.localStorage.setItem("userid", $("#userid").val());

        var isLogin = window.localStorage.getItem('isLogin');
        if (isLogin == undefined || isLogin == null || isLogin == '' || isLogin == 0){
            $("#show_username").text(window.localStorage.getItem('username'));
            $("#show_password").text(window.localStorage.getItem('password'));
            $(".hainfo").show();

            //当前域名 wapask 登录后，同步到登录到 m.9939.com 下：
            $("#child").attr("src", "http://m.9939.com/iframe.php?userid=" + $("#userid").val() + "&username="+ $("#show_username").val() +"&id=" + Math.random());
        }
    });
</script>
<script src="/js/updateUserInfo.js"></script>

<!-- 统计功能 Start -->
<{include file="ads/wap_ask_stat.html"}>
<!-- 统计功能 End -->

</body>
</html>