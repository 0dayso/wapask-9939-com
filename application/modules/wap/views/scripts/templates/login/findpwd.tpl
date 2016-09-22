<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>找回密码_久久问医</title>

    <meta name="baidu-site-verification" content="wRAn557dE3" />
    <meta name="keywords" content="久久问医,找回密码页面" />
    <meta name="description" content="久久问医的找回密码页面，提供找回密码信息." />
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
    <span>找回密码</span>
    <a class="clna"></a>
</article>

<{include file="navigation/fast_navigation_ask_new.html"}>

<form action="/login/findpwd" method="post" class="formst suinf">
    <div class="indis">
        <input type="text" placeholder="手机号" value="" id="telephone" name="telephone">
        <a></a>
    </div>
    <div class="checo">
        <input type="text" placeholder="验证码" value="" id="input_chknum">
        <a style="cursor: pointer;" id="getchk">获取验证码</a>
    </div>
    <input type="submit" class="subs" value="确   认" id="submit">
    <p class="forget">
        <a href="http://wapask.9939.com/login" class="regis">登录</a>
        <a href="http://wapask.9939.com/login/goregister" class="regis">注册</a>
    </p>
    <input type="hidden" id="chknum" value="" />
    <input type="hidden" id="userid" value="" name = "userid" />
    <input type="hidden" id="chktime" value="" />
    <input type="hidden" id="chkresult" value="" />
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
    hiddenErrorBlock($("#telephone"));
    hiddenErrorBlock($("#getchk"));
    hiddenErrorBlock($("#input_chknum"));
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
        send(120, 'findpwd', 5);
    });

    function send(interval_time, module_name, max_count) {
        var date = new Date(),
                date_str = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
        var count_str = window.localStorage.getItem(date_str + '_'+ module_name +'_count'),
                count = parseInt(count_str);
        if (count >= max_count){
            show_error('验证码获取过于频繁，请明天再试！');
            return false;
        }else {

            //验证两次发送验证码的时间是否超过了 300s
            var storage_time_str = window.localStorage.getItem(date_str + '_'+ module_name +'_storage_time');

            if (storage_time_str != null && storage_time_str != undefined && storage_time_str != ''){
                var storage_time = parseInt(storage_time_str),
                        current_time = date.getTime();
                if (current_time - storage_time < (interval_time * 1000)){
                    show_error("验证码获取频繁，请"+ interval_time +"秒后重试！");
                    return false;
                }
            }

            var isTelExist = check_tel_exist();
            if (isTelExist == 1){
                return false;
            }
            send_chk(module_name);
        }
    }

    function send_chk(module_name) {
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

                    //将当前操作的次数及操作时间存入到 localStorage 中
                    store_send_info(module_name);
                }
                $("#chkresult").val(msg.result.flag);
            }
        });
    }
    
    function store_send_info(module_name) {
        var today_date = new Date(),
                today = today_date.getFullYear() + "-" + (today_date.getMonth() + 1) + "-" + today_date.getDate(),
                current_time = today_date.getTime();

        var yesterday_time = today_date.getTime() - 24*3600*1000;
        today_date.setTime(yesterday_time);
        var yesterday = today_date.getFullYear() + "-" + (today_date.getMonth() + 1) + "-" + today_date.getDate();

        var count_key = today + '_' + module_name + "_" + "count",
                store_time_key = today + "_" + module_name + "_" + "storage_time";
        var count_str = window.localStorage.getItem(count_key);

        //今天第一次存放
        if (count_str == undefined || count_str == null || count_str == ''){
            //删除昨天的数据
            window.localStorage.removeItem(yesterday + '_' + module_name + "_" + "count");
            window.localStorage.removeItem(yesterday + "_" + module_name + "_" + "storage_time");

            window.localStorage.setItem(count_key, 1);
            window.localStorage.setItem(store_time_key, current_time);
        }else {
            var count = parseInt(count_str);
            window.localStorage.removeItem(count_key);
            window.localStorage.setItem(count_key, count + 1);
            window.localStorage.removeItem(store_time_key);
            window.localStorage.setItem(store_time_key, current_time);
        }
    }

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
                    $("#userid").val(msg);
                }else {
                    show_error('用户不存在！');
                    isTelExist = 1;
                    return isTelExist;
                }
            }
        });
        return isTelExist;
    }

    $("#submit").on('click', function () {

        if ($("#chkresult").val() == '0'){
            show_error('发送失败，请重试！');
            return false;
        }
        if ($("#chknum").val() != hex_md5($("#input_chknum").val())){
            show_error('验证码不正确！');
            return false;
        }
        return true;
    });

</script>

</body>
</html>