<?php 
include '../dbconnect.php';
$result = array();
$result[] = 3;


/*echo'SELECT * 
          FROM table 
         WHERE id IN (' . implode(',', array_map('intval', $row)) . ')';


 . implode(',', array_map('intval', $result)) . 

 */

  $select_employees = "SELECT u.firstname , u.lastname FROM users u where u.departmentID = 4 and userid NOT in (". implode(',', array_map('intval', $result)) .") ";
  $get = $conn->query($select_employees) or die (mysqli_error($conn));
 ?>