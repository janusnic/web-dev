# web-dev unit_07

Конструкция однократных включений require_once
----------------------------------------------
В PHP сценариях инструкции require применяются довольно часто. Поэтому становится довольно сложно контролировать, как бы случайно не включить один и тот же файл несколько раз, что чаще всего приводит к ошибке, которую сложно обнаружить.

В PHP предусмотрено решение данной проблемы. Используя конструкцию однократного включения require_once можно быть уверенным, что один файл не будет включен дважды. Работает конструкция однократного включения require_once так же, как и require. Разница в ее работе лишь в том, что перед включением файла интерпретатор проверяет, включен ли указанный файл ранее или нет. Если да, то файл не будет включен вновь.

Конструкция однократного включения require_once позволяет включать удаленные файлы, если такая возможность включена в конфигурационном файле PHP.

Включения удаленных файлов
---------------------------
PHP позволяет работать с объектами URL, как с обычными файлами. Упаковщики, доступные по умолчанию, служат для работы с удаленными файлами с использованием протокола ftp или http.

Если "URL fopen-оболочки" включены в PHP (как в конфигурации по умолчанию), вы можете специфицировать файл, подключаемый с использованием URL (через HTTP), вместо локального пути. Если целевой сервер интерпретирует целевой файл как PHP-код, переменные могут передаваться в подключаемый файл с использованием URL-строки запроса, как в HTTP GET. Строго говоря, это не то же самое, что подключение файла и наследование им области видимости переменных родительского файла; ведь скрипт работает на удалённом сервере, а результат затем подключается в локальный скрипт.

Для того, чтобы удаленное включение файлов было доступно, необходимо в конфигурационном файле (php.ini) установить allow_url_fopen=1.


header.php
-----------

        <!DOCTYPE html>
        <html class=''>
        <head>

        <meta charset='UTF-8'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
         <!--[if lt IE 7]>     <html class="no-js ie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
         <!--[if IE 7]>        <html class="no-js ie lt-ie9 lt-ie8"> <![endif]-->
         <!--[if IE 8]>        <html class="no-js ie lt-ie9">
         <![endif]-->
         <!--[if IE 9]>        <html class="no-js ie lt-ie10"> <![endif]-->

        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <style>

        </style>

        </head><body>


footer.php
-----------
        <footer class="col-12">
            <h4>Footer</h4>
            <p>&copy; <a href="#" class="brand col">Site Name</a></p>
        </footer>

        </body>
        </html>

nav.php
--------

    <header>
      <div class="row">
        <input type="checkbox" id="navbar-checkbox" class="navbar-checkbox">
          <nav class='menu col'>
              <ul>

                <li><a href="/">Home</a></li>
                <li><a href="#">About</a>
                    <ul>
                      <li>History</li>
                      <li>Very long and tedious history</li>
                    </ul>
                </li>
                <li><a href="#">Feature</a></li>
                <li><a href="#">Portfolio</a></li>
                <li><a href="/test.php">Test</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
              <label for="navbar-checkbox" class="navbar-handle"></label>
          </nav>
          </div>
    </header>


index.php
----------
      <?php

      require_once __DIR__.'/../bootstrap/app.php';
      require_once __DIR__.'/../resources/views/layouts/header.php';
      require_once __DIR__.'/../resources/views/layouts/nav.php';
      ?>



          <section class="jumbotron">
            <article>
              <h1>Lorem ipsum dolor sit amet</h1>
              <p><a href="#"> <em> Hello World</em></a></p>
            </article>
          </section>


      <?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>


Подготовленные запросы и хранимые процедуры 
============================================
Большинство баз данных поддерживают концепцию подготовленных запросов. Это можно описать, как некий вид скомпилированного шаблона SQL запроса, который будет запускаться приложением и настраиваться с помощью входных параметров. У подготовленных запросов есть два главных преимущества:

Запрос необходимо однажды подготовить и затем его можно запускать столько раз, сколько нужно, причем как с теми же, так и с отличающимися параметрами. Когда запрос подготовлен, СУБД анализирует его, компилирует и оптимизирует план его выполнения. В случае сложных запросов этот процесс может занимать ощутимое время и заметно замедлить работу приложения, если потребуется много раз выполнять запрос с разными параметрами. При использовании подготовленного запроса СУБД анализирует/компилирует/оптимизирует запрос любой сложности только один раз, а приложение запускает на выполнение уже подготовленный шаблон. Таким образом подготовленные запросы потребляют меньше ресурсов и работают быстрее.
Параметры подготовленного запроса не требуется экранировать кавычками; драйвер это делает автоматически. Если в приложении используются исключительно подготовленные запросы, разработчик может быть уверен, что никаких SQL инъекций случиться не может (однако, если другие части текста запроса записаны с неэкранированными символами, SQL инъекции все же возможны; здесь речь идет именно о параметрах).
Подготовленные запросы также полезны тем, что PDO может эмулировать их, если драйвер базы данных не имеет подобного функционала. Это значит, что приложение может пользоваться одной и той же методикой доступа к данным независимо от возможностей СУБД.

