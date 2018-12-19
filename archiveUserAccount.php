<?php 
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '5';
    session_start();
    validateAccess($sessionDepartment);


// SELECT System User
            $sqlUser="SELECT emp.firstName FROM users u INNER JOIN employee emp on u.empID = emp.empID WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["firstName"];
                $DashID = $Name;
            }





        if(!isset($_REQUEST['userID']))
        {
            header('location:viewUserAccount.php');
        }
             
    

              $sql_view="SELECT u.empID ,userID, e.firstName,e.lastname,d.deptName, userName From users u
              INNER JOIN employee e ON u.empID = e.empID
              INNER JOIN department d ON e.deptID = d.deptID
              WHERE userID=".$_REQUEST ['userID'] ;
              $queryView=$conn->query($sql_view) or die (mysqli_error($conn));

             

           
            while ($row= mysqli_fetch_array($queryView))
                {           $empID= $row['empID'];
                            $userID =$row['userID'];
                            $firstName=$row['firstName'];
                            $lastname=$row['lastname'];
                            $username=$row['userName'];
                            $fullname=$lastname.', '.$firstName;
                            $Department=$row['deptName'];
                                 
                }

              
              
            if(isset($_POST['submit']))
            {
            

            $sql_edit="UPDATE users set  status='Archived'where userID=".$_REQUEST ['userID'] ;
            $conn->query($sql_edit) or die(mysqli_error($conn));

            $sql_status="UPDATE employee SET status = 'Pending' WHERE empID = $empID ";
            $conn->query($sql_status)or die (mysqli_error($conn));
            #Audit
            

                add2log('Delete', $_SESSION['userid'],'User',$_REQUEST['userID']);
                echo"<script type='text/javascript'>
                alert('Successfuly Deleted a User !');
                location='viewUserAccount.php';
                </script>";
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
        <title>Edit User Account</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
            include('topmenu5.php');
         print "edit User Account";
        ?> 
     <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" >Delete User: <?php echo $userID?>   </i>
                </h1>


                <form method="POST" class="form-horizontal well">
                    
                    

                    <div class="form-group">
                        <label class="control-label col-lg-4">FullName</label>
                        <div class="col-lg-8">
                            <input name="fullname" type="text"
                                class="form-control" value=" <?php echo $fullname; ?>"  disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Department</label>
                        <div class="col-lg-8">
                            <input name="department" type="text"
                                class="form-control" maxlength="100" value=<?php echo $Department ?> disabled>
                        </div>
                        </div>

                   <div class="form-group">
                        <label class="control-label col-lg-4">Username</label>
                        <div class="col-lg-8">
                            <input name="userName" type="text"
                                class="form-control" maxlength="100" value="<?php echo $username ?>" disabled>
                        </div>
                        </div>

            


                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="submit" type="submit"  onclick="return confirm('Are you sure you want to Delete?');"class="btn btn-success btn-lg pull-right">
                                Delete Account
                            </button>
                        </div>
                    </div>
                    </form>
                   
                    </div>
                    </div>


    </body> 


</html>