<?php

    include "../dbconnect.php";
    session_start();
    unset($_SESSION['userid']);

    if (isset($_POST['Login']))
    {
        
        $Username = mysqli_real_escape_string($conn, $_POST['Username']);
        $input_password =  mysqli_real_escape_string($conn, $_POST['Password']);
        $loging = " SELECT userid ,departmentID, sid FROM users 
        where  username = '$Username' and sid =2   AND  pwdkey = $input_password  ";
    
        $data = $conn->query($loging) or die(mysqli_error($conn));
 
        if (mysqli_num_rows($data) > 0)
        {
            while ($row = mysqli_fetch_array($data))
            {
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['departmentID'] = $row['departmentID'];

                header('location:../change_fp.php');
              
            }        
        }
        else
        {
            }



        }

?>
<!DOCTYPE html>

<html>
    <head>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <title>Mailouyz Courier System</title>
        <style type="text/css">
            #main_header{
            font-family: arial;
            margin: 0px; 
            background: black;         
            }
            
        </style>
    </head>
    <body>

            <div id="main_header">
                <center><img  src='../images/logo.png'  width="450" /></center>
            </div>
              <div  class="container" id="wrapper">
            <div class="col-lg-offset-3 col-lg-6" id="main_body" >
        
                
                <h2 align="center">Forgot Password</h2>
                <form method="POST" class="form-horizontal well">
              <div class="form-group" >
                        <label class="col-lg-offset-1 col-sm-2 col-form-label">Username</label>
                        <div class="col-lg-8">
                            <input name="Username" type="text"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-lg-offset-1 col-sm-2 col-form-label">Code</label>
                        <div class="col-lg-8">
                            <input name="Password" type="number"
                                class="form-control" required>
                        </div>
                    </div>

                    <div  class="form-group" align="center">
                        <div  class="col-sm-15">
                            <button name="Login" type="submit" class="btn btn-success ">
                                <i class="fa fa-plus">Login</i> 
                            </button>
                        </div>
                    </div>                



                </form>
            </div>
        </div>
    </body> 
</html>