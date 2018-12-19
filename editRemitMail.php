<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
     




if(isset($_REQUEST['mailNo']))
{

    $sql_view="  SELECT  m.mailNo, ac.firstname, ac.lastname, m.relation, m.dateTimeDelivered, m.mailStatus, r.RTSname, mt.mailtypeName, m.dateTimePulledOut , m.mailref
        FROM mails m 
        INNER JOIN accounts ac on ac.accountNo=m.accountNo 
        INNER JOIN rtscode r on r.RTSID=m.RTSID 
        INNER JOIN mailtypes mt ON mt.mailtypeID=m.mailtypeID 
        WHERE m.mailNo= ".$_REQUEST['mailNo'];

    $queryGo = $conn->query($sql_view);



        while ($row= mysqli_fetch_array($queryGo))
        {
            $mailNo =$row['mailNo'];
            $mailref=$row['mailref'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $Relation = $row['relation'];
            $DateTimeDelivered =$row['dateTimeDelivered'];
            $mailStatus = $row['mailStatus'];
            $RTSname =$row['RTSname'];
            $mailtypeName =$row['mailtypeName'];
            $DateTimePulledOut =$row['dateTimePulledOut'];
            $fullName= $lastname.','.$firstname;

        
        }
     // CHOICES

        $sql_selectRts = "SELECT RTSID,RTSname,rtscode FROM RTScode";
        $query_SelectRts = $conn->query($sql_selectRts) or die (mysqli_error($conn));
        $select_rts = "";
        while($row =mysqli_fetch_array($query_SelectRts))
        {
            $id = $row['RTSID'];
            $code =$row['rtscode'];
            $name =$row['RTSname'];
            $select_rts= $select_rts. "<option value='$id'> $code $name </option> ";
        }
        if(isset($_POST['submit']))
        {
            $Remittance = mysqli_real_escape_string($conn, $_POST['Remittance']);

            $sql_edit="UPDATE mails set     RTSID = $Remittance , mailStatus ='5' ,dateTimeDelivered =NOW() where mailNo=".$_REQUEST ['mailNo'] ;



            $conn->query($sql_edit) or die(mysqli_error($conn));
            echo"<script type='text/javascript'>
            alert('Successfuly Remitted !');
            location='viewmail3.php';
            </script>";

        }
    


}
else
{
    header('location:viewmail3.php');
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
include('topmenu4.php');

?>
<div class="container">
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class=""> Remit Mail <?php echo $_REQUEST['mailNo']?> </i>
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
                <label class="control-label col-lg-4">Remittance:</label>
                <div class="col-lg-8">
                      <select name="Remittance" class="form-control"  required>
                            <option>Select ......</option>
                            <?php echo $select_rts?>
                            </select>
                </div>
            </div>




            <div class="form-group">
            <div class="col-lg-4">
                    <a href="viewmail3.php" type="button" class="btn btn-warning btn-lg " > Go back </a>
                </div>
                <div class="col-lg-8">
                    <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Remit Mail
                    </button>
                </div>
            </div>
        </form>



</body>

</html>