Повторяющиеся вставки в базу с использованием подготовленных запросов
----------------------------------------------------------------------
В этом примере 2 раза выполняется INSERT запрос с разными значениями name и value, которые подставляются вместо соответствующих псевдопеременных:

      <?php
      $stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':value', $value);

      // вставим одну строку
      $name = 'one';
      $value = 1;
      $stmt->execute();

      // теперь другую строку с другими значениями
      $name = 'two';
      $value = 2;
      $stmt->execute();
      ?>
Повторяющиеся вставки в базу с использованием подготовленных запросов
---------------------------------------------------------------------
В этом примере 2 раза выполняется INSERT запрос с разными значениями name и valueкоторые подставляются вместо псевдопеременных ?.

      <?php
      $stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (?, ?)");
      $stmt->bindParam(1, $name);
      $stmt->bindParam(2, $value);

      // вставим одну строку
      $name = 'one';
      $value = 1;
      $stmt->execute();

      // теперь другую строку с другими значениями
      $name = 'two';
      $value = 2;
      $stmt->execute();
      ?>

Выборка данных с использованием подготовленных запросов
--------------------------------------------------------
В этом примере производится выборка из базы по ключу, который вводит пользователь через форму. Пользовательский ввод автоматически заключается в кавычки, поэтому нет риска SQL инъекции.

    <?php
    $stmt = $dbh->prepare("SELECT * FROM REGISTRY where name = ?");
    if ($stmt->execute(array($_GET['name']))) {
      while ($row = $stmt->fetch()) {
        print_r($row);
      }
    }
    ?>
Если СУБД поддерживает выходные параметры, приложение может пользоваться ими также как и входными. Выходные параметры обычно используют для получения данных из хранимых процедур. Пользоваться выходными параметрами несколько сложнее, так как разработчику необходимо знать максимальный размер извлекаемых значений еще на этапе задания этих параметров. Если извлекаемое значение окажется больше, чем предполагалось, будет вызвана ошибка.

Вызов хранимой процедуры с выходными параметрами
-------------------------------------------------
      <?php
      $stmt = $dbh->prepare("CALL sp_returns_string(?)");
      $stmt->bindParam(1, $return_value, PDO::PARAM_STR, 4000); 

      // вызов хранимой процедуры
      $stmt->execute();

      print "процедура вернула $return_value\n";
      ?>
Можно задать параметр одновременно входным и выходным; синтаксис при этом тот же, что и для выходных параметров. 

В следующем примере строка 'привет' передается в хранимую процедуру, а затем эта строка будет заменена возвращаемым значением.

