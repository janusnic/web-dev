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

		$_POST = array_map( 'stripslashes', $_POST );

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
				//insert into database
				$stmt = $db->prepare('UPDATE blog_posts SET title = :postTitle, description = :postDesc, content = :postCont WHERE id = :postID') ;
				$stmt->execute(array(
					':postTitle' => $title,
					':postDesc' => $description,
					':postCont' => $content,
					':postID' => $id
				));

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
			$row = $stmt->fetch(); 

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

		<p><input type='submit' name='submit' value='Update'></p>

	</form>

    </section>
    </main>

<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>
