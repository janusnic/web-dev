# web-dev unit_11

PDOStatement::fetch
===================
PDOStatement::fetch — Извлечение следующей строки из результирующего набора

Извлекает следующую строку из результирующего набора объекта PDOStatement. Параметр fetch_style определяет, в каком виде PDO вернет эту строку.

Список параметров 
-----------------

fetch_style
Определяет, в каком виде следующая строка будет возвращена в вызывающий метод. Это может быть одна из констант PDO::FETCH_*. По умолчанию PDO::ATTR_DEFAULT_FETCH_MODE (что равносильно PDO::FETCH_BOTH).

PDO константы выборки данных
----------------------------
postauthoriconАвтор: Administrator
Устанавливают режим выборки значений из результата запроса. Указываются, как правило, в методах PDOStatement::fetchAll() и PDOStatement::fetch(). Или можно раз, и надолго установить режим выборки таким образом:

PDOStatement->setFetchMode(PDO::FETCH_ASSOC);

И после, (за исключением особых случаев) вызывать методы PDOStatement::fetchAll() и PDOStatement::fetch() уже без параметров.

PDO::FETCH_ASSOC
----------------
PDO::FETCH_ASSOC: возвращает массив, индексированный именами столбцов результирующего набора

Определяет, что метод fetch должен возвратить каждую строку как ассоциативный массив, имена ключей массива будут соответствовать именам столбцов в наборе результата. Если набор результатов содержит несколько столбцов с одним и тем же именем, PDO::FETCH_ASSOC выберет из задвоенных столбцов результат последнего из них.

    SELECT
     `id`, `city`, `country_id`, CONCAT(city,country_id) AS `city`
    FROM
     `gp_cities`
Результат:

     Array
     (
        [id] => 199185
        [city] => Абердин (аэропорт)11488
        [country_id] => 11488
     )



PDO::FETCH_BOTH
---------------
(по умолчанию): возвращает массив, индексированный именами столбцов результирующего набора, а также их номерами (начиная с 0)

Гибрид PDO::FETCH_ASSOC и PDO::FETCH_NUM Результирующий массив будет смешанным (индексы + именованные ключи). Причем индексная часть будет содержать значения всех столбцов выборки даже с задвоенными именами, а ассоциативная часть выберет из задвоенных столбцов результат последнего из них.

      "SELECT
       `id`, `city`, `country_id`, CONCAT(city,country_id) AS `city`
      FROM
       `gp_cities`"
Результат:
 
      Array
     (
        [id] => 199185
        [0] => 199185
        [city] => Абердин (аэропорт)11488
        [1] => Абердин (аэропорт)
        [country_id] => 11488
        [2] => 11488
        [3] => Абердин (аэропорт)11488
     )


PDO::FETCH_BOUND
----------------
возвращает TRUE и присваивает значения столбцов результирующего набора переменным PHP, которые были привязаны к этим столбцам методом PDOStatement::bindColumn()

Определяет, что метод fetch должен возвратить TRUE и назначить значения столбцов в наборе результатов к переменным PHP, с которыми они были связаны при помощи PDOStatement::bindParam() или PDOStatement::bindColumn() методов:

    $sql = 'SELECT id,city,country_id FROM gp_cities LIMIT 0,5';
     
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
     
    $stmt->bindColumn(1, $city);
    $stmt->bindColumn(2, $country_id);
     
    while( $stmt->fetch( PDO::FETCH_BOUND ))
    {
      echo "city = ".$city.";\t country_id=".$country_id."<br />";
    }
Результат:
      city = 199185;  country_id=Абердин (аэропорт)
      city = 166961;  country_id=Авалон (Аэропорт)
      city = 198410;  country_id=Авока Бич
      city = 942;           country_id=Аделаида
      city = 198234;  country_id=Айвенго

PDO::FETCH_COLUMN 
-----------------
Определяет, что метод fetch должен возвратить только единственный запрашиваемый столбец из следующей строки в наборе результатов. Ещё так же можно указать номер столбца:

    $sql = 'SELECT 
              `id`, `city`, `country_id`, CONCAT(city,country_id) AS `city` 
             FROM
              `gp_cities` 
             LIMIT 
              0,5';
     
    echo '<pre>';
    print_r( $dbh->query($sql)->fetchAll(PDO::FETCH_COLUMN,3) );
    echo '</pre>';
Результат:

     Array
     (
        [0] => Абердин (аэропорт)11488
        [1] => Авалон (Аэропорт)934
        [2] => Авока Бич934
        [3] => Аделаида934
        [4] => Айвенго934
     )


PDO::FETCH_CLASS
----------------
создает и возвращает объект запрошенного класса, присваивая значения столбцов результирующего набора именованным свойствам класса. Если fetch_style включает в себя атрибут 
PDO::FETCH_CLASSTYPE (например, PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE), то имя класса, от которого нужно создать объект, будет взято из первого столбца.

Определяет, что fetch - метод должен возвратить новый экземпляр запрашиваемого класса, проецируя столбцы на соответствующие (их именам) свойства в классе.

