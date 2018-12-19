<?php
    include "../dbconnect.php";
    include "../system_command.php";
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
            


    $sql_view="SELECT logID, emp.firstName,emp.lastname, transaction, dateTimeTransaction, affectedTable, rowID FROM auditlog ad
    INNER JOIN users u ON ad.userID = u.userid
    INNER JOIN employee emp ON u.empID = emp.empID limit 100";
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
        <title>View Mails</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    </head>
    <body>
        <?php
            include('topmenu5.php');

        ?> 


    <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> view Mails</h1>
                <form class="form-horizontal well">
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>logID</th>
                        <th>User</th>
                        <th>Transaction</th>
                        <th>Date Transaction</th>
                        <th>Affected Table</th>
                        <th>Row ID</th>

                        </tr>

                    </thead>
                    <tbody>
                <?php


                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $logID =$row['logID'];
                                $transaction=$row['transaction']; 
                                $dateTimeTransaction=$row['dateTimeTransaction'];
                                $affectedTable=$row['affectedTable'];
                                $rowID=$row['rowID']; 
                                $firstName=$row['firstName'];
                                $lastname = $row['lastname'];
                                $full = $lastname.',  '.$firstName;
                               
                                      
                                

                                echo"
                                <tr>
                                    <td>". $logID. "</td>
                                    <td>". $full. "</td>
                                    <td>". $transaction. "</td>
                                    <td>". $dateTimeTransaction. "</td>
                                    <td>". $affectedTable. "</td>
                                    <td>". $rowID. "</td>
                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>logID</th>
                        <th>User</th>
                        <th>Transaction</th>
                        <th>Date Transaction</th>
                        <th>Affected Table</th>
                        <th>Row ID</th>     
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