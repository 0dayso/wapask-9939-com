// JavaScript Document
$(function(){
	$('.acqua p a').click(function(){
		var val=$(this).parent().attr('class');
		if(val=='bre_02'){
			$(this).parent().hide();	
			$('.bre_01').show();	
		}
		else{
			$(this).parent().hide();	
			$('.bre_02').show();
		}
	});	
	$('.sympt li a.cont').click(function(){
		var vla=$(this).attr('data-v');
		if(vla==1){
			$(this).parent().find('dl').hide();
			$(this).removeClass('rota');
			$(this).attr('data-v','0');
		}
		else{
			$(this).parent().find('dl').show();
			$(this).addClass('rota');
			$(this).attr('data-v','1');	
			
			
		}
	});
	
	/**
         * 判断搜索框是否有输入
         * lc 2016-4-25
         */
	$("#searchBtn").click(function(){
            keyword = $("#searchWords").val();
            if(keyword == ''){
                return false;
            }
        });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});