если свойство не существует, в запрашиваемом классе будет вызван магический метод __set(). В конструктор создаваемого объекта, можно передавать параметры в виде массива:
 
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'SomeClass',array('republic'));

Пример:

      $sql = 'SELECT `id`, `city`, `country_id` FROM gp_cities LIMIT 2';
      $stmt = $dbh->query($sql); 
       
      class SomeClass
      {     
        private $id;
        private $city;
        private $country_id;
        private $status;        
        static  $count = NULL;
       
        public function __construct($status = '')
        {
            self::$count ++;
            $this->status = $status;
        }
      }    
      // «SomeClass»  строка-имя класса, чьи объекты будут создаваться: 
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'SomeClass', array('republic'));
       
      echo '<pre>';
      print_r( $stmt->fetchAll() );
      echo '</pre>';
      echo SomeClass::$count;

Результат:

     Array
     (
        [0] => SomeClass Object
            (
                [id:private] => 199185
                [city:private] => Абердин (аэропорт)
                [country_id:private] => 11488
                [status:private] => republic
            )

        [1] => SomeClass Object
            (
                [id:private] => 166961
                [city:private] => Авалон (Аэропорт)
                [country_id:private] => 934
                [status:private] => republic
            )
     )


PDO::FETCH_FUNC
---------------
Работает только с методом PDOStatement::fetchAll(), и устанавливается тоже только в нём. Возвращает результат через вызов указанной функции, используя столбцы каждой результирующей строки в качестве параметров вызываемой функции. Тут всё ясно из названия и примера:

      $sql = 'SELECT `id`, `city`, `country_id` FROM gp_cities LIMIT 2';        
       
      function callMe($id=0,$city=0,$country_id=0)
      {
        // Здесь можно похимичить с входными данными...
        // Ну, а множественное значение можно вернуть, к примеру
        // массивом:
        return array($id.'+++', $city.'***', $country_id.'###');
      }    
       
      $stmt = $dbh->query($sql);
      $res = $stmt->fetchAll(PDO::FETCH_FUNC, callMe);
       
      echo '<pre>';
      print_r( $res );
      echo '</pre>';
Результат:

     Array
     (
        [0] => Array
            (
                [0] => 199185+++
                [1] => Абердин (аэропорт)***
                [2] => 11488###
            )

        [1] => Array
            (
                [0] => 166961+++
                [1] => Авалон (Аэропорт)***
                [2] => 934###
            )
     )

PDO::FETCH_GROUP
----------------
Возвращает массив значений, сгруппированных по значению определённого столбца результирующей строки. Есть смысл использовать с другими константами, указывая их через побитовое «или»:

    $sql = 'SELECT 
              `cit`.`id`, `cit`.`city`, `cit`.`country_id`, `cnt`.`country`
            FROM 
              `gp_countries` AS `cnt`                 
            INNER JOIN 
              `gp_cities` AS `cit` 
            ON 
              `cit`.`country_id` = `cnt`.`id`';       
     
    $stmt = $dbh->query($sql);
    $res = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);
     
    echo '<pre>';
    print_r( $res );
    echo '</pre>';
Результат:

     Array
     (
        [198471] => Array
            (
                [0] => Array
                    (
                        [city] => Яррагон
                        [country_id] => 934
                        [country] => Австралия
                    )
            )

        [184033] => Array
            (
                [0] => Array
                    (
                        [city] => Аберзее
                        [country_id] => 700
                        [country] => Австрия
                    )
            )
         ...
     )

лучше сделать это средствами SQL:
---------------------------------
    'SELECT 
      `cit`.`id`, `cit`.`city`, `cit`.`country_id`, `cnt`.`country`
    FROM 
      `gp_countries` AS `cnt`                 
    INNER JOIN 
      `gp_cities` AS `cit` 
    ON 
      `cit`.`country_id` = `cnt`.`id`
    GROUP BY
      `cit`.`country_id`'


PDO::FETCH_INTO
----------------
обновляет существующий объект запрошенного класса, присваивая значения столбцов результирующего набора именованным свойствам объекта

Определяет, что метод fetch должен обновить существующий экземпляр запрашиваемого класса, проецируя столбцы на соответствующие свойства в классе.

это примерно, то же, что и PDO::FETCH_CLASS за исключением мелких деталей:

    $sql = 'SELECT `id`, `city`, `country_id` FROM gp_cities LIMIT 2';        
     
    class SomeClass
    {     
      public $id;
      public $city;
      public $country_id;
      public $status;
     
      public function __construct($status = '')
      {
        $this->status = $status;
      }
    }
    $stmt = $dbh->query($sql);
    // Параметры передаются в конструктор напрямую:
    $stmt->setFetchMode(PDO::FETCH_INTO, new SomeClass('federation')); 
    // Теперь проходим циклом по самому PDOStatement, минуя вызов метода
    // PDOStatement->fetch() или PDOStatement->fetchAll()
    foreach($stmt AS $some_obj)
    {
      echo '<pre>';
      var_dump( $some_obj );
      echo '</pre>';    
    }
