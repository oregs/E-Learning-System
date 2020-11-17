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
  <link rel="stylesheet" href="style/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style/css/bootstrap-datetimepicker.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS Files -->
  <link href="style/css/argon-design-system.css?v=1.2.0" rel="stylesheet" />
</head>

<style>
.nav-link{
  padding-left: 0px !important;
}
.avatar {
  width: 30px;
}
</style>

<body class="index-page">
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
              <a href="./index.html">
                <img src="./assets/img/brand/blue.png">
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
            
        <?php
          include('master/Examination.php');
          $exam = new Examination;
          if(isset($_SESSION['user_id']))
          {
            echo '
            <ul class="navbar-nav navbar-nav-hover ml-lg-auto">
              <li class="nav-item dropdown">
                <a href="student_module.php" class="nav-link" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Components</span>
                </a>
                <div class="dropdown-menu">
                  <a href="course.php" class="dropdown-item">Course Module</a>
                  <a href="exam_registration.php" class="dropdown-item">Exam Enrollment Module</a>
                  <a href="department_list.php" class="dropdown-item">Classroom Module</a>
                  <a href="enroll_exam.php" class="dropdown-item">Examination Module</a>
                  <a href="assignment_result.php" class="dropdown-item">Assignment Result</a>
                  <a href="article_entry.php" class="dropdown-item">Article Entry</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link navbar-brand" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text"><img src="upload/'.$exam->Get_specific_data('user_table', 'user_id', $_SESSION['user_id'], 'user_image').'" class="avatar" alt="User Image"><strong> '.strtoupper($exam->Get_specific_data('user_table', 'user_id', $_SESSION['user_id'], 'user_name')).'</strong></span>
                </a>
                <div class="dropdown-menu">
                  <a href="profile.php" class="dropdown-item">Profile</a>
                  <a href="change_password.php" class="dropdown-item">Change Password</a>
                  <a href="logout.php" class="dropdown-item" style="color:red;"><i class="fa fa-sign-out"> Sign Out</i></a>
                </div>
              </li>
            </ul>
            ';
          }
          else if(isset($_SESSION['tutor_id']))
          {
            echo '
            <ul class="navbar-nav navbar-nav-hover ml-lg-auto">
              <li class="nav-item dropdown">
                <a href="tutor/tutor_module.php" class="nav-link" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Dashboard</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Assignment Module</span>
                </a>
                <div class="dropdown-menu">
                  <a href="tutor/assignment_details.php" class="dropdown-item">Assignment Plan</a>
                  <a href="tutor/assignment_result.php" class="dropdown-item">Assignment Result</a>
                  <a href="tutor/grading.php" class="dropdown-item">Assignment Grading Module</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Classroom Module</span>
                </a>
                <div class="dropdown-menu">
                  <a href="tutor/classroom_details.php" class="dropdown-item">Classroom Plan</a>
                  <a href="tutor/department_list.php" class="dropdown-item">Department List</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="tutor/group.php" class="nav-link" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Modules</span>
                </a>
                <div class="dropdown-menu">
                  <a href="tutor/exam_result_details.php" class="dropdown-item">Exam Result</a>
                  <a href="tutor/group.php" class="dropdown-item">Group Module</a>
                  <a href="tutor/article_entry.php" class="dropdown-item">Article Entry</a>
                  <a href="tutor/attendance.php" class="dropdown-item">Attendance Module</a>
                </div>
              </li>
              
            </ul>
            <form class="form-inline my-2 my-lg-0">
            <ul class="navbar-nav navbar-nav-hover ml-lg-auto">
              <li class="nav-item dropdown">
                <a href="#" class="navbar-brand nav-link mr-sm-2" data-toggle="dropdown" role="button">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text"><img src="tutor/upload/'.$exam->Get_specific_data('tutor_table', 'tutor_id', $_SESSION['tutor_id'], 'tutor_image').'" class="avatar" alt="User Image"><strong> '.strtoupper($exam->Get_specific_data('tutor_table', 'tutor_id', $_SESSION['tutor_id'], 'tutor_full_name')).'</strong></span>
                </a>
                <div class="dropdown-menu">
                  <a href="tutor/profile.php" class="dropdown-item">Profile</a>
                  <a href="tutor/change_password.php" class="dropdown-item">Change Password</a>
                  <a href="tutor/logout.php" class="dropdown-item" style="color:red;"><i class="fa fa-sign-out"> Sign Out</i></a>
                </div>
              </li>
              </ul>
            </form>
            ';
          }
          else
          {
            echo '
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
                <a href="Login.php" target="_blank" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon">
                    <i class="fa fa-sign-in"></i>
                  </span>
                  <span class="nav-link-inner--text">Student Login</span>
                </a>
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
            ';
          }
        ?>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper">
    <div class="section section-hero section-shaped">
      <div class="shape shape-style-1 shape-primary">
        <span class="span-150"></span>
        <span class="span-50"></span>
        <span class="span-50"></span>
        <span class="span-75"></span>
        <span class="span-100"></span>
        <span class="span-75"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
        <span class="span-50"></span>
        <span class="span-100"></span>
      </div>
      <div class="page-header">
        <div class="container shape-container d-flex align-items-center py-lg">
          <div class="col px-0">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-10 text-center">
                <h1 style="color:white;"><strong>Advance E-Learning System</strong></h1>
                <p class="lead text-white">The objective of this system is to facilitate interaction between lecturers and students for assessment purposes.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <div class="section features-1">
      <div class="container">
        <div class="row">
          <div class="col-md-10 mx-auto text-center">
            <span class="badge badge-primary badge-pill mb-3">Insight</span>
            <h3 class="display-3">Advance E-Learning Modules</h3>
            <p class="lead">The Advance E-Learning System entails the following modules and many more that not listed below.</p>
          </div>
        </div><br /><br />
        <div class="row">
          <div class="col-md-3">
            <div class="info">
              <div class="icon icon-lg icon-shape icon-shape-primary shadow rounded-circle">
                <i class="ni ni-settings-gear-65"></i>
              </div>
              <h6 class="info-title text-uppercase text-primary">Examination Module</h6>
              <p class="description opacity-8">This is a module responsible for handling examination procedure and conduct.</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info">
              <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle">
                <i class="ni ni-atom"></i>
              </div>
              <h6 class="info-title text-uppercase text-success">Assignment Module</h6>
              <p class="description opacity-8">This is a module responsible for handling Assignment procedure and conduct.</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info">
              <div class="icon icon-lg icon-shape icon-shape-warning shadow rounded-circle">
                <i class="ni ni-world"></i>
              </div>
              <h6 class="info-title text-uppercase text-warning">Classroom Module</h6>
              <p class="description opacity-8">This is a module responsible for handling classroom activities and Planning.</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="info">
              <div class="icon icon-lg icon-shape icon-shape-default shadow rounded-circle">
                <i class="ni ni-world"></i>
              </div>
              <h6 class="info-title text-uppercase text-default">Attendance Module</h6>
              <p class="description opacity-8">This is a module responsible for handling Attendance of the students with a reports.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br /><br />
    <footer class="footer">
      <div class="container">
        <div class="row row-grid align-items-center mb-5">
          <div class="col-lg-6">
            <h3 class="text-primary font-weight-light mb-2">Thank you for using our system!</h3>
            <h4 class="mb-0 font-weight-light">Let's get in touch on any of these platforms.</h4>
          </div>
          <div class="col-lg-6 text-lg-center btn-wrapper">
            <button target="_blank" href="https://twitter.com/creativetim" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-twitter"></i></span>
            </button>
            <button target="_blank" href="https://www.facebook.com/CreativeTim/" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
              <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
            </button>
            <button target="_blank" href="https://dribbble.com/creativetim" rel="nofollow" class="btn btn-icon-only btn-dribbble rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-dribbble"></i></span>
            </button>
            <button target="_blank" href="https://github.com/creativetimofficial" rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
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
  </div>
    