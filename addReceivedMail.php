<?php

    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
    $validation_day='';
$validation_duedate='';
    $mailtypeID = '';
    $quantity = '';
    $duedate = '';
  date_default_timezone_set('Asia/Manila');
     


      $sqlGetMailType ="SELECT mt.mailtypeID , mt.mailtypeName FROM mailtypes mt ";
      $queryGo = $conn->query($sqlGetMailType) or die(mysqli_error($conn));
      $GoRow = "";
        while ($row = mysqli_fetch_array($queryGo))
        {
          $mailTypeID = $row["mailtypeID"];
          $MailTypeName = $row["mailtypeName"];
          $GoRow =$GoRow. "<option value='$mailTypeID'> $MailTypeName</option>";
        }

      $selectEncoder = "SELECT  u.userid FROM users u 
    WHERE u.userid =".$_SESSION['userid'];
    $messengerQuery = $conn->query($selectEncoder) or die (mysqli_error($conn));
    while($row=mysqli_fetch_array($messengerQuery))
    {
        

        $userid= $row['userid'];
    }
        
                
        if (isset($_POST['addreceivedmail']))
              {
                $validation_error='';
          
   
          $mailtypeID = mysqli_real_escape_string($conn, $_POST['mailtypeID']);
          $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
          $duedate = mysqli_real_escape_string($conn, $_POST['duedate']);
          ///
          $today =date("d-m-Y");
           $du = new DateTime($duedate);
         $today = new DateTime($today);
          $result = $today->format('Y-m-d h-m-s');


         $now = new DateTime();

        if($today > $du) {
            $validation_error++;
            $validation_duedate = '*Cannot be less than today  ';
        }

        if($quantity <= 0) {

          $validation_error++;
          echo "<script>alert('Quantity is invalid')</script>";

        }

         if($quantity >= is_float($quantity) ) {

          $validation_error++;
          echo "<script>alert('Quantity is invalid')</script>";

        }


        if($validation_error == 0){


          $insert = "INSERT  into receivedmails (userid, mailtypeID, quantity, duedate, status,receivedDate) VALUES (".$_SESSION['userid'].", '$mailtypeID','$quantity','$duedate','Active','$result') ";
           $conn->query($insert) or die(mysqli_error($conn));
           
            $sql_getno = "SELECT receivedMailID FROM receivedmails ORDER BY receivedMailID desc limit 1 ";
            $query_getno = $conn ->query($sql_getno) or die (mysqli_error($conn));
            while($row= mysqli_fetch_array($query_getno))
            {
                $id = $row['receivedMailID'];
            }
            $description = "Deadline Batch Mail # $id <br/>
            Number of Mails: $quantity";
            $calendar ="INSERT INTO calendar values ('','$description','$duedate','$id')";
            $conn->query($calendar) or die (mysqli_error($conn));

      

          //add2log('Add', $_SESSION['userid'],'Received Mails',$audit);
           header('location:receivedMail.php');
              }
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
include('dbconnect.php');
?>

<div class="container">
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class="fa fa-user-circle" > Received Mail</i>
        </h1>


        <form action ="" method ="post" class="form-horizontal well">
         <div class="form-group">
                
            
           <div class="form-group">
                <label class="control-label col-lg-4">Mail Type: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="mailtypeID" id="mailtypeID">
                        <option value="">Select....</option>
                        <?php echo $GoRow ?>
                        </select> 
                    </div>
             </div>         

             <div class="form-group">
                <label class="control-label col-lg-4">Quantity</label>
                <div class="col-lg-8">
                    <input name="quantity" type="text" 
                           class="form-control" required>
                </div>
              </div>

                <div class="form-group">
                 <label class="control-label col-lg-4">Due Date</label>
                <div class="col-lg-8"> 
                    <input name="duedate" type="date" 
                           class="form-control" required>
                    <span class="error_message" style="color: red"><?php echo $validation_duedate ?></span>
                </div>
                </div>



            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button name="addreceivedmail" type="submit" onclick="return confirm('Are you sure?')" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Add Received Mails
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
</body>
</html>


