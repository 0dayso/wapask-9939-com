<ul>
		<li>
					<h4 class="whid">
						<a onClick="divTag('n3Tab33', 'indexahover', '', 1, 0)"
							name="n3Tab33" id="n3Tab33" class="indexahover"><span>咳嗽</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 2, 0)"
							name="n3Tab33" id="n3Tab33"><span>感冒</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 3, 0)"
							name="n3Tab33" id="n3Tab33"><span>白癜风</span></a><a
							onClick="divTag('n3Tab33', 'indexahover', '', 4, 0)"
							name="n3Tab33" id="n3Tab33"><span>甲亢</span></a>
					</h4>
					
					<{foreach $commonDiseaseArr[0] as $key => $specifyDiseaseArr }>
						<section name="n3Tab33Content" id="n3Tab33Content" <{if $key != 0 }>style="display:none;"<{/if}> >
							<dl class="heal">
								<{foreach  $specifyDiseaseArr.data as  $specifyDiseaseKey =>  $specifyDisease}>
									<dd>
										<a href="/id/<{$specifyDisease.id}>.html" title = "<{$specifyDisease.title}>"><{$specifyDisease.shorttitle}></a>
									</dd>
								<{/foreach}>
							</dl>
							<article class="finmo">
								<a href="/disease/<{$diseaseIDMap[$specifyDiseaseArr.classid]}>.html">
									查看<{$commonDiseaseIDMap[0][$specifyDisease.classid]}>更多问题&nbsp;>
								</a>
							</article>
							
						</section>
					<{/foreach}>
				</li>

				<li>
					<h4 class="whid">
						<a onClick="divTag('n4Tab44', 'indexahover', '', 1, 0)"
							name="n4Tab44" id="n4Tab44" class="indexahover"><span>月经不调</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 2, 0)"
							name="n4Tab44" id="n4Tab44"><span>流产</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 3, 0)"
							name="n4Tab44" id="n4Tab44"><span>鼻炎</span></a><a
							onClick="divTag('n4Tab44', 'indexahover', '', 4, 0)"
							name="n4Tab44" id="n4Tab44"><span>肛肠疾病</span></a>
					</h4>
					
					<{foreach $commonDiseaseArr[1] as $key => $specifyDiseaseArr }>
						<section name="n4Tab44Content" id="n4Tab44Content" <{if $key != 0 }>style="display:none;"<{/if}> >
							<dl class="heal">
								<{foreach  $specifyDiseaseArr.data as  $specifyDiseaseKey =>  $specifyDisease}>
									<dd>
										<a href="/id/<{$specifyDisease.id}>.html" title = "<{$specifyDisease.title}>"><{$specifyDisease.shorttitle}></a>
									</dd>
								<{/foreach}>
							</dl>
							<article class="finmo">
								<a href="/disease/<{$diseaseIDMap[$specifyDiseaseArr.classid]}>.html">
									查看<{$commonDiseaseIDMap[1][$specifyDisease.classid]}>更多问题&nbsp;>
								</a>
							</article>
						</section>
					<{/foreach}>					
				</li>
			</ul>