Вызов хранимой процедуры с входным/выходным параметром
------------------------------------------------------
      <?php
      $stmt = $dbh->prepare("CALL sp_takes_string_returns_string(?)");
      $value = 'привет';
      $stmt->bindParam(1, $value, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 

      // вызов хранимой процедуры
      $stmt->execute();

      print "процедура вернула $value\n";
      ?>
Неправильное использование псевдопеременной
-------------------------------------------
      <?php
      $stmt = $dbh->prepare("SELECT * FROM REGISTRY where name LIKE '%?%'");
      $stmt->execute(array($_GET['name']));

      // псевдопеременная может использоваться только в виде отдельного значения
      $stmt = $dbh->prepare("SELECT * FROM REGISTRY where name LIKE ?");
      $stmt->execute(array("%$_GET[name]%"));
      ?>

PDO::prepare
=============

Подготавливает SQL запрос к базе данных к запуску посредством метода PDOStatement::execute(). Запрос может содержать именованные (:name) или неименованные (?) псевдопеременные, которые будут заменены реальными значениями во время запуска запроса на выполнение. Использовать одновременно и именованные, и неименованные псевдопеременные в одном запросе нельзя, необходимо выбрать что-то одно. Используйте псевдопеременные, чтобы привязать к запросу пользовательский ввод, не включайте данные, введенные пользователем, напрямую в запрос.

Вы должны подбирать уникальные имена псевдопеременных для каждого значение, которое необходимо передавать в запрос при вызове PDOStatement::execute(). Нельзя использовать одну псевдопеременную в запросе больше одного раза, если только не включен режим эмуляции.

Маркеры параметров представляют из себя только непосредственно данные. Ни часть данных, ни специальные слова, ни идентификаторы, никакая другая часть запроса не могут быть переданы через параметры. Например, вы не можете привязать несколько значений к одному параметру для SQL выражения IN().
Вызов PDO::prepare() и PDOStatement::execute() для запросов, которые будут запускаться многократно с различными параметрами, повышает производительность приложения, так как позволяет драйверу кэшировать на клиенте и/или сервере план выполнения запроса и метаданные, а также помогает избежать SQL инъекций, так как нет необходимости экранировать передаваемые параметры.

Если драйвер не поддерживает подготавливаемые запросы, PDO умеет их эмулировать. Также, PDO может заменять псевдопеременные на то, что больше подходит, если, например, драйвер поддерживает только именованные или, наоборот, только неименованные маркеры.

Список параметров
-----------------
- statement
Это должен быть корректный запрос с точки зрения целевой СУБД.

- driver_options
Этот массив содержит одну или более пар ключ=>значение для установки значений атрибутов объекта PDOStatement, который будет возвращен из этого метода. В основном, вы будете использовать этот массив для присвоения значения PDO::ATTR_CURSOR атрибуту PDO::CURSOR_SCROLL, чтобы получить прокручиваемый курсор. У некоторых драйверов могут быть свои специфические настройки, которые можно задать во время подготовки запроса.

Возвращаемые значения
---------------------
Если СУБД успешно подготовила запрос, PDO::prepare() возвращает объект PDOStatement. Если подготовить запрос не удалось, PDO::prepare() возвращает FALSE или выбрасывает исключение PDOException (зависит от текущего режима обработки ошибок).

Эмулируемые подготовленные запросы не создаются на сервере баз данных, поэтому PDO::prepare() не может проверить правильность построенного запроса.


header — Отправка HTTP заголовка
================================

header() используется для отправки HTTP заголовка. 

функцию header() можно вызывать только если клиенту еще не передавались данные. То есть она должна идти первой в выводе, перед ее вызовом не должно быть никаких HTML тэгов, пустых строк и т.п. Довольно часто возникает ошибка, когда при чтении кода файловыми функциями, вроде include или require, в этом коде попадаются пробелы или пустые строки, которые выводятся до вызова header(). Те же проблемы могут возникать и при использовании одиночного PHP/HTML файла.

        <html>
        <?php
        /* Этот пример приведет к ошибке. Обратите внимание
         * на тэг вверху, который будет выведен до вызова header() */
        header('Location: http://www.example.com/');
        exit;
        ?>
Список параметров 
-----------------
- string
Строка заголовка.

Существует два специальных заголовка. Один из них начинается с "HTTP/" (регистр не важен) и используется для отправки кода состояния HTTP. Например, если веб-сервер Apache сконфигурирован таким образом, чтобы запросы к несуществующим файлам обрабатывались средствами PHP скрипта (используя директиву ErrorDocument), вы наверняка захотите быть уверенными что скрипт генерирует правильный код состояния.

      <?php
      header("HTTP/1.0 404 Not Found");
      ?>
Другим специальным видом заголовков является "Location:". В этом случае функция не только отправляет этот заголовок броузеру, но также возвращает ему код состояния REDIRECT (302) (если ранее не был установлен код 201 или 3xx).

      <?php
      header("Location: http://www.example.com/"); /* Перенаправление броузера */

      /* Можно убедиться, что следующий за командой код не выполнится из-за
      перенаправления.*/
      exit;
      ?>
- replace
Необязательный параметр replace определяет, надо ли заменять предыдущий аналогичный заголовок или заголовок того же типа. По умолчанию заголовок будет заменен, но если передать FALSE, можно задать несколько однотипных заголовков. Например:

      <?php
      header('WWW-Authenticate: Negotiate');
      header('WWW-Authenticate: NTLM', false);
      ?>
- http_response_code
Принудительно задает код ответа HTTP. Следует учитывать, что это будет работать, только если строка string не является пустой.

Возвращаемые значения 
---------------------
Эта функция не возвращает значения после выполнения.

Диалог загрузки
----------------
Если нужно предупредить пользователя о необходимости сохранить пересылаемые данные, такие как сгенерированный PDF файл, можно воспользоваться заголовком » Content-Disposition, который подставляет рекомендуемое имя файла и заставляет броузер показать диалог загрузки.

        <?php
        // Будем передавать PDF
        header('Content-Type: application/pdf');

        // Который будет называться downloaded.pdf
        header('Content-Disposition: attachment; filename="downloaded.pdf"');

        // Исходный PDF файл original.pdf
        readfile('original.pdf');
        ?>
Директивы для работы с кэшем
----------------------------
PHP скрипты часто генерируют динамический контент, который не должен кэшироваться клиентским броузером или какими-либо промежуточными обработчиками, вроде прокси серверов. Можно принудительно отключить кэширование на многих прокси серверах и броузерах, передав заголовки:

      <?php
      header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
      header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
      ?>

В некоторых случаях ваши страницы не будут кэшироваться броузером, даже если вы не передавали этих заголовков. В броузерах есть определенные настройки, с помощью которых пользователь может изменять обычный ход кэширования, отключать его. Вы должны перекрывать любые настройки, которые могут повлиять на кэширование скрипта, отправляя приведенные выше заголовки.
Дополнительно, для случаев когда используются сессии, можно задать настройки конфигурации session_cache_limiter() и session.cache_limiter. Эти настройки можно использовать для автоматической генерации заголовков управляющих кешированием.


view.php
--------

        <?php 

        require_once __DIR__.'/../bootstrap/app.php';

        $stmt = $db->prepare('SELECT id, title, content, created FROM blog_posts WHERE id = :postID');
        $stmt->execute(array(':postID' => $_GET['id']));
        $row = $stmt->fetch();

        //if post does not exists redirect user.
        if($row['id'] == ''){
          header('Location: ./');
          exit;
        }

        ?>

        <?php
        require_once __DIR__.'/../resources/views/layouts/header.php';
        require_once __DIR__.'/../resources/views/layouts/nav.php';
        ?>

           <main>
                
            <section class="row border-top border-bottom">
               <article class="content col-8">


            <h1>Blog</h1>
            <hr />
            <p><a href="./">Blog Index</a></p>


            <?php 
              echo '<div>';
                echo '<h1>'.$row['title'].'</h1>';
                echo '<p>Posted on '.date('jS M Y', strtotime($row['created'])).'</p>';
                echo '<p>'.$row['content'].'</p>';        
              echo '</div>';
            ?>

            </article>
            
            <aside id="sidebar" class="sidebar col-4 border-left border-right">
            

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


PDOStatement::fetch
====================
Извлечение следующей строки из результирующего набора

    public mixed PDOStatement::fetch ([ int $fetch_style [, int $cursor_orientation = PDO::FETCH_ORI_NEXT [, int $cursor_offset = 0 ]]] )
Извлекает следующую строку из результирующего набора объекта PDOStatement. Параметр fetch_style определяет, в каком виде PDO вернет эту строку.

Список параметров 
-----------------
- fetch_style
Определяет, в каком виде следующая строка будет возвращена в вызывающий метод. Это может быть одна из констант PDO::FETCH_*. По умолчанию PDO::ATTR_DEFAULT_FETCH_MODE (что равносильно PDO::FETCH_BOTH).

- PDO::FETCH_ASSOC: возвращает массив, индексированный именами столбцов результирующего набора

- PDO::FETCH_BOTH (по умолчанию): возвращает массив, индексированный именами столбцов результирующего набора, а также их номерами (начиная с 0)

- PDO::FETCH_BOUND: возвращает TRUE и присваивает значения столбцов результирующего набора переменным PHP, которые были привязаны к этим столбцам методом PDOStatement::bindColumn()

- PDO::FETCH_CLASS: создает и возвращает объект запрошенного класса, присваивая значения столбцов результирующего набора именованным свойствам класса. Если fetch_style включает в себя атрибут PDO::FETCH_CLASSTYPE (например, PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE), то имя класса, от которого нужно создать объект, будет взято из первого столбца.

- PDO::FETCH_INTO: обновляет существующий объект запрошенного класса, присваивая значения столбцов результирующего набора именованным свойствам объекта

- PDO::FETCH_LAZY: комбинирует PDO::FETCH_BOTH и PDO::FETCH_OBJ, создавая новый объект со свойствами, соответствующими именам столбцов результирующего набора

- PDO::FETCH_NAMED: возвращает массив такого же вида, как и PDO::FETCH_ASSOC, но, если есть несколько полей с одинаковым именем, то значением с этим ключом будет массив со всеми значениями из рядов, в которых это поле указано.

- PDO::FETCH_NUM: возвращает массив, индексированный номерами столбцов (начиная с 0)

- PDO::FETCH_OBJ: создает анонимный объект со свойствами, соответствующими именам столбцов результирующего набора

- cursor_orientation
Для объектов PDOStatement представляющих прокручиваемый курсор, этот параметр определяет, какая строка будет возвращаться в вызывающий метод. Значением параметра должна быть одна из констант PDO::FETCH_ORI_*, по умолчанию PDO::FETCH_ORI_NEXT. Чтобы запросить прокручиваемый курсор для запроса PDOStatement, необходимо задать атрибут PDO::ATTR_CURSOR со значением PDO::CURSOR_SCROLL во время подготовки запроса методом PDO::prepare().

- offset
Для объектов PDOStatement, представляющих прокручиваемый курсор, параметр cursor_orientation которых принимает значение PDO::FETCH_ORI_ABS, эта величина означает абсолютный номер строки, которую необходимо извлечь из результирующего набора.

Для объектов PDOStatement, представляющих прокручиваемый курсор, параметр cursor_orientation которых принимает значение PDO::FETCH_ORI_REL, эта величина указывает, какая строка относительно текущего положения курсора будет извлечена функцией PDOStatement::fetch().

Возвращаемые значения 
----------------------
В случае успешного выполнения функции возвращаемое значение зависит от режима выборки. В случае неудачи, функция всегда возвращает FALSE.

Извлечение строк в разных режимах выборки
------------------------------------------
      <?php
      $sth = $dbh->prepare("SELECT name, colour FROM fruit");
      $sth->execute();

      /* Примеры различных режимов работы PDOStatement::fetch */
      print("PDO::FETCH_ASSOC: ");
      print("Возвращаем следующую строку в виде массива, индексированного именами столбцов\n");
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      print_r($result);
      print("\n");

      print("PDO::FETCH_BOTH: ");
      print("Возвращаем следующую строку в виде массива, индексированного как именами столбцов, так и их номерами\n");
      $result = $sth->fetch(PDO::FETCH_BOTH);
      print_r($result);
      print("\n");

      print("PDO::FETCH_LAZY: ");
      print("Возвращаем следующую строку в виде анонимного объекта со свойствами, соответствующими столбцам\n");
      $result = $sth->fetch(PDO::FETCH_LAZY);
      print_r($result);
      print("\n");

      print("PDO::FETCH_OBJ: ");
      print("Возвращаем следующую строку в виде анонимного объекта со свойствами, соответствующими столбцам\n");
      $result = $sth->fetch(PDO::FETCH_OBJ);
      print $result->NAME;
      print("\n");
      ?>

Результат выполнения данного примера:

        PDO::FETCH_ASSOC: Возвращаем следующую строку в виде массива, индексированного именами столбцов
        Array
        (
            [NAME] => apple
            [COLOUR] => red
        )

        PDO::FETCH_BOTH: Возвращаем следующую строку в виде массива, индексированного как именами столбцов, так и их номерами
        Array
        (
            [NAME] => banana
            [0] => banana
            [COLOUR] => yellow
            [1] => yellow
        )

        PDO::FETCH_LAZY: Возвращаем следующую строку в виде анонимного объекта со свойствами, соответствующими столбцам
        PDORow Object
        (
            [NAME] => orange
            [COLOUR] => orange
        )

        PDO::FETCH_OBJ: Возвращаем следующую строку в виде анонимного объекта со свойствами, соответствующими столбцам
        kiwi

Выборка строк средствами прокручиваемого курсора
-------------------------------------------------
        <?php
        function readDataForwards($dbh) {
          $sql = 'SELECT hand, won, bet FROM mynumbers ORDER BY BET';
          try {
            $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
              $data = $row[0] . "\t" . $row[1] . "\t" . $row[2] . "\n";
              print $data;
            }
            $stmt = null;
          }
          catch (PDOException $e) {
            print $e->getMessage();
          }
        }
        function readDataBackwards($dbh) {
          $sql = 'SELECT hand, won, bet FROM mynumbers ORDER BY bet';
          try {
            $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_LAST);
            do {
              $data = $row[0] . "\t" . $row[1] . "\t" . $row[2] . "\n";
              print $data;
            } while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_PRIOR));
            $stmt = null;
          }
          catch (PDOException $e) {
            print $e->getMessage();
          }
        }

        print "Читаем в прямой последовательности:\n";
        readDataForwards($conn);

        print "Читаем в обратной последовательности:\n";
        readDataBackwards($conn);
        ?>
