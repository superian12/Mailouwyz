<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);


// SELECT System User
            $sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["Lastname"];
                $DashID = $Name;
            }

    $sql_view="SELECT  mailNo, account.accountName,  , mailtypes.mailtypeName, pulledOutStatus From Mails 
    INNER JOIN ACCOUNT ON mails.accountNo = account.accountNo
    INNER JOIN mailtypes ON mails.mailtypeID = mailtypes.mailtypeID
    WHERE mails.status= 'Active' AND PulledOutStatus = 'Delivered'";
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
            include('topmenu3.php');
         print "View Mail";
        ?> 


    <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center text-uppercase"><i class="fa fa-list"></i> Encode Mail</h1>
                
                <form class="form-horizontal well">
                        <div class=" col-lg-12">
                            <a href ="addMail.php" class="btn btn-success btn-sm pull-right"> <i class ="fa fa-plus"> </i> Addmail </a>
                            <br/>
                            <br/>

                        </div>
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>Account Name</th>
                        <th>Mail Referrence</th>
                        <th>Mail Type Name</th>
                        <th>PulledOutStatus</th>
                        <th>Edit Mail</th>
                        <th>Delete</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $accountName=$row['accountName'];
                                $mailref=$row['mailref']; 
                                $pulledOutStatus=$row['pulledOutStatus'];
                                $mailtypeName = $row['mailtypeName'];

                                echo"
                                <tr>
                                    <td>". $accountName. "</td>
                                    <td>". $mailref. "</td>
                                    <td>". $mailtypeName. "</td>
                                    <td>". $pulledOutStatus. "</td>
                                     <td><a href='editmail.php?mailNo=". $mailNo. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>

                                    <td><a href='archivemail.php?mailNo=". $mailNo. "' class='btn btn-xs btn-danger'>
                                    <i class='fa fa-trash-o'></i></</td>

                                    
                                    

                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>Account Name</th>
                        <th>mail Referrence</th>
                        <th>Mail Type Name</th>
                        <th>PulledOutStatus</th>
                        <th>Edit Mail</th>
                        <th>Delte</th>
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