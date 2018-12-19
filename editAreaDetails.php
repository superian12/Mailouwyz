<?php

   include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);


			
			
			
            if(isset($_REQUEST['areaID']))
            {
			/* GET VALUE */
            $areaID = $_REQUEST['areaID'];

                 $sql_view = "SELECT areaName from area WHERE areaID =".$_REQUEST['areaID'];
                
                 $queryGo = $conn->query($sql_view);

             

                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        
                        $areaName = $row['areaName'];
                        
 
                    }
			}
			
			if(isset($_POST['SaveEditArea'])){
				
						
                        $areaName = mysqli_real_escape_string($conn, $_POST['areaName']);
                        
						$sql_editArea = "UPDATE area SET areaName='$areaName' WHERE areaID = ".$_REQUEST['areaID'];

                         $conn->query($sql_editArea) or die(mysqli_error($conn));

						header('location:viewArea.php');
				
			}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu2.php');
         
        ?> 
		
		<div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-user-circle" > Edit Area Details</i>
                </h1>
       

            <form action ="" method ="post" class="form-horizontal well">    

					<div class="form-group">
                        <label class="control-label col-lg-4">Area Name: </label>
                        <div class="col-lg-8">
                            <input name="areaName" type="text" value=<?php echo $areaName?>
                                class="form-control" maxlength="100" required>

                                
                        </div>
                    </div>
						<div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="SaveEditArea" type="submit" onclick="return confirm('Area you sure?')" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Save
                            </button>
                        </div>
                    </div>
    </body> 
</html>