<?php
    include "dbconnect.php";
    //require_once"addusers.php";
    include "system_command.php";
    date_default_timezone_set('Asia/Manila');

    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);
    $validation_bday='';
    $validation_username = '';
    $validation_email='';
    $username='';
    $input_password ='';
    $lastname = '';
    $firstname = '';
    $middleName = '';
    $departmentID = '';
    $gender = '';
    $bdate = '';
    $mobileNumber = '';
    $landline = '';
    $email = '';

   $sql_department = " SELECT deptname,deptID FROM department ";
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
        $validation_error ='';
        $username= mysqli_real_escape_string($conn,$_POST['username']);
        $input_password = mysqli_real_escape_string($conn,$_POST['password']);
        $password = hash('sha256',$input_password);
        $lastname = mysqli_real_escape_string($conn , $_POST['lastname']);
        $firstname = mysqli_real_escape_string($conn , $_POST['firstname']);
        $middleName = mysqli_real_escape_string($conn , $_POST['middleName']);
        $departmentID = mysqli_real_escape_string($conn, $_POST['departmentID']);
        $gender = mysqli_real_escape_string($conn , $_POST['gender']);
        $bdate = mysqli_real_escape_string($conn, $_POST['birthday']);
        $mobileNumber = mysqli_real_escape_string($conn , $_POST['mobileNumber']);
        $landline = mysqli_real_escape_string($conn , $_POST['landline']);
        $email = mysqli_real_escape_string($conn , $_POST['email']);
        // Compute for the age
        $today =date("d-m-Y");
        $birth = new DateTime($bdate);
        $today = new DateTime($today);
        $age = $birth->diff($today);
        $age = $age->y;
        //Validation

        $validate_existing_username = "SELECT * FROM users where username ='$username'";
        $query_validate_existing_username = $conn->query($validate_existing_username) or die (mysqli_error($conn));
        if(mysqli_num_rows($query_validate_existing_username) >=1){
            $validation_error++;
            $validation_username = '*Username '.$username.'   Already Exist!';

        }

        if($age<= 17 && $today > $birth){
            $validation_error++;
            $validation_bday = '*Must be 18 years old';
        }
        // Birthday
        $now = new DateTime();

        if($today < $birth) {
            $validation_error++;
            $validation_bday = '*Must be a less than today  ';

        }
        //Email If existing
        $get_email = "SELECT * FROM users where email ='$email'";
        $query_get_email =$conn->query($get_email) or die (mysqli_error($conn));
        if (mysqli_num_rows($query_get_email) >= 1 ) {
            $validation_error++;
            $validation_email= '* Email Already Exist';

        }

    //philippineTime();
    //echo greaterTime($date);
  

        // Error Free
     
        if($validation_error == 0){
        $query = "INSERT INTO users (username, password, firstname,lastname, middleName, departmentID, gender, birthday, mobileNumber, landline, email, sid, pwdkey) VALUES ('$username' , '$password','$firstname' , '$lastname', '$middleName', '$departmentID', '$gender', '$bdate', '$mobileNumber', '$landline', '$email', 1, Null )";

                $conn -> query($query)  or die (mysqli_error($conn));

        header('location:viewEmployee.php');
        }
    }


?>

<title>Add Employee</title>
        <?php
            include('topmenu.php');

        ?> 

       <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-user-circle" > Add Employee</i>
                </h1>
       

            <form action ="" method ="post" class="form-horizontal well">    
            <div class="form-group">
                        <label class="control-label col-lg-4">Username</label>
                        <div class="col-lg-8">
                            <input name="username" type="text" 
                                class="form-control" maxlength="100" value="<?php echo $username ?>" required>
                                <span class="error_message" style="color: red"><?php echo $validation_username ?></span>
                        </div>
                    </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Password</label>
                        <div class="col-lg-8">
                            <input name="password" type="password" 
                                class="form-control" maxlength="100" value="<?php echo $input_password ?>" required>          
                        </div>
                    </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Last Name: </label>
                        <div class="col-lg-8">
                            <input name="lastname" type="text" 
                                class="form-control" maxlength="100" value="<?php echo $lastname ?>" required>

                                
                        </div>
                    </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">First Name: </label>
                        <div class="col-lg-8">
                            <input name="firstname" type="text" 
                                class="form-control" maxlength="100" value="<?php echo $firstname ?>" required>

                                
                        </div>
                    </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Middle Name: </label>
                        <div class="col-lg-8">
                            <input name="middleName" type="text" 
                                class="form-control" maxlength="100" value="<?php echo $middleName ?>" required>

                                
                        </div>
                    </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Department: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="departmentID" id="departmentID"  ?>
                        <option value="">Select....</option>
                        <?php echo $deptRow ?>
                        </select> 
                    </div>
             </div> 

            <div class="form-group">
                <label class="control-label col-lg-4">Gender: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="gender" id="gender" value=<?php echo $gender ?> required> 
                        <option value="">Select....</option>
                        <option value="MALE">Male </option>
                        <option value="FEMALE">Female</option>
                        </select> 
                    </div>
             </div> 

            <div class="form-group">
                      <label class="control-label col-lg-4">Birthday: </label>
                <div class="col-lg-8">
                    <input name="birthday" type="date"
                           class="form-control" value=<?php echo $bdate ?> required>
                           <span class="error_message" style="color: red"><?php echo $validation_bday ?></span>
                </div>
            </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Mobile: </label>
                        <div class="col-lg-8">
                            <input name="mobileNumber" type="number"
                                class="form-control"  maxlength="30" value="<?php echo $mobileNumber ?>" required  >
                        </div>
                        </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Landline</label>
                        <div class="col-lg-8">
                            <input name="landline" type="number"
                                class="form-control" maxlength="30" value="<?php echo $landline ?>" required  >
                        </div>
                        </div>

            <div class="form-group">
                        <label class="control-label col-lg-4">Email: </label>
                        <div class="col-lg-8">
                            <input name="email" type="email"
                                class="form-control" maxlength="100" value="<?php echo $email ?>" required  >
                                <span class="error_message" style="color: red"><?php echo $validation_email ?></span>
                        </div>
                        </div>


                         <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Add Employee
                            </button>
                        </div>
                    </div>
      </form>
      </div>
    </body> 
</html>


