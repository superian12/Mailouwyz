<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '3';
    session_start();
    validateAccess($sessionDepartment);



    $sql_view="SELECT mailNo, accountNo , mt.mailtypeName,r.receivedmailID, ms.description, r.duedate, mailstatus From mails m INNER JOIN mailtypes mt ON m.mailtypeID = mt.mailtypeID INNER JOIN mailStatus ms ON m.mailStatus= ms.statusID INNER JOIN receivedmails r ON m.receivedmailID=r.receivedmailID
    WHERE m.mailStatus= 1";
    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));

    $array_batch = "SELECT receivedmailID FROM receivedmails ";
    $get_array_batch = $conn->query($array_batch) or die (mysqli_error($conn));
    $option='';


    if(isset($_POST['submit'])){

        if (empty($_POST['mail_id'])) {
            echo"<script>alert('Please select a mail')</script>";
        }   
       
           else{
            $checkbox = $_POST['mail_id'];
           for($i=0;$i<count($checkbox);$i++){
            $del_id = $checkbox[$i];
            $sql = "UPDATE mails set mailStatus= 6 where mailNo=".$del_id;
            $conn->query($sql) or die(mysqli_error($conn));
            header('location:viewMail2.php');




    
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
    <style type="text/css">
      
        #main
        {
            boar
            margin-right: 50px
        }
        #side{
            margin: 20px;
        }
    </style>
    </head>
    <body>
        <?php
            include('topmenu3.php');
        ?> 

<h1 class="text-center "><i class="fa fa-list"></i>View Pending Mails</h1> 


        
         <div class="container">
        <div class="col-lg-offset-1 col-lg-7">
           
                <form class="form-horizontal well" method="POST">
                 <div class=" col-lg-12">

                        <button name="submit" type="submit" class="btn btn-danger pull-right btn-sm" onclick="return confirm('Are you sure you want to archive the mails?');">
                                <i class="fa fa-minus"></i> Archive Mail
                            </button> 

                            <a href ="addMail.php" class="btn btn-success btn-sm "> <i class ="fa fa-plus">  &nbsp; </i> Add Mail </a>  &nbsp;

                
                        </div>
                         <br/>
                        <br/>
                <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      
                    <thead>
                        <tr>
                        <th>MailNo</th>
                        <th>Account No.</th>

                        <th>Batch No</th>
                        <th>Due Date</th>
                        <th>Mail Status</th>
                        <th>Edit Mail</th>
                        <th>Delete</th>
                        
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $accountNo=$row['accountNo'];
                                $mailtypeName = $row['mailtypeName'];
                                $status=$row['description'];
                                $receivedmailID=$row['receivedmailID'];
                                $duedate=$row['duedate'];

                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $accountNo. "</td>
                                     <td>".$row['receivedmailID']."</td>
                                     <td>". $duedate. "</td>
                                    <td>". $status. "</td>
                                   
                                     <td><a href='editmail.php?mailNo=". $mailNo. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>

                                     <td><input type='checkbox' name ='mail_id[]'  value='".$mailNo."'></td>

                                    
                                    

                                    </tr>
                                    ";

                        }


?>

                    </tbody>

                    <tfoot>
                        <tr>
                         <th>MailNo</th>
                        <th>Account No.</th>
                        <th>Batch No</th>
                        <th>Mail Status</th>
                        <th>Edit Mail</th>
                        <th>Delete</th>
                        </tr>

                    </tfoot>

                    </table>
<br>
<br>
             

                    </form>
                </div>
                <div class="col-sm-3 well" >
          <h4>List of Unsorted Mails Per Batch</h4>
        <div  style="overflow:scroll; height:400px;">
      
        <?php while ($row = mysqli_fetch_array($get_array_batch)) {
            $id = $row['receivedmailID'];

        $get_unsort = "SELECT (SELECT quantity from receivedmails WHERE receivedmailID = $id) - (select count(*) from mails WHERE receivedmailID = $id and mailstatus!=6 ) as ttl ";
        $query_get_unsort = $conn->query($get_unsort) or die (mysqli_error($conn));
        while($row2 = mysqli_fetch_array($query_get_unsort))
        {

                $unsorted_mails = $row2['ttl'];
                if($unsorted_mails >= 1){
                   $option.="<div class='panel panel-danger'>
                
              <div class='panel-heading'>Batch Mail # ".$id."</div>
              <div class='panel-body'>Unsorted Mails = ".$unsorted_mails."</div>
            </div>";    }
            
            
        }
     



            
        } 

        echo $option
         ?>

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
                    </form>

        </div>
        </div>


    </body> 
</html>