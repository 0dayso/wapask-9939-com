define(function(require){
	//库 声明
	var $ = require('zepto');
	// 首页搜索框
	$(".sch-zx").click(function(){
		$(".schbox").toggle();
	})
	$(".schbox li").click(function(){
		var oval = $(".sch-zx").val();
		$(".sch-zx").val($(this).text());
		$(this).text(oval);
		$(".schbox").hide();
	})
});