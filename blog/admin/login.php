<?php
//include config
require_once __DIR__.'/../bootstrap/app.php';
require_once __DIR__.'/../resources/views/layouts/header.php';


//check if already logged in
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>


<main>
<section class="row border-top border-bottom">
       <article class="content col-12">
       <h3>Login to Admin</h3>

    <?php

    //process login form if submitted
    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if($user->login($username,$password)){ 

            //logged in return to index page
            header('Location: index.php');
            exit;
        

        } else {
            $message = '<p class="error">Wrong username or password</p>';
        }

    }//end if submit

    if(isset($message)){ echo $message; }
    ?>

    <form action="" method="post">
    <p><label>Username</label><input type="text" name="username" value=""  /></p>
    <p><label>Password</label><input type="password" name="password" value=""  /></p>
    <p><label></label><input type="submit" name="submit" value="Login"  class="btn btn-default" /></p>
    </form>

    </section>
    </main>
<?php require_once __DIR__.'/../resources/views/layouts/footer.php'; ?>
