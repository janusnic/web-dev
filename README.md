# web-dev unit_09

/etc/apache2/sites-available/001-blog.conf
------------------------------------------
  
    sudo subl /etc/apache2/sites-available/001-blog.conf 


      <VirtualHost www.blog.com:80>
          # The ServerName directive sets the request scheme, hostname and port that
          # the server uses to identify itself. This is used when creating
          # redirection URLs. In the context of virtual hosts, the ServerName
          # specifies what hostname must appear in the request's Host: header to
          # match this virtual host. For the default virtual host (this file) this
          # value is not decisive as it is used as a last resort host regardless.
          # However, you must set it for any further virtual host explicitly.

          ServerName www.blog.com

          ServerAdmin webmaster@localhost
          DocumentRoot /home/janus/www/blog/public

          Options Indexes FollowSymLinks

          <Directory '/home/janus/www/blog/public/'>
              Options Indexes FollowSymLinks
              AllowOverride All
              Require all granted
          </Directory>
         

          Alias /admin/ "/home/janus/www/blog/admin/"
          <Directory '/home/janus/www/blog/admin/'>
              Order allow,deny
              Options Indexes FollowSymLinks
              Require all granted
              Allow from all
          </Directory>
       

          # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
          # error, crit, alert, emerg.
          # It is also possible to configure the loglevel for particular
          # modules, e.g.
          #LogLevel info ssl:warn

          ErrorLog ${APACHE_LOG_DIR}/blog-error.log
          CustomLog ${APACHE_LOG_DIR}/blog-access.log combined

          # For most configuration files from conf-available/, which are
          # enabled or disabled at a global level, it is possible to
          # include a line for only one particular virtual host. For example the
          # following line enables the CGI configuration for this host only
          # after it has been globally disabled with "a2disconf".
          #Include conf-available/serve-cgi-bin.conf
      </VirtualHost>


apache2 reload
--------------
    $ sudo service apache2 reload

/admin/index.php
----------------

      <?php
      //include config
      require_once __DIR__.'/../bootstrap/app.php';
      require_once __DIR__.'/../resources/views/layouts/header.php';

class
=====
Каждое определение класса начинается с ключевого слова class, затем следует имя класса, и далее пара фигурных скобок, которые заключают в себе определение свойств и методов этого класса.

Именем класса может быть любое слово, при условии, что оно не входит в список зарезервированных слов PHP, начинается с буквы или символа подчеркивания и за которым следует любое количество букв, цифр или символов подчеркивания. Если задать эти правила в виде регулярного выражения, то получится следующее выражение: 

  ^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$.

Класс может содержать собственные константы, переменные (называемые свойствами) и функции (называемые методами).

определение класса class.user.php
---------------------------------
    <?php
    class SimpleClass
    {
        // объявление свойства
        public $var = 'значение по умолчанию';

        // объявление метода
        public function displayVar() {
            echo $this->var;
        }
    }
    ?>

Конструкторы и деструкторы 
==========================
Конструктор 
-----------
    void __construct ([ mixed $args = "" [, $... ]] )
PHP 5 позволяет объявлять методы-конструкторы. Классы, в которых объявлен метод-конструктор, будут вызывать этот метод при каждом создании нового объекта, так что это может оказаться полезным, например, для инициализации какого-либо состояния объекта перед его использованием.

Конструкторы в классах-родителях не вызываются автоматически, если класс-потомок определяет собственный конструктор. Чтобы вызвать конструктор, объявленный в родительском классе, следует обратиться к методу parent::__construct() внутри конструктора класса-потомка. Если в классе-потомке не определен конструктор, то он может наследоваться от родительского класса как обычный метод (если он не определен как приватный).

Использование унифицированных конструкторов
--------------------------------------------

В целях обратной совместимости, если PHP 5 не может обнаружить объявленный метод __construct() и этот метод не наследуется от родительских классов, то вызов конструктора произойдет по устаревшей схеме, через обращение к методу, имя которого соответствует имени класса. Может возникнуть только одна проблема совместимости старого кода, если в нём присутствуют классы с методами __construct(), использующиеся для других целей.

