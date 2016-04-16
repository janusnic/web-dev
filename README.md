# web-dev unit_08

isset
-----
Определяет, была ли установлена переменная значением отличным от NULL

Пример использования isset()
----------------------------

        <?php

        $var = '';

        // Проверка вернет TRUE, поэтому текст будет напечатан.
        if (isset($var)) {
            echo "Эта переменная определена, поэтому меня и напечатали.";
        }

        // В следующем примере мы используем var_dump для вывода
        // значения, возвращаемого isset().

        $a = "test";
        $b = "anothertest";

        var_dump(isset($a));      // TRUE
        var_dump(isset($a, $b)); // TRUE

        unset ($a);

        var_dump(isset($a));     // FALSE
        var_dump(isset($a, $b)); // FALSE

        $foo = NULL;
        var_dump(isset($foo));   // FALSE

        ?>

Функция также работает с элементами массивов:

        <?php

        $a = array ('test' => 1, 'hello' => NULL, 'pie' => array('a' => 'apple'));

        var_dump(isset($a['test']));            // TRUE
        var_dump(isset($a['foo']));             // FALSE
        var_dump(isset($a['hello']));           // FALSE

        // Элемент с ключом 'hello' равен NULL, поэтому он считается неопределенным
        // Если Вы хотите проверить существование ключей со значением NULL, используйте: 
        var_dump(array_key_exists('hello', $a)); // TRUE

        // Проверка вложенных элементов массива
        var_dump(isset($a['pie']['a']));        // TRUE
        var_dump(isset($a['pie']['b']));        // FALSE
        var_dump(isset($a['cake']['a']['b']));  // FALSE

        ?>


tinymce
========
http://tinymce.cachefly.net/4.0/tinymce.min.js

ADD-POST.PHP
-------------
        <?php //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';
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
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    
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

        <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>


edit-post.php
---------------

        <?php //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';
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
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    
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



