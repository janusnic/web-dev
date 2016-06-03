@extends ('layouts.dashboard')
@section('page_heading','New Category')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::open(['url' => 'admin/categories']) !!}
					@include('admin.content.categories.form',['submitButtonText'=>'Add Category'])
				{!! Form::close() !!}
    </div>
    

</div>
</div>
@stop


