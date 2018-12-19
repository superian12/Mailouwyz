<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
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
            


    $sql_view="SELECT  mailNo, accounts.accountNo,  dateTimeDelivered, ms.description, rtscode.RTSName, mailtypes.mailtypeName, dateTimePulledOut, u.firstname,u.lastname, r.receivedmailID From Mails m
     INNER JOIN users u ON m.messenger = u.userID
    INNER JOIN mailstatus ms ON m.mailStatus = ms.statusID
    INNER JOIN ACCOUNTS ON m.accountNo = accounts.accountNo
    INNER JOIN RTScode ON m.rtsid = rtscode.rtsid
    INNER JOIN mailtypes ON m.mailtypeID = mailtypes.mailtypeID
    INNER JOIN receivedmails r ON m.receivedmailID=r.receivedmailID
    WHERE m.mailStatus= '5'";
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
            include('topmenu2.php');
         print "View Mail";
        ?> 


    <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> View Remitted Mails</h1>
                <form class="form-horizontal well">

               
                <a href="viewMail.php" class="btn btn-info" role="button">View Pending Mails</a>
                <a href="viewDelivered.php" class="btn btn-info" role="button">View Delivered Mails</a>
                <a href="viewRemitted.php" class="btn btn-info" role="button">View Remitted Mails</a>
                <br>
                <br>

                <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>MailNo</th>
                        <th>Batch No</th>
                        <th>Account No</th>
                        <th>DateTimeDelivered</th>
                        <th>Staus</th>
                        <th>RTSID</th>
                        <th>MailtypeID</th>
                        <th>DateTimePulledOut</th>
                        <th>Messenger</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $receivedmailID =$row['receivedmailID'];
                                $firstname=$row['firstname'];
                                $lastname=$row['lastname'];
                                $accountNo=$row['accountNo'];
                                $dateTimeDelivered=$row['dateTimeDelivered'];
                                $description=$row['description']; 
                                $RTSID=$row['RTSName'];
                                $mailtypeID=$row['mailtypeName'];
                                $dateTimePulledOut=$row['dateTimePulledOut'];
                                $fullName= $lastname.','.$firstname;
                                

                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $receivedmailID. "</td>
                                    <td>". $accountNo. "</td>
                                  
                                    <td>". $dateTimeDelivered. "</td>
                                    <td>". $description. "</td>
                                    <td>". $RTSID. "</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>". $dateTimePulledOut. "</td>
                                    <td>". $fullName. "</td>
                                    
                                    

                                    </tr>
                                    ";

                        }


?>

                    </tbody>
                   

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

                     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                       <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>


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