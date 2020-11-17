<?php

include 'header.php';

$exam->query = "SELECT * FROM assignment_table 
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN user_course_enroll_table ON assignment_table.course_id = user_course_enroll_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
WHERE user_course_enroll_table.user_id = ".$_SESSION['user_id']." AND assignment_format = 'individual' ORDER BY assignment_deadline
";

$result = $exam->query_result();
date_default_timezone_set('Africa/Lagos');
$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

?>

<style>
	#box-padding 
	{
		padding: 5px;
	}
</style>

<!-- New Assignment Section -->
<div class="jumbotron text-center" style="margin-bottom:0; padding: 1rem 1rem; background:#C1C1C1; color:#222D32"><h4>New Assignment</h4></div><br>

<div class="row" id="box-padding">
<?php foreach($result as $row)
{
	if($current_datetime < $row['assignment_deadline'])
	{
		if($exam->Verify_submission_index($row['assignment_id']) != $row['assignment_id'])
		{
?>
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-aqua">
				    <div class="inner">
				    	<p>ASSIGNMENT DETAILS</p>
				    	<hr style="background-color:white;" />
						<p class="card-text"><b>Course Code:</b> <?= $row['course_code']; ?></p>
						<p class="card-text"><b>Expected Score:</b> <?= $row['assignment_score']; ?></p>
						<p class="card-text"><b>Deadline:</b> <?= $row['assignment_deadline']; ?></p>
						<p class="card-text"><b>Lecturer:</b> <?= $row['tutor_full_name']; ?></p>
				    </div>
				    <div class="icon">
				      <i class="fa fa-book"></i>
				    </div>
				    <a href="view_assignment.php?code=<?= $row['assignment_code'] ?>" class="small-box-footer" style="background-color:#222D32;">View Assignment <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
<?php }}} ?>
</div>

<!-- Submitted Assignment Section -->
<div class="jumbotron text-center" style="padding:1rem 1rem; background:#C1C1C1; color:#222D32"><h4>Submitted Assignment</h4></div>
<div class="row" id="box-padding">
<?php 
	foreach($result as $row)
	{
		if($current_datetime < $row['assignment_deadline'])
		{
			if($exam->Verify_submission_index($row['assignment_id']) == $row['assignment_id'])
			{
?>
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
					<div class="small-box bg-yellow">
					    <div class="inner">
					    	<p>ASSIGNMENT DETAILS</p>
					    	<hr style="background-color:white;" />
							<p class="card-text"><b>Course Code:</b> <?= $row['course_code']; ?></p>
							<p class="card-text"><b>Expected Score:</b> <?= $row['assignment_score']; ?></p>
							<p class="card-text"><b>Deadline:</b> <?= $row['assignment_deadline']; ?></p>
							<p class="card-text"><b>Lecturer:</b> <?= $row['tutor_full_name']; ?></p>
					    </div>
					    <div class="icon">
					      <i class="fa fa-book"></i>
					    </div>
					    <a href="update_assignment.php?code=<?= $row['assignment_code'] ?>" class="small-box-footer" style="background-color:#222D32;">View Assignment <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
<?php }}} ?>
</div>

<!-- Group Assignment Section -->
<div class="jumbotron text-center" style="padding:1rem 1rem; background:#C1C1C1; color:#222D32"><h4>Group Assignment</h4></div>
<?php 

$exam->query = "SELECT * FROM assignment_table 
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
INNER JOIN group_member_table ON assignment_table.group_id = group_member_table.group_id
INNER JOIN group_table ON group_member_table.group_id = group_table.group_id
WHERE group_member_table.user_id = ".$_SESSION['user_id']." AND assignment_format = 'group' 
GROUP BY assignment_table.assignment_id
";

$group_result = $exam->query_result();

?>

<div class="row" id="box-padding">

