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
    $query = trim($query); 
    
    $query = htmlspecialchars($query);

    if (!empty($query)) 
    { 

        if (strlen($query) < 3) {
            $text = '<p>Слишком короткий поисковый запрос.</p>';
            echo $text;
        } else if (strlen($query) > 128) {
            $text = '<p>Слишком длинный поисковый запрос.</p>';
            echo $text;
        } else { 
        
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