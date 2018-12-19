<?php

    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);


// SELECT System User
          

    $sql_view=" SELECT m.mailNo, m.encoder, a.firstname, a.lastname, mm.mailtypeName, m.receivedmailID, r.dueDate  FROM mails m
            INNER JOIN accounts a on a.accountNo=m.accountNo 
            INNER JOIN receivedmails r on r.receivedmailID=m.receivedmailID
            INNER JOIN mailtypes mm on mm.mailtypeID=m.mailtypeID

            ";

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
        <title>View Deadlines</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    </head>
    <body>
        <?php
            include('topmenu3.php');
         print "View Deadlines2";
        ?> 


    <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> View Deadlines</h1>
                <form class="form-horizontal well">
                 <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Mail</th>
                        <th>Account Name</th>
                        <th>Mail Type</th>
                        <th>Batch Number</th>
                        <th>Encoder</th>
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
                                $mailtypeName=$row['mailtypeName'];
                                $receivedmailID=$row['receivedmailID'];
                                $encoder=$row['encoder'];
                                $dueDate=$row['dueDate'];
                                $fullName= $lastname.','.$firstname;
                                

                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $fullName. "</td>
                                    <td>". $mailtypeName. "</td>
                                    <td>". $receivedmailID. "</td>
                                    <td>". $encoder. "</td>
                                    <td>". $dueDate. "</td>
                                    
            
                                
                                 </tr>
                                    ";
                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>Mail</th>
                        <th>Account Name</th>
                        <th>Mail Type</th>
                        <th>Batch Number</th>\
                        <th>Batch Number</th>
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
                    </form>
                </div>
          </div>
    </body> 
</html>