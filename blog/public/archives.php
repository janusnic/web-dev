<?php require_once __DIR__.'/../bootstrap/app.php'; ?>
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
				try {

					
                    //collect month and year data
					$month = $_GET['month'];
					$year = $_GET['year'];

					//set from and to dates
					$from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
					$to = date('Y-m-31 23:59:59', strtotime("$year-$month"));


                    $pages = new Paginator('1','p');

                    $stmt = $db->prepare('SELECT id FROM blog_posts WHERE created >= :from AND created <= :to');
                    $stmt->execute(array(
                        ':from' => $from,
                        ':to' => $to
                    ));

                    //pass number of records to
                    $pages->set_total($stmt->rowCount());

                   	$stmt = $db->prepare('SELECT * FROM blog_posts WHERE created >= :from AND created <= :to ORDER BY id DESC '.$pages->get_limit());
					$stmt->execute(array(
						':from' => $from,
						':to' => $to
				 	));
					while($row = $stmt->fetch()){

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
					}

                    echo $pages->page_links("a-$month-$year&");
                    
				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>

    </article>
    
    <aside id="sidebar" class="sidebar col-4 border-left border-right">
  
        
        <article>
                 <?php require('sidebar.php'); ?>
            
        </article>
        </aside>
      </section>
    </main>

<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>