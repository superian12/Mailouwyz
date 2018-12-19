<?php
 include "dbconnect.php";
     include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
    // SELECT System User
            $sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["Lastname"];
                $DashID = $Name;
            }


   

	if(isset($_POST['addAssign'])){ 
	if(empty($_POST['AreaID'])){ 
		$getAreaName = false; $message .= 'Please select area '; 
	}else if(empty($_POST['userid'])){
		$getEmployeeName = false; $message .= 'Please select an employee '; 
	} 
	else { 
		/* 
		 */
		$AreaID = $_POST['AreaID'];
		$userid = $_POST['userid'];
		date_default_timezone_set('Asia/Manila');
		$date = date('Y/m/d H:i:s');
		$sql = "INSERT INTO `areaassignment`(`areaID`,`userid`,`dateAssigned`) VALUES ('$AreaID', '$userid', '$date')";
		$result = mysqli_query($conn, $sql);
		
		$sql2 = "UPDATE area SET `InUse`= 'Yes' WHERE `areaID`= '$AreaID'";
		$result2 = mysqli_query($conn, $sql2);
		
		//$message .= 'Are Assignment added';
		
		$sql_area = mysqli_query($conn, "SELECT areaName FROM area WHERE areaID = '$AreaID'");
		$row = mysqli_num_rows($sql_area);
		while ($row = mysqli_fetch_array($sql_area))
            {
				$areaName = $row['areaName'];
            }
		$sql_last_id = mysqli_query($conn, "SELECT LAST_INSERT_ID()");
		$row = mysqli_num_rows($sql_last_id);
		while ($row = mysqli_fetch_array($sql_last_id))
            {
				$lastID = $row[0];
            }
		
		//notification
		$sql4 = "INSERT INTO notificationID, userid, notifTitle, notifStatus, description, notifDate) 
                VALUES ('$lastID', '$userid', 'New Area Assignment', 'Pending', '$areaName is being assigned to you', '$date')";

		$result4 = mysqli_query($conn, $sql4);

        

		mysqli_close($conn);
	  } 

      header('location:viewAreaAssignment.php');
	  
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
         print "Add Area Assignment";
        ?> 

         <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Assign  Messengers  </i>
                </h1>   
                <form action ="" method="POST" class="form-horizontal well">
                    

                    <div class="form-group">
                        <label class="control-label col-lg-4">Messenger: </label>
                        <div class="col-lg-8">
                            <select name="userid" class="form-control" type="submit" required>
                            <option value="">Select one...</option>
                            <?php
							$sql = mysqli_query($conn, "SELECT `userid`, `lastname`, `firstname` FROM `users` WHERE `sid` = '1' AND `departmentID` = '4'");
							$row = mysqli_num_rows($sql);
							while ($row = mysqli_fetch_array($sql)){
							echo "<option value='". $row['userid'] ."'>" .$row['lastname'] , $row['firstname'] ."</option>" ;
							}
							?>
                        </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Area: </label>
                        <div class="col-lg-8">
                             <select name="AreaID" class="form-control" required>
                            <option value="">Select one...</option>
                           <?php
							$sql = mysqli_query($conn, "SELECT `AreaID`, `AreaName` FROM `area` WHERE `InUse` = 'No' AND `Status` = 'Active'");
							$row = mysqli_num_rows($sql);
							while ($row = mysqli_fetch_array($sql)){
							echo "<option value='". $row['AreaID'] ."'>" .$row['AreaName'] ."</option>" ;
							}
							?>
                            </select>
                        </div>
                    </div>

                  <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="addAssign" type="submit" onclick="return confirm('Are you sure you want to assign area?')" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Add Assignment
                            </button>
                        </div>
                    </div>
					
                </form>
            </div>
            </div>
			
			
    </body> 
</html>