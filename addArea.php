<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
          


			if(isset($_POST['saveArea'])){
				
				$AreaName = mysqli_real_escape_string($conn , $_POST['areaName']);
				$sql_addArea = "INSERT INTO area (areaName,status) VALUES ('$AreaName','Active')";
				
				$addQuery =  $conn->query($sql_addArea) or die (mysqli_error($conn));

                 $sql_getno = "SELECT areaID FROM area ORDER BY areaID desc limit 1 ";
                    $query_getno = $conn ->query($sql_getno) or die (mysqli_error($conn));
                    while($row= mysqli_fetch_array($query_getno))
                    {
                        $audit = $row['areaID'];
                    }

      

               // add2log('Add', $_SESSION['userid'],'Area',$audit);
				header('location:viewArea.php');
			}

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include('topmenu2.php');
        ?> 
		<div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center">
                    <i class="fa fa-envelope-o" >  Add Area  </i>
                </h1>   
                <form action ="" method="POST" class="form-horizontal well">
                    

                    <div class="form-group">
                        <label class="control-label col-lg-4">Area Name </label>
                        <div class="col-lg-8">
                            <input name="areaName" type="text"
                                class="form-control" maxlength="200" required  > 
                        </div>
                    </div>
                    
                
                  <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="saveArea" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Save New Area
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
            </div>
    </body> 
</html>