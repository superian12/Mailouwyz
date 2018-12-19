<?php 
  require_once "system_command.php";
 ?>
<!DOCTYPE html> 
<head> 

<meta charset="utf-8"> 

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
    <a href="messenger.php" class="navbar-brand">MAILouwyz Courier</a> </div>
  <div id="navbarCollapse" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="messenger.php">Home</a></li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mail Delivery 
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="viewMail3.php">View Mails</a></li>
        <li><a href="generateDeliveredRemitedReports2.php">Generate Mail Delivery Report</a></li>
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
