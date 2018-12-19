<?php

 include "dbconnect.php";

    $sql_view="SELECT accountNo, accountName, address, areaAssignID From accounts WHERE status='Active'";
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

       <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu3.php');
         print " Archive Account";
        ?> 

        <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> Archive Account</h1>
                <form class="form-horizontal well">
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        
                        <th>Account Number</th>
                        <th>AccountName</th>
                        <th>Address</th>
                        <th>AreaAssignID</th>
                        
                        <th>Archive</th>
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $accountNo =$row['accountNo'];
                                $AccountName=$row['accountName'];
                                $Address=$row['address'];
                                $AreaID=$row['areaAssignID'];
                               
                          
                                echo"
                                <tr>
                                    <td>". $accountNo. "</td>
                                    <td>". $AccountName. "</td>
                                    <td>". $Address. "</td>
                                    <td>". $AreaID. "</td>
                                    
            
                                  
                                    <td><a href='archiveAccount2.php?accountNo=". $accountNo. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-trash-o'></i></</td>
                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                       <th>Account Number</th>
                        <th>AccountName</th>
                        <th>Address</th>
                        <th>AreaAssignID</th>
                        
                        <th>Archive</th>

                        </tr>

                    </tfoot>

                    </table>
    </body> 
</html>