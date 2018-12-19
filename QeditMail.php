<?php

 include "dbconnect.php";

    $sql_view="SELECT  mailNo  , account.accountName, receiver, relation, dateTimeDelivered, mails.status, rtscode.RTSName, mailtypes.mailtypeName, pulledOutStatus, dateTimePulledOut From Mails 
    INNER JOIN ACCOUNT ON mails.accountNo = account.accountNo
    INNER JOIN RTScode ON mails.rtsid = rtscode.rtsid
    INNER JOIN mailtypes ON mails.mailtypeID = mailtypes.mailtypeID
    WHERE mails.status= 'Active'";
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
    </head>
    <body>
        <?php
            include('topmenu3.php');
         print "View Mail";
        ?> 


    <div class="container">
        <div class="col-lg-15">
            <h1 class="text-center"><i class="fa fa-list"></i> Edit Mail</h1>
                <form class="form-horizontal well">
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>MailNo</th>
                        <th>Account Name</th>
                        <th>Receiver</th>
                        <th>Relation</th>
                        <th>DateTimeDelivered</th>
                        <th>Remittance Name</th>
                        <th>mailtype Name </th>
                        <th>PulledOutStatus</th>
                        <th>DateTimePulledOut</th>
                        <th>Edit</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $accountName=$row['accountName'];
                                $receiver=$row['receiver'];
                                $relation=$row['relation'];
                                $dateTimeDelivered=$row['dateTimeDelivered'];
                                $status=$row['status']; 
                                $RTSName=$row['RTSName'];
                                $mailtypeName=$row['mailtypeName'];
                                $pulledOutStatus=$row['pulledOutStatus'];
                                $dateTimePulledOut=$row['dateTimePulledOut'];

                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $accountName. "</td>
                                    <td>". $receiver. "</td>
                                    <td>". $relation. "</td>
                                    <td>". $dateTimeDelivered. "</td>
                                
                                    <td>". $RTSName. "</td>
                                    <td>". $mailtypeName. "</td>
                                    <td>". $pulledOutStatus. "</td>
                                    <td>". $dateTimePulledOut. "</td>
                                    <td><a href='editMail.php?mailNo=". $mailNo. "' class='btn btn-xs btn-info'>
                                    <i class= 'fa fa-edit'></i></</td>
                                    
                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                         <th>MailNo</th>
                        <th>Account Name</th>
                        <th>Receiver</th>
                        <th>Relation</th>
                        <th>DateTimeDelivered</th>
                        <th>Remittance Name</th>
                        <th>mailtype Name </th>
                        <th>PulledOutStatus</th>
                        <th>DateTimePulledOut</th>
                        <th>Edit</th>
                        
                        </tr>

                    </tfoot>

                    </table>
    </body> 
</html>