blog_members
-------------

        DROP TABLE IF EXISTS `blog_members`;

        CREATE TABLE `blog_members` (
          `memberID` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `username` varchar(255) DEFAULT NULL,
          `password` varchar(255) DEFAULT NULL,
          `email` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`memberID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        LOCK TABLES `blog_members` WRITE;
        /*!40000 ALTER TABLE `blog_members` DISABLE KEYS */;

        INSERT INTO `blog_members` (`memberID`, `username`, `password`, `email`)
        VALUES
          (1,'Demo','$2a$12$TF8u1maUr5kADc42g1FB0ONJDEtt24ue.UTIuP13gij5AHsg5f5s2','demo@demo.com');

        /*!40000 ALTER TABLE `blog_members` ENABLE KEYS */;
        UNLOCK TABLES;


users.php
---------
        <?php
        //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';
        //show message from add / edit page
        if(isset($_GET['deluser'])){ 

          //if user id is 1 ignore
          if($_GET['deluser'] !='1'){

            $stmt = $db->prepare('DELETE FROM blog_members WHERE memberID = :memberID') ;
            $stmt->execute(array(':memberID' => $_GET['deluser']));

            header('Location: users.php?action=deleted');
            exit;

          }
        } 

        ?>
          <script language="JavaScript" type="text/javascript">
          function deluser(id, title)
          {
            if (confirm("Are you sure you want to delete '" + title + "'"))
            {
              window.location.href = 'users.php?deluser=' + id;
            }
          }
          </script>

        <main>
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    

            <section class="row border-top border-bottom">
               <article class="content col-8">
               
                  <p><a href="./">Blog Admin Index</a></p>

                  <h2>Users</h2>

          <?php 
          //show message from add / edit page
          if(isset($_GET['action'])){ 
            echo '<h3>User '.$_GET['action'].'.</h3>'; 
          } 
          ?>
          <table>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
          <?php
            try {

              $stmt = $db->query('SELECT memberID, username, email FROM blog_members ORDER BY username');
              while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['username'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                ?>

                <td>
                  <a href="edit-user.php?id=<?php echo $row['memberID'];?>">Edit</a> 
                  <?php if($row['memberID'] != 1){?>
                    | <a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Delete</a>
                  <?php } ?>
                </td>
                
                <?php 
                echo '</tr>';

              }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
          ?>
          </table>

          <p><a href='add-user.php'>Add User</a></p>


        <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>

menu
-----

          <header>
            <div class="row">
              <input type="checkbox" id="navbar-checkbox" class="navbar-checkbox">
                <nav class='menu col'>
                    <ul>
                      <li><a href="/">Home</a></li>
                      <li><a href="./">Blog</a></li>
                      <li><a href="./users.php">Users</a></li>
                    </ul>
                    <label for="navbar-checkbox" class="navbar-handle"></label>
                </nav>
                </div>
          </header>


add-user.php
--------------

        <?php //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';
        ?>

        <main>
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    

            <section class="row border-top border-bottom">
               <article class="content col-8">

          <p><a href="users.php">User Admin Index</a></p>

          <h2>Add User</h2>

          <?php

          //if form has been submitted process it
          if(isset($_POST['submit'])){

            //collect form data
            extract($_POST);

            //very basic validation
            if($username ==''){
              $error[] = 'Please enter the username.';
            }

            if($password ==''){
              $error[] = 'Please enter the password.';
            }

            if($passwordConfirm ==''){
              $error[] = 'Please confirm the password.';
            }

            if($password != $passwordConfirm){
              $error[] = 'Passwords do not match.';
            }

            if($email ==''){
              $error[] = 'Please enter the email address.';
            }

            if(!isset($error)){

              $hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

              try {

                //insert into database
                $stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)') ;
                $stmt->execute(array(
                  ':username' => $username,
                  ':password' => $hashedpassword,
                  ':email' => $email
                ));

                //redirect to index page
                header('Location: users.php?action=added');
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

            <p><label>Username</label><br />
            <input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

            <p><label>Password</label><br />
            <input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

            <p><label>Confirm Password</label><br />
            <input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

            <p><label>Email</label><br />
            <input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
            
            <p><input type='submit' name='submit' value='Add User'></p>

          </form>


        </article>
        </section>
        </main>
        <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>

edit-user.php
--------------

        <?php //include config
        require_once __DIR__.'/../../bootstrap/app.php';
        require_once __DIR__.'/../../resources/views/layouts/header.php';
        ?>

        <main>
            <?php require_once __DIR__.'/../../resources/views/layouts/nav_admin.php';?>    

            <section class="row border-top border-bottom">
               <article class="content col-8">

          <p><a href="users.php">User Admin Index</a></p>

          <h2>Edit User</h2>


          <?php

          //if form has been submitted process it
          if(isset($_POST['submit'])){

            //collect form data
            extract($_POST);

            //very basic validation
            if($username ==''){
              $error[] = 'Please enter the username.';
            }

            if( strlen($password) > 0){

              if($password ==''){
                $error[] = 'Please enter the password.';
              }

              if($passwordConfirm ==''){
                $error[] = 'Please confirm the password.';
              }

              if($password != $passwordConfirm){
                $error[] = 'Passwords do not match.';
              }

            }
            

            if($email ==''){
              $error[] = 'Please enter the email address.';
            }

            if(!isset($error)){

              try {

                if(isset($password)){

                  $hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

                  //update into database
                  $stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email WHERE memberID = :memberID') ;
                  $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $hashedpassword,
                    ':email' => $email,
                    ':memberID' => $memberID
                  ));


                } else {

                  //update database
                  $stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email WHERE memberID = :memberID') ;
                  $stmt->execute(array(
                    ':username' => $username,
                    ':email' => $email,
                    ':memberID' => $memberID
                  ));

                }
                

                //redirect to index page
                header('Location: users.php?action=updated');
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

              $stmt = $db->prepare('SELECT memberID, username, email FROM blog_members WHERE memberID = :memberID') ;
              $stmt->execute(array(':memberID' => $_GET['id']));
              $row = $stmt->fetch(); 

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

          ?>

          <form action='' method='post'>
            <input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

            <p><label>Username</label><br />
            <input type='text' name='username' value='<?php echo $row['username'];?>'></p>

            <p><label>Password (only to change)</label><br />
            <input type='password' name='password' value=''></p>

            <p><label>Confirm Password</label><br />
            <input type='password' name='passwordConfirm' value=''></p>

            <p><label>Email</label><br />
            <input type='text' name='email' value='<?php echo $row['email'];?>'></p>

            <p><input type='submit' name='submit' value='Update User'></p>

          </form>

        </article>
        </section>
        </main>

        <?php require_once __DIR__.'/../../resources/views/layouts/footer.php'; ?>


delete
-------
            
      //show message from add / edit page
      if(isset($_GET['delpost'])){ 

          $stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
          $stmt->execute(array(':postID' => $_GET['delpost']));

          header('Location: index.php?action=deleted');
          exit;
      } 

      ?>

        <script language="JavaScript" type="text/javascript">
        function delpost(id, title)
        {
            if (confirm("Are you sure you want to delete '" + title + "'"))
            {
              window.location.href = 'index.php?delpost=' + id;
            }
        }
        </script>
       

          <?php
              try {

                  $stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
                  while($row = $stmt->fetch()){
                      
                      echo '<tr>';
                      echo '<td>'.$row['postTitle'].'</td>';
                      echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
                      ?>

                      <td>
                          <a href="edit-post.php?id=<?php echo $row['id'];?>">Edit</a> | 
                          <a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['title'];?>')">Delete</a>
                      </td>
                      
                      <?php 
                      echo '</tr>';

                  }

              } catch(PDOException $e) {
                  echo $e->getMessage();
              }
          ?>

