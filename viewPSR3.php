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
// SELECT SURVEYS
              $sqlS = "SELECT  p.PAsurveyID, e.firstName, e.lastName, p.dateFilled, p.rating, p.remarks FROM performanceassessment p INNER JOIN employee e ON e.empID=p.empID";
            $queryEmp = $conn->query($sqlS) or die (mysqli_error($conn));

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
<?php  include "topmenu5.php" ?>
<div class="container">
        <div class="col-lg-offset-1 col-lg-10 ">
            <h1 class="text-center"><i class="fa fa-list"></i>Messenger Performance </h1>
                <form method = "POST" class="form-horizontal well" >
                <!--<div class=" col-lg-12">
                            <a href ="addMail.php" class="btn btn-success btn-xs pull-right"> <i class ="fa fa-plus"> </i> Addmail </a>

                        </div>-->
                <table id="posts" class="table table-hover">
                    <thead>

                        <tr>
                        <th>Survey ID</th>
                        <th>Messenger Name</th>
                        <th>Date Filled</th>
                        <th>Rating </th>
                        <th>Remarks</th>
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($queryEmp))
                        {
                                $PAsurveyID =$row['PAsurveyID'];
                                $firstName=$row['firstName'];
                                $lastName=$row['lastName'];
                                $dateFilled=$row['dateFilled'];
                                $rating= $row['rating'];
                                $remarks= $row['remarks'];
                                $fullName= $lastName.','.$firstName;
                                echo"
                                <tr>
                                    
                                    <td>".  $PAsurveyID."</td>
                                    <td>". $fullName. "</td>
                                    <td>". $dateFilled. "</td>
                                    <td>". $rating."</td>
                                    <td>". $remarks."</td>

                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                       
                       <tr>
                        <th>Survey ID</th>
                        <th>Messenger Name</th>
                        <th>Date Filled</th>
                        <th>Rating </th>
                        <th>Remarks</th>
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