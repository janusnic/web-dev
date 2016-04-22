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

          $stmt = $db->query('SELECT id, title, description, created FROM blog_posts ORDER BY id DESC');

          while($row = $stmt->fetch()){
            
              echo '<h2><a href="view.php?id='.$row['id'].'">'.$row['title'].'</a></h2>';
              echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['created'])).'</p>';
              echo '<p>'.$row['description'].'</p>';       
              echo '<p><a href="view.php?id='.$row['id'].'">Read More</a></p>';       
    
          }

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

      <article>
        <h2>Sidebar Title</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam congue purus non turpis vulputate mollis. Duis sit amet neque risus. Etiam vitae pulvinar enim, ac congue elit. Praesent in pretium ante, id aliquet mauris. Ut nec justo orci. Nullam
          vel tellus mi. Nulla tincidunt tincidunt nisi sit amet posuere. Praesent pellentesque mauris sed dictum ultricies. Pellentesque rhoncus nunc at consectetur fringilla. Curabitur sit amet tempus elit, sit amet auctor felis.</p>
      </article>
    </section>

    <aside id="sidebar" class="sidebar col-2">
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
    </main>
    
<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>
