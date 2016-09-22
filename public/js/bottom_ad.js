define(function(require){
	//库 声明
	var $ = require('zepto');
	// 底部广告位
	var startX,startY,endX,endY;
	var old_animate = null;
	var now_index = 1;
	var now=0;
	var pic_count = $(".bottom_ad li").length;
	var timer = null;
	$(".bottom_ad li").eq(now).css("zIndex",now_index)
	$(".bottom_ad").on("touchstart",function(e){
		startY = e.targetTouches[0].pageY;
    	startX = e.targetTouches[0].pageX;
	});
	$(".bottom_ad").on("touchend",function(e){
		endY = e.changedTouches[0].pageY;
    	endX = e.changedTouches[0].pageX;
    	if(startX>endX && (startX-endX)>30 && (startY-endY)<20){
    		clearInterval(timer);
			now--;
			now_index++;
			if(now>=0){
				img_tab();
			}else{
				now=pic_count-1;
				img_tab();
			}
			timer = setInterval(function(){
				now++;
				now_index++;
				if(now<pic_count){
					img_tab();
				}else{
					now=0;
					img_tab();
				}
			},3000); 
		}else if(startX<endX && (endX-startX)>20){
			clearInterval(timer);
			now++;
			now_index++;
			if(now<pic_count){
				img_tab();
			}else{
				now=0;
				img_tab();
			}
			timer = setInterval(function(){
				now++;
				now_index++;
				if(now<pic_count){
					img_tab();
				}else{
					now=0;
					img_tab();
				}
			},3000); 
		}
	});
	function img_tab(){
		$(".bottom_ad li").eq(now).css("zIndex",now_index);
	}
	timer = setInterval(function(){
		now++;
		now_index++;
		if(now<pic_count){
			img_tab();
		}else{
			now=0;
			img_tab();
		}
	},3000); 
});