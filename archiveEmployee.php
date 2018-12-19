<?php 
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);


// SELECT System User
   


                

            if(!isset($_REQUEST['userid']))
            {   
                header('location:viewEmployee.php');
            }

            /* GET VALUE */
            $userid = $_REQUEST['userid'];

                $sql_view = "SELECT lastname, firstname, middleName, d.deptID, d.deptname, gender, birthday, mobileNumber, landline, email from users u INNER JOIN department d ON u.departmentID=d.deptID WHERE userid =".$_REQUEST['userid'];
                $messenger = "UPDATE mails set messenger =0, mailStatus =1 WHERE mailStatus =2 AND messenger = ".$_REQUEST['userid'];
                
                 $queryGo = $conn->query($sql_view);

             

                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        
                        $lastname = $row['lastname'];
                        $firstname = $row['firstname'];
                        $middleName = $row['middleName'];
                        $deptID = $row['deptID'];
                        $deptname = $row['deptname'];
                        $gender = $row['gender'];
                        $birthday = $row['birthday'];
                        $mobileNumber = $row['mobileNumber'];
                        $landline = $row['landline'];
                        $email = $row['email'];
                        $fullName = $lastname." ".$firstname;

                        
 
                    }
              

                if(isset($_POST['submit']))
                    {

                       
                        $sql_update = "UPDATE users SET sid ='2' WHERE userid = ".$_REQUEST['userid'];
                        $delete_ar = "DELETE FROM areaassignment where userid =".$_REQUEST['userid'];

                        $conn->query($sql_update) or die (mysqli_error($conn));
                        $conn->query($messenger) or die (mysqli_error($conn));
                        $conn->query($delete_ar) or die (mysqli_error($conn));

                        header('location:viewEmployee.php'); 

                        
                    }
                
            
            
        
       

            ?>

<!DOCTYPE>
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
                    <i class="fa fa-envelope-o" >Employee: <?php echo$fullName?> </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                <!-- INPUTS / LABELS -->


                    <div class="form-group">
                        <label class="control-label col-lg-3">Middle Name</label>
                        <div class="col-lg-8">
                            <input name="middleName" type="text" value="<?php echo $middleName?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Department</label>
                        <div class="col-lg-8">
                            <input name="department" type="text" value="<?php echo $deptname?>" 
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
                            <input name="birthday" value="<?php echo $birthday?>" 
                                class="form-control" disabled>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Mobile Number</label>
                        <div class="col-lg-8">
                            <input name="mobileNumber" type="text" value="<?php echo $mobileNumber?>" 
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
                            <a href="viewEmployee.php" class="btn btn-danger btn-lg pull-left "  role="button"> Go Back </a>
                           <button name="submit" type="submit" class="btn btn-success btn-lg pull-right" onclick="return confirm('Are you sure?');">
                                <i class="fa fa-plus" ></i> Delete Employee
                            </button>
                    </div>
                </form>
                </div>
                </div>
                </body>
                   
                      
    </body> 

</html>
