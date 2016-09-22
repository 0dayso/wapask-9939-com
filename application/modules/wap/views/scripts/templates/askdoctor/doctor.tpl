		
		
		<{foreach $doctor.doctor as $allDepartmentDoctor}>
			<article class="doctor docbo hospi">
				<div>
					<img src="<{$allDepartmentDoctor.pic}>" alt="<{$allDepartmentDoctor.truename}>" title = "<{$allDepartmentDoctor.truename}>"  width = 85 height = 85 >
				</div>
				<div class="clid">
					<p>
						<span><{$allDepartmentDoctor.truename}></span><{$allDepartmentDoctor.zhicheng}>
					</p>
					<p><{$allDepartmentDoctor.doc_hos}></p>
					<p>擅长：<{$allDepartmentDoctor.best_dis}></p>
				</div>
				<a href="/ask/doctor/<{$allDepartmentDoctor.uid}>" class="refer">向TA提问</a>
			</article>
		<{/foreach}>
	
		<article class="paget">
			<{$doctor.html}>
		</article>	