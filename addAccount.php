<?php

    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
    $validation_accountNo='';
    $region ='';
    $street = '';
    $city = '';
    $zip = '';
    $accountNo = '';
    $house = '';
    $firstName = '';
    $lastName = '';
    $middleName = '';
    $status_id = 1;
    $area = '';
    $contact = '';

       $sql_department = " SELECT deptname,deptID FROM department ";
              $query_department = $conn->query($sql_department) or die (mysqli_error($conn));
              $deptRow="";

              if(mysqli_num_rows($query_department) > 0 )
              {
                while ($row = mysqli_fetch_array($query_department)) 
                {
                    $cdeptID= $row['deptID'];
                    $cdeptName=$row['deptname'];
                    $deptRow = $deptRow."  <option value='$cdeptID'> $cdeptName</option> ";        
                }
            }


            if(isset($_POST['addAccount']))
            {   

                $validation_errors = '';
            	$region = mysqli_real_escape_string($conn, $_POST['region']);
            	$street = mysqli_real_escape_string($conn,$_POST['street']);
            	$city = mysqli_real_escape_string($conn,$_POST['city']);
            	$zip = mysqli_real_escape_string($conn, $_POST['zip']);
            	$accountNo = mysqli_real_escape_string($conn,$_POST['accountNo']);
            	$house = mysqli_real_escape_string($conn,$_POST['house']);
                $firstName = mysqli_real_escape_string($conn,$_POST['firstName']);
                $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
                $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
                
                $area =  mysqli_real_escape_string($conn , $_POST['areaID']); 
                $contact = mysqli_real_escape_string($conn,$_POST['contact']);

                $validate_account_number = "SELECT accountNo FROM accounts where accountNo = ".$accountNo;
                $get_validate_account_number= $conn->query($validate_account_number) or die(mysqli_error($conn));
                // Validate if Account is existing  
                if (mysqli_num_rows($get_validate_account_number)) {
                    $validation_errors ++;
                    $validation_accountNo= $validation_accountNo .'*Account already Exist.';
                    
                }

                if($accountNo <= 1 )
                {
                    $validation_errors++;
                    $validation_accountNo = $validation_accountNo. ' <br>*Account is less than zero.';
                }
                if(strlen($middleName ==0))
                {
                    $middleName = 'NULL';
                }

                
                if ($validation_errors == 0) {
                    // If smooth then runs
                
                    $findLocation = $house." ".$street." ".$city." ".$region." ".$zip; 



                    $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address='$findLocation'&sensor=true";
                    $xml = simplexml_load_file($request_url) or die("Google Map Error Please Restart Search");
                    $status = $xml->status;
                    if ($status=="OK") {
                    $Lat = $xml->result->geometry->location->lat;
                    $Lon = $xml->result->geometry->location->lng;
                    #ADD Map 
                     $sqlMap = "INSERT INTO map (accountNo,lat,lgn,status) 
                     VALUES (".$accountNo.",'$Lat','$Lon','ACTIVE')";
                    #GetMap
                     $get_map ="SELECT mapid FROM map WHERE accountNo = ".$accountNo;
                     $query_get_map = $conn->query($get_map) or die (mysqli_error($conn));
                     while($row=mysqli_fetch_array($query_get_map))
                     {
                        $map_id = $row['mapid'];
                     }

                    $conn->query($sqlMap) or die (mysqli_error($conn));
                    #ADD ACCOUNT 
                    $house = base64_encode($house);
                    $street = base64_encode($street);
                    $city = base64_encode($city);
                    $region = base64_encode($region);
                    $zip = base64_encode($zip);
                    $query_add = "INSERT INTO accounts(accountNo, firstname, middlename, lastname, houseNo, streetName, city, region, ZIP, mobile, areaID,statusID) VALUES ($accountNo , '$firstName' , '$middleName' , '$lastName' , '$house' , '$street' , '$city' , '$region' , '$zip', $contact,$area , 1 )";

                    $conn -> query($query_add)  or die (mysqli_error($conn));

                    

                    
                     echo"<script type='text/javascript'>
                        alert('Successfuly Added an Account !');
                        location='viewaccount.php';
                        </script>";
                     }
                    else
                    {
                    $house = base64_encode($house);
                    $street = base64_encode($street);
                    $city = base64_encode($city);
                    $region = base64_encode($region);
                    $zip = base64_encode($zip);
                    $query_add = "INSERT INTO accounts(accountNo, firstname, middlename, lastname, houseNo, streetName, city, region, ZIP, mobile, areaID,statusID) VALUES ($accountNo , '$firstName' , '$middleName' , '$lastName' , '$house' , '$street' , '$city' , '$region' , '$zip', $contact,$area , 1 )";

                    $conn -> query($query_add)  or die (mysqli_error($conn));

                    echo "<script>alert('Account Added Without Map!')</script>";
                    }   
                }
            } 
            
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Add account</title>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include('topmenu2.php');

