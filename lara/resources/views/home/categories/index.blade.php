@extends('layouts.master')

@section('title'){{ config('blog.title') }}@stop

@section('content')

 <h1>{{ config('blog.title') }}</h1>
    <div class="content">
          
          <ul>
            @foreach($articles as $article)
              <div class="blog-post">
            <h2 class="blog-post-title"><a href="/{{ $article->slug }}">{{ $article->title }}</a></h2>
            <div class="blog-post-meta">posted in <a href="/categories/{{ $article->category_id }}">{{ $article->category->name }}</a> and tagged
            @foreach($article->tags as $key => $tag)
                <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
            @endforeach
            about {{ $article->created_at->diffForHumans() }}.</div>
            {!! str_limit($article->body_html, $limit = 500, $end = '...') !!}
        </div><!-- /.blog-post -->
            @endforeach
          </ul>
      </div>
          
      <hr>
@stop
