<?php
  session_start();
  if(isset($_POST['update-submit']) && isset($_SESSION['userId'])){
    require 'connect.inc.php';

    $id = mysqli_real_escape_string($conn, $_GET['id']); 
    $id = intval($id);
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $comment = $_POST['reviewtext'];

    if (empty($title) || empty($subtitle) || empty($comment) ) {
      header("Location: ../updateReview.php?id=$id&error=emptyfields");
      exit();
    } else {
      $sql = "UPDATE reviews SET title=?, subtitle=?, comment=? WHERE id=?"; 

      $statement = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../updateReview.php?id=$id&error=sqlerror"); 
        exit();
      } else {
        mysqli_stmt_bind_param($statement, "sssi", $title, $subtitle, $comment, $id);

        mysqli_stmt_execute($statement);

        header("Location: ../review.php?id=$id&edit=success"); 
        exit();
      }
    }

  } else {
    header("Location: ../signup.php");
    exit();
  }
?>