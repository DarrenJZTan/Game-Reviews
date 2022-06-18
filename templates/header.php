<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- External CSS -->
  <link rel="stylesheet" href="./styles.css">
  <title>VGReviews</title>
</head>
<body>
  <header class="container-fluid bg-dark text-white">
    <nav class="navbar navbar-expand-md navbar-dark py-2">
      <!-- Navbar (Hamburger Menu) -->
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNavbar">
          <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Navbar (Left) -->
      <div class="navbar-nav mx-5 p-2">
        <a id="logo" class="display-1" href="index.php">VG<span class="text-muted px-1">Reviews</span></a>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Navbar (Right) -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item mx-3 fs-5">
            <a class="nav-link" href="review.php">Reviews</a>
          </li>
          <!-- CONDITIONAL LOGOUT/LOGIN BUTTON: Displayed when user is logged in/logged out -->
          <?php 
            if(isset($_SESSION['userId'])){ 
              echo '<li class="nav-item mx-3 fs-5">
                <form action="includes/logout.inc.php" action="POST">
                  <button type="submit" class="bg-transparent border-0 nav-link" name="logout-submit"><img id="loginImage" src="./websiteImages/logo-icon-person-on-white-background-free-vector.jpg" alt="loginImage">&nbsp; Logout</button>
                </form>
              </li>';
            } else {
              // Login Button based on NO $_SESSION variable 
              echo '<li class="nav-item mx-3 fs-5">
              <a class="nav-link" href="login.php"><img id="loginImage" src="./websiteImages/logo-icon-person-on-white-background-free-vector.jpg" alt="loginImage">&nbsp; Login</a>
            </li>';
            }
          ?>  
        </ul>
      </div>
    </nav>
  </header>