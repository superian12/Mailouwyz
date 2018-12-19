<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
	$message = "";

// SELECT System User
            $sqlUser="SELECT emp.firstName FROM users u INNER JOIN employee emp on u.empID = emp.empID WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["firstName"];
                $DashID = $Name;
            }
            
				
			
			
			$queryView = "SELECT m.mailNo, m.accountNo, acc.accountName, rm.dueDate FROM mails m INNER JOIN account acc ON m.accountNo = acc.accountNo INNER JOIN receivedmails rm ON m.receivedmailID = rm.receivedmailID WHERE pulledOutStatus = 'QUE' AND acc.areaID =".$_SESSION['AreaID'];
			
			
			$sqlView = $conn->query($queryView) or die (mysqli_error($conn));
			
			date_default_timezone_set('Asia/Manila');
	        $dateTimePulledOut = date('Y/m/d H:i:s');
			if(isset($_POST['submit'])){
				$mailID = array();
				
				
				while ($row = mysqli_fetch_assoc($sqlView))
                        {
                                $mailID[] = $row['mailNo'];
						}	
					foreach ($mailID as $id){
						$sql_record = "UPDATE mails SET pulledOutStatus = 'Que', dateTimePulledOut = NOW(), 
						messenger = '".$_SESSION['EmpID']."' WHERE mailNo = $id";
						$queryRecord = $conn->query($sql_record) or die (mysqli_error($conn));
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
         print "Record Pulled-out Mail";
        ?> 
		<form action ="" method = "POST" class="form-horizontal well" >
                <div class=" col-lg-12">

                    

                </div>
                <table id="posts" class="table table-hover">
					
                    <thead>
                        <tr>
                        <th>MailNo</th>
                        <th>AccountNo</th>
                        <th>Account Name</th>
                        <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        while ($row = mysqli_fetch_array($sqlView))
                        {
                                $mailNo = $row['mailNo'];
								$accountNo = $row['accountNo'];
								$accountName = $row['accountName'];
								$dueDate = $row['dueDate'];
								
								
                                echo"
                                <tr>
                                   
                       
                                    <td>". $mailNo. "</td>
                                    <td>". $accountNo. "</td>
                                    <td>". $accountName. "</td>
                                    <td>". $dueDate."</td>
                                
                                </tr>
                                    ";
                        }
?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>MailNo</th>
                        <th>AccountNo</th>
                        <th>Account Name</th>
                        <th>Deadline</th>
                        </tr>

                    </tfoot>

                    </table>
					 <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Record as Pulled-out
                            </button>
                        </div>
                    </div>
                    </form>
                    </div>
                    </div>

	
	
	</body>
</html>
