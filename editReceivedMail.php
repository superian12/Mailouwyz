<?php

    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
// SELECT System User
    
  


      if(isset($_REQUEST['receivedmailID']))
            {
        /* GET VALUE */
              $sql_view="SELECT r.mailtypeID,r.receivedmailID, u.firstName, u.lastName, mt.mailtypeName, r.quantity, r.dueDate
            FROM receivedmails r INNER JOIN users u on u.userid=r.userid
            INNER JOIN mailtypes mt on mt.mailtypeID=r.mailtypeID 
            WHERE r.status= 'ACTIVE' AND receivedmailID=".$_REQUEST['receivedmailID'];
                 $queryGo = $conn->query($sql_view) or die (mysqli_error($conn));

             while ($row= mysqli_fetch_array($queryGo))
                    {
                        $existingmtID = $row['mailtypeID'];
                        $existingmt = $row['mailtypeName'];
                        $existquantity = $row['quantity'];
                        $existduedate = $row['dueDate'];
                        

                    } 
// CHOICES
          $sql_department = "SELECT mailtypeID,mailtypeName FROM mailtypes WHERE mailtypeID != $existingmtID";
              $query_department = $conn->query($sql_department) or die (mysqli_error($conn));
              
              $mtrow = "";
              if(mysqli_num_rows($query_department) > 0 )
              {
                while ($row = mysqli_fetch_array($query_department)) 
                {
                    $mailtype= $row['mailtypeID'];
                    $mailtypeName=$row['mailtypeName'];
                    $mtrow =$mtrow." <option value='$mailtype'> $mailtypeName</option> ";        
                }
            }

            if(isset($_POST['addreceivedmail']))
                    {
                        $mailtypeName = mysqli_real_escape_string($conn, $_POST['mailtype']);
                        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
                        $duedate = mysqli_real_escape_string($conn, $_POST['duedate']);
                              

            $sql_edit = "UPDATE receivedMails SET mailtypeID ='$mailtypeName' , quantity = '$quantity', duedate = '$duedate'
                        WHERE receivedmailID = ".$_REQUEST['receivedmailID'];
            $edit_mail = "UPDATE MAILS set mailtypeID = $mailtypeName where receivedmailID =".$_REQUEST['receivedmailID'];
            $conn->query($edit_mail) or die(mysqli_error($conn));

                        

                         $conn->query($sql_edit) or die(mysqli_error($conn));
                         $update_calendar= "UPDATE calendar set evedate = '$duedate' WHERE receivedmailID = ".$_REQUEST['receivedmailID'];
                         $conn->query($update_calendar) or die(mysqli_error($conn));
        
                        #AUDIT
                    //add2log('Edit', $_SESSION['userid'],'Received Mail',$_REQUEST['receivedmailID']);
                        header('location:receivedmail.php');

                    }
                
            
            }
            else
            {
               header('location:receivedMail.php');
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
            <i class="fa fa-user-circle" > Edit Received Mail # <?php echo $_REQUEST['receivedmailID']; ?></i>
        </h1>


        <form action ="" method ="post" class="form-horizontal well">
         <div class="form-group">
                
            
           <div class="form-group">
                <label class="control-label col-lg-4">Mail Type: </label>
                    <div class="col-lg-8">
                        <select name="mailtype" class="form-control"  required>
                            <option value=<?php echo$existingmtID ?>> <?php echo $existingmt?></option>
                            <?php echo $mtrow ?>
                            </select>
                    </div>
             </div>         

             <div class="form-group">
                <label class="control-label col-lg-4">Quantity</label>
                <div class="col-lg-8">
                    <input name="quantity" type="text"
                           class="form-control" value="<?php echo $existquantity ?>" required>
                </div>
              </div>


                <label class="control-label col-lg-4">Due Date</label>
                <div class="col-lg-8">
                    <input name="duedate" type="date" value=<?php echo$existduedate ?>
                           class="form-control" required>
                </div>
                </div>



            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button name="addreceivedmail" type="submit" onclick="return confirm('Are you sure?')" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>


