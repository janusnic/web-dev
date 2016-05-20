# web-dev unit_15

СОЗДАНИЕ ПРОСТОГО БЛОГА НА LARAVEL
==================================
Основы работы с базами данных
-----------------------------
Настройка

Настройки работы с БД хранятся в файле config/database.php. Здесь вы можете указать все используемые вами соединения к БД, а также задать то, какое из них будет использоваться по умолчанию. Примеры настройки всех возможных видов подключений находятся в этом же файле.

На данный момент Laravel поддерживает 4 СУБД: MySQL, PostgreSQL, SQLite и SQL Server.

.env
----
        ENV=local
        APP_DEBUG=true
        APP_KEY=base64:cYI7guydCo2TIXLB+1cWZcStHflixXtXIKXXtNRfXrs=
        APP_URL=http://localhost

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=lara
        DB_USERNAME=dev
        DB_PASSWORD=ghbdtn

Соединения для чтения/записи

Иногда вам может понадобиться использовать разные подключения к базе данных: одно для запросов SELECT, а другое для запросов INSERT, UPDATE и DELETE. В Laravel это делается очень просто, и всегда будет использоваться соответствующее соединение, используете ли вы сырые запросы, построитель запросов или Eloquent ORM.


СОЗДАДИМ ТАБЛИЦУ В КОТОРОЙ БУДУТ ХРАНИТЬСЯ НАШИ ПОСТЫ
=====================================================
Во-первых создадим модель.

    php artisan make:model --migration Post

    Model created successfully.
    Created Migration: 2016_05_20_120234_create_posts_table

После выполнения команды произойдет следующее:
Будет создан класс модели App\Post в папке app в корне проекта.

        <?php

        namespace App;

        use Illuminate\Database\Eloquent\Model;

        class Post extends Model
        {
            //
        }

Будет создана миграция для создания таблицы в БД. Вы можете увидеть ее в директории database/migrations.

        <?php

        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;

        class CreatePostsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('posts', function (Blueprint $table) {
                    $table->increments('id');
                    $table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::drop('posts');
            }
        }


ЧТО ТАКОЕ МИГРАЦИЯ?
===================
Миграция - своеобразная система контроля версий структуры вашей базы данных. 
Они позволяют команде изменять её структуру, в то же время оставаясь в курсе изменений других участников. 

Создание миграций
-----------------
Для создания новой миграции вы можете использовать Artisan-команду make:migration:

        php artisan make:migration create_users_table

Миграция будет помещена в папку database/migrations и будет содержать метку времени, которая позволяет фреймворку определять порядок применения миграций.

Можно также использовать параметры --table и --create для указания имени таблицы и того факта, что миграция будет создавать новую таблицу (а не изменять существующую):

        php artisan make:migration add_votes_to_users_table --table=users

        php artisan make:migration create_users_table --create=users

Применение миграций
===================
Накатывание всех неприменённых миграций

    php artisan migrate

Если при применении миграции вы получаете ошибку «class not found» («класс не найден»), попробуйте выполнить команду composer dump-autoload.

Принудительные миграции в продакшне
-----------------------------------
Некоторые операции миграций разрушительны, они могут привести к потере ваших данных. Для предотвращения случайного запуска этих команд на вашей боевой БД перед их выполнением запрашивается подтверждение. Для принудительного запуска команд без подтверждения используйте ключ --force:

        php artisan migrate --force

Откат миграций
==============
Отмена изменений последней миграции

        php artisan migrate:rollback

Отмена изменений всех миграций

        php artisan migrate:reset

Откат всех миграций и их повторное применение

        php artisan migrate:refresh

        php artisan migrate:refresh --seed

