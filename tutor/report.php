<?php

//report.php

include('../master/Examination.php');

require_once('../class/pdf.php');

$exam = new Examination;

if(isset($_GET["action"]))
{
	if($_GET["action"] = "student_report")
	{
		if(isset($_GET["enroll_id"], $_GET["from_date"], $_GET["to_date"]))
		{
			$output = '';
			$exam->query = "
			SELECT * FROM user_course_enroll_table 
			INNER JOIN user_table ON user_table.user_id=user_course_enroll_table.user_id 
			INNER JOIN course_table ON course_table.course_id=user_course_enroll_table.course_id
			WHERE user_course_enroll_table.user_course_enroll_id='".$_GET["enroll_id"]."'
			";

			$result = $exam->query_result();

			foreach ($result as $row) 
			{
				$output .='
				<style>
			@page { margin:20px; }

			</style>
			<p>&nbsp;</p>
			<h3 align="center">Attendance Report</h3><br/>
			<table width=100% border="0" cellpadding="5" cellspacing="0">
			<tr>
				<td width="25%"><b>Matric Number</b><td>
				<td width="75%">'.$row["matric_no"].'</td> 
			</tr>
			<tr>
				<td width="25%"><b>Student Name</b><td>
				<td width="75%">'.$row["user_name"].'</td> 
			</tr>
			<tr>
				<td width="25%"><b>Course</b><td>
				<td width="75%">'.$row["course_code"].' - '.$row["course_name"].'</td> 
			</tr>
			<tr>
				<td colspan="2" height="5"><h3 align="center">Attendance Details</h3>
				<td>	
			</tr>
			<tr>
				<td colspan="8">
					<table width=100% border="1" cellpadding="5" cellspacing="0">
					<tr>
						<td><b>Attendance Date</b></td>
						<td><b>Attendance Status</b></td>
					</tr>
				';
				$exam->query = "
				SELECT * FROM classroom_visibility_table 
				WHERE user_course_enroll_id='".$_GET["enroll_id"]."' 
				AND (classroom_date_viewed BETWEEN '".$_GET["from_date"]."' 
				AND '".$_GET["to_date"]."') GROUP BY classroom_date_viewed 
				ORDER BY classroom_date_viewed ASC
				";

				$sub_result = $exam->query_result();

				foreach ($sub_result as $sub_row) 
				{
					if($sub_row['seen'] == 1)
					{
						$status = 'Present';
					}
					else
					{
						$status = 'Absent';
					}

					$output .='
						<tr>
							<td>'.$sub_row["classroom_date_viewed"].'</td>
							<td>'.$status.'</td>		
						</tr>
					';
				}
				$output .='
						</table>
					</td>
					</tr>
				</table>
				';
			}
			$pdf = new pdf();
			$file_name = 'Attendance Report.pdf';
			$pdf->loadHtml($output);
			$pdf->render();
			$pdf->stream($file_name, array("Attachment" => false));
			exit(0); 
		}
	}

	if($_GET["action"] = "overall_report")
	{
		if(isset($_GET["course_id"], $_GET["report_from_date"], $_GET["report_to_date"]))
		{
			$output = '';
			
			$exam->query = "
			SELECT * FROM classroom_visibility_table
			INNER JOIN user_course_enroll_table ON classroom_visibility_table.user_course_enroll_id = user_course_enroll_table.user_course_enroll_id
			INNER JOIN course_table ON course_table.course_id = user_course_enroll_table.course_id
			WHERE user_course_enroll_table.course_id = '".$_GET['course_id']."' 
			AND (classroom_visibility_table.classroom_date_viewed BETWEEN '".$_GET["report_from_date"]."' 
			AND '".$_GET["report_to_date"]."') 
			GROUP BY classroom_visibility_table.classroom_date_viewed 
			ORDER BY classroom_visibility_table.classroom_date_viewed ASC
			";

			$result = $exam->query_result();

			$output ='
			<style>
				@page { margin:20px; }

			</style>
			<p>&nbsp;</p>
			<h2 align="center">Attendance Report</h2><br/>
			';

			foreach ($result as $row) 
			{
				$output .= '
				<table width=100% border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td width="25%"><b>Date & Time</b><td>
						<td width="75%">'.$row["classroom_date_viewed"].'</td> 
					</tr>
					<tr>
						<td colspan="8">
							<table width=100% border="1" cellpadding="5" cellspacing="0">
							<tr>
								<td><b>Matric Number</b></td>
								<td><b>Student Name</b></td>
								<td><b>Course Code</b></td>
								<td><b>Attendance Status</b></td>
							</tr>
				';

				$exam->query = "
				SELECT * FROM classroom_visibility_table
				INNER JOIN user_course_enroll_table ON user_course_enroll_table.user_course_enroll_id = classroom_visibility_table.user_course_enroll_id
				INNER JOIN user_table ON user_table.user_id = user_course_enroll_table.user_id
				WHERE user_course_enroll_table.course_id = ".$_GET['course_id']."
				AND classroom_visibility_table.classroom_date_viewed = '".$row['classroom_date_viewed']."'
				";

				$sub_result = $exam->query_result();

				foreach($sub_result as $sub_row) 
				{
					if($sub_row['seen'] == 1)
					{
						$status = 'Present';
					}
					else
					{
						$status = 'Absent';
					}

					$output .='
								<tr>
									<td>'.$sub_row["matric_no"].'</td>
									<td>'.$sub_row["user_name"].'</td>
									<td>'.$row["course_code"].'</td>
									<td>'.$status.'</td>		
								</tr>
					';
				}
				$output .='
						</td>
					</tr>
				</table><br /><br />
				';
			}
			$pdf = new pdf();
			$file_name = 'Attendance Report.pdf';
			$pdf->loadHtml($output);
			$pdf->render();
			$pdf->stream($file_name, array("Attachment" => false));
			exit(0); 
		}
	}
}
?>