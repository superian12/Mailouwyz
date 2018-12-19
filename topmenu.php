<?php 
require_once "system_command.php";

 ?>
<!DOCTYPE html> 
<head> 
<!-- ONLINE LIBRARY -->
  <meta charset="utf-8"> 
 <title><center><img src='logo.png'  width="450" />
<br><h3>MAILouwyz HR</h3>
</center>
</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css"> 
  <!-- <link rel="stylesheet" href="assets/font-awesome-4.7/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- <script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js/bootstrap.min.js"></script> -->
  <script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  </head>
<body> 
    <nav role="navigation" class="navbar navbar-inverse bg-inverse" >
  <div id="navbarCollapse" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">

  <div class="navbar-header">
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <a href="hr.php" class="navbar-brand">Home</a> </div>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="viewEmployee.php">View Employee</a></li>
        <li><a href="viewMessenger.php">View Messenger</a></li>
        </ul>
      </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="generateMessengerReport.php">Generate Messenger Reports</a></li>
          <li class="divider"></li>
          <li><a href="generatePAR2.php">Generate Performance Assesment Reports</a></li>
        </ul>
      </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Performance Assesment
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewPSR2.php">View Performance Survey Result</a></li>
        </ul>
      </li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo DashID();?>
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