Отредактируйте только что созданный файл миграции в директории database/migrations и приведите его к такому виду:

        <?php

        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;

        class CreatePostsTable extends Migration
        {

          /**
           * Run the migrations.
           */
          public function up()
          {
            Schema::create('posts', function (Blueprint $table) {
              $table->increments('id');
              $table->string('slug')->unique();
              $table->string('title');
              $table->text('content');
              $table->timestamps();
              $table->timestamp('published_at')->index();
            });
          }

          /**
           * Reverse the migrations.
           */
          public function down()
          {
            Schema::drop('posts');
          }
        }


мы добавали дополнительные, нужные нам колонки, в дополнение к созданным изначально.

- slug - Мы будем конвертировать название каждого поста, используя это название, как часть URL. 
Это поможет нам сделать наш блог более дружественным к поисковым системам.

- title - какой же пост без названия?
- content - А уж тем более без контента!
- published_at - Для того, что бы мы могли контролировать дату публикации.

Теперь, когда миграция отредактирована, мы можем запустить ее для создания нужной нам структуры таблицы

    php artisan migrate

    Migration table created successfully.
    Migrated: 2014_10_12_000000_create_users_table
    Migrated: 2014_10_12_100000_create_password_resets_table
    Migrated: 2016_05_20_120234_create_posts_table



отредактируем app/Post.php :
----------------------------

        <?php

        namespace App;

        use Illuminate\Database\Eloquent\Model;

        class Post extends Model
        {
          protected $dates = ['published_at']; // Не забываем, что колонка published_at содержит дату

          public function setTitleAttribute($value) //Всякий раз, когда объекту присваивается свойство title, будет вызван метод setTitleAttribute
          {                                         //который проверит его на существование и добавит slug
            $this->attributes['title'] = $value;

            if (! $this->exists) {
              $this->attributes['slug'] = str_slug($value);
            }
          }
        }


Загрузка начальных данных в БД
==============================
Кроме миграций Laravel также включает в себя механизм наполнения вашей БД начальными данными (seeding) с помощью специальных классов. Все такие классы хранятся в database/seeds. Они могут иметь любое имя, но вам, вероятно, следует придерживаться какой-то логики в их именовании — например, UserTableSeeder и т.д. По умолчанию для вас уже определён класс DatabaseSeeder. Из этого класса вы можете вызывать метод call() для подключения других классов с данными, что позволит вам контролировать порядок их выполнения.

Пример класса для загрузки начальных данных

        class DatabaseSeeder extends Seeder {

          public function run()
          {
            $this->call('UserTableSeeder');

            $this->command->info('Таблица пользователей загружена данными!');
          }

        }

        class UserTableSeeder extends Seeder {

          public function run()
          {
            DB::table('users')->delete();

            User::create(['email' => 'foo@bar.com']);
          }

        }

Для добавления данных в БД используйте Artisan-команду db:seed:

    php artisan db:seed

По умолчанию команда db:seed вызывает класс DatabaseSeeder, который может быть использован для вызова других классов, заполняющих БД данными. Однако, вы можете использовать параметр --class для указания конкретного класса для вызова:

    php artisan db:seed --class=UserTableSeeder

Вы также можете использовать для заполнения БД данными команду %%(sh)migrate:refresh**, которая также откатит и заново применит все ваши миграции:

    php artisan migrate:refresh --seed

ДОБАВИМ ТЕСТОВЫЕ ДАННЫЕ
-----------------------

Теперь пришло самое время наполнить базу данных несколькими тестовыми постами. ЧТо бы сделать это мы будем использовать библиотеку Faker.

Добавьте следующий код в файл ModelFactory.php находящийся в директории database/factories.

        $factory->define(App\Post::class, function ($faker) {                 
          return [                                                         
            'title' => $faker->sentence(mt_rand(3, 10)),
            'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
            'published_at' => $faker->dateTimeBetween('-1 month', '+3 days'),
          ];
        });

