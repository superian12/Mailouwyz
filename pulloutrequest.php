<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);


// CHOICES

     
            if (isset($_SESSION['mail']))
            {
                unset($_SESSION['mail']);
            }
   $sql_view="SELECT  userid , firstname , lastname FROM users WHERE departmentID =4 AND sid = 1;";
    $query_view =$conn->query($sql_view) or die (mysqli_error($conn));
    $messengerROW ="";
    
    while($row= mysqli_fetch_array($query_view))
    {
        $userid = $row['userid'];
        $first =$row['firstname'];
        $last = $row['lastname'];
        $full = $last.', '.$first;
        $messengerROW = $messengerROW. "<option value='$userid'>$full</option>";
    }


    if(isset($_POST['submit']))
    {
       
            $_SESSION['messenger_pull'] = mysqli_real_escape_string($conn,$_POST['id']);
            header('location:messengerPull.php');
    }

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
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu2.php');

        ?> 

            <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-user-circle" > Pull Mails</i>
                </h1>
       

            <form action ="" method ="post" class="form-horizontal well">    

                  <div class="form-group">
                <label class="control-label col-lg-3">Messengers: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="id" id="id" required>
                        <option value="">Select....</option>
                        <?php echo $messengerROW ?>
                        </select> 
                    </div>
             </div>     
             <br>
                         <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Pull Mails
                            </button>
                        </div>
                    </div>
      </form>
      </div>
    </body> 
</html>


