<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
            $sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["Lastname"];
                $DashID = $Name;
            }
            

	

        $queryView = "SELECT notificationID, notifTitle, description, notifDate FROM notification WHERE    notifStatus = 'Pending'";
		$sqlView = $conn->query($queryView) or die (mysqli_error($conn));







?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>


        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />


    </head>
    <body>
        <?php
            include('topmenu4.php');

        ?>
		
         <div class="container">
        <div class="col-lg-12">
            <h1 class="text-center"><i class="fa fa-list"></i> Notifications </h1>
                <form class="form-horizontal well">
                <table id="posts" class="table table-hover">
                    <thead>
                        <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Confirm</th>
                        <th>Delete</th>

                        </tr>

                    </thead>
                        <?php
                        while ($row = mysqli_fetch_array($sqlView))
                        {
								$notificationID = $row['notificationID'];
                                $notifTitle =$row['notifTitle'];
                                $description=$row['description'];
                                $notifDate=$row['notifDate']; 
                                

                                echo"
                                <tr>
                                    <td>". $notifTitle. "</td>
                                    <td>". $description. "</td>
                                    <td>". $notifDate."</td>
									<td><a href='confirmNotif.php?notificationID=". $notificationID. "' class='btn btn-xs btn-info'>
                                    <i class='fa fa-pencil-square-o'></i></</td>
                                    <td><a href='disapproveNotif.php?notificationID=".$notificationID."' class='btn btn-xs btn-danger'><i class='fa fa-trash-o'/></a></td>
                                   
                                </tr>
                                    ";

                        }
                   
                  
                   
                ?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Confirm</th>
                        <th>Delete</th>
                        </tr>

                    </tfoot>

                    </table>
                    </form>


                    <a href ="messenger.php" class="btn btn-success btn-lg pull-right"> <i class ="fa fa-plus"> </i> Proceed  </a>

   
    </body> 
</html>