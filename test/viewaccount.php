<?php
    include "../dbconnect.php";
    include "../system_command.php";
    $sessionDepartment = '3';
    session_start();




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
        <title>Test</title>
        <style type="text/css">
            #wrapper{
                display: grid;
                grid-template-columns:1fr 3fr;
            }
            #import_div{
                background-color: black;
            }
        </style>
    </head>
    <body>
        <?php
            include('../topmenu3.php');
        ?> 
        <div id="wrapper">
            <div id="import_div" >
               <?php if(!empty($statusMsg)){
                    echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
                } ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Members list
                        <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import Members</a>
                    </div>
                    <div class="panel-body">
                        <form action="importData.php" method="post" enctype="multipart/form-data" id="importFrm">
                            <input type="file" name="file" />
                            <br>
                            <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                            </form>
                    </div>
                </div> 
            </div>
            <div id="main_div">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                          <th>Account Number</th>
                          <th>First Name</th>
                          <th>Adress</th>
                          <th>ZIP</th>
                          <th>Area ID</th>
                          <th>Mobile</th>
                          <th>Email</th>
                          <th>Status ID</th>                                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = $conn->query("SELECT * FROM accounts ORDER BY accountNo ASC");
                        if($query->num_rows > 0){ 
                            while($row = $query->fetch_assoc()){ ?>
                        <tr>
                          <td><?php echo $row['accountNo']; ?></td>
                          <td><?php echo $row['firstname'] ."  ".$row['middlename'] ."  " . $row['lastname']; ?></td>
                          <td><?php echo $row['houseNo'] ."  ". $row['streetName']."  ". $row['city']."  ".$row['region']; ?></td>
                          <td><?php echo $row['ZIP']; ?></td>
                          <td><?php echo $row['areaID']; ?></td>
                          <td><?php echo $row['mobile']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td><?php echo ($row['statusID'] == '1')?'Active':'Inactive'; ?></td>
                          
                        </tr>
                        <?php } }else{ ?>
                        <tr><td colspan="5">No member(s) found.....</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </body> 
</html>