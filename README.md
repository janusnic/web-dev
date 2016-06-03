# web-dev unit_19

Изменение структуры таблиц
==========================
    php artisan make:migration add_slug_to_tags --table=tags


    class AddSlugToTags extends Migration
    {
        public function up()
        {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn('tag');
                $table->string('name');
                $table->string('slug')->unique()->after('name');
            });
        }

        public function down()
        {
            Schema::table('tags', function (Blueprint $table) {
               $table->dropColumn('name'); //
               $table->dropColumn('slug'); //
            });
        }



    php artisan make:migration add_category_to_articles --table=articles

    Created Migration: 2016_06_03_072443_add_category_to_articles


    class AddCategoryToArticles extends Migration
    {
        public function up()
        {
            Schema::table('articles', function (Blueprint $table) {
                
                $table->integer('category_id')->unsigned()->after('content');
                $table->softDeletes();
                
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('category_id'); //
            });
        }


    php artisan make:migration create_articl_tag_tabe

    Created Migration: 2016_06_03_074352_create_articl_tag_tabe


        public function up()
        {
           Schema::create('article_tag', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('article_id')->unsigned()->index();
                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

                $table->integer('tag_id')->unsigned()->index();
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

                $table->timestamps();

            });
        }

        public function down()
        {
            Schema::drop('article_tag');
        }

    php artisan migrate

    Migrated: 2016_06_03_074352_create_articl_tag_tabe


ИСПОЛЬЗОВАНИЕ ВАЛИДАЦИИ
=======================
Laravel поставляется с простой, удобной системой валидации (проверки входных данных на соответствие правилам) и получения сообщений об ошибках - классом Validation.

ВАЛИДАЦИЯ В КОНТРОЛЛЕРАХ
========================
Писать полный код валидации каждый раз, когда нужно провалидировать данные - это неудобно. Поэтому Laravel предоставляет несколько решений для упрощения этой процедуры.

Базовый контроллер App\Http\Controllers\Controller включает в себя трейт ValidatesRequests, который уже содержит методы для валидации:

      <?php

      namespace App\Http\Controllers;

      use Illuminate\Foundation\Bus\DispatchesJobs;
      use Illuminate\Routing\Controller as BaseController;
      use Illuminate\Foundation\Validation\ValidatesRequests;
      use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
      use Illuminate\Foundation\Auth\Access\AuthorizesResources;

      class Controller extends BaseController
      {
          use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
      }


Если валидация проходит, код продолжает выполняться. Если нет - бросается исключение Illuminate\Contracts\Validation\ValidationException. Если вы не поймаете это исключение, его поймает фреймворк, заполнит flash-переменные сообщениями об ошибках валидации и средиректит пользователя на предыдущую страницу с формой - сам !


ВАЛИДАЦИЯ ЗАПРОСОВ
-------------------
Для реализации более сложных сценариев валидации вам могут быть удобны так называемые Form Requests. Это специальные классы HTTP-запроса, содержащие в себе логику валидации. Они обрабатывают запрос до того, как он поступит в контроллер.

Чтобы создать класс запроса, используйте artisan-команду make:request:

   php artisan make:request TagRequest


Класс будет создан в папке app/Http/Requests. 


      <?php namespace App\Http\Requests;

      class TagRequest extends Request
      {
          public function authorize()
          {
              return true;
          }

Добавьте необходимые правила валидации в его метод rules:

          public function rules()
          {
              return [
                  'name' => 'required|min:2',
              ];
          }
      }


Для того, чтобы фреймворк перехватил запрос перед контроллером, добавьте этот класс в аргументы необходимого метода контроллера:

      use App\Http\Requests\TagRequest;

      public function store(TagRequest $request)
      {
        Tag::create($request->all());
        return redirect('admin/tags');
      }

При грамотном использовании валидации запросов вы можете быть уверены, что в ваших контроллерах всегда находятся только отвалидированные входные данные !

В случае неудачной валидации фреймворк заполняет флэш-переменные ошибками валидации и возврашает редирект на предыдущую страницу.


    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $tag->update($request->all());

        return redirect('admin/tags');
    }




РАБОТА С СООБЩЕНИЯМИ
====================

  composer require laracasts/flash
  Using version ^2.0 for laracasts/flash
  ./composer.json has been updated
  Loading composer repositories with package information
  Updating dependencies (including require-dev)
    - Installing laracasts/flash (2.0.0)
      Downloading: 100%         

app.php
------- 
    Collective\Html\HtmlServiceProvider::class,
    Laracasts\Flash\FlashServiceProvider::class,
    

    'Flash' => Laracasts\Flash\Flash::class,

publish
-------
    php artisan vendor:publish

    Copied Directory [/vendor/laracasts/flash/src/views] To [/resources/views/vendor/flash]

