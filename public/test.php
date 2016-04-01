<?php
echo 'test';
?>

<h2>Пример  Вывод значения переменной (элемента массива)</h2>
<pre>
        echo $_SERVER['HTTP_USER_AGENT'];
</pre>

<?php  echo $_SERVER['HTTP_USER_AGENT']; ?>
<h2>Изолирование от HTML</h2>
<p>
Все, что находится вне пары открывающегося и закрывающегося тегов, игнорируется интерпретатором PHP, у которого есть возможность обрабатывать файлы со смешанным содержимым. Это позволяет PHP-коду быть встроенным в документы HTML, к примеру, для создания шаблонов.
</p>
        <p>Это будет проигнорировано PHP и отображено браузером.</p>
        <?php echo 'А это будет обработано.'; ?>
        <p>Это тоже будет проигнорировано PHP и отображено браузером.</p>

<h2>Использование структур с условиями</h2>

        <?php $expression = true; if ($expression == true): ?>
          Это будет отображено, если выражение истинно.
        <?php else: ?>
          В ином случае будет отображено это.
        <?php endif; ?>
<?php echo 'если вы хотите хранить код PHP в документах XHTML или XML,
                        то используйте эти теги'; ?>

         <script language="php">
                echo 'некоторые редакторы (например, FrontPage) не любят инструкции обработки с этими тегами';
         </script>

<?php
            echo "Это тест"; // Это однострочный комментарий в стиле c++
            /* Это многострочный комментарий
               еще одна строка комментария */
            echo "Это еще один тест";
            echo "Последний тест"; # Это комментарий в стиле оболочки Unix
        ?>

<?php
        $var = 'Bob';
        $Var = 'Joe';
        echo "$var, $Var";      // выведет "Bob, Joe"

        
        $_4site = 'not yet';    // верно; начинается с символа подчеркивания
        $täyte = 'mansikka';    // верно; 'ä' это (Расширенный) ASCII 228.
?>

<?php
        $foo = 'Боб';              // Присваивает $foo значение 'Боб'
        $bar = &$foo;              // Ссылка на $foo через $bar.
        $bar = "Меня зовут $bar";  // Изменение $bar...
        echo $bar;
        echo $foo;                 // меняет и $foo.
        ?>
<p>Важно отметить, что по ссылке могут быть присвоены только именованные переменные.</p>

        <?php
        $foo = 25;
        $bar = &$foo;      // Это верное присвоение.
        //$bar = &(24 * 7);  // Неверно; ссылка на неименованное выражение.

        function test()
        {
           return 25;
        }

        //$bar = &test();    // Неверно.
        ?>
<?php
        // Неустановленная И не имеющая ссылок (т.е. без контекста использования) переменная; выведет NULL
        var_dump($unset_var);

        // Булевое применение; выведет 'false' (Подробнее по этому синтаксису смотрите раздел о тернарном операторе)
        echo($unset_bool ? "true\n" : "false\n");

        // Строковое использование; выведет 'string(3) "abc"'
        $unset_str .= 'abc';
        var_dump($unset_str);

        // Целочисленное использование; выведет 'int(25)'
        $unset_int += 25; // 0 + 25 => 25
        var_dump($unset_int);

        // Использование в качестве числа с плавающей точкой (float/double); выведет 'float(1.25)'
        $unset_float += 1.25;
        var_dump($unset_float);

        // Использование в качестве массива; выведет array(1) {  [3]=>  string(3) "def" }
        $unset_arr[3] = "def"; // array() + array(3 => "def") => array(3 => "def")
        var_dump($unset_arr);

        // Использование в качестве объекта; создает новый объект stdClass (см. http://www.php.net/manual/en/reserved.classes.php)
        // Выведет: object(stdClass)#1 (1) {  ["foo"]=>  string(3) "bar" }
        $unset_obj->foo = 'bar';
        var_dump($unset_obj);
        ?>
<?php

        echo (5 % 3)."\n";           // выводит 2
        echo (5 % -3)."\n";          // выводит 2
        echo (-5 % 3)."\n";          // выводит -2
        echo (-5 % -3)."\n";         // выводит -2

        ?>


<?php

        $a = ($b = 4) + 5; // $a теперь равно 9, а $b было присвоено 4.

        ?>

