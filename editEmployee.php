<?php 
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);
    $validation_username='';
    $validation_age='';
    $validation_mobile='';
    $validation_email='';




           if(!isset($_REQUEST['userid']))
            {   
                header('location:viewEmployee.php');
            }

            /* GET VALUE */
            $userid = $_REQUEST['userid'];

                 $sql_view = "SELECT username, lastname, firstname, middleName, d.deptID, d.deptname, gender, birthday, mobileNumber, landline, email from users u INNER JOIN department d ON u.departmentID=d.deptID WHERE userid =".$_REQUEST['userid'];
                
                 $queryGo = $conn->query($sql_view) or die(mysqli_error($conn));

             

                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        $username = $row['username'];
                        $lastname = $row['lastname'];
                        $firstName = $row['firstname'];
                        $middleName = $row['middleName'];
                        $deptID = $row['deptID'];
                        $department = $row['deptname'];
                        $gender = $row['gender'];
                        $birthday = $row['birthday'];
                        $mobileNumber = $row['mobileNumber'];
                        $landline = $row['landline'];
                        $email = $row['email'];
                        $fullName = $lastname." ".$firstName;

                    }
 
                // CHOICES
              
              $sql_department = " SELECT deptname, deptID FROM department WHERE deptID != $deptID ";
              $query_department = $conn->query($sql_department) or die (mysqli_error($conn));
              $deptRow="";

              if(mysqli_num_rows($query_department) > 0 )
              {
                while ($row = mysqli_fetch_array($query_department)) 
                {
                    $cdeptID= $row['deptID'];
                    $cdeptName=$row['deptname'];
                    $deptRow = $deptRow."  <option value='$cdeptID'> $cdeptName</option> ";        
                }
            }


                if(isset($_POST['submit']))
                    {
                        $validation_errors='';
                        $username = mysqli_real_escape_string($conn, $_POST['username']);
                        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
                        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
                        $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
                        $department = mysqli_real_escape_string($conn, $_POST['department']);
                        //$jobdes = mysqli_real_escape_string($conn, $_POST['jobdes']);
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                        $mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
                        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
                        $landline = mysqli_real_escape_string($conn, $_POST['landline']);
                        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
                          // Compute for the age
                        $today =date("d-m-Y");
                        $birth = new DateTime($birthday);
                        $today = new DateTime($today);
                        $age = $birth->diff($today);
                        $age = $age->y;
                        // Validations
                        $validate_existing_username = "SELECT username from users where username = '$username' and userid !=".$_REQUEST['userid'];
                        $get_validate_existing_username = $conn->query($validate_existing_username) or die (mysqli_error($conn));
                        if(mysqli_num_rows($get_validate_existing_username) >= 1)
                        {
                            $validation_errors++;
                            $validation_username = '* $username username already exist';
                                                    }
                        if($age <= 17)
                        {
                            $validation_errors++;
                            $validation_age = '*Age must be 18 above';

                        }
                        $validate_existing_mobile = "SELECT * from users where mobileNumber = $mobileNumber and userid !=".$_REQUEST['userid'];
                        $get_validate_existing_mobile =$conn->query($validate_existing_mobile) or die(mysqli_error($conn));
                        if (mysqli_num_rows($get_validate_existing_mobile) >= 1) {
                            $validation_errors++;
                            $validation_mobile .=$mobileNumber.' is already an existing number';
                            
                            
                        }
                        $validate_existing_email = "SELECT * from users WHERE email ='$email' and userid !=".$_REQUEST['userid'];
                        $get_validate_existing_email = $conn->query($validate_existing_email) or die(mysqli_error($conn));
                        if(mysqli_num_rows($get_validate_existing_email) >=1)
                        {
                            $validation_errors++;
                            $validation_email = '* Email already exist!';
                            

                        }

                        if($validation_errors == 0 ){



                        $sql_edit = "UPDATE users SET username='$username',firstname ='$firstname' , lastname = '$lastname', middleName = '$middleName', departmentID = '$department',mobileNumber = '$mobileNumber', landline = '$landline' , birthday = '$birthday',email ='$email', gender = '$gender'
                        WHERE userid = ".$_REQUEST['userid'];

                        

                         $conn->query($sql_edit) or die(mysqli_error($conn));
                         echo"<script>alert('Edit Successful')</script>";
                        header('location:viewEmployee.php'); 
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
                    <i class="fa fa-envelope-o" >Employee: <?php echo$fullName?> </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                <!-- INPUTS / LABELS -->
                  <div class="form-group">
                        <label class="control-label col-lg-3">User Name</label>
                        <div class="col-lg-8">
                            <input name="username" type="text" value="<?php echo $username?>" 
                                class="form-control" required>
                                <span class="error_message" style="color: red"><?php echo $validation_username ?></span> 
                        </div>
                        </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-3">First Name</label>
                        <div class="col-lg-8">
                            <input name="firstname" type="text" value="<?php echo $firstName?>" 
                                class="form-control" required>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Last Name </label>
                        <div class="col-lg-8">
                            <input name="lastname" type="text" value="<?php echo $lastname ?>" 
                                class="form-control" required>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Middle Name</label>
                        <div class="col-lg-8">
                            <input name="middleName" type="text" value="<?php echo $middleName?>" 
                                class="form-control" >
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Department</label>
                        <div class="col-lg-8">
                          <select name="department" class="form-control"  required>
                            <option value=<?php echo$deptID ?>> <?php echo $department?></option>
                            <?php echo $deptRow ?>
                            </select>
                        </div>
                        </div>

                      
                    <div class="form-group">
                    <label class="control-label col-lg-3">Gender </label>
                        <div class="col-lg-8">
                            <select class="form-control" name="gender" id="gender" required> 
                            <option value=<?php echo$gender ?>> <?php echo $gender?></option>
                            <option value="MALE">Male </option>
                            <option value="FEMALE">Female</option>
                            </select> 
                        </div>
                 </div> 



                <div class="form-group">
                <label class="control-label col-lg-3">Birthday</label>
                <div class="col-lg-8">
                    <input name="birthday" type="date" value=<?php echo$birthday ?>
                           class="form-control" required>
                           <span class="error_message" style="color: red"><?php echo $validation_age ?></span>
                </div>
                </div>

           

                    <div class="form-group">
                        <label class="control-label col-lg-3">Mobile Number</label>
                        <div class="col-lg-8">
                            <input name="mobileNumber" type="number" value="<?php echo $mobileNumber?>" 
                                class="form-control" required>
                                <span class="error_message" style="color: red"><?php echo $validation_mobile ?></span>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Landline</label>
                        <div class="col-lg-8">
                            <input name="landline" type="number" value="<?php echo $landline?>" 
                                class="form-control" required>
                        </div>
                        </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3">Email</label>
                        <div class="col-lg-8">
                            <input name="email" type="text" value="<?php echo $email?>" 
                                class="form-control" required>
                                <span class="error_message" style="color: red"><?php echo $validation_email ?></span>

                        </div>
                        </div>








                  <div class="form-group">
                            <a href="viewEmployee.php" class="btn btn-danger btn-lg pull-left "  role="button"> Go Back </a>
                           <button name="submit" type="submit" class="btn btn-success btn-lg pull-right" onclick="return confirm('Are you sure?');">
                                <i class="fa fa-plus" ></i> Edit Employee
                            </button>
                    </div>
                </form>
                </div>
                </div>
                </body>
                   
                      
    </body> 

</html>
