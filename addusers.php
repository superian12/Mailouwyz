<?php 
	function addUser ($usern,$pass,$lastname,$firstname,$middle,$department,
		$gender,$birth,$mobile,$landline,$email){
		include "dbconnect.php";

		$sqlin = "INSERT INTO users(username, password, lastname, firstname, middleName, departmentID, gender, birthday,mobileNumber,landline,email,sid, pwdkey)VALUES ('$usern','$pass','$lastname','$firstname','$middle',$department,
		'$gender',$birth,$mobile,$landline,'$email',1,NULL)";

		$conn->query($sqlin) or die (mysqli_error($conn));
	}
	function pwdKey($uid){

		$key = rand(100,999);
		$key = (string)$key;

		return $key;
	}
	function editUser($ID,$username,$pass,$lastname,$firstname,$middle,$department,
		$gender,$birth,$mobile,$landline,$email){

		$query = "UPDATE users SET username='$username',$password='$pass',lastname='$lastname',firstname = '$firstname', middlename = '$middle' departmentID=$department, gender='$gender',birthday=$birth,mobileNumber=$mobile , landline=$landline, email='$email' where userid=$ID ";
		$conn->query($query) or die (mysqli_error($conn));
	}
 ?>