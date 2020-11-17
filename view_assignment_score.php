<?php

include('header.php');

$exam->query = "
SELECT * FROM assignment_submission_table
INNER JOIN assignment_table ON assignment_submission_table.assignment_id = assignment_table.assignment_id
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
WHERE assignment_submission_table.assignment_submission_id = ".$_GET['id'].";
";
$result = $exam->query_result();

?>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h3 class="panel-title">Assignment Result Details</h3>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="col-md-12">
        <?php 
          foreach($result as $row)
          { 
            $exam->query = "
            SELECT * FROM assignment_result_table 
            WHERE user_id = '".$_SESSION['user_id']."' AND course_id = ".$row['course_id']."
            ";
            $sub_result = $exam->query_result();
          ?>
              <table class="table table-bordered">
                <tr>
                  <th>Course:</th>
                  <td><?= $row["course_code"] ?> -  <?= $row["course_name"] ?></td>
                </tr>
                <tr>
                  <th>Assignment Number:</th>
                  <td><?= str_replace('_', ' ', $row['assignment_num']); ?></td>
                </tr>
                <tr>
                  <th>Lecturer:</th>
                  <td><?= $row["tutor_full_name"] ?></td>
                </tr>
                <tr>
                  <th>Assignment Status:</th>
                  <td><b><?= $row["status"] ?></b></td>
                </tr>
              </table>
              <div class="tab-content" style="background-color: #3C8DBC; color:white;">

                <?php foreach ($sub_result as $sub_row) { ?>

                <h3 align="center"><strong class="color">SCORE:</strong></h3>
                <h1 align="center" style="font-size:100px;"><?= $sub_row[$row['assignment_num']] .'/'. $row['assignment_score'] ?></h1>
              </div>
        </div><br>
      <?php }} ?>
    </div>
  </div>
</div>