<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>症状自查</title>
	<meta name="description" content="页面描述" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta content="telephone=no" name="format-detection">
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link rel="stylesheet" type="text/css" href="/css/index.css">
        <link rel="stylesheet" type="text/css" href="/css/other.css">
</head>
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd personal-hd">
        <a href="/" class="c_logo">首页</a>
		<h2 class="main-hd-bt">症状自查</h2>       
		<div class="hd-right">
			<!--6.1 修改-->
			<div class="personal">
				<a href="javascript:;" class="personal-btn"><img src="/images/f_sym.png"></a>
			</div>
         <!--ends-->
		</div>
  </header>
  <!--6.1 修改-->
  <!--右上角快速导航 开始-->
    <{include file="navigation/fast_navigation.html"}>
  <!--右上角快速导航 结束-->
	<!-- header ends -->
	<!-- 内容stars-->
	<div class="main-bd">
		<div class="zzzc-w pfzz-w" id="the11">
			<h1 class="pfzz-tit zzzc-tt">按人体查找</h1>
			<div class="zzzc-contmen">
				<img class="z-img-bg" src="/temps/personal-men.png" alt="">
				<div class="zzzc-brain zzzc-all">
					<a href="/Symptom/position/?id=1748">[头]眼耳口鼻</a>
				</div>
				<div class="zzzc-skin zzzc-all">
					<a href="/Symptom/position/?id=2882">皮肤</a>
				</div>
				<div class="neck zzzc-all">
					<a href="/Symptom/position/?id=1754">颈部</a>
				</div>
				<div class="chest zzzc-all">
					<a href="/Symptom/position/?id=2875">胸部</a>
				</div>
				<div class="limb1 zzzc-all">
					<a href="/Symptom/position/?id=1756">上肢</a>
				</div>
				<div class="limb2 zzzc-all">
					<a href="/Symptom/position/?id=1756">上肢</a>
				</div>
				<div class="belly zzzc-all">
					<a href="/Symptom/position/?id=2877">腹部</a>
				</div>
				<div class="engender zzzc-all">
					<a href="/Symptom/position/?id=2884">生殖部位</a>
				</div>
				<!--<div class="excrete zzzc-all">
					<a href="#">排泄部位</a>
				</div>-->
				<div class="legs1 zzzc-all">
					<a href="/Symptom/position/?id=2874">下肢</a>
				</div>
				<div class="legs2 zzzc-all">
					<a href="/Symptom/position/?id=2874">下肢</a>
				</div>
			</div>
		</div>
        <div class="zzzc-w pfzz-w hidden" id="the21">
			<h1 class="pfzz-tit zzzc-tt">按人体查找</h1>
            <div class="zzzc-contmen">
				<img class="z-img-bg" src="/temps/personal-la.png" alt="">
				<div class="zzzc-brain zzzc-all">
					<a href="/Symptom/position/?id=1748">[头]眼耳口鼻</a>
				</div>
				<div class="zzzc-skin zzzc-all">
					<a href="/Symptom/position/?id=2882">皮肤</a>
				</div>
				<div class="neck zzzc-all">
					<a href="/Symptom/position/?id=1754">颈部</a>
				</div>
				<div class="chest zzzc-all">
					<a href="/Symptom/position/?id=2875">胸部</a>
				</div>
				<div class="limb1 zzzc-all">
					<a href="/Symptom/position/?id=1756">上肢</a>
				</div>
				<div class="limb2 zzzc-all">
					<a href="/Symptom/position/?id=1756">上肢</a>
				</div>
				<div class="belly zzzc-all">
					<a href="/Symptom/position/?id=2877">腹部</a>
				</div>
				<div class="engender zzzc-all">
					<a href="/Symptom/position/?id=2885">生殖部位</a>
				</div>
				<!--<div class="excrete zzzc-all">
					<a href="#">排泄部位</a>
				</div>-->
				<div class="legs1 zzzc-all">
					<a href="/Symptom/position/?id=2874">下肢</a>
				</div>
				<div class="legs2 zzzc-all">
					<a href="/Symptom/position/?id=2874">下肢</a>
				</div>
			</div>
		</div>
        <div class="sexc"><a class="hhh" id="tab11" onclick="toggleMenu('1','1');">男</a><a id="tab21" onclick="toggleMenu('2','1');">女</a></div>
	</div>
	<!-- 内容ends-->
	<!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</div>
</body>
<script type="text/javascript">setTimeout(show_tanchuang,10000);function toggleMenu(the,id){for(i=1;i<=2;i++){if(i==the){document.getElementById('tab'+i+id).className='hhh';document.getElementById('the'+i+id).className=''}else{document.getElementById('tab'+i+id).className='';document.getElementById('the'+i+id).className='hidden'}}}var sec=1000;var cou=20;function close_tanchuang(s){document.getElementById("tanchuang").className='hidden';if(s==1){setTimeout(show_tanchuang,sec*cou);cou=cou+18}}function show_tanchuang(){document.getElementById("tanchuang").className=''}</script>
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript">
    seajs.use("play.js")
</script>
</html>