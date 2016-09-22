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
	//登录页面input获得焦点
	$('.formst .indis input').keydown(function(){
		$(this).parent().find('a').show();	
	});
	
	var isshow=true;//用于控制全局显示与隐藏
	$(document).click(function(){
		if(isshow){
			var dvalatr=$('.formst .indis a').attr('data-ct');
			if(dvalatr==1){
				$(this).hide();
				$('.formst .indis a').attr('data-ct','0');
			}
		}
		isshow=true;
	});
	$('.formst .indis a').click(function(){
		var dval=$('.formst .indis a').attr('data-ct');
		if(dval==1){
			$(this).hide();
			$(this).prev('input').focus();
		}
		else{
			$(this).hide();
			$(this).prev('input').val('');
			$(this).prev('input').focus();
			
		}
		isshow=false;
	});

	//个人提交问题关闭
	$('p.tips a').click(function(){
		$(this).parent().slideUp();	
	});
	/*当前提示框控制
	var val=$('.messa').width()/2;
	$('.messa').css('margin-left','-'+val+'px');*/
	//年龄弹出
	$('.choic li.age span').click(function(){
		$('.outl,.confirm').removeClass('disn').addClass('shay');
			
		
	});
	$('.confirm p a,.outl').click(function(){
		$('.outl,.confirm,.chau').removeClass('shay').addClass('disn');	
	});
	$('.clos').click(function(){
		$('.outl,.chau').removeClass('shay').addClass('disn');	
	});
	$('.confirm div a').click(function(){
		$('.confirm div a').removeClass('curr');
		$(this).addClass('curr');
		$('.outl,.confirm').removeClass('shay').addClass('disn');
		$('.choic li.age span').html($(this).html());	
	});
	$('.choic li').click(function(){
		var ind=$(this).index();
		if(ind==0||ind==1){
			$('.choic li').removeClass('curs');
			$(this).addClass('curs');	
		}
	});
	$('.chbt_01').click(function(){
		$('.outl,.chau_02').removeClass('disn').addClass('shay');	
	});
	$('.chbt_02').click(function(){
		$('.outl,.chau_01').removeClass('disn').addClass('shay');	
	});
	//选中
	$('.agree div').click(function(){
		if($(this).attr('data-g')==0){
			$(this).removeClass('cusm')	;
			$(this).attr('data-g','1');	
		}
		else{
			
			$(this).addClass('cusm');
			$(this).attr('data-g','0');	
		}
	});
	//专家咨询聚焦不显示提示框
	$('.terea textarea').click(function(){
		$('.messa').removeClass('shay').addClass('disn');	
		
		
	});
	
});