?>

<div class="container" >
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class="fa fa-user-circle" > Add Account</i>
        </h1>

        <form method ="post" class="form-horizontal well">

            <div class="form-group">
                <label class="control-label col-lg-3">Account Number</label>
                <div class="col-lg-8">
                    <input name="accountNo" type="number"
                           class="form-control" value='<?php echo $accountNo ?>' min="1" required>
                    <span class="alert" style="color: red"><?php echo $validation_accountNo ?></span>
                </div>
            </div>
        <form method ="post" class="form-horizontal well">

            <div class="form-group">
                <label class="control-label col-lg-3">First Name</label>
                <div class="col-lg-8">
                    <input name="firstName" type="text"
                           class="form-control"  value='<?php echo $firstName ?>'required>
                </div>
            </div>

                        <div class="form-group">
                <label class="control-label col-lg-3">Last Name</label>
                <div class="col-lg-8">
                    <input name="lastName" type="text"
                           class="form-control" value ='<?php echo $lastName ?>' required>
                </div>
            </div>

                        <div class="form-group">
                <label class="control-label col-lg-3">Middle Name</label>
                <div class="col-lg-8">
                    <input name="middleName" type="text"
                           class="form-control" value='<?php echo $middleName; ?>'>
                </div>
            </div>

  			<div class="form-group">
                <label class="control-label col-lg-3">House Number</label>
                <div class="col-lg-8">
                    <input name="house" type="number"
                           class="form-control" value="<?php echo $house ?>" min="0" required>
                </div>
            </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Street Name</label>
                <div class="col-lg-8">
                    <input name="street" type="text"
                           class="form-control" value="<?php echo $street ?>" required>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-lg-3">Region: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="region" id="region" value=<?php echo $region ?> required> 
                        <option value="">Select....</option>
                        <option value="NCR">NCR </option>
                        </select> 
                    </div>
             </div> 

         
            <div class="form-group">
                <label class="control-label col-lg-3">City: </label>
                    <div class="col-lg-8">
                        <select class="form-control" name="city" id="city" value=<?php echo $city ?> required> 
                        <option value="">Select....</option>
                        <option value="Mandaluyong">Mandaluyong </option>
                        <option value="San Juan">San Juan </option>
                        </select> 
                    </div>
             </div> 

              <div class="form-group">
                <label class="control-label col-lg-3">Zip</label>
                <div class="col-lg-8">
                    <input name="zip" type="number"
                           class="form-control" value="<?php echo $zip ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Contact No.</label>
                <div class="col-lg-8">
                    <input name="contact" type="number"
                           class="form-control" maxlength="11"  minlength="11" value="<?php echo $contact ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Area: </label>
                <div class="col-lg-8">
                    <select class="form-control" name="areaID" id="areaID"  required>
                        <option value="">Select...</option>
                         <?php
                        $sql = mysqli_query($conn, "SELECT `areaID`, `areaName` FROM `area` WHERE status ='Active'");
                        $row = mysqli_num_rows($sql);
                        while ($row = mysqli_fetch_array($sql)){
                            echo "<option value='". $row['areaID'] ."'>" .$row['areaName'] ."</option>" ;
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <button name="addAccount" type="submit" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-plus"></i> Add 
                    </button>
                </div>
            </div>
        </form>

        <!-- MODAL-->

            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                 You are signed in now!
                </div>
              </div>
            </div>

        <!---->
    </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="java.js"></script>
</body>
</html>


