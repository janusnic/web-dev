@extends('layouts.dashboard')
@section('page_heading','Categories')

@section('section')
<div class="col-sm-12">

<div class="row">
    <div class="col-sm-12">
        @section ('cotable_panel_title','Categories List')
        @section ('cotable_panel_body')
    
    	{!! link_to_route('admin.categories.create', 'New Category') !!}

			 <table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Slug</th>
						<th>Articles</th>
						<th>Created At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($categories as $category)
					<tr>
						<td>{{ $category->id }}</td>
						<td>
							@if($category->parent_id) &nbsp;&nbsp;&nbsp;— @endif
							{{ $category->title }}
						</td>
						<td>{{ $category->slug }}</td>
						<td>{{ $category->articles()->count() }}</td>
						<td>{{ $category->created_at }}</td>
						<td>
							{!! Form::open(['method' => 'get', 'url' => 'admin/categories/'.$category->id.'/edit', 'style' => 'float:left;margin-right: 10px;']) !!}
								<button type="submit" class="btn btn-success btn-sm iframe cboxElement"><span class="glyphicon glyphicon-pencil"></span> Edite</button>
							{!! Form::close() !!}

							{!! Form::open(['method' => 'delete', 'url' => 'admin/categories/'.$category->id, 'style' => 'float:left;margin-right: 10px;']) !!}
								<button type="submit" class="btn btn-sm btn-danger iframe cboxElement"><span class="glyphicon glyphicon-trash"></span> Delete</button>
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
    </div>
</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">
					{{ $categories->count() }} Categories On Page #{{ $categories->lastPage() }} From {{ $categories->total() }}.
				</div>
			</div>
			<div class="col-sm-6">
				<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
				<!-- /.col-lg-12 -->    <!-- pagination -->
				    {!! $categories->render() !!}

				</div>
			</div>
		</div>

        @endsection
        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))

</div>
@stop