<?php
foreach($group_result as $group_row)
{
	if($current_datetime < $group_row['assignment_deadline'])
		{
			if($exam->Verify_submission_index($group_row['assignment_id']) != $group_row['assignment_id'])
			{
?>
				<div class="col-lg-3 col-xs-6">
					  <!-- small box -->
						<div class="small-box bg-gray">
						    <div class="inner">
						    	<p>ASSIGNMENT DETAILS</p>
						    	<hr style="background-color:white;" />
						    	<p class="card-text"><b>Group:</b> <?= $group_row['group_name']; ?></p>
								<p class="card-text"><b>Course Code:</b> <?= $group_row['course_code']; ?></p>
								<p class="card-text"><b>Assignment Round:</b> <?= str_replace('_', ' ', $group_row['assignment_num']); ?></p>
								<p class="card-text"><b>Expected Score:</b> <?= $group_row['assignment_score']; ?></p>
								<p class="card-text"><b>Deadline:</b> <?= $group_row['assignment_deadline']; ?></p>
								<p class="card-text"><b>Lecturer:</b> <?= $group_row['tutor_full_name']; ?></p>
						    </div>
						    <div class="icon">
						      <i class="fa fa-book"></i>
						    </div>
						    <a href="view_group_member.php?assignment_id=<?= $group_row['assignment_id'] ?>&id=<?= $group_row['group_id'] ?>&course_id=<?= $group_row['course_id'] ?>" class="small-box-footer" style="background-color:#222D32;">View Assignment <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
<?php }}} ?>
</div>

<!-- Group Submitted Assignment Section -->
<div class="jumbotron text-center" style="padding:1rem 1rem; background:#C1C1C1; color:#222D32"><h4>Group Submitted Assignment</h4></div>

<div class="row" id="box-padding">

<?php
foreach($group_result as $group_row)
{
	if($current_datetime < $group_row['assignment_deadline'])
		{
			if($exam->Verify_submission_index($group_row['assignment_id']) == $group_row['assignment_id'])
			{
?>
				<div class="col-lg-3 col-xs-6">
					  <!-- small box -->
						<div class="small-box bg-gray">
						    <div class="inner">
						    	<p>ASSIGNMENT DETAILS</p>
						    	<hr style="background-color:white;" />
						    	<p class="card-text"><b>Group:</b> <?= $group_row['group_name']; ?></p>
								<p class="card-text"><b>Course Code:</b> <?= $group_row['course_code']; ?></p>
								<p class="card-text"><b>Assignment Round:</b> <?= str_replace('_', ' ', $group_row['assignment_num']); ?></p>
								<p class="card-text"><b>Expected Score:</b> <?= $group_row['assignment_score']; ?></p>
								<p class="card-text"><b>Deadline:</b> <?= $group_row['assignment_deadline']; ?></p>
								<p class="card-text"><b>Lecturer:</b> <?= $group_row['tutor_full_name']; ?></p>
						    </div>
						    <div class="icon">
						      <i class="fa fa-book"></i>
						    </div>
						    <a href="update_assignment.php?assignment_id=<?= $group_row['assignment_id'] ?>&id=<?= $group_row['group_id'] ?>&course_id=<?= $group_row['course_id'] ?>" class="small-box-footer" style="background-color:#222D32;">View Assignment <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
<?php }}} ?>
</div>

<!-- Assignment Graded Section -->
<div class="jumbotron text-center" style="padding:1rem 1rem; background:#C1C1C1; color:#222D32"><h4>Assignment Graded</h4></div>
<div class="row" id="box-padding">
<?php 

$exam->query = "SELECT * FROM assignment_submission_table 
INNER JOIN assignment_table ON assignment_submission_table.assignment_id = assignment_table.assignment_id
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
WHERE assignment_submission_table.user_id = ".$_SESSION['user_id']."  AND status = 'Graded' ORDER BY course_table.course_code ASC
";

$sub_result = $exam->query_result();

foreach($sub_result as $sub_row) 
{

?>
	<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-green">
				    <div class="inner">
				    	<p>ASSIGNMENT DETAILS</p>
				    	<hr style="background-color:white;" />
						<p class="card-text"><b>Course Code:</b> <?= $sub_row['course_code']; ?></p>
						<p class="card-text"><b>Submission Date:</b> <?= $sub_row['assignment_submission_date']; ?></p>
						<p class="card-text"><b>Lecturer:</b> <?= $sub_row['tutor_full_name']; ?></p>
				    </div>
				    <div class="icon">
				      <i class="fa fa-book"></i>
				    </div>
				    <a href="view_assignment_score.php?id=<?= $sub_row['assignment_submission_id'] ?>" class="small-box-footer" style="background-color:#222D32;">View Score <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
<?php } ?>
</div>