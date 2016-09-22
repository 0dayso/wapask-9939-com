define(function(require){
	//库 声明
	var $ = require('zepto');
	// 展开收缩
	$('.wytw-sexs').delegate('label','click',function(){
		$('.wytw-sexs').find('label').removeClass('selec');
		$(this).addClass('selec');
		$(this).find('input').prop("checked",true);
	});
});