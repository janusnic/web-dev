<?php

require_once __DIR__.'/../bootstrap/app.php';

?>

<!DOCTYPE html>
<html class=''>
<head>

<meta charset='UTF-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head><body>

<?php
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }


        $res = $mysqli->query("SELECT id, title FROM blog_posts ORDER BY id ASC");

        echo "Обратный порядок...\n";
        for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
            $res->data_seek($row_no);
            $row = $res->fetch_assoc();
            echo " id = " . $row['id'] . "\n";
            echo " title = " . $row['title'] . "\n";
        }

        echo "Исходный порядок строк...\n";
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            echo " id = " . $row['id'] . "\n";
            echo " title = " . $row['title'] . "\n";
        }
?>



</body>
</html>