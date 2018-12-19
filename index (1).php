<?php

    include "dbconnect.php";

    if (isset($_POST['Login']))
    {
        session_start();
        $Username = mysqli_real_escape_string($conn, $_POST['Username']);
        $Password =  hash('sha256', mysqli_real_escape_string($conn, $_POST['Password']));
        $loging = " SELECT userid,username , Password ,deptID FROM Users 
        inner join employee ON users.empID = employee.empID 
        where  username = '$Username' AND password ='$Password' AND Users.status ='ACTIVE' ";
    
        $data = $conn->query($loging) or die(mysqli_error($conn));
 
        if (mysqli_num_rows($data) > 0)
        {
            while ($row = mysqli_fetch_array($data))
            {
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['deptID'] = $row['deptID'];
              

                 if ( $_SESSION['deptID'] == 1) 
                {
                    header('location: hr.php');
                }
                else if ( $_SESSION['deptID'] == 2) 
                {
                    header('location: ophead.php');
                }
                else if ( $_SESSION['deptID'] == 3) 
                {
                    header('location:encohead.php');
                }
                else if ( $_SESSION['deptID'] == 4) 
                {
                    header('location: notification.php');
                }
                else if ( $_SESSION['deptID'] == 5) 
                {
                    header('location: admin.php');
                }
                
            }
            
               
            
               
        }
        else
        {
            echo "<script type='text/javascript'>alert('invalid username and password !')</script>";

        }
 

    }

?>
<!DOCTYPE html>

<html>
    <head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

           

        <div  class="container">
            <div class="col-lg-offset-3 col-lg-6" >
            <br>
            <center><img src='logo.png'  width="450" /></center>
                <h1 class="text-center" style="color:black;">
                    <i class="" >Login </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-lg-8">
                            <input name="Username" type="text"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-lg-8">
                            <input name="Password" type="password"
                                class="form-control" maxlength="100" required>
                        </div>
                    </div>
                


                    <center>
                    <div  class="form-group">
                        <div class="col-sm-15 col-form-label"> 
                            <p><b><a href="forgotPassword.php" target="_blank"> Forgot Password </a><b><p>
                        </div>
                    </div>

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