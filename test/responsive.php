<?php 

 require_once "../system_command.php";
 session_start();
 ?>
<!DOCTYPE html> 
<head> 
<meta charset="utf-8"> 
<title><center><img src='logo.png'  width="450" />
<br><h3>MAILouwyz Operations Head</h3>
</center>
</title> 
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
</head> 
<body> 
  <nav role="navigation" class="navbar navbar-inverse bg-inverse" >
  <div class="navbar-header">
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <a href="opHead.php" class="navbar-brand">Home</a> </div>
    <div id="navbarCollapse" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Messenger Monitoring
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="viewMessenger2.php">View Messenger</a></li>
        <li><a href="viewPendingMail.php">View Peding Mails</a></li>
        <li><a href="pulloutrequest.php">Pull Mails</a></li>
        </ul>
      </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Area Assignment
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewAreaAssignment.php">View Area</a></li>
          <li><a href="addAreaAssign.php">Add Area Assignment</a></li>
          <li><a href="viewAreaAssignment.php">Re-assign Area</a></li>
          <li><a href="viewAreaAssignment.php">Archive Assignments</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account Holder Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewAccount.php">View Account</a></li>
          <li><a href="addAccount.php">Add Account</a></li>
          <li><a href="editAccount.php">Edit Account</a></li>
          <li><a href="archiveAccount.php">Archive Account</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Area Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewArea.php">View Area</a></li>
          <li><a href="addArea.php">Add Area</a></li>
          <li><a href="viewArea.php">Edit Area Details</a></li>
          <li><a href="viewArea.php">Archive Area</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Mail Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewMail.php">View Mails</a></li>
          <li><a href="viewDeadlines.php">View Deadlines</a></li>
          <li class="divider"></li>
          <li><a href="receivedMail.php">Received Mails</a></li>
          <li><a href="addReceivedMail.php">Add Received Mails</a></li>
          <li><a href="editReceivedMail.php">Edit Received Mails</a></li>
          <li><a href="archiveReceivedMail.php">Archive Received Mails</a></li>
          <li><a href="generateReceivedMail.php">Generate Received Mails</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="generateMessengerReport2.php">Generate Messenger Reports</a></li>
          <li class="divider"></li>
          <li><a href="viewpsr.php">Generate Performance Assesment Reports</a></li>
          <li class="divider"></li>
          <li><a href="generatePAR2.php">Generate Receive Mail Report</a></li>
        </ul>
      </li> 
    </ul>
<ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo DashID()?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="changePass.php">Change Password</a></li>
          <li> <a href="logout.php" 
          onclick="return confirm('Are you sure?');">Logout</a>
          </li>
        </ul>
      </ul>
</li>
</ul>
</div>
</nav>


<?php

    include "../dbconnect.php";

    $sessionDepartment = '2';

    validateAccess($sessionDepartment);

if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Members data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
?>
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
        </style>

        <div id="header">
          <h1 align="center">View Accounts</h1>
        </div>
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

?>

