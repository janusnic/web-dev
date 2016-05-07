# web-dev unit_12

собственный поиск по сайту с использованием PHP и MySQL

Пользователь выполняет POST запрос из формы поиска, этот запрос передается специальному скрипту-обработчику, который должен обработать поисковый запрос пользователя и возвратить результат.

Сначала скрипт должен обработать должным образом запрос пользователя для обеспечения безопасности, затем выполняется запрос к базе данных, который возвращает в ассоциативном массиве результаты, которые должны будут выводиться на экран. 

Простейший алгоритм следующий:

- Создать HTML-форму со строкой поиска, а также кнопкой "Submit". В текстовое поле пользователи будут вводить поисковый запрос, а далее нажимать на кнопку.
- Получить поисковый запрос (как правило, передаваемый методом GET, но иногда применяют и POST), а также, в целях защиты от XSS, пропустить его через функцию htmlspecialchars().
- Сделать выборку из соответствующих таблицы (со статьями, новостями, заметками и прочим) тех записей, в которых содержится поисковый запрос. Показываю примерный SQL-запрос для таких случаев:
SELECT * FROM articles WHERE `text_article` LIKE %search%
Соответственно, вместо search подставляется строка поиска.
- Получив записи, в нужном виде выводим их, желательно, по релевантности.

создадим форму поиска на странице sidebar.php

    <form name="search" method="post" action="search.php">
        <input type="search" name="query" placeholder="Поиск">
        <button type="submit">Найти</button> 
    </form>

Эта форма и будет отправлять сам поисковый запрос скрипту search.php.

    <?php 
    require_once __DIR__.'/../bootstrap/app.php';
    require_once __DIR__.'/../resources/views/layouts/header.php';
    require_once __DIR__.'/../resources/views/layouts/nav.php';

    ?>
       <main>
            
        <section class="row border-top border-bottom">
           <article class="content col-8">

            <h1>Blog Search</h1>
            <hr />
            <p><a href="./">Blog Index</a></p>
    <?php
        $query = $_POST['query']; 
    
    //  обрабатывают запрос, чтобы он стал безопасным для базы. Такую обработку нужно делать обязательно, т.  к.  любая форма на Вашем сайте — это потенциальная уязвимость для злоумышленников.

    $query = trim($query); 
    
    $query = htmlspecialchars($query);

    trim — Удаляет пробелы (или другие символы) из начала и конца строки


      string trim ( string $str [, string $character_mask = " \t\n\r\0\x0B" ] )

Эта функция возвращает строку str с удаленными из начала и конца строки пробелами. Если второй параметр не передан, trim() удаляет следующие символы:

    " " (ASCII 32 (0x20)), обычный пробел.
    "\t" (ASCII 9 (0x09)), символ табуляции.
    "\n" (ASCII 10 (0x0A)), символ перевода строки.
    "\r" (ASCII 13 (0x0D)), символ возврата каретки.
    "\0" (ASCII 0 (0x00)), NUL-байт.
    "\x0B" (ASCII 11 (0x0B)), вертикальная табуляция.

Список параметров 

str
Обрезаемая строка (string).

character_mask
Можно также задать список символов для удаления с помощью необязательного аргумента character_mask. Просто перечислите все символы, которые вы хотите удалить. Можно указать конструкцию .. для обозначения диапазона символов.

Возвращаемые значения 

Обрезаемая строка.

Пример использования trim()

      <?php

      $text   = "\t\tThese are a few words :) ...  ";
      $binary = "\x09Example string\x0A";
      $hello  = "Hello World";
      var_dump($text, $binary, $hello);

      print "\n";

      $trimmed = trim($text);
      var_dump($trimmed);

      $trimmed = trim($text, " \t.");
      var_dump($trimmed);

      $trimmed = trim($hello, "Hdle");
      var_dump($trimmed);

      $trimmed = trim($hello, 'HdWr');
      var_dump($trimmed);

      // удаляем управляющие ASCII-символы с начала и конца $binary
      // (от 0 до 31 включительно)
      $clean = trim($binary, "\x00..\x1F");
      var_dump($clean);

      ?>
Результат выполнения данного примера:

    string(32) "        These are a few words :) ...  "
    string(16) "    Example string
    "
    string(11) "Hello World"

    string(28) "These are a few words :) ..."
    string(24) "These are a few words :)"
    string(5) "o Wor"
    string(9) "ello Worl"
    string(14) "Example string"

Обрезание значений массива с помощью trim()

    <?php
    function trim_value(&$value)
    {
        $value = trim($value);
    }

    $fruit = array('apple','banana ', ' cranberry ');
    var_dump($fruit);

    array_walk($fruit, 'trim_value');
    var_dump($fruit);

    ?>
