@extends ('layouts.dashboard')
@section('page_heading','New Category')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
        
        {!! Form::open(['route' => 'admin.category.store', 'class' => 'form']) !!}
            @include ('admin.content.category.form', ['submitButtonText' => 'Save'])
        {!! Form::close() !!}

    </div>
    

</div>
</div>
@stop



