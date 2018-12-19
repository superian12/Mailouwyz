<?php 


 ?>
<!DOCTYPE html> 
<head> 
<meta charset="utf-8"> 
<title><center><img src='logo.png'  width="450" />
<br><h3>MAILouwyz Encoder</h3>
</center>
</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head> 
<body> 
  <nav role="navigation" class="navbar navbar-inverse bg-inverse" >
  <div class="navbar-header">
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <a href="encoHead.php" class="navbar-brand">MAILouwyz Courier</a> </div>
  <div id="navbarCollapse" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="encoHead.php">Home</a></li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mali Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="viewMail2.php">View Mail</a></li>
        <li><a href="viewDeadlines2.php">View Deadlines</a></li>
        </ul>
      </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="generateDeliveredRemitedReports.php">Generate Delivered/Remitted Mails Report</a></li>
        </ul>
      </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account Holder Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="viewAccount2.php">View Account</a></li>
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

