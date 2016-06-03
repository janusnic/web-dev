@extends ('layouts.dashboard')
@section('page_heading','New Tag')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::open(['route' => 'admin.tags.store', 'class' => 'form']) !!}
				
					@include('admin.content.tags.form',['submitButtonText'=>'Save'])
				{!! Form::close() !!}
	</div>

</div>
</div>
@stop
