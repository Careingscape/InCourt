<?php
if (isset($_POST["login"]))
{
  $email = $_POST["email"];
  $password = $_POST["password"];

  $conn = mysqli_connect("localhost:8889", "root", "root", "scbs_db");
  $sql = "SELECT * FROM client_list WHERE email = '" . $email . "'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0)
  {
    die("Email not found.");
  }
  $user = mysqli_fetch_object($result);
  if (!password_verify($password, $user->password))
  {
    die("Password is not correct");
  }
  if ($user->email_verified_at == null)
  {
    die("Please verify your email <a href='email-verification.php?email=" . $email . "'>from here</a>");
  }

  echo "<p>Your login logic here</p>";
  exit();
}
?>

<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/login.css" />
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/alert.css">
    <title>Login</title>
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
  </head>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>

<div class="container">
<?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
     <?php if($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
      </script>
    <?php endif;?>

    <div class="forms-container">
        <div class="signin-signup">

        <form id="clogin-frm" class="sign-in-form" action="" method="post">
        <h2 class="title">Sign in</h2>
        <div class="input-field"> 
          <i class="fas fa-user"></i>
          <input type="email" class="form-control" name="email" autofocus placeholder="Email">
        </div>
        <div class="input-field mb-3">
          <i class="fas fa-lock"></i>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <a href="#" class="btn-forgot">Forgot Password?</a>
        <br>
        <button type="submit" name="login" value="Login" class="btn btn-primary btn-sm btn-flat btn-block">Login</button>
        <p>New here? <a href="register.php">Sign Up</a></p>
        </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <img src="./assets/img/login.svg" class="image" alt="" />
        </div>
      </div>
    </div>

<script src="./assets/js/app.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>