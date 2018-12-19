<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);
    


             $sql_view="SELECT m.receivedmailID,  count(m.mailNo) as ttl ,mt.mailtypeName, rm.dueDate 
        FROM mails m 
    
        INNER JOIN receivedMails rm ON m.receivedmailID = rm.receivedMailID
        INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID
        INNER JOIN mailStatus ms ON m.mailStatus = ms.statusID
        WHERE m.mailStatus = 1  AND m.messenger =".$_SESSION['userid'].
        " GROUP BY m.receivedmailID";
    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));


             $sql_view1="SELECT m.receivedmailID,  count(m.mailNo) as ttl ,mt.mailtypeName, rm.dueDate 
        FROM mails m 
    
        INNER JOIN receivedMails rm ON m.receivedmailID = rm.receivedMailID
        INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID
        INNER JOIN mailStatus ms ON m.mailStatus = ms.statusID
        WHERE m.mailStatus = 2  AND m.messenger =".$_SESSION['userid']
        ." GROUP BY m.receivedmailID";
    $result_view1 =$conn->query($sql_view1) or die (mysqli_error($conn));
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
       
    </head>
    <body onLoad="initialCalendar();">
        <?php 
         include("topmenu4.php");  
        ?> 

        <div class="col-sm-6 ">

            <h1 class="text-center"><i class="fa fa-list"></i> Pending Mails</h1>
                <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="header">
                      
                        <th>Batch Number</th>
                        <th>Mail Count</th>
                        <th>MailType</th>
                        <th>Deadline</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result_view))
                            {
                                $receivedmailID =$row['receivedmailID'];
                                $mailtypeID=$row['mailtypeName'];
                                $deadline = $row['dueDate'];
                                $count = $row['ttl'];
                                echo"
                                <tr>
                                     
                                    <td>".$receivedmailID."</td>                                 
                                    <td>".$count."</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>". $deadline."</td>
                                   
                                </tr>";
                            }


                        ?>

                        </tbody>
                        </table>
                        </div>


        <div class="col-sm-6">
      
                        <h1 class="text-center"><i class="fa fa-list"></i> Queues Mails</h1>
              <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="header">
                      
                         <th>Batch Number</th>
                        <th>Mail Count</th>
                        <th>MailType</th>
                        <th>Deadline</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result_view1))
                            {
                                $receivedmailID =$row['receivedmailID'];
                                $mailtypeID=$row['mailtypeName'];
                                $deadline = $row['dueDate'];
                                $count = $row['ttl'];
                                echo"
                                <tr>
                                     
                                    <td>".$receivedmailID."</td>                                 
                                    <td>".$count."</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>". $deadline."</td>
                                   
                                </tr>";
                            }


                        ?>

                        </tbody>
                            </table>
                            </div>
                            

         
    </body>
</html>