Результат выполнения данного примера:

        Читаем в прямой последовательности:
        21    10    5
        16    0     5
        19    20    10

        Читаем в обратной последовательности:
        19    20    10
        16    0     5
        21    10    5


admin/index.php
================

        <?php
        //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';

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
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    
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

            <p><a href='add-post.php'>Add Post</a></p>
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

        <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>


add-post.php
-------------

      <?php //include config
      require_once __DIR__.'/../../bootstrap/app.php';
      require_once __DIR__.'/../../resources/views/layouts/header.php';
      ?>

array_map
=========
array_map — Применяет callback-функцию ко всем элементам указанных массивов

    array array_map ( callable $callback , array $array1 [, array $... ] )
Функция array_map() возвращает массив, содержащий элементы array1 после их обработки callback-функцией. Количество параметров, передаваемых callback-функции, должно совпадать с количеством массивов, переданным функции array_map().

Список параметров 
-----------------
- callback
Callback-функция, применяемая к каждому элементу в каждом массиве.

- array1
Массив, к которому применяется callback-функция.


Возвращаемые значения 
---------------------
Возвращает массив, содержащий все элементы array1 после применения callback-функции к каждому из них.


Пример #1 Пример использования array_map()

      <?php
      function cube($n)
      {
          return($n * $n * $n);
      }

      $a = array(1, 2, 3, 4, 5);
      $b = array_map("cube", $a);
      print_r($b);
      ?>
