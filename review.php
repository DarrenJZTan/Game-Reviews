<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>

  <main class="container p-4 bg-light mt-3" style="width: 1000px">
    <?php
      require './includes/connect.inc.php';
      $sql = "SELECT `id`, `title`, `author`, `subtitle`, `image`, `comment`, `created` FROM `reviews` ORDER BY `id` DESC";
      $result = mysqli_query($conn, $sql);
    ?>
    <?php 
      if(isset($_GET['post']) == "success"){
        echo '<div class="alert alert-success" role="alert">
          Review successfully created!
        </div>';  
      } else if(isset($_GET['update']) == "success"){
        echo '<div class="alert alert-success" role="alert">
        Review updated!
        </div>'; 
      }

      // DYNAMIC ERROR/SUCCESS MESSAGES FOR DELETE
      if(isset($_GET['error'])){
        // (i) Internal server error 
        if ($_GET['error'] == "sqlerror") {
          header("Location: ./500Error.php");
        }

        echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';

      // (iii) Display SUCCESS message for correct login!
      } else if (isset($_GET['delete']) == "success"){
        echo '<div class="alert alert-success" role="alert">
          Post successfully deleted!
        </div>';    
      }
    ?>

    <?php
      if(isset($_SESSION['userId'])){
        echo '
        <div class="text-end">
          <button type="button" onclick="location.href=`createReview.php`" class="btn btn-dark">Add Review</button>
        </div>
        ';
      }
      // Success: Display Posts
      if(mysqli_num_rows($result) > 0){

        // Variable 
        $output = "";

        while($row = mysqli_fetch_assoc($result)) {
          $output .= 
          '
            <div class="card border-0 mt-3 bg-light" id="' . $row['id'] . '">';
              if(isset($_SESSION['userId'])){
                $output .= '
                <div class="d-flex justify-content-between">
                  <h2 class="card-title display-2 text-capitalize fw-bold">' . $row['title'] . '</h2>
                  <div class="admin-btn align-self-end">
                    <a href="updateReview.php?id=' . $row['id'] . '" class="btn btn-secondary mt-2">Update</a>
                    <a href="includes/deleteReview.inc.php?id=' . $row['id'] . '" class="btn btn-danger mt-2">Delete</a>
                  </div>
                </div>';
              } else {
                $output .= '<h2 class="card-title display-2 text-capitalize fw-bold">' . $row['title'] . '</h2>';
              }
              $output .=
              '
              <h3 class="text-muted text-capitalize fs-2">' . $row['subtitle'] . '</h3>
              <img src="' . $row['image'] . '" class="hero-image" alt="' . $row['title'] . '">
              <div class="d-flex justify-content-between">
                <p class="lead">By: ' . $row['author'] . ' </p>
                <p class="lead"> Posted: ' . $row['created'] .'</p>
              </div>
                <p class="card-text">' . $row['comment'] . '</p>
            </div>
            <hr class="mt-5">
            ';
        }
        echo $output;
      } else {
        echo '
        <img src="./websiteImages/noresults.png" id="noResultImage" alt="Sad">
        <p class="text-center">It appears that there are <strong>0 results</strong>.</p>
        <p class="text-center">However, you can help: <br> share a <strong>review</strong>, make a <strong>video</strong>, and start a <strong>new discussion!</strong></p>
        ';
      }
      // Close Connection
      mysqli_close($conn);
    ?>
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>