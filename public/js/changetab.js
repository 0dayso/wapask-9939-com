define(function(require){
	//库 声明
	var $ = require('zepto');
	// 选项卡
	$(function() {
        function tabs(tabTit, on, tabCon) {
            $(tabTit).children().click(function() {
                $(this).addClass(on).siblings().removeClass(on);
                var index = $(tabTit).children().index(this);
                $(tabCon).children().eq(index).show().siblings().hide();
            });
        }
        tabs(".tab-hd", "current", ".tab-bd");
    });
});