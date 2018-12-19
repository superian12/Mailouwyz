<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System U
        $queryView = "select a.areaid , a.areaName, count(ar.userid) as ttl from area a  LEFT JOIN areaassignment ar ON a.areaID = ar.areaID WHERE a.status = 'Active' GROUP BY a.areaid order by ttl asc";
    $sqlView = $conn->query($queryView) or die (mysqli_error($conn));

    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu2.php');
        ?>

         <div class="container">
        <div class="col-xs-12">
            <h1 class="text-center"><i class="fa fa-list"></i> Area Assignment </h1>
                <form class="form-horizontal well">
                 <table id="posts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Area ID</th>
                        <th>Area Name</th>
                        <th>Messengers </th>
                        <th>Messenger Count</th>
                        <th>Manage</th>


                        </tr>

                    </thead>
                        <?php
                        while ($row = mysqli_fetch_array($sqlView))
                        {
                                $areaid = $row['areaid'];
                                $areaname = $row['areaName'];
                                $count = $row['ttl'];

                        $get_messenger = "SELECT ar.userid, u.firstname, u.lastname  FROM areaassignment ar inner JOIN users u ON ar.userid = u.userid INNER JOIN area a ON ar.areaID = a.areaID where a.areaID = $areaid";
                        $query_get = $conn->query($get_messenger) or die (mysqli_error($conn));
                                echo"
                                <tr>
                                    <td>". $areaid. "</td>
                                    <td>". $areaname. "</td> 
                                    <td>";
                                     while ($mes_array =mysqli_fetch_array($query_get)) {
                                        $fullname = $mes_array['lastname'].", ".$mes_array['firstname'];
                                        
                                        echo" * $fullname<br> ";
                                    }
                                    echo"
                                    <td>". $count. "</td>
                                    <td><a href='re-AssignArea.php?areaID=". $areaid. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>                        
                                </tr>
                                    ";

                        }
                   
                  
                   
                ?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>Area ID</th>
                        <th>Area Name</th>
                        <th>Messengers </th>
                        <th>Messenger Count</th>
                        <th>Manage</th>



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