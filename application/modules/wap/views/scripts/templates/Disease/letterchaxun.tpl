<!DOCTYPE html>
<html>
<!-- head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>疾病字母查询</title>
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
<!-- head -->
<body>
<div class="main">
	<!-- header stars -->
	<header class="main-hd personal-hd">
   		 <a href="/Disease/" class="c_logo">疾病库</a>
		<h2 class="main-hd-bt">按字母查找</h2>
		<div class="hd-right">
			<!--6.1 修改-->
			<div class="personal">
				<a href="javascript:;" class="personal-btn"><img src="/images/f_sym.png"></a>
			</div>
         <!--ends-->
		</div>
	</header>
	<!-- header ends -->
    <!--6.1 修改-->
    <!--右上角快速导航 开始-->
    <{include file="navigation/fast_navigation.html"}>
    <!--右上角快速导航 结束-->
    <!-- 主内容 stars -->
    <div class="m_shor">按字母查找</div>
    <div class="l_fin">
       <{if $result}>
        	<div class="sym_i">
                <{foreach from=$result item=letter}>
            	   <a href="/Disease/<{$letter.contentid}>.shtml"><{$letter.title}></a>
                <{/foreach}>
            </div>
         <{else}>
            <div class="sym_i">
                对不起暂无此类信息
            </div>
        <{/if}>
        <div class="letter">
        	<a  <{if <{$capital}> eq A}>class="hhh"<{/if}> href="/Disease/letter/?capital=A">A</a>
            <a  <{if <{$capital}> eq B}>class="hhh"<{/if}> href="/Disease/letter/?capital=B">B</a>
            <a  <{if <{$capital}> eq C}>class="hhh"<{/if}> href="/Disease/letter/?capital=C">C</a>
            <a  <{if <{$capital}> eq D}>class="hhh"<{/if}> href="/Disease/letter/?capital=D">D</a>
            <a  <{if <{$capital}> eq E}>class="hhh"<{/if}> href="/Disease/letter/?capital=E">E</a>
            <a  <{if <{$capital}> eq F}>class="hhh"<{/if}> href="/Disease/letter/?capital=F">F</a>
            <a  <{if <{$capital}> eq G}>class="hhh"<{/if}> href="/Disease/letter/?capital=G">G</a>
            <a  <{if <{$capital}> eq H}>class="hhh"<{/if}> href="/Disease/letter/?capital=H">H</a>
            <a  <{if <{$capital}> eq I}>class="hhh"<{/if}> href="/Disease/letter/?capital=I">I</a>
            <a  <{if <{$capital}> eq J}>class="hhh"<{/if}> href="/Disease/letter/?capital=J">J</a>
            <a  <{if <{$capital}> eq K}>class="hhh"<{/if}> href="/Disease/letter/?capital=K">K</a>
            <a  <{if <{$capital}> eq L}>class="hhh"<{/if}> href="/Disease/letter/?capital=L">L</a>
            <a  <{if <{$capital}> eq M}>class="hhh"<{/if}> href="/Disease/letter/?capital=M">M</a>
            <a  <{if <{$capital}> eq N}>class="hhh"<{/if}> href="/Disease/letter/?capital=N">N</a>
            <a  <{if <{$capital}> eq O}>class="hhh"<{/if}> href="/Disease/letter/?capital=O">O</a>
            <a  <{if <{$capital}> eq P}>class="hhh"<{/if}> href="/Disease/letter/?capital=P">P</a>
            <a  <{if <{$capital}> eq Q}>class="hhh"<{/if}> href="/Disease/letter/?capital=Q">Q</a>
            <a  <{if <{$capital}> eq R}>class="hhh"<{/if}> href="/Disease/letter/?capital=R">R</a>
            <a  <{if <{$capital}> eq S}>class="hhh"<{/if}> href="/Disease/letter/?capital=S">S</a>
            <a  <{if <{$capital}> eq T}>class="hhh"<{/if}> href="/Disease/letter/?capital=T">T</a>
            <a  <{if <{$capital}> eq U}>class="hhh"<{/if}> href="/Disease/letter/?capital=U">U</a>
            <a  <{if <{$capital}> eq V}>class="hhh"<{/if}> href="/Disease/letter/?capital=V">V</a>
            <a  <{if <{$capital}> eq W}>class="hhh"<{/if}> href="/Disease/letter/?capital=W">W</a>
            <a  <{if <{$capital}> eq X}>class="hhh"<{/if}> href="/Disease/letter/?capital=X">X</a>
            <a  <{if <{$capital}> eq Y}>class="hhh"<{/if}> href="/Disease/letter/?capital=Y">Y</a>
            <a  <{if <{$capital}> eq Z}>class="hhh"<{/if}> href="/Disease/letter/?capital=Z">Z</a>
        </div>
    </div>
	<!-- 主内容 ends -->
	<!-- footer stars -->
	   <{include file="footer/footer.html"}>
           <{include file="ads/wap_ask_stat.html"}>
	<!-- footer ends -->
</div>
</body>
<script type="text/javascript" src="/js/sea.js"></script>
<script type="text/javascript">
    seajs.use("play.js")
</script>
</html>