Результат выполнения данного примера:

    array(3) {
      [0]=>
      string(5) "apple"
      [1]=>
      string(7) "banana "
      [2]=>
      string(11) " cranberry "
    }
    array(3) {
      [0]=>
      string(5) "apple"
      [1]=>
      string(6) "banana"
      [2]=>
      string(9) "cranberry"
    }


Возможные трюки: удаление символов из середины строки
Так как trim() удаляет символы с начала и конца строки string, то удаление (или неудаление) символов из середины строки может ввести в недоумение. trim('abc', 'bad') удалит как 'a', так и 'b', потому что удаление 'a' сдвинет 'b' к началу строки, что также позволит ее удалить. Вот почему это "работает", тогда как trim('abc', 'b') очевидно нет.


htmlspecialchars — Преобразует специальные символы в HTML-сущности

    string htmlspecialchars ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = ini_get("default_charset") [, bool $double_encode = true ]]] )
В HTML некоторые символы имеют особый смысл и должны быть представлены в виде HTML сущностей, чтобы сохранить их значение. Эта функция возвращает строку, над которой проведены эти преобразования. Если вам нужно преобразовать все возможные сущности, используйте htmlentities().

Если входная строка переданная в эту функцию и результирующий документ используют одинаковую кодировку символов, то этой функции достаточно, чтобы подготовить данные для вставки в большинство частей HTML документа. Однако, если данные содержат символы, не определенные в кодировке символов результирующего документа и вы ожидаете сохранения этих символов (как числовые или именованные сущности), то вам недостаточно будет этой и htmlentities() функций (которые только преобразуют подстроки с соответствующими сущностями). Необходимо использовать функцию mb_encode_numericentity().

Производятся следующие преобразования:

    '&' (амперсанд) преобразуется в '&amp;'
    '"' (двойная кавычка) преобразуется в '&quot;' в режиме ENT_NOQUOTES is not set.
    "'" (одиночная кавычка) преобразуется в '&#039;' (или &apos;) только в режиме ENT_QUOTES.
    '<' (знак "меньше чем") преобразуется в '&lt;'
    '>' (знак "больше чем") преобразуется в '&gt;'

Список параметров 

string
Конвертируемая строка (string).

flags
Битовая маска из нижеуказанных флагов, определяющих режим обработки кавычек, некорректных кодовых последовательностей и используемый тип документа. По умолчанию используется ENT_COMPAT | ENT_HTML401.

Доступные значения параметра flags

ENT_COMPAT  Преобразует двойные кавычки, одинарные кавычки не изменяются.
ENT_QUOTES  Преобразует как двойные, так и одинарные кавычки.
ENT_NOQUOTES  Оставляет без изменения как двойные, так и одинарные кавычки.
ENT_IGNORE  Без всяких уведомительных сообщений отбрасывает некорректные кодовые последовательности вместо возврата пустой строки. Использование этого флага не рекомендуется, так как это может привести к » негативным последствиям, связанным с безопасностью.
ENT_SUBSTITUTE  Заменяет некорреткные кодовые последовательности символом замены Юникода U+FFFD в случае использования UTF-8 и &#FFFD; при использовании другой кодировки, вместо возврата пустой строки.
ENT_DISALLOWED  Заменяет неверные коды символов для заданного типа документа символом замены юникода U+FFFD (UTF-8) или &#FFFD; (при использовании другой кодировки) вместо того, чтобы оставлять все как есть. Это может быть полезно, например, для того, чтобы убедиться в формальной правильности XML-документов со встроенным внешним контентом.
ENT_HTML401 Обработка кода в соответствии с HTML 4.01.
ENT_XML1  Обработка кода в соответствии с XML 1.
ENT_XHTML Обработка кода в соответствии с XHTML.
ENT_HTML5 Обработка кода в соответствии с HTML 5.
encoding

Необязательный аргумент определяющий кодировку, используемую при конвертации симоволов.

Если не указан, то значением по умолчанию для encoding зависит от используемой версии PHP. В PHP 5.6 и старше, для значения по умолчанию используется конфигурационная опция default_charset. В PHP 5.4 и 5.5 используется UTF-8 по умолчанию. Более ранние версии PHP используют ISO-8859-1.

Хотя этот аргумент является технически необязательным, настоятельно рекомендуется   указать правильное значение для вашего кода, если вы используете PHP 5.5 или выше,   или если ваша опция конфигурации default_charset   может быть задана неверно для входных данных.