В результате переменная $b будет содержать:

      Array
      (
          [0] => 1
          [1] => 8
          [2] => 27
          [3] => 64
          [4] => 125
      )
Пример #2 Использование array_map() вместе с lambda-функцией (начиная с версии PHP 5.3.0)

        <?php
        $func = function($value) {
            return $value * 2;
        };

        print_r(array_map($func, range(1, 5)));
        ?>
        Array
        (
            [0] => 2
            [1] => 4
            [2] => 6
            [3] => 8
            [4] => 10
        )
Пример #3 Пример использования array_map(): обработка нескольких массивов

            <?php
            function show_Spanish($n, $m)
            {
                return("Число $n по-испански - $m");
            }

            function map_Spanish($n, $m)
            {
                return(array($n => $m));
            }

            $a = array(1, 2, 3, 4, 5);
            $b = array("uno", "dos", "tres", "cuatro", "cinco");

            $c = array_map("show_Spanish", $a, $b);
            print_r($c);

            $d = array_map("map_Spanish", $a , $b);
            print_r($d);
            ?>
Результат выполнения данного примера:

        // вывод $c
        Array
        (
            [0] => Число 1 по-испански - uno
            [1] => Число 2 по-испански - dos
            [2] => Число 3 по-испански - tres
            [3] => Число 4 по-испански - cuatro
            [4] => Число 5 по-испански - cinco
        )

        // вывод $d
        Array
        (
            [0] => Array
                (
                    [1] => uno
                )

            [1] => Array
                (
                    [2] => dos
                )

            [2] => Array
                (
                    [3] => tres
                )

            [3] => Array
                (
                    [4] => cuatro
                )

            [4] => Array
                (
                    [5] => cinco
                )

        )
