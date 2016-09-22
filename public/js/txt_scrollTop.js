define(function(require){
	//库 声明
	var $ = require('zepto');
	// 文字向上滚动
	$(function(){
		var sHeight=0;
		var timer = null;
		var oTxt = $(".txt_scrollTop");
		var scroll_list_box = $(".scroll_list_box");
		var oLiHeight = parseInt($(".txt_scrollTop li").height());
		$(".txt_scrollTop li").height(oLiHeight);
		oTxt.css({"overflow":"hidden","height":oLiHeight*6,"position":"relative"});
		scroll_list_box.css({"position":"absolute","top":0,"left":0});
		scroll_list_box.html(scroll_list_box.html()+scroll_list_box.html());
		timer = setInterval(function(){
			if(sHeight<=-scroll_list_box.find("ul").eq(0).height()){
		 		scroll_list_box.css({"top":"0"});
		 		sHeight = 0;
		 	};
		 	sHeight-=oLiHeight;
		 	scroll_list_box.animate({top:sHeight+"px"});
		},2000);
	})
});