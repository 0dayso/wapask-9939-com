		<ul class="lopre">
			<{foreach $doctorAnswerAsk as $key => $answerAsk }>
				<li>
					<h3>
						<{$answerAsk.title}>
					</h3>
					<div class="care">
						<p><{$answerAsk.content}><a href = "/id/<{$answerAsk.id}>.html" ><span style="color:#00B489;" >详情</span></a></p>
						<div class="agree">
							<span class="sp_05 sp_07"><{$answerAsk.satisfied}></span>
							<span class="sp_01"><{$answerAsk.praise}></span>
							<span class="sp_06"><{$answerAsk.addtime}></span>|
							<span class="sp_04"><{$answerAsk.answernum}>个回答</span>
						</div>
					</div>
				</li>
			<{/foreach}>
		</ul>
	
		<article class="paget">
			<{$pageHTML}>
		</article>