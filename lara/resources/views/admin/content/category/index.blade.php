@extends('layouts.dashboard')
@section('page_heading','Categories')

@section('section')
<div class="col-sm-12">

<div class="row">
    <div class="col-sm-12">
        @section ('cotable_panel_title','Categories List')
        @section ('cotable_panel_body')
    
    {!! link_to_route('admin.category.create', 'New category') !!}
        
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

            @foreach ($categories as $category)

                <tr class="success">
                    <td>{!! link_to_route('admin.category.edit', $category->id, $category->id) !!}</td>
                    <td>{!! link_to_route('admin.category.edit', $category->title, $category->id) !!}</td>
                    <td>{!! link_to_route('admin.category.edit', 'Edit', $category->id) !!}</td>

                    <td>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.category.destroy', $category->id]]) !!}
                    <button type="submit">Delete</button>
                    {!! Form::close() !!}</td>
                </tr>

            @endforeach

            </tbody>
        </table>    
    
    <!-- pagination -->
    {!! $categories->render() !!}

        @endsection
        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
    </div>
</div>
</div>
@stop