<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>

<?php 
  if(isset($_GET['loginerror'])){
    if($_GET['loginerror'] == "emptyusername" || $_GET['loginerror'] == "emptypassword"){
      $errorMsg = "Please fill in all fields";
    } else if ($_GET['loginerror'] == "sqlerror") {
      header("Location: ./500Error.php");
    } else if ($_GET['loginerror'] == "wrongCredentials") {
      $errorMsg = "The username or password is incorrect. Please try again.";
    } 
  } else if (isset($_GET['login']) == "success") {
    header("Location: ./welcome.php");    
  }

?>

<main class="container p-4 bg-light mt-5" style="width: 750px">
<!-- Form -->
<form class="py-4 px-5" action="includes/login.inc.php" method="POST">
  <div class="mb-3">
    <label for="emailusername" class="form-label">Username or Email</label>
    <input 
      type="text" 
      class="form-control 
      <?php 
        if(isset($_GET['loginerror'])) {
          if($_GET['loginerror'] == "emptyusername") {
            echo ' is-invalid';
          } else {
            echo '';
          }
        }
      ?>" 
      name="emailusername" 
      placeholder="Username or Email"
      value=
      <?php 
        if(isset($_GET['emailusername'])){ 
          echo($_GET['emailusername']);
        } else {
          echo null;
        }
      ?> 
    >
    <div class="form-text text-danger invalid-feedback"><?php echo $errorMsg ?></div>    
  </div>
  <div class="mb-3 form-group">
    <label for="password" class="form-label">Password</label>
    <input 
      type="password" 
      class="form-control
      <?php 
        if(isset($_GET['loginerror'])) {
          if($_GET['loginerror'] == "emptypassword" || $_GET['loginerror'] == "wrongCredentials") {
            echo ' is-invalid';
          } else {
            echo '';
          }
        }
      ?>" 
      name="password" 
      placeholder="Password">
    <div class="form-text text-danger invalid-feedback"><?php echo $errorMsg ?></div>
  </div>

  <div class="form-text mb-3">
    New? <a href="./signup.php">Sign up here</a>
  </div>

  <div class="d-grid gap-2">
    <button type="submit" name="loginSubmitted" class="btn btn-dark mb-3">Log In</button>
  </div>
</form>

</main>
<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>