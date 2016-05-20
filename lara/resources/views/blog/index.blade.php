@extends('layouts.master')

@section('title')
  <title>{{ config('blog.title') }}</title>
@stop
@section('content')
    <h1>{{ config('blog.title') }}</h1>
    <div class="content">
          <h5>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</h5>
          <ul>
            @foreach ($posts as $post)
              <li>
                <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                <em>({{ $post->published_at->format('M jS Y g:ia') }})</em>
                <p>
                  {{ str_limit($post->content) }}
                </p>
              </li>
            @endforeach
          </ul>
      </div>
          {!! $posts->render() !!}
      <hr>
 
@stop

