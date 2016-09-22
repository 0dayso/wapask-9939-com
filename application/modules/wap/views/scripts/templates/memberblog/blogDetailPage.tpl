
<!-- <article class="arnav docna other"><a href="">更多> > </a>看TA其他日志（<label><{$doctorBlogCount}></label>）</article> -->
<article class="arnav docna other">看TA其他日志<label><{$doctorBlogCount}></label></article>


<ul class="arclo">

	<{foreach $doctorBlogArr as $key => $doctorBlog }>
		<li>
			<a href="/doctor/blog/detail/<{$doctorid}>/<{$doctorBlog.blogid}>">
				<h3><{$doctorBlog.subject}></h3>
				<p>
					<span>发布于<{$doctorBlog.date}></span>
					<span><{$doctorBlog.time}></span>
					<span>有<{$doctorBlog.viewnum}>人浏览</span>
				</p>
			</a>
		</li>
	<{/foreach}>
</ul>

	<article class="paget">
	<{$pageHTML}>
	</article>