<?php
header('Content-Type: application/json');

include('../master/Examination.php');

$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if($_FILES['files']['name']){

	$allowed = ['docx', 'pdf', 'txt', 'ppt'];
	$processed = [];

	foreach($_FILES['files']['name'] as $key => $name)
	{
		if($_FILES['files']['error'][$key] === 0)
		{
			$temp = $_FILES['files']['tmp_name'][$key];
			$ext = explode('.', $name);
			$ext = strtolower(end($ext));

			$file = uniqid('', true) . time() . '.' . $ext;

			if(in_array($ext, $allowed) && move_uploaded_file($temp, 'upload/' . $file))
			{
				$exam->data = array(
					':tutor_id'				=> 	$_SESSION['tutor_id'],
					':article_title'		=>	$name,
					':article_file'			=>	$file,
					':article_upload_date'	=>	$current_datetime
				);

				$exam->query = "
				INSERT INTO article_entry_table(tutor_id, article_title, article_file, article_upload_date)
				VALUES(:tutor_id, :article_title, :article_file, :article_upload_date)
				";

				$exam->execute_query();
			}
			else
			{
				$processed[] = array(
					'name' => $name,
					'uploaded' => false 
				);
			}
		}
	}
	echo json_encode($processed);
}
?>