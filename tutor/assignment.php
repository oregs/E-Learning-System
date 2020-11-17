<?php
$num = 3;

$student = [1,2,3,4,5,6,7,8,9,10,11];
$group = [3,7,9,10];

$student1 = count([1,2,3,4,5,6,7,8,9,10,11]);
$group1 = count([3,7,9,10]);

$store[] = '';

$count = 0;

$num1 = $num;

if($num > $group1)
{
  echo 'Number greater than Group';
}
else
{
  $iterate = ceil($student1/$num);
  $rownum = $iterate * $num;

  while($num <= $rownum)
  {
    for($count = $count; $count < $num; $count++)
    {
      if($count == $student1)
      {
        break;
      }

      // foreach($student as $row)
      // {
        foreach($group as $member)
        {
            $store = $student[$count] . ' ' . $member . '<br>';
            print_r($store);
        }
      // }
    }
    $num += $num1;
    // $group += 1;
  }
}

// die(var_dump($student));





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

      $iterate = ceil($total_user/$per_group);
      $user_number = $iterate * $per_group;

      if($iterate > $total_group)
      {
        echo 'Number greater than Group available';
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

                $exam->data = array(
                  ':session_id'   =>  $_SESSION['session_id'],
                  ':course_id'    =>  $_POST['auto_course_id']
                );

                $exam->query = "
            INSERT INTO group_member_table(group_id, course_id, user_id, session_id) 
            VALUES ($group_id, :course_id, $student_id[$count], :session_id)
            ";

            $exam->execute_query();
            }
            $per_group += $number_per_group;
            $group_id += 1;
          }
          $output = array(
          'success'   => 'Group assigned successfully', 
        );
        echo json_encode($output);
      }
    }

    exam->query = "SELECT * FROM assignment_table 
INNER JOIN course_table ON assignment_table.course_id = course_table.course_id
INNER JOIN user_course_enroll_table ON assignment_table.course_id = user_course_enroll_table.course_id
INNER JOIN tutor_table ON assignment_table.tutor_id = tutor_table.tutor_id
INNER JOIN group_table ON assignment_table.group_id = group_table.group_id
INNER JOIN group_member_table ON assignment_table.group_id = group_member_table.group_id
WHERE user_course_enroll_table.user_id = ".$_SESSION['user_id']." AND group_member_table.user_id = ".$_SESSION['user_id']." AND assignment_format = 'group' GROUP BY 
";

?>