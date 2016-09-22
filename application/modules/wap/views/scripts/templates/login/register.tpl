<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户注册页面_久久问医</title>
    <meta name="baidu-site-verification" content="wRAn557dE3" />
    <meta name="keywords" content="久久问医,用户注册页面" />
    <meta name="description" content="久久问医的用户注册页面，提供用户注册信息." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/other.css">

    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>
    <script src="/js/md5.js"></script>
    <script src="/js/top_nav.js"></script>
</head>
<body>
<article class="head">
    <a href="javascript:window.history.back();"></a>
    <span>注 册</span>
    <a class="clna"></a>
</article>

<{include file="navigation/fast_navigation_ask_new.html"}>

<article class="person">
    <h3>久久医生</h3>
    <p>注册后即可获得专业医生解答！</p>
</article>

<form action="/login/register" method="post" class="formst">
    <div class="indis bacan">
        <input type="text" placeholder="输入手机号" value="" class="user" name="telephone" id="telephone">
        <a></a>
    </div>
    <div class="checo bacan">
        <input type="text" placeholder="验证码" value="" id="input_chknum">
        <a style="cursor: pointer;" id="getchk">获取验证码</a>
    </div>
    <div class="indis caba bacan">
        <input type="password" placeholder="密码" value="" class="psd" name="password" id="password">
        <a></a>
    </div>
    <div class="indis caba bacan">
        <input type="password" placeholder="重新输入" value="" class="psd" id="repassword">
        <a></a>
    </div>
    <div class="agree">
        <div data-g="0" class="cusm"></div>
		<span>
			我同意
			<a href="/login/service">服务条款</a>
			中的所有内容
		</span>
    </div>
    <input type="submit" class="subs" value="注   册" id="submit">
    <input type="hidden" id="chknum" value="" />
    <input type="hidden" id="chktime" value="" />
    <input type="hidden" id="chkresult" value="" />
</form>

<!-- <article class="otcoun">
    <div class="othel">
        <h3>其他账号登录</h3>
        <div>
            <a href="">
                <img src="/images/wei_01.png" alt=""></a>
            <a href="">
                <img src="/images/wei_02.png" alt=""></a>
            <a href="">
                <img src="/images/wei_03.png" alt=""></a>
        </div>
    </div>
</article> -->

<!--message box-->
<div class="messa" id="tipmsg" style="display: none;">
    <a>用户已存在或输入格式错误</a>
</div>

<script>

    function hiddenErrorBlock(controlObj){
        //当输入框获取焦点时，隐藏 错误显示信息
        $(controlObj).on('focus', function(){
            //隐藏错误显示区域
            $("#tipmsg").hide();
        });
    }
    hiddenErrorBlock($("#telephone"));
    hiddenErrorBlock($("#getchk"));
    hiddenErrorBlock($("#input_chknum"));
    hiddenErrorBlock($("#password"));
    hiddenErrorBlock($("#repassword"));
    hiddenErrorBlock($(".agree div"));
    hiddenErrorBlock($("#submit"));

    $("#getchk").on('click', function () {
        /*
         * 验证当前手机号码是否合法
         * 1、如果合法，查看是否已经绑定过
         * 2、如果没有绑定过，则发送验证码
         */

        var telephone = $("#telephone").val();
        if (telephone.length == 0){
            show_error('手机号不能为空！');
            return false;
        }

        var regexp = /^1[3|4|5|7|8]\d{9}$/;
        if (!regexp.test(telephone)){
            show_error('手机填写有误！');
            return false;
        }

        var isTelExist = check_tel_exist();
        if (isTelExist == 1){
            return false;
        }

        $.ajax({
            type: "GET",
            url:  "/doctor/send",
            data: {
                'dst': $("#telephone").val()
            },
            success: function(rel){
                var msg = eval( "(" + rel + ")" );
                if (msg.result.flag == 0){
                    show_error('发送失败，请重试！');
                }else{
                    show_error('发送成功！');
                    $("#chknum").val(msg.checknummd5);
                    $("#chktime").val(msg.time);
                }
                $("#chkresult").val(msg.result.flag);
            }
        });
    });

    $("#submit").on('click', function () {

        if ($("#chkresult").val() == '0'){
            show_error('发送失败，请重试！');
            return false;
        }
        if ($("#chknum").val() != hex_md5($("#input_chknum").val())){
            show_error('验证码不正确！');
            return false;
        }

        //验证密码
        var password = $("#password").val();
        if (password.length == 0){
            show_error("密码不能为空！");
            return false;
        }
        if (password.length < 6){
            show_error("密码长度不够！");
            return false;
        }
        if (password != $("#repassword").val()){
            show_error("密码不一致！");
            return false;
        }
        //是否同意条款：
        var service = $(".agree div").attr('data-g');
        if (service == undefined || service == '' || service == 1){
            show_error("请同意条款！");
            return false;
        }
        return true;
    });
    
    function show_error(msg) {
        $("#tipmsg").show();
        $("#tipmsg a").text(msg);
    }

    function check_tel_exist() {
        var isTelExist = 0;

        $.ajax({
            type: "GET",
            url:  "/ask/checktelexist",
            data: {
                'telephone': $("#telephone").val()
            },
            async: false,
            success: function(msg){
                if(msg > 0){
                    show_error('手机号已绑定！');
                    isTelExist = 1;
                    return isTelExist;
                }
            }
        });
        return isTelExist;
    }
</script>

</body>
</html>