<?php
        echo "<h3>Постфиксный инкремент</h3>";
        $a = 5;
        echo "Должно быть 5: " . $a++ . "<br />\n";
        echo "Должно быть 6: " . $a . "<br />\n";

        echo "<h3>Префиксный инкремент</h3>";
        $a = 5;
        echo "Должно быть 6: " . ++$a . "<br />\n";
        echo "Должно быть 6: " . $a . "<br />\n";

        echo "<h3>Постфиксный декремент</h3>";
        $a = 5;
        echo "Должно быть 5: " . $a-- . "<br />\n";
        echo "Должно быть 4: " . $a . "<br />\n";

        echo "<h3>Префиксный декремент</h3>";
        $a = 5;
        echo "Должно быть 4: " . --$a . "<br />\n";
        echo "Должно быть 4: " . $a . "<br />\n";
        ?>

<?php
        function double($i)
        {
            return $i*2;
        }
        $b = $a = 5;        /* присвоить значение пять переменным $a и $b */
        $c = $a++;          /* постфиксный инкремент, присвоить значение $a 
                               (5) переменной $c */
        $e = $d = ++$b;     /* префиксный инкремент, присвоить увеличенное
                               значение $b (6) переменным $d и $e */

        /* в этой точке и $d, и $e равны 6 */

        $f = double($d++);  /* присвоить удвоенное значение $d перед
                               инкрементом (2*6 = 12) переменной $f */
        $g = double(++$e);  /* присвоить удвоенное значение $e после
                               инкремента (2*7 = 14) переменной $g */
        $h = $g += 10;      /* сначала переменная $g увеличивается на 10,
                               приобретая, в итоге, значение 24. Затем значение
                               присвоения (24) присваивается переменной $h,
                               которая в итоге также становится равной 24. */
        ?>

<?php
        // == это оператор, который проверяет
        // эквивалентность и возвращает boolean
        if ($action == "show_version") {
            echo "The version is 1.23";
        }

        // это необязательно...
        if ($show_separators == TRUE) {
            echo "<hr>\n";
        }

        // ... потому что следующее имеет тот же самый смысл:
        if ($show_separators) {
            echo "<hr>\n";
        }
        ?>
<?php
        var_dump((bool) "");        // bool(false)
        var_dump((bool) 1);         // bool(true)
        var_dump((bool) -2);        // bool(true)
        var_dump((bool) "foo");     // bool(true)
        var_dump((bool) 2.3e5);     // bool(true)
        var_dump((bool) array(12)); // bool(true)
        var_dump((bool) array());   // bool(false)
        var_dump((bool) "false");   // bool(true)
        ?>
<?php
        // Булево и null всегда сравниваются как булево значение 
        var_dump(1 == TRUE);  // TRUE - тоже что и (bool)1 == TRUE
        var_dump(0 == FALSE); // TRUE - тоже что и (bool)0 == FALSE
        var_dump(100 < TRUE); // FALSE - тоже что и (bool)100 < TRUE
        var_dump(-10 < FALSE);// FALSE - тоже что и (bool)-10 < FALSE
        var_dump(min(-100, -10, NULL, 10, 100)); // NULL - (bool)NULL < (bool)-100 , тоже что и FALSE < TRUE
        ?>
 <?php

        // --------------------
        // foo() никогда не буде вызвана, так как эти операторы являются шунтирующими (short-circuit)

        $a = (false && foo());
        $b = (true  || foo());
        $c = (false and foo());
        $d = (true  or  foo());

        // --------------------
        // "||" имеет больший приоритет, чем "or"

        // Результат выражения (false || true) присваивается переменной $e
        // Действует как: ($e = (false || true))
        $e = false || true;

        // Константа false присваивается $f, а затем значение true игнорируется
        // Действует как: (($f = false) or true)
        $f = false or true;

        var_dump($e, $f);

        // --------------------
        // "&&" имеет больший приоритет, чем "and"

        // Результат выражения (true && false) присваивается переменной $g
        // Действует как: ($g = (true && false))
        $g = true && false;

        // Константа true присваивается $h, а затем значение false игнорируется
        // Действует как: (($h = true) and false)
        $h = true and false;

        var_dump($g, $h);
        ?>