Результат возвращается в виде отдельного объекта:

     SomeClass Object
     (
        [id] => 199185
        [city] => Абердин (аэропорт)
        [country_id] => 11488
        [status] => federation
     )
     SomeClass Object
     (
        [id] => 166961
        [city] => Авалон (Аэропорт)
        [country_id] => 934
        [status] => federation
     )


PDO::FETCH_LAZY
---------------
комбинирует PDO::FETCH_BOTH и PDO::FETCH_OBJ, создавая новый объект со свойствами, соответствующими именам столбцов результирующего набора

Определяет, что метод fetch должен возвратить каждую строку как объект с именами переменных, которые соответствуют именам столбцов, возвращенным в наборе результатов. PDO:: FETCH_LAZY создает свойства объекта, соответствующие именам столбцов выборки. Не может использоваться с методом PDOStatement::fetchAll(). Так же добавляет в результирующий объект свойство queryString – которое содержит строку запроса:
Трассировка результирующего объекта запроса :

    SELECT
     `id`, `city`, `country_id`, CONCAT(city,country_id) AS `city`
    FROM
     `gp_cities`
- здесь и далее будет использоваться этот же запрос, в нём умышленно задвоены результирующие столбцы ` city ` .

Результат:


     PDORow Object
     (
        [queryString] => SELECT id,city,country_id, CONCAT(city,country_id) AS city FROM gp_cities LIMIT 0,10
        [id] => 199185
        [city] => Абердин (аэропорт)11488
        [country_id] => 11488
     )


PDO::FETCH_NAMED
----------------
возвращает массив такого же вида, как и PDO::FETCH_ASSOC, но, если есть несколько полей с одинаковым именем, то значением с этим ключом будет массив со всеми значениями из рядов, в которых это поле указано.

Тоже что и PDO::FETCH_ASSOC

PDO::FETCH_NUM 
--------------
Тоже что и PDO::FETCH_ASSOC только возвращённый массив будет индексный.
возвращает массив, индексированный номерами столбцов (начиная с 0)
      SELECT
        `id`, `city`, `country_id`, CONCAT(city,country_id) AS `city`
      FROM
        `gp_cities`
Результат:

      Array
     (
        [0] => 199185
        [1] => Абердин (аэропорт)
        [2] => 11488
        [3] => Абердин (аэропорт)11488
     )


PDO::FETCH_OBJ
создает анонимный объект со свойствами, соответствующими именам столбцов результирующего набора

Определяет, что метод fetch должен возвратить каждую строку как объект с именами свойств, которые соответствуют именам столбцов, возвращенным в наборе результатов. В случае с применением PDOStatement::fetchAll() – вернёт массив объектов.
Результат:
 
      Array
     (
        [0] => stdClass Object
            (
                [id] => 199185
                [city] => Абердин (аэропорт)11488
                [country_id] => 11488
            )

        [1] => stdClass Object
            (
                [id] => 166961
                [city] => Авалон (Аэропорт)934
                [country_id] => 934
            )
        ...
     }

PDO::FETCH_UNIQUE
-----------------
Позволяет получить только уникальные значения из результирующего набора данных. Может работать в паре с другими константами через побитовое "или". Ещё один, на мой взгляд, избыточный функционал: на хрена гонять трафик, если можно отсеять данные ещё на этапе запроса: "SELECT DISTINCT …"

PDO::FETCH_KEY_PAIR
-------------------
Выдает результат запроса в виде массива, где 1-ый столбец - ключ второй является значением. Как следствие требование: sql–запрос должен возвращать два столбца в ответе:

    $sql = 'SELECT `id`, `city` FROM `gp_cities` ORDER BY city DESC';
     
    $stmt = $dbh->query($sql);
     
    echo '<pre>';
    print_r($stmt->fetchAll(PDO::FETCH_KEY_PAIR));
    echo '</pre>';
Результат:

     Array
     (
        [174853] => Яффа
        [145423] => Яунде
        [167845] => Ятелей
        ...
     )

Иначе, если столбца не два: General error: PDO::FETCH_KEY_PAIR fetch mode requires the result set to contain extactly 2 columns

PDO:: FETCH_CLASSTYPE
---------------------
Возвращает объекты класса, имя которого соответствует имени первого столбца результирующей строки. Это в теории. На деле же, если использовать её отдельно – возвращает смешанный массив, если совместно: PDO::FETCH_CLASS|PDO::FETCH_CLASSTYPE То возвращает объекты StdClass… Ещё народ пишет, что устанавливать значения можно только непосредственно в методах получения: PDOStatement::fetchAll() и PDOStatement::fetch(). А у меня так и не получилось создать объекты того класса, которого хотелось… В общем: хотели как лучше, получилось как всегда.

