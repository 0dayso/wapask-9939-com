define(function(require){
	//库 声明
	var $ = require('zepto');
	// 展开收缩
	$(function(){
		var oldHeight = $(".txtinfo_box").height();
		$('<i class="zz_txt"></i>').appendTo($(".txtinfo_box"));
		$(".show_more_btn").click(function(){
			if($(this).text()=="查看更多"){
				$(this).prev().height("auto");
				$(this).prev().find(".zz_txt").remove();
				$(this).find("a").text("点击收缩");
			}else{
				$(this).prev().height(oldHeight);
				$('<i class="zz_txt"></i>').appendTo($(this).prev());
				$(this).find("a").text("查看更多");
			}
		});
	});
});