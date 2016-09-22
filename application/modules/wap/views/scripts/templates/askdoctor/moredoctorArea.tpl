	<section name="n3Tab33Content" id="n3Tab33ContentArea"
		style="display: none;">
		
		<{foreach $allAreaDoctorArr.doctor as $allAreaDoctor}>
			<article class="doctor docbo hospi">
				<div>
					<img src="<{$allAreaDoctor.pic}>" alt="<{$allAreaDoctor.truename}>" title = "<{$allAreaDoctor.truename}>" width = 85 height = 85>
				</div>
				<div class="clid">
					<p>
						<span><{$allAreaDoctor.truename}></span><{$allAreaDoctor.zhicheng}>
					</p>
					<p><{$allAreaDoctor.doc_hos}></p>
					<p>擅长：<{$allAreaDoctor.best_dis}></p>
				</div>
				<a href="/ask/doctor/<{$allAreaDoctor.uid}>" class="refer">向TA提问</a>
			</article>
		<{/foreach}>	
			
		<article class="finmo shmor">
			<a href="javascript:" id="showMoreArea">显示更多医生</a>
		</article>
	</section>
	
	<script>
			$("#showMoreArea").click(function(){
			$.ajax({
				  url: "/doctor/showmoredoctorpage?from=2&currentPage=2",
				  cache: false, 
				  success: function(html){
				  		//将得到的信息，添加到 n3Tab33ContentArea 下面
				  		$("#n3Tab33ContentArea").html(html);
				  }
			});
		});
	</script>