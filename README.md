# web-dev unit_20

Изменение структуры таблиц
==========================
     php artisan make:migration add_role_to_users --table=users

     Created Migration: 2016_06_04_045617_add_role_to_users

    <?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddRoleToUsers extends Migration
    {
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                //
                $table->string('role', 60)->default('author')->after('password');
                
                $table->boolean('active')->default(0)->after('role');
            });

            $user = new \App\User();
            $user->name = 'janus';
            $user->email = 'janus@example.com';
            $user->password = 'ghbdtn';
            $user->role = 'admin';
            $user->active = '1';
            $user->save();
        }

        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                //
                $table->dropColumn('role'); 
                $table->dropColumn('active'); 
            });
        }
    }

class User
-----------
    <?php namespace App;

    use Illuminate\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Auth\Passwords\CanResetPassword;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

    use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
    use Illuminate\Foundation\Auth\Access\Authorizable;

    class User extends Model implements AuthenticatableContract, CanResetPasswordContract
    {
        use Authenticatable, CanResetPassword;

        protected $table = 'users';

        protected $fillable = ['name', 'email', 'password'];
        
        protected $hidden = ['password', 'remember_token'];

        public function setPasswordAttribute($password)
        {
            $this->attributes['password'] = bcrypt($password);
        }

    }

