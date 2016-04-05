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


        $mysqli->real_query("SELECT id, title FROM blog_posts ORDER BY id ASC");
        $res = $mysqli->use_result();

        echo "Порядок строк в результирующем наборе...\n";
        while ($row = $res->fetch_assoc()) {
            echo " id = " . $row['id'] . "\n";
            echo " title = " . $row['title'] . "\n";
        }
?>



</body>
</html>