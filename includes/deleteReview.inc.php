<?php
  session_start();
  if(isset($_SESSION['userId']) && isset($_GET['id'])){
    require 'connect.inc.php';
    
    $id = mysqli_real_escape_string($conn, $_GET['id']); 

    $id = intval($id);

    $sql = "SELECT `image` FROM reviews WHERE id=?";

    $statement = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($statement, $sql)) {
      header("Location: ../review.php?error=sqlerror"); 
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "i", $id);

      mysqli_stmt_execute($statement);

      $result = mysqli_stmt_get_result($statement); 

      $row = mysqli_fetch_assoc($result);

      $path = ".". $row["image"];

      unlink($path);

      $sql = "DELETE FROM reviews WHERE id=?";

      $statement = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($statement, $sql))
        {
          header("Location: ../posts.php?error=sqlerror"); 
          exit();
        } else {
          mysqli_stmt_bind_param($statement, "i", $id);
    
          mysqli_stmt_execute($statement);
    
          header("Location: ../review.php?id=$id&delete=success"); 
          exit();
        }

      header("Location: ../review.php?id=$id&delete=success"); 
      exit();
    }
  } else {
    header("Location: ../signup.php");
    exit();
  }
?>