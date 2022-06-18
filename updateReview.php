<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>

  <main class="container p-4 bg-light mt-3" style="width: 1000px">
    <?php
      if(isset($_SESSION['userId']) && isset($_GET['id'])) {
        require './includes/connect.inc.php';
  
        $id = mysqli_real_escape_string($conn, $_GET['id']); 
        $id = intval($id);

        $sql = "SELECT `id`, `title`, `author`, `subtitle`, `image`, `comment`, `created` FROM `reviews` WHERE id=?";
  
        $statement = mysqli_stmt_init($conn);
  
        if(!mysqli_stmt_prepare($statement, $sql)) {
          header("Location: updateReview.php?id=$id&error=sqlerror"); 
          exit();
        } else {
          mysqli_stmt_bind_param($statement, "i", $id);
  
          mysqli_stmt_execute($statement);
  
          $result = mysqli_stmt_get_result($statement);
          $row = mysqli_fetch_assoc($result);
        }
      } else {
        header("Location: index.php");
        exit();
      }
    ?>

    <?php 
      if(isset($_GET['error'])){
        if($_GET['error'] == "emptyfields"){
          $errorMsg = "Please fill in all fields";
        } else if ($_GET['error'] == "sqlerror") {
          header("Location: ./500Error.php");
        }

        echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';
      }
    ?>
    <form action="includes/updateReview.inc.php?id=<?php echo $id ?>" method="POST">
      <h2 class="text-center display-2">Edit a Review</h2>

      <?php
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            $errorMsg = "Please fill in all fields";
          } else if ($_GET['error'] == "sqlerror") {
            header("Location: ./500Error.php");
          } 

          echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';
        }
      ?>
      
      <!-- Title -->
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" value="<?php 
          if(isset($_GET['title'])){ 
            echo($_GET['title']);
          } else {
            echo null;
          }
        ?>">
      </div>  

      <!-- Subtitle -->
      <div class="mb-3">
        <label for="subtitle" class="form-label">Subtitle</label>
        <input type="text" class="form-control" name="subtitle" placeholder="Subtitle" value="<?php 
          if(isset($_GET['subtitle'])){ 
            echo($_GET['subtitle']);
          } else {
            echo null;
          }
        ?>">
      </div>

      <!-- Text/Review -->
      <div class="mb-3 form-floating">
        <textarea class="form-control" name="reviewtext" style="height: 500px"><?php 
          if(isset($_GET['comment'])){ 
            echo($_GET['comment']);
          } else {
            echo null;
          }
        ?></textarea>
        <label for="review">Paragraph</label>
      </div> 

      <!-- Submit Button -->
      <button type="submit" name="update-submit" class="btn btn-dark w-100">Post</button>
    </form>
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>