
<div class="news-item">
	<a href="/article/{{ $article->slug }}" class="news-preview">
		<img src="{{ $article->preview }}" alt="">
		<span class="news-more">
			<span class="btn-mini btn-white">Подробнее</span>
		</span>
	</a>
	<div class="news-date">{{ $article->published_formated }}</div>
	<h3 class="news-title"><a href="/article/{{ $article->slug }}">{{ $article->title }}</a></h3>
</div>