Теперь отредактируем файл DatabaseSeeder.php, находящийся в директории database/seeds и приведем его к такому виду:

        <?php

        use Illuminate\Database\Seeder;
        use Illuminate\Database\Eloquent\Model;

        class DatabaseSeeder extends Seeder
        {
          /**
           * Run the database seeds.
           */
          public function run()
          {
            Model::unguard();

            $this->call('PostTableSeeder');
          }

        }

        class PostTableSeeder extends Seeder
        {
          public function run()
          {
            App\Post::truncate();

            factory(App\Post::class, 20)->create();
          }
        }


чтобы заполнить БД рандомными данными, воспользуемся artisan.
-------------------------------------------------------------
    
    php artisan db:seed

    Seeded: PostTableSeeder

Запуск команды artisan db:seed выполнит запись 20 постов в таблицу. Для проверки вы можете воспользоваться любам клиентом.

СОЗДАДИМ КОНФИГУРАЦИЮ.
----------------------

Конечно же нам понадобятся некоторые настраиваемые опции для настройки отдельных параметров нашего блога, такие, например, как количество постов на странице.

Создадим новый файл в директории config, именем blog.php и содержимым:

        <?php
        return [
            'title' => 'Janus Blog',
            'posts_per_page' => 5
        ];

Благодаря использованию Laravel мы можем легко получить значения настроек в любом, удобном для нас месте, используя config(). Например config('blog.title') вернет нам значение title.

РОУТИНГ И КОНТРОЛЛЕРЫ.
======================
отредактируем файл app/Http/routes.php :
----------------------------------------

        <?php

        get('/', function () {                          // При запросе на http://lara.com/
            return redirect('/blog');                   // Будет происходить редирект на http://lara.com/blog
        });

        get('blog', 'BlogController@index');            // При запросе к http://lara.com/blog будет вызван метод index()
                                                        // Класса BlogController

        get('blog/{slug}', 'BlogController@showPost');  // При запросе к http://lara.com/blog/что-нибудь будет вызва метод showPost()
                                                        // Класса BlogController

Выполнение запросов
-------------------
Как только вы настроили соединение с базой данных вы можете выполнять запросы, используя фасад DB.

Выполнение запроса SELECT
-------------------------
    $results = DB::select('select * from users where id = ?', [1]);

Метод select() всегда возвращает массив.

Вы также можете выполнить запрос, используя привязку по имени:

    $results = DB::select('select * from users where id = :id', ['id' => 1]);

Конструктор запросов
====================
Конструктор запросов предоставляет удобный, выразительный интерфейс для создания и выполнения запросов к базе данных. Он может использоваться для выполнения большинства типов операций и работает со всеми поддерживаемыми СУБД.

конструктор запросов Laravel использует привязку параметров к запросам средствами PDO для защиты вашего приложения от SQL-инъекций. Нет необходимости экранировать строки перед их передачей в запрос.

Выборка (SELECT)
-----------------
Получение всех записей таблицы

        $users = DB::table('users')->get();

        foreach ($users as $user) {
          var_dump($user->name);
        }
        Получение результатов из таблицы «по кускам»

        DB::table('users')->chunk(100, function($users)
        {
          foreach ($users as $user)
          {
            //
          }
        });

Вы можете остановить обработку последующих «кусков» вернув false из замыкания:

        DB::table('users')->chunk(100, function($users)
        {
          //

          return false;
        });
Получение одной записи
----------------------
        $user = DB::table('users')->where('name', 'Джон')->first();

        var_dump($user->name);
Получение одного поля из записей
--------------------------------
        $name = DB::table('users')->where('name', 'Джон')->pluck('name');
Получение списка всех значений одного поля
------------------------------------------
        $roles = DB::table('roles')->lists('title');
Этот метод вернёт массив всех заголовков (title). Вы можете указать произвольный ключ для возвращаемого массива:

        $roles = DB::table('roles')->lists('title', 'name');
Указание полей для выборки
--------------------------
        $users = DB::table('users')->select('name', 'email')->get();

        $users = DB::table('users')->distinct()->get();

        $users = DB::table('users')->select('name as user_name')->get();
