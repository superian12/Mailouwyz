<?php 

 require_once "system_command.php";
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
          <li><a href="viewAreaAssignment.php">Manage Area Assignment</a></li>
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
          <li><a href="generateReceivedMail.php">Generate Receive Mail Report</a></li>
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
  </div>
</nav>   
