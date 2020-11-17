<?php

include('master/Examination.php');

$exam = new Examination;

$exam->user_session_public();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>Online Advance E-Learning System</title>
  <!-- Nucleo Icons -->
  <link href="style/css/nucleo-icons.css" rel="stylesheet" />
  <link href="style/css/nucleo-svg.css" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="style/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/css/style.css">
  <link rel="stylesheet" href="style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS Files -->
  <link href="style/css/argon-design-system.css?v=1.2.0" rel="stylesheet" />

  <!-- JavaScript Files -->
  <script src="style/js/jquery-3.4.0.min.js"></script>
  <script src="style/js/parsley.js"></script>
  <script src="style/js/popper.min.js"></script>
  <script src="style/js/bootstrap.min.js"></script>
</head>

<body class="login-page">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
    <div class="container">
      <a class="navbar-brand mr-lg-5" href="index.php">
        <h2 style="color:#fff;"><strong>AE-Learning</strong></h2>
        <!-- <img src="./assets/img/brand/white.png"> -->
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbar_global">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a class="navbar-brand mr-lg-5" href="index.php">
                <h2 style="color:#fff;"><strong>AE-Learning</strong></h2>
                <!-- <img src="./assets/img/brand/white.png"> -->
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Like us on Facebook">
              <i class="fa fa-facebook-square"></i>
              <span class="nav-link-inner--text d-lg-none">Facebook</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Follow us on Instagram">
              <i class="fa fa-instagram"></i>
              <span class="nav-link-inner--text d-lg-none">Instagram</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Follow us on Twitter">
              <i class="fa fa-twitter-square"></i>
              <span class="nav-link-inner--text d-lg-none">Twitter</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Star us on Github">
              <i class="fa fa-github"></i>
              <span class="nav-link-inner--text d-lg-none">Github</span>
            </a>
          </li>
          <li class="nav-item d-none d-lg-block ml-lg-4">
            <a href="tutor/Login.php" target="_blank" class="btn btn-neutral btn-icon">
              <span class="btn-inner--icon">
                <i class="fa fa-sign-in"></i>
              </span>
              <span class="nav-link-inner--text">Lecturer Login</span>
            </a>
            <a href="master/Login.php" target="_blank" class="btn btn-neutral btn-icon">
              <span class="btn-inner--icon">
                <i class="fa fa-sign-in"></i>
              </span>
              <span class="nav-link-inner--text">Admin Login</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <section class="section section-shaped section-lg">
    <div class="shape shape-style-1 bg-gradient-default">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="container pt-lg-7">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <span id="message"></span>
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-white pb-5">
              <div class="btn-wrapper text-center">
                <h1><i class="fa fa-user"></i></h1>
                <h4 style="margin-top:-15px;"><b>Student Registration</b></h4>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form method="post" id="user_register_form">
                <div class="form-group">
                  <label>Matric Number</label>
                  <input type="text" name="matric_no" id="matric_no" class="form-control" data-parsley-checkmatricno data-parsley-checkmatricno-message="Matric Number already Exists">
                </div>
                <div class="form-group">
                  <label>Enter Email Address</label>
                  <input type="text" name="user_email_address" id="user_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message="Address already Exists">
                </div>
                <div class="form-group">
                  <label>Enter Password</label>
                  <input type="password" name="user_password" id="user_password" class="form-control">
                </div>
                <div class="form-group">
                  <label>Enter Confirm Password</label>
                  <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control">
                </div>
                <div class="form-group">
                  <label>Enter Name</label>
                  <input type="text" name="user_name" id="user_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Select Gender</label>
                  <select name="user_gender" id="user_gender" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Enter Address</label>
                  <textarea name="user_address" id="user_address" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Enter Mobile Number</label>
                  <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control">
                </div>
                <div class="form-group">
                  <label>Select Department</label>
                  <select name="department_id" id="department_id" class="form-control">
                    <option selected="selected" disabled = "disabled">Select Department</option>
                    <?php echo $exam->Get_data('department_table', 'department_id', 'department_name'); ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Select Level</label>
                  <select name="level_id" id="level_id" class="form-control">
                    <option selected="selected" disabled = "disabled">Select Level</option>
                    <?php echo $exam->Get_data('level_table', 'level_id', 'level_code'); ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Select Profile Image</label>
                  <input type="file" name="user_image" id="user_image" />
                </div>
                <br />
                <div class="form-group" align="center">
                  <input type="hidden" name="page" value="register" />
                  <input type="hidden" name="action" value="register" />
                  <input type="submit" name="user_register" id="user_register" class="btn btn-primary btn-sm" />
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="login.php" class="text-light"><small>Login to account</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
      <footer class="footer">
      <div class="container">
        <div class="row row-grid align-items-center mb-5">
          <div class="col-lg-6">
            <h3 class="text-primary font-weight-light mb-2">Thank you for using our system!</h3>
            <h4 class="mb-0 font-weight-light">Let's get in touch on any of these platforms.</h4>
          </div>
          <div class="col-lg-6 text-lg-center btn-wrapper">
            <button target="_blank" href="#" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-twitter"></i></span>
            </button>
            <button target="_blank" href="#" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
              <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
            </button>
            <button target="_blank" href="#s" rel="nofollow" class="btn btn-icon-only btn-dribbble rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-dribbble"></i></span>
            </button>
            <button target="_blank" href="# rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
              <span class="btn-inner--icon"><i class="fa fa-github"></i></span>
            </button>
          </div>
        </div>
        <hr>
        <div class="row align-items-center justify-content-md-between">
          <div class="col-md-6">
            <div class="copyright">
              &copy; 2020 <a href="" target="_blank">Advance E-learning System</a>.
            </div>
          </div>
          <div class="col-md-6">
            <ul class="nav nav-footer justify-content-end">
              <li class="nav-item">
                <a href="" class="nav-link" target="_blank">Advance E-learning System</a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

