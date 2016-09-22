<!doctype html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$askInfo.title}>_<{$askInfo.classname}>_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="<{$askInfo.title}>" />
<meta name="description" content="<{$askInfo.title}> <{$askInfo.content|mb_substr:0:20:'utf-8'}>" />
<meta
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
	name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/1125.css">
    <link rel="stylesheet" type="text/css" href="/css/other.css">

<link rel="canonical" href="http://ask.9939.com/id/<{$askInfo.id}>" >

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/gundong.js"></script>
<script src="/js/page.js"></script>
    <script src="/js/top_nav.js"></script>

</head>


<body class="bodb">
	<!--header-->
	<header>
        <a href="javascript:window.history.back();"></a>
		<a href="javascript:">
            <{if isset($qlx_ads) && !empty($qlx_ads)}>
            <{$qlx_ads}>
            <{/if}>
            疾病详情
        </a>
		<!--<a href="" class="circ" id = "usercenterID"></a>-->

        <!-- 右侧快捷按钮 Start -->
        <div class="hd-right">
            <div class="personal">
                <a href="javascript:;" class="personal-btn"></a>
            </div>
        </div>
        <!--ends-->

    </header>

    <{include file="navigation/fast_navigation_ask.html"}>

	<!--ends-->
	<div class="blahe"></div>

	<nav>
		<a href="http://m.9939.com/" title = "">首页</a>>
		<a href="http://wapask.9939.com" title = "问医">问医</a>>
		<a href="/disease/<{$askInfo.classid}>.html" title = "<{$askInfo.classname}>"><{$askInfo.classname}></a>>
		<a href="javascript:" title = "疾病详情">疾病详情</a>
	</nav>
        <div>
            <script type="text/javascript">
                /*问答wap端内容详情页标题上方*/
                var cpro_id = "u2753446";
            </script>
            <script type="text/javascript" src="http://jsm.9939.com/cpro/ui/cm.js"></script>
        </div>

	<article class="symp">
		<h1><{$askInfo.title}></h1>
	</article>
	<article class="sick">
		<h3>
			病情描述：<span>(<{$askInfo.sexnn}><{if $askInfo.age != 0 }>，<{$askInfo.age}>岁<{/if}>)</span>
		</h3>
		<p><{$askInfo.content}></p>

		<{if isset($askInfo.help) && !empty($askInfo.help) }>
			<div style = "height: 20px;"></div>
			<div style = "height: 20px; font-size: 1.2em; color:#999; ">想要得到的帮助：</div><p><{$askInfo.help}></p>
		<{/if}>

		<aside><{$askInfo.ctime}></aside>
	</article>

    <{include file="ads/ads_ask_answer_detail_statis.html"}>

    <h3 class="reask">医生问答</h3>

	<!-- 医生的回答部分 Start -->
	<{foreach $askDoctorAnswer as $key => $doctorAnswer }>
		<{if count($doctorAnswer.doctor) != 0  }>
			<article class="doctor docbo docur">
				<div>
					<img src="<{$doctorAnswer.doctor.pic}>" alt="<{$doctorAnswer.doctor.truename}>" title = "<{$doctorAnswer.doctor.truename}>" >
				</div>
				<div>
					<p>
						<span><{$doctorAnswer.doctor.truename}></span><{$doctorAnswer.doctor.zhicheng}>
					</p>
					<p>
						<{$doctorAnswer.doctor.doc_keshi}>
					</p>
				</div>
				<div>
					<a href="/ask/doctor/<{$doctorAnswer.doctor.uid}>">向TA提问</a>
				</div>
			</article>
		<{/if}>
		<article class="sick disein">
			<p>
				<b>病情分析：</b> <{$doctorAnswer.answer.content}>
			</p>

			<{if isset($doctorAnswer.answer.suggest) && !empty($doctorAnswer.answer.suggest) }>
				<p> <b>指导意见：</b> <{$doctorAnswer.answer.suggest}></p>
			<{/if}>

		</article>
	<{/foreach }>
	<!-- 医生的回答部分 End -->

    <div class="thre"></div>
    <a href="/ask/goAskDoctor" class="fread">
        <img src="/images/logo.jpg" alt="">
        <h3>专家与您一对一答疑</h3>
        <p><span>免费提问</span>及时解答</p>
    </a>
    <div class="thre"></div>

	<article class="know adv">
		<{include file="ads/ads_askAnswerDetail_01.html"}>
	</article>

	<h3 class="reask">相关问答</h3>
	<ul class="ques">
		<{foreach $relateAskInfoArr as $key => $relateAskInfo  }>
			<li>
				<span><{$relateAskInfo.answernum}>条回复</span>
				<a href="/id/<{$relateAskInfo.id}>.html" title = "<{$relateAskInfo.title}>"><{$relateAskInfo.shorttitle}></a>
			</li>
		<{/foreach}>
	</ul>

    <article class="hoimg">
        <h3 class="reask">热图推荐</h3>
        <section class="floor-item-d">
            <div class="main_visual">
                <div class="flicking_con">
                    <{if isset($ads_hotpic) && !empty($ads_hotpic)}>
                    <{foreach $ads_hotpic as $key => $hotPic}>
                    <{if $key is even}>
                    <a href="#"><{($key/2) + 1}></a>
                    <{/if}>
                    <{/foreach}>
                    <{/if}>
                </div>
                <div class="main_image">
                    <ul class="d-durse clearfix">
                        <{if isset($ads_hotpic)}>
                        <{foreach from=$ads_hotpic item=val key=key}>
                        <{if $key is even}>
                        <li>
                        <{/if}>
                        <div class="louts"><a href="<{$val.linkurl}>"><img src="<{$val.imageurl}>"  alt="<{$val.adsname}>" title="<{$val.adsname}>"></a><span><{$val.adsname}></span></div>
                        <{if $key is odd}>
                        </li>
                        <{/if}>
                        <{/foreach}>
                        <{/if}>
                    </ul>
                </div>
            </div>
        </section>

        <div class="adv_05">
            <script type="text/javascript">
                /*问答wap端内容详情页热图推荐下方*/
                var cpro_id = "u2753459";
            </script>
            <script type="text/javascript" src="http://jsm.9939.com/cpro/ui/cm.js"></script>
        </div>
    </article>

<!-- 	<article class="finmo shmor">
		<a href="">显示更多医生</a>
	</article> -->

	<article class="know adv">
		<{include file="ads/ads_askAnswerDetail_02.html"}>
	</article>

	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_footer.html"}>
	<!-- 底部 部分 End -->

	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->

</body>
</html>
