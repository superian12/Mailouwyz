<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
         
            

            if(!isset($_REQUEST['areaAssignID']))
            {
                header('location:viewAreaAssignment.php');
            }
			
            $areaAssignID = $_REQUEST['areaAssignID'];

                 $sql_view = " SELECT area.areaID, area.areaName , u.userid, u.firstname , u.lastname FROM areaAssignment 
                INNER JOIN area ON areaassignment.areaID = area.areaID
                INNER JOIN users u ON areaAssignment.userid = u.userid
                Where areaAssignID=".$_REQUEST['areaAssignID'];
                
                 $queryGo = $conn->query($sql_view);

             

                    while ($row= mysqli_fetch_array($queryGo))
                    {
                        $areaID = $row['areaID'];
                        $areaName = $row['areaName'];
                        $userid = $row['userid'];
                        $firstname = $row['firstname'];
                        $lastname=$row['lastname'];
                        
                      
                        

                    }
           
            
   
    


			
    if(isset($_POST['archiveAreaAssign']))
                    {
                        #check for possible Error in other tables
                          $sqlAffect ="SELECT m.mailNo From mails m
                        INNER JOIN Accounts ac ON m.accountNo = ac.accountNo
                        INNER JOIN Area a ON ac.areaID = a.areaID
                        INNER JOIN areaassignment ar ON a.areaID = ar.areaID
                        WHERE m.mailStatus in ('1','2') AND ac.areaID =".$areaID;
                        
                        $queryAffect =$conn->query($sqlAffect) or die (mysqli_error($conn));
                        if(mysqli_num_rows($queryAffect) > 0)
                        {     
                            echo"<script type='text/javascript'>
                            alert('Cannot delete Area Assign because of pending mails!');
                            location='viewArea.php';
                            </script>";

                                

                        }
                       
                        
                       
                        $sql_edit = "UPDATE areaassignment SET status = 'Inactive' WHERE areaAssignID = ".$_REQUEST['areaAssignID'];

                         $conn->query($sql_edit) or die(mysqli_error($conn));
						 
						// $sql_edit = "UPDATE notification SET notifStatus = 'Inactive' WHERE notificationID = ".$_REQUEST['areaAssignID'];

                         //$conn->query($sql_edit) or die(mysqli_error($conn));
						 
						 $sql_update = "UPDATE area SET InUse = 'No' WHERE areaID = $areaID";

                         $conn->query($sql_update) or die(mysqli_error($conn));

                      header('location:viewAreaAssignment.php');

                    }
                
            
            
            else
            {
             //   header('location:viewAreaAssignment.php');
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
                 <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Archive Area Assignment </i>
                </h1>   
                <form action ="" method="POST" class="form-horizontal well">
                    

                    <div class="form-group">
                        <label class="control-label col-lg-4">Messenger: </label>
                        <div class="col-lg-8">
                            
							<input name="areaName" type="text" value=<?php echo $firstname.$lastname?>
                                class="form-control" maxlength="100" disabled>
							
                       
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Area: </label>
                        <div class="col-lg-8">
                             <input name="areaName" type="text" value=<?php echo $areaName?>
                                class="form-control" maxlength="100" disabled>
                           
                        </div>
                    </div>

                  <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="archiveAreaAssign" type="submit" onclick="return confirm('Area you sure?')" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Archive Area Assignment
                            </button>
                        </div>
                    </div>
                   
                </form>
            
   
    </body> 
</html>