PDO::FETCH_SERIALIZE 
--------------------
Тоже что и PDO:: FETCH_INTO, но возвращаемые объекты представляются в виде сериализованной строки. От этой штуки я так и не получил адекватного результата, по ходу она глючит, так как на сайте php сообщается о каких то найденных багах… в общем следующий код:

    class myclass
    {
      public $id = '';
      public $foo = '';
      public $bar = '';
     
      public function __construct($a,$b,$c)
      {
        $this->id = $a;
        $this->foo = $b;
        $this->bar = $c;
        printf("%s()\n", __METHOD__);
      }
      public function __sleep()
      {
        printf("%s()\n", __METHOD__);
        return array_keys(get_class_vars(__CLASS__));
      }
      public function __wakeup()
      {
        printf("%s()\n", __METHOD__);
        return "any data from unserialize()";
      }
    }
    // Проверка возможности сериализации
    echo '<pre>';
    $obj1 = new myclass('one','two','three');
    $tmp  = serialize($obj1);
    echo $tmp;
    $obj2 = unserialize($tmp);
    print_r($obj2);
    echo '</pre>';
     
    $stmt = $dbh->query("SELECT city,id,country_id FROM `gp_cities`");
    $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_SERIALIZE, "myclass", array('one','two','three'));

Выдаёт следующее:

  myclass::__construct()
  myclass::__sleep()
  O:7:"myclass":3:{s:2:"id";s:3:"one";s:3:"foo";s:3:"two";s:3:"bar";s:5:"three";}myclass::__wakeup()
  myclass Object
  (
    [id] => one
    [foo] => two
    [bar] => three
  )
  myclass::__construct() SQLSTATE[HY000]: General error: cannot unserialize class

То есть стандартные функции: serialize() unserialize() отрабатывают нормально, а PDO::FETCH_SERIALIZE с какого то, не может восстановить объект, к тому же спрашивается на хрена его восстанавливать, если указано, что возвращается строка? Да к тому же зачем то вызывается конструктор. В общем проходим мимо :)

PDO::FETCH_PROPS_LATE
---------------------
Используется, как правило в качестве дополнения: PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE Сообщает, что сначала нужно вызвать конструктор, а потом уже присвоить значения свойствам. То есть, если в конструкторе данные модифицируются, то при указании этой константы изменения в конструкторе пролетают мимо.
PDO::FETCH_ORI_NEXT
-------------------
Получает следующую строку в наборе результатов. Работает только с прокручиваемыми курсорами.
PDO::FETCH_ORI_PRIOR
--------------------
Получает предыдущую строку в наборе результатов. Работает только с прокручиваемыми курсорами.
PDO::FETCH_ORI_FIRST
--------------------
Получает первую строку в наборе результатов Работает только с прокручиваемыми курсорами.
PDO::FETCH_ORI_LAST
-------------------
Получает последнюю строку в наборе результатов. Работает только с прокручиваемыми курсорами.
PDO::FETCH_ORI_ABS
------------------
Получает запрашиваемую строку номером ряда из набора результатов. Работает только с прокручиваемыми курсорами.
PDO::FETCH_ORI_REL
------------------
Получает запрашиваемую строку с относительным положением от настоящего положения курсора в наборе результатов. Работает только с прокручиваемыми курсорами.

    $sql = 'SELECT * FROM `gp_cities` ORDER BY city DESC';
     
    $stmt = $dbh->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     
    $stmt->execute();
     
    while($row1 = $stmt->fetch(PDO::FETCH_OBJ, PDO::FETCH_ORI_NEXT) )
    {
      print_r($row1);
    }

cursor_orientation
------------------
Для объектов PDOStatement представляющих прокручиваемый курсор, этот параметр определяет, какая строка будет возвращаться в вызывающий метод. Значением параметра должна быть одна из констант PDO::FETCH_ORI_*, по умолчанию PDO::FETCH_ORI_NEXT. Чтобы запросить прокручиваемый курсор для запроса PDOStatement, необходимо задать атрибут PDO::ATTR_CURSOR со значением PDO::CURSOR_SCROLL во время подготовки запроса методом PDO::prepare().

offset
------
Для объектов PDOStatement, представляющих прокручиваемый курсор, параметр cursor_orientation которых принимает значение PDO::FETCH_ORI_ABS, эта величина означает абсолютный номер строки, которую необходимо извлечь из результирующего набора.

Для объектов PDOStatement, представляющих прокручиваемый курсор, параметр cursor_orientation которых принимает значение PDO::FETCH_ORI_REL, эта величина указывает, какая строка относительно текущего положения курсора будет извлечена функцией PDOStatement::fetch().

Возвращаемые значения 
---------------------
В случае успешного выполнения функции возвращаемое значение зависит от режима выборки. В случае неудачи, функция всегда возвращает FALSE.


Извлечение строк в разных режимах выборки
-----------------------------------------
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
------------------------------------------------
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


PDOStatement::fetchAll
======================
PDOStatement::fetchAll — Возвращает массив, содержащий все строки результирующего набора

Список параметров 
-----------------
fetch_style
Определяет содержимое возвращаемого массива. Подробней можно узнать из документации к методу PDOStatement::fetch(). По умолчанию параметр принимает значение PDO::ATTR_DEFAULT_FETCH_MODE (которое в свою очередь имеет умолчание PDO::FETCH_BOTH)

Чтобы извлечь значения только одного столбца, передайте в качестве значения этого параметра константу PDO::FETCH_COLUMN. С помощью параметра column-index можно задать столбец, из которого требуется извлечь данные.

Если требуется извлечь только уникальные строки одного столбца, нужно передать побитовое ИЛИ констант PDO::FETCH_COLUMN и PDO::FETCH_UNIQUE.

