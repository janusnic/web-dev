@extends('layouts.master')

@section('title'){{ config('blog.title'.'|'.$articles->currentPage()) }}@stop

@section('content')


 <h1>{{ config('blog.title') }}</h1>
    <div class="content">
          
	@foreach($articles as $article)
		<div class="blog-post">
			<h2 class="blog-post-title"><a href="/{{ $article->slug }}">{{ $article->title }}</a></h2>
			<div class="blog-post-meta">posted in <a href="/categories/{{ $article->category->slug }}">{{ $article->category->name }}</a> and tagged
			@foreach($article->tags as $key => $tag)
				<a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
			@endforeach
			about {{ $article->published_at }}.</div>
			{!! str_limit($article->content, $limit = 500, $end = '...') !!}
		</div><!-- /.blog-post -->
		<hr>
	@endforeach

	<nav class="pull-right">
		{!! $articles->render() !!}
	</nav>

@stop
