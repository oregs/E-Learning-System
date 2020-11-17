<?php

include 'header.php';



$exam->query = "SELECT * FROM group_member_table 
INNER JOIN group_table ON group_member_table.group_id = group_table.group_id
INNER JOIN user_table ON group_member_table.user_id = user_table.user_id
WHERE group_table.group_id = ".$_GET['id']." 
AND group_member_table.session_id = ".$_SESSION['session_id']." AND group_member_table.course_id = ".$_GET['course_id']."
";

$result = $exam->query_result();

?>
<div class="container" style="padding-top: 60px;">
<div class="card">
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title">Group Member List</h3>
        </div>
      </div>
    </div>
  <div class="card-body">
  	<div class="form-group">
  		<h4 align="center">Group <?= $_GET['id'] ?></h4>
  	</div><br /><br />
   <?php
   		foreach($result as $row)
   		{
   			echo '
   			<div class="row" align="center">
				<div class="col-md-7 col-sm-offset-1">
		            <div class="form-group">
		                <label><h4>'.$row["user_name"].'</h4></label>
		            </div>
		        </div>
		        <div class="col-md-5">
		             <div class="form-group">
		                <label><h4>'.$row["matric_no"].'</h4></label>
		            </div>
		        </div>
	        </div>
   			';
   		}
	?>
			<div class="card-footer" align="center">
				<a href="view_assignment.php?assignment_id=<?= $_GET['assignment_id'] ?>&group_name=<?= $row['group_name'] ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-link"></span><h5>View Group Assignment</h5></a>
			</div>  
  </div>
</div>