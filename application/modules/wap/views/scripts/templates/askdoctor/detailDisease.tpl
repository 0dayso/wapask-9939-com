<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><{$diseaseName}>_疾病列表_久久问医</title>

<meta name="baidu-site-verification" content="wRAn557dE3" />
<meta name="keywords" content="<{$diseaseName}>疾病,久久问医" />
<meta name="description" content="久久问医为您提供<{$diseaseName}>疾病方面的症状、预防、保健、治疗、诊断、用药等方面的问题及在线医生解答." />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta http-equiv="Cache-Control" content="no-cache">
<meta content="telephone=no" name="format-detection">

<link rel="stylesheet" type="text/css" href="/css/body.css">
<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/index.css">
<link rel="stylesheet" type="text/css" href="/css/other.css">

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/page.js"></script>

</head>


<body class="bodb">
<article class="main-hd personal-hd">
	 <a href="http://m.9939.com/" class="j_logo"></a>
	<h2 class="main-hd-bt">
        <{if isset($qlx_ads) && !empty($qlx_ads)}>
        <{$qlx_ads}>
        <{/if}>
        <{$diseaseName}>
    </h2>
	
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
	
	<div class="blahe" style = "height: 0.12em;" ></div>
	
	<nav>
		<a href="http://m.9939.com" title = "首页">首页</a>>
		<a href="http://wapask.9939.com" title = "问医">问医</a>>
		<a href="http://wapask.9939.com/department/list.html" title = "疾病科室">疾病科室</a>>
		<a href="javascript:"><{$diseaseName}></a>
	</nav>

    <article class="sead">
        <input type="text" id="searchWords" placeholder="请描述疾病或症状...">
        <a href="javascript:" id="searchBtn"></a>
    </article>
	
	<article>
		<{include file="ads/ads_detailDisease_01.html"}>
	</article>

    <input type = "hidden" id = "diseaseNameID" value = "<{$diseaseName}>" />
    <input type = "hidden" id = "diseaseID" value = "<{$diseaseID}>" />
	<div class="thre"></div>
        <{if !empty($disease)}>
            <section class="doct">
                    <h2 class="blood"><{$disease.title}></h2>

                    <article class="acqua">
                            <a href=""><img src="<{$disease.thumb}>" alt="<{$disease.title}>" title = "<{$disease.title}>"></a>

                            <p class="bre_01">
                                    <{$disease.simpleDesc}> <a>[展开]</a>
                            </p>
                            <p class="bre_02" style = "display:none;">
                                    <{$disease.description}>
                                    <a>[收起]</a>
                            </p>
                    </article>

                    <article class="resyp">
                            <span>相关症状：</span>
                            <{foreach from = $disease.symptom item = symptomVal key = key}>
                                    <a href="javascript:"><{$symptomVal}></a>
                            <{/foreach}>
                    </article>

                    <article class="fimed">
                            <span>适用药品：</span>
                            <ul class="ims">
                                    <{if count($disease.medicine_arr) > 0 }>
                                            <{foreach from = $disease.medicine_arr item = drugVal key = key}>
                                                    <li>
                                                            <a href="javascript:" title = "<{$drugVal}>">
                                                                    <img src="" alt="<{$drugVal}>" title = "<{$drugVal}>"></a>
                                                            <a href="javascript:" title = "<{$drugVal}>"><{$drugVal}></a>
                                                    </li>
                                            <{/foreach}>
                                    <{/if}>
                                    <{if  count($disease.medicine_arr) == 0 }>
                                    <li>暂无</li>
                                    <{/if}>
                            </ul>
                    </article>
            </section>
	<{/if}>
	<article class="arnav">
		<span><{$diseaseName}></span>相关问题<{$askCount}>个
        <input type="hidden" value="<{$askCount}>" id="ask_count" />
	</article>
	
	<div id = "fatherHTMLID">
	</div>

	<!--底部部分 Start-->
	<{include file="footer/ask_doctor_footer.html"}>
	<!--底部部分 End-->

	<!-- 统计功能 Start -->
	<{include file="ads/wap_ask_stat.html"}>
	<!-- 统计功能 End -->
	
	<script type="text/javascript">
		$(document).ready(function(){
			
			//设置 搜索 部分的 a 的 href 值
			$("#searchBtn").on('click', function(){
				searchWords = $("#searchWords").val();
				
				$(this).attr("href", "/search/" + encodeURI(searchWords) + "/1");
			});

            //如果没有相关问题的话，就不进行分页请求
            var ask_count = $("#ask_count").val();

            if (ask_count != 0){

                //异步分页操作
                $.ajax({
                    url: "/search/detaildiseasepage?diseaseID="+ $("#diseaseID").val() + "&diseaseName="+ encodeURI($("#diseaseNameID").val()) ,
                    cache: false,
                    success: function(html){
                        //将得到的信息，添加到 n3Tab33ContentDep 下面
                        $("#fatherHTMLID").html(html);
                    }
                });
            }
		});
	</script>
	
	<script src="/js/sea.js"></script>
	<script type="text/javascript">
		seajs.use("play.js");
	</script>

</body>
</html>
