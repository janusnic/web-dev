# web-dev unit_16

Dashboard
----------
    php artisan make:controller admin/DashboardController

    Controller created successfully.

admin/DashboardController
-------------------------
    <?php

    namespace App\Http\Controllers\admin;

    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class DashboardController extends Controller
    {
        //
    }

admin/BlogController
--------------------
    php artisan make:controller admin/BlogController

    Controller created successfully.

    <?php

    namespace App\Http\Controllers\admin;

    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class BlogController extends Controller
    {
        //
    }


Application Routes
------------------
      <?php

      Route::get('/', ['as' => 'posts', 'uses' => 'PostController@index']);

      Route::get('blog/{slug}', 'BlogController@showPost');  

      Route::resource('posts', 'PostController');
      Route::resource('blog', 'BlogController');

      Route::group(['prefix'=>'admin'],function(){
          Route::any('/','admin\DashboardController@index');
          Route::resource('home', 'admin\DashboardController');
          Route::resource('blog','admin\BlogController');
      });



DashboardController
-------------------
    <?php

    namespace App\Http\Controllers\admin;

    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Illuminate\View\View;

    class DashboardController extends Controller
    {
        
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
            return view('admin.home');
        }
    }


config/blog.php
----------------
      <?php
      return [
          'title' => 'Janus Blog',
          'posts_per_page' => 5,
          'admin_posts_per_page' => 10
      ];

BlogController
--------------
    <?php

    namespace App\Http\Controllers\admin;

    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use App\Post;

    class BlogController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
            //
            $posts = Post::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
            

            return view('admin.blog.index', compact('posts')); 

        }
    }


home.blade.php
--------------
      @extends('admin.backend')

      @section('title')
        <title>{{ config('blog.title') }}</title>
      @stop
      @section('content')
          <h1>{{ config('blog.admin_title') }}</h1>
          <div class="content">
                
            </div>
                
            <hr>
       
      @stop


config/blog.php
----------------

      <?php
      return [
          'title' => 'Janus Blog',
          'posts_per_page' => 5,
          'admin_posts_per_page' => 10,
          'admin_title'=>'Admin Dashboard'
      ];



admin/blog/index.blade.php
--------------------------
      @extends('admin.backend')

      @section('title')
        <title>{{ config('blog.title') }}</title>
      @stop
      @section('content')
          <h1>{{ config('blog.title') }}</h1>
          <div class="content">
                <h5>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</h5>
                <ul>
                  @foreach ($posts as $post)
                    <li>
                      <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                      <em>({{ $post->published_at->format('M jS Y g:ia') }})</em>
                      
                    </li>
                  @endforeach
                </ul>
            </div>
                {!! $posts->render() !!}
            <hr>
       
      @stop

composer.json
--------------
       "require": {
            "php": ">=5.5.9",
            "laravel/framework": "5.2.*",
            "laravelcollective/html": "^5.2"
        },

app.php
-------
       /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        //Illuminate\Html\HtmlServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,


          'aliases' => [

        'View' => Illuminate\Support\Facades\View::class,
        //'Form'      => 'Illuminate\Html\FormFacade',
        //'Html'      => 'Illuminate\Html\HtmlFacade',
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,


index.blade.php
----------------
      @extends('admin.backend')

      @section('title')
        <title>{{ config('blog.title') }}</title>
      @stop
      @section('content')
          <h1>{{ config('blog.title') }}</h1>
          <div class="content">
                <div class="btn btn-block"><a href="{{ route('admin.blog.create')  }}"><h2>Add New Post</h2></a></div>
                <h5>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</h5>
                 <div class="panel-body">
                          <a class="btn btn-success" href="{{ URL::route('admin.blog.create')}}">New Post</a>

                          <table class="table table-hover table-top">
                              <tr>
                                  <th>#</th>
                                  <th>title</th>
                                  <th>create</th>
                                  <th>Remove</th>
                                  <th class="text-right">Edit</th>
                              </tr>

                              @foreach($posts as $post)
                              <tr>
                                  <th scope="row">{{ $post->id }}</th>
                                  <td>{{ $post->title }}</td>
                                  <td>{{ $post->created_at }}</td>
                                  <td class="text-right">

                                  {!! Form::open(['route' => ['admin.blog.destroy', $post->id], 'method' => 'delete']) !!}
                                 <input class="btn btn-default col-xs-2" type="submit" value="Delete" />
                                 {!! Form::close() !!}

                                 {!! Form::open(['route' => ['admin.blog.edit', $post->id], 'method' => 'edit']) !!}
                                 <input class="btn btn-default col-xs-2" type="submit" value="Edit" />
                                 {!! Form::close() !!}

                                  </td>

                              </tr>
                              @endforeach
                          </table>

                      </div>

            </div>
                {!! $posts->render() !!}
            <hr>
       
      @stop

function edit($id)
------------------
       /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
      public function edit($id)
        {
            //Get Result by targeting id
            $post = Post::find($id);

            //Redirecting to edit.blade.php with $post variable
            return view('admin.blog.edit')->with('post',$post);
        }    

Route
------
  Route::post('admin/blog/{id}/edit', 'admin\BlogController@edit');

edit.blade.php
--------------
      <html>
      <head>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
      </head>
      <body>
              <div class="container">
              {{--Header Finished--}}

              <div><h1>Edit {{ $post->title }}</h1></div>
              {!! Form::model($post, ['route' => ['admin.blog.update', $post->id ], 'method'=>'PUT']) !!}
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

Route
------
Route::post('admin/blog/{id}/update', 'admin\BlogController@update');


Validation request
-------------------
Make new request(app/Http/Requests)

    php artisan make:request BlogRequest

    Request created successfully.

class BlogRequest
-----------------
      <?php

      namespace App\Http\Requests;

      use App\Http\Requests\Request;

      class BlogRequest extends Request
      {
          /**
           * Determine if the user is authorized to make this request.
           *
           * @return bool
           */
          public function authorize()
          {
              return false;
          }

          /**
           * Get the validation rules that apply to the request.
           *
           * @return array
           */
          public function rules()
          {
              return [
                  //
              ];
          }
      }


      <?php

      namespace App\Http\Requests;

      use App\Http\Requests\Request;

      class BlogRequest extends Request
      {
          /**
           * Determine if the user is authorized to make this request.
           *
           * @return bool
           */
          public function authorize()
          {
              return false;
          }

          /**
           * Get the validation rules that apply to the request.
           *
           * @return array
           */
          public function rules()
          {
              return [
                  'title' => 'required',
                  'content' => 'required'
                  
              ];
          }
      }


add.blade.php
-------------
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