Чтобы получить ассоциативный массив строк сгруппированный по значениям определенного столбца, нужно передать побитовое ИЛИ констант PDO::FETCH_COLUMN и PDO::FETCH_GROUP.

fetch_argument
Смысл этого аргумента зависит от значения параметра fetch_style:

PDO::FETCH_COLUMN: Будет возвращен указанный столбец. Индексация столбцов начинается с 0.

PDO::FETCH_CLASS: Будет создан и возвращен новый объект указанного класса. Свойствам объекта будут присвоены значения столбцов, имена которых совпадут с именами свойств.

PDO::FETCH_FUNC: Будут возвращены результаты вызовов указанной функции. Данные каждой строки результирующего набора будут передаваться в эту функцию.

ctor_args
Аргументы конструктора класса. Для случаев, когда параметру fetch_style присвоено значение PDO::FETCH_CLASS.

Возвращаемые значения
---------------------
PDOStatement::fetchAll() возвращает массив, содержащий все оставшиеся строки результирующего набора. Массив представляет каждую строку либо в виде массива значений одного столбца, либо в виде объекта, имена свойств которого совпадают с именами столбцов. В случае, если нет результатов, то будет возвращен пустой массив. В случае ошибки возвращается FALSE.

Использование этого метода для извлечения строк больших результирующих наборов может пагубно сказаться на производительности системы и сетевых ресурсов. Вместо извлечения всех данных и их обработки в PHP рекомендуется использовать встроенные средства СУБД. Например, использование выражений WHERE и ORDER BY языка SQL может уменьшить размеры результирующего набора.

Извлечение всех оставшихся строк результирующего набора

    <?php
    $sth = $dbh->prepare("SELECT name, colour FROM fruit");
    $sth->execute();

    /* Извлечение всех оставшихся строк результирующего набора */
    print("Извлечение всех оставшихся строк результирующего набора:\n");
    $result = $sth->fetchAll();
    print_r($result);
    ?>

Извлечение всех оставшихся строк результирующего набора:
    Array
    (
        [0] => Array
            (
                [NAME] => pear
                [0] => pear
                [COLOUR] => green
                [1] => green
            )

        [1] => Array
            (
                [NAME] => watermelon
                [0] => watermelon
                [COLOUR] => pink
                [1] => pink
            )

    )

Извлечение всех значений одного столбца результирующего набора

В следующем примере показано, как извлечь из результирующего набора значения только одного столбца, даже если строки содержат значения нескольких столбцов.

    <?php
    $sth = $dbh->prepare("SELECT name, colour FROM fruit");
    $sth->execute();

    /* Извлечение всех значений первого столбца */
    $result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
    var_dump($result);
    ?>
Результатом выполнения данного примера будет что-то подобное:

    Array(3)
    (
        [0] =>
        string(5) => apple
        [1] =>
        string(4) => pear
        [2] =>
        string(10) => watermelon
    )

Группировка строк по значениям одного столбца

В следующем примере показано, как получить ассоциативный массив строк результирующего набора, сгруппированных по значениям указанного столбца. Массив содержит три ключа: значения apple и pear являются массивами, содержащими два разных цвета; в тоже время watermelon будет массивом, содержащим только один цвет.

    <?php
    $insert = $dbh->prepare("INSERT INTO fruit(name, colour) VALUES (?, ?)");
    $insert->execute(array('apple', 'green'));
    $insert->execute(array('pear', 'yellow'));

    $sth = $dbh->prepare("SELECT name, colour FROM fruit");
    $sth->execute();

    /* Группируем записи по значениям первого столбца */
    var_dump($sth->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP));
    ?>
Результатом выполнения данного примера будет что-то подобное:

    array(3) {
      ["apple"]=>
      array(2) {
        [0]=>
        string(5) "green"
        [1]=>
        string(3) "red"
      }
      ["pear"]=>
      array(2) {
        [0]=>
        string(5) "green"
        [1]=>
        string(6) "yellow"
      }
      ["watermelon"]=>
      array(1) {
        [0]=>
        string(5) "green"
      }
    }


Создание объекта для каждой строки

В следующем примере показано поведение метода в режиме выборки PDO::FETCH_CLASS.

    <?php
    class fruit {
        public $name;
        public $colour;
    }

    $sth = $dbh->prepare("SELECT name, colour FROM fruit");
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_CLASS, "fruit");
    var_dump($result);
    ?>
Результатом выполнения данного примера будет что-то подобное:

    array(3) {
      [0]=>
      object(fruit)#1 (2) {
        ["name"]=>
        string(5) "apple"
        ["colour"]=>
        string(5) "green"
      }
      [1]=>
      object(fruit)#2 (2) {
        ["name"]=>
        string(4) "pear"
        ["colour"]=>
        string(6) "yellow"
      }
      [2]=>
      object(fruit)#3 (2) {
        ["name"]=>
        string(10) "watermelon"
        ["colour"]=>
        string(4) "pink"
      }
    }

Вызов функции для каждой строки

