@extends ('layouts.dashboard')
@section('page_heading','Edit Article')
{!! HTML::style('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css') !!}
@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-12">
				{!! Form::model($article,['method' => 'PATCH', 'route' => ['admin.articles.update', $article->id]]) !!}
            	@include ('admin.content.articles.form', ['submitButtonText' => 'Update', 'form_date'=>$article->created_at->format('Y-m-d')])
        		{!! Form::close() !!}
    </div>
    

</div>
</div>
@stop

@section('scripts')

  {!! HTML::script('ckeditor/ckeditor.js') !!}
  
  <script>


  var config = {
    codeSnippet_theme: 'Monokai',
    //language: '{{ config('app.locale') }}',
    // height: 100,

    toolbarGroups: [
      { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
      { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
      { name: 'links' },
      { name: 'insert' },
      { name: 'forms' },
      { name: 'tools' },
      { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
      { name: 'others' },
      //'/',
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
      { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
      { name: 'styles' },
      { name: 'colors' }
    ]
  };

  // CKEDITOR.replace( 'summary', config);

  config['height'] = 400;   

  CKEDITOR.replace( 'content', config);

  $("#title").keyup(function(){
      var str = sansAccent($(this).val());
      str = str.replace(/[^a-zA-Z0-9\s]/g,"");
      str = str.toLowerCase();
      str = str.replace(/\s/g,'-');
      $("#permalien").val(str);        
    });

  </script>

@stop

