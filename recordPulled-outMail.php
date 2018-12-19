<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
	$message = "";

// SELECT System User
            $sqlUser="SELECT emp.firstName FROM users u INNER JOIN employee emp on u.empID = emp.empID WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["firstName"];
                $DashID = $Name;
            }
            
			
		if(isset($_POST['Submit']))	{
			
			$_SESSION['AreaID'] = $_POST['AreaID'];
			$_SESSION['EmpID'] = $_POST['EmpID'];
			header('location:recordPulled-outMailGo.php');
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
         print "Record Pulled-out Mail";
        ?> 
		
		<div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-user-circle" > Record Pulled-out Mails</i>
                </h1>
       

            <form action ="" method ="post" class="form-horizontal well">    

			<div class="form-group">
                        <label class="control-label col-lg-4">Area: </label>
                        <div class="col-lg-8">
                             <select name="AreaID" class="form-control" required>
                            <option value="">Select one...</option>
                           <?php
                            $sql = mysqli_query($conn, "SELECT `AreaID`, `AreaName` FROM `area` WHERE `InUse` = 'Yes' AND `Status` = 'Active'");
                            $row = mysqli_num_rows($sql);
                            while ($row = mysqli_fetch_array($sql)){
                            echo "<option value='". $row['AreaID'] ."'>" .$row['AreaName'] ."</option>" ;
                            }
                            ?>
                            </select>
                        </div>
                    </div>
					
            <div class="form-group">
                        <label class="control-label col-lg-4">Messenger: </label>
                        <div class="col-lg-8">
                            <select name="EmpID" class="form-control" type="submit" required>
                            <option value="">Select one...</option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT `EmpID`, `LastName`, `FirstName` FROM `Employee` WHERE `Status` = 'Active' AND `deptID` = '4'");
                            $row = mysqli_num_rows($sql);
                            while ($row = mysqli_fetch_array($sql)){
                            echo "<option value='". $row['EmpID'] ."'>" .$row['LastName'] , $row['FirstName'] ."</option>" ;
                            }
                            ?>
                        </select>
                        </div>
                    </div>
			
                  <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="Submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Select Mails
                            </button>
                        </div>
                    </div>
                    <?php echo $message;?>
           
      </form>
    </body> 
</html>