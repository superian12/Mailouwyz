<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);

       $get_all_performance = "SELECT m.messenger, u.firstname, u.lastname , count(*) as reports, AVG(pa.quest1) as total_1 , AVG (pa.quest2) as total_2 , AVG(pa.quest3) as total_3 from performanceassessments pa  INNER JOIN mails m ON m.mailNo = pa.mailNo INNER JOIN users u ON u.userid = m.messenger group by  m.messenger";
    $query_get_all_performance = $conn-> query($get_all_performance) or die (myqli_error($conn));
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Performance Assesment    </title>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
    <style type="text/css">
        #wrapper{
            /*display: grid;
            grid-template-columns: 1fr 8fr ;
            */
            margin-top: 100px;
            margin-right:100px;
            margin-left: 100px;
         }
    </style>
    </head>
    <body>
        <?php
            include('topmenu.php');
        ?> 
            <div class="container">
        <div class="col-lg-offset-2 col-lg-9">
             <h3 align="center">View Performance Assesment Report</h3>
                <form class="form-horizontal well">
               
       
        
            
                <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Messenger</th>
                        <th>Average Rating 1</th>
                        <th>Average Rating 2</th>
                        <th>Average Rating 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row=mysqli_fetch_array($query_get_all_performance)) {
                                $messenger_id = $row['messenger'];
                                $messenger_name = $row['lastname'].', '.$row['firstname'];
                                $reports = $row['reports'];
                                $total_1= $row['total_1'];
                                $total_2= $row['total_2'];
                                $total_3= $row['total_3'];

                                echo "<tr>
                                        <td><a href='generatepar2.php?m=".$messenger_id."' class='btn btn-xs btn-info'><i class='fa fa-pencil-square-o'></i></td>
                                        <td>$messenger_name</td>
                                        <td>$total_1</td>
                                        <td>$total_2</td>
                                        <td>$total_3</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
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