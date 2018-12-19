<?php
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
                    <i class="fa fa-calendar" > Add Event</i>
                </h1>
                   
                <form action ="addEventGo.php" method ="post" class="form-horizontal well">    
                   <div class="form-group">
                        <label class="control-label col-lg-4">Date</label>
                        <div class="col-lg-8">
                            <input name="evedate" type="date" 
                                class="form-control" maxlength="100" required>

                                
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Description</label>
                        <div class="col-lg-8">
                            <input name="descrip" type="text" 
                                class="form-control" maxlength="100" required>

                                
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="addEvent" type="submit" class="btn btn-success btn-lg pull-right"  onclick="return confirm('Are you sure you want to Add?');">
                                <i class="fa fa-plus"></i> Add Event
                            </button>
                        </div>
                    </div>

      </form>
    </body> 
</html>



