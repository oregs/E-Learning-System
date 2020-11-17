<?php

//register.php
include('../master/Examination.php');

$exam = new Examination;

$exam->tutor_session_public();


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
  <link href="../style/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../style/css/nucleo-svg.css" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="../style/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/css/style.css">
  <link rel="stylesheet" href="../style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../style/css/argon-design-system.css?v=1.2.0" rel="stylesheet" />

  <!-- JavaScript Files -->
  <script src="../style/js/jquery-3.4.0.min.js"></script>
  <script src="../style/js/parsley.js"></script>
  <script src="../style/js/popper.min.js"></script>
  <script src="../style/js/bootstrap.min.js"></script>
</head>

<body class="login-page">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
    <div class="container">
      <a class="navbar-brand mr-lg-5" href="../index.php">
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
              <a class="navbar-brand mr-lg-5" href="../index.php">
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
            <a href="../Login.php" class="btn btn-neutral btn-icon">
              <span class="btn-inner--icon">
                <i class="fa fa-sign-in"></i>
              </span>
              <span class="nav-link-inner--text">Student Login</span>
            </a>
            <a href="../master/Login.php" target="_blank" class="btn btn-neutral btn-icon">
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
    <div class="shape shape-style-1 bg-gradient-dark">
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
                <h4 style="margin-top:-15px;"><b>Tutor Registration</b></h4>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form method="post" id="tutor_register_form">
                <div class="form-group">
                  <label>Staff ID</label>
                  <input type="text" name="staff_id" id="staff_id" class="form-control" data-parsley-checkstaffid data-parsley-checkstaffid-message='Staff ID already Exists' />
                </div>
                <div class="form-group">
                  <label>Enter Email Address</label>
                  <input type="text" name="tutor_email_address" id="tutor_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
                </div>
                <div class="form-group">
                  <label>Enter Password</label>
                  <input type="password" name="tutor_password" id="tutor_password" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Enter Confirm Password</label>
                  <input type="password" name="confirm_tutor_password" id="confirm_tutor_password" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Enter Full Name</label>
                  <input type="text" name="tutor_name" id="tutor_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Select Gender</label>
                  <select name="tutor_gender" id="tutor_gender" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Enter Mobile Number</label>
                  <input type="text" name="tutor_mobile_no" id="tutor_mobile_no" class="form-control">
                </div>
                <div class="form-group">
                  <label>Select Profile Image</label>
                  <input type="file" name="tutor_image" id="tutor_image" />
                </div>
                <div class="form-group" align="center">
                  <input type="hidden" name="page" value="register" />
                  <input type="hidden" name="action" value="register" />
                  <input type="submit" name="tutor_register" id="tutor_register" class="btn btn-primary my-4" value="Register" />
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
            <button target="_blank" href="#" rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
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
    validateString: function(value)
    {
      return $.ajax({
        url:"tutor_ajax_action.php",
        method:"POST",
        data:{page:'register', action:'check_email', email:value},
        dataType:'json',
        async:false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });

  window.Parsley.addValidator('checkstaffid', {
    validateString: function(value)
    {
      return $.ajax({
        url:"tutor_ajax_action.php",
        method:"POST",
        data:{page:'register', action:'check_staffid', staff_id:value},
        dataType:'json',
        async:false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });

  $('#tutor_register_form').parsley();

  $('#tutor_register_form').on('submit', function(event){
    event.preventDefault();

    // var matric = new RegExp(/^\d{2}\/\d{4}$/);
    $('#staff_id').attr('required', 'required');
    // $('#staff_id').attr('data-parsley-pattern', matric)
    $('#tutor_email_address').attr('required', 'required');
    $('#tutor_email_address').attr('data-parsley-type', 'email');
    $('#tutor_password').attr('required', 'required');
    $('#confirm_tutor_password').attr('required', 'required');
    $('#confirm_tutor_password').attr('data-parsley-equalto', '#tutor_password');
    $('#tutor_name').attr('required', 'required');
    $('#tutor_mobile_no').attr('required', 'required');
    $('#tutor_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
    $('#tutor_image').attr('required', 'required');
    $('#tutor_image').attr('accept', 'image/*');

    $('#tutor_register_form').parsley().validate();

    if($(this).parsley().isValid())
    {
      $.ajax({
        url:"tutor_ajax_action.php",
        method:"POST",
        data:new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function(){
          $('#tutor_register').attr('disabled', 'disabled');
          $('#tutor_register').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#tutor_register_form')[0].reset();
            $('#tutor_register_form').parsley().reset();
          }

          $('#tutor_register').attr('disabled', false);
          $('#tutor_register').val('Register');
        }
      })
    }

  });
});
</script>
</body>
</html>