@extends ('layouts.dashboard')
@section('page_heading','Edit User')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::model($user,['method'=>'PATCH','url' => 'admin/users/'.$user->id]) !!}
					@include('admin.users.form',['submitButtonText'=>'Update Tag'])
				{!! Form::close() !!}
	</div>

</div>
</div>
@stop

