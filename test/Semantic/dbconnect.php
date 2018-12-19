<?php
	$server     = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "warzone";
    
    //STEP 1 : connect to the database
    $conn       = mysqli_connect($server, $username, $password, $database);
    
    //STEP 2 : check the connection
        if (!$conn) 
            {
                die("Connection Failed: " . mysqli_connect_error());
            }	
?>
	