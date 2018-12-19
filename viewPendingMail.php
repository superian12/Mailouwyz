 <?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
                
   $sql_view="SELECT m.mailNo , ac.accountNo , rm.dueDate, mt.mailtypename, a.areaname ,rm.receivedmailID FROM mails m 
   INNER JOIN accounts ac ON m.accountNo = ac.accountNo 
   INNER JOIN area a ON a.areaid = ac.areaid
   INNER JOIN receivedmails rm ON m.receivedmailID = rm.receivedmailID
   INNER JOIN mailtypes mt ON m.mailtypeID = mt.mailtypeID
   INNER JOIN mailstatus ms ON m.mailtypeID = ms.statusID
   where m.mailStatus =1 and rm.status ='Active'";
    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));
?>
        <title>View Mails</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    </head>
    <body>
        <?php
            include('topmenu2.php');
        ?> 
    <div class="container">
        <div class="col-lg-offset-2 col-lg-8 ">
            <h1 class="text-center"><i class="fa fa-list"></i> Pending Mails</h1>
                <form method = "POST" class="form-horizontal well" >
                <!--<div class=" col-lg-12">
                            <a href ="addMail.php" class="btn btn-success btn-xs pull-right"> <i class ="fa fa-plus"> </i> Addmail </a>

                        </div>-->
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>Mail Number</th>
                        <th>Account Number</th>
                        <th>Mail Type</th>
                        <th>Due Date</th>
                        <th>Area</th>
                        <th>Batch #</th>
             </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($result_view))
                        {
                                $mailNo =$row['mailNo'];
                                $accountNo=$row['accountNo'];; 
                                $mailtypeID=$row['mailtypename'];
                                $dueDate = $row['dueDate'];
                                $mailtypename = $row['mailtypename'];
                                $description = $row['areaname'];
                                $batch=$row['receivedmailID'];
                                echo"
                                <tr>
                                    <td>". $mailNo. "</td>
                                    <td>". $accountNo. "</td>
                                    <td>".$mailtypename."</td>
                                    <td>".$dueDate."</td>
                                    <td>".$description."</td>
                                    <td>".$batch."</td>

                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>Mail Number</th>
                        <th>Account Number</th>
                        <th>Due Date</th>
                        <th>Mail Type</th>
                        <th>Area</th>
                        <th>Batch #</th>
                        </tr>
                    </tfoot>

                    </table>
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