В отличие от других методов, PHP не будет генерировать ошибку уровня E_STRICT, если __construct() будет перекрыт методом с другими параметрами, отличными от тех, которые находятся в родительском __construct().

Начиная с версии PHP 5.3.3, методы с именами, совпадающими с последним элементом имени класса, находящимся в пространстве имен, больше не будут считаться конструкторами. Это изменение не влияет на классы, не находящиеся в пространстве имен.

Конструкторы в классах, находящихся в пространстве имен
-------------------------------------------------------
    <?php
    namespace Foo;
    class Bar {
        public function Bar() {
            // конструктор в версиях PHP 5.3.0-5.3.2
            // обычный метод, начиная с версии PHP 5.3.3
        }
    }
    ?>

Деструкторы 
-----------

PHP 5 предоставляет концепцию деструкторов, сходную с теми, что применяются в других ОО языках, таких, как C++. Деструктор будет вызван при освобождении всех ссылок на определенный объект или при завершении скрипта (порядок выполнения деструкторов не гарантируется).

Пример использования деструктора

    <?php
    class MyDestructableClass {
       function __construct() {
           print "Конструктор\n";
           $this->name = "MyDestructableClass";
       }

       function __destruct() {
           print "Уничтожается " . $this->name . "\n";
       }
    }

    $obj = new MyDestructableClass();
    ?>
Как и в случае с конструкторами, деструкторы, объявленные в родительском классе, не будут вызваны автоматически. Для вызова деструктора, объявленном в классе-родителе, следует обратиться к методу parent::__destruct() в теле деструктора-потомка. Также класс-потомок может унаследовать деструктор из родительского класса, если он не определен в нем.

Деструктор будет вызван даже в том случае, если скрипт был остановлен с помощью функции exit(). Вызов exit() в деструкторе предотвратит запуск всех последующих функций завершения.

Деструкторы, вызываемые при завершении скрипта, вызываются после отправки HTTP-заголовков. Рабочая директория во время фазы завершения скрипта может отличаться в некоторых SAPI (например, в Apache).

Попытка бросить исключение в деструкторе (вызванного во время завершения скрипта) влечет за собой фатальную ошибку.

Область видимости
================= 
Область видимости свойства или метода может быть определена путем использования следующих ключевых слов в объявлении: public, protected или private. Доступ к свойствам и методам класса, объявленным как public (общедоступный), разрешен отовсюду. Модификатор protected (защищенный) разрешает доступ наследуемым и родительским классам. Модификатор private (закрытый) ограничивает область видимости так, что только класс, где объявлен сам элемент, имеет к нему доступ.

Область видимости свойства 
--------------------------
Свойства класса должны быть определены через модификаторы public, private, или protected. Если же свойство определено с помощью var, то оно будет доступно как public свойство.

Объявление свойства класса
--------------------------
      <?php
      /**
       * Определение MyClass
       */
      class MyClass
      {
          public $public = 'Общий';
          protected $protected = 'Защищенный';
          private $private = 'Закрытый';

          function printHello()
          {
              echo $this->public;
              echo $this->protected;
              echo $this->private;
          }
      }

      $obj = new MyClass();
      echo $obj->public; // Работает
      echo $obj->protected; // Неисправимая ошибка
      echo $obj->private; // Неисправимая ошибка
      $obj->printHello(); // Выводит Общий, Защищенный и Закрытый


      /**
       * Определение MyClass2
       */
      class MyClass2 extends MyClass
      {
          // Мы можем переопределить public и protected методы, но не private
          protected $protected = 'Защищенный2';

          function printHello()
          {
              echo $this->public;
              echo $this->protected;
              echo $this->private;
          }
      }

      $obj2 = new MyClass2();
      echo $obj2->public; // Работает
      echo $obj2->protected; // Неисправимая ошибка
      echo $obj2->private; // Неопределен
      $obj2->printHello(); // Выводит Общий, Защищенный2 и Неопределен

      ?>

Метод объявления переменной через ключевое слово var, принятый в PHP 4, до сих пор поддерживается в целях совместимости (как синоним ключевого слова public). В версиях PHP 5 ниже 5.1.3 такое использование выводит предупреждение E_STRICT.

Область видимости метода 
------------------------
Методы класса должны быть определены через модификаторы public, private, или protected. Методы, где определение модификатора отсутствует, определяются как public.

