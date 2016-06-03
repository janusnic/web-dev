<div  class="form-group">
    {!! Form::label('title', 'Article title:') !!}
    {!! Form::text('title', 
                       null, 
                       array('required', 
                      'class'=>'form-control', 
                      'autofocus' => 'autofocus',
                      'placeholder'=>'Article title*')) !!}
</div>

<div class="form-group">
     {!! Form::textarea('summary', null,
         ['class'=>'form-control', 'placeholder'=>'Summary'])
     !!}
</div>

<div class="form-group">
	{!! Form::label('content', 'Body:') !!}
	{!! Form::textarea('content', null, ['class' => 'form-control', 'style' => 'overflow-x:hidden', 'rows' => '22']) !!}
</div>

<div class="form-group">
	{!! Form::label('category_id', 'Category:') !!}
	<select class="form-control" name="category_id" id="category_id">
		@foreach ($categories as $category)
			<option value="{{ $category->id }}"
			@if(($article->category_id) && $category->id == $article->category_id)
				selected
			@endif
			>{{ $category->title }}</option>
			
		@endforeach
	</select>
</div>

<div class="form-group">
	{!! Form::label('tag_list', 'Tags:') !!}
	{!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
</div>

<div class="form-group">
	{!! Form::label('published_at', 'Time:') !!}
	{!! Form::input('date', 'published_at', $form_date, ['class' => 'form-control']) !!}
</div>




<div class="form-group">
    {!! Form::label('seen', 'Article seen:') !!}
    {!! Form::checkbox('seen') !!}
</div>

<div class="form-group">
    {!! Form::label('active', 'Article active:') !!}
    {!! Form::checkbox('active') !!}
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


<div class="form-group">
	{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
	{!! Form::reset('Reset', array('class'=>'btn btn-info')) !!}
</div>

@section('header')
	<link rel="stylesheet" href="/admin-assets/css/select2.min.css">
	<link rel="stylesheet" href="/admin-assets/css/codemirror.css">
@stop

@section('footer')
	<!-- CodeMirror -->
	<script src="/admin-assets/js/codemirror.js"></script>
	<script src="/admin-assets/js/markdown.js"></script>
	<script src="/admin-assets/js/continuelist.js"></script>

	<!-- inline-attachment -->
	<script src="/admin-assets/js/inline-attachment.js"></script>
	<script src="/admin-assets/js/jquery.inline-attachment.js"></script>

	<!-- select2 -->
	<script src="/admin-assets/js/select2.min.js"></script>
	<script>
		
		$('#tag_list').select2({
			placeholder: 'Choose a tag',
			tags: true
		});
		$('#category_id').select2();
		
	</script>
@stop
