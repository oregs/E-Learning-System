<?php

include('Examination.php');

$exam = new Examination;

$exam->admin_session_private();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Online Examination System in PHP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../style/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="../style/css/style.css">
	<link rel="stylesheet" href="../style/css/jquery.lwMultiSelect.css">
	<script src="../style/js/jquery-3.4.0.min.js"></script>
	<script src="../style/js/popper.min.js"></script>
	<script src="../style/js/bootstrap.min.js"></script>
	<script src="../style/js/moment.js"></script>
	<script src="../style/js/jquery.dataTables.min.js"></script>
	<script src="../style/js/dataTables.bootstrap4.min.js"></script>
	<script src="../style/js/bootstrap-datetimepicker.js"></script>
	<script src="../style/js/parsley.js"></script>
	<script src="../style/js/jquery.lwMultiSelect.js"></script>
</head>
<body>
	<div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;">
		<h1>ONLINE EXAMINATION SYSTEM</h1>
	</div>

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<a class="navbar-brand" href="index.php">Admin Side</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="course.php">Course</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="exam.php">Exam</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="tutor.php">Tutor</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="user.php">User</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="setting.php">Setting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid alet alert-dark">
	