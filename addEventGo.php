<?php

include("dbconnect.php");
	//STEP 3 Prepare for SQL Statement

		$descrip = $_POST["descrip"];
		$evedate = $_POST["evedate"];
	



		$sql = " INSERT INTO calendar (descrip, evedate) 
		         VALUES ('$descrip', '$evedate') ";
// validate if insert statement was successful 
	if ($conn->query($sql) === TRUE){
		echo "<script type= 'text/javascript'>alert('New record successfully added');</script>";
	} else {
		echo "<script type= 'text/javascript'>alert('Error:" . $sql. "<br>" . $conn->error."');</script>";
	}
		
	//	echo $sql;
	//STEP 4 Execute SQL Statement
		//$result = mysqli_query($conn, $sql);

	//STEP 5 : Write other TASKS


	//STEP 6 :	Display Data

						
	//STEP 7: Close the connection
	mysqli_close($conn);
	
    // Others

    header("Location: opHead.php");

?>