Объявление метода
-----------------
    <?php
    /**
     * Определение MyClass
     */
    class MyClass
    {
        // Объявление общедоступного конструктора
        public function __construct() { }

        // Объявление общедоступного метода
        public function MyPublic() { }

        // Объявление защищенного метода
        protected function MyProtected() { }

        // Объявление закрытого метода
        private function MyPrivate() { }

        // Это общедоступный метод
        function Foo()
        {
            $this->MyPublic();
            $this->MyProtected();
            $this->MyPrivate();
        }
    }

    $myclass = new MyClass;
    $myclass->MyPublic(); // Работает
    $myclass->MyProtected(); // Неисправимая ошибка
    $myclass->MyPrivate(); // Неисправимая ошибка
    $myclass->Foo(); // Работает общий, защищенный и закрытый


    /**
     * Определение MyClass2
     */
    class MyClass2 extends MyClass
    {
        // Это общедоступный метод
        function Foo2()
        {
            $this->MyPublic();
            $this->MyProtected();
            $this->MyPrivate(); // Неисправимая ошибка
        }
    }

    $myclass2 = new MyClass2;
    $myclass2->MyPublic(); // Работает
    $myclass2->Foo2(); // Работает общий и защищенный, закрытый не работает

    class Bar 
    {
        public function test() {
            $this->testPrivate();
            $this->testPublic();
        }

        public function testPublic() {
            echo "Bar::testPublic\n";
        }
        
        private function testPrivate() {
            echo "Bar::testPrivate\n";
        }
    }

    class Foo extends Bar 
    {
        public function testPublic() {
            echo "Foo::testPublic\n";
        }
        
        private function testPrivate() {
            echo "Foo::testPrivate\n";
        }
    }

    $myFoo = new foo();
    $myFoo->test(); // Bar::testPrivate 
                    // Foo::testPublic
    ?>
Видимость из других объектов 
----------------------------
Объекты одного типа имеют доступ к элементам с модификаторами private и protected друг друга, даже если не являются одним и тем же экземпляром. Это объясняется тем, что реализация видимости элементов известна внутри этих объектов.

Доступ к элементам с модификатором private из объектов одного типа

    <?php
    class Test
    {
        private $foo;

        public function __construct($foo)
        {
            $this->foo = $foo;
        }

        private function bar()
        {
            echo 'Доступ к закрытому методу.';
        }

        public function baz(Test $other)
        {
            // Мы можем изменить закрытое свойство:
            $other->foo = 'hello';
            var_dump($other->foo);

            // Мы также можем вызвать закрытый метод:
            $other->bar();
        }
    }

    $test = new Test('test');

    $test->baz(new Test('other'));
    ?>
Результат выполнения данного примера:

      string(5) "hello"
      Доступ к закрытому методу.

Псевдо-переменная $this доступна в том случае, если метод был вызван в контексте объекта. $this является ссылкой на вызываемый объект. Обычно это тот объект, которому принадлежит вызванный метод, но может быть и другой объект, если метод был вызван статически из контекста другого объекта.

Переменная $this
-----------------
    <?php
    class A
    {
        function foo()
        {
            if (isset($this)) {
                echo '$this определена (';
                echo get_class($this);
                echo ")\n";
            } else {
                echo "\$this не определена.\n";
            }
        }
    }

    class B
    {
        function bar()
        {
            // Замечание: следующая строка вызовет предупреждение, если включен параметр E_STRICT.
            A::foo();
        }
    }

    $a = new A();
    $a->foo();

    // Замечание: следующая строка вызовет предупреждение, если включен параметр E_STRICT.
    A::foo();
    $b = new B();
    $b->bar();

    // Замечание: следующая строка вызовет предупреждение, если включен параметр E_STRICT.
    B::bar();
    ?>
Результат выполнения данного примера:

    $this определена (A)
    $this не определена.
    $this определена (B)
    $this не определена.

$_SESSION — Переменные сессии
-----------------------------
Ассоциативный массив, содержащий переменные сессии, которые доступны для текущего скрипта. Смотрите документацию по функциям сессии для получения дополнительной информации.

