<?php

include('../master/Examination.php');

require_once('../class/class.phpmailer.php');


$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM tutor_table WHERE tutor_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'check_staffid')
		{
			$exam->query = "
			SELECT * FROM tutor_table WHERE staff_id = '".trim($_POST["staff_id"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}
	}

	if($_POST['action'] == 'register')
	{
		$tutor_verification_code = md5(rand());
		$receiver_email = $_POST['tutor_email_address'];
		$exam->filedata = $_FILES['tutor_image'];
		$tutor_image = $exam->upload_file();
		$exam->data = array(
			':staff_id'					=>	$_POST['staff_id'],
			':tutor_email_address'		=> 	$receiver_email,
			':tutor_password'			=>	password_hash($_POST['tutor_password'], PASSWORD_DEFAULT),
			':tutor_verification_code'	=>	$tutor_verification_code,
			':tutor_name'				=>	$_POST['tutor_name'],
			':tutor_gender'				=>	$_POST['tutor_gender'],
			':tutor_mobile_no'			=>	$_POST['tutor_mobile_no'],
			':tutor_image'				=>	$tutor_image,
			':tutor_created_on'			=>	$current_datetime
		);

		$exam->query = "
		INSERT INTO tutor_table(staff_id, tutor_full_name, tutor_mobile_no, tutor_gender, tutor_image, tutor_email_address, tutor_password, tutor_verification_code, tutor_created_on)
		VALUES(:staff_id, :tutor_name, :tutor_mobile_no, :tutor_gender, :tutor_image, :tutor_email_address, :tutor_password, :tutor_verification_code, :tutor_created_on)
		";

		$exam->execute_query();

		$subject = 'Online Examination Registration Verification';

		$body = '
		<p>Thank you for registering.</p>
		<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=master&code='.$tutor_verification_code.'" target="_blank"><b>link</b></a>.</p>
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

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':tutor_email_address'	=>	$_POST['tutor_email_address']
			);

			$exam->query = "
			SELECT * FROM tutor_table WHERE tutor_email_address = :tutor_email_address";

			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();
				$_SESSION['session_id'] = $_POST['session_id'];

				foreach ($result as $row) 
				{
					if($row['tutor_account_confirmation'] == 'Confirm')
					{
						if($row['email_verified'] == 'yes')
						{
							if(password_verify($_POST['tutor_password'], $row['tutor_password']))
							{
								$_SESSION['tutor_id'] = $row['tutor_id'];
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
					else
					{
						$output = array(
							'error'	=>	'Your Account is not confirmed by Administrative'
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
			$tutor_image = $_POST['hidden_tutor_image'];

			if($_FILES['tutor_image']['name'] != '')
			{
				$exam->filedata = $_FILES['tutor_image'];
				$tutor_image = $exam->upload_file();
			}

			$new = $exam->data = array(
				':tutor_full_name'	=>	$_POST['tutor_full_name'],
				':tutor_gender'		=>	$_POST['tutor_gender'],
				// ':tutor_address'	=>	$_POST['tutor_address'],
				':tutor_mobile_no'	=>	$_POST['tutor_mobile_no'],
				':tutor_image'		=>	$tutor_image,
				':tutor_id'			=>	$_SESSION['tutor_id']
			);

			$exam->query = "
			UPDATE tutor_table
			SET tutor_full_name = :tutor_full_name, tutor_gender = :tutor_gender, tutor_mobile_no = :tutor_mobile_no, tutor_image = :tutor_image
			WHERE tutor_id = :tutor_id
			";

			$exam->execute_query();
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
				':tutor_password'	=>	password_hash($_POST['tutor_password'], PASSWORD_DEFAULT),
				':tutor_id'			=>	$_SESSION['tutor_id']
			);

			$exam->query = "
			UPDATE tutor_table
			SET tutor_password = :tutor_password
			WHERE tutor_id = :tutor_id
			";

			$exam->execute_query();
			session_destroy();
			$output = array(
				'success'	=> 'Password has been change'
			);
			echo json_encode($output);
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

				$button_action = '';

				if($_SESSION['tutor_id'] == $row['tutor_id'])
				{
					$button_action = '
					<button type="button" class="btn btn-primary btn-sm edit" id="'.$row["article_id"].'"><span class="fa fa-pencil"></span> Edit</button>
					<button type="button" class="btn btn-danger btn-sm delete" id="'.$row["article_id"].'"><span class="fa fa-recycle"></span> Delete</button>
					';
				}
				else
				{
					$button_action = '';
				}

				$sub_array[] = '<a href="upload/'.$row['article_file'].'" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> download</a>';
				$sub_array[] = $row['article_upload_date'];
				$sub_array[] = $button_action;
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

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':article_id'	=>	$_POST['article_id'],
				':tutor_id'		=>	$_SESSION["tutor_id"]
			);

			$exam->query = "
			DELETE FROM article_entry_table
			WHERE article_id = :article_id AND tutor_id = :tutor_id
			";

			$exam->execute_query();

			echo 'success';
		}
	}

	if($_POST['page'] == 'assignment')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM assignment_table
			INNER JOIN course_table ON assignment_table.course_id = course_table.course_id 
			WHERE tutor_id = '".$_SESSION['tutor_id']."' AND session_id = '".$_SESSION['session_id']."' AND (
			"; 

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR assignment_num LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR assignment_format LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR assignment_deadline LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY assignment_deadline ASC ';
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
			SELECT * FROM assignment_table
			INNER JOIN course_table ON assignment_table.course_id = course_table.course_id 
			WHERE tutor_id = ".$_SESSION['tutor_id']." AND session_id = ".$_SESSION['session_id']."
			"; 

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row["course_code"] . '-' . $row["course_name"];
				$sub_array[] = str_replace('_', ' ', $row["assignment_num"]);
				$sub_array[] = $row['assignment_deadline'];
				$sub_array[] = strtoupper($row['assignment_format']);

				$button_action = '';

				if($exam->Time_expire('assignment_table', 'assignment_id', $row['assignment_id'], 'assignment_deadline'))
				{
					$button_action = '
					<button type="button" class="btn btn-primary btn-sm edit" id="'.$row["assignment_id"].'"><span class="fa fa-pencil"></span>Edit</button>
					<button type="button" class="btn btn-danger btn-sm delete" id="'.$row["assignment_id"].'"><span class="fa fa-recycle"></span> Delete</button>';
				}
				else
				{
					$button_action = '<span class="badge badge-success">Assignment Completed</span>';
				}

				$sub_array[] = '<button type="button" class="btn btn-info btn-sm view" id="'.$row["assignment_id"].'"><span class="fa fa-search"></span> View Assignment</button>';
				$sub_array[] = $button_action;
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

		if($_POST['action'] == 'view')
		{
			$exam->query = "SELECT * FROM assignment_table 
			INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
			WHERE assignment_id = '".$_POST['assignment_id']."'";
			$result = $exam->query_result();

			$output = '';

			foreach($result as $row) 
			{
				$assignment_num = str_replace('_', ' ', $row["assignment_num"]);
				$is_assignment_type = '';

				if($row['assignment_type'] == 'file_upload')
				{
					$is_assignment_type = '<a href="assignment_file/'.$row['assignment_bank'].'" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> download</a>';
				}
				else
				{
					$is_assignment_type = $row['assignment_bank'];
				}

				$output .= '
				<div class="row">
					<div class="col-md-12">
						<div>'.$is_assignment_type.'</div>
						<hr style="background-color:black;"/>
						<br />
						<table class="table table-bordered">
							<tr>
								<th><h3><strong>Score</strong></h3></th>
								<td style="color:green;"><h2>'.$row["assignment_score"].'</h2></td>
							</tr>
							<tr>
								<th>Course</th>
								<td>'.$row["course_code"].' - '.$row["course_name"].'</td>
							</tr>
							<tr>
								<th>Assignment Number</th>
								<td>'.$assignment_num.'</td>
							</tr>
							<tr>
								<th>Deadline</th>
								<td>'.$row["assignment_deadline"].'</td>
							</tr>
						</table>
					</div>
				</div>
				';
			}

			echo $output;
		}

		if($_POST['action'] == 'Add')
		{
			if($exam->Verify_assignment_num($_SESSION['tutor_id'], $_POST['course_id'], $_POST['assignment_num']))
			{
				$exam->filedata = $_FILES['assignment_file'];
				$assignment_file = $exam->upload_file();

				if($_POST['assignment_type'] == 'file_upload')
				{
					$exam->data = array(
						':tutor_id'					=>	$_SESSION['tutor_id'],
						':session_id'				=>	$_SESSION['session_id'],
						':course_id'				=>	$_POST['course_id'],
						':assignment_type'			=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_score'			=>	$_POST['assignment_score'],
						':assignment_deadline'		=>	$_POST['assignment_deadline'],
						':assignment_file'			=>	$assignment_file,
						':assignment_format'		=>	$exam->clean_data($_POST['assignment_format']),
						':assignment_num'			=>	$_POST['assignment_num'],
						':assignment_code'			=>	md5(rand())
					);

					if($_POST['assignment_format'] == 'group')
					{
						if($_POST['group_id'] == 'All')
						{
							$exam->query = "SELECT group_table.group_id, group_table.group_name FROM group_member_table
							INNER JOIN group_table ON group_member_table.group_id = group_table.group_id
							WHERE course_id = ".$_POST['course_id']." AND session_id = ".$_SESSION['session_id']."
							GROUP BY group_id ASC
							";

							$result = $exam->query_result();

							foreach($result as $row) 
							{
								$exam->query = "
								INSERT INTO assignment_table
								(tutor_id, course_id, group_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
								VALUES (:tutor_id, :course_id, ".$row['group_id'].", :assignment_num, :assignment_file, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
								";
							
								$exam->execute_query($exam->data);
							}
							$output = array(
								'success'	=> 'Question Details Added'
							);
						}
						else
						{
							$group_id = $_POST['group_id'];

							$exam->query = "
							INSERT INTO assignment_table
							(tutor_id, course_id, group_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
							VALUES (:tutor_id, :course_id, $group_id, :assignment_num, :assignment_file, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
							";
						
							$exam->execute_query($exam->data);

							$output = array(
								'success'	=> 'Question Details Added'
							);
						}
					}

					if($_POST['assignment_format'] == 'individual')
					{
						$exam->query = "
						INSERT INTO assignment_table
						(tutor_id, course_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
						VALUES (:tutor_id, :course_id, :assignment_num, :assignment_file, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
						";
					
						$exam->execute_query($exam->data);

						$output = array(
							'success'	=> 'Question Details Added'
						);
					}
				}
				else
				{
					$exam->data = array(
						':tutor_id'					=>	$_SESSION['tutor_id'],
						':session_id'				=>	$_SESSION['session_id'],
						':course_id'				=>	$_POST['course_id'],
						':assignment_type'			=> 	$exam->clean_data($_POST['assignment_type']),
						':assignment_score'			=>	$_POST['assignment_score'],
						':assignment_deadline'		=>	$_POST['assignment_deadline'],
						':assignment_text'			=>	$_POST['assignment_text'],
						':assignment_format'		=>	$exam->clean_data($_POST['assignment_format']),
						':assignment_num'			=>	$_POST['assignment_num'],
						':assignment_code'			=>	md5(rand())
					);

					if($_POST['assignment_format'] == 'group')
					{
						if($_POST['group_id'] == 'All')
						{
							$exam->query = "SELECT group_table.group_id, group_table.group_name FROM group_member_table
							INNER JOIN group_table ON group_member_table.group_id = group_table.group_id
							WHERE course_id = ".$_POST['course_id']." AND session_id = ".$_SESSION['session_id']."
							GROUP BY group_id ASC
							";
							$result = $exam->query_result();

							foreach($result as $row) 
							{
								$exam->query = "
								INSERT INTO assignment_table
								(tutor_id, course_id, group_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
								VALUES (:tutor_id, :course_id, ".$row['group_id'].", :assignment_num, :assignment_text, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
								";
							
								$exam->execute_query($exam->data);
							}
							$output = array(
								'success'	=> 'Question Details Added'
							);
						}
						else
						{
							$group_id = $_POST['group_id'];
							
							$exam->query = "
							INSERT INTO assignment_table
							(tutor_id, course_id, group_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
							VALUES (:tutor_id, :course_id, $group_id, :assignment_num, :assignment_text, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
							";
						
							$exam->execute_query($exam->data);

							$output = array(
								'success'	=> 'Question Details Added'
							);
						}
					}

					if($_POST['assignment_format'] == 'individual')
					{
						$exam->query = "
						INSERT INTO assignment_table
						(tutor_id, course_id, assignment_num, assignment_bank, assignment_score, assignment_deadline, assignment_format, assignment_type, assignment_code, session_id)
						VALUES (:tutor_id, :course_id, :assignment_num, :assignment_text, :assignment_score, :assignment_deadline, :assignment_format, :assignment_type, :assignment_code, :session_id)
						";
					
						$exam->execute_query($exam->data);

						$output = array(
							'success'	=> 'Question Details Added'
						);
					}
				}

				echo json_encode($output);
			}
			else
			{
				$output = array(
					'error'	=> 'Assignment Number Exist!'
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'edit_fetch')
		{
			if($_POST['action'] == 'edit_fetch')
			{
				$exam->query = "
				SELECT * FROM assignment_table
				WHERE assignment_id = '".$_POST["assignment_id"]."'
				";

				$result = $exam->query_result();

				foreach($result as $row)
				{
					$output['assignment_type'] 		= 	$row['assignment_type'];
					$output['assignment_bank'] 		= 	$row['assignment_bank'];
					$output['assignment_score'] 	= 	$row['assignment_score'];
					$output['assignment_deadline'] 	= 	$row['assignment_deadline'];
					$output['assignment_format']	=	$row['assignment_format'];
					$output['assignment_num']		=	$row['assignment_num'];
					$output['course_id']			=	$row['course_id'];
					$output['group_id']				=	$row['group_id'];
				}

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'edit')
		{
			if($_POST['assignment_type'] == 'file_upload')
			{
				$assignment_file = $_POST['hidden_assignment_file'];

				if($_FILES['assignment_file']['name'] != '')
				{
					$exam->filedata = $_FILES['assignment_file'];
					$assignment_file = $exam->upload_file();
				}

				$exam->data = array(
					':assignment_id'			=>	$_POST['assignment_id'],
					':course_id'				=>	$_POST['course_id'],
					':assignment_type'			=> 	$exam->clean_data($_POST['assignment_type']),
					':assignment_score'			=>	$_POST['assignment_score'],
					':assignment_deadline'		=>	$_POST['assignment_deadline'],
					':assignment_file'			=>	$assignment_file,
					':assignment_format'		=>	$exam->clean_data($_POST['assignment_format']),
					':assignment_num'			=>	$_POST['assignment_num']
				);

				$exam->query = "UPDATE assignment_table
				SET course_id = :course_id, assignment_num = :assignment_num, assignment_bank = :assignment_file, assignment_score = :assignment_score, assignment_deadline = :assignment_deadline, assignment_format = :assignment_format, assignment_type = :assignment_type
				WHERE assignment_id = :assignment_id
				";

				$exam->execute_query($exam->data);
				$output = array(
					'success'	=>	'Assignment Details Edit'
				);
				echo json_encode($output);
			}

			if($_POST['assignment_type'] == 'text_input')
			{
				$exam->data = array(
					':assignment_id'			=>	$_POST['assignment_id'],
					':course_id'				=>	$_POST['course_id'],
					':assignment_type'			=> 	$exam->clean_data($_POST['assignment_type']),
					':assignment_score'			=>	$_POST['assignment_score'],
					':assignment_deadline'		=>	$_POST['assignment_deadline'],
					':assignment_text'			=>	$_POST['assignment_text'],
					':assignment_format'		=>	$exam->clean_data($_POST['assignment_format']),
					':assignment_num'			=>	$_POST['assignment_num']
				);

				$exam->query = "UPDATE assignment_table
				SET course_id = :course_id, assignment_num = :assignment_num, assignment_bank = :assignment_text, assignment_score = :assignment_score, assignment_deadline = :assignment_deadline, assignment_format = :assignment_format, assignment_type = :assignment_type
				WHERE assignment_id = :assignment_id
				";

				$exam->execute_query();
				$output = array(
					'success'	=>	'Assignment Details Edit'
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':assignment_id'	=>	$_POST['assignment_id'],
				':tutor_id'			=>	$_SESSION["tutor_id"]
			);

			$exam->query = "
			DELETE FROM assignment_table
			WHERE assignment_id = :assignment_id AND tutor_id = :tutor_id
			";

			$exam->execute_query();

			echo 'success';
		}

		if($_POST['action'] == 'fetch_result')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM assignment_result_table
			INNER JOIN course_table ON  assignment_result_table.course_id = course_table.course_id 
			INNER JOIN user_table ON assignment_result_table.user_id = user_table.user_id
			WHERE assignment_result_table.tutor_id = ".$_SESSION["tutor_id"]." AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.matric_no LIKE "%'.$_POST["search"]["value"].'%" ';
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
			INNER JOIN user_table ON assignment_result_table.user_id = user_table.user_id
			WHERE tutor_id = ".$_SESSION["tutor_id"]."
			";


			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{			
				$total = $row['Assignment_1'] + $row['Assignment_2'] + $row['Assignment_3'] + $row['Assignment_4'] + $row['Assignment_5'];	
				$sub_array = array();

				$sub_array[] = $count;
				$sub_array[] = $row["matric_no"];
				$sub_array[] = $row['course_code'];
				$sub_array[] = '<div contenteditable class="update" data-id="'.$row["assignment_result_id"].'" data-column="Assignment_1">' . $row['Assignment_1'] . '</div>';

				$sub_array[] = '<div contenteditable class="update" data-id="'.$row["assignment_result_id"].'" data-column="Assignment_2">' . $row['Assignment_2'] . '</div>';
				$sub_array[] = '<div contenteditable class="update" data-id="'.$row["assignment_result_id"].'" data-column="Assignment_3">' . $row['Assignment_3'] . '</div>';
				$sub_array[] = '<div contenteditable class="update" data-id="'.$row["assignment_result_id"].'" data-column="Assignment_4">' . $row['Assignment_4'] . '</div>';
				$sub_array[] = '<div contenteditable class="update" data-id="'.$row["assignment_result_id"].'" data-column="Assignment_5">' . $row['Assignment_5'] . '</div>';
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

		if($_POST['action'] == 'update_result')
		{
			$exam->data = array(
				':assignment_result_id'		=>	$_POST['assignment_result_id'],
				':value'					=>	$_POST['value']
			);

			$exam->query = "UPDATE assignment_result_table SET ".$_POST['column_name']." = :value
			WHERE assignment_result_id = :assignment_result_id
			";

			$exam->execute_query();
			$output = array(
				'success'	=>	'Assignment Details Edit'
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'get_group')
		{
			$exam->query = "SELECT group_table.group_id, group_table.group_name FROM group_member_table
			INNER JOIN group_table ON group_member_table.group_id = group_table.group_id
			WHERE course_id = ".$_POST['course_id']." AND session_id = ".$_SESSION['session_id']."
			GROUP BY group_id ASC
			";

			$result = $exam->query_result();

			$output = '<option value="All" selected="selected">All</option>';

			foreach($result as $row)
			{
				$output .= '<option value="'.$row["group_id"].'">'.$row["group_name"].'</option>';
			}
			echo $output;
		}
	}

	if($_POST['page'] == 'grading')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM assignment_submission_table
			INNER JOIN assignment_table ON  assignment_submission_table.assignment_id = assignment_table.assignment_id
			INNER JOIN course_table ON assignment_table.course_id = course_table.course_id  
			INNER JOIN user_table ON assignment_submission_table.user_id = user_table.user_id
			WHERE assignment_table.tutor_id = ".$_SESSION["tutor_id"]." 
			AND assignment_table.session_id = ".$_SESSION['session_id']." AND status = 'Ungraded' AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.matric_no LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR assignment_submission_date LIKE "%'.$_POST["search"]["value"].'%" ';
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
			SELECT * FROM assignment_submission_table
			INNER JOIN assignment_table ON  assignment_submission_table.assignment_id = assignment_table.assignment_id
			INNER JOIN course_table ON assignment_table.course_id = course_table.course_id  
			INNER JOIN user_table ON assignment_submission_table.user_id = user_table.user_id
			WHERE assignment_table.tutor_id = ".$_SESSION["tutor_id"]."
			AND assignment_table.session_id = ".$_SESSION['session_id']." 
			";


			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{				
				$sub_array = array();

				$sub_array[] = $count;
				$sub_array[] = $row["matric_no"];
				$sub_array[] = $row['user_name'];
				$sub_array[] = str_replace('_', ' ', $row['assignment_num']);
				$sub_array[] = strtoupper($row['assignment_format']);
				$sub_array[] = $row['course_code'] . '-' . $row['course_name'];
				$sub_array[] = $row['assignment_submission_date'];
				$sub_array[] = '<a href="grading_module.php?id='.$row['assignment_submission_id'].'" class="btn btn-primary btn-sm grade">'.$row['status'].'</a>';
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

		if($_POST['action'] == 'Add')
		{
			if($_POST['assignment_format'] == 'individual')
			{
				if(!empty($exam->Get_count($_POST['user_id'], $_POST['course_id'])))
				{
					$count = $exam->Get_count($_POST['user_id'], $_POST['course_id']) + 1;
				}
				else
				{
					$count = 1;
				}

				$exam->data = array(
					':course_id'		=>	$_POST['course_id'],
					':mark_award'		=>	intval($_POST['mark_award']),
					':count'			=>	$count
				);

				if($exam->User_verification_result($_POST['user_id'], $_POST['course_id']))
				{
					if($exam->Get_assignment_grade($_POST['assignment_submission_id']))
					{		
						if($exam->Get_assignment_score($_POST['assignment_id'], $_POST['mark_award']))
						{		
							$exam->query = "
							UPDATE assignment_result_table SET ".$_POST["assignment_num"]." = :mark_award, count = :count
							WHERE user_id = ".$_POST['user_id']." AND course_id = :course_id
							";

							// die(var_dump($me));
							$exam->execute_query();

							$exam->query = "
							UPDATE assignment_submission_table SET status = 'Graded' WHERE assignment_submission_id = '".$_POST['assignment_submission_id']."';
							";
						
							$exam->execute_query();

							$output = array(
								'success'	=> 'Score Awarded Successfully'
							);
						}
						else
						{
							$output = array(
								'error'	=> 'Score Awarded is Greater than Expected Score'
							);
						}

						echo json_encode($output);
					}
					else
					{
						header("location: grading.php");
					}
				}
				else
				{
					if($exam->Get_assignment_grade($_POST['assignment_submission_id']))
					{		
						if($exam->Get_assignment_score($_POST['assignment_id'], $_POST['mark_award']))
						{		
							$exam->query = "
							INSERT INTO assignment_result_table(user_id, course_id, ".$_POST["assignment_num"].", tutor_id, count, session_id)
							VALUES (".$_POST['user_id'].", :course_id, :mark_award, ".$_SESSION["tutor_id"].", :count, ".$_SESSION['session_id'].")
							";
							$exam->execute_query();

							$exam->query = "
							UPDATE assignment_submission_table SET status = 'Graded' WHERE assignment_submission_id = '".$_POST['assignment_submission_id']."';
							";
						
							$exam->execute_query();

							$output = array(
								'success'	=> 'Score Awarded Successfully'
							);
						}
						else
						{
							$output = array(
								'error'	=> 'Score Awarded is Greater than Expected Score'
							);
						}

						echo json_encode($output);
					}
					else
					{
						header("location: grading.php");
					}
				}
			}

			if($_POST['assignment_format'] == 'group')
			{
				$exam->data = array(
					':course_id'		=>	$_POST['course_id'],
					':mark_award'		=>	intval($_POST['mark_award']),
				);

				$exam->query = "SELECT user_id FROM group_member_table 
				WHERE group_id = ".$_POST['group_id']." AND course_id = ".$_POST['course_id']."
				AND session_id = ".$_SESSION['session_id']."
				";

				$result = $exam->query_result();
				
				foreach ($result as $row) 
				{
					$exam->query = "SELECT count FROM assignment_result_table 
					WHERE user_id = '".$row['user_id']."' AND course_id = '".$_POST['course_id']."'
					";

					$count_result = $exam->query_result();

					foreach($count_result as $count_row) 
					{
						$count = $count_row['count'] + 1;

						if($exam->User_verification_result($row['user_id'], $_POST['course_id']))
						{
							if($exam->Get_assignment_score($_POST['assignment_id'], $_POST['mark_award']))
							{		
								$exam->query = "
								UPDATE assignment_result_table SET ".$_POST["assignment_num"]." = :mark_award, count = ".$count."
								WHERE user_id = ".$row['user_id']." AND course_id = :course_id
								";

								$exam->execute_query();

								$exam->query = "
								UPDATE assignment_submission_table SET status = 'Graded' WHERE assignment_submission_id = '".$_POST['assignment_submission_id']."';
								";
							
								$exam->execute_query();

								$output = array(
									'success'	=> 'Score Awarded Successfully'
								);
							}
							else
							{
								$output = array(
									'error'	=> 'Score Awarded is Greater than Expected Score'
								);
							}
						}
						else
						{
							if($exam->Get_assignment_score($_POST['assignment_id'], $_POST['mark_award']))
							{		
								$exam->query = "
								INSERT INTO assignment_result_table(user_id, course_id, ".$_POST["assignment_num"].", tutor_id, count, session_id)
								VALUES (".$row['user_id'].", :course_id, :mark_award, ".$_SESSION["tutor_id"].",  ".$count.", ".$_SESSION['session_id'].")
								";
								$exam->execute_query();

								$exam->query = "
								UPDATE assignment_submission_table SET status = 'Graded' WHERE assignment_submission_id = '".$_POST['assignment_submission_id']."';
								";
							
								$exam->execute_query();

								$output = array(
									'success'	=> 'Score Awarded Successfully'
								);
							}
							else
							{
								$output = array(
									'error'	=> 'Score Awarded is Greater than Expected Score'
								);
							}
						}
					}
				}
				echo json_encode($output);				
			}
		}
	}

	if($_POST['page'] == 'classroom')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM classroom_table
			INNER JOIN course_table ON classroom_table.course_id = course_table.course_id 
			WHERE tutor_id = '".$_SESSION['tutor_id']."' AND session_id = '".$_SESSION['session_id']."' AND (
			"; 

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR classroom_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR classroom_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY classroom_created_on ASC ';
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
			SELECT * FROM assignment_table
			INNER JOIN course_table ON classroom_table.course_id = course_table.course_id 
			WHERE tutor_id = ".$_SESSION['tutor_id']." AND session_id = ".$_SESSION['session_id']."
			"; 

			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $count;
				$sub_array[] = $row["course_code"] . '-' . $row["course_name"];
				$sub_array[] = $row["classroom_title"];

				$is_classroom_file= '';
				$button_action = '';

				if($row['classroom_file'] == 'Unavailable')
				{
					$is_classroom_file = '<span class="badge badge-danger">No file uploded</span>';
				}
				else
				{
					$is_classroom_file = '
					<a href="assignment_file/'.$row['classroom_file'].'" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> download</a>
					';
				}

				$sub_array[] = $is_classroom_file;
				$sub_array[] = $row['classroom_created_on'];

				if($exam->Time_expire('classroom_table', 'classroom_id', $row['classroom_id'], 'to_datetime'))
				{
					$button_action = '
					<button type="button" class="btn btn-primary btn-sm edit" id="'.$row["classroom_id"].'"><span class="fa fa-pencil"></span>Edit</button>
					<button type="button" class="btn btn-danger btn-sm delete" id="'.$row["classroom_id"].'"><span class="fa fa-recycle"></span> Delete</button>';
				}
				else
				{
					$button_action = '<span class="badge badge-success">Lecture Completed</span>';
				}

				$sub_array[] = $button_action;
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

		if($_POST['action'] == 'Add')
		{
			if(!empty($_FILES['classroom_file']['name']))
			{
				$exam->filedata = $_FILES['classroom_file'];
				$classroom_file = $exam->upload_file();
			}
			else
			{
				$classroom_file = 'Unavailable';
			}

			$exam->data = array(
				':tutor_id'					=>	$_SESSION['tutor_id'],
				':session_id'				=>	$_SESSION['session_id'],
				':course_id'				=>	$_POST['course_id'],
				':classroom_title'			=> 	$exam->clean_data($_POST['classroom_title']),
				':classroom_description'	=>	$_POST['classroom_description'],
				':classroom_file'			=>	$classroom_file,
				':classroom_code'			=>	md5(rand()),
				':from_datetime'			=>	$_POST['from_datetime'],
				':to_datetime'				=>	$_POST['to_datetime'],
				':classroom_created_on'		=>	$current_datetime
			);

			// die(var_dump($me));
			$exam->query = "
			INSERT INTO classroom_table(tutor_id, course_id, classroom_title, classroom_description, classroom_file, classroom_code, session_id, from_datetime, to_datetime, classroom_created_on)
			VALUES (:tutor_id, :course_id, :classroom_title, :classroom_description, :classroom_file, :classroom_code, :session_id, :from_datetime, :to_datetime, :classroom_created_on)
			";
		
			$classroom_id = $exam->execute_question_with_last_id();

			$output = $exam->Get_user_data($_POST['course_id'], $classroom_id);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch')
		{
			
			$exam->query = "
			SELECT * FROM classroom_table
			WHERE classroom_id = '".$_POST["classroom_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['classroom_title'] 			= 	$row['classroom_title'];
				$output['classroom_description'] 	= 	$row['classroom_description'];
				$output['classroom_file'] 			= 	$row['classroom_file'];
				$output['course_id']				=	$row['course_id'];
				$output['classroom_id'] 			= 	$row['classroom_id'];
				$output['from_datetime'] 			= 	$row['from_datetime'];
				$output['to_datetime'] 				= 	$row['to_datetime'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			if(!empty($_FILES['classroom_file']['name']))
			{
				$exam->filedata = $_FILES['classroom_file'];
				$classroom_file = $exam->upload_file();
			}
			else
			{
				$classroom_file = $_POST['hidden_classroom_file'];
			}

			$exam->data = array(
				':classroom_id'				=>	$_POST['classroom_id'],
				':classroom_title'			=> 	$exam->clean_data($_POST['classroom_title']),
				':classroom_description'	=>	$_POST['classroom_description'],
				':classroom_file'			=>	$classroom_file,
				':from_datetime'			=>	$_POST['from_datetime'],
				':to_datetime'				=>	$_POST['to_datetime'],
			);

			$exam->query = "
			UPDATE classroom_table 
			SET classroom_title = :classroom_title, classroom_description = :classroom_description, classroom_file = :classroom_file, from_datetime = :from_datetime, to_datetime = :to_datetime
			WHERE classroom_id = :classroom_id
			";
		
			$exam->execute_query($exam->data);

			$output = array(
				'success'	=> 'Lecture Details Edited'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':classroom_id'	=>	$_POST['classroom_id']
			);

			$exam->query = "
			DELETE FROM classroom_table
			WHERE classroom_id = :classroom_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=> 'classroom Details has been removed'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'add_comment')
		{
			$comment_sender_username = $exam->Get_specific_data('tutor_table', 'tutor_id', $_SESSION['tutor_id'], 'staff_id');
			$comment_sender_name = $exam->Get_specific_data('tutor_table', 'tutor_id', $_SESSION['tutor_id'], 'tutor_full_name');

			$exam->data = array(
				':parent_comment_id' 		=>	$_POST['comment_id'],
				':comment_text'				=>	$_POST['comment_content'],
				':comment_sender_name'		=>	$comment_sender_name,
				':comment_sender_username'	=>	$comment_sender_username,
				':classroom_id'				=>	$_POST['classroom_id'],
				':comment_datetime'			=>	$current_datetime,
				':seen'						=> '1'
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
				':seen'		=>	'0'
				);

				$exam->query = "
				SELECT * FROM comment_table WHERE  seen = :seen
				";

				$total_row = $exam->total_row();

				$output = array(
					'unseen_notification'	=> $total_row
				);
				echo json_encode($output);
			}
		}
	}

	if($_POST['page'] == 'exam_result')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM online_exam_table
			INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
			INNER JOIN course_assign_table ON course_assign_table.course_id = course_table.course_id
			WHERE course_assign_table.tutor_id = '".$_SESSION["tutor_id"]."' 
			AND session_id = '".$_SESSION['session_id']."' AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_status LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM online_exam_table
			INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
			INNER JOIN course_assign_table ON course_assign_table.course_id = course_table.course_id
			WHERE course_assign_table.tutor_id = '".$_SESSION["tutor_id"]."' 
			AND session_id = '".$_SESSION['session_id']."' 
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row['course_code'] . '-' . html_entity_decode($row['course_name']);
				$sub_array[] = $row['online_exam_datetime'];
				
				$status = '';

				$result_button = '';

				if($row['online_exam_status'] == 'Pending')
				{
					$status = '<span class="badge badge-warning">Pending</span>';
				}

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
				$sub_array[] = '<a href="exam_result.php?code='.$row["online_exam_code"].'" class="btn btn-dark btn-sm">Result</a>';
				$sub_array[] = '<a href="exam_enroll.php?code='.$row['online_exam_code'].'" class="btn btn-secondary btn-sm">Enroll</a>';

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

		if($_POST['action'] == 'fetch_result')
		{
			$output = array();

			$exam_id = $exam->Get_examination_id($_POST["code"]);
			
			$exam->query = "
			SELECT course_table.course_code, course_table.course_name, user_table.user_id, user_exam_question_answer.exam_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark FROM user_exam_question_answer
			INNER JOIN user_table ON user_table.user_id = user_exam_question_answer.user_id
			INNER JOIN online_exam_table ON user_exam_question_answer.exam_id = online_exam_table.online_exam_id
			INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
			WHERE exam_id = ".$exam_id."
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY total_mark DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT course_table.course_code, course_table.course_name, user_table.user_id, user_exam_question_answer.exam_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark FROM user_exam_question_answer
			INNER JOIN user_table ON user_table.user_id = user_exam_question_answer.user_id
			INNER JOIN online_exam_table ON user_exam_question_answer.exam_id = online_exam_table.online_exam_id
			INNER JOIN course_table ON online_exam_table.course_id = course_table.course_id
			WHERE exam_id = ".$exam_id."
			GROUP BY user_exam_question_answer.user_id
			ORDER BY total_mark DESC
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row['user_name'];
				$sub_array[] = $row['course_code'] . '-' . $row['course_name'];
				$sub_array[] = $exam->Get_user_exam_status($exam_id, $row["user_id"]);
				$sub_array[] = $row['total_mark'];

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

	if($_POST['page'] == 'exam_enroll')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();
			$exam_id = $exam->Get_examination_id($_POST['code']);

			$exam->query = "
			SELECT * FROM user_exam_enroll_table
			INNER JOIN user_table
			ON user_table.user_id = user_exam_enroll_table.user_id
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."'
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR user_table.user_gender LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR user_table.user_mobile_no LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR user_table.user_email_verified LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ') ';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY user_exam_enroll_table.user_exam_enroll_id ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_exam_enroll_table
			INNER JOIN user_table
			ON user_table.user_id = user_exam_enroll_table.user_id
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = "<img src='../upload/".$row["user_image"]."' class='img-thumbnail' width='75' />";
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_gender"];
				$sub_array[] = $row["user_mobile_no"];
				$is_email_verified = '';

				if($row['user_email_verified'] == 'yes')
				{
					$is_email_verified = '<label class="badge badge-success">Yes</label>
					';
				}
				else
				{
					$is_email_verified = '<label class="badge badge-danger">No</label>
					';
				}
				$sub_array[] = $is_email_verified;
				$result = '';

				if($exam->Get_exam_status($exam_id) == 'Completed')
				{
					$result = '<a href="user_exam_result.php?code='.$_POST['code'].'&id='.$row['user_id'].'" class="btn btn-info btn-sm" target="_blank">Result</a>';
				}
				$sub_array[] = $result;

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

	if($_POST['page'] == 'group')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM group_member_table
			INNER JOIN course_table ON group_member_table.course_id = course_table.course_id
			INNER jOIN group_table ON group_member_table.group_id = group_table.group_id
			WHERE group_member_table.course_id = ".$_POST['course_id']."
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ') ';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'GROUP BY group_member_table.group_id ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM group_member_table
			INNER JOIN course_table ON group_member_table.course_id = course_table.course_id
			INNER jOIN group_table ON group_member_table.group_id = group_table.group_id
			WHERE  group_member_table.course_id = ".$_POST['course_id']."
			";

			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $count;
				$sub_array[] = $row["course_code"].' - '.$row["course_name"];
				$sub_array[] = $row["group_name"];
				$sub_array[] = '<button type="button" class="btn btn-primary btn-sm view" id="'.$row["group_id"].'" data-course_id="'.$row["course_id"].'"><span class="fa fa-search"></span> View Groups</button>';
				$sub_array[] = '<button type="button" class="btn btn-danger btn-sm delete" id="'.$row["group_id"].'" data-course_id="'.$row["course_id"].'"><span class="fa fa-recycle"> Delete</span></button>';
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

		if($_POST['action'] == 'fetch_group')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM group_member_table
			INNER JOIN course_table ON group_member_table.course_id = course_table.course_id
			INNER jOIN course_assign_table ON group_member_table.course_id = course_assign_table.course_id
			WHERE course_assign_table.tutor_id = '".$_SESSION['tutor_id']."' 
			AND session_id = '".$_SESSION['session_id']."' AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'course_table.course_code LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ') ';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'GROUP BY course_table.course_code ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM group_member_table
			INNER JOIN course_table ON group_member_table.course_id = course_table.course_id
			INNER jOIN course_assign_table ON group_member_table.course_id = course_assign_table.course_id
			WHERE course_assign_table.tutor_id = '".$_SESSION['tutor_id']."' 
			AND session_id = '".$_SESSION['session_id']."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $count;
				$sub_array[] = $row["course_code"];
				$sub_array[] =  $row["course_name"];
				$sub_array[] = '<button type="button" class="btn btn-primary btn-sm view_member" id="'.$row["course_id"].'"><span class="fa fa-search"></span> View Group</button>';
				// $sub_array[] = '<button type="button" class="btn btn-danger btn-sm delete" id="'.$row["group_id"].'"><span class="fa fa-recycle"> Delete</span></button>';
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

		if($_POST['action'] == 'get_user')
		{
			$exam->query = "SELECT * FROM user_course_enroll_table 
			INNER JOIN user_table ON user_course_enroll_table.user_id = user_table.user_id
			WHERE  user_course_enroll_table.course_id = ".$_POST['query']."";
			
			$result = $exam->query_result();

			$output = '';

			foreach ($result as $row) 
			{
				$output .= '<option value="'.$row["user_id"].'">'.$row['user_name'].'</option>';
			}
			echo $output;
		}

		if($_POST['action'] == 'Add')
		{
			$error_user = '';
			$error = 0;

			if(empty($_POST["user_id"]))
			{
				$error_user = 'Student is required';
				$error++;
			}
			else
			{
				$user = array_map('intval', $_POST["user_id"]);

				foreach($user as $row)
				{
					$exam->query = "SELECT * FROM group_member_table WHERE user_id = $row 
					AND course_id = ".$_POST['course_id']." AND session_id = ".$_SESSION['session_id']." 
					AND group_id = ".$_POST['group_id']."";

					if($exam->total_row() > 0)
					{
						$error_user = 'Student is already assigned';
						$error++;
					}
					else
					{

						$exam->data = array(
							':group_id' 	=>	$_POST['group_id'],
							':course_id'	=>	$_POST['course_id'],
							':session_id'	=>	$_SESSION['session_id']
						);

						// die(var_dump($value, $teacher_id));
						$exam->query = "
						INSERT INTO group_member_table(group_id, course_id, user_id, session_id) 
						VALUES (:group_id, :course_id, $row, :session_id)
						";

						$exam->execute_query();

						$output = array(
							'success' 	=> 'Group assigned successfully', 
						);
					}
				}
			}

			if($error > 0)
			{
				$output = array(
					'error'			=> true,
					'error_user'	=> $error_user
				);
			}
			echo json_encode($output);
		}

		if($_POST['action'] == 'view')
		{
			$exam->query = "
			SELECT * FROM group_member_table
			INNER JOIN course_table ON group_member_table.course_id = course_table.course_id
			INNER JOIN user_table ON group_member_table.user_id = user_table.user_id
			WHERE group_member_table.group_id = '".$_POST['group_id']."' 
			AND group_member_table.session_id = ".$_SESSION['session_id']." 
			AND group_member_table.course_id = ".$_POST['course_id']."
			";

			$result = $exam->query_result();
			
			$output = '';

			foreach($result as $row) 
			{
				
				$output .= '
		        <div class="row">
					<div class="col-md-7 col-sm-offset-2">
			            <div class="form-group">
			                <label><h6>'.$row["user_name"].'</h6></label>
			            </div>
			        </div>
			        <div class="col-md-3">
			             <div class="form-group">
			                <label><h6>'.$row["matric_no"].'</h6></label>
			            </div>
			        </div>
			        <div class="col-md-2 .result">
			             <div class="form-group">
			                <button type="button" name="delete_member" class="btn btn-danger btn-xs delete_member" id="'.$row["group_member_id"].'"><span class="glyphicon glyphicon-trash"></span> Delete</button>
			            </div>
			        </div>
		        </div>
		        ';
			}
			echo $output;
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':group_id'			=>	$_POST['group_id']
			);

			$exam->query = "
			DELETE FROM group_member_table
			WHERE group_id = :group_id AND course_id = ".$_POST['course_id']." AND session_id = ".$_SESSION['session_id']."
			";

			$exam->execute_query($exam->data);

			echo 'success';
		}

		if($_POST['action'] == 'delete_member')
		{
			$exam->query = "
			DELETE FROM group_member_table
			WHERE group_member_id = ".$_POST['group_member_id']."
			";

			$exam->execute_query($exam->data);

			echo 'success';
		}

		if($_POST['action'] == 'auto_group')
		{
			$per_group = $_POST['per_group'];

			$exam->query = "SELECT user_id FROM user_course_enroll_table WHERE course_id = ".$_POST['auto_course_id']."";
			$result = $exam->query_result();
			$total_user = $exam->total_row();

			$exam->query = "SELECT * FROM group_table";
			$total_group = $exam->total_row();
			
			$group_id = 1;
			$count = 0;

			$number_per_group = $per_group;

			$iterate = ceil($total_user / $per_group);
			$user_number = $iterate * $per_group;

			if($per_group < $total_user)
			{
				if($iterate > $total_group)
				{
					$output = array(
						'error' 	=> 'Number Exceed Group Available'
					);
				}
				else
				{
				  	while($per_group <= $user_number)
				  	{
					    for($count = $count; $count < $per_group; $count++)
					    {
					      	if($count == $total_user)
					      	{
					        	break;
					      	}

					      	foreach($result as $row)
					      	{
					      		$student_id[] = $row['user_id']; 
					      	}

					      	$exam->query = "SELECT * FROM group_member_table WHERE user_id = $student_id[$count] 
							AND course_id = ".$_POST['auto_course_id']." AND session_id = ".$_SESSION['session_id']." 
							AND group_id = ".$group_id."";

							$check_row = $exam->total_row();

							if($check_row > 0)
							{
								$output = array(
									'success' 	=> 'Group assigned successfully', 
								);
							}
							else
							{
						      	$exam->data = array(
						      		':session_id'		=>	$_SESSION['session_id'],
						      		':course_id'		=>	$_POST['auto_course_id']
						      	);

						      	$exam->query = "
								INSERT INTO group_member_table(group_id, course_id, user_id, session_id) 
								VALUES ($group_id, :course_id, $student_id[$count], :session_id)
								";

								$exam->execute_query();
							}
					    }
					    $per_group += $number_per_group;
					    $group_id += 1;
				  	}
				  	$output = array(
						'success' 	=> 'Group assigned successfully', 
					);
				}
			}
			else
			{
				$output = array(
					'error' 	=> 'Number exceed students available'
				);
			}
			echo json_encode($output);
		}

		if($_POST['action'] == 'group_setting')
		{
			if($exam->Count_total_row('group_table', 'group_name', $_POST['group_name']) > 0)
			{
				$output = array(
					'error' 	=> 'Group already exist'
				);
			}
			else
			{
				$exam->data = array(
					':group_name' 	=>	$_POST['group_name']
				);

				// die(var_dump($value, $teacher_id));
				$exam->query = "INSERT INTO group_table(group_name) VALUES (:group_name)";

				$exam->execute_query();

				$output = array(
					'success' 	=> 'Group Added successfully', 
				);
			}
			echo json_encode($output);
		}

		if($_POST['action'] == 'fetch_setting')
		{
			
			$output = array();

			$exam->query = "SELECT * FROM group_table WHERE ";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'group_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY group_id ASC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM group_table";

			$total_rows = $exam->total_row();

			$data = array();

			$count = 1;

			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row["group_id"];
				$sub_array[] = '<div class="update" id="update'.$count.'" data-id="'.$row['group_id'].'">'.$row['group_name'].'</div>';
				$sub_array[] = '<button type="button" class="btn btn-primary btn-sm edit_setting" id="'.$count.'">Edit</button>';
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

		if($_POST['action'] == 'update_group')
		{
			if($exam->Count_total_row('group_table', 'group_name', $_POST['value']) > 0)
			{
				$output = array(
					'error' 	=> 'Group already exist'
				);
			}
			else
			{
				$exam->data = array(
					':group_name' 	=>	$_POST['value'],

				);

				$exam->query = "UPDATE group_table SET group_name = :group_name 
				WHERE group_id = ".$_POST['group_id']."";

				$exam->execute_query();

				$output = array(
					'success' 	=> 'Group Updated successfully', 
				);
			}
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'attendance')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query ="
			SELECT * FROM classroom_visibility_table
			INNER JOIN classroom_table ON classroom_visibility_table.classroom_id=classroom_table.classroom_id
			INNER JOIN course_table ON classroom_table.course_id=course_table.course_id 
			INNER JOIN course_assign_table ON classroom_table.course_id=course_assign_table.course_id
			WHERE course_assign_table.tutor_id = ".$_SESSION['tutor_id']." 
			AND classroom_table.session_id = ".$_SESSION['session_id']." AND (
			";
			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= '
				course_table.course_code LIKE "%'.$_POST["search"]["value"].'%"
				OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%"
				';
			}
			$exam->query .= ")";

			$exam->query .='GROUP BY course_table.course_code ';

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
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM classroom_visibility_table
			INNER JOIN classroom_table ON classroom_visibility_table.classroom_id=classroom_table.classroom_id
			INNER JOIN course_table ON classroom_table.course_id=course_table.course_id 
			INNER JOIN course_assign_table ON classroom_table.course_id=course_assign_table.course_id
			WHERE course_assign_table.tutor_id = ".$_SESSION['tutor_id']." 
			AND classroom_table.session_id = ".$_SESSION['session_id']."
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row["course_code"];
				$sub_array[] = $row['course_name'];
				$sub_array[] = $exam->Count_total_row('user_course_enroll_table', 'course_id', $row['course_id']);
				$sub_array[] = '<button type="button" id="'.$row["course_id"].'" class="btn btn-info btn-sm view"><i class="fa fa-search"></i> View Attendance</button>';
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

		if($_POST['action'] == 'fetch_attendance')
		{
			$output = array();

			$exam->query ="
			SELECT * FROM classroom_visibility_table
			INNER JOIN classroom_table ON classroom_visibility_table.classroom_id=classroom_table.classroom_id
			INNER JOIN course_table ON classroom_table.course_id=course_table.course_id 
			INNER JOIN course_assign_table ON classroom_table.course_id=course_assign_table.course_id
			INNER JOIN user_table ON classroom_visibility_table.user_id=user_table.user_id
			WHERE course_assign_table.tutor_id = ".$_SESSION['tutor_id']." 
			AND classroom_table.session_id = ".$_SESSION['session_id']." 
			AND course_table.course_id = ".$_POST['course_id']." AND (
			";
			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= '
				user_table.matric_no LIKE "%'.$_POST["search"]["value"].'%"
				OR user_table.user_name LIKE "%'.$_POST["search"]["value"].'%"
				OR course_table.course_name LIKE "%'.$_POST["search"]["value"].'%"
				';
			}
			$exam->query .= ")";

			$exam->query .='GROUP BY user_table.user_id ';

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
			$exam->query .=$extra_query;
			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM classroom_visibility_table
			INNER JOIN classroom_table ON classroom_visibility_table.classroom_id=classroom_table.classroom_id
			INNER JOIN course_table ON classroom_table.course_id=course_table.course_id 
			INNER JOIN course_assign_table ON classroom_table.course_id=course_assign_table.course_id
			INNER JOIN user_table ON classroom_visibility_table.user_id=user_table.user_id
			WHERE course_assign_table.tutor_id = ".$_SESSION['tutor_id']." 
			AND classroom_table.session_id = ".$_SESSION['session_id']."
			AND course_table.course_id = ".$_POST['course_id']."
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = $row["matric_no"];
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["course_code"].' - '.$row['course_name'];
				$sub_array[] = $exam->get_attendance_percentage($row['user_course_enroll_id'], $_SESSION["session_id"]);
				$sub_array[] = '<button type="button" name="report_button" id="'.$row["user_course_enroll_id"].'" class="btn btn-danger btn-sm report_button">Report</button>';
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
}

?>