@extends('layouts.dashboard')
@section('page_heading','Tags')

@section('section')
<div class="col-sm-12">

<div class="row">
    <div class="col-sm-12">
        @section ('cotable_panel_title','Tags List')
        @section ('cotable_panel_body')
    
    {!! link_to_route('admin.tag.create', 'New Tag') !!}
        
        <table class="table table-bordered">
            <thead>
                <tr>
                      <th>id</th>
                      <th>Name</th>
                      <th>Edit</th>
                      <th>Remove</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($tags as $tag)

                <tr class="success">
                    <td>{!! link_to_route('admin.tag.edit', $tag->id, $tag->id) !!}</td>
                    <td>{!! link_to_route('admin.tag.edit', $tag->tag, $tag->id) !!}</td>
                    <td>{!! link_to_route('admin.tag.edit', 'Edit', $tag->id) !!}</td>

                    <td>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.tag.destroy', $tag->id]]) !!}
                    <button type="submit">Delete</button>
                    {!! Form::close() !!}</td>
                </tr>

            @endforeach

            </tbody>
        </table>    
    
    <!-- pagination -->
    {!! $tags->render() !!}

        @endsection
        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
    </div>
</div>
</div>
@stop