В следующем примере показано поведение метода в режиме выборки PDO::FETCH_FUNC.

    <?php
    function fruit($name, $colour) {
        return "{$name}: {$colour}";
    }

    $sth = $dbh->prepare("SELECT name, colour FROM fruit");
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_FUNC, "fruit");
    var_dump($result);
    ?>
Результатом выполнения данного примера будет что-то подобное:

    array(3) {
      [0]=>
      string(12) "apple: green"
      [1]=>
      string(12) "pear: yellow"
      [2]=>
      string(16) "watermelon: pink"
    }


index.php
----------
        try {

          $stmt = $db->query('SELECT id, title, description, created FROM blog_posts ORDER BY id DESC');

          while($row = $stmt->fetch()){
            
              echo '<h2><a href="view.php?id='.$row['id'].'">'.$row['title'].'</a></h2>';
              echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created'])).' in ';

              $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                $stmt2->execute(array(':postID' => $row['id']));

                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($catRow as $cat)
                {
                    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                }
                echo implode(", ", $links);
                echo '</p>';
              echo '<p>'.$row['description'].'</p>';       
              echo '<p><a href="view.php?id='.$row['id'].'">Read More</a></p>';       
    
          }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }


.htaccess
---------
    RewriteEngine On
    RewriteBase /

    RewriteRule ^c-(.*)$ catpost.php?id=$1 [L]

catpost.php
-----------
    <?php

    require_once __DIR__.'/../bootstrap/app.php';
    require_once __DIR__.'/../resources/views/layouts/header.php';
    require_once __DIR__.'/../resources/views/layouts/nav.php';
    $stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
    $stmt->execute(array(':catSlug' => $_GET['id']));
    $row = $stmt->fetch();

    //if post does not exists redirect user.
    if($row['catID'] == ''){
      header('Location: ./');
      exit;
    }

    ?>
        <main>
        
    <section class="row border-top border-bottom">
       <article class="content col-8">

    <h1>Blog</h1>
    <p>Posts in <?php echo $row['catTitle'];?></p>
    <hr />
    <p><a href="./">Blog Index</a></p>

      <?php 
      try {

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
          ');
        $stmt->execute(array(':catID' => $row['catID']));
        while($row = $stmt->fetch()){
          
          echo '<div>';
            echo '<h1><a href="'.$row['slug'].'">'.$row['title'].'</a></h1>';
            echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created'])).' in ';

              $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
              $stmt2->execute(array(':postID' => $row['id']));

              $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

              $links = array();
              foreach ($catRow as $cat)
              {
                  $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
              }
              echo implode(", ", $links);

            echo '</p>';
            echo '<p>'.$row['description'].'</p>';        
            echo '<p><a href="'.$row['slug'].'">Read More</a></p>';       
          echo '</div>';

        }

      } catch(PDOException $e) {
          echo $e->getMessage();
      }

      ?>

     </article>

TABLE blog_posts
----------------
    CREATE TABLE IF NOT EXISTS `blog_posts` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) DEFAULT NULL,
      `slug` varchar(255) DEFAULT NULL,
      `description` text,
      `content` text,
      `created` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


.htaccess
---------
    RewriteEngine On
    RewriteBase /

    RewriteRule ^c-(.*)$ catpost.php?id=$1 [L]
    RewriteCond %{REQUEST_FILENAME} !-d [NC]
    RewriteCond %{REQUEST_FILENAME} !-f [NC]
    RewriteRule ^(.*)$ view.php?id=$1 [QSA,L]


view.php
---------
      $stmt = $db->prepare('SELECT id, title, content, created FROM blog_posts WHERE slug = :postSlug');
      $stmt->execute(array(':postSlug' => $_GET['id']));
      $row = $stmt->fetch();


