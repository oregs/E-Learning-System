<?php

include('master/Examination.php');

require_once('class/class.phpmailer.php');

$exam = new Examination;

date_default_timezone_set('Africa/Lagos');

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM user_table
			WHERE user_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=> true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'check_matricno')
		{
			$exam->query = "
			SELECT * FROM user_table WHERE matric_no = '".$_POST["matric_no"]."'";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=> true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$user_verification_code = md5(rand());
			$receiver_email = $_POST['user_email_address'];
			$exam->filedata = $_FILES['user_image'];
			$user_image = $exam->upload_file();
			$exam->data = array(
				':matric_no'				=> 	$_POST['matric_no'],
				':user_email_address'		=> 	$receiver_email,
				':user_password'			=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verification_code'	=>	$user_verification_code,
				':user_name'				=>	$_POST['user_name'],
				':user_gender'				=>	$_POST['user_gender'],
				':user_address'				=>	$_POST['user_address'],
				':user_mobile_no'			=>	$_POST['user_mobile_no'],
				':user_image'				=>	$user_image,
				':user_created_on'			=>	$current_datetime,
				':level_id'					=>	$_POST['level_id'],
				'department_id'				=>	$_POST['department_id']
			);

			$exam->query = "
			INSERT INTO user_table(matric_no, user_email_address, user_password, user_verification_code, user_name, user_gender, user_address, user_mobile_no, user_image, department_id, user_created_on, level_id)
			VALUES(:matric_no, :user_email_address, :user_password, :user_verification_code, :user_name, :user_gender, :user_address, :user_mobile_no, :user_image, :department_id, :user_created_on, :level_id)
			";

			$exam->execute_query();

			// die(var_dump($exam));

			$subject = 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=master&code='.$user_verification_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$_SESSION['session_id'] = $_POST['session_id'];
			
			$exam->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);

			$exam->query = "
			SELECT * FROM user_table
			WHERE user_email_address = :user_email_address
			";

			$total_row = $exam->total_row();

			// die(var_dump($total_row));

			if($total_row > 0)
			{
				$result = $exam->query_result();

				foreach ($result as $row) 
				{
					if($row['user_email_verified'] == 'yes')
					{
						if(password_verify($_POST['user_password'], $row['user_password']))
						{
							$_SESSION['user_id'] = $row['user_id'];
							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'		=>	'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'	=>	'Wrong Email Address'
				);
			}
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'profile')
	{
		if($_POST['action'] == 'profile')
		{
			$user_image = $_POST['hidden_user_image'];

			if($_FILES['user_image']['name'] != '')
			{
				$exam->filedata = $_FILES['user_image'];
				$user_image = $exam->upload_file();
			}

			$new = $exam->data = array(
				':user_name'		=>	$_POST['user_name'],
				':user_gender'		=>	$_POST['user_gender'],
				':user_address'		=>	$_POST['user_address'],
				':user_mobile_no'	=>	$_POST['user_mobile_no'],
				':user_image'		=>	$user_image,
				':user_id'			=>	$_SESSION['user_id']
			);

			$exam->query = "
			UPDATE user_table
			SET user_name = :user_name, user_gender = :user_gender, user_address = :user_address, user_mobile_no = :user_mobile_no, user_image = :user_image
			WHERE user_id = :user_id
			";

			$exam->execute_query();
			// die(var_dump($new));
			$output = array(
				'success' => true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'change_password')
	{
		if($_POST['action'] == 'change_password')
		{
			$exam->data = array(
				':user_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_id'			=>	$_SESSION['user_id']
			);

			$exam->query = "
			UPDATE user_table
			SET user_password = :user_password
			WHERE user_id = :user_id
			";

			$exam->execute_query();
			session_destroy();
			$output = array(
				'success'	=> 'Password has been change'
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'examination')
	{
		if($_POST['action'] == "fetch_exam")
		{
			$current_semester = $exam->Get_current_semester();

			$exam->query = "
			SELECT * FROM online_exam_table
			INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
			INNER JOIN level_table ON level_table.level_id = course_table.level_id
			WHERE course_table.semester_id = '".$current_semester."' AND online_exam_status = 'Created' AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR level_table.level_code LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ') ';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start']. ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM online_exam_table";

			$total_rows = $exam->total_row();
			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row["course_code"]. ' - ' . $row["course_name"];
				$sub_array[] = $row["online_exam_datetime"];
				$sub_array[] = $row["online_exam_duration"];
				$sub_array[] = $row["total_question"];
				$sub_array[] = $row["marks_per_right_answer"];
				$sub_array[] = $row["marks_per_wrong_answer"];

				$enroll_button = '';

				if($exam->If_user_already_enroll_exam($row['online_exam_id'], $_SESSION['user_id']))
				{
					$enroll_button = '<button type="button" name="enroll_button" class="btn btn-info">Already Enrolled</button>';
				}
				else
				{
					$enroll_button = '<button type="button" name="enroll_button" id="enroll_button" class="btn btn-warning" data-exam_id="'.$row['online_exam_id'].'">Enroll it</button>';
				}

				$sub_array[] = $enroll_button;
				$data[] = $sub_array;
			}

			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'enroll_exam')
		{
			$exam->data = array(
				':user_id'	=>	$_SESSION['user_id'],
				':exam_id'	=>	$_POST['exam_id']
			);

			$exam->query = "
			INSERT INTO user_exam_enroll_table(user_id, exam_id)
			VALUES (:user_id, :exam_id)
			";
			$exam->execute_query();

			$exam->query = "
			SELECT question_id FROM question_table
			WHERE online_exam_id = '".$_POST['exam_id']."'
			";
			$result = $exam->query_result();

			foreach($result as $row)
			{
				$exam->data = array(
					':user_id'				=>	$_SESSION['user_id'],
					':exam_id'				=>	$_POST['exam_id'],
					':question_id'			=>	$row['question_id'],
					':user_answer_option'	=>	'0',
					':marks'				=>	'0'

				);
				
				$exam->query = "
				INSERT INTO user_exam_question_answer(user_id, exam_id, question_id, user_answer_option, marks)
				VALUES (:user_id, :exam_id, :question_id, :user_answer_option, :marks)
				";
				$exam->execute_query();
			}
		}
	}

	if($_POST['page'] == 'enroll_exam')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();
			$exam->query = "
			SELECT * FROM online_exam_table
			INNER JOIN course_table
			ON online_exam_table.course_id = course_table.course_id
			INNER JOIN user_exam_enroll_table
			ON user_exam_enroll_table.exam_id = online_exam_table.online_exam_id
			WHERE user_exam_enroll_table.user_id = '".$_SESSION['user_id']."' 
			AND online_exam_table.session_id = '".$_SESSION['session_id']."' AND (
			";
			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_table.online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_table.online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_table.total_question LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_table.online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM online_exam_table
			INNER JOIN course_table
			ON online_exam_table.course_id = course_table.course_id
			INNER JOIN user_exam_enroll_table
			ON user_exam_enroll_table.exam_id = online_exam_table.online_exam_id
			WHERE user_exam_enroll_table.user_id = '".$_SESSION['user_id']."'
			online_exam_table.session_id = '".$_SESSION['session_id']."'";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				
				$sub_array[] = $row['course_name'];
				$sub_array[] = $row['online_exam_datetime'];
				$sub_array[] = $row['online_exam_duration'] . ' Minute';
				$sub_array[] = $row['total_question'] . ' Question';
				$sub_array[] = $row['marks_per_right_answer'] . ' Marks';
				$sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Marks';
				$status = '';
				$view_exam = '';

				if($row['online_exam_status'] == 'Created')
				{
					$status = '<span class="badge badge-success">Created</span>';
				}
				if($row['online_exam_status'] == 'Started')
				{
					$status = '<span class="badge badge-primary">Started</span>';
				}
				if($row['online_exam_status'] == 'Completed')
				{
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				$sub_array[] = $status;


				if($row["online_exam_status"] == 'Started')
				{
					$view_exam = '<a href="view_exam.php?code='.$row["online_exam_code"].'" class="btn btn-info btn-sm">Started</a>';
				}
				if($row["online_exam_status"] == 'Completed')
				{
					$view_exam = '<a href="view_exam.php?code='.$row["online_exam_code"].'" class="btn btn-info btn-sm">View Result</a>';
				}


				$sub_array[] = $view_exam;

				$data[] = $sub_array;
			}
			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'view_exam')
	{
		if($_POST['action'] == 'load_question')
		{
			if($_POST['question_id'] == '')
			{
				$exam->query = "
				SELECT * FROM question_table
				WHERE online_exam_id = '".$_POST["exam_id"]."'
				ORDER BY question_id ASC
				LIMIT 1
				";
			}
			else
			{
				$exam->query = "
				SELECT * FROM question_table 
				WHERE question_id = '".$_POST["question_id"]."'
				";
			}

			$result = $exam->query_result();
			$output = '';

			foreach($result as $row)
			{
				$output .= '
				<h2>'.$row["question_title"].'</h2>
				<hr />
				<br />
				<div class="row">
				';

				if($row['question_type'] == 'Subjunctive')
				{

					// if(!empty($_POST['question_id']))
					// {
					// 	$exam->query = "
					// 	SELECT * FROM user_exam_question_answer 
					// 	WHERE question_id = '".$_POST["question_id"]."'
					// 	AND exam_id = '".$_POST["exam_id"]."' AND user_id = '".$_SESSION["user_id"]."'
					// 	";
					// 	$result = $exam->query_result();

					// 	foreach ($result as $sub_row) 
					// 	{
					// 		$value = $row['user_answer_option'];
					// 	}
					// }
					
					$output .='
					<div class="col-md-6">
						<div class="form-group">
							<label>Enter Answer</label>
							<input type="text" name="sub_answer" data-question_id="'.$row["question_id"].'" data-question_type="'.$row["question_type"].'" id="sub_answer" class="form-control answer_option" />
						</div>
					</div>
					';
				}

				if($row['question_type'] == 'Objective')
				{
					$exam->query = "
					SELECT * FROM option_table
					WHERE question_id = '".$row['question_id']."'
					";

					$sub_result = $exam->query_result();

					$count = 1;

					foreach($sub_result as $sub_row)
					{
						$output .= '
						<div class="col-md-6" style="margin-bottom:32px;">
							<div class="radio">
								<label><h4><input type="radio" name="option_1" class="answer_option" data-question_id="'.$row["question_id"].'" data-question_type="'.$row["question_type"].'" data-id="'.$count.'"/>&nbsp;'.$sub_row["option_title"].'</h4></label>
							</div>
						</div>
						';

						$count = $count + 1;
					}
				}

				$output .= '
				</div>
				';

				$exam->query = "
				SELECT question_id FROM question_table
				WHERE question_id < '".$row['question_id']."'
				AND online_exam_id = '".$_POST["exam_id"]."'
				ORDER BY question_id DESC
				LIMIT 1
				";

				$previous_result = $exam->query_result();

				$previous_id = '';
				$next_id = '';

				foreach($previous_result as $previous_row)
				{
					$previous_id = $previous_row['question_id'];
				}

				$exam->query = "
				SELECT question_id FROM question_table
				WHERE question_id > '".$row['question_id']."'
				AND online_exam_id = '".$_POST["exam_id"]."'
				ORDER BY question_id ASC
				LIMIT 1
				";

				$next_result = $exam->query_result();

				foreach($next_result as $next_row)
				{
					$next_id = $next_row['question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';

				if($previous_id == '')
				{
					$if_previous_disable = 'disabled';
				}

				if($next_id == '')
				{
					$if_next_disable = 'disabled';
				}

				$output .='
				<br /><br />
				<div align="center">
					<button type="button" name="previous" class="btn btn-info btn-lg previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
					<button type="button" name="next" class="btn btn-warning btn-lg next" id="'.$next_id.'" '.$if_next_disable.'>Next</button>
				</div>
				<br /><br />
				';
			}

			echo $output;
		}

		if($_POST['action'] == 'question_navigation')
		{
			$exam->query = "
			SELECT question_id FROM question_table
			WHERE online_exam_id = '".$_POST["exam_id"]."'
			ORDER BY question_id ASC
			";

			$result = $exam->query_result();

			$output = '
			<div class="card">
				<div class="card-header">Question Navigation</div>
				<div class="card-body">
					<div class="row">
			';

			$count = 1;

			foreach($result as $row)
			{
				$output .= '
				<div class="col-md-2" style="margin-bottom:24px;">
					<button type="button" class="btn btn-primary btn-lg question_navigation" data-question_id="'.$row["question_id"].'">'.$count.'</button>
				</div>
				';

				$count = $count + 1;
			}

			$output .= '
				<div>
			</div></div>
			';

			echo $output;
		}

		if($_POST['action'] == 'user_detail')
		{
			$exam->query = "
			SELECT * FROM user_table
			WHERE user_id ='".$_SESSION["user_id"]."'
			";

			$result = $exam->query_result();

			$output = '
			<div class="card">
				<div class="card-header">User Details</div>
				<div class="card_body">
					<div class="row">

			';

			foreach($result as $row)
			{
				$output .= '
				<div class="col-md-3">
					<img src="upload/'.$row["user_image"].'" class="img-fluid" />
					</div>
					<div class="col-md-9">
						<table class="table table-bordered">
							<tr>
								<th>Name</th>
								<td>'.$row["user_name"].'</td>
							</tr>
							<tr>
								<th>Email ID</th>
								<td>'.$row["user_email_address"].'</td>
							</tr>
							<tr>
								<th>Gender</th>
								<td>'.$row["user_gender"].'</td>
							</tr>	
						</table>
					</div>		
				';
			}
			$output .= '</div></div></div>';

			echo $output;
		}

		if($_POST['action'] == 'answer')
		{
			$exam_right_answer_mark = $exam->Get_question_right_answer_mark($_POST['exam_id']);

			$exam_wrong_answer_mark = $exam->Get_question_wrong_answer_mark($_POST['exam_id']);
			$original_answer = $exam->Get_question_answer_option($_POST['question_id']);

			$marks = 0;

	
			if($original_answer == $_POST['answer_option'])
			{
				$marks = '+' . $exam_right_answer_mark;
			}
			else
			{
				$marks = '-' . $exam_wrong_answer_mark;
			}

			if($exam->Question_answer_exist($_POST['exam_id'], $_POST['question_id']))
			{
				$exam->data = array(
					':user_answer_option'	=>	$_POST['answer_option'],
					':marks'				=>	$marks
				);

				$exam->query = "
				UPDATE user_exam_question_answer
				SET user_answer_option = :user_answer_option, marks = :marks
				WHERE user_id = '".$_SESSION["user_id"]."'
				AND exam_id = '".$_POST['exam_id']."'
				AND question_id = '".$_POST["question_id"]."'
				";

				$exam->execute_query();
			}
			else
			{
				$exam->data = array(
					':user_id'				=>	$_SESSION['user_id'],
					':exam_id'				=>	$_POST['exam_id'],
					':question_id'			=>	$_POST['question_id'],
					':user_answer_option'	=>	$_POST['answer_option'],
					':marks'				=>	$marks
				);

				$exam->query = "
				INSERT INTO user_exam_question_answer(user_id, exam_id, question_id, user_answer_option, marks)
				VALUES(:user_id, :exam_id, :question_id, :user_answer_option, :marks)
				";

				$exam->execute_query();
			}
			
		}
	}

	if($_POST['page'] == 'course')
	{
		if($_POST['action'] == 'fetch')
		{
			$current_semester = $exam->Get_current_semester();

			$column = array("course_table.course_id", "course_table.course_code", "course_table.course_name", "course_table.course_unit");
			$exam->query = "
				SELECT * FROM level_table
				INNER JOIN course_table
				ON level_table.level_id = course_table.level_id
			";
			$exam->query .= " WHERE course_table.semester_id = ".$current_semester." AND ";

			if(isset($_POST["is_level"]))
			{
				$exam->query .= "course_table.level_id = '".$_POST["is_level"]."' AND";
			}
			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= '(course_table.course_id LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR level_table.level_code LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY course_table.course_id ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start']. ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM course_table";

			$total_rows = $exam->total_row();
			$data = array();

			foreach($result as $row)
			{
				$enroll = '';

				if($exam->Get_course_enroll($row['course_id'], $_SESSION['user_id']))
				{
					$enroll = '';
				}
				else
				{
					$enroll = '<button value="'.$row['course_id'].'" type="button" name="register" class="btn btn-primary btn-sm success register">Register</button>';
				}

				$sub_array = array();
				$sub_array[] = $row["course_id"];
				$sub_array[] = $row["course_code"];
				$sub_array[] = $row["course_name"];
				$sub_array[] = $row["course_unit"];
				$sub_array[] = $enroll;
				$data[] = $sub_array;
			}

			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'enroll_fetch')
		{
			$current_semester = $exam->Get_current_semester();
				// die(var_dump($current_semester));

			$column = array("course_table.course_id", "course_table.course_code", "course_table.course_name", "course_table.course_unit");

			$exam->query = "
				SELECT * FROM user_course_enroll_table
				INNER JOIN course_table
				ON user_course_enroll_table.course_id = course_table.course_id
			";
			$exam->query .= " WHERE user_course_enroll_table.user_id = ".$_SESSION["user_id"]." AND course_table.semester_id = ".$current_semester." AND";
			
			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= '(course_table.course_id LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_code LIKE "%'.$_POST["search"]["value"].'%") ';
			}

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY course_table.course_id ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start']. ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM table_course";

			$total_rows = $exam->total_row();
			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row["course_id"];
				$sub_array[] = $row["course_code"];
				$sub_array[] = $row["course_name"];
				$sub_array[] = $row["course_unit"];
				$sub_array[] = '<button id="'.$row['course_id'].'" type="button" name="delete" class="btn btn-danger btn-sm delete">Delete</button>';
				$data[] = $sub_array;
			}

			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'enroll')
		{
			$exam->data = array(
				':course_id'	=>	$_POST['course_id'],
				':user_id'		=>	$_SESSION["user_id"]
			);

			$exam->query ="
			INSERT INTO user_course_enroll_table(user_id, course_id) VALUES (:user_id, :course_id)
			";

			$exam->execute_query();

			echo 'success';
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':course_id'	=>	$_POST['course_id'],
				':user_id'		=>	$_SESSION["user_id"]
			);

			$exam->query = "
			DELETE FROM user_course_enroll_table
			WHERE user_id = :user_id AND course_id = :course_id
			";

			$exam->execute_query($exam->data);

			echo 'success';
		}
	}

	if($_POST['page'] == 'article')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM article_entry_table
			INNER JOIN tutor_table ON article_entry_table.tutor_id = tutor_table.tutor_id  
			WHERE 
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'article_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR tutor_table.tutor_full_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR tutor_table.staff_id LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY article_id ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM article_entry_table
			INNER JOIN tutor_table ON article_entry_table.tutor_id = tutor_table.tutor_id 
			"; 

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row["article_id"];
				$sub_array[] = $row["staff_id"];
				$sub_array[] = $row['tutor_full_name'];
				$sub_array[] = $row['article_title'];
				$sub_array[] = '<a href="tutor/upload/'.$row['article_file'].'" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> download</a>';
				$sub_array[] = $row['article_upload_date'];
				$data[] = $sub_array;
			}
			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);
			echo json_encode($output);	
		}
	}

	if($_POST['page'] == 'assignment')
	{
		if($_POST['action'] == 'Add')
		{
			if($exam->Verify_submission($_POST['assignment_id']))
			{
				if($_POST['assignment_type'] == 'file_upload')
				{
					$exam->filedata = $_FILES['assignment_file'];
					$assignment_file = $exam->upload_file();
					
					$exam->data = array(
						':assignment_id'				=>	$_POST['assignment_id'],
						':assignment_submission_type'	=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_submission_date'	=>	$current_datetime,
						':assignment_file'				=>	$assignment_file,
					);

					$exam->query = "
					UPDATE assignment_submission_table
					SET assignment_answer_bank = :assignment_file, assignment_submission_date = :assignment_submission_date, assignment_submission_type = :assignment_submission_type
					WHERE assignment_id = :assignment_id
					";
				
					$exam->execute_query($exam->data);

					$output = array(
						'success'	=> 'Answer Updated Successfully'
					);
				}
				else
				{
					$exam->data = array(
						':assignment_id'				=>	$_POST['assignment_id'],
						':assignment_submission_type'	=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_submission_date'	=>	$current_datetime,
						':assignment_text'				=>	$_POST['assignment_text'],
					);

					// die(var_dump($me));
					$exam->query = "
					UPDATE assignment_submission_table
					SET assignment_id = :assignment_id, assignment_answer_bank = :assignment_text, assignment_submission_date = :assignment_submission_date, assignment_submission_type = :assignment_submission_type 
					WHERE assignment_id = :assignment_id
					";

					$exam->execute_query();

					$output = array(
						'success'	=> 'Answer Updated Successfully'
					);
				}

				echo json_encode($output);
			}
			else
			{
				$exam->filedata = $_FILES['assignment_file'];
				$assignment_file = $exam->upload_file();

				if($_POST['assignment_type'] == 'file_upload')
				{
					$exam->data = array(
						':assignment_id'				=>	$_POST['assignment_id'],
						':user_id'						=>	$_SESSION['user_id'],
						':assignment_submission_type'	=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_submission_date'	=>	$current_datetime,
						':assignment_file'				=>	$assignment_file,
						':status'						=>	'Ungraded'
					);

					$exam->query = "
					INSERT INTO assignment_submission_table
					(user_id, assignment_id, assignment_answer_bank, status, assignment_submission_date, assignment_submission_type)
					VALUES (:user_id, :assignment_id, :assignment_file, :status, :assignment_submission_date, :assignment_submission_type)
					";
				
					$exam->execute_query($exam->data);

					$output = array(
						'success'	=> 'Answer Submitted Successfully'
					);
				}
				else
				{
					$exam->data = array(
						':assignment_id'				=>	$_POST['assignment_id'],
						':user_id'						=>	$_SESSION['user_id'],
						':assignment_submission_type'	=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_submission_date'	=>	$current_datetime,
						':assignment_text'				=>	$_POST['assignment_text'],
						':status'						=>	'Ungraded'
					);

					$exam->query = "
					INSERT INTO assignment_submission_table
					(user_id, assignment_id, assignment_answer_bank, status, assignment_submission_date, assignment_submission_type)
					VALUES (:user_id, :assignment_id, :assignment_text, :status, :assignment_submission_date, :assignment_submission_type)
					";

					$exam->execute_query();

					$output = array(
						'success'	=> 'Answer Submitted Successfully'
					);
				}
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'fetch_result')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM assignment_result_table
			INNER JOIN course_table ON  assignment_result_table.course_id = course_table.course_id 
			WHERE assignment_result_table.user_id = ".$_SESSION["user_id"]." AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY course_table.course_code ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM assignment_result_table
			INNER JOIN course_table ON  assignment_result_table.course_id = course_table.course_id
			WHERE user_id = ".$_SESSION["user_id"]."
			";


			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{			
				$total = $row['Assignment_1'] + $row['Assignment_2'] + $row['Assignment_3'] + $row['Assignment_4'] + $row['Assignment_5'];	
				$sub_array = array();

				$sub_array[] = $count;
				$sub_array[] = $row['course_code'];
				$sub_array[] = isset($row['Assignment_1']) ? $row['Assignment_1'] : '-';
				$sub_array[] = isset($row['Assignment_2']) ? $row['Assignment_2'] : '-';
				$sub_array[] = isset($row['Assignment_3']) ? $row['Assignment_3'] : '-';
				$sub_array[] = isset($row['Assignment_4']) ? $row['Assignment_4'] : '-';
				$sub_array[] = isset($row['Assignment_5']) ? $row['Assignment_5'] : '-';
				$sub_array[] = '<td>'.$total.'</td>';
				$sub_array[] = '<td>'.round($total/$row['count'], 2).'</td>';
				$data[] = $sub_array;

				$count++;
			}
			$output = array(
				"draw" 				=> intval($_POST["draw"]),
				"recordsTotal" 		=> $total_rows,
				"recordsFiltered" 	=> $filtered_rows,
				"data"				=> $data
			);
			echo json_encode($output);	
		}
	}

	if($_POST['page'] == 'classroom')
	{
		if($_POST['action'] == 'add_comment')
		{
			$comment_sender_username = $exam->Get_specific_data('user_table', 'user_id', $_SESSION['user_id'], 'matric_no');
			$comment_sender_name = $exam->Get_specific_data('user_table', 'user_id', $_SESSION['user_id'], 'user_name');

			$exam->data = array(
				':parent_comment_id' 		=>	$_POST['comment_id'],
				':comment_text'				=>	$_POST['comment_content'],
				':comment_sender_name'		=>	$comment_sender_name,
				':comment_sender_username'	=>	$comment_sender_username,
				':classroom_id'				=>	$_POST['classroom_id'],
				':comment_datetime'			=>	$current_datetime,
				':seen'						=> '0'
			);

			$exam->query = "
			INSERT INTO comment_table(parent_comment_id, comment_sender_name, comment_sender_username, classroom_id, comment_text, comment_datetime, seen)
			VALUES (:parent_comment_id, :comment_sender_name, :comment_sender_username, :classroom_id, :comment_text, :comment_datetime, :seen)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Comment Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'fetch_comment')
		{
			$exam->query = "
			SELECT * FROM comment_table 
			WHERE parent_comment_id = '0' AND classroom_id = '".$_POST["classroom_id"]."' ORDER BY comment_id DESC
			";

			$result = $exam->query_result();
			$output = '';

			foreach($result as $row) 
			{
				$output .= '
				<div class="card">
					<div class="card-header">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["comment_datetime"].'</i></div>
					<div class="card-body">'.$row["comment_text"].'</div>
					<div class="card-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
				</div><br />
				';

				$output .= $exam->get_reply_comment( $_POST["classroom_id"], $row['comment_id']);
			}

			echo $output;
		}

		if($_POST['action'] == 'notification')
		{
			if(isset($_POST['view']))
			{
				$exam->data = array(
				':user_id' 	=>	$_SESSION['user_id'],
				':seen'		=>	'0'
				);

				$exam->query = "
				SELECT * FROM classroom_visibility_table 
				WHERE user_id = :user_id AND seen = :seen
				";

				$total_row = $exam->total_row();

				$output = array(
					'unseen_notification'	=> $total_row
				);
				echo json_encode($output);
			}
		}
	}
}

?>