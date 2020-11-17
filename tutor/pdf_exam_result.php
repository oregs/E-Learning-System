<?php

include('../master/Examination.php');

require_once('../class/pdf.php');

$exam = new Examination;

if(isset($_GET["code"]))
{
	$exam_id = $exam->Get_examination_id($_GET['code']);

	$exam->query = "
	SELECT course_table.course_code, course_table.course_name, user_table.user_id, user_exam_question_answer.exam_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark FROM user_exam_question_answer
	INNER JOIN user_table ON user_table.user_id = user_exam_question_answer.user_id
	INNER JOIN online_exam_table ON user_exam_question_answer.exam_id = online_exam_table.online_exam_id
	INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
	WHERE exam_id = ".$exam_id."
	GROUP BY user_exam_question_answer.user_id
	ORDER BY total_mark DESC
	";

	$result = $exam->query_result();

	$count = 1;

	foreach($result as $row)
	{
		$output = '
		<h2 align="center">Exam Result</h2><br />
		<p align="center"><b>'.$row["course_code"]. ' - ' . $row["course_name"].'</b></p><br />
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<th>Rank</th>
				<th>Image</th>
				<th>User Name</th>
				<th>Attendance Status</th>
				<th>Marks</th>
			</tr>
			<tr>
				<td>'.$count.'</td>
				<td><img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" /></td>
				<td>'.$row["user_name"].'</td>
				<td>'.$exam->Get_user_exam_status($exam_id, $row["user_id"]).'</td>
				<td><b>'.$row["total_mark"].'</b></td>
			</tr>
			';

		$count += 1;
	}

	$output .= '</table>';

	$pdf = new Pdf();
	$file_name = 'Exam Result.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}

?>