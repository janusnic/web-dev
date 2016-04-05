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
        $row = $res->fetch_assoc();

        printf("id = %s (%s)\n", $row['id'], gettype($row['id']));
        printf("title = %s (%s)\n", $row['title'], gettype($row['title']));
?>




</body>
</html>