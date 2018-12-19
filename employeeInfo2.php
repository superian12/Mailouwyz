<?php 

require_once "dbconnect.php";
require_once "system_command.php";
$sessionDepartment = '2';
session_start();
validateAccess($sessionDepartment);


    if(isset($_REQUEST['userID']))
            {
        /* GET VALUE */
            


                $sql_view="SELECT   lastname,firstname,middleName ,birthday,dept.deptname,  gender, mobileNumber, landline,email FROM users us INNER JOIN Department dept ON us.departmentID = dept.deptid  WHERE sid= 1 AND userid=".$_REQUEST['userID'];
                 $queryGo = $conn->query($sql_view);


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
                        $fullname = $lastname.' '.$firstname;

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
            include('topmenu2.php'); 
        ?>
              <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" >Employee: <?php echo $_REQUEST['userID'] ?> </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                <!-- INPUTS / LABELS -->

                    <div class="form-group">
                        <label class="control-label col-lg-3">Middle Name</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $middleName?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Department</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $department?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                  
                    <div class="form-group">
                        <label class="control-label col-lg-3">Gender</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $gender?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Birth Date</label>
                        <div class="col-lg-8">
                            <input name="mailref" value="<?php echo $birthdate ?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Mobile Number</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $mobileNumber?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Landline</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $landline?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Email</label>
                        <div class="col-lg-8">
                            <input name="mailref" type="text" value="<?php echo $email?>" 
                                class="form-control" disabled>
                        </div>
                        </div>








                  <div class="form-group">
                            <a href="viewmessenger2.php" class="btn btn-danger btn-lg pull-right "  role="button"> Go Back </a>
                    </div>
                </form>
                </div>
                </div>
                </body>
                   
                      
    </body> 

</html>
