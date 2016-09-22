		<ul class="lopre">
			<{foreach from = $askAndAnswerArr item = askAndAnswer key = key}>
				<li>
					<h3>
						<a href = "/id/<{$askAndAnswer.ask.id}>.html" style="color: #333;" ><{$askAndAnswer.ask.title}></a>
					</h3>
					<div class="care">
						<p><{$askAndAnswer.answer.content}><a href = "/id/<{$askAndAnswer.ask.id}>.html" ><span style="color:#00B489;" >详情</span></a></p>
                    </div>
                    <div class="agree">
                        <span class="sp_02"><{$askAndAnswer.doctor.doc_keshi}></span>
                        <span class="sp_03"><{$askAndAnswer.doctor.nickname}></span>
                        <span class="sp_04"><{$askAndAnswer.ask.answernum}>个回答</span>
                    </div>
				 </li>
				 
				 <{if $key eq 1 || $key eq 4 || $key eq 6 }>
					 <li>
						<{include file="ads/ads_detailDisease_02.html"}>
					</li>
				 <{/if}>
			<{/foreach}>
		</ul>
		<article class="paget">
			<{$pageHTML}>
		</article>