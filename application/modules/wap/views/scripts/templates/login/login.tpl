<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户登录页面_久久问医</title>
    <meta name="baidu-site-verification" content="wRAn557dE3" />
    <meta name="keywords" content="久久问医,用户登录页面" />
    <meta name="description" content="久久问医的用户登录页面" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/other.css">
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/detail.js"></script>
    <script src="/js/top_nav.js"></script>
    <input type="hidden" id="rm" value="<{$r}>" />
    <script>
        var r = $("#rm").val();
        if (r !== '0'){
            var ir = parseInt(r);
            var cdate = new Date();
            var cdate_str = cdate.getFullYear() + '' + (cdate.getMonth() + 1) + '' + cdate.getDate();
            cdate.setTime(ir * 1000);
            var rdate_str = cdate.getFullYear() + '' + (cdate.getMonth() + 1) + '' + cdate.getDate();

            if (cdate_str == rdate_str){
                window.localStorage.removeItem('userid');
            }
        }
        if(window.localStorage){
            var userid = window.localStorage.getItem('userid');
            if (userid != null && userid != undefined){
                window.location.href = 'http://wapask.9939.com/doctor/usercenter?userid=' + userid;
            }
        }
    </script>
</head>

<body>
<article class="head">
    <a href="javascript:window.history.back();"></a>
    <span>登 录</span>
    <a class="clna"></a>
</article>

<{include file="navigation/fast_navigation_ask_new.html"}>

<article class="usinf">
    <div>
        <img src="/images/user.jpg" alt="">
    </div>
</article>

<form action="/login/login" method="post" class="formst logi">
    <div class="indis">
        <input type="text" placeholder="输入用户名、手机号" value="" class="user" id= "username" name = "username">
        <a></a>
    </div>
    <div class="indis">
        <input type="password" placeholder="输入密码" value="" class="psd" id ="password" name = "password">
        <a></a>
    </div>
    <input type="hidden" name="userid" id="userid" value="0" />
    <input type="hidden" name="login" id="login" value="1"  />
    <input type="submit" class="subs" value="登  录" id = "submit">
    <p class="forget">
        <a href="/login/forgetpwd" id="forget_pwd">忘记密码？</a>
        <a href="http://wapask.9939.com/login/goregister" class="regis">注册</a>
    </p>
    <iframe id="remove" src="http://m.9939.com/remove.php?r=<{time()}>" style = "display: none;"></iframe>
</form>

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
    hiddenErrorBlock($("#username"));
    hiddenErrorBlock($("#password"));

    function notify_error(msg) {
        $("#tipmsg").show();
        $("#tipmsg a").text(msg);
    }

    $("#submit").on('click', function(){

        //验证用户输入的用户名是否合法
        var username = $("#username").val();
        if(username.length == 0){
            notify_error("用户名不能为空！");
            return false;
        }
        var password = $("#password").val();
        if(password.length == 0){
            notify_error("密码不能为空！");
            return false;
        }

        var userexist = isuserexist();
        if (!userexist){
            return false;
        }
        return true;
    });
    
    function isuserexist() {
        var isuserexist = false;
        $.ajax({
            type: "POST",
            url:  "http://wapask.9939.com/login/isuserexist",
            data: {
                'username' : $("#username").val(),
                'password' : $("#password").val()
            },
            dataType:'json',
            async: false,
            success: function(msg){
                if (msg.flag == 0){
                    notify_error('登录信息有误！');
                }else {
                    isuserexist = true;
                    $("#userid").val(msg.userid);
                }
            }
        });
        return isuserexist;
    }
</script>

</body>
</html>