<?php //include config
require_once __DIR__.'/../bootstrap/app.php';
require_once __DIR__.'/../resources/views/layouts/header.php';
?>
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
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
       <h3>Add Post</h3>
          <p><a href="./">Blog Admin Index</a></p>

          <h2>Add Post</h2>

          <?php

          //if form has been submitted process it
          if(isset($_POST['submit'])){

              $_POST = array_map( 'stripslashes', $_POST );

              //collect form data
              extract($_POST);

              //very basic validation
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
                      $stmt = $db->prepare('INSERT INTO blog_posts (title,description,content,created) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
                      $stmt->execute(array(
                          ':postTitle' => $title,
                          ':postDesc' => $description,
                          ':postCont' => $content,
                          ':postDate' => date('Y-m-d H:i:s')
                      ));

                      //redirect to index page
                      header('Location: index.php?action=added');
                      exit;

                  } catch(PDOException $e) {
                      echo $e->getMessage();
                  }

              }

          }

          //check for any errors
          if(isset($error)){
              foreach($error as $error){
                  echo '<p class="error">'.$error.'</p>';
              }
          }
          ?>

    <form action='' method='post'>

        <p><label>Title</label><br />
        <input type='text' name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>

        <p><label>Description</label><br />
        <textarea name='description' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['description'];}?></textarea></p>

        <p><label>Content</label><br />
        <textarea name='content' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['content'];}?></textarea></p>

        <p><input type='submit' name='submit' value='Submit'></p>

    </form>

    </article>

            <aside id="sidebar" class="sidebar col-4">
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
