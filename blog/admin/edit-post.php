<?php //include config
require_once __DIR__.'/../bootstrap/app.php';
require_once __DIR__.'/../resources/views/layouts/header.php';
?>
 <script src="/js/tinymce.min.js"></script>
  <!-- script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script-->
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
<main>
    <?php require_once __DIR__.'/../resources/views/layouts/nav_admin.php';?>    
    <section class="row border-top border-bottom">
       <article class="content col-8">
			<p><a href="./">Blog Admin Index</a></p>

			<h2>Edit Post</h2>
	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		
        array_walk_recursive($_POST, create_function('&$val', '$val = stripslashes($val);'));
       

		//collect form data
		extract($_POST);

		//very basic validation
		if($id ==''){
			$error[] = 'This post is missing a valid id!.';
		}

		if($title ==''){
			$error[] = 'Please enter the title.';
		}

		if($description ==''){
			$error[] = 'Please enter the description.';
		}

		if($content ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {
				$postSlug = slug($title);

                //insert into database
				$stmt = $db->prepare('UPDATE blog_posts SET title = :postTitle, slug = :postSlug, description = :postDesc, content = :postCont WHERE id = :postID') ;
				$stmt->execute(array(
					':postTitle' => $title,
                    ':postSlug' => $postSlug,
					':postDesc' => $description,
					':postCont' => $content,
					':postID' => $id
				));
                
                //delete all items with the current postID
                $stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
                $stmt->execute(array(':postID' => $id));
                if(is_array($catID)){
                    foreach($_POST['catID'] as $catID){
                        $stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
                        $stmt->execute(array(
                            ':postID' => $id,
                            ':catID' => $catID
                        ));
                    }
                }

				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>

	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT id, title, description, content FROM blog_posts WHERE id = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='id' value='<?php echo $row['id'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='title' value='<?php echo $row['title'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='description' cols='60' rows='10'><?php echo $row['description'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='content' cols='60' rows='10'><?php echo $row['content'];?></textarea></p>
        <fieldset>
            <legend>Categories</legend>

            <?php

            $stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');

            while($row2 = $stmt2->fetch()){

                $stmt3 = $db->prepare('SELECT catID FROM blog_post_cats WHERE catID = :catID AND postID = :postID') ;
                $stmt3->execute(array(':catID' => $row2['catID'], ':postID' => $row['id']));

                $row3 = $stmt3->fetch(); 

                if($row3['catID'] == $row2['catID']){
                    $checked = 'checked';
                } else {
                    $checked = null;
                }

                echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."' $checked> ".$row2['catTitle']."<br />";
            }

            ?>

        </fieldset>

		<p><input type='submit' name='submit' value='Update'></p>

	</form>

    </section>
    </main>

<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>
