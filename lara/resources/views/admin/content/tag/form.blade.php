<div  class="form-group">
    {!! Form::label('tag', 'Tag name:') !!}
    {!! Form::text('tag', 
                       null, 
                       array('required', 
                      'class'=>'form-control', 
                      'placeholder'=>'Tag name*')) !!}
</div>

{!! Form::submit($submitButtonText, array('class'=>'btn btn-primary')) !!}
{!! Form::reset('Reset', array('class'=>'btn btn-info')) !!}