<?php
        // Пример использования тернарного оператора
        $action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

        // Приведенный выше код аналогичен следующему блоку с использованием if/else
        if (empty($_POST['action'])) {
            $action = 'default';
        } else {
            $action = $_POST['action'];
        }

        ?>
 <?php
        var_dump(0 == "a"); // 0 == 0 -> true
        var_dump("1" == "01"); // 1 == 1 -> true
        var_dump("10" == "1e1"); // 10 == 10 -> true
        var_dump(100 == "1e2"); // 100 == 100 -> true

        switch ("a") {
        case 0:
            echo "0";
            break;
        case "a": // Эта ветка никогда не будет достигнута, так как "a" уже сопоставленно с 0
            echo "a";
            break;
        }
        ?>

<?php
        if ($a == 5):
            echo "a равно 5";
            echo "...";
        elseif ($a == 6):
            echo "a равно 6";
            echo "!!!";
        else:
            echo "a не равно ни 5 ни 6";
        endif;
        ?>
<?php
    var_dump(01090); // 010 octal = 8 decimal
    ?>

<?php
        $large_number = 2147483647;
        var_dump($large_number);                     // int(2147483647)

        $large_number = 2147483648;
        var_dump($large_number);                     // float(2147483648)

        $million = 1000000;
        $large_number =  50000 * $million;
        var_dump($large_number);                     // float(50000000000)
        ?>

<p>Пример Переполнение целых на 64-битных системах</p>

        <?php
        $large_number = 9223372036854775807;
        var_dump($large_number);                     // int(9223372036854775807)

        $large_number = 9223372036854775808;
        var_dump($large_number);                     // float(9.2233720368548E+18)

        $million = 1000000;
        $large_number =  50000000000000 * $million;
        var_dump($large_number);                     // float(5.0E+19)
        ?>
<?php
        var_dump(25/7);         // float(3.5714285714286) 
        var_dump((int) (25/7)); // int(3)
        var_dump(round(25/7));  // float(4) 
        ?>

 <?php
        $a = 1.23456789;
        $b = 1.23456780;
        $epsilon = 0.00001;

        if(abs($a-$b) < $epsilon) {
            echo "true";
        }
        ?>

<?php
        echo 'это простая строка';

        echo 'Также вы можете вставлять в строки
        символ новой строки вот так,
        это нормально';

        // Выводит: Однажды Арнольд сказал: "I'll be back"
        echo 'Однажды Арнольд сказал: "I\'ll be back"';

        // Выводит: Вы удалили C:\*.*?
        echo 'Вы удалили C:\\*.*?';

        // Выводит: Вы удалили C:\*.*?
        echo 'Вы удалили C:\*.*?';

        // Выводит: Это не будет развернуто: \n новая строка
        echo 'Это не будет развернуто: \n новая строка';

        // Выводит: Переменные $expand также $either не разворачиваются
        echo 'Переменные $expand также $either не разворачиваются';
        ?>

<?php
$str = <<<EOD
Пример строки,
охватывающей несколько строчек,
с использованием heredoc-синтаксиса.
EOD;

/* Более сложный пример с переменными. */
class foo
 {
   var $foo;
   var $bar;

   function foo()
     {
        $this->foo = 'Foo';
        $this->bar = array('Bar1', 'Bar2', 'Bar3');
     }
  }

$foo = new foo();
$name = 'МоеИмя';

echo <<<EOT
Меня зовут "$name". Я печатаю $foo->foo.
Теперь я вывожу {$foo->bar[1]}.
Это должно вывести заглавную букву 'A': \x41
EOT;

?>

<?php
var_dump(array(<<<EOD
foobar!
EOD
));

?>

<?php
$str = <<<'EOD'
Пример текста,
занимающего несколько строк,
с помощью синтаксиса nowdoc.
EOD;

/* Более сложный пример с переменными. */
class foo1
  {
   public $foo;
   public $bar;

function foo()
  {
   $this->foo = 'Foo';
   $this->bar = array('Bar1', 'Bar2', 'Bar3');
   }
 }

$foo = new foo1();
$name = 'МоеИмя';

