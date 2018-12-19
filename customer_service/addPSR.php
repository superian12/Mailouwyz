<?php
    include "../dbconnect.php";
    include"../system_command.php";


    session_start();

 if(!isset($_SESSION['mailNo']))
 {
 header('location:index.php');
}
    $selectMessenger = "SELECT u.lastname, u.firstname  , u.userid FROM users u INNER JOIN mails m on u.userid = m.messenger
    WHERE m.mailno =".$_SESSION['mailNo'];
    $messengerQuery = $conn->query($selectMessenger) or die (mysqli_error($conn));
    while($row=mysqli_fetch_array($messengerQuery))
    {
        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $fullname = $lastname.', '.$firstname;
        $userid= $row['userid'];
    }


    $selectAccount = "SELECT a.accountNo , a.firstname, a.lastname  from accounts a inner join mails m ON m.accountNo = a.accountNo where m.mailNo =".$_SESSION['mailNo'];
    $AccountQuery = $conn->query($selectAccount) or die (mysqli_error($conn));
    while($row = mysqli_fetch_array($AccountQuery))
    {
        $accountNumber = $row['accountNo'];
        $accountFirstName = $row['firstname'];
        $accountLastName = $row['lastname'];
    }
            if(isset($_POST['submit'])){
                date_default_timezone_set('Asia/Manila');
                $dateFilled = date('Y/m/d H:i:s');
                $quest1 = mysqli_real_escape_string($conn , $_POST['quest1']);
                $quest2 = mysqli_real_escape_string($conn , $_POST['quest2']);
                $quest3 = mysqli_real_escape_string($conn , $_POST['quest3']);
                $remarks = mysqli_real_escape_string($conn , $_POST['quest4']);
                $recommendations= mysqli_real_escape_string($conn , $_POST['quest5']);

                if($quest1 <= 2 || $quest2 <=2 || $quest3 <=2){
                     $mail_number=$_SESSION['mailNo'];
                    $messenger= $fullname;
                    $message= "
                    Performance Assessment Alert<br/>
        
                    One of the messengers have received a lowest perfomance rating.
                    Mr.$fullname  <br/>
                    Submitted By; $accountLastName, $accountFirstName.<br/>
                    Referrence: Mail number $mail_number date time: $dateFilled

                    <br/><br/>
                    Thank you for your continues support for Mailouwyz System
                   
            ";

                    $get_email = "SELECT u.email FROM users u where u.departmentID = 2";
                    $query_get_email = $conn->query($get_email) or die(mysqli_error($conn));
                    while ($row = mysqli_fetch_array($query_get_email)) {
                    $receiver = $row['email'];

                        sendEmail($receiver,'Performance Asssesment Notice',$message);  
                        
                    }

                   

 

               
                }

                $sql_addArea = "INSERT INTO performanceassessments (mailNo, dateFilled, accountNo, quest1, quest2, quest3, remarks, recommendation) VALUES (".$_SESSION['mailNo'].", '$dateFilled', $accountNumber, '$quest1', '$quest2', '$quest3', '$remarks', '$recommendations')";
                
                $addQuery =  $conn->query($sql_addArea) or die (mysqli_error($conn));
                $update_mails = "UPDATE mails SET paStatus = 1 WHERE mailNo =".$_SESSION['mailNo'];
                $conn->query($update_mails) or die(mysqli_error($conn));
               

                header('location:index.php');       
            }
?>
<!DOCTYPE html>

<html>
   <head>
    <title>Performance Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
    <h2 style="color:white;">Mailouyz Custumer Service</h2>

</nav>
</div>

         <div class="container">
            <div class="col-lg-offset-2 col-lg-8" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Messenger Performance Task   </i>
                </h1>   
                <form method="POST" class="form-horizontal well">
                    

                   <div class="form-group">
                    <div class="col-lg-offset-2">
                        <h2>Messenger: <?php echo $fullname; ?></h2>
                       
                    </div>
                    </div>
                    
                    

                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Account No: </label>
                        <?php echo $accountNumber ?>
                    </div>


            <p>Please mark 5, as exellent and 1, as the worst</p>
            <br>


            <div class="form-group">
                        <label class="col-sm-10 col-form-label" >The courier was friendly and helpful</label>
                        <div class="col-lg-8">
                            <input type = "radio" name = "quest1" value = "1"> 1
                            <input type = "radio" name = "quest1" value = "2"> 2
                            <input type = "radio" name = "quest1" value = "3"> 3
                            <input type = "radio" name = "quest1" value = "4 ">4
                            <input type = "radio" name = "quest1" value = "5"> 5
                    </div>
                </div>

                <div class="form-group">
                        <label class="col-sm-12 col-form-label">The courier provided me with the correct documentation for the mails delivered</label>
                        <div class="col-lg-8">
                            <input type = "radio" name = "quest2" value = "1"> 1
                            <input type = "radio" name = "quest2" value = "2"> 2
                            <input type = "radio" name = "quest2" value = "3"> 3
                            <input type = "radio" name = "quest2" value = "4 ">4
                            <input type = "radio" name = "quest2" value = "5"> 5
                    </div>
                </div> 

                <div class="form-group">
                        <label class="col-sm-12 col-form-label" >The mail arrived in full and were undammaged</label>
                        <div class="col-lg-8">
                            <input type = "radio" name = "quest3" value = "1"> 1
                            <input type = "radio" name = "quest3" value = "2"> 2
                            <input type = "radio" name = "quest3" value = "3"> 3
                            <input type = "radio" name = "quest3" value = "4 ">4
                            <input type = "radio" name = "quest3" value = "5"> 5
                    </div>
                </div> 

                <p>Please answer the following questions.</p>

                 

                <div class="form-group">
                        <label class="col-sm-12 col-form-label" >Would you change anything about us to improve the services you receive? </label>
                        <div class="col-lg-8">
                            <input name="quest4" type="text"
                                class="form-control" maxlength="300"  style="height:150px; width:500px; " required>
                    </div>
                </div>

                <div class="form-group">
                        <label class="col-sm-12 col-form-label" >Would you consider recommending our shipping / courier service? </label>
                        <div class="col-lg-8">
                            <input name="quest5" type="text"
                                class="form-control" maxlength="300"  style="height:150px; width:500px;" required>
                    </div>
                </div>


                  <div class="form-group">
                        <div class="col-sm-12 col-form-label">
                            <button name="submit" type="submit" class="btn btn-success btn-lg " onclick="return confirm('Survey will be added thank you for answering!')">
                                <i class="fa fa-plus"></i> Send Survey
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
    </body> 
</html>