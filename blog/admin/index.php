<?php
//include config
require_once __DIR__.'/../bootstrap/app.php';
require_once __DIR__.'/../resources/views/layouts/header.php';

//show message from add / edit page
if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM blog_posts WHERE id = :postID') ;
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

  <main>
  
    <?php require_once __DIR__.'/../resources/views/layouts/nav_admin.php';?>    
    
    <section class="row border-top border-bottom">
       <article class="content col-8">
       <h3>Admin Posts</h3>

    <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>Post '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT id, title, created FROM blog_posts ORDER BY id DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['title'].'</td>';
                echo '<td>'.date('jS M Y', strtotime($row['created'])).'</td>';
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
    </table>

    <p><a href='/admin/add-post.php'>Add Post</a></p>
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