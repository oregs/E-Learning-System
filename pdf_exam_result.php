<?php

include('master/Examination.php');

require_once('class/pdf.php');

$exam = new Examination;

if(isset($_GET["code"]))
{
	$exam_id = $exam->Get_examination_id($_GET["code"]);

	$exam->query = "
	SELECT * FROM question_table
	INNER JOIN user_exam_question_answer
	ON user_exam_question_answer.question_id = question_table.question_id
	WHERE question_table.online_exam_id = '$exam_id'
	AND user_exam_question_answer.user_id = '".$_SESSION["user_id"]."'
	";

	$result = $exam->query_result();

	$output = '
	<h3 align="center">Exam Result</h3>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<th>Question</th>
			<th>Your Answer</th>
			<th>Answer</th>
			<th>Result</th>
			<th>Marks</th>
		</tr>
	';

	$total_mark = 0;

	foreach($result as $row)
	{
		$exam->query = "
		SELECT * FROM option_table WHERE question_id = '".$row["question_id"]."'
		";

		$sub_result = $exam->query_result();

		$user_answer = '';
		$original_answer = '';
		$question_result = '';

		if($row['marks'] == '0')
		{
			$question_result = 'Not Attend';
		}

		if($row['marks'] > '0')
		{
			$question_result = 'Right';
		}

		if($row['marks'] < '0')
		{
			$question_result = 'Wrong';
		}

		$output .= '
		<tr>
			<td>'.$row["question_title"].'</td>
			<td>'.$row["user_answer_option"].'</td>
			<td>'.$row["answer_option"].'</td>
			<td>'.$question_result.'</td>
			<td>'.$row["marks"].'</td>
		</tr>
		';
	}

	$exam->query = "
	SELECT SUM(marks) as total_mark FROM user_exam_question_answer
	WHERE user_id = '".$_SESSION['user_id']."'
	AND exam_id = '".$exam_id."'
	";

	$marks_result = $exam->query_result();

	foreach($marks_result as $row)
	{
		$output .= '
		<tr>
			<td colspan="4" align="right"><b>Total Marks</b></td>
			<td align="left"><b>'.$row["total_mark"].'</b></td>
		</tr>
		';
	}
	$output .= '</table>';

	$pdf = new Pdf();

	$pdf->set_paper('letter', 'landscape');
	$file_name = 'Exam Result.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}

?>