Для целей этой функции кодировки ISO-8859-1, ISO-8859-15, UTF-8, cp866, cp1251, cp1252 и KOI8-R являются практически эквивалентными, предполагая то, что сама строка string содержит корректные символы в указанной кодировке, то символы, изменяемые htmlspecialchars(), останутся на тех же местах во всех этих кодировках.

Поддерживаются следующие кодировки:

ISO-8859-1  ISO8859-1 Западно-европейская Latin-1.
ISO-8859-5  ISO8859-5 Редко используемая кириллическая кодировка (Latin/Cyrillic).
ISO-8859-15 ISO8859-15  Западно-европейская Latin-9. Добавляет знак евро, французские и финские буквы к кодировке Latin-1(ISO-8859-1).
UTF-8   8-битная Unicode, совместимая с ASCII.
cp866 ibm866, 866 Кириллическая кодировка, применяемая в DOS.
cp1251  Windows-1251, win-1251, 1251  Кириллическая кодировка, применяемая в Windows.
cp1252  Windows-1252, 1252  Западно-европейская кодировка, применяемая в Windows.
KOI8-R  koi8-ru, koi8r  Русская кодировка.
BIG5  950 Традиционный китайский, применяется в основном на Тайване.
GB2312  936 Упрощенный китайский, стандартная национальная кодировка.
BIG5-HKSCS    Расширенная Big5, применяемая в Гонг-Конге.
Shift_JIS SJIS, SJIS-win, cp932, 932  Японская кодировка.
EUC-JP  EUCJP, eucJP-win  Японская кодировка.
MacRoman    Кодировка, используемая в Mac OS.
''    Пустая строка активирует режим определения кодировки из файла скрипта (Zend multibyte), default_charset и текущей локали (см. nl_langinfo() и setlocale()), в указанном порядке. Не рекомендуется к использованию.


double_encode
Если параметр double_encode выключен, то PHP не будет преобразовывать существующие html-сущности. По умолчанию преобразуется все без ограничений.

Возвращаемые значения 

Преобразованная строка (string).

Если входная строка string содержит неверную последовательность символов в указанной кодировке encoding, то будет возвращаться пустая строка в случае, если флаги ENT_IGNORE или ENT_SUBSTITUTE не установлены.



    // Если запрос пустой, то возвращаем соответствующее сообщение пользователю. Если запрос не пустой, проверяем его на размер.
    
    if (!empty($query)) 
    { 
      // Если поисковый запрос имеет длину менее 3 или более 128 символов, также выводим соответствующие сообщения пользователю. 

        if (strlen($query) < 3) {
            $text = '<p>Слишком короткий поисковый запрос.</p>';
            echo $text;
        } else if (strlen($query) > 128) {
            $text = '<p>Слишком длинный поисковый запрос.</p>';
            echo $text;
        } 

        // Иначе, выполняем запрос к базе данных, который делает выборку идентификатора страницы, ее заголовка, описания.
        else { 
        
        $q = "SELECT * FROM blog_posts WHERE description LIKE ? OR title LIKE ? OR content LIKE ?";
        
        $params = array("%$query%", "%$query%", "%$query%");
        $stmt = $db->prepare($q);
        $stmt->execute($params);
        
        if ($stmt->rowCount() > 0) { 
                $text = '<p>По запросу <b>'.$query.'</b> найдено совпадений: '.$stmt->rowCount().'</p>';
                echo $text;

                while($row = $stmt->fetch()){

                    $stmt1 = $db->prepare('SELECT * FROM blog_posts WHERE id = :postID');
                    $stmt1->execute(array(
                        ':postID' => $row['id']
                    ));

                    $row1 = $stmt1->fetch();

                    echo '<h1><a href="'.$row1['slug'].'">'.$row1['title'].'</a></h1>';
                } 
            } else {
                $text = '<p>По вашему запросу ничего не найдено.</p>';
            }
        } 
    } else {
        $text = '<p>Задан пустой поисковый запрос.</p>';
    }


    ?>
         </article>


        <aside id="sidebar" class="sidebar col-4">
          <article>
            <?php require('sidebar.php'); ?>
          </article>
        </aside>
        </section>
        </main>
        
    <?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>



Обработка строки

Порезать строку.

    $query = substr($query, 0, 64);

64 символа пользователю будет достаточно для поиска. 

все "ненормальные" символы.

    $query = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $query);