index.php
---------
      <?php
        try {

          $stmt = $db->query('SELECT id, title, slug, description, created FROM blog_posts ORDER BY id DESC');

          while($row = $stmt->fetch()){
            
              echo '<h1><a href="'.$row['slug'].'">'.$row['postTitle'].'</a></h1>';
              
              echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created'])).' in ';

              $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                $stmt2->execute(array(':postID' => $row['id']));

                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($catRow as $cat)
                {
                    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                }
                echo implode(", ", $links);
                echo '</p>';
              echo '<p>'.$row['description'].'</p>';       
              echo '<p><a href="'.$row['slug'].'">Read More</a></p>';       


admin/add_post.php
------------------
          if(!isset($error)){

                  try {

                      $postSlug = slug($postTitle);
                      
                      //insert into database
                      $stmt = $db->prepare('INSERT INTO blog_posts (title,description,content,created) VALUES (:postTitle, :postSlug, :postDesc, :postCont, :postDate)') ;
                      $stmt->execute(array(
                          ':postTitle' => $title,
                          ':postSlug' => $postSlug,
                          ':postDesc' => $description,
                          ':postCont' => $content,
                          ':postDate' => date('Y-m-d H:i:s')
                      ));

                      //redirect to index page
                      header('Location: index.php?action=added');
                      exit;


sidebar.php
-----------

    <h1>Recent Posts</h1><hr />
    <ul>
    <?php
    $stmt = $db->query('SELECT title, slug FROM blog_posts ORDER BY id DESC LIMIT 5');
    while($row = $stmt->fetch()){
      echo '<li><a href="'.$row['slug'].'">'.$row['title'].'</a></li>';
    }?></ul>
    <h1>Catgories</h1>
    <hr />
    <ul>
    <?php
    $stmt = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
    while($row = $stmt->fetch()){
      echo '<li><a href="c-'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
    }?></ul>


date
====
date — Форматирует вывод системной даты/времени

Возвращает строку, отформатированную в соответствии с указанным шаблоном format. Используется метка времени, заданная аргументом timestamp, или текущее системное время, если timestamp не задан. Таким образом, timestamp является необязательным и по умолчанию равен значению, возвращаемому функцией time().

Список параметров 
-----------------
format
Шаблон результирующей строки (string) с датой. См. параметры форматирования ниже. Также существует несколько предопределенных констант даты/времени, которые могут быть использованы вместо этих параметров. Например: DATE_RSS заменяет шаблон 'D, d M Y H:i:s'.

В параметре format распознаются следующие символы
День  --- ---
---------------
    d День месяца, 2 цифры с ведущим нулём  от 01 до 31
    D Текстовое представление дня недели, 3 символа от Mon до Sun
    j День месяца без ведущего нуля от 1 до 31
    l (строчная 'L')  Полное наименование дня недели  от Sunday до Saturday
    N Порядковый номер дня недели в соответствии со стандартом ISO-8601 (добавлен в версии PHP 5.1.0) от 1 (понедельник) до 7 (воскресенье)
    S Английский суффикс порядкового числительного дня месяца, 2 символа  st, nd, rd или th. Применяется совместно с j
    w Порядковый номер дня недели от 0 (воскресенье) до 6 (суббота)
    z Порядковый номер дня в году (начиная с 0) От 0 до 365
Неделя  --- ---
----------------
    W Порядковый номер недели года в соответствии со стандартом ISO-8601; недели начинаются с понедельника (добавлено в версии PHP 4.1.0) Например: 42 (42-я неделя года)
Месяц --- ---
-------------
    F Полное наименование месяца, например January или March  от January до December
    m Порядковый номер месяца с ведущим нулём от 01 до 12
    M Сокращенное наименование месяца, 3 символа  от Jan до Dec
    n Порядковый номер месяца без ведущего нуля от 1 до 12
    t Количество дней в указанном месяце  от 28 до 31
Год --- ---
-----------
    L Признак високосного года  1, если год високосный, иначе 0.
    o Номер года в соответствии со стандартом ISO-8601. Имеет то же значение, что и Y, кроме случая, когда номер недели ISO (W) принадлежит предыдущему или следующему году; тогда будет использован год этой недели. (добавлен в версии PHP 5.1.0) Примеры: 1999 или 2003
    Y Порядковый номер года, 4 цифры  Примеры: 1999, 2003
    y Номер года, 2 цифры Примеры: 99, 03
Время --- ---
-------------
    a Ante meridiem (англ. "до полудня") или Post meridiem (англ. "после полудня") в нижнем регистре  am или pm
    A Ante meridiem или Post meridiem в верхнем регистре  AM или PM
    B Время в формате Интернет-времени (альтернативной системы отсчета времени суток) от 000 до 999
    g Часы в 12-часовом формате без ведущего нуля от 1 до 12
    G Часы в 24-часовом формате без ведущего нуля от 0 до 23
    h Часы в 12-часовом формате с ведущим нулём от 01 до 12
    H Часы в 24-часовом формате с ведущим нулём от 00 до 23
    i Минуты с ведущим нулём  от 00 до 59
    s Секунды с ведущим нулём от 00 до 59
    u Микросекунды (добавлено в версии PHP 5.2.2). Учтите, что date() всегда будет возвращать 000000, т.к. она принимает целочисленный (integer) параметр, тогда как DateTime::format() поддерживает микросекунды.  Например: 654321
Временная зона  --- ---
-----------------------
    e Код шкалы временной зоны(добавлен в версии PHP 5.1.0) Примеры: UTC, GMT, Atlantic/Azores
    I (заглавная i) Признак летнего времени 1, если дата соответствует летнему времени, 0 в противном случае.
    O Разница с временем по Гринвичу, в часах Например: +0200
    P Разница с временем по Гринвичу с двоеточием между часами и минутами (добавлено в версии PHP 5.1.3)  Например: +02:00
    T Аббревиатура временной зоны Примеры: EST, MDT ...
    Z Смещение временной зоны в секундах. Для временных зон, расположенных западнее UTC возвращаются отрицательные числа, а расположенных восточнее UTC - положительные.  от -43200 до 50400
Полная дата/время --- ---
-------------------------
    c Дата в формате стандарта ISO 8601 (добавлено в PHP 5) 2004-02-12T15:19:21+00:00
    r Дата в формате » RFC 2822 Например: Thu, 21 Dec 2000 16:01:07 +0200
    U Количество секунд, прошедших с начала Эпохи Unix (The Unix Epoch, 1 января 1970 00:00:00 GMT) 
Любые другие символы, встреченные в строке-шаблоне, будут выведены в результирующую строку без изменений. Z всегда возвращает 0 при использовании gmdate().

Поскольку рассматриваемая функция принимает в качестве параметра временные метки типа integer, форматирующий символ u будет полезен только при использовании функции date_format() и пользовательских меток времени, созданных с помощью функции date_create().
timestamp
Необязательный параметр timestamp представляет собой integer метку времени, по умолчанию равную текущему локальному времени, если timestamp не указан. Другими словами, значение по умолчанию равно результату функции time().

Возвращаемые значения 
---------------------
Возвращает отформатированную строку с датой. При передаче нечислового значения в качестве параметра timestamp будет возвращено FALSE и вызвана ошибка уровня E_WARNING.

Ошибки 
-------
Каждый вызов к функциям даты/времени при неправильных настройках временной зоны сгенерирует ошибку уровня E_NOTICE, и/или ошибку уровня E_STRICT или E_WARNING при использовании системных настроек или переменной окружения TZ. Смотрите также date_default_timezone_set()

MySQL MONTH() function
----------------------
    SELECT MONTH('2009-05-18');  
    Output
    mysql> SELECT MONTH('2009-05-18');
    +---------------------+
    | MONTH('2009-05-18') |
    +---------------------+
    |                   5 | 
    +---------------------+
    1 row in set (0.01 sec)

    SELECT MONTH(CURRENT_DATE());  
    Note : Since CURRENT_DATE() is used, your output may vary form the output shown.

    Output
    mysql> SELECT MONTH(CURRENT_DATE());
    +-----------------------+
    | MONTH(CURRENT_DATE()) |
    +-----------------------+
    |                     4 | 
    +-----------------------+
    1 row in set (0.00 sec)

MySQL YEAR() function
---------------------
    SELECT YEAR('2009-05-19');  
    Output

    mysql> SELECT YEAR('2009-05-19');
    +--------------------+
    | YEAR('2009-05-19') |
    +--------------------+
    |               2009 | 
    +--------------------+
    1 row in set (0.00 sec)


Последние 10 дней
-----------------
    select * from dt_table where  `date` >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)

    SELECT * FROM dt_table WHERE `date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 10 DAY ) AND CURDATE( )  

Последний месяц
---------------
    select * from dt_table where  `date` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)

    select * from dt_table where  `date` >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)

Между двумя датами
------------------
    select * from dt_table where `date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 3 MONTH ) AND DATE_SUB( CURDATE( ) ,INTERVAL 0 MONTH )

    select * from dt_table where `date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 6 MONTH ) AND DATE_SUB( CURDATE( ) ,INTERVAL 3 MONTH )

Между 6 и 12 месяцем.
---------------------
      select * from dt_table where `date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 12  MONTH ) AND DATE_SUB( CURDATE( ) ,INTERVAL 6 MONTH )

Archives
---------

      <h1>Archives</h1>
      <hr />

      <ul>
      <?php
      $stmt = $db->query("SELECT Month(created) as Month, Year(created) as Year FROM blog_posts GROUP BY Month(created), Year(created) ORDER BY created DESC");
      while($row = $stmt->fetch()){
        $monthName = date("F", mktime(0, 0, 0, $row['Month'], 10));
        $slug = 'a-'.$row['Month'].'-'.$row['Year'];
        echo "<li><a href='$slug'>$monthName</a></li>";
      }
      ?>
      </ul>


archive.php
-----------

    <?php require_once __DIR__.'/../bootstrap/app.php'; ?>
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
        try {

          //collect month and year data
          $month = $_GET['month'];
          $year = $_GET['year'];

          //set from and to dates
          $from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
          $to = date('Y-m-31 23:59:59', strtotime("$year-$month"));




          $stmt = $db->prepare('SELECT * FROM blog_posts WHERE created >= :from AND created <= :to ORDER BY id DESC');
          $stmt->execute(array(
            ':from' => $from,
            ':to' => $to
          ));
          while($row = $stmt->fetch()){

              echo '<h1><a href="'.$row['slug'].'">'.$row['title'].'</a></h1>';
              echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created'])).' in ';

                $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                $stmt2->execute(array(':postID' => $row['id']));

                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($catRow as $cat)
                {
                    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                }
                echo implode(", ", $links);

              echo '</p>';
              echo '<p>'.$row['description'].'</p>';        
              echo '<p><a href="'.$row['slug'].'">Read More</a></p>';
          }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
      ?>

    </article>
    
    <aside id="sidebar" class="sidebar col-4 border-left border-right">
  
        
        <article>
                 <?php require('sidebar.php'); ?>
            
        </article>
        </aside>
      </section>
    </main>

    <?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>

.htaccess
---------

    RewriteEngine On
    RewriteBase /

    RewriteRule ^c-(.*)$ catpost.php?id=$1 [L]

    RewriteRule ^a-(.*)-(.*)$ archives.php?month=$1&year=$2 [L]

    RewriteCond %{REQUEST_FILENAME} !-d [NC]
    RewriteCond %{REQUEST_FILENAME} !-f [NC]

    RewriteRule ^(.*)$ view.php?id=$1 [QSA,L]
