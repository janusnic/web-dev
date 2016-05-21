@extends('admin.backend')

@section('title')
  <title>{{ config('blog.title') }}</title>
@stop
@section('content')
    <h1>{{ config('blog.title') }}</h1>
    <div class="content">
          <div class="btn btn-block"><a href="{{ route('admin.blog.create')  }}"><h2>Add New Post</h2></a></div>
          <h5>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</h5>
           <div class="panel-body">
                    <a class="btn btn-success" href="{{ URL::route('admin.blog.create')}}">New Post</a>

                    <table class="table table-hover table-top">
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>create</th>
                            <th>Remove</th>
                            <th class="text-right">Edit</th>
                        </tr>

                        @foreach($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td class="text-right">

                            {!! Form::open(['route' => ['admin.blog.destroy', $post->id], 'method' => 'delete']) !!}
                           <input class="btn btn-default col-xs-2" type="submit" value="Delete" />
                           {!! Form::close() !!}

                           {!! Form::open(['route' => ['admin.blog.edit', $post->id], 'method' => 'edit']) !!}
                           <input class="btn btn-default col-xs-2" type="submit" value="Edit" />
                           {!! Form::close() !!}

                            </td>

                        </tr>
                        @endforeach
                    </table>

                </div>

      </div>
          {!! $posts->render() !!}
      <hr>
 
@stop

