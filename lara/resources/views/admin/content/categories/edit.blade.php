@extends ('layouts.dashboard')
@section('page_heading','Edit Category')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">

				{!! Form::model($category,['method'=>'PATCH','url' => 'admin/categories/'.$category->id]) !!}
					@include('admin.content.categories.form',['submitButtonText'=>'Update Category'])
				{!! Form::close() !!}
    </div>
    

</div>
</div>
@stop

