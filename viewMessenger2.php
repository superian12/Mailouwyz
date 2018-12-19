<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);


            
// Select Employees
            $sqlEmp = "SELECT  userID, lastname,firstname ,mobileNumber, landline,email,statusType FROM users us INNER JOIN userStatus s ON us.sid = s.sid WHERE us.sid= 1 AND  us.departmentID=4 ";
            $queryEmp = $conn->query($sqlEmp) or die (mysqli_error($conn));

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<title>View Messengers</title>
<?php  include "topmenu2.php" ?>
<div class="container">
        <div class="col-lg-offset-1 col-lg-10 table-responsive " style="overflow-x: auto;">
            <h1 class="text-center"><i class="fa fa-list"></i>Messenger </h1>
                <form method = "POST" class="form-horizontal well" >

                <table id="posts" class="table table-hover table table-responsive">
                    <thead>
                        <tr>
                        <th>Info</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>status</th>       
                        </tr>

                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($queryEmp))
                        {
                                $userID =$row['userID'];
                                $firstname=$row['firstname'];
                                $lastname=$row['lastname'];
                                $email=$row['email'];
                                $mobile= $row['mobileNumber'];
                                $status = $row['statusType'];

                                
                                $fullName= $lastname.','.$firstname;
                                echo"
                                <tr>
                                    <td><a href='employeeInfo2.php?userID=".$userID."'' class='btn btn-xs btn-warning'>
                                    <i class ='fa fa-map-o'></i></td>
                                    
                                    <td>". $fullName. "</td>
                                    <td>". $email. "</td>
                                    <td>". $mobile."</td>
                                    <td>".$status."</td>
                       

                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                        <tr>
                         <th>Info</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>status</th>    

                   
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