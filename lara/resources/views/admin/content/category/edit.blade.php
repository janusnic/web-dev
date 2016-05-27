@extends ('layouts.dashboard')
@section('page_heading','Edit Category')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">

        {!! Form::model($category,['method' => 'PATCH', 'route' => ['admin.category.update', $category->id]]) !!}
            @include ('admin.content.category.form', ['submitButtonText' => 'Update'])
        {!! Form::close() !!}

    </div>
    

</div>
</div>
@stop



