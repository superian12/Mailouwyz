<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);




   $sql_view="SELECT m.mailNo, ac.accountNo, a.areaName , mt.mailtypeName , rm.dueDate ,ms.description  FROM mails m 
                    INNER JOIN accounts ac ON m.accountNo = ac.accountNo
                    INNER JOIN mailtypes mt ON m.mailtypeID = mt.mailtypeID
                    INNER JOIN mailstatus ms ON m.mailStatus = ms.statusID
                    INNER JOIN receivedmails rm ON m.receivedmailID = rm.receivedmailID
                    INNER JOIN area a ON ac.areaID = a.areaID
                    INNER JOIN areaassignment ar ON a.areaID = ar.areaID
                     WHERE m.mailStatus = 1 and ar.userid = ". $_SESSION['messenger_pull'];




    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));

    if(!isset($_SESSION['messenger_pull']))
    {
        header('location:pulloutrequest.php');
    }


    if(isset($_POST['submit'])){

        if (empty($_POST['mail_id'])) {
            echo"<script>alert('Please select a mail')</script>";
        }   
       
        
        else{
            date_default_timezone_set('Asia/Manila');
            $dateFilled = date('Y/m/d H:i:s');
            $checkbox = $_POST['mail_id'];
            for($i=0;$i<count($checkbox);$i++){
            $del_id = $checkbox[$i];
            $sql = "UPDATE mails  SET mailStatus = 2, messenger = ".$_SESSION['messenger_pull']." , dateTimePulledOut = '$dateFilled' WHERE mailNo=".$del_id;
            $conn->query($sql) or die(mysqli_error($conn));
                header('location:messengerpull.php');
            }
        }

    }
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>View Mails</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>
    <body>
        <?php
            include('topmenu2.php');
         print "View Mail";
        ?> 
    <div class="container">
        <div class="col-lg-offset-2 col-lg-8 ">
            <h1 class="text-center"><i class="fa fa-list"></i> Pull Mails</h1>
                <form method = "POST" class="form-horizontal well" >
                <!--<div class=" col-lg-12">
                            <a href ="addMail.php" class="btn btn-success btn-xs pull-right"> <i class ="fa fa-plus"> </i> Addmail </a>

                        </div>-->

                <table id="posts" class="table table-hover">
                    <thead>
                        <tr class="header">
            
                        <th>Mail No</th>
                        <th>Account Name</th>
                        <th>MailType</th>
                        <th>Area</th>
                        <th>Deadline</th>
                        <th>Pull</th>
                    
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $accountNo=$row['accountNo'];; 
                                $mailtypeID=$row['mailtypeName'];

                                
                                   $deadline = $row['dueDate'];
                                   $areaName = $row['areaName'];
                                echo"
                                <tr>
                                    
                                    
                                    <td>". $mailNo. "</td>
                                    <td>". $accountNo. "</td>
                                    <td>". $mailtypeID. "</td>
                                    <td>".$areaName."</td>
                                    <td>".$deadline."</td>
                                    <td><input type='checkbox' name ='mail_id[]'  value='".$mailNo."'></td>
                                 
                                </tr>
                                    ";
                        }   
?>

                    </tbody>

                    <tfoot>
                        <tr>

                        
                        <th>Mail No</th>
                        <th>Account Name</th>
                        <th>MailType</th>
                        <th>Area</th>
                        <th>Deadline</th>
                        <th>Pull</th>
                        
                                           
                        </tr>

                    </tfoot>



                    </table>
                    <div align="center">
                      <button name="submit" type="submit" class="btn btn-success btn-lg">
                                <i class="fa fa-plus"></i> Pull Mails
                            </button>
                       </div>
                    <br>
                    </form>
                    <a href="viewaccount.php" type="button" class=" btn btn-warning pull-left" id="btn_pull">Go Back </a>


                   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
                    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

                    <script>
                        $(document).ready(function() {
                        $('#posts').DataTable();
                    } );
                    </script>
                    
                </div>
          </div>
        

    </body> 
</html>