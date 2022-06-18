<?php 
  // Make sure user clicked submit button from signup
  if(isset($_POST['signupSubmitted'])){

    // Connect to database
    require 'connect.inc.php';

    // Variables
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password-repeat'];
    
    //Password Validation Variables
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    // Human Error Validation: 
    // Error: Field Empty
    if(empty($username) || empty($email) || empty($password)) {
      if(empty($username) && empty($email) && empty($password)) {
        header("Location: ../signup.php?error=emptyall");
      } else if(empty($username) && empty($email) && !empty($password)) {
        header("Location: ../signup.php?error=emptyemailusername");
      } else if (empty($username) && !empty($email) && !empty($password)) {
        header("Location: ../signup.php?error=emptyusername&email=".$email);
      } else if (!empty($username) && !empty($email) && empty($password)) {
        header("Location: ../signup.php?error=emptypassword&username=".$username."&email=".$email);
      } else if (!empty($username) && empty($email) && empty($password)) {
        header("Location: ../signup.php?error=emptyemailpassword&username=".$username);
      } else if (!empty($username) && empty($email) && !empty($password)) {
        header("Location: ../signup.php?error=emptyemail&username=".$username);
      } else if (empty($username) && !empty($email) && empty($password)) {
        header("Location: ../signup.php?error=emptyusernamepassword&email=".$email);
      }
      exit(); 

    // Error: Invalid email and username syntax 
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
      header("Location: ../signup.php?error=invalidemailusername&username=".$username."&email=".$email);
      exit(); 

    // Error: Username invalid
    } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
      header("Location: ../signup.php?error=invalidusername&username=".$username."&email=".$email);
      exit();
      
    // Error: Email invalid
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location: ../signup.php?error=invalidemail&username=".$username."&email=".$email);
      exit(); 


    // Error: Password at least 8 characters, has a upper case, lower case and number
    } else if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
      header("Location: ../signup.php?error=invalidpassword&username=".$username."&email=".$email);
      exit();

    // Error: Confirm password is the same
    } else if($password !== $passwordRepeat){
      header("Location: ../signup.php?error=passwordcheck&username=".$username."&email=".$email);
      exit();  

    } else {

      // Database Errors Check (Exists + Prepared Statements):
      // Template SQL: Looking for usernames
      $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";

      // Init
      $statement = mysqli_stmt_init($conn);

      // Error: SQL
      if(!mysqli_stmt_prepare($statement, $sql)) {        
        header("Location: ../signup.php?error=sqlerror"); 
        exit();

      } else {

        // Bind user data + escape strings
        mysqli_stmt_bind_param($statement, "s", $username);

        // Execute the SQL Statement
        mysqli_stmt_execute($statement);

        // Return result
        mysqli_stmt_store_result($statement);

        // Check if username rows exist
        $usernameResultCheck = mysqli_stmt_num_rows($statement);
        
        //Email Check
        //Template SQL: Looking for emails
        $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";

        // Init
        $statement = mysqli_stmt_init($conn);

        // Error: SQL
        if(!mysqli_stmt_prepare($statement, $sql)) {        
          header("Location: ../signup.php?error=sqlerror"); 
          exit(); 
        
        } else {

          // Bind user data + escape strings
          mysqli_stmt_bind_param($statement, "s", $email);

          // Execute the SQL Statement
          mysqli_stmt_execute($statement);

          // Return result
          mysqli_stmt_store_result($statement);

          // Check if username rows exist
          $emailResultCheck = mysqli_stmt_num_rows($statement);
          
          // Error: username taken
          if($usernameResultCheck > 0){
            header("Location: ../signup.php?error=usertaken&email".$email); 
            exit();  

          // Error: email taken
          } else if ($emailResultCheck > 0) {
            header("Location: ../signup.php?error=emailtaken&username".$username); 
            exit(); 
            
          } else {

            // TEST SUCCESS: No user exists
            // Template SQL: Inserting user data
            $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";

            // Init 
            $statement = mysqli_stmt_init($conn);

            // Error: SQL
            if(!mysqli_stmt_prepare($statement, $sql)){
              header("Location: ../signup.php?error=sqlerror");
              exit(); 

            } else {
              
              // Hash password
              $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

              // Bind user data + escape strings
              mysqli_stmt_bind_param($statement, "sss", $username, $email, $hashedPwd);

              // Execute the SQL Statement
              mysqli_stmt_execute($statement);

              // Success -> redirected to welcome
              $idUsers = mysqli_stmt_insert_id($statement); 
              session_start();
              $_SESSION['userId'] = $idUsers;
              $_SESSION['userUid'] = mysqli_real_escape_string($conn ,$username);
              header("Location: ../index.php?signup=success");
              exit();

            }
          }
        }
      }
    }
    // Close prepared statement + connection
    mysqli_stmt_close($statement); 
    mysqli_close($conn); 

  // Restricted Access -> redirected to signup
  } else {
    header("Location: ../signup.php");
    exit(); 
  }
?>