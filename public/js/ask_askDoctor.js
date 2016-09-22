
//验证码刷新功能
$("#refresh").on('click', function(){
    $("#checkCode").attr('src', "/ask/getchk?cd=" + Math.random() );
});

/**
 * 验证 验证码输入是否正确
 */
function checknum() {
    $.ajax({
        type: "GET",
        url: "/ask/checknum",
        data: "chknum=" + $("#chknum").val(),
        async: false,
        success: function(msg){
            if (msg == 1){
                $("#isCheckSuccess").val("1");
            }else{
                $("#isCheckSuccess").val("0");
            }
        }
    });
}

function hiddenErrorBlock(controlObj){
    //当输入框获取焦点时，隐藏 错误显示信息
    $(controlObj).on('focus', function(){
        //隐藏错误显示区域
        $("#tipmsg").hide();
    });
}
hiddenErrorBlock($("#content"));
hiddenErrorBlock($("#age_num"));
hiddenErrorBlock($("#telephone"));
hiddenErrorBlock($("#chknum"));
hiddenErrorBlock($("#checkCode"));
hiddenErrorBlock($("#submit"));

function notify_error(msg) {
    $("#tipmsg").show();
    $("#tipmsg a").text(msg);
}

$("#submit").on('click', function () {

    //验证内容：
    var content = $("#content").val();

    var emptyCheck = /^\s+$/;
    if (emptyCheck.test(content)){
        notify_error("内容不能为空！");
        return false;
    }

    if (content.length < 20){
        notify_error("内容少于20个字！");
        return false;
    }

    var age_num = $("#age_num").val();
    if (age_num == '' || age_num == ' '){
        notify_error("请输入年龄！");
        return false;
    }
    if (parseInt(age_num) > 150){
        notify_error("年龄输入有误！");
        return false;
    }

    checknum();
    if($("#isCheckSuccess").val() == '0'){
        notify_error('验证码不正确！');
        return false;
    }

    if (window.localStorage.getItem("userid") != undefined && window.localStorage.getItem("userid") != ''){
        $("#userid").val(window.localStorage.getItem("userid"));
    }

    $("#sex").val($(".choic .curs").text());
    $("#age").val(age_num + '-' + $("#age_unit .curr").text());

    //判断是否重复提交
    var successTime = window.localStorage.getItem("successTime");
    var time = new Date().getTime();
    if(successTime == undefined || successTime == null){
        successTime = time;
    }else{
        successTime = parseInt(successTime);
    }
    if(time - successTime > 0 && time - successTime < 60*1000){
        notify_error('不能重复提交！');
        return false;
    }

    //操作成功后，记录当前操作时间，避免重复提交
    var currentTime = new Date().getTime();
    window.localStorage.removeItem("successTime");
    window.localStorage.setItem("successTime", currentTime);

    var classid = ask_doctor();
    window.location.href = "http://wapask.9939.com/ask/success?classid=" + classid;

    return false;
});

function ask_doctor() {
    var classid_str = 15;

    $.ajax({
        type: "POST",
        url: "/ask/askdoctor",
        data: {
            'content': $("#content").val(),
            'sex': $("#sex").val(),
            'age': $("#age").val(),
            'telephone': $("#telephone").val(),
            'doctorID': $("#doctorID").val(),
            'userid': $("#userid").val(),
        },
        async: false,
        success: function(msg){
            //{"userid":"1389810","username":"vxwcg","md5password":"3e775d0a96d1cea47b9d00a2d99840e7","password":328354,"isLogin":0,"flag":1,"classid":"15"}
            var msg = eval( "(" + msg + ")" );

            if(msg.flag == 1){
                classid_str = msg.classid + '-' + msg.userid;

                //将数据存放到 localStorage 里面
                window.localStorage.removeItem('userid');
                window.localStorage.removeItem('isLogin');
                window.localStorage.removeItem('classid');

                window.localStorage.setItem('userid', msg.userid);
                window.localStorage.setItem('isLogin', msg.isLogin);
                window.localStorage.setItem('classid', msg.classid);
                if(msg.isLogin == 0){
                    window.localStorage.removeItem('username');
                    window.localStorage.removeItem('md5password');
                    window.localStorage.removeItem('password');

                    window.localStorage.setItem('username', msg.username);
                    window.localStorage.setItem('md5password', msg.md5password);
                    window.localStorage.setItem('password', msg.password);
                }
            }
        }
    });
    return classid_str;
}