Добавление полей к созданному запросу
-------------------------------------
        $query = DB::table('users')->select('name');

        $users = $query->addSelect('age')->get();
Фильтрация через WHERE
----------------------
        $users = DB::table('users')->where('votes', '>', 100)->get();
Условия ИЛИ
-----------
        $users = DB::table('users')
                            ->where('votes', '>', 100)
                            ->orWhere('name', 'Джон')
                            ->get();
Фильтрация по интервалу значений
--------------------------------
        $users = DB::table('users')
                            ->whereBetween('votes', [1, 100])->get();
        Фильтрация по отсутствию в интервале

        $users = DB::table('users')
                            ->whereNotBetween('votes', [1, 100])->get();
Фильтрация по совпадению с массивом значений
--------------------------------------------
        $users = DB::table('users')
                            ->whereIn('id', [1, 2, 3])->get();

        $users = DB::table('users')
                            ->whereNotIn('id', [1, 2, 3])->get();
Поиск неустановленных значений (NULL)
-------------------------------------
        $users = DB::table('users')
                            ->whereNull('updated_at')->get();
Динамические условия WHERE
--------------------------
Вы можете использовать даже «динамические» условия where для гибкого построения операторов, используя магические методы:

        $admin = DB::table('users')->whereId(1)->first();

        $john = DB::table('users')
                            ->whereIdAndEmail(2, 'john@doe.com')
                            ->first();

        $jane = DB::table('users')
                            ->whereNameOrAge('Jane', 22)
                            ->first();
Использование ORDER BY, GROUP BY и HAVING
-----------------------------------------
        $users = DB::table('users')
                            ->orderBy('name', 'desc')
                            ->groupBy('count')
                            ->having('count', '>', 100)
                            ->get();
Смещение от начала и лимит числа возвращаемых строк
---------------------------------------------------
        $users = DB::table('users')->skip(10)->take(5)->get();


создадим BlogController.
------------------------
Для начала воспользуемся artisan:

    php artisan make:controller BlogController
    
    Controller created successfully.

Новый файл с именем BlogController.php будет создан в директории app/Http/Controllers. 

Отредактируем его:

        <?php

        namespace App\Http\Controllers;

        use App\Post;
        use Carbon\Carbon;

        class BlogController extends Controller
        {
            public function index()
            {
                $posts = Post::where('published_at', '<=', Carbon::now()) // Делаем запрос
                    ->orderBy('published_at', 'desc')
                    ->paginate(config('blog.posts_per_page'));

                return view('blog.index', compact('posts')); // Возвращаем представление blog\index.blade.php в переменной $posts
            }

            public function showPost($slug)
            {
                $post = Post::whereSlug($slug)->firstOrFail();

                return view('blog.post')->withPost($post);
            }
        }

СОЗДАДИМ ПРЕДСТАВЛЕНИЯ.
-----------------------
Перове выведет нам список постов, второе позволит просмотреть весь пост целиком.
Создайте новую директорию в resources/views и назовите ее blog. Затем создайте в ней файл index.blade.php со следующим содержанием:

        @extends('layouts.master')

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
                        <p>
                          {{ str_limit($post->content) }}
                        </p>
                      </li>
                    @endforeach
                  </ul>
              </div>
                  {!! $posts->render() !!}
              <hr>
         
        @stop



Последним шагом станет создание представления конкретного поста. Создайте файл resources/views/blog/post.blade.php

        <html>
        <head>
          <title>{{ $post->title }}</title>
          <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"
                rel="stylesheet">
        </head>
        <body>
          <div class="container">
            <h1>{{ $post->title }}</h1>
            <h5>{{ $post->published_at->format('M jS Y g:ia') }}</h5>
            <hr>
            {!! nl2br(e($post->content)) !!}
            <hr>
            <button class="btn btn-primary" onclick="history.go(-1)">
              « Back
            </button>
          </div>
        </body>
        </html>

