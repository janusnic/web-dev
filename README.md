# web-dev unit_17

Admin Laravel
=============

http://startlaravel.com/

https://github.com/start-laravel/sb-admin-laravel-5


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

Category
========
Для создания модели выполним:

    $ php artisan make:model --migration Category

    Model created successfully.
    Created Migration: 2016_05_27_080310_create_categories_table


Добавляем нужные нам поля:
--------------------------
файл database/migrations/2016_05_27_080310_create_categories_table.php

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('parent_id')->default(0);
            $table->string('seo_title');
            $table->string('seo_key');
            $table->string('seo_desc');
            $table->timestamps();
        });
    }


Создаем таблицы в БД:
---------------------
    php artisan migrate

    Migrated: 2016_05_27_080310_create_categories_table


Генерируем контроллер:
----------------------

CategoryController

    php artisan make:controller CategoryController

    Controller created successfully.

admin/CategoryController

    php artisan make:controller admin/CategoryController

    Controller created successfully.


Добавляем маршрут в app/Http/routes.php
---------------------------------------

    <?php

    Route::get('/', ['as' => 'posts', 'uses' => 'PostController@index']);

    Route::get('blog/{slug}', 'BlogController@showPost');  

    Route::resource('posts', 'PostController');
    Route::resource('blog', 'BlogController');
    Route::resource('category', 'CategoryController');

    Route::group(['prefix'=>'admin'],function(){
        Route::any('/','admin\DashboardController@index');
        Route::resource('home', 'admin\DashboardController');
        Route::resource('category','admin\CategoryController');
        Route::resource('blog','admin\BlogController');
    });


config/blog.php
----------------

      <?php
      return [
          'title' => 'Janus Blog',
          'posts_per_page' => 5,
          'admin_posts_per_page' => 10,
          'admin_title'=>'Admin Dashboard'
      ];


В контроллере создаем основные методы: 
--------------------------------------

    <?php

    namespace App\Http\Controllers\admin;

    use Illuminate\Http\Request;

    use App\Category;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class CategoryController extends Controller
    {

        public function index()
        {
         
        $categories = Category::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
            return view('admin.content.category.index', compact('categories')); 

        }

        public function create()
        {
            $category = new Category;
            return view('admin.content.category.create', compact('category'));
        }
        
        public function store(Request $request)
        {
            Category::create($request->all());
            return redirect('/admin/category');
        }
        
        public function show($id)
        {
            $category = Category::where('id', $id)->firstOrFail();
            return view('admin.content.category.show', compact('category'));
        }
        public function edit($id)
        {
            $category = Category::where('id', $id)->firstOrFail();
            return view('admin.content.category.edit', compact('category'));
        }

        public function update(Request $request, $id)
        {
            $category = Category::where('id', $id)->firstOrFail();
            $category->update($request->all());
            return redirect('/admin/category');

        }
        public function destroy($id)
        {
            Category::where('id', $id)->delete();
            return redirect('/admin/category');
        }

    }


Создаем представления view в resources/views/admin/content/category/

blade шаблон для index:
-----------------------
resources/views/admin/content/category/index.blade.php

    @extends('layouts.dashboard')
    @section('page_heading','Categories')

    @section('section')
    <div class="col-sm-12">

    <div class="row">
        <div class="col-sm-12">
            @section ('cotable_panel_title','Categories List')
            @section ('cotable_panel_body')
        
        {!! link_to_route('admin.category.create', 'New category') !!}
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                          <th>id</th>
                          <th>Name</th>
                          <th>Edit</th>
                          <th>Remove</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($categories as $category)

                    <tr class="success">
                        <td>{!! link_to_route('admin.category.edit', $category->id, $category->id) !!}</td>
                        <td>{!! link_to_route('admin.category.edit', $category->title, $category->id) !!}</td>
                        <td>{!! link_to_route('admin.category.edit', 'Edit', $category->id) !!}</td>

                        <td>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.category.destroy', $category->id]]) !!}
                        <button type="submit">Delete</button>
                        {!! Form::close() !!}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>    
        
        <!-- pagination -->
        {!! $categories->render() !!}

            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
        </div>
    </div>
    </div>
    @stop


blade шаблон для create:
------------------------
resources/views/admin/content/category/create.blade.php

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


Добавляем через composer помошник HTML форм:

    composer require laravelcollective/html

и добавляем его в config/app.php

   'providers' => [
          ...
          Collective\Html\HtmlServiceProvider::class,
      ]
      ...
      'aliases' => [
          ...
          'Form'      => Collective\Html\FormFacade::class,
          'Html'      => Collective\Html\HtmlFacade::class,
      ]


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



