 seajs.config({
  alias: {
    'zepto': 'zepto'
  },
  debug: 1
});
define(function(require,exports,module) {
	var $ = require("zepto");
	//选项卡
	if($(".tab-hd").length){
		require("changetab");
	}
	// 头部 个人中心
	if($(".personal-btn").length){
		require("personal-show");
	}
	//首页搜索框
	if($(".sch-zx").length){
		require("search-sele");
	}
	if($(".touch-nav").length){
		require("slider-nav")
	}
	//模拟单选框
	if($(".wytw-sexs").length){
		require("radio");
	}
	//字数限制
	if($(".txtinfo_box").length){
		require("wordLimit");
	}
	// 底部广告位
	if($(".bottom_ad").length){
		require("bottom_ad");
	}
	//文字向上滚动
	if($(".txt_scrollTop").length){
		require("txt_scrollTop")
	}
});