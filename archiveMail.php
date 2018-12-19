
<?php 
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);

if(isset($_REQUEST['mailNo']))
        {   

             
            
            $sql_view=" SELECT  m.mailNo, m.accountNo ,ac.firstname , ac.lastname,m.receivedmailID ,mt.mailtypeName 
                FROM mails m 
                INNER JOIN accounts ac on m.accountNo =ac.accountNo
                INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID 
                INNER JOIN receivedmails rm ON m.receivedmailID = rm.receivedmailID
                WHERE m.mailNo=".$_REQUEST['mailNo'];

             $queryGo = $conn->query($sql_view);

            if (mysqli_num_rows($queryGo) > 0)
            {

            while ($row= mysqli_fetch_array($queryGo))
                {
                    $account_number = $row['accountNo'];
                    $batch_id = $row['receivedmailID'];
                    $batch_det = $batch_id. " - ".$row['mailtypeName'];
                    $mailtype = $row['mailtypeName'];
                    $account_name = $account_number.' - '.$row['lastname'].', '.$row['firstname'];
                }
            }
            if(isset($_POST['submit']))
                {
            

                 $sql_archive="UPDATE mails set mailstatus = 6 where mailno=".$_REQUEST['mailNo'];



                 $conn->query($sql_archive) or die(mysqli_error($conn));
                 // AUDIT     

 
                header('location:viewmail2.php');
                }
            
         }

         else
         {
            header('location: QarchiveMail.php');
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
            include('topmenu3.php');
         print "archive Mail";
        ?>           <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Delete Mail #  <?php echo $_REQUEST['mailNo'] ?></i>
                </h1>
                <form method="POST" class="form-horizontal well">


                    <div class="form-group">
                        <label class="control-label col-lg-4">Account Holder's  Name</label>
                        <div class="col-lg-8">
                             <input name="accountNo" type="number"
                           class="form-control"  value="<?php echo $account_number?>" disabled>
                        </div>
                    </div>

            


                       <div class="form-group">
                        <label class="control-label col-lg-4">Batch ID</label>
                        <div class="col-lg-8">
                                 <input name="accountNo" type="number"
                               class="form-control"  value="<?php echo $batch_id?>" disabled>
                        </div>
                        </div>


                  <div class="form-group">
                        <div class="col-lg-6">
                            <a href="viewmail2.php" class="btn btn-danger btn-lg pull-left "  role="button"> Go Back </a>
                        </div>
                        <div class="col-7">
                            <button name="submit" type="submit" class="btn btn-success btn-lg pull-right" onclick="return confirm('Are you sure you want to edit?');">
                                <i class="fa fa-plus"></i> Confirm
                            </button>
                        </div>
                    </div>


                </form>
                </div>
                </div>
    </body> 
</html>