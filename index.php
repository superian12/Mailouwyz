<?php

    include "dbconnect.php";

session_start();
    unset($_SESSION['userid']);

   if (isset($_POST['Login']))
    {
        
        $Username = mysqli_real_escape_string($conn, $_POST['Username']);
        $Password =   hash('sha256',mysqli_real_escape_string($conn, $_POST['Password']));
        $SecretKey = "6Ld1NVIUAAAAAMBlX8MdNQrdWTFJg8Do2Cp0EfXt";
        $CaptchaCapture=$_POST['g-recaptcha-response'];
        $RemoteIP = $_SERVER['REMOTE_ADDR'];
        $url="https://www.google.com/recaptcha/api/siteverify?secret=$SecretKey&response=$CaptchaCapture&remoteip=$RemoteIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        if($response->success){
           $loging = " SELECT userid ,departmentID FROM users 
        where  username = '$Username' AND password ='$Password' and sid =1  ";
    
        $data = $conn->query($loging) or die(mysqli_error($conn));
 
        if (mysqli_num_rows($data) > 0)
        {
            while ($row = mysqli_fetch_array($data))
            {
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['departmentID'] = $row['departmentID'];
              

                 if ( $_SESSION['departmentID'] == 1) 
                {
                    header('location:hr.php');
                }
                else if ( $_SESSION['departmentID'] == 2) 
                {
                    header('location: ophead.php');
                }
                else if ( $_SESSION['departmentID'] == 3) 
                {
                    header('location:encohead.php');
                }
                else if ( $_SESSION['departmentID'] == 4) 
                {
                    header('location: messenger.php');
                }
                else if ( $_SESSION['departmentID'] == 5) 
                {
                    header('location: admin/admin.php');
                }
                
            }
            
               
            
               
        }
        else
        {
            echo "<script>alert('Incorrect Credentials')</script>";

        }
        }
        else{
            echo"<script>alert('Captcha Verification Failed')</script>";
        }



        
    }
?>
<!DOCTYPE html>

<html>
    <head>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
                <center><img  src='images/logo.png'  width="450" /></center>
            </div>
              <div  class="container" id="wrapper">
            <div class="col-lg-offset-3 col-lg-6" id="main_body" >
        
                
                <h2 align="center">Login</h2>
                <form method="POST" class="form-horizontal well">
              <div class="form-group" >
                        <label class="col-lg-offset-1 col-sm-2 col-form-label">Username</label>
                        <div class="col-lg-8">
                            <input name="Username" type="text"
                                class="form-control" required>
                                
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-lg-offset-1 col-sm-2 col-form-label">Password</label>
                        <div class="col-lg-8">
                            <input name="Password" type="password"
                                class="form-control" required>
                        </div>
                    </div>                


                    <center>
                    <div  class="form-group">
                        <div class="col-sm-15 col-form-label"> 
                            <p><b><a href="forgot_pw/forgotPassword.php" target="_blank"> Forgot Password </a><b><p>
                        </div>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6Ld1NVIUAAAAAGlxSaJ_bXfx3xZI-idgmfKxo6zS" required ></div>

                    <div  class="form-group">
                        <div  class="col-sm-15">
                            <button name="Login" type="submit" class="btn btn-success ">
                                <i class="fa fa-plus"></i> &nbsp&nbsp&nbsp&nbsp Login &nbsp&nbsp&nbsp&nbsp
                            </button>
                        </div>
                    </div>
                    </center>

                  

                </form>
            </div>
        </div>
    </body> 
</html>