<script>
$(document).ready(function(){
  window.Parsley.addValidator('checkemail', {
    validateString: function(value){
      return $.ajax({
        url:"user_ajax_action.php",
        method:"POST",
        data:{page:'register', action:'check_email', email:value},
        dataType:"json",
        async:false,
        success:function(data)
        {
          return true;
        } 
      });
    }
  });

  window.Parsley.addValidator('checkmatricno', {
    validateString: function(value){
      return $.ajax({
        url:"user_ajax_action.php",
        method:"POST",
        data:{page:'register', action:'check_matricno', matric_no:value},
        dataType:"json",
        async:false,
        success:function(data)
        {
          return true;
        } 
      });
    }
  });

  window.ParsleyValidator.addValidator('fileextension', function(value, requirement){
    var fileExtension = value.split('.').pop();
    return fileExtension === requirement;
  }, 32).addMessage('en', 'fileextension', 'The extension doesn\'t match the required');

  $('#user_register_form').parsley();

  $('#user_register_form').on('submit', function(event){
    event.preventDefault();

    var matric = new RegExp(/^\d{2}\/\d{4}$/);
    $('#user_email_address').attr('required', 'required');
    $('#user_email_address').attr('data-parsley-type', 'email');
    $('#user_password').attr('required', 'required');
    $('#confirm_user_password').attr('required', 'required');
    $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');
    $('#user_name').attr('required', 'required');
    $('#user_name').attr('data-parsley-pattern', '^[a-z A-Z]+$');
    $('#user_address').attr('required', 'required');
    $('#user_mobile_no').attr('required', 'required');
     $('#department_id').attr('required', 'required');
    $('#level_id').attr('required', 'required');
    $('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
    $('#matric_no').attr('required', 'required');
    $('#matric_no').attr('data-parsley-pattern', matric);
    $('#user_image').attr('required', 'required');
    $('#user_image').attr('accept', 'image/*');

    $('#user_register_form').parsley().validate();

      if($(this).parsley().isValid())
      {
        $.ajax({
          url:"user_ajax_action.php",
        method:"POST",
          data: new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
          beforeSend:function(){
            $('#user_register').attr('disabled', 'disabled');
            $('#user_register').val('please wait...');
          },
          success:function(data)
          {
            if(data.success)
            {
              $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#user_register_form')[0].reset();
            $('#user_register_form').parsley().reset();
            }

            $('#user_register').attr('disabled', false);
          $('#user_register').val('Register');
          }
        })      
      }
  });
});

</script>
</body>
</html>