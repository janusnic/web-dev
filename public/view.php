<?php 

require_once __DIR__.'/../bootstrap/app.php';

$stmt = $db->prepare('SELECT id, title, content, created FROM blog_posts WHERE id = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['id'] == ''){
	header('Location: ./');
	exit;
}

?>

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
			echo '<div>';
				echo '<h1>'.$row['title'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['created'])).'</p>';
				echo '<p>'.$row['content'].'</p>';				
			echo '</div>';
		?>

    </article>
    
    <aside id="sidebar" class="sidebar col-4 border-left border-right">
  
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
      </section>
    </main>

<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>