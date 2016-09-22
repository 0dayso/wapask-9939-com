// JavaScript Document
$(function(){
	
	//头部导航弹出
	var bool=true;
	$('a.clna').click(function(){
		if(bool){
			$('.heabar').removeClass('disn').addClass('shay');	
			bool=false;
		}
		else{
			$('.heabar').removeClass('shay').addClass('disn');	
			bool=true;		
		}	
	});
	$('span.arrow').click(function(){
		$('.heabar').removeClass('shay').addClass('disn');	
		bool=true;	
	});
	
	//一级科室一级部位弹出
	$('.heanew b').click(function(){
		$('.oubra,.choico').removeClass('disn').addClass('shay');	
		$('body').css('overflow','hidden');
		
	});
	$('.oubra').click(function(){
		$('.oubra,.choico,.sio,.agint,.brand,.sio,.tips').removeClass('shay').addClass('disn');	
		$('body').css('overflow','visible');	
	});
	//放大缩小字体
	var boo=true;
	$('.shaco a').click(function(){
		if(boo){
			if($(this).hasClass('max')){
				$('.expla p,.node p').css('font-size','.34rem');	
			}
			else{
				$('.expla p,.node p').css('font-size','.3rem');	
			}
		}
		
	});
	/*点击经验分享弹出*/
	var bo=true;
	$('.nav a.eper').click(function(){
		if(bo){
			$('.exsha').removeClass('disn').addClass('shay');	
			bo=false;
		}
		else{
			$('.exsha').removeClass('shay').addClass('disn');	
			bo=true;	
		}
		
	});
});