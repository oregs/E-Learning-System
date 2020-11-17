<!-- <div class="wrapper">
		<div class="upload-console">
			<h3 class="class-console-header">Upload</h3>
			<hr>

			<div class="upload-console-body">
				<h5>Select files from computer</h5>
				<form action="upload.php" method="post" enctype="multipart/form-data">
					<input type="file" name="files[]" id="standard-upload-files" multiple>
					<input type="submit" value="Upload files" id="standard-upload" class="btn btn-primary">
				</form><br />

				<h5>Or drag and drop files below</h5>
				<div class="upload-console-drop" id="drop-zone">
					Just drag and drop files here
				</div>

				<div class="bar">
					<div class="bar-fill" id="bar-fill">
						<div class="bar-fill-text" id="bar-fill-text"></div>
					</div>
				</div> -->

				<!-- class="hidden" -->
				<!-- <div id="uploads-finished">
					<h5>Processed Files</h5> -->
					<!-- <div class="upload-console-upload">
						<a href="#">filename.jpg</a>
						<span>Success</span>	
					</div> -->
				<!-- </div>

			</div>
		</div>
	</div> -->

<?php



<div class = "col-lg-10 well" style = "margin-top:60px;">
<div class="content">
	<div class = "alert alert-info">New Assignment</div>

		<!-- Individual Assignment Card Link -->                      
	<div class="row">                        
		<div class="content">
			<div class ="alert alert-gray">New Assignment</div>

			<!-- Individual Assignment Card Link -->
			<div class="row">                         
	           	<a href="" class="text-white">
					<div class="col-md-3" style="margin-bottom:20px;">
			          	<div class="card text-white bg-primary" style="max-width: 20rem;">
							<div class="card-header">Assignment Details</div>
							<div class="card-body">
								<p class="card-text"></p>
								<p class="card-text"></p>
								<p class="card-text"></p>
								<p class="card-text"><b>Lecturer:</b></p>
							</div>
							<div class="card-footer">
								<span style="color:white;">Submit Assignment</span>
								<span style="color:white;float:right;"><i class='fa fa-angle-right'></i></span>
							</div>
						</div>
					</div>
				</a>
			</div><br>
		</div>
	</div>
</div>






      // window.Parsley.addValidator('minTextSize', {
      //   validateString: function(_value, minTextSize, parsleyInstance) {
      //     if (!window.FormData) {
      //       alert('You are making all developpers in the world cringe. Upgrade your browser!');
      //       return true;
      //     }
      //     var txt = $(_value).text().trim();
      //     return txt.length > minTextSize;
      //   },
      //   requirementType: 'integer'
      // });

include('../master/Examination.php');

$exam = new Examination;

$exam->tutor_session_private();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Online Examination System in PHP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../style/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../style/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="../style/css/global.css">
	<link rel="stylesheet" href="../style/css/adminlte/AdminLTE.min.css">
	<link rel="stylesheet" href="../style/css/adminlte/skins/skin-yellow.min.css">
	<link rel="stylesheet" href="../style/css/style.css">
	<link rel="stylesheet" href="../style/css/sweetalert.css">
	<!-- <link rel="stylesheet" href="../style/css/sb-admin.css"> -->
	<script src="../style/js/jquery-3.4.0.min.js"></script>
	<script src="../style/js/popper.min.js"></script>
	<script src="../style/js/bootstrap.min.js"></script>
	<script src="../style/js/moment.js"></script>
	<script src="../style/js/jquery.dataTables.min.js"></script>
	<script src="../style/js/dataTables.bootstrap4.min.js"></script>
	<script src="../style/js/bootstrap-datetimepicker.js"></script>
	<script src="../style/js/parsley.js"></script>
	<script src="../style/js/sweetalert.min.js"></script>
	<!-- <script src="../style/js/sb-admin.js"></script> -->
	<script src="../style/js/adminlte/adminlte.min.js"></script>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SL</b>MS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Library Management</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
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
          <img src="dist/img/ic10.png" class="img-circle" alt="User Image">
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
        <li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="Users_view.php"><i class="fa fa-users"></i> <span>Members</span></a></li>
        <li><a href="books_view.php"><i class="fa fa-book"></i> <span>Books</span></a></li>
        <li><a href="Magazines_view.php"><i class="fa fa-file-word-o"></i> <span>Magazines</span></a></li>
        <li><a href="article_entry.php"><i class="fa fa-newspaper-o"></i> <span>Article Entry</span></a></li>
        <li><a href="Book_Issue_view.php"><i class="fa fa-space-shuttle"></i> <span>Issued</span></a></li>
        <li><a href="Return_Book_view.php"><i class="fa fa-thumbs-up"></i> <span>Returned</span></a></li>
         <li></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-cogs"></i> <span>ACTIONS</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper"><br>
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












 // function Get_last_id($tablename, $attribute, $id)
  // {
  //  $this->query = "
  //  SELECT $attribute FROM $tablename 
  //  ORDER BY $id DESC LIMIT 1
  //  ";

  //  $result = $this->query_result();

  //  foreach($result as $row)
  //  {
  //    return $row["$attribute"];
  //  }
  // }












	<!-- <div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem;">
		<h1>ONLINE EXAMINATION SYSTEM</h1>
	</div> -->

	<!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<a class="navbar-brand" href="index.php">Lecturer Side</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="assignment.php">Assignment Module</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="user.php">Classroom Module</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="user.php">Student Result</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="article_entry.php">Article Entry</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="user.php">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="user.php">Change Password</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav> -->

	<!-- <div class="container-fluid"> -->
	


	 <div class="row" style=" background:white;">
    <div class="col-md-8">
      <h2 class="page-header">Comments</h2>
        <section class="comment-list">
          <!-- First Comment -->
          <article class="row">
            <div class="col-md-2 col-sm-2 hiddetn-xs">
              <figure class="thumbnail">
                <img class="img-responsive" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                <figcaption class="text-center">username</figcaption>
              </figure>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="panel panel-default arrow left">
                <div class="panel-body">
                  <header class="text-left">
                    <div class="comment-user"><i class="fa fa-user"></i> That Guy</div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="comment-post">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                  </div>
                  <p class="text-right"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
                </div>
              </div>
            </div>
          </article>
      </section>
    </div>
  </div><br />
  <div class="row" style=" background:white;">
    <div class="col-md-8">
      <h2 class="page-header">Comments</h2>
        <section class="comment-list">
          <!-- First Comment -->
          <article class="row">
            <div class="col-md-2 col-sm-2 hiddetn-xs">
              <figure class="thumbnail">
                <img class="img-responsive" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                <figcaption class="text-center">username</figcaption>
              </figure>
            </div>
            <div class="col-md-10 col-sm-10">
              <div class="panel panel-default arrow left">
                <div class="panel-body">
                  <header class="text-left">
                    <div class="comment-user"><i class="fa fa-user"></i> That Guy</div>
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="comment-post">
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                  </div>
                  <p class="text-right"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
                </div>
              </div>
            </div>
          </article>
      </section>
    </div>
  </div>
