<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();


// SELECT System User
            $sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
        $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
        $DashID = "";
        while ($row = mysqli_fetch_array($queryUsers))
        {
            $Name = $row["Lastname"];
            $DashID = $Name;
        }




    $sql_view="SELECT accountNo, a.firstname, a.lastname, a.houseNo, a.streetName, a.city, a.region, a.ZIP, a.areaID,area.areaName From accounts a
    INNER JOIN area on a.areaID = area.areaID WHERE a.statusID='1'";
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu3.php');
         print "View Account";
        ?> 

        <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> view Accounts</h1>
                <form class="form-horizontal well">
               <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        
                        <th>Account Number</th>
                        <th>AccountName</th>
                        <th>Address</th>
                        <th>Area Name</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $accountNo =$row['accountNo'];
                                $firstname=$row['firstname'];
                                $lastname=$row['lastname'];
                                $houseNo=base64_decode($row['houseNo']);
                                $streetName=base64_decode($row['streetName']);
                                $city=base64_decode($row['city']);
                                $region=base64_decode($row['region']);
                                $ZIP=base64_decode($row['ZIP']);
                                $areaName=$row['areaName'];
                                $fullName= $lastname.','.$firstname;
                                $address= $houseNo.','.$streetName.','.$city.','.$region.','.$ZIP;
                               
                          
                                echo"
                                <tr>
                                    <td>". $accountNo. "</td>
                                    <td>". $fullName. "</td>
                                    <td>". $address. "</td>
                                    <td>". $areaName. "</td>
                                    
            
                                
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