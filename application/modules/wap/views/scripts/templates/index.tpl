<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="baidu-site-verification" content="wRAn557dE3" />
	<title>久久健康网_中国领先的医疗健康门户网站9939.com</title>
	<meta name="description" content="久久健康网（9939.com）中国医疗健康领域权威的门户网站,联合国内权威医疗健康服务机构,为中国全民大健康提供全面、专业的医疗健康资讯.产品和服务." />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="black" name="apple-mobile-web-app-status-bar-style">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta content="telephone=no" name="format-detection">
	<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/common.css">
	<link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/index.css">
        <link rel="stylesheet" type="text/css" href="<{$smarty.const.__DOMAINURL__}>/css/other.css">
</head>
<!-- head -->
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd index-hd">
		<h1 class="logo"><a href="#"><img src="/images/logo.png" alt=""></a></h1>
		<div class="c-right">
        <!--
        <!--6.1 修改-->
			<!--<span>欢迎XX</span>-->
			<div class="personal">
				<a href="javascript:;" class="personal-btn"><img src="/images/i_dex.png"></a>
			</div>
			<!--<a href="#" class="favorites"></a>-->
		</div>
	</header>
    <!--6.1 修改-->
    <!--右上角快速导航 开始-->
        <{include file="navigation/fast_navigation.html"}>
    <!--右上角快速导航 结束-->
	<!-- header ends -->
	<!-- nav start -->
	<nav class="cfx">
		<ul>
			<li><a href="/baby/">母婴</a></li>
			<li><a href="/lady/">女性</a></li>
			<li><a href="/man/">男性</a></li>
			<li><a href="http://wapask.9939.com">问答</a></li>
			<li><a href="/oldman/">老人</a></li>
			<li><a href="/baojian/">保健</a></li>
			<li><a href="/js/">健身</a></li>
			<li><a href="/food/">饮食</a></li>
			<li><a href="/lx/">性爱</a></li>
			<li><a href="/beauty/">美容</a></li>
			<li><a href="/zx/">整形</a></li>
			<li><a href="/fitness/">减肥</a></li>
			<li><a href="/xinli/">心理</a></li>
            <li><a href="/tijian/">体检</a></li>
			<li><a href="/news/">新闻</a></li>
			<li><a href="/zhongyi/">中医</a></li>
			<li><a href="/nurse/">护理</a></li>
			<li><a href="/pianfang/">偏方</a></li>
			<li><a href="/navigation/keshi_navigation.html">更多</a></li>
		</ul>
	</nav>
	<!-- nav end -->
	<!-- banner start -->
	<div class="scroll relative">
        <div class="scroll_box" id="scroll_img" style="visibility: visible;">
            <ul class="scroll_wrap" style="width: 1280px;">
                <{foreach from=$zx_ads item=ads key=key}>
                    <{if $ads.imageurl neq ""}>
                        <li data-index="<{$key}>"><a href="<{$ads.linkurl}>"><img src="<{$ads.imageurl}>" width="100%" alt="<{$ads.adsname}>"><span><{$ads.adsname}></span></a></li>
                    <{else}>
                        <li data-index="<{$key}>"><a href="<{$ads.linkurl}>" title="<{$ads.adsname}>"><span><{$ads.adsname}></span></a></li>
                    <{/if}>
                <{/foreach}>               
            </ul>
        </div>
        <ul class="scroll_position" id="scroll_position">
            <li class="on"><a href="javascript:void(0);"></a></li>
            <li><a href="javascript:void(0);"></a></li>
            <li><a href="javascript:void(0);"></a></li>
            <li><a href="javascript:void(0);"></a></li>
            <li><a href="javascript:void(0);"></a></li>
        </ul>
    </div>
	<!-- banner end -->
	<!-- 搜索框 start -->
	<div class="maintop-search">
        <!--
		<div class="main-searchbox">
			<form action="">
				<input type="submit" class="sch-btn" value="">
				<div class="sch-txt-box">
					<input type="text" value placeholder="问久久24小时为您服务" class="sch-txt">
					<input type="text" class="sch-zx" readonly="readonly" value="资讯">
					<ul class="schbox">
						<li>疾病</li>
						<li>医院</li>
					</ul>
				</div>
			</form>
		</div>
        -->
		<div class="maintop-links cfx">
			<dl>
				<a href="http://wapask.9939.com/ask/goAskDoctor">
					<dt><img src="images/m-link-icon01.png" alt=""></dt>
					<dd>快速问医</dd>
				</a>
			</dl>
			<dl>
				<a href="/Disease/">
					<dt><img src="images/m-link-icon02.png" alt=""></dt>
					<dd>疾病自查</dd>
				</a>
			</dl>
			<dl>
				<a href="/Symptom/">
					<dt><img src="images/m-link-icon03.png" alt=""></dt>
					<dd>症状自查</dd>
				</a>
			</dl>
			<dl>
				<a href="/drug/">
					<dt><img src="images/m-link-icon04.png" alt=""></dt>
					<dd>药品常识</dd>
				</a>
			</dl>
		</div>
	</div>
	<!-- 搜索框 end -->
	<!-- 主内容 stars -->
	<section class="main-bd">
		<!-- 精彩问答 start -->
		<div class="main-jcwd pdbg">
			<h2 class="m-title"><span>精彩问答</span></h2>
			<ul class="mm-list">
            <{if $jc_ask}>
                <{foreach from=$jc_ask item=asks}>
    			   	<li><a href="/Ask/show?askid=<{$asks.id}>"><{$asks.title}></a></li>
                <{/foreach}>
            <{else}>
                    <li>暂无问答信息</li>
            <{/if}>
		    </ul>
		   <!-- <div class="Healthy-link"><a href="#">查看更多</a></div>-->
		</div>
		<!-- 精彩问答 end -->
        <!-- 百度联盟 开始 -->
        <script type="text/javascript">
        /*医疗信息上方20:3 创建于 2015-05-25*/
        var cpro_id = "u2120604";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
        <!-- 百度联盟 结束 -->
		<!-- 医疗信息 stars -->
		<div class="main-Healthy pdbg mt24">
			<h2 class="m-title"><span>医疗信息</span></h2>
			<ul class="Healthy-tit ylqx-tit cfx tab-hd">
	        	<li class="current"><a href="javascript:;">找医生</a></li>
	        	<li><a href="javascript:;">找医院</a></li>
	        	<li><a href="javascript:;">查疾病</a></li>
	        </ul>
	        <div class="tab-bd">
		        <div class="f-doctor healthy-tab">
			        <div class="doctorlist">
			        	<dl>
			        		<dt><img src="temps/hechangjian.jpg" alt=""></dt>
			        		<dd>
			        			<h3>贺常见</h3>
			        			<p>内科</p>
			        			<p>擅长：内科常见病多发病的诊断治疗</p>
			        		</dd>
			        		<a href="http://wapask.9939.com/ask/doctor/478027" class="a-tw">向ta提问</a>
			        	</dl>
			        	<dl>
			        		<dt><img src="temps/shihongyi.jpg" alt=""></dt>
			        		<dd>
			        			<h3>史艺红</h3>
			        			<p>妇产科</p>
			        			<p>擅长：妇科常见疾病优生优育的咨询</p>
			        		</dd>
			        		<a href="http://wapask.9939.com/ask/doctor/834864" class="a-tw">向ta提问</a>
			        	</dl>
			        	<dl>
			        		<dt><img src="temps/wenhai.jpg" alt=""></dt>
			        		<dd>
			        			<h3>温海</h3>
			        			<p>皮肤科</p>
			        			<p>擅长：各类皮肤病性病精通各种药理</p>
			        		</dd>
			        		<a href="http://wapask.9939.com/ask/doctor/203017" class="a-tw">向ta提问</a>
			        	</dl>
			        </div>
                    <!--
			        <div class="changeshow">
			        	<a href="#">换一批</a>
			        </div>
                    -->
			    </div>
		        <div class="f-hospita healthy-tab">
                    <!--
			        <div class="ylqx-select cfx">
			        	<label>
			        		<i class="ylqx-icon fore1"></i>
			        		<select>
			        			<option value="选择地区">选择地区</option>
			        		</select>
			        	</label>
			        	<label>
			        		<i class="ylqx-icon fore2"></i>
			        		<select>
			        			<option value="选择科室">选择科室</option>
			        		</select>
			        	</label>
			        </div>
                    -->
			        <div class="hospitalist">
			        	<dl>
			        		<dt><img src="temps/bjxh.jpg" alt=""></dt>
			        		<dd>
                            	<h4>中国人民解放军总医院</h4>
			        			<p><span>地址：</span>北京市东城区帅府园1号</p>
			        			<p><span>电话：</span>010-69156114</p>
			        			<p><span>官网：</span>www.pumch.cn</p>
			        		</dd>
			        	</dl>
			        	<dl>
			        		<dt><img src="temps/bjxh.jpg" alt=""></dt>
			        		<dd><h4>中国人民解放军总医院</h4>
			        			<p><span>地址：</span>北京市东城区天坛西里6号</p>
			        			<p><span>电话：</span>010-67096611</p>
			        			<p><span>官网：</span>http://www.bjtth.org</p>
			        		</dd>
			        	</dl>
			        </div>
                    <!--
			        <div class="changeshow">
			        	<a href="#">换一批</a>
			        </div>
                    -->
			    </div>
			    <div class="f-disease healthy-tab">
                    <!--
			    	<div class="ylqx-select cfx">
			        	<label>
			        		<i class="ylqx-icon fore2"></i>
			        		<select>
			        			<option value="选择科室">选择科室</option>
			        		</select>
			        	</label>
			        </div>
                    -->
			        <ul class="cfx">
			        	<li><a href="/Disease/140676.shtml">心绞痛</a></li>
			        	<li><a href="/Disease/140041.shtml">前列腺增生</a></li>
			        	<li><a href="/Disease/139944.shtml">尿失禁</a></li>
			        	<li><a href="/Disease/138875.shtml">动脉硬化</a></li>
			        	<li><a href="/Disease/139250.shtml">冠心病</a></li>
			        	<li><a href="/Disease/139482.shtml">甲亢</a></li>
			        	<li><a href="/Disease/139112.shtml">感冒</a></li>
			        	<li><a href="/Disease/140145.shtml">弱视</a></li>
			        	<li><a href="/Disease/139109.shtml">肝硬化</a></li>
			        	<li><a href="/Disease/139414.shtml">急性阑尾炎</a></li>
			        	<li><a href="/Disease/141041.shtml">脂肪肝</a></li>
			        	<li><a href="/Disease/139817.shtml">慢性肾炎</a></li>
			        	<li><a href="/Disease/139022.shtml">肺炎</a></li>
			        	<li><a href="/Disease/139939.shtml">尿毒症</a></li>
			        	<li><a href="/Disease/140238.shtml">肾结石</a></li>
			        	<li><a href="/Disease/139146.shtml">高血脂</a></li>
			        	<li><a href="/Disease/140357.shtml">糖尿病</a></li>
			        	<li><a href="/Disease/141127.shtml">子宫息肉</a></li>
			        	<li><a href="/Disease/140388.shtml">痛风</a></li>
			        	<li><a href="/Disease/140855.shtml">药物过敏</a></li>
			        	<li><a href="/Disease/139921.shtml">脑血栓</a></li>
			        	<li><a href="/Disease/139910.shtml">脑膜炎</a></li>
			        	<li><a href="/Disease/141076.shtml">痔疮</a></li>
			        	<li><a href="/Disease/141149.shtml">哮喘病</a></li>
			        </ul>
                    <!--
			        <div class="changeshow">
			        	<a href="#">换一批</a>
			        </div>
                    -->
			    </div>
			</div>
		</div>
		<!-- 医疗信息 ends -->
        <!-- 百度联盟 开始-->
        <script type="text/javascript">
        /*wap健康资讯上方20:3 创建于 2015-05-25*/
        var cpro_id = "u2120601";
        </script>
        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
        <!-- 百度联盟 结束-->
		<!-- 健康资讯 stars -->
		<div class="main-Healthy pdbg mt24">
			<h2 class="m-title"><span>健康资讯</span></h2>
			<!-- 进入母婴频道 stars -->
			<ul class="Healthy-tit tab-hd cfx">
	        	<li class="current"><a href="javascript:;">男性</a></li>
	        	<li><a href="javascript:;">女性</a></li>
	        	<li><a href="javascript:;">老人</a></li>
	        	<li><a href="javascript:;">母婴</a></li>
	        </ul>
	        <div class="tab-bd">
	        	<div class="healthy-tab" style="display:block;">
                	<ul class="Healthy-list">
				        <{if $art_male}>
                                         <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_male item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_male}>
                        <div class="Healthy-link">
                        <{foreach from=$art_male item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入男性频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_nvxing}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_nvxing item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_nvxing}>
                        <div class="Healthy-link">
                        <{foreach from=$art_nvxing item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入女性频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
                	<ul class="Healthy-list">
                             <li><{include file="ads/ads_index_flow.html"}></li>
						<{if $art_laoren}>
                        <{foreach from=$art_laoren item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_laoren}>
                        <div class="Healthy-link">
                        <{foreach from=$art_laoren item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入老人频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
                                             <li><{include file="ads/ads_index_flow.html"}></li>
                        <{if $art_baby}>
                        <{foreach from=$art_baby item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_baby}>
                        <div class="Healthy-link">
                        <{foreach from=$art_baby item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入母婴频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
			</div>
			<!-- 进入母婴频道 ends -->
			<!-- 进入保健频道 stars -->
			<ul class="Healthy-tit tab-hd cfx">
	        	<li class="current"><a href="javascript:;">饮食</a></li>
	        	<li><a href="javascript:;">减肥</a></li>
	        	<li><a href="javascript:;">健身</a></li>
	        	<li><a href="javascript:;">美容</a></li>
	        </ul>
	        <div class="tab-bd">
	        	<div class="healthy-tab" style="display:block;">
                    <ul class="Healthy-list">
						<{if $art_yinshi}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_yinshi item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_yinshi}>
                        <div class="Healthy-link">
                        <{foreach from=$art_yinshi item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入饮食频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_jf}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_jf item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_jf}>
                        <div class="Healthy-link">
                        <{foreach from=$art_jf item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入减肥频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
                	<ul class="Healthy-list">
						<{if $art_jianshen}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_jianshen item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_jianshen}>
                        <div class="Healthy-link">
                        <{foreach from=$art_jianshen item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入健身频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_meirong}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_meirong item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_meirong}>
                        <div class="Healthy-link">
                        <{foreach from=$art_meirong item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入美容频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
			</div>
			<!-- 进入保健频道 ends -->
			<!-- 进入美容频道 stars -->
			<ul class="Healthy-tit tab-hd cfx">
	        	<li class="current"><a href="javascript:;">两性</a></li>
	        	<li><a href="javascript:;">心理</a></li>
	        	<li><a href="javascript:;">保健</a></li>
	        	<li><a href="javascript:;">整形</a></li>
	        </ul>
	        <div class="tab-bd">
	        	<div class="healthy-tab" style="display:block;">
                	<ul class="Healthy-list">
						<{if $art_xa}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_xa item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_xa}>
                        <div class="Healthy-link">
                        <{foreach from=$art_xa item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入两性频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_xinli}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_xinli item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_xinli}>
                        <div class="Healthy-link">
                        <{foreach from=$art_xinli item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入心理频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
                    <ul class="Healthy-list">
						<{if $art_bj}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_bj item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_bj}>
                        <div class="Healthy-link">
                        <{foreach from=$art_bj item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入保健频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_zhengxing}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_zhengxing item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_zhengxing}>
                        <div class="Healthy-link">
                        <{foreach from=$art_zhengxing item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入整形频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
			</div>
			<!-- 进入美容频道 ends -->
            <!-- 进入频道 stars -->
			<ul class="Healthy-tit tab-hd cfx">
	        	<li class="current"><a href="javascript:;">中医</a></li>
	        	<li><a href="javascript:;">护理</a></li>
	        	<li><a href="javascript:;">偏方</a></li>
	        	<li><a href="javascript:;">体检</a></li>
	        </ul>
	        <div class="tab-bd">
	        	<div class="healthy-tab" style="display:block;">
                	<ul class="Healthy-list">
						<{if $art_zy}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_zy item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_zy}>
                        <div class="Healthy-link">
                        <{foreach from=$art_zy item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入中医频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_huli}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_huli item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_huli}>
                        <div class="Healthy-link">
                        <{foreach from=$art_huli item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入护理频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
                    <ul class="Healthy-list">
						<{if $art_pf}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_pf item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_pf}>
                        <div class="Healthy-link">
                        <{foreach from=$art_pf item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入偏方频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
				<div class="healthy-tab">
					<ul class="Healthy-list">
						<{if $art_tijian}>
                                                 <li><{include file="ads/ads_index_flow.html"}></li>
                        <{foreach from=$art_tijian item=arts}>
            			   	<li><a href="<{$arts.art_base_path}>/<{$arts.articleid}>.shtml"><{$arts.title}></a></li>
                        <{/foreach}>
                        <{else}>
                            <li>暂无信息</li>
                        <{/if}>
					</ul>
                    <{if $art_tijian}>
                        <div class="Healthy-link">
                        <{foreach from=$art_tijian item=arts key=key}>
    					   <{if $key eq 0}><a href="<{$arts.channel}>">进入体检频道</a><{/if}>
                        <{/foreach}>
                        </div>
                    <{/if}>
				</div>
			</div>
			<!-- 进入频道 ends -->
		</div>
		<!-- 健康资讯 ens -->
	</section>
	<!-- 主内容 ends -->
	<!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</div>
</body>
<script src="/js/zepto.js"></script>
<script src="/js/hhSwipe.js"></script>
<script src="/js/sea.js"></script>
<script>
	
	var slider = Swipe(document.getElementById('scroll_img'), {
		auto: 3000,
		continuous: true,
		callback: function(pos) {
			var i = bullets.length;
			while (i--) {
				bullets[i].className = ' ';
			}
			bullets[pos].className = 'on';
		}
	});
	var bullets = document.getElementById('scroll_position').getElementsByTagName('li');
	$(function(){
		$('.scroll_position_bg').css({
			width:$('#scroll_position').width()
		});
	});
</script>
<script type="text/javascript">
	seajs.use("play.js")	
</script>
</html>