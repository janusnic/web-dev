@extends ('layouts.dashboard')
@section('page_heading','New Tag')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::model($tag,['method'=>'PATCH','url' => 'admin/tags/'.$tag->id]) !!}
					@include('admin.content.tags.form',['submitButtonText'=>'Update Tag'])
				{!! Form::close() !!}
	</div>

</div>
</div>
@stop