flash::message
--------------
    <body>
      @include('flash::message')
      @yield('body')
      <script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
        @yield('scripts')
        @yield('footer')
    </body>
    </html>


controller
----------
      public function store(TagRequest $request)
        {
            Tag::create($request->all());

            flash()->success('Your tag has been created!');

            return redirect('admin/tags');
        }

    
      public function update(TagRequest $request, $id)
      {
          $tag = Tag::findOrFail($id);

          $tag->update($request->all());

          flash()->success('Your tag has been updateed!');

          return redirect('admin/tags');
      }

ОПРЕДЕЛЕНИЕ ОТНОШЕНИЙ
=====================
Отношения Eloquent определяются при помощи методов в модели Eloquent. Т.к. связи (как и сами модели) по сути являются конструкторами запросов, определение связей в виде методов позволяет использовать мощный механизм сцепления методов в цепочку и построения запроса. 

Например:

  $user->posts()->where('active', 1)->get();


Один к одному
-------------
Связь вида «один к одному» является очень простой. К примеру, модель User может иметь один Phone. Для определения такой связи мы заведем метод phone в модели User. Метод phone должен вернуть результат метода hasOne базового класса Eloquent модели:

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        /**
         * Получить телефон, связанный с пользователем.
         */
        public function phone()
        {
            return $this->hasOne('App\Phone');
        }
    }

Первый аргумент, передаваемый в метод hasOne - имя модели связи. Теперь, когда связь определена можно получить связанную запись при помощи динамического атрибута. Динамические атрибуты позволяют обращаться к отношениям так, будто они являются атрибутами самой модели:

    $phone = User::find(1)->phone;

Eloquent по умолчанию предугадывает имя внешнего ключа по имени модели. В данном случае подразумевается что модель Phone имеет внешний ключ user_id. Если хотите переопределить это правило, имя ключа можно передать вторым параметром в методhasOne:

    return $this->hasOne('App\Phone', 'foreign_key');

Также Eloquent предполагает, что значение внешнего ключа будет равно id (или атрибуту, указанному в $primaryKey) родительской модели. Другими словами, Eloquent будет искать пользователя с id равным столбцу user_id в модели Phone. Если хотите использовать другой атрибут (не id) в качестве идентификатора связи, можно передать третий параметр в метод hasOne указав свой ключ:

    return $this->hasOne('App\Phone', 'foreign_key', 'local_key');

Определение обратного отношения
-------------------------------
Итак мы можем получить модель телефона (Phone) из модели пользователя (User). Давайте теперь определим связь на стороне телефона, что позволит нам иметь доступ к модели пользователя (User), владельцу телефона. Мы можем определить обратное отношение к hasOne при помощи метода belongsTo:

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Phone extends Model
    {
        /**
         * Получить пользователя - владельца телефона
         */
        public function user()
        {
            return $this->belongsTo('App\User');
        }
    }

Eloquent попытается сопоставить user_id модели Phone атрибуту id модели User. Eloquent определяет дефолтное имя внешнего ключа по имени метода, который задает отношение, добавив к нему суффикс _id. Однако, если имя внешнего ключа в модели Phone не user_id, можно передать собственное имя ключа вторым параметром метода belongsTo:

    /**
     * Получить пользователя - владельца телефон
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }

Если родительская модель не использует id в качестве первичного ключа, или вы хотите связать дочернею модель с родительской по другой колонке, можно передать третьим параметром в метод belongsTo имя ключа для связи:

    /**
     * Получить пользователя - владельца телефон
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key', 'other_key');
    }

Один ко многим
--------------
Тип связи "один ко многим" используется для определения таких отношений, в которых одна модель может иметь неограниченное количество других моделей. Например статья в блоге может иметь неограниченное количество комментариев. Как и любые другие отношения Eloquent, связь "один ко многим" определяется при помощи метода модели Eloquent:

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Post extends Model
    {
        /**
         * Получить комментарии к записи.
         */
        public function comments()
        {
            return $this->hasMany('App\Comment');
        }
    }

Eloquent будет автоматически определять внешний ключ в модели Comment. Обычно при этом берется имя родительской модели в "змеином_регистре" ("snake case") и добавляется суффикс _id. Например, в нашем случае в модели Comment Eloquent будет искать поле post_id.

Когда отношение описано, мы можем получить коллекцию комментариев через атрибут comments. динамические атрибуты позволяют обращаться к отношениям так, будто они являются атрибутами самой модели:

    $comments = App\Post::find(1)->comments;

    foreach ($comments as $comment) {
        //
    }
И конечно, т.к. наши отношения являются по сути построителями запроса, вы можете строить цепь вызовов добавляя необходимые условия, после вызова метода comments:

    $comments = App\Post::find(1)->comments()->where('title', 'foo')->first();

Как и в случае с методом hasOne, можно указать собственные имена ключей в таблицах, передавая их дополнительными параметрами в hasMany:

    return $this->hasMany('App\Comment', 'foreign_key');

    return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
