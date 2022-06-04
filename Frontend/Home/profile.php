<?php
include("auth_session.php");
?>
<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

$new_username = $confirm_username = "";
$new_username_err = $confirm_username_err = "";

// Processing form data when form is submitted
if (isset($_POST['password_button'])) {

  // Validate new password
  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "Please enter the new password.";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "Password must have atleast 6 characters.";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm the password.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($new_password_err) && ($new_password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Check input errors before updating the database
  if (empty($new_password_err) && empty($confirm_password_err)) {
    // Prepare an update statement
    $sql = "UPDATE users SET password = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

      // Set parameters
      $param_password = password_hash($new_password, PASSWORD_DEFAULT);
      $param_id = $_SESSION["id"];

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Password updated successfully. Destroy the session, and redirect to login page
        session_destroy();
        header("location: sign-in.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($link);
}
if (isset($_POST['username_button'])) {

  // Validate new password
  if (empty(trim($_POST["new_username"]))) {
    $new_username_err = "Please enter the new username.";
  } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["new_username"]))) {
    $new_username_err = "Username can only contain letters, numbers, and underscores.";
  } else {
    $new_username = trim($_POST["new_username"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_username"]))) {
    $confirm_username_err = "Please confirm the username.";
  } else {
    $confirm_username = trim($_POST["confirm_username"]);
    if (empty($new_username_err) && ($new_username != $confirm_username)) {
      $confirm_username_err = "Username did not match.";
    }
  }

  // Check input errors before updating the database
  if (empty($new_username_err) && empty($confirm_username_err)) {
    // Prepare an update statement
    $sql = "UPDATE users SET username = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_username, $param_id);


      // Set parameters
      $param_username = $new_username;
      $param_id = $_SESSION["id"];

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Password updated successfully. Destroy the session, and redirect to login page
        session_destroy();
        header("location: sign-in.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include("head.html");
?>
<script src="assets/js/jquery-1.11.0.js"></script>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-gradient-primary position-absolute w-100"></div>
  <?php
  include("sidebar.html");
  ?>
  <div class="main-content position-relative max-height-vh-100 h-100">
    <?php
    include("navbar.php");
    ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="text-center">
                <p class="mb-0 fw-bold fs-5">Edit User Information</p>
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">Edit Username</p>
              <div class="row">
                <div class="col-md-12">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>New Username</label>
                          <input type="text" name="new_username" class="form-control <?php echo (!empty($new_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_username; ?>">
                          <span class="invalid-feedback"><?php echo $new_username_err; ?></span>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Confirm Username</label>
                          <input type="text" name="confirm_username" class="form-control <?php echo (!empty($new_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_username; ?>">
                          <span class="invalid-feedback"><?php echo $new_username_err; ?></span>
                        </div>
                      </div>
                    </div>
                    <center>
                      <div class="form-group">
                        <input type="submit" name="username_button" class="btn btn-primary" value="Submit">
                        <a class="btn btn-link ml-2" href="profile.php">Cancel</a>
                      </div>
                    </center>
                  </form>
                </div>
              </div>
              <hr class="horizontal dark" />
              <p class="text-uppercase text-sm">Reset Password</p>
              <div class="row">
                <div class="col-md-12">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>New Password</label>
                          <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                          <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                          <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                      </div>
                    </div>
                    <center>
                      <div class="form-group">
                        <input type="submit" name="password_button" class="btn btn-primary" value="Submit">
                        <a class="btn btn-link ml-2" href="profile.php">Cancel</a>
                      </div>
                    </center>
                  </form>
                </div>
              </div>
              <hr class="horizontal dark" />
            </div>
          </div>
        </div>
        <div class="col-md-4" style="font-family: Raleway !important">
          <div class="card card-profile">
            <div class="card-body pt-0">
              <div class="card-header pb-0">
                <div class="text-center">
                  <p class="mb-0 fw-bold fs-5">User Information</p>
                </div>
              </div>
              <div class="text-center mt-4">
                <div class="h5">
                  Username - <span class=" fw-normal fst-italic"> <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                </div>
              </div>
              <div class="text-left mt-4">
                <script>
                  $.ajax({
                    url: "https://geolocation-db.com/jsonp",
                    jsonpCallback: "callback",
                    dataType: "jsonp",
                    success: function(location) {
                      $('#country').html(location.country_name);
                      $('#state').html(location.state);
                      $('#city').html(location.city);
                      $('#ip').html(location.IPv4);
                    }
                  });
                </script>
                <div class="h5 font-weight-300">
                  Country - <span class="fw-normal fst-italic" id="country"></span>
                </div>
                <div class="h5 font-weight-300">
                  City - <span class="fw-normal fst-italic" id="city"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      include("footer.html");
      ?>
    </div>
  </div>

  <!--   Core JS Files   -->
  <?php
  include("core.html");
  ?>

</body>

</html>