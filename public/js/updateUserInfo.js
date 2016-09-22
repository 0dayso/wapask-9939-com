
$(".chbt_01").on('click', function () {
    //将密码输入框置为空
    $("#password").val('');
    $("#repassword").val('');
});

$(".chbt_02").on('click', function () {
    //将验证码输入框置为空
    $("#input_chknum").val('');
    $("#tel_password").val('');
});

$("#getchk").on('click', function () {
    /*
     * 验证当前手机号码是否合法
     * 1、如果合法，查看是否已经绑定过
     * 2、如果没有绑定过，则发送验证码
     */

    var telephone = $("#telephone").val();
    if (telephone.length == 0){
        notify('手机号不能为空！');
        return false;
    }

    var regexp = /^1[3|4|5|7|8]\d{9}$/;
    if (!regexp.test(telephone)){
        notify('手机填写有误！');
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
                notify('发送失败，请重试！', true);
            }else{
                notify_success('发送成功！');
                $("#chknum").val(msg.checknummd5);
                $("#chktime").val(msg.time);
            }
            $("#chkresult").val(msg.result.flag);
        }
    });
});

$("#update_tel").on('click', function () {

    if ($("#chkresult").val() == '0'){
        notify('发送失败，请重试！');
        return false;
    }
    if ($("#chknum").val() != hex_md5($("#input_chknum").val())){
        notify('验证码不正确！');
        return false;
    }

    //更新到数据库中
    $.ajax({
        type: "POST",
        url:  "/ask/updateusertel",
        data: {
            'userid': $("#userid").val(),
            'telephone': $("#telephone").val(),
            'password': $("#tel_password").val()
        },
        success: function(){
            notify_success("绑定手机成功！");
            $("#show_telephone").text($("#telephone").val());

            //如果修改了密码，则将当前修改的密码，存放到 localStorage 中
            var password = $("#tel_password").val();
            password = String.trim(password);
            if(password != null && password != '' && password.length > 0){
                window.localStorage.removeItem('password');
                window.localStorage.setItem('password', password);

                $("#show_password").text(password);
            }

            $('.outl,.chau').removeClass('shay').addClass('disn');
            $("#show_success_tel").show();
        }
    });
    return false;
});

function check_tel_exist() {
    var isTelExist = 0;

    $.ajax({
        type: "GET",
        url:  "/ask/checktelexist",
        data: {
            'userid': $("#userid").val(),
            'telephone': $("#telephone").val()
        },
        async: false,
        success: function(msg){
            if(msg > 0){
                notify("手机号已绑定！");
                isTelExist = 1;
                return isTelExist;
            }
        }
    });
    return isTelExist;
}

$("#update_user").on('click', function () {
    /*
     1、验证当前用户名是否存在
     2、如果存在，提示用户
     3、如果不存在，则更新到数据库，关闭当前窗口
     */
    var username = $("#username").val();

    //判断用户是否为空
    if(username.length == 0){
        notify("用户名不能为空！");
        return false;
    }

    //判断用户名是否存在：
    var isUserExist = checkuser();
    if (isUserExist == 1){
        return false;
    }

    //验证密码
    var password = $("#password").val();
    if (password.length == 0){
        notify("密码不能为空！");
        return false;
    }
    if (password.length < 6){
        notify("密码长度不够！");
        return false;
    }
    if (password != $("#repassword").val()){
        notify("密码不一致！");
        return false;
    }

    //则更新到数据库，关闭当前窗口
    $.ajax({
        type: "POST",
        url:  "/ask/updateuser",
        data: {
            'userid': $("#userid").val(),
            'username': $("#username").val(),
            'password': $("#password").val()
        },
        success: function(){
            notify_success("恭喜修改成功！");
            $("#show_username").text($("#username").val());
            $("#show_password").text($("#password").val());

            //将修改后的用户名和密码，存放到 localStorage 中
            window.localStorage.removeItem('username');
            window.localStorage.removeItem('password');

            window.localStorage.setItem('username', $("#username").val());
            window.localStorage.setItem('password', $("#password").val());

            //当前域名 wapask 登录后，同步到登录到 m.9939.com 下：
            $("#child").attr("src", "http://m.9939.com/iframe.php?userid=" + $("#userid").val() + "&username="+ $("#username").val() +"&id=" + Math.random());

            $('.outl,.chau').removeClass('shay').addClass('disn');
        }
    });
    return false;
});

function checkuser() {
    var isUserExist = 0;
    $.ajax({
        type: "GET",
        url:  "http://wapask.9939.com/ask/checkuserexist",
        data: "username=" + $("#username").val(),
        dataType:'json',
        async: false,
        success: function(msg){
            if(msg != null && msg.flag == "1"){
                notify("用户名已存在！");
                isUserExist = 1;
                return isUserExist;
            }
        }
    });
    return isUserExist;
}

function notify_success($message) {
    jSuccess($message,{
        clickOverlay : false,  // 是否单击遮罩层才关闭提示条
        MinWidth : 150,        // 最小宽度
        TimeShown : 1500,      // 显示时间：毫秒
        ShowTimeEffect : 200,  // 显示到页面上所需时间：毫秒
        HideTimeEffect : 200,  // 从页面上消失所需时间：毫秒
        LongTrip : 15,         // 当提示条显示和隐藏时的位移
        HorizontalPosition : "center",// 水平位置:left, center, right
        VerticalPosition : "center",// 垂直位置：top, center, bottom
        ShowOverlay : true,     // 是否显示遮罩层
        ColorOverlay : "#000",  // 设置遮罩层的颜色
        OpacityOverlay : 0.3,   // 设置遮罩层的透明度
    });
    $("#jSuccess").css('font-size', 16);
}

function notify(message, autoHide) {
    autoHide = autoHide || false;
    jError(message,{
        autoHide : autoHide,       // 是否自动隐藏提示条
        clickOverlay : false,  // 是否单击遮罩层才关闭提示条
        MinWidth : 150,        // 最小宽度
        TimeShown : 1500,      // 显示时间：毫秒
        ShowTimeEffect : 200,  // 显示到页面上所需时间：毫秒
        HideTimeEffect : 200,  // 从页面上消失所需时间：毫秒
        LongTrip : 15,         // 当提示条显示和隐藏时的位移
        HorizontalPosition : "center",// 水平位置:left, center, right
        VerticalPosition : "center",// 垂直位置：top, center, bottom
        ShowOverlay : true,     // 是否显示遮罩层
        ColorOverlay : "#000",  // 设置遮罩层的颜色
        OpacityOverlay : 0.3,   // 设置遮罩层的透明度
    });
    $("#jError").css('font-size', 16);
}