Определение обратного отношения
-------------------------------
Теперь, когда у нас есть метод для получения всех комментариев записи блога, давайте определим отношение для получения родительской записи из модели комментария. Для описания обратной связи hasMany служит метод belongsTo:

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Comment extends Model
    {
        /**
         * Получить родительскую запись комментария.
         */
        public function post()
        {
            return $this->belongsTo('App\Post');
        }
    }
Теперь, когда отношение описано, мы можем получить родительский объект Post для Comment через "динамический атрибут" post:

    $comment = App\Comment::find(1);

    echo $comment->post->title;

Eloquent будет пытаться найти объект Post с id равным post_id модели Comment. Eloquent по умолчанию определяет имя внешнего ключа по имени метода, задающего отношение с суффиксом _id. Однако, если в модели Comment внешний ключ не равен post_id, можно передать свое имя в метод belongsTo:

    /**
     * Получить родительскую запись комментария.
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'foreign_key');
    }
Если родительская модель не использует id в качестве первичного ключа, или вы хотите связать дочернею модель с родительской по другой колонке, можно передать третьим параметром в метод belongsTo имя ключа для связи:

    /**
     * Получить родительскую запись комментария.
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'foreign_key', 'other_key');
    }

Многие ко многим
----------------
Отношения типа «многие ко многим» - более сложные, чем остальные виды отношений. Примером может служить пользователь, имеющий много ролей, где роли также относятся ко многим пользователям. Например, один пользователь может иметь роль «Admin». Для этой связи нужны три таблицы : users, roles и role_user. Название таблицы role_user происходит от упорядоченного по алфавиту имён связанных моделей и она должна иметь поля user_id и role_id.

Вы можете определить отношение «многие ко многим» через метод belongsToMany. Давайте для примера определим связь roles в модели User:

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        /**
         * Роли, к которым принадлежит пользователь.
         */
        public function roles()
        {
            return $this->belongsToMany('App\Role');
        }
    }
Когда отношение описано, мы можем получить роли пользователя через динамический атрибут roles:

    $user = App\User::find(1);

    foreach ($user->roles as $role) {
        //
    }
И конечно же, как и в случае с любым другим типом отношений, можно выстраивать цепочки вызовов таким образом:

    $roles = App\User::find(1)->roles()->orderBy('name')->get();

имя связующей таблицы по умолчанию строится по именам моделей в алфавитном порядке. Однако его можно переопределить. Делается это при помощи второго параметра метода belongsToMany:

    return $this->belongsToMany('App\Role', 'role_user');
Помимо собственного названия связующей таблицы​, можно также переопределить имена колонок-ключей при помощи дополнительных параметров метода belongsToMany. Третий аргумент — колонка, ссылающаяся на модель, в которой вы описываете отношение, четвертый — колонка, ссылающаяся на модель с которой строится связь:

    return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');

Определение обратного отношения
-------------------------------
Для определения обратного отношения «многие ко многим» необходимо просто добавить такой же вызов метода belongsToMany но, со стороны другой модели. В продолжение нашего примера с ролями пользователя, определим метод users в модели Role:

    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Role extends Model
    {
        /**
         * Пользователи, которые принадлежат данной роли.
         */
        public function users()
        {
            return $this->belongsToMany('App\User');
        }
    }

отношение описывается точно также, как обратное, со стороны пользователя, с той лишь разницей, что ссылаемся мы теперь на модель App\User. Т.к. вызов метода belongsToMany является таким же точно, как и выше, все опции по заданию собственных имен таблиц и колонок выглядят идентично.

Работа с данными связующих таблиц
---------------------------------
Как вы уже знаете отношения типа «многие ко многим» требует дополнительную связующую таблицу. Eloquent позволяет работать с этой таблицей, что бывает весьма полезно. Предположим, что наш объект User имеет много ролей (объектов Role). После того, как мы получили объект отношения, мы можем получить доступ к связующей таблице при помощи атрибута pivot у каждого из объектов:

    $user = App\User::find(1);

    foreach ($user->roles as $role) {
        echo $role->pivot->created_at;
    }

у каждой из моделей Role есть автоматически созданный атрибут pivot. Этот атрибут представляет из себя модель с данными связующей таблицы, и может использоваться как обычный объект Eloquent.

По умолчанию, в объекте pivot будут присутствовать только ключи моделей. Если ваша связующая таблица содержит дополнительные атрибуты, их необходимо перечислить при описании отношения:

    return $this->belongsToMany('App\Role')->withPivot('column1', 'column2');

Если вы хотите, чтобы связующая таблица автоматически поддерживала таймстемпы created_at и updated_at, используйте метод withTimestamps при описании отношения:

    return $this->belongsToMany('App\Role')->withTimestamps();

