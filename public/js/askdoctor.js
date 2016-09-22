
		$(document).ready(function(){
			//生成随机的在线医生数
			function GetRandomNum(id, Min, Max)
		    {   
		        var Range = Max - Min;   
		        var Rand = Math.random(); 
				var HTML = document.getElementById(id);  
				HTML.innerHTML=(Min + Math.round(Rand * Range));   
		    } 
			
			//日搜索量
			//GetRandomNum("daySearchNum", 300, 500);	
			
			//平均在线医生数
			GetRandomNum("doctorNum", 1600, 5000);

			/*var dl = $("#department li dl");
			
			//一级科室
			var dta = $(dl).find("dt a");
			$(dta).each(function(){
				$(this).attr("href", "/department/index/level/one/department/" + $(this).text());
			});
			
			//二级科室
			var dda = $(dl).find("dd a");
			$(dda).each(function(){
				$(this).attr("href", "/department/index/level/two/department/" + $(this).text());
			});*/
			
			// ajax 常见疾病
			/* $.ajax({
				  url: "/askdoctor/commonDisease",
				  cache: false, 
				  success: function(html){
				  		//将得到的信息，添加到 n3Tab33ContentDep 下面
				  		$("#commonDisease").html(html);
				  }
			}); */
			
		});