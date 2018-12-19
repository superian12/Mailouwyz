<?php 


    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);





    if(isset($_REQUEST['mailNo']))
            {
        /* GET VALUE */


                $sql_view=" SELECT  m.mailNo, m.accountNo ,ac.firstname , ac.lastname,m.receivedmailID ,mt.mailtypeName 
                FROM mails m 
                INNER JOIN accounts ac on m.accountNo =ac.accountNo
                INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID 
                INNER JOIN receivedmails rm ON m.receivedmailID = rm.receivedmailID
                WHERE m.mailNo=".$_REQUEST['mailNo'];

                 $queryGo = $conn->query($sql_view) or die (mysqli_error($conn));

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
                // CHOICES
            


                    $get_batch = "SELECT rm.receivedmailID , mt.mailtypeName from receivedmails rm 
                    INNER JOIN mailtypes mt on mt.mailtypeID = rm.mailtypeID where rm.status = 'active' AND rm.receivedmailID !=".$batch_id;
                    $query_get_batch = $conn-> query($get_batch) or die (mysqli_error($conn));
                    $choice_batch = '';
                    while ($row = mysqli_fetch_array($query_get_batch)) {
                        $choice_batch_number =$row['receivedmailID'];
                        $choice_batch_full_det = $row['receivedmailID']." - ".$row['mailtypeName'];
                        $choice_batch = $choice_batch. "<option value='".$choice_batch_number."'>".$choice_batch_full_det."</option>";
                    }
             

 
                if(isset($_POST['submit']))
                    {   

                        $accountNo = mysqli_real_escape_string($conn, $_POST['accountNo']);
                        $receivedmailID = mysqli_real_escape_string($conn, $_POST['receivedmailID']);

                        // Validation

                        

                        $sql_edit="UPDATE Mails set accountNo = $accountNo , receivedmailID = $receivedmailID where mailNo=".$_REQUEST ['mailNo'] ;

                        $conn->query($sql_edit) or die(mysqli_error($conn));

                        

            
                        header('location: viewmail2.php');

                    }
                }
            
            }
       

            ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       
    </head>
    <body>
        <?php
            include('topmenu3.php'); 
        ?>
              <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Edit Mail #  <?php echo $_REQUEST['mailNo'] ?></i>
                </h1>
                <form method="POST" class="form-horizontal well">


                    <div class="form-group">
                        <label class="control-label col-lg-4">Account Number</label>
                        <div class="col-lg-8">
                            <input name="accountNo" type="number" class="form-control"   value="<?php echo $account_number ?>" required>
                        </div>
                    </div>

            


                       <div class="form-group">
                        <label class="control-label col-lg-4">Batch ID</label>
                        <div class="col-lg-8">
                            <select class="form-control" name="receivedmailID" id="receivedmailID">
                                <option value=<?php echo$batch_id ?>> <?php echo $batch_det?></option>
                                <?php echo $choice_batch ?>
                            </select> 
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
                   
                      
    </body> 

</html>