Обычно при обработке двух или более массивов, они имеют одинаковую длину, так как callback-функция применяется параллельно к соответствующим элементам массивов. Если массивы имеют различную длину, более короткие из них дополняется элементами с пустыми значениями до длины самого длинного массива.

Интересным эффектом при использовании этой функции является создание массива массивов, что может быть достигнуто путем использования значения NULL в качестве имени callback-функции.

Пример #4 Создание массива массивов

      <?php
      $a = array(1, 2, 3, 4, 5);
      $b = array("one", "two", "three", "four", "five");
      $c = array("uno", "dos", "tres", "cuatro", "cinco");

      $d = array_map(null, $a, $b, $c);
      print_r($d);
      ?>
Результат выполнения данного примера:

          Array
          (
              [0] => Array
                  (
                      [0] => 1
                      [1] => one
                      [2] => uno
                  )

              [1] => Array
                  (
                      [0] => 2
                      [1] => two
                      [2] => dos
                  )

              [2] => Array
                  (
                      [0] => 3
                      [1] => three
                      [2] => tres
                  )

              [3] => Array
                  (
                      [0] => 4
                      [1] => four
                      [2] => cuatro
                  )

              [4] => Array
                  (
                      [0] => 5
                      [1] => five
                      [2] => cinco
                  )

          )
Если массив-аргумент содержит строковые ключи, то результирующий массив будет содержать строковые ключи тогда и только тогда, если передан ровно один массив. Если передано больше одного аргумента, то результирующий массив будет всегда содержать числовые ключи.

Пример #5 Использование array_map() со строковыми ключами

        <?php
        $arr = array("stringkey" => "value");
        function cb1($a) {
            return array ($a);
        }
        function cb2($a, $b) {
            return array ($a, $b);
        }
        var_dump(array_map("cb1", $arr));
        var_dump(array_map("cb2", $arr, $arr));
        var_dump(array_map(null, $arr));
        var_dump(array_map(null, $arr, $arr));
        ?>
Результат выполнения данного примера:

        array(1) {
          ["stringkey"]=>
          array(1) {
            [0]=>
            string(5) "value"
          }
        }
        array(1) {
          [0]=>
          array(2) {
            [0]=>
            string(5) "value"
            [1]=>
            string(5) "value"
          }
        }
        array(1) {
          ["stringkey"]=>
          string(5) "value"
        }
        array(1) {
          [0]=>
          array(2) {
            [0]=>
            string(5) "value"
            [1]=>
            string(5) "value"
          }
        }


extract
=======
extract — Импортирует переменные из массива в текущую таблицу символов

int extract ( array &$array [, int $flags = EXTR_OVERWRITE [, string $prefix = NULL ]] )
Импортирует переменные из массива в текущую таблицу символов.

Каждый ключ проверяется на предмет корректного имени переменной. Также проверяются совпадения с существующими переменными в символьной таблице.

Список параметров 
-----------------
- array
Ассоциативный массив. Эта функция рассматривает ключи массива в качестве имен переменных, а их значения - в качестве значений этих переменных. Для каждой пары ключ/значение будет создана переменная в текущей таблице символов, в соответствии с параметрами flags и prefix.

