<?php

include('master/Examination.php');

$exam = new Examination;

$exam->user_session_private();

?>

<!DOCTYPE html>
<html>
<head>
	<title>E-Learning System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Cascading Sheet  -->
	<link rel="stylesheet" href="style/css/bootstrap.min.css">
	<link rel="stylesheet" href="style/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="style/css/global.css">
	<link rel="stylesheet" href="style/css/adminlte/AdminLTE.min.css">
	<link rel="stylesheet" href="style/css/adminlte/skins/skin-blue.min.css">
	<link rel="stylesheet" href="style/css/style.css">
	<link rel="stylesheet" href="style/css/timeCircles.min.css">
	<link rel="stylesheet" href="style/css/sweetalert.css">
  <link rel="stylesheet" href="style/css/commenting.css">
  <link rel="stylesheet" href= "style/css/datatable_tableexport.css" />
	<!-- JavaScript Library  -->
	<script src="style/js/jquery-3.4.0.min.js"></script>
	<script src="style/js/popper.min.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
	<script src="style/js/moment.js"></script>
	<script src="style/js/jquery.dataTables.min.js"></script>
	<script src="style/js/dataTables.bootstrap4.min.js"></script>
	<script src="style/js/bootstrap-datetimepicker.js"></script>
	<script src="style/js/timeCircles.min.js"></script>
	<script src="style/js/parsley.js"></script>
	<script src="style/js/sweetalert.min.js"></script>
	<script src="style/js/adminlte/adminlte.min.js"></script>
  <script src="style/js/notification.js"></script>
  <script type="text/javascript" async src="style/ckeditor/plugins/MathJax/MathJax.js?config=TeX-AMS_HTML"></script>
</head>
<style>
  .count {
    border-radius: 50%; 
    position:absolute;
    top:0;
    right:-5px;
    left:0;
    height:25px;
    width:25px;
    text-align:center;
    color:#fff;
  }
</style>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>E-</b>LS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>E-Learning System</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="logout.php"><i class="fa fa-sign-out"></i> Sign out</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
<br>
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
           <img src="<?= isset($tutor_image) ? 'upload/'.$tutor_image : 'style/img/user.png' ?>" class="avatar" alt="User Image">
        </div>
        <div class="pull-left info">
            <strong><a href="" class="text-success"></a></strong>
              <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="student_module.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="course.php"><i class="fa fa-users"></i> <span>Course Module</span></a></li>
        <li><a href="exam_registration.php"><i class="fa fa-users"></i> <span>Exam Enrollment Module </span></a></li>
        <li><a href="department_list.php"><span class="label label-pill count"></span><i class="fa fa-book"></i> <span>  Classroom Module</span></a></li>
        <li><a href="enroll_exam.php"><i class="fa fa-file-word-o"></i> <span>Examination Module</span></a></li>
        <li><a href="assignment_result.php"><i class="fa fa-newspaper-o"></i> <span>Assignment Result.php</span></a></li>
        <li><a href="article_entry.php"><i class="fa fa-newspaper-o"></i> <span>Article Entry</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-cogs"></i> <span>ACTIONS</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="profile.php"><i class="fa fa-user"></i><span >Profile</span></a></li>
            <li><a href="change_password.php"><i class="fa fa-arrow-right"></i><span>Change Password</span></a></li>
          </ul>
        </li>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
<!-- <section class="content-header"> -->
      <!-- <h1>
        Library Management
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">dashboard</li>
      </ol>
    </section>
</div> -->
