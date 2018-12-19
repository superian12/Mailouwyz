<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
            

            if(!isset($_REQUEST['areaID']))
            {   
                header('location:viewAreaAssignment.php');
            }
            $areaAssignID1 = $_REQUEST['areaID'];
        /* GET VALUE */
            $get_areaname = "SELECT areaName FROM AREA a where areaid=".$_REQUEST['areaID'];
            $query_get_area = $conn->query($get_areaname) or die (myqli_error($conn));
            while ($row = mysqli_fetch_array($query_get_area)) {
                $area_name = $row['areaName'];
                
            }

        // Messenger Options


                 $sql_view = "SELECT ar.areaAssignID, a.areaName, u.firstname , u.lastname , u.userid from area a INNER JOIN areaassignment ar ON a.areaID = ar.areaID INNER JOIN users u ON ar.userid = u.userid WHERE a.status = 'Active' and a.areaID =".$areaAssignID1;                
                 $queryGo = $conn->query($sql_view) or die (mysqli_error($conn));
                      if(isset($_POST['reAssign']))
                    {
                       
                        $userid = mysqli_real_escape_string($conn, $_POST['userid']);
                        date_default_timezone_set('Asia/Manila');
							$date = date('Y/m/d H:i:s');
                        $sql_edit = "UPDATE areaassignment SET areaID = '$areaID', userid = '$userid', status = 'Pending', dateModified = '$date' WHERE areaAssignID = $areaAssignID1";

                         $conn->query($sql_edit) or die(mysqli_error($conn));

                 //add2log('Re-Assign', $_SESSION['userid'],'AreaAssign',$_REQUEST['areaAssignID']);
                 header('location:viewAreaAssignment.php');

                    
                }   
               if(isset($_POST['submit']))
                {
                    $validation_error='';
                    $dateFilled = date('Y/m/d H:i:s');
                    $userID = mysqli_real_escape_string($conn,$_POST['userid']);
                    if ($userID ==0) {
                        $validation_error++;
                        
                    }
                    if($validation_error == 0)
                    {
                    $message = "You have been Assign in area ".$area_name.".Please talk to the office for more information. ";
                    $get_number = "SELECT mobileNumber FROM users where userid=".$userID;
                    $query_get_number =$conn->query($get_number) or die(mysqli_error($conn));
                    while($row = mysqli_fetch_array($query_get_number))
                    {
                        $mobile_number = $row['mobileNumber'];
                    }

                    $update_area = "UPDATE AREA set inuse = 'Yes' where areaID = $areaAssignID1";
                            $conn->query($update_area) or die (mysqli_error($conn));
                    sendSMS($mobile_number,$message);
                    $insert_messenger ="INSERT INTO areaassignment( areaID, userid, status, dateAssigned ) VALUES ('$areaAssignID1',$userID,'Active','$dateFilled')";
                    $conn->query($insert_messenger) or die (mysqli_error($conn));
                    header('location:Re-AssignArea.php?areaID='.$areaAssignID1);  
                    }

                }
                
                if(isset($_POST['delete']))
                {
                      if (empty($_POST['messengers'])) {
                        echo"<script>alert('Please select a messenger')</script>";
                        } 
                        else {
                    $checkbox = $_POST['messengers'];

                    $message = "You have been remove in area  ".$area_name.".Please talk to the office for more information. ";

                    for($i=0;$i<count($checkbox);$i++){
                        $del_id = $checkbox[$i];
                        $get_number = "SELECT u.mobileNumber FROM users u inner JOIN areaassignment ar ON ar.userid = u.userid where ar.areaAssignID = ".$del_id;
                        $query_get_number =$conn->query($get_number) or die(mysqli_error($conn));
                        while($row = mysqli_fetch_array($query_get_number))
                        {
                            $mobile_number = $row['mobileNumber'];
                        }

                        sendSMS($mobile_number,$message);

                        
                       $sql = "DELETE FROM areaassignment where areaAssignID =".$del_id;
                        $conn->query($sql) or die(mysqli_error($conn));
                        header('location:Re-AssignArea.php?areaID='.$areaAssignID1);
                        $check_area = "SELECT * FROM areaassignment WHERE areaID = $areaAssignID1";
                        $get_check_area = $conn->query($check_area) or die (mysqli_error($conn));
                        if(mysqli_num_rows($get_check_area)==0){
                            $update_area = "UPDATE AREA set inuse = 'No' where areaID = $areaAssignID1";
                            $conn->query($update_area) or die (mysqli_error($conn));

                        }

                        

                    }
                    }
                }
                

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       
    </head>
    <body>
        <?php
            include('topmenu2.php');

        ?>
        <form  method="POST" class="form-horizontal "> 
             <h1 class="text-center" style="color:black;">
                    <i class="fa fa-location-arrow" >Assign Area <?php echo $area_name ?> </i>
                </h1>

            <div class=" col-sm-offset-3  col-sm-6 row " >
                <h3 align="center">Add Messenger</h3> 
                  
                               
                    <div class="form-group">
                        <label class="control-label col-sm-4">Messenger: </label>
                        <div class="col-sm-7">
                            <select name="userid" class="form-control" type="submit" >
                            <option value="">Select..</option>
                            <?php 
                                if(mysqli_num_rows($queryGo) ==0 ){
                                    $select_employees = "SELECT  u.userid,u.firstname , u.lastname FROM users u where u.departmentID = 4 and sid !=2";
                                    $query_get_employees = $conn ->query($select_employees) or die (mysqli_error($conn));
                                        while ($row= mysqli_fetch_array($query_get_employees)) {

                                            $id = $row['userid'];
                                            $fullName = $row['lastname'].", ".$row['firstname'];

                                            echo"<option value='$id'>$fullName</option>";
                                        }
                                }
                                else if(mysqli_num_rows($queryGo) >=1 ){

                                     $results = array();
                                     while ($exRow = mysqli_fetch_array($queryGo)) {
                                         $results[] =$exRow['userid'];
                                     }
                                $select_employees = "SELECT u.firstname , u.lastname,userid FROM users u where sid !=2 and u.departmentID = 4 and userid NOT in (". implode(',', array_map('intval', $results)) .") ";
                                $query_get_employees = $conn ->query($select_employees) or die (mysqli_error($conn));
                                while ($row= mysqli_fetch_array($query_get_employees)) {

                                    $fullName = $row['lastname'].", ".$row['firstname'];
                                    $id = $row['userid'];
                                    echo"<option value='$id'>$fullName</option>";
                                    }
                                } 
                            ?>
                        </select>
                        </div>
                    </div>

                        <div class="form-group">
                        <div class=" col-sm-7">
                            <button name="submit" id="submit" type="submit" class="btn btn-success btn-sm pull-right" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-plus"></i> Add Messenger
                            </button>   
                        </div>
                    </div>
                    
                    </div>


                    
             



                <div class="col-sm-offset-3 col-sm-6 row well">
                <table class="table table-boarder">
                    <thead>
                        <tr>
                        <th>AreaID</th>
                        <th>Area Name</th>
                        <th>Messenger</th>
                        <th>Delete</th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php 
                            $ar_messenger = "SELECT ar.areaAssignID, a.areaName, u.firstname , u.lastname , u.userid from area a INNER JOIN areaassignment ar ON a.areaID = ar.areaID INNER JOIN users u ON ar.userid = u.userid WHERE a.status = 'Active' and a.areaID =".$areaAssignID1;                
                            $go_get = $conn->query($ar_messenger) or die (mysqli_error($conn));
                            while ($mess= mysqli_fetch_array($go_get))
                            {
                                $arID = $mess['areaAssignID'];
                                $areaName = $mess['areaName'];
                                $fullName =$mess['lastname'].", ".$mess['firstname'];

                                echo "<tr>
                                    <td>".$arID."</td>
                                    <td>".$areaName."</td>
                                    <td>".$fullName."</td>
                                    <td><input type='checkbox' name ='messengers[]'  value='".$arID."'></td>
                                </tr>";
                            }
                        
                        
                         ?>
                    </tbody>
                </table>
                <button name="delete" type="submit" class="btn btn-danger btn-sm pull-right" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-plus"></i> Delete Messenger
                            </button>
                
                </div>



                
   </form>
    </body> 
</html>