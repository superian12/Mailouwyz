<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);



$userID = $_SESSION['userid'];
 



 $sqlGetRTS ="SELECT RTSID, RTSname FROM rtscode";

$queryRTS = $conn->query($sqlGetRTS) or die(mysqli_error($conn));
$RTSRow = "";
    while ($row = mysqli_fetch_array($queryRTS))
    {
        $RTSID = $row["RTSID"];
        $RTSname = $row["RTSname"];
        
        $RTSRow =$RTSRow."<option value='$RTSID'> $RTSname</option>";
    }


    $sqlGetBatch = "SELECT r.ReceivedMailID, mt.mailtypename , year(duedate) as m_y ,day(duedate) as m_d , month(duedate) as m_m FROM ReceivedMails r 
    INNER JOIN mailtypes mt ON  r.mailtypeID=mt.mailtypeID
    WHERE status ='Active' ";
    $queryBatch = $conn->query($sqlGetBatch) or die (mysqli_error($conn));
    $GoBatch = "";
    while ($row = mysqli_fetch_array($queryBatch))
    {
        $rowReceivedMailID = $row['ReceivedMailID'];
        //$duedate = $row['duedate'];
        $mailkind = $row['mailtypename'];
        $date = completeStringDate($row['m_m'],$row['m_y'],$row['m_d']);
        $GoBatch = $GoBatch."<option value ='$rowReceivedMailID'>$rowReceivedMailID - $mailkind - $date  </option>";
    }




 $sqlGetAccount ="SELECT AccountNo, firstname, lastname  FROM accounts";

$queryAccount = $conn->query($sqlGetAccount) or die(mysqli_error($conn));
$AccountRow = "";   
    while ($row = mysqli_fetch_array($queryAccount))
    {
        $AccountNo = $row["AccountNo"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $fullName= $lastname.','.$firstname;
        $AccountRow = $AccountRow . "<option value='$AccountNo'>$AccountNo - $fullName</option>";
    }



    

    if (isset($_POST['addMail']))
    { 
        $validation_errors = '';

        $mailNo = mysqli_real_escape_string($conn,$_POST['mailNo']);

        $AccountNo = mysqli_real_escape_string($conn, $_POST['accountNo']);
        $filter = (int) filter_var($AccountNo, FILTER_SANITIZE_NUMBER_INT);
        $ReceivedMailID = mysqli_real_escape_string($conn, $_POST['batch']);
        $select_mailtype = "SELECT mailtypeID from ReceivedMails where ReceivedMailID = $ReceivedMailID";
        $query_select_mailtype =$conn->query($select_mailtype) or die (mysqli_error($conn));
        while ($row = mysqli_fetch_array($query_select_mailtype))
        {
       $mailtype = $row['mailtypeID'];
        }
        
        #VALIDATE

        $validate_mailNo = "SELECT * FROM MAILS WHERE mailNo = ".$mailNo;
        $get_validate_mailNo = $conn->query($validate_mailNo) or die (mysqli_error($conn));
        if(mysqli_num_rows($get_validate_mailNo) >=1){
            $validation_errors++;
            echo"<script>alert('Mail number already exist')</script>";
        }
        $validate_quantity = "SELECT (SELECT count(*) FROM mails m where m.mailStatus !=6 and m.receivedmailID =$ReceivedMailID) as count, (SELECT rm.quantity FROM receivedmails rm where rm.receivedmailID = $ReceivedMailID) as ttl";
        $query_validate=$conn->query($validate_quantity) or die (mysqli_error($conn));
        while($row = mysqli_fetch_array($query_validate))
        {
            $total = $row['count'];
            $rm_quantity = $row['ttl'];
        }
        if($total == $rm_quantity){
            $validation_errors++;
              echo"<script>alert('Mail already exceeded batch quantity')</script>";
        }


        
        


        if($validation_errors ==0 ){
        $insert = "INSERT  into mails (mailNo, accountNo, mailStatus, mailtypeID ,encoder,messenger,ReceivedMailID) VALUES ($mailNo,$filter, 1, $mailtype ,$userID, $userID,$ReceivedMailID) ";
         $conn->query($insert) or die(mysqli_error($conn));

         header('location:viewmail2.php');
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
        <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
        <script
          src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
          crossorigin="anonymous"></script>
        <script src="semantic/dist/semantic.min.js"></script>
       
    </head>
    <body>
        <?php
        
            include('topmenu3.php');

        ?> 

            <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Add Mail</i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    

                <div class="form-group">
                        <label class="control-label col-lg-4">Mail No.: </label>
                        <div class="col-lg-8">
                            <input name="mailNo" type="text" 
                                class="form-control" maxlength="100" required>   
                                       
                        </div>
                    </div>


                   <div class="form-group">
                        <label class="control-label col-lg-4">Account Number</label>
                        <div class="col-lg-8">  
                <input type="text" name="accountNo" id="accountNo" class="form-control" placeholder="Enter accountNo Name" />  
                <div id="account_number"></div>  
                </div>
                </div>

                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Receive Mail ID</label>
                        <div class="col-lg-8">
                             <select name="batch" class="form-control" required>
                            <option value="">Select one...</option>
                            <?php echo $GoBatch; ?>
                            </select>
                        </div>
                    </div>


                  <div class="form-group">
                        <div class="col-lg-8">
                            <a href="viewmail2.php" class="btn btn-danger btn-sm pull-left" role="button"> Go Back </a>
                        </div>
                        <div class="col-12">
                            <button name="addMail" type="submit" class="btn btn-success btn-sm pull-right" onclick="return confirm('Are you sure?');"> 
                                <i class="fa fa-plus"></i> Add Mail
                            </button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>

    </body> 
</html>
<script>  
 $(document).ready(function(){  
      $('#accountNo').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"search.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#account_number').fadeIn();  
                          $('#account_number').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  
           $('#accountNo').val($(this).text());  
           $('#account_number').fadeOut();  
      });  
 });  
 </script>  