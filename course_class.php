<?php

include 'header.php';

$exam->query = "
SELECT * FROM course_table WHERE course_id = ".$_GET["id"]."";
$result = $exam->query_result();

foreach($result as $row){
?>
<br />
<nav aria-label="breadcrumb">
	<ol class="breadcrumb" style="background-color:white;">
		<li class="breadcrumb-item"><a href="department_list.php">Department List</a></li>
    <li class="breadcrumb-item"><a href="course_list.php?id=<?= $row['department_id']; ?>">Course List</a></li>
  <?php } ?>
		<li class="breadcrumb-item active" aria-current="page">Course Class</li>
	</ol>
</nav>
<br />
<div class="card">
  <div class="card-header alert-info">
      <div class="row">
        <div class="col-md-9">
          <h3 class="panel-title">Class List</h3>
        </div>
      </div>
    </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive" style="overflow-x:hidden;">
      <table id="classroom_table" class="table table-bordered table-striped table-hover">
        <thead class="alert-info">
          <tr>
            <th>Class Title</th>
            <th>Student View</th>
            <th>Date & Time Created</th>
            <th>View Class</th>
          </tr>
        </thead>
        <tbody>
        	
        		<?php 

              $exam->query = "
              SELECT * FROM classroom_table WHERE course_id = ".$_GET["id"]."";
              $sub_result = $exam->query_result();

	        		foreach($sub_result as $sub_row)
	        		{
	        			echo '
	        			<tr>
                  <td><b>'.$sub_row["classroom_title"].'</b></td>
                  <td></td>
                  <td><i>'.$sub_row['classroom_created_on'].'<i></td>
                  <td><a href="classroom.php?code='.$sub_row["classroom_code"].'&id='.$_GET["id"].'" class="btn btn-info"><i class="fa fa-book"> Join Class</i></a></td>
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