class UsersController
---------------------
    <?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests;
    use App\Http\Requests\UserRequest;
    use App\User;

    class UsersController extends Controller
    {
        public function __construct()
        {

        }

        public function index()
        {
            $users = User::latest()->paginate(15);

            return view('admin.users.index', compact('users'));
       }

       public function create()
        {
            return view('admin.users.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function store(UserRequest $request)
        {
            User::create($request->all());

            flash()->success('User has been created!');

            return redirect('admin/users');
        }


       public function edit($id)
        {
            $user = User::findOrFail($id);

            return view('admin.users.edit', compact('user'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param int $id
         *
         * @return Response
         */
        public function update(UserRequest $request, $id)
        {
            $user = User::findOrFail($id);

            $user->update($request->all());
            flash()->success('User has been updateed!');

            return redirect('admin/users');
        }
    }

admin.users.index
-----------------

    @extends('layouts.dashboard')
    @section('page_heading','Users')

    @section('section')
    <div class="col-sm-12">

    <div class="row">
        <div class="col-sm-12">
            @section ('cotable_panel_title','Users List')
            @section ('cotable_panel_body')
        
            {!! link_to_route('admin.users.create', 'New user') !!}

                     <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                {!! Form::open(['method' => 'get', 'url' => 'admin/users/'.$user->id.'/edit', 'style' => 'float:left;margin-right: 10px;']) !!}
                                    <button type="submit" class="btn btn-success btn-sm iframe cboxElement"><span class="glyphicon glyphicon-pencil"></span> Edite</button>
                                {!! Form::close() !!}

                                {!! Form::open(['method' => 'delete', 'url' => 'admin/users/'.$user->id, 'style' => 'float:left;margin-right: 10px;']) !!}
                                    <button type="submit" class="btn btn-sm btn-danger iframe cboxElement"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            <div class="row">
                <div class="col-sm-6">
                    <div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">
                        {{ $users->count() }} User(s) On Page #{{ $users->lastPage() }} From {{ $users->total() }}.
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                    <!-- /.col-lg-12 -->    <!-- pagination -->
                        {!! $users->render() !!}

                    </div>
                </div>
            </div>

            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))

    </div>
    @stop

admin.users.form
----------------
    <div class="form-group">
      {!! Form::label('name', 'Name:') !!}
      {!! Form::text('name', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('email', 'Email:') !!}
      {!! Form::email('email', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('password', 'Password:') !!}
      {!! Form::password('password', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <div class="form-group">
      {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
    </div>

    @section('header')
      <link rel="stylesheet" href="/admin-assets/css/select2.min.css">
    @endsection

    @section('footer')
      <script>
        $('#tag_list').select2({
          placeholder: 'Choose a tag',
          tags: true
        });
      </script>
    @endsection


admin.users.create
------------------

    @extends ('layouts.dashboard')
    @section('page_heading','New User')

    @section('section')
    <div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => 'admin.users.store', 'class' => 'form']) !!}
            
              @include('admin.users.form',['submitButtonText'=>'Save'])
            {!! Form::close() !!}
      </div>

    </div>
    </div>
    @stop

admin.users.edit
----------------

    @extends ('layouts.dashboard')
    @section('page_heading','Edit User')

    @section('section')
    <div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12">
            {!! Form::model($user,['method'=>'PATCH','url' => 'admin/users/'.$user->id]) !!}
              @include('admin.users.form',['submitButtonText'=>'Update Tag'])
            {!! Form::close() !!}
      </div>

    </div>
    </div>
    @stop


Аутентификация
==============
Аутентификация - это процесс сопоставления введенных логина и пароля с данными зарегистрированных пользователей сайта и определение, является ли пользователь сайта одним из них (тогда следует логин пользователя) или нет (тогда пользователь получает сообщение об ошибке). Не путать с авторизацией - процессом проверки прав на выполнение какого-либо действия. Это разные вещи, но для каждой из них Laravel предоставляет удобные инструменты.

Аутентификация в Laravel делается очень просто. Фактически, почти всё уже готово к использованию «из коробки». Настройки аутентификации находятся в файле config/auth.php, который содержит несколько хорошо документированных опций.

Фактически, подсистема аутентификации Laravel состоит из двух частей:

Guards, "гарды", "охранники". Это по сути правила аутентификации пользователя - в каких частях запроса хранить информацию о том, что данный запрос идет от аутентифицированного пользователя. Например, это можно делать в сессии/куках, или в некотором токене, который должен содержаться в каждом запросе. В Laravel это гарды session и token соответственно.

Providers, "провайдеры". Они определяют, как можно получить данные пользователя из базы данных или другого места хранения. В Laravel можно получать пользователя через Eloquent и Query Builder, но вы можете написать свой провайдер, если по каким-то причинам, хотите хранить даные пользователей, например, в файле.
Можно создавать собственные гарды и провайдеры. Это нужно, если у вас, например, несколько таблиц с пользователями, или несколько областей в приложении, куда нужно логиниться отдельно, даже уже аутентифицированным пользователям - например, админка.

Но если вы только изучаете фреймворк - не беспокойтесь, чтобы использовать аутентификацию в Laravel вам не нужно досконально разбираться, как работают гарды и провайдеры. Весь необходимый код уже написан, и схема, которая принята по умолчанию, подойдет практически всем.


Настройки базы данных
---------------------
По умолчанию Laravel использует модель App\User Eloquent в каталоге app. Эта модель может использоваться вместе с драйвером аутентификации на базе Eloquent. Если ваше приложение не использует Eloquent, вы можете применить драйвер аутентификации database, который использует Query Builder.

При создании схемы базы данных для модели App\User убедитесь, что поле пароля имеет длину минимум в 60 символов. Дефолтное значение для поля varchar - 255 - подойдет замечательно.

Также вы должны убедиться, что ваша таблица users (или её эквивалент) содержит строковое nullable поле remember_token длиной в 100 символов. Это поле используется для хранения токена сессии, если ваше приложение предоставляет функциональность «запомнить меня». Создать такое поле можно с помощью $table->rememberToken(); в миграции.

Controllers\Auth
-----------------
Laravel оснащён двумя контроллерами аутентификации «из коробки». Они находятся в пространстве имён App\Http\Controllers\Auth. AuthController обрабатывает регистрацию и аутентификацию пользователей, а PasswordController содержит логику для сброса паролей существующих пользователей. Каждый из этих контроллеров использует трейты для включения необходимых методов. В большинстве случаев вам не понадобится редактировать эти контроллеры.


Routing
--------
Чтобы сгенерировать роуты и шаблоны, которые нужны для процесса аутентификации (страница регистрации, логина, восстановления пароля и т.п.), вам нужно даль всего одну команду:

    php artisan make:auth

Вместе с ними создастся контроллер HomeController, куда будет вести редирект после успешного логина пользователя.

Естественно, вы можете отредактировать эти сгенерированные файлы так, как вам нужно.


Views
-----
шаблоны страниц регистрации создаются при помощи команды, в папке resources/views/auth. Кроме того, будет создан главный шаблон приложения resources/views/layouts, в который эти шаблоны будут подключаться. Вы можете строить приложение опираясь на этот главный шаблон, или использовать вместо него свой.


Аутентификация
---------------
Контроллеры аутентификации уже были в приложении, роуты и шаблоны вы только что сгененировали. Всё, теперь пользователи могут регистрироваться и логиниться в ваше приложение.

Настройка путей
---------------
После успешного логина пользователя надо куда-то редиректить. Куда именно - за это отвечает свойство redirectTo класса AuthController:

  protected $redirectTo = '/home';

Если логин не успешный, то происходит автоматический редирект назад на страницу логина.


class AuthController
--------------------

    <?php

    namespace App\Http\Controllers\Auth;

    use App\User;
    use Validator;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\ThrottlesLogins;
    use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

    class AuthController extends Controller
    {
        /*
        |--------------------------------------------------------------------------
        | Registration & Login Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users, as well as the
        | authentication of existing users. By default, this controller uses
        | a simple trait to add these behaviors. Why don't you explore it?
        |
        */

        use AuthenticatesAndRegistersUsers, ThrottlesLogins;

        /**
         * Where to redirect users after login / registration.
         *
         * @var string
         */
        protected $redirectTo = '/';

        /**
         * Create a new authentication controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        }

        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param  array  $data
         * @return User
         */
        protected function create(array $data)
        {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }
    }


Admin\AuthController
--------------------

    <?php namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Auth;
    use Illuminate\Http\Request;

    class AuthController extends Controller
    {
        public function __construct()
        {
            $this->middleware('guest', ['except' => 'logout']);
        }

        /**
         * Show the application login form.
         *
         * @return \Illuminate\Http\Response
         */
        public function getLogin()
        {
            return view('admin.login');
        }

        /**
         * Handle a login request to the application.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function postLogin(Request $request)
        {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, $request->has('remember'))) {
                return redirect()->intended('/admin/index');
            }

            return redirect('/login')
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email' => 'These credentials do not match our records.',
                        ]);
        }

        /**
         * Log the user out of the application.
         *
         * @return \Illuminate\Http\Response
         */
        public function logout()
        {
            Auth::logout();

            return redirect('/');
        }
    }


admin.login
-----------
      <!DOCTYPE html>
      <html lang="en">

      <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Please Sign In</title>

        @include('admin.partials.header')

      </head>

      <body>

        <div class="container">
          <div class="row">
            <div class="col-md-4 col-md-offset-4">
              <div class="login-panel panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <strong>Whoops!</strong> There were some problems with your input.<br><br>
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  {!! Form::open(['url' => '/login', 'role' => 'from', 'method' => 'post']) !!}
                    <fieldset>
                      <div class="form-group">
                        {!! Form::email('email', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                      </div>
                      <div class="form-group">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                      </div>
                      <div class="checkbox">
                        <label>
                        {!! Form::checkbox('remember', null) !!}Remember Me
                        </label>
                      </div>
                      <div class="form-group">
                        {!! Form::submit('Login', ['class' => 'btn btn-lg btn-success btn-block']) !!}
                      </div>
                    </fieldset>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        </div>

        @include('admin.partials.footer')

      </body>

      </html>


routes.php
----------

    Route::get('login', 'Admin\AuthController@getLogin');
    Route::post('login', 'Admin\AuthController@postLogin');
    Route::get('logout', 'Admin\AuthController@logout');



    Route::group(['prefix'=>'admin', 'namespace' => 'Admin', 'middleware' => 'auth'],function(){
        Route::any('/','DashboardController@index');

        Route::resource('index', 'DashboardController');
        Route::resource('categories','CategoriesController');
        Route::resource('articles','ArticlesController');
        Route::resource('tags','TagsController');
        Route::resource('users','UsersController');
    });