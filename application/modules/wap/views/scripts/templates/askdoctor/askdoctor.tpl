<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>在线医生_快速问医生_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="在线医生,快速问医生,久久问医" />
<meta name="description" content="久久问医中国权威的在线医生健康问答平台.万名医生24小时在线提供优质、专业、及时的医疗健康咨询服务,快速问医生上久久问医." />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<link rel="canonical" href="http://ask.9939.com/" >

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/gundong.js"></script>
<script src="/js/page.js"></script>
<script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
<script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
<script type="text/javascript" src="/js/slide.js"></script>

</head>


<body class="bodb">
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">久久问医</h2>
	
	<!-- 右侧快捷按钮 Start -->
	<div class="hd-right">
		<div class="personal">
			<a href="javascript:;" class="personal-btn"></a>
		</div>
     <!--ends-->   
	</div>
</article>
<{include file="navigation/fast_navigation_ask.html"}>
<!-- 右侧快捷按钮 End -->	
	
	
<!-- 主体内容部分 Start -->
	
	
	<!-- 搜索部分 Start -->
    <article class="sead">
        <input type="text" id = "searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id = "searchBtn" style="background-size:0.45rem 0.45rem;"></a>
        <script>
            //设置 搜索 部分的 a 的 href 值
            $("#searchBtn").on('click', function(){
                var searchWords = $("#searchWords").val();

                $(this).attr("href", "/search/" + encodeURI(searchWords) + "/1");
            });
        </script>
    </article>
	
	<article class="hoser">
        <span>热搜：</span>
        <div>
            <a href="/disease/36.html">冠心病</a>
            <a href="/disease/34.html">高血压</a>
            <a href="/disease/43.html">糖尿病</a>
            <a href="/disease/145.html">乳腺癌</a>
            <a href="/disease/201.html">子宫肌瘤</a>
            <a href="/hot/">热词</a>
            <a href="http://wapask.9939.com/jingyan/">健康经验</a>
        </div>
	</article>
	<!-- 搜索部分 End -->
	
	
	<!-- 医生部分 Start -->
	<div class="thre"></div>
	<h3 class="reask ondoc">
        在线医生
	</h3>

        <ul class="docinf">
		<li>
			<a href="/doctor/detail/1440561.html"  >
				<img src="http://home.9939.com//upload/pic/201601/1440561_avatar_middle.jpg" alt="陶丽萍" title="陶丽萍" height="64" width="64">
			</a>
			<div>
				<h3>
					<a href="/doctor/detail/1440561.html"  title = "陶丽萍">陶丽萍</a>
				</h3>
				<p>医师</p>
				<a href="/ask/doctor/1440561"  class="suqu" >
					提问
				</a>
			</div>			
		</li>
		<li>
			<a href="/doctor/detail/312932.html"  >
				<img src="http://home.9939.com//upload/pic/201504/312932_avatar_middle.jpg" alt="刘兴志" title="刘兴志" height="64" width="64">
			</a>
			<div>
				<h3>
					<a href="/doctor/detail/312932.html"  title = "刘兴志">刘兴志</a>
				</h3>
				<p>医师</p>
				<a href="/ask/doctor/312932"  class="suqu" >
					提问
				</a>
			</div>
		</li>
		<li>
			<a href="/doctor/detail/334752.html"  >
				<img src="http://home.9939.com//upload/pic/201504/334752_avatar_middle.jpg" alt="高爱萍" title="高爱萍" height="64" width="64">
			</a>
			<div>
				<h3>
					<a href="/doctor/detail/334752.html"  title = "高爱萍">高爱萍</a>
				</h3>
				<p>医师</p>
				<a href="/ask/doctor/334752"  class="suqu">
					提问
				</a>
			</div>
		</li>
		<li>
			<a href="/doctor/detail/821899.html"  >
				<img src="http://home.9939.com/upload/pic//201406/821899_avatar_middle.jpg" alt="余惠平" title="余惠平" height="64" width="64">
			</a>
			<div>
				<h3>
					<a href="/doctor/detail/821899.html"  title = "余惠平">余惠平</a>
				</h3>
				<p>医师</p>
				<a href="/ask/doctor/821899"  class="suqu" >
					提问
				</a>
			</div>	
		</li>
	</ul>

	<article class="finmo shmor">
		<a href="/doctor">查看更多医生&nbsp;></a>
	</article>
	<div class="thre"></div>
	<!-- 医生部分 End -->
	
	
	<!-- 自主提问部分 Start -->
    <a href="/ask/goAskDoctor" class="fread">
        <img src="/images/logo.jpg" alt="">
        <h3>专家与您一对一答疑</h3>
        <p>
            <span>免费提问</span>及时解答
        </p>
    </a>
    <div class="thre"></div>
	<!-- 自主提问部分 End -->
	
	<!-- 广告位部分 Start -->
	<article>
		<{include file="ads/ads_askDoctor_01.html"}>
	</article>	
	<!-- 广告位部分 End -->
	
	
	<!-- 常见疾病部分 Start -->
	<h3 class="reask">常见疾病</h3>
	<div class="main_visual">
		<div class="flicking_con">
			<a href="#">1</a> <a href="#">2</a>
		</div>
		
		<div class="main_image extra" id = "commonDisease">
		<ul>
			<li>
					<h4 class="whid">
						<a onClick="divTag('n3Tab33', 'indexahover', '', 1, 0)"
							name="n3Tab33" id="n3Tab33" class="indexahover"><span>咳嗽</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 2, 0)"
							name="n3Tab33" id="n3Tab33"><span>感冒</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 3, 0)"
							name="n3Tab33" id="n3Tab33"><span>白癜风</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 4, 0)"
							name="n3Tab33" id="n3Tab33"><span>甲亢</span></a>
					</h4>
					
					<{foreach $commonDiseaseArr[0] as $key => $specifyDiseaseArr }>
						<section name="n3Tab33Content" id="n3Tab33Content" <{if $key != 0 }>style="display:none;"<{/if}> >
							<dl class="heal">
								<{foreach  $specifyDiseaseArr.data as  $specifyDiseaseKey =>  $specifyDisease}>
									<dd>
										<a href="/id/<{$specifyDisease.id}>.html" title = "<{$specifyDisease.title}>"><{$specifyDisease.shorttitle}></a>
									</dd>
								<{/foreach}>
							</dl>
							<article class="finmo">
								<a href="/disease/<{$specifyDiseaseArr.classid}>.html">
									查看<{$commonDiseaseIDMap[0][$specifyDisease.classid]}>更多问题&nbsp;>
								</a>
							</article>
							
						</section>
					<{/foreach}>
				</li>

				<li>
					<h4 class="whid">
						<a onClick="divTag('n4Tab44', 'indexahover', '', 1, 0)"
							name="n4Tab44" id="n4Tab44" class="indexahover"><span>月经不调</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 2, 0)"
							name="n4Tab44" id="n4Tab44"><span>流产</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 3, 0)"
							name="n4Tab44" id="n4Tab44"><span>鼻炎</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 4, 0)"
							name="n4Tab44" id="n4Tab44"><span>肛肠疾病</span></a>
					</h4>
					
					<{foreach $commonDiseaseArr[1] as $key => $specifyDiseaseArr }>
						<section name="n4Tab44Content" id="n4Tab44Content" <{if $key != 0 }>style="display:none;"<{/if}> >
							<dl class="heal">
								<{foreach  $specifyDiseaseArr.data as  $specifyDiseaseKey =>  $specifyDisease}>
									<dd>
										<a href="/id/<{$specifyDisease.id}>.html" title = "<{$specifyDisease.title}>"><{$specifyDisease.shorttitle}></a>
									</dd>
								<{/foreach}>
							</dl>
							<article class="finmo">
								<a href="/disease/<{$specifyDiseaseArr.classid}>.html">
									查看<{$commonDiseaseIDMap[1][$specifyDisease.classid]}>更多问题&nbsp;>
								</a>
							</article>
						</section>
					<{/foreach}>					
				</li>
			</ul>
		</div>
		
		<a href="javascript:void(0);" id="btn_prev"></a> 
		<a href="javascript:void(0);" id="btn_next"></a>
	</div>
	<!-- 常见疾病部分 End -->


	<!-- 科室部分 Start  -->
	<div class="thre"></div>
	<h3 class="reask">疾病科室</h3>
	<ul class="disho" id = "department">
		<li><dl>
				<dt>
					<a href="/classid/32.html">内科</a>
				</dt>
				<dd> 
					<a href="/classid/33.html">心血管内科</a>
				</dd>
				<dd>
					<a href="/classid/69.html">神经内科</a>
				</dd>
				<dd>
					<a href="/classid/95.html">肾内科</a>
				</dd>
				<dd>
					<a href="/classid/56.html">消化内科</a>
				</dd>
				<dd>
					<a href="/classid/42.html">内分泌科</a>
				</dd>
				<dd>
					<a href="/classid/87.html">血液科</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt>
					<a href="/classid/102.html">外科</a>
				</dt>
				<dd>
					<a href="/classid/166.html">普外科</a>
				</dd>
				<dd>
					<a href="/classid/111.html">心胸外科</a>
				</dd>
				<dd>
					<a href="/classid/118.html">泌尿外科</a>
				</dd>
				<dd>
					<a href="/classid/149.html">肛肠外科</a>
				</dd>
				<dd>
					<a href="/classid/143.html">乳腺外科</a>
				</dd>
				<dd>
					<a href="/classid/159.html">肝胆外科</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt>
					<a href="/classid/193.html">妇科</a>
				</dt>
				<dd>
					<a href="/classid/194.html">妇科</a>
				</dd>
				<dd>
					<a href="/classid/208.html">产科</a>
				</dd>
				<dd>
					<a href="/classid/219.html">避孕流产</a>
				</dd>
				<dd>
					<a href="/classid/195.html">月经不调</a>
				</dd>
				<dd>
					<a href="/classid/199.html">痛经</a>
				</dd>
				<dd>
					<a href="/classid/197.html">宫颈糜烂</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt>
					<a href="/classid/236.html">儿科</a>
				</dt>
				<dd>
					<a href="/classid/237.html">小儿内科</a>
				</dd>
				<dd>
					<a href="/classid/248.html">小儿心理</a>
				</dd>
				<dd>
					<a href="/classid/256.html">小儿外科</a>
				</dd>
				<dd>
					<a href="/classid/534.html">小儿急救</a>
				</dd>
				<dd>
					<a href="/classid/239.html">小儿感冒</a>
				</dd>
				<dd>
					<a href="/classid/243.html">小儿肺炎</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt>
					<a href="/classid/220.html">男科</a>
				</dt>
				<dd>
					<a href="/classid/221.html">男性科</a>
				</dd>
				<dd>
					<a href="/classid/232.html">前列腺科</a>
				</dd>
				<dd>
					<a href="/classid/545.html">包皮过长</a>
				</dd>
				<dd>
					<a href="/classid/544.html">早泄</a>
				</dd>
				<dd>
					<a href="/classid/543.html">阳痿</a>
				</dd>
				<dd>
					<a href="/classid/546.html">遗精</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt style="height: 4.6em; padding-top: 0.2em;">
					<a href="/classid/276.html">五官科</a>
				</dt>
				<dd>
					<a href="/classid/277.html">眼科</a>
				</dd>
				<dd>
					<a href="/classid/291.html">口腔科</a>
				</dd>
				<dd>
					<a href="/classid/284.html">耳鼻喉科</a>
				</dd>
				<dd>
					<a href="/classid/285.html">鼻炎</a>
				</dd>
				<dd>
					<a href="/classid/286.html">鼻出血</a>
				</dd>
				<dd>
					<a href="/classid/287.html">鼻息肉</a>
				</dd>
			</dl></li>
		<li><dl>
				<dt>
					<a href="/classid/523.html">性病</a>
				</dt>
				<dd>
					<a href="/classid/331.html">性病科</a>
				</dd>
				<dd>
					<a href="/classid/339.html">皮肤科</a>
				</dd>
				<dd>
					<a href="/classid/335.html">性交疼</a>
				</dd>
				<dd>
					<a href="/classid/332.html">淋病</a>
				</dd>
				<dd>
					<a href="/classid/333.html">梅毒</a>
				</dd>
				<dd>
					<a href="/classid/334.html">尖锐湿疣</a>
				</dd>
			</dl></li>
	</ul>

	<article class="finmo shmor">
		<a href="/department/list.html">查看更多常见科室&nbsp;></a>
	</article>
	<!-- 科室部分 End  -->
<!-- 主体内容部分 End -->
	
	
	<!-- 底部 部分 Start -->
	<{include file="footer/ask_doctor_index_footer.html"}>
	<!-- 底部 部分 End -->

	<script src="/js/sea.js"></script>
	
	<script type="text/javascript">
		seajs.use("play.js");
		seajs.use("askdoctor.js");	
		seajs.use("detail.js");
	</script>

    <!-- 统计功能 Start -->
    <{include file="ads/wap_ask_stat_index.html"}>
    <!-- 统计功能 End -->
	
</body>
</html>
