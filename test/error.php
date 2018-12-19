<?php 
	include "../dbconnect.php";

$query = "SELECT  sada*FROM users";

 
if (!mysqli_query($conn,$query))
  {
 	echo "<script>alert('Alert Agent is leaving the team')</script>";
  }
  else {
  	echo '<script type="text/javascript">alertify.alert("Hello");</script>';

  }
   



 ?>

 


<