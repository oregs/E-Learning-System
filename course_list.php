<?php

include 'header.php';

$semester_id = $exam->Get_current_semester();
// die(var_dump($semester_id));

$exam->query = "
SELECT * FROM course_table 
INNER JOIN user_course_enroll_table ON course_table.course_id = user_course_enroll_table.course_id
WHERE department_id = ".$_GET["id"]." AND user_course_enroll_table.user_id = ".$_SESSION["user_id"]."";

// AND semester_id = ".$semester_id." ------ Limiting it to semester or session in query above --------
$result = $exam->query_result();

// 

?>
<br />
<nav aria-label="breadcrumb">
	<ol class="breadcrumb" style="background-color:white;">
		<li class="breadcrumb-item"><a href="department_list.php">Department List</a></li>
		<li class="breadcrumb-item active" aria-current="page">Course List</li>
	</ol>
</nav>
<br />
<div class="card">
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title">Course List</h3>
        </div>
      </div>
    </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive" style="overflow-x:hidden;">
      <table id="classroom_table" class="table table-bordered table-striped table-hover">
        <thead class="alert-info">
          <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Number of Class</th>
            <th>View Classes</th>
          </tr>
        </thead>
        <tbody>
        	
        		<?php 
	        		foreach($result as $row)
	        		{
                $exam->query = "
                SELECT * FROM classroom_table WHERE course_id = ".$row["course_id"]."";
                $course_class = $exam->total_row(); 
	        			echo '
	        			<tr>
	        				<td>'.$row["course_code"].'</td>
	        				<td>'.$row['course_name'].'</td>
                  <td>'.$course_class.'</td>
                  <td><a href="course_class.php?id='.$row["course_id"].'" class="btn btn-info"><span class="fa fa-search"> View Classes</span></a></td>
	        			</tr>
	        			';
	        		}
        		?>
        </tbody>
      </table>
    </div>
  </div>
</div>  
<?php include 'master/footer.php'; ?> 