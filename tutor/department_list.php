<?php

include 'header.php';

$exam->query = "
SELECT * FROM department_table";
$result = $exam->query_result();

?>
<br />
<nav aria-label="breadcrumb">
	<ol class="breadcrumb" style="background-color:white;">
		<!-- <li class="breadcrumb-item"><a href="exam.php">Exam List</a></li> -->
		<li class="breadcrumb-item active" aria-current="page">Department List</li>
	</ol>
</nav>
<br />
<div class="card">
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title">Department List</h3>
        </div>
      </div>
    </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive" style="overflow-x:hidden;">
      <table id="classroom_table" class="table table-bordered table-striped table-hover">
        <thead class="alert-info">
          <tr>
            <th>Department</th>
            <th>Description</th>
            <th>Number of Course</th>
          </tr>
        </thead>
        <tbody>
        	
        		<?php 
	        		foreach($result as $row)
	        		{
	        			$exam->query = "
						SELECT * FROM course_table WHERE department_id = ".$row["department_id"]."";
						$department_list = $exam->total_row();
	        			echo '
	        			<tr>
	        				<td><a href="course_list.php?id='.$row["department_id"].'">'.$row['department_name'].'</a></td>
	        				<td>'.$row['department_description'].'</td>
	        				<td>'.$department_list.'</td>
	        			</tr>
	        			';
	        		}
        		?>
        </tbody>
      </table>
    </div>
  </div>
</div>  
<?php include '../master/footer.php'; ?> 