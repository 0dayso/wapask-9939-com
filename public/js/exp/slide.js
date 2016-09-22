// JavaScript Document
$(document).ready(function(){
	$(".main_visual,.main_v").hover(function(){
		$("#btn_prev,#btn_next").fadeIn()
	},function(){
		$("#btn_prev,#btn_next,#btn_p,#btn_n").fadeOut()
	});
	$dragBln = false;
	$(".main_image,.main_i").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev,#btn_p"),
		btn_next : $("#btn_next,#btn_n"),
		paging : $(".flicking_con a,.flicking_c a"),
		counter : function (e){
			$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
			$(".flicking_c a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	$(".main_image,.main_i").bind("mousedown", function() {
		$dragBln = false;
	});
	$(".main_image,.main_i").bind("dragstart", function() {
		$dragBln = true;
	});
	$(".main_image a,.main_i a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	timer = setInterval(function(){
		$("#btn_next").click();
	}, 5000);
	$(".main_visual,.main_v").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next,#btn_n").click();
		},5000);
	});
	$(".main_image,.main_i").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next,#btn_n").click();
		}, 5000);
	});
});
