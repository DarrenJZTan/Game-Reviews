<!-- HEADER.PHP -->
<?php 
  require "templates/header.php";
  if(isset($_SESSION['userId'])) {
    header("Location: ./welcome.php");
    exit(); 
  }
?>

<!-- Main Landing Page for logout users -->
  <main class="container d-flex flex-grow-1 flex-column" id="main-index">
    <div class="row d-flex flex-grow-1 justify-content-center">
      <div class="d-flex align-items-center">
        <div class="col text-light px-5">
          <h1 class="fs-1 display-1">
            Your favourite <span class="fw-bold">video games</span><br>
            and entertainment media website &mdash;
          </h1>
          <p class="lead mt-5">Add your own reviews</p>
          <button type="button" onclick="location.href='signup.php'" class="btn btn-dark px-5">Sign Up</button>
        </div>
        <div class="col text-center">
          <img class="w-75" src="./websiteImages/580b57fcd9996e24bc43c314.png" alt="pacman">
        </div>
      </div>
    </div>
  </main>
<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>