blade шаблон для формы:
----------------------
resources/views/admin/content/category/form.blade.php

    <div  class="form-group">
        {!! Form::label('title', 'Category name:') !!}
        {!! Form::text('title', 
                           null, 
                           array('required', 
                          'class'=>'form-control', 
                          'placeholder'=>'Category name*')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('slug', 'Category slug:') !!}
        {!! Form::text('slug',
                           null, 
                           array('required', 
                          'class'=>'form-control', 
                          'placeholder'=>'Category slug*')) !!}
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



Model Category
--------------

в модели указываем какие поля можно присваивать

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Category extends Model
    {
        protected $fillable = ['title', 'slug', 'parent_id', 'seo_title', 'seo_key', 'seo_desc'];

    }


blade шаблон для edit:
----------------------
resources/views/admin/content/category/edit.blade.php

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

layouts/dashboard.blade.php
---------------------------

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li {{ (Request::is('/admin') ? 'class="active"' : '') }}>
                            <a href="{{ url ('admin') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Categories<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*category') ? 'class="active"' : '') }}>
                                    <a href="{{ url ('/admin/category') }}">All Categories</a>
                                </li>
                                <li>
                                    <a href="{{ url ('/admin/category/create') }}">Add Category</a>
                                </li>
                            </ul>



Всякий раз, когда объекту присваивается свойство title, будет вызван метод setTitleAttribute который проверит его на существование и добавит slug

model Category
--------------
    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Category extends Model
    {
        protected $fillable = ['title','slug', 'parent_id', 'seo_title', 'seo_key', 'seo_desc'];

      public function setTitleAttribute($value) 

      {
        $this->attributes['title'] = $value;

        if (! $this->exists) {
          $this->attributes['slug'] = str_slug($value);
        }
      }

    }

blade шаблон для формы:
----------------------
resources/views/admin/content/category/form.blade.php

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


Model Tag
---------
    php artisan make:model --migration Tag

    Model created successfully.
    Created Migration: 2016_05_27_130215_create_tags_table


2016_05_27_130215_create_tags_table

    class CreateTagsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('tag')->unique();
                $table->timestamps();
            });

             DB::table('tags')->insert([
                'tag' => "Pink"
                ]);

            DB::table('tags')->insert([
                'tag' => "T-Shirt"
                ]);
        }

Migration
---------
    php artisan migrate

    Migrated: 2016_05_27_130215_create_tags_table

Tag Model
---------

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Tag extends Model
    {
        protected $fillable = array('tag');
    }

admin/TagController
--------------------
    php artisan make:controller admin/TagController

    Controller created successfully.

routes.php
----------

    Route::group(['prefix'=>'admin'],function(){
        Route::any('/','admin\DashboardController@index');
        Route::resource('home', 'admin\DashboardController');
        Route::resource('category','admin\CategoryController');
        Route::resource('tag','admin\TagController');
        Route::resource('blog','admin\BlogController');
    });


TagController
-------------
      <?php

      namespace App\Http\Controllers\admin;

      use Illuminate\Http\Request;
      use App\Tag;
      use App\Http\Requests;
      use App\Http\Controllers\Controller;

      class TagController extends Controller
      {
          public function index()
          {
           
          $tags = Tag::orderBy('id', 'DESC')->paginate(config('blog.admin_posts_per_page'));
              return view('admin.content.tag.index', compact('tags')); 

          }

          public function create()
          {
              $tag = new Tag;
              return view('admin.content.tag.create', compact('tag'));
          }
          
          public function store(Request $request)
          {
              Tag::create($request->all());
              return redirect('/admin/tag');
          }
          
          public function show($id)
          {
              $tag = Tag::where('id', $id)->firstOrFail();
              return view('admin.content.tag.show', compact('tag'));
          }
          public function edit($id)
          {
              $tag = Tag::where('id', $id)->firstOrFail();
              return view('admin.content.tag.edit', compact('tag'));
          }

          public function update(Request $request, $id)
          {
              $tag = Tag::where('id', $id)->firstOrFail();
              $tag->update($request->all());
              return redirect('/admin/tag');

          }
          public function destroy($id)
          {
              Tag::where('id', $id)->delete();
              return redirect('/admin/tag');
          }

      }


create tag
-----------
    @extends ('layouts.dashboard')
    @section('page_heading','New Tag')

    @section('section')
    <div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12">
            
            {!! Form::open(['route' => 'admin.tag.store', 'class' => 'form']) !!}
                @include ('admin.content.tag.form', ['submitButtonText' => 'Save'])
            {!! Form::close() !!}

        </div>
        

    </div>
    </div>
    @stop

edit tag
--------
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


form tag
--------

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

index tag
---------

    @extends('layouts.dashboard')
    @section('page_heading','Tags')

    @section('section')
    <div class="col-sm-12">

    <div class="row">
        <div class="col-sm-12">
            @section ('cotable_panel_title','Tags List')
            @section ('cotable_panel_body')
        
        {!! link_to_route('admin.tag.create', 'New Tag') !!}
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                          <th>id</th>
                          <th>Name</th>
                          <th>Edit</th>
                          <th>Remove</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($tags as $tag)

                    <tr class="success">
                        <td>{!! link_to_route('admin.tag.edit', $tag->id, $tag->id) !!}</td>
                        <td>{!! link_to_route('admin.tag.edit', $tag->tag, $tag->id) !!}</td>
                        <td>{!! link_to_route('admin.tag.edit', 'Edit', $tag->id) !!}</td>

                        <td>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.tag.destroy', $tag->id]]) !!}
                        <button type="submit">Delete</button>
                        {!! Form::close() !!}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>    
        
        <!-- pagination -->
        {!! $tags->render() !!}

            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
        </div>
    </div>
    </div>
    @stop

dashboard tag
-------------
                        <li {{ (Request::is('*tag') ? 'class="active"' : '') }}>
                            <a href="{{ url ('/admin/tag') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Tags</a>
                            <!-- /.nav-second-level -->
                        </li>