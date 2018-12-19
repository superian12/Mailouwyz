<?php
    require_once "../dbconnect.php";
    require_once "../system_command.php";
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
    $sql_view="SELECT userID, e.firstName,e.lastname,d.deptName, userName From users 
              INNER JOIN employee e ON users.empID = e.empID
              INNER JOIN department d ON e.deptID = d.deptID";

    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));


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
        <title>View User Account</title>

    </head>
    <body>
        <?php
            include('topmenu5.php');
         
        ?> 

         <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> View User Accounts</h1>
                <form class="form-horizontal well">
                <div class=" col-lg-12">

                    <a href ="addUserAccount.php" class="btn btn-success btn-xs pull-right"> <i class ="fa fa-plus"> </i> Add User </a>

                    <br><br>


                </div>
                <table id="posts" class="table table-hover">
                 
                <br/>
                <br/>
                    <thead>
                        <tr>

                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>User Name</th>
                            <th>Edit </th>
                            <th>Delete</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                               $userID =$row['userID'];
                            $firstName=$row['firstName'];
                            $lastname=$row['lastname'];
                            $username=$row['userName'];
                            $fullname=$lastname.', '.$firstName;
                            $Department=$row['deptName'];
                                 
                               
                          
                                echo"
                                <tr>
                                    <td>". $userID. "</td>
                                    <td>". $fullname. "</td>
                                    <td>". $Department. "</td>
                                    <td>". $username. "</td>
                                    
                                    <td><a href='editUserAccount.php?userID=". $userID. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>
                                    <td><a href='archiveUserAccount.php?userID=".$userID."' class='btn btn-xs btn-danger'>
                                    <i class='fa fa-times'></i></</td>
                                    
            
                                
                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>

                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>User Name</th>
                            <th>Edit </th>
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