echo <<<'EOT'
Меня зовут "$name". Я печатаю $foo->foo.
Теперь я печатаю {$foo->bar[1]}.
Это не должно вывести заглавную 'A': \x41
EOT;

 ?>

 <?php
        $juice = "apple";

        echo "He drank some $juice juice.".PHP_EOL;
        // не работает, 's' - это верный символ для имени переменной,
        // но наша переменная имеет имя $juice.
        echo "He drank some juice made of $juices.";
        ?>

<h3>Пример простого синтаксиса</h3>

        <?php
        $juices = array("apple", "orange", "koolaid1" => "purple");

        echo "He drank some $juices[0] juice.".PHP_EOL;
        echo "He drank some $juices[1] juice.".PHP_EOL;
        echo "He drank some $juices[koolaid1] juice.".PHP_EOL;

        class people {
            public $john = "John Smith";
            public $jane = "Jane Smith";
            public $robert = "Robert Paulsen";
            
            public $smith = "Smith";
        }

        $people = new people();

        echo "$people->john drank some $juices[0] juice.".PHP_EOL;
        echo "$people->john then said hello to $people->jane.".PHP_EOL;
        echo "$people->john's wife greeted $people->robert.".PHP_EOL;
        echo "$people->robert greeted the two $people->smiths."; // Won't work
        ?>

<h3>Сложный (фигурный) синтаксис</h3>
<?php
        // Показываем все ошибки
        error_reporting(E_ALL);

        $great = 'здорово';

        // Не работает, выводит: Это { здорово}
        echo "Это { $great}";

        // Работает, выводит: Это здорово
        echo "Это {$great}";
        echo "Это ${great}";

        // Работает
        echo "Этот квадрат шириной {$square->width}00 сантиметров.";

        // Работает, ключи, заключенные в кавычки, работают только с синтаксисом фигурных скобок
        echo "Это работает: {$arr['key']}";

        // Работает
        echo "Это работает: {$arr[4][3]}";

        // Это неверно по той же причине, что и $foo[bar] вне
        // строки. Другими словами, это по-прежнему будет работать,
        // но поскольку PHP сначала ищет константу foo, это вызовет
        // ошибку уровня E_NOTICE (неопределенная константа).
        echo "Это неправильно: {$arr[foo][3]}";

        // Работает. При использовании многомерных массивов внутри
        // строк всегда используйте фигурные скобки
        echo "Это работает: {$arr['foo'][3]}";

        // Работает.
        echo "Это работает: " . $arr['foo'][3];

        echo "Это тоже работает: {$obj->values[3]->name}";

        echo "Это значение переменной по имени $name: {${$name}}";

        //echo "Это значение переменной по имени, которое возвращает функция getName(): {${getName()}}";

        //echo "Это значение переменной по имени, которое возвращает \$object->getName(): {${$object->getName()}}";

        // Не работает, выводит: Это то, что возвращает getName(): {getName()}
        //echo "Это то, что возвращает getName(): {getName()}";
        ?>

<?php
        // Получение первого символа строки
        $str = 'This is a test.';
        $first = $str[0];

        // Получение третьего символа строки
        $third = $str[2];

        // Получение последнего символа строки
        $str = 'This is still a test.';
        $last = $str[strlen($str)-1]; 

        // Изменение последнего символа строки
        $str = 'Look at the sea';
        $str[strlen($str)-1] = 'e';

        ?>

<?php
        $str = 'abc';

        var_dump($str['1']);
        var_dump(isset($str['1']));

        var_dump($str['1.0']);
        var_dump(isset($str['1.0']));

        var_dump($str['x']);
        var_dump(isset($str['x']));

        var_dump($str['1x']);
        var_dump(isset($str['1x']));
        ?>

<?php
        $foo = 1 + "10.5";                // $foo это float (11.5)
        $foo = 1 + "-1.3e3";              // $foo это float (-1299)
        $foo = 1 + "bob-1.3e3";           // $foo это integer (1)
        $foo = 1 + "bob3";                // $foo это integer (1)
        $foo = 1 + "10 Small Pigs";       // $foo это integer (11)
        $foo = 4 + "10.2 Little Piggies"; // $foo это float (14.2)
        $foo = "10.0 pigs " + 1;          // $foo это float (11)
        $foo = "10.0 pigs " + 1.0;        // $foo это float (11)
        ?>
