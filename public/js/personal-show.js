define(function(require){
	//库 声明
	var $ = require('zepto');
        
        function showLoginState(){
            var userid = window.localStorage.getItem('userid');
            var username = window.localStorage.getItem('username');
            var link = "http://wapask.9939.com/doctor/usercenter?userid=" + userid;
            if (typeof (userid)!="undefined" && parseInt(userid)>0){
                $('.loginb').hide();
                $('.lotal').attr('href', link);
                $(".lotal > span").text(username);
                $('.lotal').show();
            } else {
                $('.loginb').show();
            }
        }
        //头部导航弹出
        var bool=true;
        $('a.clna,.personal-btn,.lin_02').click(function(){
            showLoginState();
            if(bool){
                    $('.headbar').removeClass('disn').addClass('shay');	
                    bool=false;
            }
            else{
                    $('.headbar').removeClass('shay').addClass('disn');	
                    bool=true;		
            }
        });
        $('span.arrow').click(function(){
                $('.headbar').removeClass('shay').addClass('disn');	
                bool=true;	
        });
});