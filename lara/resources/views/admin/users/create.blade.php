@extends ('layouts.dashboard')
@section('page_heading','New User')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::open(['route' => 'admin.users.store', 'class' => 'form']) !!}
				
					@include('admin.users.form',['submitButtonText'=>'Save'])
				{!! Form::close() !!}
	</div>

</div>
</div>
@stop
