<?php

   include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);


			
			
			
            if(!isset($_REQUEST['areaID']))
            {   
                header('location:viewarea.php');
            }

			/* GET VALUE */
            $areaID = $_REQUEST['areaID'];

                 $sql_view = "SELECT areaName from area WHERE areaID =".$_REQUEST['areaID'];
                
                 $queryGo = $conn->query($sql_view);

             

                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        
                        $areaName = $row['areaName'];
                        
 
                    }
			
			
			if(isset($_POST['archiveArea']))
            {
				#Check affected Row

                $sqlAffect ="SELECT m.mailNo From mails m
                INNER JOIN accounts ac ON m.accountNo = ac.accountNo
                INNER JOIN area a ON ac.areaID = a.areaID WHERE m.mailStatus in ('1','2') AND ac.areaID =".$_REQUEST['areaID'];
                $queryAffect =$conn->query($sqlAffect) or die (mysqli_error($conn));


                if(mysqli_num_rows($queryAffect) > 0)
                {     
                    echo"<script type='text/javascript'>
                    alert('Cannot delete area because of pending mails!');
                    location='viewArea.php';
                    </script>";

                        

                }
                else
                {
                 
                 $sql_editArea = "UPDATE area SET status='Inactive' WHERE areaID = ".$_REQUEST['areaID'];
                        $editAreaAssign = "UPDATE areaAssignment SET status ='Inactive'WHERE areaID = ".$_REQUEST['areaID'];
                         $sql_editAccount = "UPDATE Accounts SET statusID='2' WHERE areaID = ".$_REQUEST['areaID'];

                        $conn->query($editAreaAssign) or die (mysqli_error($conn));
                        $conn->query($sql_editArea) or die(mysqli_error($conn));
                        $conn->query($sql_editAccount) or die(mysqli_error($conn));
                        #Edit existing account affected by change
                        
             #AUDIT   
                        //add2log('Delete', $_SESSION['userid'],'Area',$_REQUEST['areaID']);

                        header('location:viewArea.php');   
                    

                      
                        
						
                     
                    }
				
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
                    <i class="fa fa-user-circle" >Archive</i>
                </h1>
       

            <form action ="" method ="post" class="form-horizontal well">    

					<div class="form-group">
                        <label class="control-label col-lg-4">Area Name: </label>
                        <div class="col-lg-8">
                            <input name="areaName" type="text" value=<?php echo $areaName?>
                                class="form-control" maxlength="100" disabled>

                                
                        </div>
                    </div>
						<div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="archiveArea" type="submit" onclick="return confirm('Are you sure you want to Archive area?')" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Archive
                            </button>
                        </div>
                    </div>
    </body> 
</html>