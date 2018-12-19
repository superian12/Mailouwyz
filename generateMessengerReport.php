<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);

            


    $sql_view="SELECT  mailNo, accounts.firstname, accounts.lastname ,receiver, relation, dateTimeDelivered, ms.description, rtscode.RTSName, mailtypes.mailtypeName,  dateTimePulledOut, messenger From Mails 
    INNER JOIN ACCOUNTS ON mails.accountNo = accounts.accountNo
    INNER JOIN RTScode ON mails.rtsid = rtscode.rtsid
    INNER JOIN mailtypes ON mails.mailtypeID = mailtypes.mailtypeID
     INNER JOIN mailstatus ms ON mails.mailStatus = ms.statusID
    WHERE mails.mailStatus= '3 '";
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
        <title></title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    </head>
    <body>
        <?php
            include('topmenu.php');
         
        ?> 


    <div class="container">
        <div class="col-lg-12">
        <center><img src='logo.png'  width="450" /></center>
        <h3 class="text-center"><i class="fa fa-list"></i>Messenger Reports</h3>
                <form class="form-horizontal well">
                 <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>MailNo</th>
                        <th>Account Number</th>
                        <th>Receiver</th>
                        <th>Relation</th>
                        <th>DateTimeDelivered</th>
                        <th>RTSID</th>
                        <th>MailtypeID</th>
                        <th>Status</th>
                        <th>DateTimePulledOut</th>
                        <th>Messenger</th>
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $firstname=$row['firstname'];
                                $lastname=$row['lastname'];
                                $receiver=$row['receiver']; 
                                $relation=$row['relation'];
                                $dateTimeDelivered=$row['dateTimeDelivered'];
                                $RTSID=$row['RTSName'];
                                $mailtypeID=$row['mailtypeName'];
                                $description=$row['description'];
                                $dateTimePulledOut=$row['dateTimePulledOut'];
                                $messenger=$row['messenger'];
                                $fullName= $lastname.','.$firstname;

                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $fullName. "</td>
                                    <td>". $receiver. "</td>
                                    <td>". $relation. "</td>
                                    <td>". $dateTimeDelivered. "</td>
                                
                                    <td>". $RTSID. "</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>". $description. "</td>
                                    <td>". $dateTimePulledOut. "</td>
                                    <td>". $messenger. "</td>
                                    
                                    

                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                   
                    </table>

                    <br><br>

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
                        $('#posts').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                               'print', 'pdf', 'copy'
                            ]
                        } );
                    } );
                    </script>
                    </form>
                    </div>
                    </div>
    </body> 
</html>