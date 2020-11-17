<?php
class Examination
{
	var $host;
	var $username;
	var $password;
	var $database;
	var $connect;
	var $home_page;
	var $query;
	var $data;
	var $statement;
	var $filedata;
	
	function __construct()
	{
		$this->host = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'advance_elearning';
		$this->home_page = 'http://localhost/tutorial/online_examination/';
		$this->connect = new PDO("mysql:host=$this->host;dbname=$this->database", "$this->username", "$this->password");

		session_start();
	}

	function execute_query()
	{
		$this->statement = $this->connect->prepare($this->query);
		$this->statement->execute($this->data);
	}

	function total_row()
	{
		$this->execute_query();
		return $this->statement->rowCount();
	}

	function send_email($receiver_email, $subject, $body)
	{
		$mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->Host = 'smtp host';

		$mail->Port = '587';

		$mail->SMTPAuth = true;

		$mail->Username = '';

		$mail->Password = '';

		$mail->SMTPSecure = '';

		$mail->From = 'oregsgraphix@gmail.com';

		$mail->FromName = 'oregsgraphix@gmail.com';

		$mail->AddAddress($receiver_email, '');

		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();
 	}

 	function redirect($page)
 	{
 		header('location:'.$page.'');
 		exit;
 	}

 	function admin_session_private()
 	{
 		if(!isset($_SESSION['admin_id']))
 		{
 			$this->redirect('login.php');
 		}
 	}

 	function admin_session_public()
 	{
 		if(isset($_SESSION['admin_id']))
 		{
 			$this->redirect('index.php');
 		}
 	}

 	function tutor_session_private()
 	{
 		if(!isset($_SESSION['tutor_id']))
 		{
 			$this->redirect('login.php');
 		}
 	}

 	function tutor_session_public()
 	{
 		if(isset($_SESSION['tutor_id']))
 		{
 			$this->redirect('tutor_module.php');
 		}
 	}

 	function query_result()
 	{
 		$this->execute_query();
 		return $this->statement->fetchAll();
 	}

 	function clean_data($data)
 	{
 		$data = trim($data);
 		$data = stripslashes($data);
 		$data = htmlspecialchars($data);
 		return $data;
 	}

	function Is_exam_is_not_started($online_exam_id)
	{
		date_default_timezone_set('Africa/Lagos');

		$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

		$exam_datetime = '';

		$this->query ="
		SELECT online_exam_datetime FROM online_exam_table WHERE online_exam_id = '$online_exam_id'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
		 	$exam_datetime = $row['online_exam_datetime'];	
		} 

