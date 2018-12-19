<?php 

require_once "dbconnect.php";
require_once "system_command.php";
$sessionDepartment = '1';
session_start();
validateAccess($sessionDepartment);


    if(isset($_REQUEST['userid']))
            {
                $sql_view="SELECT  userid, lastname,firstname,middleName ,birthday,dept.deptname,  gender, mobileNumber, landline,email FROM users us INNER JOIN department dept ON us.departmentID = dept.deptid  WHERE sid= 1 AND userid=".$_REQUEST['userid'];
                 $queryGo = $conn->query($sql_view);

                if (mysqli_num_rows($queryGo) > 0)
                {
                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        $lastname = $row['lastname'];
                        $firstname = $row['firstname'];
                        $middleName = $row['middleName'];
                        $department = $row['deptname'];
                        $gender =$row['gender'];
                        $mobileNumber = $row['mobileNumber'];
                        $landline=$row['landline'];
                        $email=$row['email'];
                        $birthdate=$row['birthday'];
                        $fullName = $lastname." ".$firstname;
                    }               
                }    
            }      
            ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       
    </head>
    <body>
        <?php
            include('topmenu.php'); 
        ?>
              <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" >Employee: <?php echo $fullName?> </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                <!-- INPUTS / LABELS -->

                    <div class="form-group">
                        <label class="control-label col-lg-3">Middle Name</label>
                        <div class="col-lg-8">
                            <input name="middlename" type="text" value="<?php echo $middleName?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Department</label>
                        <div class="col-lg-8">
                            <input name="deptname" type="text" value="<?php echo $department?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                  
                    <div class="form-group">
                        <label class="control-label col-lg-3">Gender</label>
                        <div class="col-lg-8">
                            <input name="gender" type="text" value="<?php echo $gender?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Birth Date</label>
                        <div class="col-lg-8">
                            <input name="birthdate" value="<?php echo $birthdate ?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Mobile Number</label>
                        <div class="col-lg-8">
                            <input name="mobile" type="text" value="<?php echo $mobileNumber?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Landline</label>
                        <div class="col-lg-8">
                            <input name="landline" type="text" value="<?php echo $landline?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Email</label>
                        <div class="col-lg-8">
                            <input name="email" type="text" value="<?php echo $email?>" 
                                class="form-control" disabled>
                        </div>
                        </div>








                  <div class="form-group">
                            <a href="viewEmployee.php" class="btn btn-danger btn-lg pull-right "  role="button"> Go Back </a>
                    </div>
                </form>
                </div>
                </div>
                </body>
                   
                      
    </body> 

</html>
