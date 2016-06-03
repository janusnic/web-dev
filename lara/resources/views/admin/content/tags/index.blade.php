@extends('layouts.dashboard')
@section('page_heading','Tags')

@section('section')
<div class="col-sm-12">

<div class="row">
    <div class="col-sm-12">
        @section ('cotable_panel_title','Tags List')
        @section ('cotable_panel_body')
    
    	{!! link_to_route('admin.tags.create', 'New Tag') !!}

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
				@foreach($tags as $tag)
					<tr>
						<td>{{ $tag->id }}</td>
						<td>{{ $tag->name }}</td>
						<td>{{ $tag->slug }}</td>
						<td>{{ $tag->articles()->count() }}</td>
						<td>{{ $tag->created_at }}</td>
						<td>
							{!! Form::open(['method' => 'get', 'url' => 'admin/tags/'.$tag->id.'/edit', 'style' => 'float:left;margin-right: 10px;']) !!}
								<button type="submit" class="btn btn-success btn-sm iframe cboxElement"><span class="glyphicon glyphicon-pencil"></span> Edite</button>
							{!! Form::close() !!}

							{!! Form::open(['method' => 'delete', 'url' => 'admin/tags/'.$tag->id, 'style' => 'float:left;margin-right: 10px;']) !!}
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
					{{ $tags->count() }} Tag(s) On Page #{{ $tags->lastPage() }} From {{ $tags->total() }}.
				</div>
			</div>
			<div class="col-sm-6">
				<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
				<!-- /.col-lg-12 -->    <!-- pagination -->
				    {!! $tags->render() !!}

				</div>
			</div>
		</div>

        @endsection
        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))

</div>
@stop