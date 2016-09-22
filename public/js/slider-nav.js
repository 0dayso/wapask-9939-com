define(function(require){
	//库 声明
	var $ = require('zepto');
	// 滑动nav
	var slideWidth = $(".touch-box").width();
	var navWidth = null;
	var itarget = null;
	var nowlength = null;
	for(var i=0;i<$(".touch-box li").length;i++){
		navWidth=navWidth+$(".touch-box li")[i].offsetWidth;
	}
	$(".touch-box ul").css("width",navWidth);
	var nStartY,nStartX,nMoveY,nMoveX,nChangY,nChangX,that,hSHow;
	$(".touch-nav").delegate(".touch-box","touchstart",function(e){
		nStartY = e.targetTouches[0].pageY;
        nStartX = e.targetTouches[0].pageX;
	});
	$(".touch-nav").delegate(".touch-box","touchend",function(e){
		nChangY = e.changedTouches[0].pageY;
        nChangX = e.changedTouches[0].pageX;
		if(nStartX>nChangX && (nStartX-nChangX)>30 && (nStartY-nChangY)<20){
			itarget = itarget+slideWidth;
			if(itarget<navWidth && (navWidth-itarget)>(slideWidth/8.8)){
				nowlength = itarget;
				$(".touch-box ul").animate({left:-itarget});
				$(".touch-nav .right-icon").show();
			}else{
				itarget = nowlength;
				$(".touch-nav .left-icon").hide();
			}
		}else if(nStartX<nChangX && (nChangX-nStartX)>20){
			itarget = -Math.abs(itarget)+slideWidth;
			if(itarget<=0){
				$(".touch-box ul").animate({left:itarget});
				$(".touch-nav .left-icon").show();
			}else{
				itarget = 0;
				$(".touch-nav .right-icon").hide();
			}
		}
	});
});