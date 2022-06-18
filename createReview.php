<?php 
  require "templates/header.php";
  if(!isset($_SESSION['userId'])) {
    header("Location: ./index.php");
    exit(); 
  }
?>

  <main class="container p-4 bg-light mt-3" style="width: 1000px">
    <form action="includes/createReview.inc.php" method="POST" enctype="multipart/form-data">
      <h2 class="text-center display-2">Create Review</h2>

      <?php
      
        if(isset($_GET['error'])){
          if($_GET['error'] == "emptyfields"){
            $errorMsg = "Please fill in all fields";
          } else if ($_GET['error'] == "sqlerror") {
            header("Location: ./500Error.php");
          } else if ($_GET['error'] == "1" || $_GET['error'] == "2" || $_GET['error'] == "3" || $_GET['error'] == "4" || $_GET['error'] == "5" || $_GET['error'] == "6" || $_GET['error'] == "7" || $_GET['error'] == "8") {
            $errorMsg = $phpFileUploadErrors[$_GET['error']];
          } else if ($_GET['error'] == "exists") {
            $errorMsg = "This file already exists";
          } else if ($_GET['error'] == "invalidFile") {
            "File type is NOT allowed. Please limit file types to: jpg, jpeg, gif or png";
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

      <!-- Image uploader -->
      <div class="mb-3">
        <label for="image" class="form-label">Hero Image</label>
        <input type="file" class="form-control 
        <?php 
        if(isset($_GET['error'])) {
          if($_GET['error'] == "1" || $_GET['error'] == "2" || $_GET['error'] == "3" || $_GET['error'] == "4" || $_GET['error'] == "5" || $_GET['error'] == "6" || $_GET['error'] == "7" || $_GET['error'] == "8" || $_GET['error'] == "exists" || $_GET['error'] == "invalidFile") {
            echo "is-invalid";
          }
        }
        ?>" 
        id="inputGroupFile" name="fileToUpload">
        <div class="form-text text-danger invalid-feedback"><?php 
          echo $errorMsg;
        ?></div>
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
      <button type="submit" name="review-submit" class="btn btn-dark w-100">Post</button>
    </form>
  </main>

<?php 
  require "templates/footer.php"
?>