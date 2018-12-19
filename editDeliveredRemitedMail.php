<?php
    include "dbconnect.php";
    include "system_command.php";
    include('smsChikka.php');
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);
if(isset($_REQUEST['mailNo']))
{

    $sql_view="SELECT ac.accountNo, ac.firstname, ac.lastname, m.mailNo, mt.mailtypeName FROM mails m
        INNER JOIN accounts ac ON m.accountNo = ac.accountNo 
        INNER JOIN mailtypes mt ON m.mailtypeID = mt.mailtypeID
        WHERE m.mailNo= ".$_REQUEST['mailNo'];

    $queryGo = $conn->query($sql_view);

    if (mysqli_num_rows($queryGo) > 0)
    {

        while ($row= mysqli_fetch_array($queryGo))
        {
             $accountNo=$row['accountNo'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $mailtypeName = $row['mailtypeName'];
            $fullName= $lastname.','.$firstname;
        
        }

     

            // SMS Code
       //  $messageID = gen_random_string(32);
            if(isset($_POST['submit']))
                {
                    $validation_error='';
                    $dateFilled = date('Y/m/d H:i:s');
                   // $accountNo = mysqli_real_escape_string($conn,$_POST['accountNo']);
                    $Receiver = mysqli_real_escape_string($conn, $_POST['receiver']);
                    $Relation = mysqli_real_escape_string($conn, $_POST['relation']);
                    $PaCode = mt_rand(100000000,999999999);
                    if ($accountNo ==0) {
                        $validation_error++;
                        
                    }
                    if($validation_error == 0)
                    {
                   
                  $message = "Good day! " . $row['firstname']. $row['lastname'] .  "
                  We would like to know your comments and suggestion to our service. To log in your SMS Code is ".$PaCode." For access please see Link .... localhost:ISPROJ2/customer_service/ 
                  -MaiLouwyz Courier ";
                    $get_number = "SELECT ac.mobile FROM mails m INNER JOIN accounts ac ON m.accountNo = ac.accountNo WHERE m.mailNo= ".$_REQUEST['mailNo'];" ";
                    $query_get_number =$conn->query($get_number) or die(mysqli_error($conn));
                    while($row = mysqli_fetch_array($query_get_number))
                    {
                        $mobile_number = $row['mobile'];
                    }

                    sendSMS($mobile_number,$message);
                     $insert_messenger ="UPDATE mails set receiver='$Receiver' , relation='$Relation' , DateTimeDelivered = NOW() ,mailstatus =3 ,mailRef= $PaCode where mailNo=".$_REQUEST ['mailNo'] ;    
                    $conn->query($insert_messenger) or die (mysqli_error($conn));
                    header('location:viewmail3.php?mailNo='.$mailNo);  
                    }
        }

 

            

            

        }
    


}
else
{
    header('location:viewmail3.php');
}





// END 








include('topmenu4.php');

?>

<div class="container">
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class=""> Finalize Mail <?php echo$_REQUEST['mailNo']?> </i>
        </h1>

        <form method="POST" class="form-horizontal well">
            <div class="form-group">
                <label class="control-label col-lg-4">Account Name</label>
                <div class="col-lg-8">
                    <input name="accountName" class="form-control"  id="textInputdisabled" style="text-align:left" value="<?php echo $fullName; ?> " disabled>
                    </input>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Mail Type</label>
                <div class="col-lg-8">
                    <input name="mailtypeName" class="form-control" id="disabled" style="text-align:left" value=" <?php echo $mailtypeName; ?> " disabled>
                    </input>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Receiver</label>
                <div class="col-lg-8">
                    <input name="receiver" type="text"
                           class="form-control" maxlength="100"  required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Relation</label>
                <div class="col-lg-8">
                    <input name="relation" type="text"
                           class="form-control" maxlength="30"  >
                </div>
            </div>







            <div class="form-group">

                <div class="col-lg-4">
                    <a href="viewmail3.php" type="button" class="btn btn-warning btn-lg " > Go back </a>
                </div>
                <div class="col-lg-8">
                    <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Update Mail
                    </button>
                </div>
            </div>
        </form>



</body>

</html>