$HTTP_SESSION_VARS первоначально содержит ту же информацию, но она не является суперглобальной переменной.

Это 'суперглобальная' или автоматическая глобальная переменная. Это просто означает что она доступна во всех контекстах скрипта. Нет необходимости выполнять global $variable; для доступа к ней внутри метода или функции.

Исключения 
===========

Наследование исключений
-----------------------
Исключение можно сгенерировать (как говорят, "выбросить") при помощи оператора throw, и можно перехватить (или, как говорят, "поймать") оператором catch. Код генерирующий исключение, должен быть окружен блоком try, для того чтобы можно было перехватить исключение. Каждый блок try должен иметь как минимум один соответствующий ему блок catch или finally.

Генерируемый объект должен принадлежать классу Exception или наследоваться от Exception. Попытка сгенерировать исключение другого класса приведет к неисправимой ошибке.

catch
------
Можно использовать несколько блоков catch, перехватывающих различные классы исключений. Нормальное выполнение (когда не генерируются исключения в блоках try или когда класс сгенерированного исключения не совпадает с классами, объявленными в соответствующих блоках catch) будет продолжено за последним блоком catch. Исключения так же могут быть сгенерированы (или вызваны еще раз) оператором throw внутри блока catch.

При генерации исключения код следующий после описываемого выражения исполнен не будет, а PHP предпримет попытку найти первый блок catch, перехватывающий исключение данного класса. Если исключение не будет перехвачено, PHP выдаст сообщение об ошибке: "Uncaught Exception ..." (Неперехваченное исключение), если не был определен обработчик ошибок при помощи функции set_exception_handler().

finally
-------
В PHP 5.5 и более поздних версиях также можно использовать блок finally после или вместо блока catch. Код в блоке finally всегда будет выполняться после кода в блоках try и catch, вне зависимости было ли брошено исключение или нет, перед тем как продолжится нормальное выполнение кода. whether an exception has been thrown, and before normal execution resumes.

Внутренние функции PHP в основном используют сообщения об ошибках, и только новые объектно-ориентированные расширения используют исключения. Однако, ошибки можно легко преобразовать в исключения с помощью класса ErrorException.

Выброс исключений

    <?php
    function inverse($x) {
        if (!$x) {
            throw new Exception('Деление на ноль.');
        }
        return 1/$x;
    }

    try {
        echo inverse(5) . "\n";
        echo inverse(0) . "\n";
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
    }

    // Продолжение выполнения
    echo "Hello World\n";
    ?>

Результат выполнения данного примера:

    0.2
    Выброшено исключение: Деление на ноль.
    Hello World

Вложенные исключения

    <?php
    function inverse($x) {
        if (!$x) {
            throw new Exception('Деление на ноль.');
        }
        return 1/$x;
    }

    try {
        echo inverse(5) . "\n";
    } catch (Exception $e) {
        echo 'Поймано исключение: ',  $e->getMessage(), "\n";
    } finally {
        echo "Первое finally.\n";
    }

    try {
        echo inverse(0) . "\n";
    } catch (Exception $e) {
        echo 'Поймано исключение: ',  $e->getMessage(), "\n";
    } finally {
        echo "Второе finally.\n";
    }

    // Продолжение нормального выполнения
    echo "Hello World\n";
    ?>
Результат выполнения данного примера:

      0.2
      Первое finally.
      Поймано исключение: Деление на ноль.
      Второе finally.
      Hello World

