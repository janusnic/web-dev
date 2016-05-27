@extends ('layouts.dashboard')
@section('page_heading','Edit Tag')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">

        {!! Form::model($tag,['method' => 'PATCH', 'route' => ['admin.tag.update', $tag->id]]) !!}
            @include ('admin.content.tag.form', ['submitButtonText' => 'Update'])
        {!! Form::close() !!}

    </div>
    

</div>
</div>
@stop