Вы должны использовать ассоциативный массив, использование числовых массивов не приведёт ни к каким результатам, если вы не используете EXTR_PREFIX_ALL или EXTR_PREFIX_INVALID.

- flags
Параметр flags определяет способ трактования неправильных/числовых ключей и коллизий. Он может принимать следующие значения:

- EXTR_OVERWRITE
Если переменная с таким именем существует, она будет перезаписана.
- EXTR_SKIP
Если переменная с таким именем существует, ее текущее значение не будет перезаписано.
- EXTR_PREFIX_SAME
Если переменная с таким именем существует, к её имени будет добавлен префикс, определённый параметром prefix.
- EXTR_PREFIX_ALL
Добавить префикс prefix ко всем именам переменных.
- EXTR_PREFIX_INVALID
Добавить префикс prefix только к некорректным/числовым именам переменных.
- EXTR_IF_EXISTS
Перезаписать только переменные, уже имеющиеся в текущей таблице символов, в противном случае не делать ничего. Данная возможность полезна для определения списка приемлемых переменных и для извлечения только тех переменных, которые вы уже определили из массивов типа $_REQUEST, например.
- EXTR_PREFIX_IF_EXISTS
Создать только префикс-версии переменных, если версия данной переменной без префикса уже существует в текущей символьной таблице.
- EXTR_REFS
Извлечь переменные как ссылки. Это означает, что значения таких переменных будут всё ещё ссылаться на значения массива array. Вы можете использовать этот флаг отдельно или комбинировать его с другими значениями flags с помощью побитового 'или'.
Если flags не указан, он трактуется как EXTR_OVERWRITE.

- prefix
Обратите внимание, что prefix имеет значение, только если flags установлен в EXTR_PREFIX_SAME, EXTR_PREFIX_ALL, EXTR_PREFIX_INVALID или EXTR_PREFIX_IF_EXISTS. Если в результате добавления префикса, не будет получено допустимое имя для переменной, она не будет импортирована в текущую символьную таблицу.

Возвращаемые значения 
----------------------
Возвращает количество переменных, успешно импортированных в текущую таблицу символов.


add-post.php
------------

          <main>
              <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    
              <section class="row border-top border-bottom">
                 <article class="content col-8">
                 <h3>Add Post</h3>
                    <p><a href="./">Blog Admin Index</a></p>

                    <h2>Add Post</h2>

                    <?php

                    //if form has been submitted process it
                    if(isset($_POST['submit'])){

                        $_POST = array_map( 'stripslashes', $_POST );

                        //collect form data
                        extract($_POST);

                        //very basic validation
                        if($title ==''){
                            $error[] = 'Please enter the title.';
                        }

                        if($description ==''){
                            $error[] = 'Please enter the description.';
                        }

                        if($content ==''){
                            $error[] = 'Please enter the content.';
                        }

                        if(!isset($error)){

                            try {

                                //insert into database
                                $stmt = $db->prepare('INSERT INTO blog_posts (title,description,content,created) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
                                $stmt->execute(array(
                                    ':postTitle' => $title,
                                    ':postDesc' => $description,
                                    ':postCont' => $content,
                                    ':postDate' => date('Y-m-d H:i:s')
                                ));

                                //redirect to index page
                                header('Location: index.php?action=added');
                                exit;

                            } catch(PDOException $e) {
                                echo $e->getMessage();
                            }

                        }

                    }

                    //check for any errors
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<p class="error">'.$error.'</p>';
                        }
                    }
                    ?>

              <form action='' method='post'>

                  <p><label>Title</label><br />
                  <input type='text' name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>

                  <p><label>Description</label><br />
                  <textarea name='description' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['description'];}?></textarea></p>

                  <p><label>Content</label><br />
                  <textarea name='content' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['content'];}?></textarea></p>

                  <p><input type='submit' name='submit' value='Submit'></p>

              </form>

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

          <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>


nav_admin.php
---------------

            <header>
              <div class="row">
                <input type="checkbox" id="navbar-checkbox" class="navbar-checkbox">
                  <nav class='menu col'>
                      <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="./">Blog</a></li>
                      </ul>
                      <label for="navbar-checkbox" class="navbar-handle"></label>
                  </nav>
                  </div>
            </header>


foreach 
=======
Конструкция foreach предоставляет простой способ перебора массивов. Foreach работает только с массивами и объектами, и будет генерировать ошибку при попытке использования с переменными других типов или неинициализированными переменными. Существует два вида синтаксиса:

      foreach (array_expression as $value)
          statement
      foreach (array_expression as $key => $value)
          statement
Первый цикл перебирает массив, задаваемый с помощью array_expression. На каждой итерации значение текущего элемента присваивается переменной $value и внутренний указатель массива увеличивается на единицу (таким образом, на следующей итерации цикла работа будет происходить со следующим элементом).

Второй цикл будет дополнительно соотносить ключ текущего элемента с переменной $key на каждой итерации.

