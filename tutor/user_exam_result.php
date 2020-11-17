<?php

include 'header.php';

$exam_id = $exam->Get_examination_id($_GET["code"]);

$exam->query = "
SELECT * FROM question_table
INNER JOIN user_exam_question_answer ON user_exam_question_answer.question_id = question_table.question_id
-- INNER JOIN online_exam_table ON question_table.online_exam_id = online_exam_table.online_exam_id
-- INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
WHERE question_table.online_exam_id = '$exam_id'
AND user_exam_question_answer.user_id = '".$_GET["id"]."'
";

$result = $exam->query_result();

?>
<br />
<div class="card">
	<div class="card-header">Online Exam Result</div>
	<div class="card-body">
		<div class="table-responsive" style="overflow-x:hidden;">
			<table id="enroll_table" class="table table-bordered table-striped table-hover">
					<tr align="center">
						<th>Question</th>
						<th>Your Answer</th>
						<th>Answer</th>
						<th>Result</th>
						<th>Marks</th>
					</tr>
					<?php
					$total_mark = 0;

					foreach($result as $row)
					{
						$user_answer = '';
						$question_answer = '';
						$question_result = '';

						if($row["marks"] == '0')
						{
							$question_result = '<h4 class="badge badge-dark">Right</h4>';
						}
						if($row['marks'] > '0')
						{
							$question_result = '<h4 class="badge badge-success">Right</h4>';
						}

						if($row['marks'] < '0')
						{
							$question_result = '<h4 class="badge badge-danger">Wrong</h4>';
						}

						echo '
						<tr>
							<td>'.$row["question_title"].'</td>
							<td align="center">'.$row["user_answer_option"].'</td>
							<td align="center">'.$row["answer_option"].'</td>
							<td align="center">'.$question_result.'</td>
							<td align="center">'.$row["marks"].'</td>
						</tr>
						';
					}

					$exam->query = "
					SELECT SUM(marks) as total_mark FROM user_exam_question_answer
					WHERE user_id = '".$_GET['id']."'
					AND exam_id = '".$exam_id."'
					";

					$marks_result = $exam->query_result();

					foreach($marks_result as $row)
					{

						echo '
						<tr>
							<td colspan="4" align="right"><b>Total Marks</b></td>
							<td align="center"><b>'.$row["total_mark"].'</b></td>
						</tr>
						';
					}
					?>
			</table>
		</div>
	</div>
</div>
<?php include '../master/footer.php'; ?>