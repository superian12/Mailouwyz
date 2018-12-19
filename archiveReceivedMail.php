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


            if(isset($_POST['addreceivedmail']))
                    {
               

            $sql_edit = "UPDATE receivedMails SET status = 'Inactive'
                        WHERE receivedmailID = ".$_REQUEST['receivedmailID'];
                         $conn->query($sql_edit) or die(mysqli_error($conn));
            $edit_calendar = "DELETE FROM calendar where receivedmailID = ".$_REQUEST['receivedmailID'];
            $conn->query($edit_calendar) or die(mysqli_error($conn));
                        header('location:receivedmail.php');
                    }
                
            
            }
            else
            {
               header('location:receivedMail.php');
            }

            
?>


<!DOCTYPE html>

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
            <i class="fa fa-user-circle" > Archive Received Mail <?php echo $_REQUEST['receivedmailID']; ?></i>
        </h1>


        <form action ="" method ="post" class="form-horizontal well">
         <div class="form-group">
                
            
           <div class="form-group">
                <label class="control-label col-lg-4">Mail Type: </label>
                    <div class="col-lg-8">
                        <select name="mailtype" class="form-control"  disabled>
                            <option value=<?php echo$existingmtID ?>> <?php echo $existingmt?></option>
                            <?php echo $mtrow ?>
                            </select>
                    </div>
             </div>         

             <div class="form-group">
                <label class="control-label col-lg-4">Quantity</label>
                <div class="col-lg-8">
                    <input name="quantity" type="text"
                           class="form-control" value="<?php echo $existquantity ?>" disabled>
                </div>
              </div>


                <label class="control-label col-lg-4">Due Date</label>
                <div class="col-lg-8">
                    <input name="duedate" type="date" value=<?php echo$existduedate ?>
                           class="form-control" disabled>
                </div>
                </div>




            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button name="addreceivedmail" type="submit" onclick="return confirm('Are you sure?')" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Archive
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>


