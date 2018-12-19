<?php

include "dbconnect.php";


     
        $sqlGetRTS ="SELECT RTSname , RTSID FROM rtscode where RTSID = 0 ";

        $queryRTS = $conn->query($sqlGetRTS) or die(mysqli_error($conn));
        $RTSRow = "";
        while ($row = mysqli_fetch_array($queryRTS))
        {
            $RTSname = $row['RTSname'];
            $RTSID = $row['RTSID'];
            $RTSRow =$RTSRow."<option value='$RTSID'> $RTSname</option>";
        }


if(isset($_REQUEST['mailNo']))
{



    $sql_view="  SELECT  m.mailNo, ac.accountName, m.relation, m.dateTimeDelivered, m.status, r.RTSname, mt.mailtypeName, m.pulledOutStatus, m.dateTimePulledOut 
        FROM mails m 
        INNER JOIN account ac on ac.accountNo=m.accountNo 
        INNER JOIN rtscode r on r.RTSID=m.RTSID 
        INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID
        WHERE mailno=".$_REQUEST['mailNo'];

    $queryGo = $conn->query($sql_view);

    if (mysqli_num_rows($queryGo) > 0)
    {

        while ($row= mysqli_fetch_array($queryGo))
        {
            $mailNo =$row['mailNo'];
            $accountName = $row['accountName'];
            $Relation = $row['relation'];
            $DateTimeDelivered =$row['dateTimeDelivered'];
            $status = $row['status'];
            $RTSname =$row['RTSname'];
            $mailtypeName =$row['mailtypeName'];
            $PulledOutStatus =$row['pulledOutStatus'];
            $DateTimePulledOut =$row['dateTimePulledOut'];
        }

    





        if(isset($_POST['submit']))
        {
            $mailNo = mysqli_real_escape_string($conn, $_POST['mailNo']);
            $accountNo = mysqli_real_escape_string($conn, $_POST['accountNo']);
            $Receiver = mysqli_real_escape_string($conn, $_POST['receiver']);
            $Relation = mysqli_real_escape_string($conn, $_POST['relation']);
            $RTS = mysqli_real_escape_string($conn, $_POST['RTS']);
            $mailtypeID = mysqli_real_escape_string($conn, $_POST['mailtypeID']);

            $sql_edit="UPDATE mails set accountNo='$accountNo', receiver='$Receiver', relation='$Relation', status='$status', mailtypeID='$mailtypeID',pulledOutStatus, dateTimePulledOut='$DateTimePulledOut'  where mailNo =".$_REQUEST['mailNo'];



            $conn->query($sql_edit) or die(mysqli_error($conn));
            header('location: viewMail3.php');

        }
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
            include('topmenu4.php');
         print "Remit Mail";
        ?> 

<div class="container">
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class=""> Remit Mail</i>
        </h1>

        <form method="POST" class="form-horizontal well">
            <div class="form-group">
                <label class="control-label col-lg-4">Account Name</label>
                <div class="col-lg-8">
                    <input name="accountName" class="form-control"  id="textInputdisabled" style="text-align:left" value="<?php echo $accountName; ?> " disabled>
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
                           class="form-control" maxlength="30"  required>
                </div>
            </div>

             <div class="form-group">
                <label class="control-label col-lg-4">Remittance Code</label>
                <div class="col-lg-8">
                    <select name="RTS" class="form-control" required>
                            <option value="">Select one...</option>
                            <?php echo $RTSRow; ?>
                    </select>
                </div>
            </div>



            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Remit Mail
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body> 
</html>