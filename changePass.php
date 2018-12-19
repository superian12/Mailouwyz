<?php
include "dbconnect.php";
include "system_command.php";
session_start();




if(!isset($_SESSION['userid']))
{
    header('location:../index.php');
}
else
{



    if (isset($_POST['changePassword']))
    {
        $userID = $_SESSION['userid'];
        $Username = mysqli_real_escape_string($conn, $_POST['Username']);
        $Password =  hash('sha256', mysqli_real_escape_string($conn, $_POST['Password']));
        $newPassword  =  hash('sha256', mysqli_real_escape_string($conn, $_POST['newPassword']));
        $Verify  =  hash('sha256', mysqli_real_escape_string($conn, $_POST['verify']));

            $sql_view=" SELECT username , password FROM users 
            
            where  username = '$Username' AND password ='$Password' AND sid !='2' AND userID = $userID" ;
            $queryGo = $conn->query($sql_view) or die (mysqli_error($conn));
    
     
            if (mysqli_num_rows($queryGo) >= 1   && $Verify == $newPassword)
            {
               
                
                
            $loging = " UPDATE  users  SET password ='$newPassword' WHERE userID = $userID"  ;
            $conn->query($loging) or die(mysqli_error($conn));
            
             //REDIRECT TO HOMEPAGE 

               if ( $_SESSION['departmentID'] == 1) 
                {
                    $url = "hr.php";
                }
                else if ( $_SESSION['departmentID'] == 2) 
                {
                   $url = "ophead.php";
                }
                else if ( $_SESSION['departmentID'] == 3) 
                {
                   $url = "encohead.php";
                }
                else if ( $_SESSION['departmentID'] == 4) 
                {
                   $url = "messenger.php";
                }
                else if ( $_SESSION['departmentID'] == 5) 
                {
                    $url = "admin.php";
                }

                
               

               echo"<script type='text/javascript'>
                    alert('Successfuly changed!');
                    location=".$url.";
                    </script>";

            
            
        }
            else
            {
                echo "<script type='text/javascript'>alert('invalid Authentication  !')</script>";
            }
    }
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
        // TOP MENU FOR the user
       if ( $_SESSION['departmentID'] == 1) 
                {
                    include('topmenu.php');
                }
                else if ( $_SESSION['departmentID'] == 2) 
                {
                   include('topmenu2.php');
                }
                else if ( $_SESSION['departmentID'] == 3) 
                {
                   include('topmenu3.php');
                }
                else if ( $_SESSION['departmentID'] == 4) 
                {
                   include('topmenu4.php');
                }
                else if ( $_SESSION['departmentID'] == 5) 
                {
                    include('topmenu5.php');
                }

        ?> 

         <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="" >Change Password </i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Username</label>
                        <div class="col-lg-8">
                            <input name="Username" type="text"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Old    Password</label>
                        <div class="col-lg-8">
                            <input name="Password" type="password"
                                class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <br>
                    <br>
                      <div class="form-group">
                        <label class="control-label col-lg-4">New Password</label>
                        <div class="col-lg-8">
                            <input name="newPassword" type="password"
                                class="form-control" maxlength="100" required>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="control-label col-lg-4"> Repeat Password</label>
                        <div class="col-lg-8">
                            <input name="verify" type="password"
                                class="form-control" maxlength="100" required>
                        </div>
                    </div>
                

                

                


                    
                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="changePassword" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Change Password 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body> 
</html>