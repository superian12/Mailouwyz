<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
     $user = $_SESSION['userid'];
   $sql_view="SELECT m.mailNo, ac.firstname,ac.lastname,m.accountNo,mt.mailtypeName, rm.dueDate ,ms.description
        FROM mails m 
        INNER JOIN accounts ac on ac.accountNo=m.accountNo 
        INNER JOIN receivedMails rm ON m.receivedmailID = rm.receivedMailID
        INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID
        INNER JOIN mailStatus ms ON m.mailStatus = ms.statusID
        WHERE m.mailStatus = 2 AND m.messenger =$user ORDER by dueDate desc";
    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));


?>






<!DOCTYPE html>

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
    <body >
        <?php
            include('topmenu4.php');
         print "View Mail";
        ?> 
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8 ">
            <h1 class="text-center"><i class="fa fa-list"></i> Delivery Queues</h1>
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>*</th>
                        <th>Mail Number</th>
                        <th>Account Number</th>
                        <th>MailType</th>
                        <th>Deadline</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result_view))
                            {
                                $mailNo =$row['mailNo'];
                                $firstname=$row['firstname'];
                                $lastname=$row['lastname'];
                                $mailtypeID=$row['mailtypeName'];
                                $pulledOutStatus=$row['description'];
                                $fullName= $lastname.','.$firstname;
                             
                                $deadline = $row['dueDate'];
                                echo"
                                <tr>
                                    <td><a href='messengermap.php?mailNo=".$mailNo."'' class='btn btn-xs btn-warning'>
                                    <i class ='fa fa-map-o'></i></td>   
                                    <td>".$mailNo."</td>                                 
                                    <td>". $pulledOutStatus. "</td>
                                    <td>". $fullName. "</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>". $deadline."</td>
                                   <td><a href='editDeliveredRemitedMail.php?mailNo=".$mailNo."' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>
                                    <td><a href='editRemitMail.php?mailNo=".$mailNo."' class='btn btn-xs btn-danger'>
                                    <i class='fa fa-times'></i></</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th>*</th>
                        <th>Mail Number</th>
                        <th>Account Number</th>
                        <th>MailType</th>
                        <th>Deadline</th>
                   
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

                </div>
          </div>
    </body> 
</html>