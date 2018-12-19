<?php 

	function getMessenger()
	{
		require_once "../dbconnect.php";
		$selectMessenger = "SELECT u.lastname , u.firstname FROM mails m inner join users u on m.messenger = u.userid WHERE m.accountNo =".$_REQUEST['accountNo'];
	    $messengerQuery = $conn->query($selectMessenger) or die (mysqli_error($conn));
	    while($row=mysqli_fetch_array($messengerQuery))
	    {
	        $lastname = $row['lastname'];
	        $firstname = $row['firstname'];
	        $fullname = $lastname.', '.$firstname;

	        return $fullname;
	    }
	}

	    


 ?>