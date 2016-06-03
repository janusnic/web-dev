<div class="form-group">
	{!! Form::label('title', 'Name:') !!}
	{!! Form::text('title', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
</div>

	{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
	{!! Form::reset('Reset', array('class'=>'btn btn-info')) !!}


@section('header')
	<link rel="stylesheet" href="/admin-assets/css/select2.min.css">
@endsection

@section('footer')
	<script src="/admin-assets/js/select2.min.js"></script>
	<script>
		$('#parent_id').select2();
	</script>
@endsection
