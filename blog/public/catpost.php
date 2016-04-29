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

							$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
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


    <aside id="sidebar" class="sidebar col-4">
      <article>
        <?php require('sidebar.php'); ?>
      </article>
    </aside>
    </section>
    </main>
    
<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>