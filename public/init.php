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

        if (!$mysqli->query("DROP TABLE IF EXISTS blog_posts") ||
            !$mysqli->query("CREATE TABLE blog_posts(id int(11) unsigned NOT NULL AUTO_INCREMENT ,title varchar(255) DEFAULT NULL, description text, content text, created datetime DEFAULT NULL, PRIMARY KEY(id))")) {
            echo "Не удалось создать таблицу: (" . $mysqli->errno . ") " . $mysqli->error;
        }
?>

</body>
</html>