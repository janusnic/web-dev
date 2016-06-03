@extends('layouts.master')

@section('title'){{ config('blog.title') }}@stop

@section('content')

<h1>{{ config('blog.title') }}</h1>
    <div class="content">

		<h2 class="blog-post-title">{{ $article->title }}</h2>
		<div class="blog-post-meta">posted in <a href="/categories/{{ $article->category->slug }}">{{ $article->category->title }}</a> and tagged
		@foreach($article->tags as $key => $tag)
			<a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
		@endforeach
	
		about {{ $article->published_at }}.</div>
		{!! $article->content !!}
	
	</div><!-- /.blog-post -->
	
	<hr>


@stop