Возможно настроить итераторы объектов.

Когда оператор foreach начинает исполнение, внутренний указатель массива автоматически устанавливается на первый его элемент Это означает, что нет необходимости вызывать функцию reset() перед использованием цикла foreach.
Так как оператор foreach опирается на внутренний указатель массива, его изменение внутри цикла может привести к непредсказуемому поведению.
Для того, чтобы напрямую изменять элементы массива внутри цикла, переменной $value должен предшествовать знак &. В этом случае значение будет присвоено по ссылке.

      <?php
      $arr = array(1, 2, 3, 4);
      foreach ($arr as &$value) {
          $value = $value * 2;
      }
      // массив $arr сейчас таков: array(2, 4, 6, 8)
      unset($value); // разорвать ссылку на последний элемент
      ?>
Указатель на $value возможен, только если на перебираемый массив можно ссылаться (т.е. если он является переменной). Следующий код не будет работать:

      <?php
      foreach (array(1, 2, 3, 4) as &$value) {
          $value = $value * 2;
      }
      ?>

Ссылка $value на последний элемент массива остается даже после того, как оператор foreach завершил работу. Рекомендуется уничтожить ее с помощью функции unset().
Замечание:
Оператор foreach не поддерживает возможность подавления сообщений об ошибках с помощью префикса '@'.
Вы могли заметить, что следующие конструкции функционально идентичны:

      <?php
      $arr = array("one", "two", "three");
      reset($arr);
      while (list(, $value) = each($arr)) {
          echo "Значение: $value<br />\n";
      }

      foreach ($arr as $value) {
          echo "Значение: $value<br />\n";
      }
      ?>
Следующие конструкции также функционально идентичны:

      <?php
      $arr = array("one", "two", "three");
      reset($arr);
      while (list($key, $value) = each($arr)) {
          echo "Ключ: $key; Значение: $value<br />\n";
      }

      foreach ($arr as $key => $value) {
          echo "Ключ: $key; Значение: $value<br />\n";
      }
      ?>
Вот еще несколько примеров, демонстрирующие использование оператора:

      <?php
      /* Пример 1: только значение */

      $a = array(1, 2, 3, 17);

      foreach ($a as $v) {
          echo "Текущее значение переменной \$a: $v.\n";
      }

/* Пример 2: значение (для иллюстрации массив выводится в виде значения с ключом) */

      $a = array(1, 2, 3, 17);

      $i = 0; /* только для пояснения */

      foreach ($a as $v) {
          echo "\$a[$i] => $v.\n";
          $i++;
      }

/* Пример 3: ключ и значение */

      $a = array(
          "one" => 1,
          "two" => 2,
          "three" => 3,
          "seventeen" => 17
      );

      foreach ($a as $k => $v) {
          echo "\$a[$k] => $v.\n";
      }

/* Пример 4: многомерные массивы */
      $a = array();
      $a[0][0] = "a";
      $a[0][1] = "b";
      $a[1][0] = "y";
      $a[1][1] = "z";

      foreach ($a as $v1) {
          foreach ($v1 as $v2) {
              echo "$v2\n";
          }
      }

/* Пример 5: динамические массивы */

      foreach (array(1, 2, 3, 4, 5) as $v) {
          echo "$v\n";
      }
      ?>
Распаковка вложенных массивов с помощью list() 
------------------------------------------------
В PHP 5.5 была добавлена возможность обхода массива массивов с распаковкой вложенного массива в переменные цикла, передав list() в качестве значения.


      <?php
      $array = [
          [1, 2],
          [3, 4],
      ];

      foreach ($array as list($a, $b)) {
          // $a содержит первый элемент вложенного массива,
          // а $b содержит второй элемент.
          echo "A: $a; B: $b\n";
      }
      ?>
Результат выполнения данного примера:

      A: 1; B: 2
      A: 3; B: 4

Можно передавать меньшее количество элементов в list(), чем находится во вложенном массиве, в этом случае оставшиеся значения массива будут проигнорированы:

      <?php
      $array = [
          [1, 2],
          [3, 4],
      ];

      foreach ($array as list($a)) {
          // Обратите внимание на отсутствие $b.
          echo "$a\n";
      }
      ?>
Результат выполнения данного примера:

      1
      3

Если массив содержит недостаточно элементов для заполнения всех переменных из list(), то будет сгенерировано замечание об ошибке:

      <?php
      $array = [
          [1, 2],
          [3, 4],
      ];

      foreach ($array as list($a, $b, $c)) {
          echo "A: $a; B: $b; C: $c\n";
      }
      ?>
Результат выполнения данного примера:

      Notice: Undefined offset: 2 in example.php on line 7
      A: 1; B: 2; C:

      Notice: Undefined offset: 2 in example.php on line 7
      A: 3; B: 4; C: