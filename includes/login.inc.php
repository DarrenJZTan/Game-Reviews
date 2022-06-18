<?php 
  if(isset($_POST['loginSubmitted'])) {
    require 'connect.inc.php';

    $emailusername = $_POST['emailusername'];
    $password = $_POST['password'];

    if(empty($emailusername)) {
      header("Location: ../login.php?loginerror=emptyusername");
      exit(); 
    } else if (empty($password)) {
      header("Location: ../login.php?loginerror=emptypassword&emailusername=".$emailusername);
      exit(); 
    } else {
      $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?"; 
      $statement = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($statement, $sql)) {
        //sql error
        header("Location: ../login.php?loginerror=sqlerror"); 
        exit();
      } else {
        mysqli_stmt_bind_param($statement, "ss", $emailusername, $emailusername);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement); 
        if($row = mysqli_fetch_assoc($result)) {
          $passwordCheck = password_verify($password, $row['pwdUsers']);
          if($passwordCheck == false){
            //Wrong password
            header("Location: ../login.php?loginerror=wrongCredentials&emailusername=".$emailusername);
            exit(); 
          } else if ($passwordCheck == true) {
            //Success
            session_start();
            $_SESSION['userId'] = $row['idUsers']; 
            $_SESSION['userUid'] = $row['uidUsers']; 
            header("Location: ../login.php?login=success");
            exit(); 
          } else {
            //Catch error
            header("Location: ../login.php?loginerror=wrongCredentials&emailusername=".$emailusername);
            exit(); 
          }
        } else {
          //No user
          header("Location: ../login.php?loginerror=wrongCredentials&emailusername=".$emailusername);
          exit(); 
        }
      }
    }
  } else {
    //Restriction
    header("Location: ../index.php");
    exit();
  }
?>