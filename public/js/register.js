
		$(document).ready(function(){
		
			/**
			 * 隐藏错误显示区域
			 * @author gaoqing
			 * 2015-09-10
			 */
			function hiddenErrorBlock(controlObj){
				//当输入框获取焦点时，隐藏 错误显示信息
				$(controlObj).on('focus', function(){
					//隐藏错误显示区域
					$("#showInfo").hide();
				});
			}
			//当错误提示信息显示的时候，如果再重新输入信息的话，错误提示要隐藏
			hiddenErrorBlock($("#username"));
			hiddenErrorBlock($("#password"));
			hiddenErrorBlock($("#repassword"));
			hiddenErrorBlock($("#email"));
			hiddenErrorBlock($("#nickname"));
			
			$("#username").change(function() {
				//验证用户名是否存在
				$.ajax({
					type: "POST",
					url:  "http://wapask.9939.com/ask/checkuserexist",
					data: "username=" + $("#username").val(),
					dataType:'json',
					success: function(msg){
						if(msg != null && msg.flag == "1"){
							
							$("#showInfo").show();
							$("#showInfo").text("用户名已存在！");
							$("#usernameExist").val("01");
						}else{
							$("#usernameExist").val("00");
						}
					}
				});
			});
			
			/**
			 * 得到汉字的长度
			 */
			function getRealLen(str) {  
			    return str.replace(/[^\x00-\xff]/g, '__').length; //这个把所有双字节的都给匹配进去了  
			}
			
			$("#submit").on('click', function(){
				
				//显示信息的对象
				var showInfo = $("#showInfo");
				
				//验证用户输入的用户名是否合法
				var username = $("#username").val();
				if(username.length == 0){
					
					$("#showInfo").show();
					showInfo.text("用户名不能为空！");
					return false;
				}
				if(username.length < 4){
					
					$("#showInfo").show();
					showInfo.text("用户名太短！");
					return false;
				}
				if(username.length > 16){
					
					$("#showInfo").show();
					showInfo.text("用户名太长！");
					return false;
				}
				var userReg = new RegExp('[a-zA-Z0-9]{4,16}');
				if(!userReg.test(username)){
					$("#showInfo").show();
					showInfo.text("用户名是字母与数字！");
					return false;
				}
				
				//邮箱
				var email = $("#email").val();
				var emailReg = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$');
				if(email.length == 0 ){
					$("#showInfo").show();
					showInfo.text("邮箱不能为空！");
					return false;
				}
				if(!emailReg.test(email)){
					$("#showInfo").show();
					showInfo.text("邮箱格式不对！");
					return false;
				}
				
				//昵称
				var nickname = $("#nickname").val();
				if(nickname.length == 0){
					$("#showInfo").show();
					showInfo.text("昵称不能为空！");
					return false;					
				}
				if(getRealLen(nickname) > 30){
					$("#showInfo").show();
					showInfo.text("昵称太长！");
					return false;					
				}
				
				//判断两次输入的密码，是否一致
				var password = $("#password").val();
				if(password.length == 0){
					
					$("#showInfo").show();
					showInfo.text("密码不能为空！");
					return false;
				}
				var repassword = $("#repassword").val();
				if(password != repassword){
					
					$("#showInfo").show();
					showInfo.text("两次输入的密码不一致！");
					return false;
				}
				
				//验证用户名是否存在
				var usernameExist = $("#usernameExist").val();
				if(usernameExist == "01"){
					$("#showInfo").show();
					showInfo.text("用户名存在！");
					return false;
				}
				
				//清空 usernameExist 的值
				$("#usernameExist").val("00");				
				return true;	
			});
		});