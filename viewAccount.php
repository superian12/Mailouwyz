<?php

    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);



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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
   <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        
        <title>Test</title>
    </head>
    <body>
    <!--
            <style type="text/css">
            #wrapper{
                display: grid;
                grid-template-columns:1fr 3fr;
                margin-top: 100px
            }
            #import_div{
              padding: auto;
              margin: auto;
              border: auto;
            }
            #main_div{
             padding: auto;
              margin: auto;
              border: auto;
            }
        </style>
        -->
        <?php
            include('topmenu2.php');
        ?> 
        <div id="header">
          <h1 align="center">View Accounts</h1>
        </div>


            <div id="main_div" class="col-sm-offset-2 col-sm-8 ">
            <form class="form-horizontal well">
                <table id="posts" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Account Info</th>
                        <th>Account Number</th>
                        <th>Full Name</th>
                        <th>Adress</th>                         
                        <th>AreaName</th>
                        <th>Edit</th>
                        <th>Delete</th>
                                                               
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = $conn->query("SELECT ac.accountNo , ac.lastname, ac.firstname, a.areaName, ac.houseNo , ac.streetName, ac.region ,ac.city , ac.ZIP FROM accounts ac INNER JOIN area a on ac.areaID = a.areaID where statusID =1 ORDER BY accountNo ASC");
                        if($query->num_rows > 0){ 
                            while($row = mysqli_fetch_array($query)){ 
                            $account = $row['accountNo'];
                            $fullname = $row['lastname'].", ".$row['firstname'];
                            $houseNo = base64_decode($row['houseNo']);
                            $streetName = base64_decode($row['streetName']);
                            $city = base64_decode($row['city']);
                            $region = base64_decode($row['region']);
                            $zip = base64_decode($row['ZIP']);
                            $address = $houseNo .", ".$streetName.", ".$city.", ".$region.", ".$zip;
                            
                            $areaid = $row['areaName'];

                            echo"
                            <tr>
                            <td><a href='infoaccount.php?accountNo=".$account."' class='btn btn-xs btn-info'><i class='fa fa-map-o'></i></td>
                            <td>".$account."</td>
                            <td>".$fullname."</td>
                            <td>".$address."</td>
                            <td>".$areaid."</td>
                            <td><a href='editaccount.php?accountNo=".$account."' class='btn btn-xs btn-info'><i class='fa fa-pencil-square-o'></i></td>
                            <td><a href='archiveaccount.php?accountNo=".$account."' class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></td>
                            <tr>

                            ";
                                } 
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

                    <script>
                        $(document).ready(function() {
                        $('#posts').DataTable();
                    } );
                    </script>
                    </form>
            </div>


    </body> 
</html>