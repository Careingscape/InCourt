<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    require_once('./config.php');

    if (isset($_POST["register"])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        $mail = new PHPMailer(true);

                    try {
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                        $mail->isSMTP();                                          
                        $mail->Host       = 'smtp.gmail.com';                   
                        $mail->SMTPAuth   = true;                                  
                        $mail->Username   = 'pererdan7@gmail.com';                   
                        $mail->Password   = 'cssxwldekpaffmdf';                            
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
                        $mail->Port       = 465;                                    

                        $mail->setFrom('pererdan7@gmail.com');
                        $mail->addAddress($email, $fullname);

                        $mail->isHTML(true);
                        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);                                  
                        $mail->Subject = 'Email verification';
                        $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' .
                            $verification_code . '</b></p>';

                        $mail->send();
                        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

                        $conn = mysqli_connect("localhost:8889", "root", "root", "scbs_db");
                        $sql = "INSERT INTO client_list(fullname, email, password, verification_code, email_verified_at) VALUES ('" . $fullname . "', '" . $email . "','" . $encrypted_password . "','" . $verification_code . "', NULL)";
                        mysqli_query($conn, $sql);

                        header("Location: email-verification.php?email=" . $email);
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
?> 
<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/signup.css">
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/alert.css">
    <title>Register</title>
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
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
   </head>
   <body class="">
  <script>
    start_loader()
  </script>
      <div class="container">
        <div class="forms-container">
          <div class="signin-signup">
            <form id="register-frm" action="" method="post">
              <input type="hidden" name="id">
            <h2 class="title">Sign up</h2>
              <div class="input-field">
              <i class="fas fa-lock"></i>
                    <input type="text" name="fullname" id="fullname" placeholder="Your Name" autofocus  required>
              </div>
              <div class="input-field">
              <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email"  required>
              </div>
              <div class="input-field">
              <i class="fas fa-phone"></i>
                <input type="text" name="contact" id="contact" placeholder="Contact No"  required pattern="[0-9]{11}" oninvalid="this.setCustomValidity('Enter 11 Digits Number')" oninput="this.setCustomValidity('')">
              </div>
              <div class="input-field">
              <i class="fas fa-address-book"></i>
                <input type="text" name="address" id="address" class="form-control form-control-sm rounded-0" placeholder="Address"></textarea>
              </div>
              <div class="input-field">
              <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password"  required>
              </div>
              <div class="input-field">
              <i class="fas fa-unlock"></i>
                <input type="password" id="cpassword" placeholder="Confirm Password"  required>
              </div>
              <div class="gender-details">
                <span class="gender-title">Gender</span>
                      <select name="gender" id="gender" class="dropdown dropdown-select" required>
                        <option>Male</option>
                        <option>Female</option>
                      </select>
              </div>
                  <button type="submit" name="register" value="Register" class="btn btn-primary btn-sm btn-flat btn-block">Register</button>
                  <p>Have an Account? <a href="login.php" class="btn-forgot">Sign In</a></p>
              </div>
            </form>
          </div>
        </div>
        <div class="panels-container">
        <div class="panel left-panel">
          <img src="./assets/img/signup.svg" class="image" alt="" />
        </div>
      </div>
      </div>

<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?= base_url ?>dist/js/adminlte.min.js"></script> -->

<script>
  window.displayImg = function(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
  $(document).ready(function(){
    end_loader();
    $('.pass_type').click(function(){
      var type = $(this).attr('data-type')
      if(type == 'password'){
        $(this).attr('data-type','text')
        $(this).closest('.input-group').find('input').attr('type',"text")
        $(this).removeClass("fa-eye-slash")
        $(this).addClass("fa-eye")
      }else{
        $(this).attr('data-type','password')
        $(this).closest('.input-group').find('input').attr('type',"password")
        $(this).removeClass("fa-eye")
        $(this).addClass("fa-eye-slash")
      }
    })
    $('#register-frm').submit(function(e){
      e.preventDefault()
      var _this = $(this)
			 $('.err-msg').remove();
       var el = $('<div>')
            el.hide()
      if($('#password').val() != $('#cpassword').val()){
        el.addClass('alert alert-danger err-msg').text('Password does not match.');
        _this.prepend(el)
        el.show('slow')
        return false;
      }
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Users.php?f=save_client",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./login.php";
					}else if(resp.status == 'failed' && !!resp.msg){   
              el.addClass("alert alert-danger err-msg").text(resp.msg)
              _this.prepend(el)
              el.show('slow')
          }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
          $('html, body').scrollTop(0)
				}
			})
    })
  })
</script>
</body>
</html>