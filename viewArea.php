<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);





    $queryView = "SELECT areaID, areaName, InUse FROM area WHERE status ='Active'";
    $sqlView = $conn->query($queryView) or die (mysqli_error($conn));


?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>View Area</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        
    </head>
    <body>
        <?php
            include('topmenu2.php');

   

                       if(mysqli_num_rows($sqlView) <=0)
                    {

                        echo"
                        <script type='text/javascript'>
                        alert('There are no Mails');
                        location='ophead.php';
                        </script>
                        ";
                   }




        ?>

         <div class="container">
        <div class="col-lg-offset-3 col-lg-6">
            <h1 class="text-center"><i class="fa fa-list"></i> Area </h1>
                <form class="form-horizontal well">
               
                 <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>AreaID</th>
                        <th>Area Name</th>
                        <th>InUse</th>
						<th>Edit</th>
						<th>Archive</th>
                        </tr>

                    </thead>
                    <tbody>
               

                    <?php
                        while ($row = mysqli_fetch_array($sqlView))
                        {
                              
								
								$areaID = $row['areaID'];
								$areaName = $row['areaName'];
								$InUse = $row['InUse'];

                                echo"
                                <tr>
                                    <td>". $areaID. "</td>
                                    <td>". $areaName. "</td>
                                    <td>". $InUse. "</td>
									<td><a href='editAreaDetails.php?areaID=". $areaID. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>
                                    <td><a href='ArchiveArea.php?areaID=".$areaID."' class='btn btn-xs btn-danger'>
                                    <i class = 'fa fa-trash-o'/></td>
                                </tr>
                                    ";

                        }
                   
                  
                   
                ?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>AreaID</th>
                        <th>Area Name</th>
                        <th>InUse</th>
                        <th>Edit</th>
                        <th>Archive</th>
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