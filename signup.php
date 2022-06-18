<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>

<main class="container p-4 bg-light mt-5" style="width: 750px">

  <!-- signup.inc.php - Will process the data from this form-->
  <form class="py-4 px-5" action="includes/signup.inc.php" method="POST">
    <div class="mb-5">
      <h2>Sign Up Now &mdash; It&rsquo;s Free &amp; Easy!</h2>
    </div>

    <?php 
      if(isset($_GET['error'])){
        if($_GET['error'] == "emptyall" || $_GET['error'] == "emptyemailusername" || $_GET['error'] == "emptyusername" || $_GET['error'] == "emptypassword" || $_GET['error'] == "emptyemailpassword"|| $_GET['error'] == "emptyemail" || $_GET['error'] == "emptyusernamepassword"){
          $errorMsg = "Please fill in all fields";
        } else if ($_GET['error'] == "invalidemailusername") {
          $errorMsg = "Username should only contain Latin letters and numbers";
        } else if ($_GET['error'] == "invalidusername") {
          $errorMsg = "Username should only contain Latin letters and numbers";
        } else if ($_GET['error'] == "invalidemail") {
          $errorMsg = "This is not a valid email format";
        } else if ($_GET['error'] == "passwordcheck") {
          $errorMsg = "Passwords do not match";
        } else if ($_GET['error'] == "usertaken") {
          $errorMsg = 'This username is taken. <a href="./login.php">Login Here</a> if this is you!';
        } else if ($_GET['error'] == "emailtaken") {
          $errorMsg = 'This email is taken. <a href="./login.php">Login Here</a> if this is you!';
        } else if ($_GET['error'] == "sqlerror") {
          header("Location: ./500Error.php");
        }
      } else if (isset($_GET['signup']) == "success") {
        header("Location: ./welcome.php");    
      }

    ?>

    <!-- USERNAME -->
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input 
        type="text" 
        class="form-control 
        <?php 
          if(isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyall' || $_GET['error'] == 'emptyemailusername' || $_GET['error'] == 'emptyusername' || $_GET['error'] == 'emptyusernamepassword' || $_GET['error'] == "invalidemailusername" || $_GET['error'] == "invalidusername" || $_GET['error'] == "usertaken") {
              echo ' is-invalid';
            } else {
              echo '';
            }
          } 
        ?>" 
        name="username" 
        placeholder="Username"
        value=
        <?php 
          if(isset($_GET['username'])){ 
            echo($_GET['username']);
          } else {
            echo null;
          }
        ?> 
      >
      <div class="form-text text-danger invalid-feedback"><?php echo $errorMsg ?></div>
    </div>

    <!-- EMAIL -->
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input 
        type="email" 
        class="form-control 
        <?php 
          if(isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyall' || $_GET['error'] == 'emptyemailusername' || $_GET['error'] == 'emptyemail' || $_GET['error'] == 'emptyemailpassword' || $_GET['error'] == "invalidemailusername" || $_GET['error'] == "invalidemail" || $_GET['error'] == 'emailtaken') {
              echo ' is-invalid';
            } else {
              echo '';
            }
          } 
        ?>" 
        name="email" 
        placeholder="Email Address" 
        value=         
        <?php 
          if(isset($_GET['email'])){ 
            echo($_GET['email']);
          } else {
            echo null;
          }
        ?> >
      <?php 
        if(isset($_GET['error'])) {
          if ($_GET['error'] == 'emptyall' || $_GET['error'] == 'emptyemailusername' || $_GET['error'] == 'emptyemail' || $_GET['error'] == 'emptyemailpassword') {
            echo '<div class="form-text text-danger invalid-feedback">'. $errorMsg . '</div>';
          } else if ($_GET['error'] == "invalidemailusername" || $_GET['error'] == "invalidemail") {
            echo '<div class="form-text text-danger invalid-feedback">This is not a valid email format</div>';
          } else {
            echo '<div class="form-text"> We\'ll never share your email with anyone else.</div>';
          }
        } else {
          echo '<div class="form-text"> We\'ll never share your email with anyone else.</div>';
        } ?> 
    </div>

    <!-- PASSWORD -->
    <div class="mb-3 form-group">
      <label for="password" class="form-label">Password</label>
      <input 
        type="password" 
        class="form-control 
        <?php 
          if(isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyall' || $_GET['error'] == 'emptyusernamepassword' || $_GET['error'] == 'emptypassword' || $_GET['error'] == 'emptyemailpassword' || $_GET['error'] == "invalidpassword") {
              echo ' is-invalid';
            } else {
              echo '';
            }
          } 
        ?>" 
        name="password" 
        placeholder="Password">
      <div class="form-text 
        <?php 
          if(isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyall' || $_GET['error'] == 'emptyusernamepassword' || $_GET['error'] == 'emptypassword' || $_GET['error'] == 'emptyemailpassword' || $_GET['error'] == "invalidpassword") { 
              echo ' text-danger'; 
            } else {
              echo '';
            }
          } 
        ?>">
        Your password should be at least 8 characters in length and should include at least one upper case letter, and one number.
      </div>
    </div>

    <!-- PASSWORD CONFIRMATION -->
    <div class="mb-3 ">
      <label for="password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control <?php 
        if(isset($_GET['error'])) {
          if ($_GET['error'] == "passwordcheck") {
            echo ' is-invalid';
          } else {
            echo '';
          }
        }
      ?>" name="password-repeat" placeholder="Confirm Password">
      <?php 
        if(isset($_GET['error'])) {
          if ($_GET['error'] == "passwordcheck") {
            echo '<div class="form-text text-danger">'. $errorMsg . '</div>';
          } else {
            echo '';
          }
        }
      ?>
    </div>

    <div class="form-text mb-3">
      Already have an account? <a href="./login.php">Sign in</a> .
    </div>

    <!-- SUBMIT BUTTON -->
    <div class="d-grid gap-2">
      <button type="submit" name="signupSubmitted" class="btn btn-dark mb-3">Sign Up</button>
    </div>

    <div class="form-text">
      I accept the site <a href="#">Terms of Service</a> and agree to the <a href="#">Privacy Policy</a>.
    </div>
  </form>

</main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>