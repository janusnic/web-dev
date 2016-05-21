<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
        <div class="container">
        {{--Header Finished--}}



        <div><h1>Add New Post</h1></div>
        {!! Form::open(['action' => 'admin\BlogController@store']) !!}
       
            <div class="form-group">
                {!! Form::label('title', 'Title :') !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('content', 'content :') !!}
                {!! Form::textarea('content', null,  ['class'=>'form-control', 'placeholder'=>'content']) !!}
            </div>


            <br>
            <div class="form-group">
                {!! Form::submit( 'Update', ['class'=>'btn btn-toolbar']) !!} <button class="btn btn-toolbar pull-right"><a href="/admin/blog">Back to Home</a></button>            </div>

            {!! Form::close() !!}
            @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            {{--Footer Started--}}
     </div>
</body>
</html>