нельзя давать пользователю возможности искать по слишком коротким словам - кроме всего прочего, это сильно загружает сервер. Итак, разрешим искать только по словам, которые длиннее двух букв (если ограничение больше, надо заменить "{1,2}" на "{1, кол-во символов}").

    $good = trim(preg_replace("/\s(\S{1,2})\s/", " ", ereg_replace(" +", "  "," $query ")));

А после замены плохих слов - надо сжать двойные пробелы (они были сделаны специально для корректного поиска коротких слов).

    $good = ereg_eplace(" +", " ", $good);


Подсветка

Чтобы подсвечивать светом или жирным шрифтом искомые слова в тексте, надо сделать следующее:

$highlight = str_replace(" ", "|", $good);

Пробелы достаточно заменить на вертикальную черту - разделитель вариантов в регулярных выражениях. "Плохие" слова мы не подсвечиваем, потому что в базе их не ищем. В коде, который выводит текст пишем:

      $row["text"] = ereg_replace($highlight, "<font color=#cc0000>\\0</font>", $row["text"]);

в тексте встречаются теги HTML:

      $text = eregi_replace(">([^<]*)($words)", ">\\1<font color=#cc0000>\\2</font>", $text);

Применяя такие приемы, можно, во-первых, ограничить свободу действий пользователя и не дать ему 
а) узнать программную структуру сайта 
б) вызвать перегрузку сервера (например, отправив мегабайт текста, состоящего из слов длиной в три буквы, чтобы скрипт 250 тысяч раз лазил в базу) 
в) увидеть сообщение об ошибке в результате попадания в строку спецсимволов языка запросов. 

class.paginator.php
-------------------

      <?php
      /*
       * PHP Pagination Class
       */
      class Paginator{

              /**
         * set the number of items per page.
         *
         * @var numeric
        */
        private $_perPage;

        /**
         * set get parameter for fetching the page number
         *
         * @var string
        */
        private $_instance;

        /**
         * sets the page number.
         *
         * @var numeric
        */
        private $_page;

        /**
         * set the limit for the data source
         *
         * @var string
        */
        private $_limit;

        /**
         * set the total number of records/items.
         *
         * @var numeric
        */
        private $_totalRows = 0;



        /**
         *  __construct
         *  
         *  pass values when class is istantiated 
         *  
         * @param numeric  $_perPage  sets the number of iteems per page
         * @param numeric  $_instance sets the instance for the GET parameter
         */
        public function __construct($perPage,$instance){
          $this->_instance = $instance;   
          $this->_perPage = $perPage;
          $this->set_instance();    
        }

        /**
         * get_start
         *
         * creates the starting point for limiting the dataset
         * @return numeric
        */
        private function get_start(){
          return ($this->_page * $this->_perPage) - $this->_perPage;
        }

        /**
         * set_instance
         * 
         * sets the instance parameter, if numeric value is 0 then set to 1
         *
         * @var numeric
        */
        private function set_instance(){
          $this->_page = (int) (!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]); 
          $this->_page = ($this->_page == 0 ? 1 : $this->_page);
        }

        /**
         * set_total
         *
         * collect a numberic value and assigns it to the totalRows
         *
         * @var numeric
        */
        public function set_total($_totalRows){
          $this->_totalRows = $_totalRows;
        }

        /**
         * get_limit
         *
         * returns the limit for the data source, calling the get_start method and passing in the number of items perp page
         * 
         * @return string
        */
        public function get_limit(){
                return "LIMIT ".$this->get_start().",$this->_perPage";
              }

              /**
               * page_links
               *
               * create the html links for navigating through the dataset
               * 
               * @var sting $path optionally set the path for the link
               * @var sting $ext optionally pass in extra parameters to the GET
               * @return string returns the html menu
              */
        public function page_links($path='?',$ext=null)
        {
            $adjacents = "2";
            $prev = $this->_page - 1;
            $next = $this->_page + 1;
            $lastpage = ceil($this->_totalRows/$this->_perPage);
            $lpm1 = $lastpage - 1;

            $pagination = "";
          if($lastpage > 1)
          {   
              $pagination .= "<div class='pagination'>";
          if ($this->_page > 1)
              $pagination.= "<a href='".$path."$this->_instance=$prev"."$ext'>« previous</a>";
          else
              $pagination.= "<span class='disabled'>« previous</span>";   

          if ($lastpage < 7 + ($adjacents * 2))
          {   
          for ($counter = 1; $counter <= $lastpage; $counter++)
          {
          if ($counter == $this->_page)
              $pagination.= "<span class='current'>$counter</span>";
          else
              $pagination.= "<a href='".$path."$this->_instance=$counter"."$ext'>$counter</a>";                   
          }
          }
          elseif($lastpage > 5 + ($adjacents * 2))
          {
          if($this->_page < 1 + ($adjacents * 2))       
          {
          for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
          {
          if ($counter == $this->_page)
              $pagination.= "<span class='current'>$counter</span>";
          else
              $pagination.= "<a href='".$path."$this->_instance=$counter"."$ext'>$counter</a>";                   
          }
              $pagination.= "...";
              $pagination.= "<a href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a>";
              $pagination.= "<a href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a>";       
          }
          elseif($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2))
          {
              $pagination.= "<a href='".$path."$this->_instance=1"."$ext'>1</a>";
              $pagination.= "<a href='".$path."$this->_instance=2"."$ext'>2</a>";
              $pagination.= "...";
          for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++)
          {
          if ($counter == $this->_page)
              $pagination.= "<span class='current'>$counter</span>";
          else
              $pagination.= "<a href='".$path."$this->_instance=$counter"."$ext'>$counter</a>";                   
          }
              $pagination.= "..";
              $pagination.= "<a href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a>";
              $pagination.= "<a href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a>";       
          }
          else
          {
              $pagination.= "<a href='".$path."$this->_instance=1"."$ext'>1</a>";
              $pagination.= "<a href='".$path."$this->_instance=2"."$ext'>2</a>";
              $pagination.= "..";
          for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
          {
          if ($counter == $this->_page)
              $pagination.= "<span class='current'>$counter</span>";
          else
              $pagination.= "<a href='".$path."$this->_instance=$counter"."$ext'>$counter</a>";                   
          }
          }
          }

          if ($this->_page < $counter - 1)
              $pagination.= "<a href='".$path."$this->_instance=$next"."$ext'>next »</a>";
          else
              $pagination.= "<span class='disabled'>next »</span>";
              $pagination.= "</div>\n";       
          }


        return $pagination;
        }
      }


