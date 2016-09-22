<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><{$user.username}>的个人页面_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="久久问医,<{$user.username}>的个人页面" />
<meta name="description" content="久久问医<{$user.username}>的空间、个人信息页面." />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
    <link rel="stylesheet" type="text/css" href="/css/other.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/page.js"></script>
<script src="/js/gundong.js"></script>
<script src="/js/top_nav.js?123456"></script>

</head>


<body>
<!--header-->
<header>
	<a href="javascript:window.history.back();"></a>
	<a href="javascript:">个人中心</a>
    <div class="hd-right">
        <div class="personal">
            <a href="javascript:;" class="personal-btn"></a>
        </div>
    </div>
	</header>
    <{include file="navigation/fast_navigation_ask.html"}>
<!--ends-->

<div class="blahe"></div>
<section class="persc">
    <article class="detai">
    	<span><img src="<{$user.pic}>"></span>
    	<span><{$user.nickname}></span>
    </article>
    <ul class="spest">
    	<li><a href="javascript:"><span><img src="/images/per_01.png"></span><span>会员等级</span><span class="level"><{$user.groupname}></span></a></li>
    	<li><a href="http://wapask.9939.com/doctor/userdetail?userid=<{$user.uid}>"><span><img src="/images/per_02.png"></span><span>个人资料</span></a></li>
        <li><a href="http://wapask.9939.com/ask/userasklist?userid=<{$user.uid}>"><span><img src="/images/per_03.png"></span><span>我的提问</span></a></li>
        <li><a href="http://wapask.9939.com/doctor/gousermsg?userid=<{$user.uid}>"><span><img src="/images/per_04.png"></span><span>消息</span></a></li>
        <li><a href="http://wapask.9939.com/doctor/bindtel?userid=<{$user.uid}>"><span><img src="/images/per_05.png"></span><span>绑定手机</span></a></li>
        <li><a href="http://wapask.9939.com/doctor/goupdatepd?userid=<{$user.uid}>"><span><img src="/images/per_05.png"></span><span>修改密码</span></a></li>
    </ul>
</section>
<article class="finmo shmor logout" style="padding: 0.2rem 0px;"><a href="javascript:" id="logout">退出登录</a></article>
	
	<input type = "hidden" value = "<{$user.uid}>" id = "hidden_userid" />
	<input type = "hidden" value = "<{$user.username}>" id = "hidden_username" />
	<input type = "hidden" value = "<{$login}>" id = "isLogin" />
	<iframe id="child" src="http://m.9939.com/iframe.php?userid=<{$user.uid}>&username=<{$user.username}>&r=<{time()}>" style = "display: none;"></iframe>
	<iframe id="remove" src="" style = "display: none;"></iframe>
	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->
	
	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->
	
	<script>
                var is_login = '<{$login}>';
		$(document).ready(function(){
		
			//如果是登录成功，则将当前用户的 id 保存到本地缓存中
			if(parseInt(is_login)==1){
				window.localStorage.removeItem('userid');
				window.localStorage.removeItem('username');
				window.localStorage.setItem('userid', $("#hidden_userid").val());
				window.localStorage.setItem('username', $("#hidden_username").val());

                            //添加 m.9939.com 中的本地缓存(userid)
                            $("#child").attr("src", "http://m.9939.com/iframe.php?userid=" + $("#hidden_userid").val() + "&username="+ $("#hidden_username").val() +"&id=" + Math.random());
                        }
		});
		
		$("#logout").on('click', function(){
			window.localStorage.removeItem('userid');
			window.localStorage.removeItem('username');
                        
                        //删除 m.9939.com 中的本地缓存(userid)
                        var rd = Math.random();
                        var clear_url = 'http://m.9939.com/remove.php?r='+rd;
                        $("#remove").attr('src',clear_url);
                        var url = 'http://wapask.9939.com/login/logout?userid=' + $("#hidden_userid").val();
                        window.location.href = url;  
		});
	</script>

</body>
</html>
