@extends('layouts.dashboard')
@section('page_heading','Users')

@section('section')
<div class="col-sm-12">

<div class="row">
    <div class="col-sm-12">
        @section ('cotable_panel_title','Users List')
        @section ('cotable_panel_body')
    
        {!! link_to_route('admin.users.create', 'New user') !!}

                 <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            {!! Form::open(['method' => 'get', 'url' => 'admin/users/'.$user->id.'/edit', 'style' => 'float:left;margin-right: 10px;']) !!}
                                <button type="submit" class="btn btn-success btn-sm iframe cboxElement"><span class="glyphicon glyphicon-pencil"></span> Edite</button>
                            {!! Form::close() !!}

                            {!! Form::open(['method' => 'delete', 'url' => 'admin/users/'.$user->id, 'style' => 'float:left;margin-right: 10px;']) !!}
                                <button type="submit" class="btn btn-sm btn-danger iframe cboxElement"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        <div class="row">
            <div class="col-sm-6">
                <div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">
                    {{ $users->count() }} User(s) On Page #{{ $users->lastPage() }} From {{ $users->total() }}.
                </div>
            </div>
            <div class="col-sm-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                <!-- /.col-lg-12 -->    <!-- pagination -->
                    {!! $users->render() !!}

                </div>
            </div>
        </div>

        @endsection
        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))

</div>
@stop