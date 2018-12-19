<?php
 include "dbconnect.php";

 $sqlAreaAssign ="SELECT areaAssignID FROM areaassignment";

$queryAreaAssign = $conn->query($sqlAreaAssign) or die(mysqli_error($conn));
$GoRow = "";
    while ($row = mysqli_fetch_array($queryAreaAssign))
    {
        $AreaAssignID= $row["areaAssignID"];
         $GoRow =$GoRow. "<option value='$AreaAssignID'> $AreaAssignID</option>";
    }




if (isset($_POST['addAccount']))
    {
        $accountName = mysqli_real_escape_string($conn, $_POST['accountName']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        
        $areaAssignID = $_POST['areaAssignID'];

        $insert = "INSERT INTO accounts VALUES ('','$accountName','$address','$areaAssignID','Active') ";
         $conn->query($insert) or die(mysqli_error($conn));

    }

?>
<!DOCTYPE html>

<html>
    <head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include('topmenu3.php');
         
        ?> 

           

        <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="" > Add Account</i>
                </h1>
                <form method="POST" class="form-horizontal well">
                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Account Name</label>
                        <div class="col-lg-8">
                            <input name="accountName" type="text"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4">Address</label>
                        <div class="col-lg-8">
                            <input name="address" type="text"
                                class="form-control" maxlength="100" minlength="10" required>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-lg-4">Area Assign ID</label>
                    <div class="col-lg-8">
                        <select name="areaAssignID" class="form-control" required>
                            <option value="">Select one...</option>
                            <?php echo $GoRow; ?>
                        </select>
                    </div>
                </div>


                    
                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <button name="addAccount" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Add account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body> 
</html>