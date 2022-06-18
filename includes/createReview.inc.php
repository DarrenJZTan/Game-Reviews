<?php
  session_start();

  if(isset($_POST['review-submit']) && isset($_SESSION['userId'])){
    require 'connect.inc.php';

    $directory = "uploadedImages";

    $title = $_POST['title'];
    $author = $_SESSION['userUid'];
    $subtitle = $_POST['subtitle'];
    $image = $_FILES['fileToUpload']['name'];
    $comment = $_POST['reviewtext'];

    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    $target_file = $_FILES['fileToUpload']['name'];
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $my_url = "../" . $directory . "/" . $target_file;
    $db_url = "./" . $directory . "/" . $target_file;

    $the_error = $_FILES['fileToUpload']['error'];
    
    if (empty($title ) || empty($subtitle) || empty($image) || empty($comment) ) {
      header("Location: ../createReview.php?error=emptyfields&title=".$title."&subtitle=".$subtitle."&comment=".$comment);
      exit();
    } else if($_FILES['fileToUpload']['error'] != 0) {
      header("Location: ../createReview.php?error=".$the_error);
      exit();
    } else if (file_exists($my_url)) {
      header("Location: ../createReview.php?error=exists&title=".$title."&subtitle=".$subtitle."&comment=".$comment);
      exit();
    } else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg") {
      header("Location: ../createReview.php?error=invalidFile&title=".$title."&subtitle=".$subtitle."&comment=".$comment);
      exit();
    } else {
      $sql = "INSERT INTO reviews VALUES (NULL, ?, ?, ?, ?, ?, NOW())";
      $statement = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../createReview.php?error=sqlerror"); 
        exit();
      } else { 
        echo $sql;
        mysqli_stmt_bind_param($statement, "sssss", $title, $author, $subtitle, $db_url, $comment);
        if(move_uploaded_file($temp_name, $my_url)){
          mysqli_stmt_execute($statement);
          header("Location: ../review.php?post=success");
          exit();
        } else {
          header("Location: ../createReview.php?error=sqlerror");
          exit();
        }
      }
    }
  } else {
    header("Location: ../index.php");
    exit();
  }
?>