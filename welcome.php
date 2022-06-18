<?php 
  require "templates/header.php";

  if(!isset($_SESSION['userId'])) {
    header("Location: ./index.php");
    exit(); 
  }
?>
<div class="container m-auto position-relative">
  <img class="position-absolute w-50 translate-middle top-50 " src="./websiteImages/welcome-1030x350.png" alt="Welcome" style="left: 250px">
  <main class="container p-5 bg-light me-0 text-center " style="width: 35%">
    <h2>Welcome Back, <?php echo $_SESSION['userUid']?>!</h2>
    <p class="lead">Have you seen the latest video game reviews? Why not head over there and give it a read!</p>
    <p class="lead">We're sure you'll love it!</p>
    <button type="button" onclick="location.href='review.php'" class="btn btn-dark px-5">Check it out</button>
  </main>
</div>
<?php 
  require "templates/footer.php";
?>