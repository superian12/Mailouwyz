<?php 
    require_once "../dbconnect.php";
    session_start();

    if(isset($_POST['submit']))
    {
    $mailref = mysqli_real_escape_string($conn,$_POST['code']);
    $logsql = "SELECT m.mailNo  FROM  mails m  WHERE mailref= $mailref AND m.paStatus !=1";
  
    $doQuery = $conn->query($logsql) or die (mysqli_error($conn));
    if(mysqli_num_rows($doQuery) > 0 )
    { 
      while($rows = mysqli_fetch_array($doQuery))
      {
         $_SESSION['mailNo']  = $rows['mailNo'];
      }
        header('location:addpsr.php');
    }

    else
    {
      echo "<script> alert('Sorry your SMS code is Incorrect or Expired!') </script>";
    }
  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>Hr</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container">
  <h2 style="color:white;">Mailouyz Custumer Service</h2>

</nav>
</div>
<div class="container">

  <form class="login" method="POST">
                <h3> "What do we live for if not to make life less difficult for each other?"</h3>

George Eliot, Novelist.</h3>
          <div class="form-group">
            <label>SMS Code</label>
            <input name="code" type="number" required>
          </div>

          <div class="form-group">
            <button name="submit" class="btn btn-success btn-lg" type="submit"> Login</button>
          </div>

        </form>
</body>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>