		if($exam_datetime > $current_datetime)
		{
			return true;
		}
		return false;
	} 	

	function Get_exam_question_limit($exam_id)
	{
		$this->query = "
		SELECT total_question FROM online_exam_table
		WHERE online_exam_id = '$exam_id'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['total_question'];
		}
	}

	function Get_exam_total_question($exam_id)
	{
		$this->query = "
		SELECT question_id FROM question_table 
		WHERE online_exam_id = '$exam_id'
		";

		return $this->total_row();
	}

	function Is_allowed_add_question($exam_id)
	{
		$exam_question_limit = $this->Get_exam_question_limit($exam_id);

		$exam_total_question = $this->Get_exam_total_question($exam_id);

		if($exam_total_question >= $exam_question_limit)
		{
			return false;
		}
		return true;
	}

	function execute_question_with_last_id()
	{
		$this->statement = $this->connect->prepare($this->query);

		$this->statement->execute($this->data);

		return $this->connect->lastInsertId();
	}

	function Get_exam_id($course_id, $session)
	{
		$this->query = "
		SELECT online_exam_id FROM online_exam_table
		WHERE course_id = '$course_id' AND session = '$session'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['online_exam_id'];
		}
	}

	function Get_examination_id($exam_code)
	{
		$this->query = "
		SELECT online_exam_id FROM online_exam_table
		WHERE online_exam_code = '$exam_code'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['online_exam_id'];
		}
	}

	function Get_assignment_id($assignment_code)
	{
		$this->query = "
		SELECT assignment_id FROM assignment_table
		WHERE assignment_code = '$assignment_code'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['assignment_id'];
		}
	}

	function upload_file()
	{
		if(!empty($this->filedata['name']))
		{
			date_default_timezone_set('Africa/Lagos');

			$allowed = ['docx', 'pdf', 'ppt'];
			$extension = pathinfo($this->filedata['name'], PATHINFO_EXTENSION);
			$new_name =uniqid() . date("Y-m-d") . '.' . $extension;
			$_source_path = $this->filedata['tmp_name'];

			if(in_array($extension, $allowed))
			{
				$target_path = 'assignment_file/' . $new_name;
				move_uploaded_file($_source_path, $target_path);
			}
			else
			{
				$target_path = 'upload/' . $new_name;
				move_uploaded_file($_source_path, $target_path);
			}

			return $new_name;
		}
	}

	function user_session_private()
 	{
 		if(!isset($_SESSION['user_id']))
 		{
 			$this->redirect('login.php');
 		}
 	}

 	function user_session_public()
 	{
 		if(isset($_SESSION['user_id']))
 		{
 			$this->redirect('student_module.php');
 		}
 	}

 	function Fill_exam_list()
 	{
 		$this->query = "
 		SELECT online_exam_id, course_name FROM online_exam_table
 		INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
 		WHERE online_exam_status = 'Created' 

 		ORDER BY course_table.course_name ASC
 		";
 		$result = $this->query_result();
 		$output = '';
 		foreach($result as $row) 
 		{
 			$output .= '<option value="'.$row["online_exam_id"].'">'.$row["course_name"].'</option>';
 		}
 		return $output;
 	}

 	function If_user_already_enroll_exam($exam_id, $user_id)
 	{
 		$this->query = "
 		SELECT * FROM user_exam_enroll_table
 		WHERE exam_id = '$exam_id'
 		AND user_id = '$user_id'
 		";
 		if($this->total_row() > 0)
 		{
 			return true;
 		}
 		return false;
 	}

 	function Change_exam_status($user_id)
	{
		$this->query = "
		SELECT * FROM user_course_enroll_table 
		INNER JOIN online_exam_table 
		ON online_exam_table.course_id = user_course_enroll_table.course_id 
		WHERE user_course_enroll_table.user_id = '".$user_id."'
		";

		$result = $this->query_result();

		date_default_timezone_set('Africa/Lagos');

		$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

		foreach($result as $row)
		{
			$exam_start_time = $row["online_exam_datetime"];

			$duration = $row["online_exam_duration"] . ' minute';

			$exam_end_time = strtotime($exam_start_time . '+' . $duration);

			$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);

			$view_exam = '';

			if($current_datetime >= $exam_start_time && $current_datetime <= $exam_end_time)
			{
				//exam started
				$this->data = array(
					':online_exam_status'	=>	'Started'
				);

				$this->query = "
				UPDATE online_exam_table 
				SET online_exam_status = :online_exam_status 
				WHERE online_exam_id = '".$row['online_exam_id']."'
				";

				$this->execute_query();
			}
			else
			{
				if($current_datetime > $exam_end_time)
				{
					//exam completed
					$this->data = array(
						':online_exam_status'	=>	'Completed'
					);

					$this->query = "
					UPDATE online_exam_table 
					SET online_exam_status = :online_exam_status 
					WHERE online_exam_id = '".$row['online_exam_id']."'
					";

					$this->execute_query();
				}					
			}
		}
	}

	function Get_question_right_answer_mark($exam_id)
	{
		$this->query = "
		SELECT marks_per_right_answer FROM online_exam_table 
		WHERE online_exam_id = '".$exam_id."'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['marks_per_right_answer'];
		}
	}

	function Get_question_wrong_answer_mark($exam_id)
	{
		$this->query = "
		SELECT marks_per_wrong_answer FROM online_exam_table 
		WHERE online_exam_id = '".$exam_id."'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row['marks_per_wrong_answer'];
		}
	}

	function Get_question_answer_option($question_id)
	{
		$this->query = "
		SELECT answer_option FROM question_table
		WHERE question_id = '".$question_id."'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['answer_option'];
		}
	}

	function Question_answer_exist($exam_id, $question_id)
	{
		$this->query = "
		SELECT * FROM user_exam_question_answer
		WHERE exam_id = '".$exam_id."'
		AND question_id = '".$question_id."'
		";
		
		if($this->total_row() > 0)
 		{
 			return true;
 		}
 		return false;
	}

	function Get_exam_status($exam_id)
	{
		$this->query = "
		SELECT online_exam_status FROM online_exam_table
		WHERE online_exam_id = '".$exam_id."'
		";

		$result = $this->query_result();
		foreach($result as $row) 
		{
			return $row['online_exam_status'];
		}
	}

	function Get_user_exam_status($exam_id, $user_id)
	{
		$this->query = "
		SELECT attendance_status FROM user_exam_enroll_table
		WHERE exam_id = '$exam_id'
		AND user_id = '$user_id'
		";

		$result = $this->query_result();

		foreach($result as $row)
		{
			return $row["attendance_status"];
		}
	}

	function Get_data($tablename, $value, $input)
	{
		$this->query = "SELECT * FROM $tablename ORDER BY $value ASC ";

		$result = $this->query_result();

		$output = '';

		foreach($result as $row)
		{
			$output .= '<option value="'.$row["$value"].'">'.$row["$input"].'</option>';
		}
		return $output;
	}

	function Get_course_data()
	{
		$this->query = "SELECT * FROM course_table";

		$result = $this->query_result();

		$output = '';

		foreach($result as $row)
		{
			$output .= '<option value="'.$row["course_id"].'">'.$row["course_code"].' - '.$row["course_name"].'</option>';
		}
		return $output;
	}

	function Get_current_semester()
	{
		$this->query = "SELECT * FROM semester_table";

		$result = $this->query_result();

		date_default_timezone_set('Africa/Lagos');

		$current_date = date("Y-m-d");

		foreach($result as $row)
		{
			$semester_start_date = date($row["semester_start_date"]);

			$semester_end_date = date($row["semester_end_date"]);


			if($current_date >= $semester_start_date && $current_date <= $semester_end_date)
			{
				return $row['semester_id'];
			}
		}
	}

	function Get_course_enroll($course_id, $user_id)
	{
		$this->query ="
		SELECT course_id FROM user_course_enroll_table 
		WHERE course_id = '$course_id' AND user_id = '$user_id'
		";
		
		if($this->total_row() > 0)
 		{
 			return true;
 		}
 		return false;
	}

	function Current_session($session_id)
	{
		$this->query = "SELECT * FROM session_table WHERE session_id = '".$session_id."'";

		$result = $this->query_result();

		date_default_timezone_set('Africa/Lagos');

		$current_date = date("Y-m-d");

		foreach($result as $row)
		{
			$session_start_date = date($row["session_start_date"]);

			$session_end_date = date($row["session_end_date"]);


			if($current_date >= $session_end_date)
			{
				return false;
			}
			return true;
		}
	}

	function Get_course_assign($tutor_id)
	{
		$this->query = "
		SELECT * FROM course_assign_table
		INNER JOIN course_table ON course_assign_table.course_id = course_table.course_id 
		WHERE course_assign_table.tutor_id='".$_POST['tutor_id']."'
		";

		$result = $this->query_result();
		
		$output = '<table>
		<thead class ="alert-success">
		<tr>
			<th>Course Name</th>
			<th>Course Code</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>';

		if($this->total_row() > 0)
		{
			foreach($result as $row) 
			{
	
				$output .= '<tr>
					<td>'.$row['course_code'].'</td>
					<td>'.$row['course_name'].'</td>
					<td> <button type="button" name="remove" value="'.$row['course_assign_id'].'" class="btn btn-danger btn-xs remove" value=""><span class="glyphicon glyphicon-trash"></span> Delete</button></td>
				</tr>';
			}
		}
		$output .= '</tbody></table>';
		return $output;
	}

	function Get_tutor_course_assign($tutor_id)
	{
		$this->query = "SELECT * FROM course_assign_table
		INNER JOIN course_table ON course_assign_table.course_id = course_table.course_id
		WHERE tutor_id = '".$tutor_id."'
		";

		$result = $this->query_result();

		$output = '';

		foreach($result as $row)
		{
			$output .= '<option value="'.$row["course_id"].'">'.$row["course_code"].' - '.$row["course_name"].'</option>';
		}
		return $output;
	}

	function Verify_assignment_num($tutor_id, $course_id, $assignment_num)
	{
		$this->query ="
		SELECT * FROM assignment_table 
		WHERE $tutor_id = '$tutor_id' AND course_id = '$course_id' AND assignment_num = '$assignment_num'
		";
		
		if($this->total_row() > 0)
 		{
 			return false;
 		}
 		return true;
	}

	function Time_expire($tablename, $id, $arguement, $value)
	{
		date_default_timezone_set('Africa/Lagos');
		
		$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

		$exam_datetime = '';

		$this->query ="
		SELECT * FROM $tablename WHERE $id = ".$arguement."
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
		 	$datetime = $row[$value];

		 	if($datetime < $current_datetime)
			{
				return false;
			}
			return true;	
		} 
	} 	

	function Verify_submission($assignment_id)
	{
		$this->query ="
		SELECT * FROM assignment_submission_table WHERE assignment_id = '".$assignment_id."'
		";
		
		if($this->total_row() > 0)
 		{
 			return true;
 		}
 		return false;
	}

	function Verify_submission_index($assignment_id)
	{
		$this->query ="
		SELECT * FROM assignment_submission_table WHERE assignment_id = '".$assignment_id."'
		";

		$result = $this->query_result();
		
		foreach($result as $row)
		{
			return $row['assignment_id'];
		}
	}

	function Get_assignment_grade($assignment_submission_id)
	{
		$this->query = "SELECT * FROM assignment_submission_table 
		WHERE assignment_submission_id = '".$assignment_submission_id."'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			if($row['status'] == 'Ungraded')
			{
				return true;
			}
			return false;
		}
	}

	function Get_assignment_score($assignment_id, $value)
	{
		$this->query = "SELECT * FROM assignment_table WHERE assignment_id = '".$assignment_id."'";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			if($row['assignment_score'] < $value)
			{
				return false;
			}
			return true;
		}
	}

	function Get_count($user_id, $course_id)
	{
		$this->query = "SELECT count FROM assignment_result_table 
		WHERE user_id = '".$_POST['user_id']."' AND course_id = '".$_POST['course_id']."'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row['count'];
		}
	}

	function User_verification_result($user_id, $course_id)
	{
		$this->query = "SELECT * FROM assignment_result_table 
		WHERE user_id = '".$user_id."' AND course_id = '".$course_id."'
		";

		if($this->total_row() > 0)
		{
			return true;
		}
		return false;
	}

	function Get_specific_data($tablename, $attribute, $arguement, $value)
	{
		$this->query = "
		SELECT * FROM $tablename
		WHERE $attribute = '$arguement'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			return $row[$value];
		}
	}

	function get_reply_Comment($classroom_id, $parent_id = 0, $marginleft = 0)
	{
		$this->query = "
		SELECT * FROM comment_table WHERE parent_comment_id = '".$parent_id."' AND classroom_id = '".$classroom_id."'
		";

		$result = $this->query_result();
		$count = $this->total_row();
		$output = '';

		if($parent_id == 0)
		{
			$marginleft = 0;
		}
		else
		{
			$marginleft = $marginleft + 48;
		}

		if($count > 0)
		{
			foreach ($result as $row) 
			{
				$output .= '
				<div class="card" style="margin-left:'.$marginleft.'px">
					<div class="card-header">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["comment_datetime"].'</i></div>
					<div class="card-body">'.$row["comment_text"].'</div>
					<div class="card-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
				</div><br />
				';

				// Recursive function
				$output .= $this->get_reply_Comment($classroom_id, $row["comment_id"], $marginleft);
			}
		}
		return $output;
	}

	function Get_user_data($course_id, $classroom_id)
	{
		$this->query = "
		SELECT user_course_enroll_id, user_id FROM user_course_enroll_table
		WHERE course_id = '$course_id'
		";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			$this->data = array(
				':user_course_enroll_id'	=>	$row['user_course_enroll_id'],
				':user_id'					=>	$row['user_id'],
				':classroom_id'				=>	$classroom_id,
				':seen'						=>	'0'
			);

			$this->query = "
			INSERT INTO classroom_visibility_table(classroom_id, user_id, user_course_enroll_id, seen)
			VALUES (:classroom_id, :user_id, :user_course_enroll_id, :seen)
			";

			$this->execute_query();
		}
		$output = array(
			'success'	=> 'Lecture Details Added'
		);

		return $output;
	}

	function Classroom_viewed($user_id, $classroom_id, $course_id)
	{
		$this->query = "
		SELECT user_course_enroll_id FROM user_course_enroll_table
		WHERE course_id = '$course_id' AND user_id = '$user_id'
		";

		$result = $this->query_result();

		date_default_timezone_set('Africa/Lagos');
		$current_date = date("Y-m-d");


		foreach ($result as $row) 
		{
			$this->data = array(
				':seen'				=>	1,
			);

			$this->query = "
			SELECT classroom_date_viewed FROM classroom_visibility_table
			WHERE  user_course_enroll_id = ".$row['user_course_enroll_id']." 
			AND classroom_id = ".$classroom_id."
			";

			$view_result = $this->query_result();

			foreach ($view_result as $view_row) 
			{
				if($view_row['classroom_date_viewed'] == '0000-00-00')
				{
					$this->query = "
					UPDATE classroom_visibility_table 
					SET seen = :seen, classroom_date_viewed = '$current_date'
					WHERE  user_course_enroll_id = ".$row['user_course_enroll_id']." 
					AND classroom_id = ".$classroom_id."
					";

					$this->execute_query();
				}
			}
		}
	}

	function Comment_viewed($classroom_id)
	{
		$this->query = "SELECT * FROM comment_table WHERE classroom_id = ".$classroom_id."";
		$result = $this->query_result();

		foreach($result as $row)
		{
			$this->data = array(
				':seen'			=>	1
			);

			$this->query = "
			UPDATE comment_table SET seen = :seen WHERE classroom_id = ".$classroom_id."
			";

			$this->execute_query();
		}
	}

	function Get_total_row($classroom_id)
	{
		$this->query = "SELECT * FROM classroom_visibility_table
		WHERE classroom_id = '$classroom_id' AND seen = 1";
		$total_row = $this->total_row();
		return $total_row;
	}

	function Count_total_row($tablename, $attribute, $arguement)
	{
		$this->query = "SELECT * FROM $tablename WHERE $attribute = '$arguement'";
		$total_row = $this->total_row();
		return $total_row;
	}

	function Change_examination_status($exam_id)
	{
		$exam_total_question = $this->Get_exam_total_question($exam_id);
		$exam_question_limit = $this->Get_exam_question_limit($exam_id);
		
		if($exam_total_question == $exam_question_limit)
		{
			$this->data = array(
				':online_exam_status'	=>	'Created'
			);

			$this->query = "UPDATE online_exam_table 
			SET online_exam_status = :online_exam_status
			WHERE online_exam_id = ".$exam_id."";

			$this->execute_query();
		}
		else
		{
			return $exam_id;
		}
	}

	function Change_level_status()
	{
		$this->query = "SELECT user_id, level_id FROM user_table";

		$result = $this->query_result();

		foreach($result as $row) 
		{
			$this->data = array(
				':level_id'	=>	$row['level_id'] + 1
			);

			$this->query = "UPDATE user_table SET level_id = :level_id WHERE user_id = ".$row["user_id"]."";

			$this->execute_query();
		}
	}

	function get_attendance_percentage($enroll_id, $session_id)
	{
		$this->query = "
		SELECT ROUND((SELECT COUNT(*) FROM classroom_visibility_table 
		WHERE seen = 1 AND user_course_enroll_id = ".$enroll_id.") * 100 / COUNT(*)) 
		AS percentage FROM classroom_visibility_table WHERE user_course_enroll_id = ".$enroll_id."
		";

		$result = $this->query_result();

		foreach ($result as $row) 
		{
			// die(var_dump($session_id, $classroom_id));
			if($row["percentage"] > 0)
			{
				return $row["percentage"] . '%';

			}
			else
			{
				return 'NA';
			}
		}
	}
}

?>