Вложенные исключения

    <?php

    class MyException extends Exception { }

    class Test {
        public function testing() {
            try {
                try {
                    throw new MyException('foo!');
                } catch (MyException $e) {
                    // повторный выброс исключения
                    throw $e;
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
        }
    }

    $foo = new Test;
    $foo->testing();

    ?>
Результат выполнения данного примера:

    string(4) "foo!"

Класс Пользователей class user
===============================

Этот класс будет определять каждого пользователя.

Конструктор
-----------
В этом классе мы будем использовать конструктор - это функция, которая автоматически вызывается при создании очередной копии класса. 

dump blog_members
------------------

    CREATE TABLE IF NOT EXISTS `blog_members` (
      `memberID` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `username` varchar(255) DEFAULT NULL,
      `password` varchar(255) DEFAULT NULL,
      `email` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`memberID`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


classes/class.user.php
----------------------
    <?php

    class User {

        private $db;
        
        function __construct($db){
            $this->_db = $db;
        }

        public function is_logged_in(){
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                return true;
            }       
        }

        private function get_user_hash($username){  

            try {

                $stmt = $this->_db->prepare('SELECT password FROM blog_members WHERE username = :username');
                $stmt->execute(array('username' => $username));
                
                $row = $stmt->fetch();
                return $row['password'];

            } catch(PDOException $e) {
                echo '<p class="error">'.$e->getMessage().'</p>';
            }
        }

        
        public function login($username,$password){ 

            $hashed = $this->get_user_hash($username);
            
                $_SESSION['loggedin'] = true;
                return true;
        }
        
            
        public function logout(){
            session_destroy();
        }

    }

Автоматическая загрузка классов 
===============================

Большинство разработчиков объектно-ориентированных приложений используют такое соглашение именования файлов, в котором каждый класс хранится в отдельно созданном для него файле. Одной из наиболее при этом досаждающих деталей является необходимость писать в начале каждого скрипта длинный список подгружаемых файлов.

В PHP 5 это делать не обязательно. Можно определить функцию __autoload(), которая будет автоматически вызвана при использовании ранее неопределенного класса или интерфейса. Вызов этой функции - последний шанс для интерпретатора загрузить класс прежде, чем он закончит выполнение скрипта с ошибкой.

До версии 5.3.0, исключения, вызванные в функции __autoload, не могли быть перехвачены в блоке catch и завершались с неисправимой ошибкой. Начиная с версии 5.3.0 эти исключения можно перехватывать в ближайшем блоке catch. Если бросить определенное пользователем исключение, то класс этого исключения должен быть доступен. Функция __autoload также может использоваться рекурсивно для автоматической загрузки пользовательских классов исключений.

Если имя класса используется, например, для вызова через call_user_func(), то оно может содержать некоторые опасные символы, такие как ../. Поэтому, рекомендуется не использовать данные от пользователей в таких функциях или же, как минимум, проверять значения в __autoload().

Автоматическая загрузка недоступна в случае использования PHP в командной строке в интерактивном режиме.

Пример автоматической загрузки
-------------------------------
В этом примере функция пытается загрузить классы MyClass1 и MyClass2 из файлов MyClass1.php и MyClass2.php соответственно.

    <?php
    function __autoload($class_name) {
        include $class_name . '.php';
    }

    $obj  = new MyClass1();
    $obj2 = new MyClass2(); 
    ?>

В этом примере представлена попытка загрузки интерфейса ITest.

      <?php

      function __autoload($name) {
          var_dump($name);
      }

      class Foo implements ITest {
      }

      /*
      string(5) "ITest"

      Fatal error: Interface 'ITest' not found in ...
      */
      ?>


В данном примере вызывается исключение и отлавливается блоком try/catch.

      <?php
      function __autoload($name) {
          echo "Want to load $name.\n";
          throw new Exception("Unable to load $name.");
      }

      try {
          $obj = new NonLoadableClass();
      } catch (Exception $e) {
          echo $e->getMessage(), "\n";
      }
      ?>
Результат выполнения данного примера:

      Want to load NonLoadableClass.
      Unable to load NonLoadableClass.

Автоматическая загрузка с перехватом исключения в версиях 5.3.0+ - Класс пользовательского исключения не подгружен

      <?php
      function __autoload($name) {
          echo "Want to load $name.\n";
          throw new MissingException("Unable to load $name.");
      }

      try {
          $obj = new NonLoadableClass();
      } catch (Exception $e) {
          echo $e->getMessage(), "\n";
      }
      ?>

Результат выполнения данного примера:

    Want to load NonLoadableClass.
    Want to load MissingException.

    Fatal error: Class 'MissingException' not found in testMissingException.php on line 4

spl_autoload_register() предоставляет более гибкую альтернативу для автоматической загрузки классов. По этой причине использовать __autoload() не рекомендуется, а сама функция в будущем может перестать поддерживаться или быть удалена.

bootstrap/app.php
--------------------

      <?php
      ob_start();
      session_start();

      //set timezone
      date_default_timezone_set('Europe/Kiev');

      //database credentials

      define('DBHOST','localhost');
      define('DBUSER','dev');
      define('DBPASS','ghbdtn');
      define('DBNAME','webdev');

      $db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //load classes as needed
      function __autoload($class) {
         
         $class = strtolower($class);

         //if call from within assets adjust the path
         $classpath = 'classes/class.'.$class . '.php';
         if ( file_exists($classpath)) {
            require_once $classpath;
         }  
         
         //if call from within admin adjust the path
         $classpath = '../classes/class.'.$class . '.php';
         if ( file_exists($classpath)) {
            require_once $classpath;
         }
         
         //if call from within admin adjust the path
         $classpath = '../../classes/class.'.$class . '.php';
         if ( file_exists($classpath)) {
            require_once $classpath;
         }     
          
      }

      $user = new User($db); 
      ?>

file_exists — Проверяет наличие указанного файла или каталога
-------------------------------------------------------------
    bool file_exists ( string $filename )
Проверяет наличие указанного файла или каталога.

- filename
Путь к файлу или каталогу.

На платформах Windows, для проверки наличия файлов на сетевых ресурсах, используйте имена, подобные //computername/share/filename или \\computername\share\filename.

Возвращает TRUE, если файл или каталог, указанный параметром filename, существует, иначе возвращает FALSE.

Данная функция возвращает FALSE для символических ссылок, указывающих на несуществующие файлы.

Если файлы недоступны из-за ограничений, налагаемых безопасным режимом, то данная функция вернет FALSE. Однако, эти файлы все еще могут быть подключены, если они располагаются в каталоге safe_mode_include_dir.

Проверка происходит с помощью реальных UID/GID, а не эффективных идентификаторов.
Так как тип integer в PHP является целым числом со знаком и многие платформы используют 32-х битные целые числа, то некоторые функции файловых систем могут возвращать неожиданные результаты для файлов размером больше 2ГБ.


new
====
Для создания экземпляра класса используется директива new. Новый объект всегда будет создан, за исключением случаев, когда он содержит конструктор, в котором определен вызов исключения в случае ошибки. Рекомендуется определять классы до создания их экземпляров (в некоторых случаях это обязательно).

Если с директивой new используется строка (string), содержащая имя класса, то будет создан новый экземпляр этого класса. Если имя находится в пространстве имен, то оно должно быть задано полностью.

Создание экземпляра класса
--------------------------

    <?php
    $instance = new SimpleClass();

    // Это же можно сделать с помощью переменной:
    $className = 'Foo';
    $instance = new $className(); // Foo()
    ?>

В контексте класса можно создать новый объект через new self и new parent.

Когда происходит присвоение уже существующего экземпляра класса новой переменной, то эта переменная будет указывать на этот же экземпляр класса. Тоже самое происходит и при передаче экземпляра класса в функцию. Копию уже созданного объекта можно создать через ее клонирование.

Присваивание объекта
---------------------

    <?php

    $instance = new SimpleClass();

    $assigned   =  $instance;
    $reference  =& $instance;

    $instance->var = '$assigned будет иметь это значение';

    $instance = null; // $instance и $reference становятся null

    var_dump($instance);
    var_dump($reference);
    var_dump($assigned);
    ?>

Результат выполнения данного примера:

    NULL
    NULL
    object(SimpleClass)#1 (1) {
       ["var"]=>
         string(30) "$assigned будет иметь это значение"
    }

В PHP 5.3.0 введены несколько новых методов создания экземпляров объекта:

Создание новых объектов
------------------------

    <?php
    class Test
    {
        static public function getNew()
        {
            return new static;
        }
    }

    class Child extends Test
    {}

    $obj1 = new Test();
    $obj2 = new $obj1;
    var_dump($obj1 !== $obj2);

    $obj3 = Test::getNew();
    var_dump($obj3 instanceof Test);

    $obj4 = Child::getNew();
    var_dump($obj4 instanceof Child);
    ?>
Результат выполнения данного примера:

    bool(true)
    bool(true)
    bool(true)


admin/index.php
----------------
      <?php
      //include config
      require_once __DIR__.'/../bootstrap/app.php';
      require_once __DIR__.'/../resources/views/layouts/header.php';

      //show message from add / edit page
      if(isset($_GET['delpost'])){ 

          $stmt = $db->prepare('DELETE FROM blog_posts WHERE id = :postID') ;
          $stmt->execute(array(':postID' => $_GET['delpost']));

          header('Location: index.php?action=deleted');
          exit;
      } 

      ?>

        <script language="JavaScript" type="text/javascript">
        function delpost(id, title)
        {
            if (confirm("Are you sure you want to delete '" + title + "'"))
            {
              window.location.href = 'index.php?delpost=' + id;
            }
        }
        </script>

        <main>
        
          <?php require_once __DIR__.'/../resources/views/layouts/nav_admin.php';?>    
          
          <section class="row border-top border-bottom">
             <article class="content col-8">
             <h3>Admin Posts</h3>

          <?php 
          //show message from add / edit page
          if(isset($_GET['action'])){ 
              echo '<h3>Post '.$_GET['action'].'.</h3>'; 
          } 
          ?>

          <table>
          <tr>
              <th>Title</th>
              <th>Date</th>
              <th>Action</th>
          </tr>
          <?php
              try {

                  $stmt = $db->query('SELECT id, title, created FROM blog_posts ORDER BY id DESC');
                  while($row = $stmt->fetch()){
                      
                      echo '<tr>';
                      echo '<td>'.$row['title'].'</td>';
                      echo '<td>'.date('jS M Y', strtotime($row['created'])).'</td>';
                      ?>

                      <td>
                          <a href="edit-post.php?id=<?php echo $row['id'];?>">Edit</a> | 
                          <a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['title'];?>')">Delete</a>
                      </td>
                      
                      <?php 
                      echo '</tr>';

                  }

              } catch(PDOException $e) {
                  echo $e->getMessage();
              }
          ?>
          </table>

          <p><a href='/admin/add-post.php'>Add Post</a></p>
          </article>

                  <aside id="sidebar" class="sidebar col-4">
                      <article>
                          <h2>3rd Content Area</h2>
                          <p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
                          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                          <p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
                      </article>
                      <article>
                          <h3>Sidebar Title</h3>
                          <p>
                            Vel tellus mi. Nulla tincidunt tincidunt nisi sit amet posuere. Praesent pellentesque mauris sed dictum ultricies. Pellentesque rhoncus nunc at consectetur fringilla. Curabitur sit amet tempus elit, sit amet auctor felis.</p>
                      </article>
              </aside>
          </section>
          </main>

      <?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>

admin/login.php
---------------

    <?php
    //include config
    require_once __DIR__.'/../bootstrap/app.php';
    require_once __DIR__.'/../resources/views/layouts/header.php';


    //check if already logged in
    if( $user->is_logged_in() ){ header('Location: index.php'); } 
    ?>


    <div id="login">

      <?php

      //process login form if submitted
      if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if($user->login($username,$password)){ 

          //logged in return to index page
          header('Location: index.php');
          exit;
        

        } else {
          $message = '<p class="error">Wrong username or password</p>';
        }

      }//end if submit

      if(isset($message)){ echo $message; }
      ?>

      <form action="" method="post">
      <p><label>Username</label><input type="text" name="username" value=""  /></p>
      <p><label>Password</label><input type="password" name="password" value=""  /></p>
      <p><label></label><input type="submit" name="submit" value="Login"  /></p>
      </form>

    </div>
    <?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>


admin/logout.php
-----------------

      <?php
      //include config
      require_once __DIR__.'/../bootstrap/app.php';

      //log user out
      $user->logout();
      header('Location: /index.php'); 

      ?>

Admin menu
-----------

      <header>
        <div class="row">
          <input type="checkbox" id="navbar-checkbox" class="navbar-checkbox">
            <nav class='menu col'>
                <ul>
                  <li><a href="/">Home</a></li>
                  <li><a href="./">Blog</a></li>
                  <li><a href="./users.php">Users</a></li>
                  <li><a href="/" target="_blank">View Website</a></li>
                  <li><a href='logout.php'>Logout</a></li>
                </ul>
                <label for="navbar-checkbox" class="navbar-handle"></label>
            </nav>
            </div>
      </header>
