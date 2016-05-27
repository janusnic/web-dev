<div  class="form-group">
    {!! Form::label('title', 'Category name:') !!}
    {!! Form::text('title', 
                       null, 
                       array('required', 
                      'class'=>'form-control', 
                      'placeholder'=>'Category name*')) !!}
</div>


<div class="form-group">
    {!! Form::label('parent_id', 'Category Parent:') !!}
    {!! Form::number('parent_id',
                       null, 
                       array(
                      'class'=>'form-control', 
                      'placeholder'=>'Category Parent')) !!}
</div>

<div class="form-group">
    {!! Form::label('seo_title', 'SEO title:') !!}
    {!! Form::text('seo_title',null, 
                       array(
                      'class'=>'form-control', 
                      'placeholder'=>'SEO title')) !!}
</div>
<div class="form-group">
    {!! Form::label('seo_key', 'Seo Key:') !!}
    {!! Form::text('seo_key',null, 
                       array(
                      'class'=>'form-control', 
                      'placeholder'=>'Seo Key')) !!}

</div>
<div class="form-group">
    {!! Form::label('seo_desc', 'SEO description:') !!}
    {!! Form::textArea('seo_desc',null, 
                       array(
                      'class'=>'form-control', 
                      'placeholder'=>'Seo description')) !!}
</div>

{!! Form::submit($submitButtonText, array('class'=>'btn btn-primary')) !!}
{!! Form::reset('Reset', array('class'=>'btn btn-info')) !!}
