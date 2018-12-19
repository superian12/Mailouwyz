<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);

            
// Select Employees
            $sqlEmp = "SELECT  userid,username, lastname,firstname ,middleName,dept.deptname, gender, birthday ,mobileNumber, landline,email, ut.statusType FROM users u INNER JOIN Department dept ON u.departmentID = dept.deptid INNER JOIN userstatus ut ON u.sid=ut.sid  WHERE ut.sid = 1 and u.departmentID !=4 ";
            $queryEmp = $conn->query($sqlEmp) or die (mysqli_error($conn));


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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
   <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    
        <title></title>
    </head>
    <body>
<?php  include "topmenu.php" ?>
<div class="container">
        <div class=" col-lg-12 ">
            <h1 class="text-center"><i class="fa fa-list"></i>View Employees </h1>
                <form method = "POST" class="form-horizontal well" >

                    

                <div class=" col-lg-12">

                    <a href ="addemployee.php" class="btn btn-success btn-xs pull-right"> <i class ="fa fa-plus"> </i> Add Employee </a>

                    <br><br>


                </div>
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Mobile </th>
                        <th>Land line</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        
                        

                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($queryEmp))
                        {
                                $userid =$row['userid'];
                                $username=$row['username'];
                                $lastname=$row['lastname'];
                                $firstname=$row['firstname'];
                                $middleName= $row['middleName'];
                                $department=$row['deptname'];
                                $birthday=$row['birthday'];
                                $Mobile= $row['mobileNumber'];
                                $landline=$row['landline'];
                                $email=$row['email'];
                                $sid=$row['statusType'];
                                $fullname = $lastname.", ".$firstname;
                                echo"
                                <tr>
                                 
                                    
                                    <td>". $userid. "</td>
                                    <td>". $username. "</td>
                                    <td>". $fullname. "</td>
                                    <td>". $department. "</td>
        
                                    <td>". $Mobile. "</td>
                                    <td>". $landline. "</td>
                                    <td>". $email. "</td>
                                    <td>". $sid. "</td>
                                    
                                   <td><a href='editemployee.php?userid=". $userid. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>
                                    <td><a href='archiveEmployee.php?userid=".$userid."' class='btn btn-xs btn-danger'>
                                    <i class='fa fa-times'></i></</td>

                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                        <tr>
                         <th>User ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Mobile </th>
                        <th>Land line</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        
                   
                        </tr>

                    </tfoot>

                    </table>
                   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
                    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

                    <script>
                        $(document).ready(function() {
                        $('#posts').DataTable();
                    } );
                    </script>
                    </form>
                </div>
          </div>
    </body> 
</html>