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
        <meta charset="UTF-8">
        <title>Edit User Account</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
         <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
            include('topmenu5.php');
         print "edit User Account";
        ?> 

        <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> Edit Account
            </h1>
                <form class="form-horizontal well">
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        
                        <th>Account Number</th>
                        <th>AccountName</th>
                        <th>Address</th>
                        <th>AreaAssign</th>
                        <th>Edit</th>
                        
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
                                    
            
                                    <td><a href='editUserAccount.php?accountNo=". $accountNo. "' class='btn btn-xs btn-info'>
                                    <i class= 'fa fa-edit'></i></</td>

                                                                       ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                       <th>Account Number</th>
                        <th>AccountName</th>
                        <th>Address</th>
                        <th>AreaAssign</th>
                        <th>Edit</th>
                        

                        </tr>

                    </tfoot>

                    </table>
                    </form>
                    </div>
                    </div>
                    
    </body> 
</html>