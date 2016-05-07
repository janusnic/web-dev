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
 
 
    <main>
        
    <section class="row border-top border-bottom">
       <article class="content col-6">

       <?php
        try {

          $pages = new Paginator('1','p');

          $stmt = $db->query('SELECT id FROM blog_posts');

          //pass number of records to
          $pages->set_total($stmt->rowCount());

          $stmt = $db->query('SELECT id, title, slug, description, created FROM blog_posts ORDER BY id DESC '.$pages->get_limit());

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
          echo $pages->page_links();

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
      ?>
        
    </article>
    
    <section id="middle" class="sidebar col-4 border-left border-right">
 

      <article>
        <h2>Sidebar Title</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam congue purus non turpis vulputate mollis. Duis sit amet neque risus. Etiam vitae pulvinar enim, ac congue elit. Praesent in pretium ante, id aliquet mauris. Ut nec justo orci. Nullam
          vel tellus mi. Nulla tincidunt tincidunt nisi sit amet posuere. Praesent pellentesque mauris sed dictum ultricies. Pellentesque rhoncus nunc at consectetur fringilla. Curabitur sit amet tempus elit, sit amet auctor felis.</p>
      </article>

      <article>
        <h2>Sidebar Title</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam congue purus non turpis vulputate mollis. Duis sit amet neque risus. Etiam vitae pulvinar enim, ac congue elit. Praesent in pretium ante, id aliquet mauris. Ut nec justo orci. Nullam
          vel tellus mi. Nulla tincidunt tincidunt nisi sit amet posuere. Praesent pellentesque mauris sed dictum ultricies. Pellentesque rhoncus nunc at consectetur fringilla. Curabitur sit amet tempus elit, sit amet auctor felis.</p>
      </article>
    </section>

    <aside id="sidebar" class="sidebar col-2">
      <article>
        <?php require('sidebar.php'); ?>
      </article>
    </aside>
    </main>
    
<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>