index.php
---------
       <?php
        try {

          $pages = new Paginator('1','p');

          $stmt = $db->query('SELECT id FROM blog_posts');

          //pass number of records to
          $pages->set_total($stmt->rowCount());

          $stmt = $db->query('SELECT id, title, slug, description, created FROM blog_posts ORDER BY id DESC'.$pages->get_limit());

          while($row = $stmt->fetch()){



          }
          echo $pages->page_links();

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
      ?>



css
----

        /* PAGINATION */

      .pagination {
          clear: both;
          padding-bottom: 10px;
          padding-top: 10px;
      }
      .pagination a {
          border: 1px solid #D5D5D5;
          color: #666666;
          font-size: 11px;
          font-weight: bold;
          height: 25px;
          padding: 4px 8px;
          text-decoration: none;
        margin:2px;
      }
      .pagination a:hover, .pagination a:active {
          background:#efefef;
      }
      .pagination span.current {
          background-color: #687282;
          border: 1px solid #D5D5D5;
          color: #ffffff;
          font-size: 11px;
          font-weight: bold;
          height: 25px;
          padding: 4px 8px;
          text-decoration: none;
              margin:2px;
      }
      .pagination span.disabled {
          border: 1px solid #EEEEEE;
          color: #DDDDDD;
          margin: 2px;
          padding: 2px 5px;
      }

Archives.Php
------------

try {

          $pages = new Paginator('5','p');
          $month = $_GET['month'];
          $year = $_GET['year'];

          //set from and to dates
          $from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
          $to = date('Y-m-31 23:59:59', strtotime("$year-$month"));


                    //pass number of records to
                    $pages->set_total($stmt->rowCount());

          $stmt = $db->prepare('SELECT * FROM blog_posts WHERE created >= :from AND created <= :to ORDER BY id DESC '.$pages->get_limit());
          $stmt->execute(array(
            ':from' => $from,
            ':to' => $to
          ));


        echo $pages->page_links("a-$month-$year&");

Catpost.Php
-----------
    try {

        $pages = new Paginator('1','p');
        $stmt = $db->prepare('SELECT blog_posts.id FROM blog_posts, blog_post_cats WHERE blog_posts.id = blog_post_cats.postID AND blog_post_cats.catID = :catID');
        $stmt->execute(array(':catID' => $row['catID']));

        //pass number of records to
        $pages->set_total($stmt->rowCount());

        $stmt = $db->prepare('
          SELECT 
            *
          FROM 
            blog_posts,
            blog_post_cats
          WHERE
             blog_posts.id = blog_post_cats.postID
             AND blog_post_cats.catID = :catID
          ORDER BY 
            created DESC 
          '.$pages->get_limit());
          );


          echo $pages->page_links('c-'.$_GET['id'].'&');