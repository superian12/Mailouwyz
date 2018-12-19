
<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
          


    $sql_view="SELECT r.receivedmailID, u.firstname, u.lastname, m.mailtypeName, r.quantity, r.dueDate
            FROM receivedmails r INNER JOIN users u on u.userid=r.userid
            INNER JOIN mailtypes m on m.mailtypeID=r.mailtypeID where status !='Inactive'";
    $result_view =$conn->query($sql_view) or die (mysqli_error($conn));


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
        <div class="col-lg-12">
    
        <h3 class="text-center"><i class="fa fa-list"></i>Received Mails</h3>
                <form class="form-horizontal well">
                <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Report</th>
                        <th>Batch ID</th>
                    <th>Received By</th>
                    <th>Mail Type</th>
                    <th>Quantity</th>
                    <th>Due Date</th>


                </tr>

                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_array($result_view))
                {
                    $receivedmailID =$row['receivedmailID'];
                    $firstname= $row['firstname'];
                    $lastname= $row['lastname'];
                    $mailtypeName=$row['mailtypeName'];
                    $quantity=$row['quantity'];
                    $dueDate=$row['dueDate'];
                    $fullName = $firstname . ','. $lastname ;


                    echo"
                                <tr>
                                    <td><a href ='reports/chart.php?batchNo=".$receivedmailID."' target='_blank' class='btn btn-info btn-xs'><i class='fa fa-pencil-square-o'></i></td>
                                    <td>". $receivedmailID. "</td>
                                    <td>". $fullName. "</td>
                                    <td>". $mailtypeName. "</td>
                                    <td>". $quantity. "</td>
                                    <td>". $dueDate. "</td>
                                    
            
                                
                                 </tr>
                                    ";

                }


                ?>

                </tbody>

                <tfoot>
                <tr>
                    <th>Report</th>
                    <th>Batch ID</th>
                    <th>Received By</th>
                    <th>Mail Type</th>
                    <th>Quantity</th>
                    <th>Due Date</th>



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
                        $('#posts').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                               'print', 'pdf', 'copy'
                            ]
                        } );
                    } );
                    </script>
                    </form>
                    </div>
                    </div>
    </body> 
</html>