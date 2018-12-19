<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

    $validation_accountNo='';
            
    $validation_mobile='';

            if(!isset($_REQUEST['accountNo']))
            {   
                
                header('location: viewaccount.php');
            }
            
                #DISPLAY account data
                $SQLMap = "SELECT mapID , accountNo,lat,lgn FROM map WHERE status='Active' AND accountNo =".$_REQUEST['accountNo'];
                $queryMap= $conn->query($SQLMap) or die (mysqli_error($conn));
                
                while($row = mysqli_fetch_array($queryMap))
                {
                    $lat = $row['lat'];
                    $long = $row['lgn'];
                }

                $sqlAccount = "SELECT accountNo, firstname, lastname, middlename, houseNo, streetName, city, region, ZIP , mobile, a.areaName , a.areaID FROM accounts ac
                INNER JOIN area a ON ac.areaID = a.areaID 
                INNER JOIN userstatus us ON ac.statusID=us.sid
                WHERE ac.statusID =1 AND accountNo=".$_REQUEST['accountNo'];

                $queryAccount = $conn->query($sqlAccount) or die (mysqli_error($conn));

                while($row =mysqli_fetch_array($queryAccount))
                {
                    $accountNo=$row['accountNo'];
                    $firstname=$row['firstname'];
                    $lastname=$row['lastname'];
                    $middlename=$row['middlename'];
                    $areaName =$row['areaName'];
                    $areaID = $row['areaID'];
                    $houseNo = base64_decode($row['houseNo']);
                    $streetName =base64_decode($row['streetName']);
                    $city =base64_decode($row['city']);
                    $region =base64_decode($row['region']);
                    $ZIP =base64_decode($row['ZIP']);
                    $contact =$row['mobile'];
                    $fullName= $lastname.', '.$firstname;

                }

                $sql_area = "SELECT areaID , areaName FROM area where areaID !=$areaID and status='Active'";

                $queryArea = $conn->query($sql_area) or die (mysqli_error($conn));
                $GoRow = '';
                while ($row = mysqli_fetch_array($queryArea))
                {
                    $queryAreaID = $row['areaID'];
                    $queryName = $row['areaName'];
                    $GoRow = $GoRow. "<option value=$queryAreaID>$queryName</option>";    
                }

                if(isset($_POST['submit']))
                {
                $validation_error='';
                $areaID =  mysqli_real_escape_string($conn , $_POST['areaID']); 
                $region = mysqli_real_escape_string($conn, $_POST['region']);
                $streetName = mysqli_real_escape_string($conn,$_POST['streetName']);
                $city = mysqli_real_escape_string($conn,$_POST['city']);
                $ZIP = mysqli_real_escape_string($conn, $_POST['ZIP']);
                $houseNo = mysqli_real_escape_string($conn,$_POST['houseNo']);
                $firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
                $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
                $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
                $contact = mysqli_real_escape_string($conn,$_POST['contact']);
                
                $findLocation = $houseNo." ".$streetName." ".$city." ".$region." ".$ZIP;
                echo "<script> alert ('$findLocation')</script>";

                $validate_existing_mobile = "SELECT *  FROM accounts where mobile =$contact and accountNo !=".$_REQUEST['accountNo'];
                $get_validate_existing_mobile=$conn->query($validate_existing_mobile) or die(mysqli_error($conn));
                if(mysqli_num_rows($get_validate_existing_mobile) >=1){
                    $validation_error++;
                    $validation_mobile = '*Mobile Number is already existing';

                }
                $numlength = strlen((string)$contact);
                if($numlength !=11){
                    $validation_error++;
                    $validation_mobile = '<br>* Mobile Number must be 11 digits';
                }

                
                if ($validation_error == 0 ) {
                    
                    $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address='$findLocation'&sensor=true";
                    $xml = simplexml_load_file($request_url) or die("Google Map Error Please Restart Search");
                    $status = $xml->status;
                    if ($status=="OK") {
                    $Lat = $xml->result->geometry->location->lat;
                    $Lon = $xml->result->geometry->location->lng;
                    #ADD ACCOUNT 
                    $houseNo = base64_encode($houseNo);
                    $streetName = base64_encode($streetName);
                    $city = base64_encode($city);
                    $region = base64_encode($region);
                    $ZIP = base64_encode($ZIP);
                    $query = "UPDATE accounts set  firstname='$firstname', lastname='$lastname', middlename='$middlename', houseNo='$houseNo', streetName='$streetName', city='$city', region='$region', ZIP='$ZIP', mobile='$contact' , areaID = '$areaID' WHERE accountNo =".$_REQUEST['accountNo'];
                    
                    $conn->query($query) or die (mysqli_error($conn));

                    # Converting Address To Longtitude
                    

                     $sqlMap = "UPDATE map SET lat =$Lat, lgn= $Lon WHERE accountNo =".$_REQUEST['accountNo'];
                  

                     $conn->query($sqlMap) or die (mysqli_error($conn));
                     #Audit

                    echo"<script type='text/javascript'>
                    alert('Successfuly Edited an Account !');
                    </script>";
                   header('location:viewAccount.php');

                    


                     }
                     else
                     {
                        echo"<script type='text/javascript'>
                        alert('Error! Address not found in Map!')
                        </script>";
                     }           
                }
       
            

    }
        




?>

<!DOCTYPE html>
<html>
<head>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxLcBhYr5nz356Li4jgaT1nwXB8CkXgz8&callback=initMap"
  type="text/javascript"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
   <?php
            include('topmenu2.php');
        ?>
        
        <br/>

 
       <div class="container" >
    <div class="col-lg-offset-3 col-lg-6" >
        <h1 class="text-center" style="color:black;">
            <i class="fa fa-user-circle" >Account Number <?php echo $accountNo ?></i>
        </h1>


        <form method ="post" class="form-horizontal well">

            <div class="form-group">
                <label class="control-label col-lg-3">First Name</label>
                <div class="col-lg-8">
                    <input name="firstname" type="text"
                           class="form-control"  value='<?php echo $firstname ?>'required>
                </div>
            </div>

                        <div class="form-group">
                <label class="control-label col-lg-3">Last Name</label>
                <div class="col-lg-8">
                    <input name="lastname" type="text"
                           class="form-control" value ='<?php echo $lastname ?>' required>
                </div>
            </div>

                        <div class="form-group">
                <label class="control-label col-lg-3">Middle Name</label>
                <div class="col-lg-8">
                    <input name="middlename" type="text"
                           class="form-control" value='<?php echo $middlename; ?>' required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">HouseNumber</label>
                <div class="col-lg-8">
                    <input name="houseNo" type="number"
                           class="form-control" value="<?php echo $houseNo ?>" min="0" required>
                </div>
            </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Street Name</label>
                <div class="col-lg-8">
                    <input name="streetName" type="text"
                           class="form-control" value="<?php echo $streetName ?>" required>
                </div>
            </div>

              <div class="form-group">
                    <label class="control-label col-lg-3">Region </label>
                        <div class="col-lg-8">
                            <select class="form-control" name="region" id="region" required> 
                            <option value=<?php echo$region ?>> <?php echo $region?></option>
                            <option value="NCR">NCR </option>
                            </select> 
                        </div>
                 </div> 

                 <div class="form-group">
                    <label class="control-label col-lg-3">City </label>
                        <div class="col-lg-8">
                            <select class="form-control" name="city" id="city" required> 
                            <option value=<?php echo$city ?>> <?php echo $city?></option>
                             <option value="Mandaluyong">Mandaluyong </option>
                             <option value="San Juan">San Juan </option>
                            </select> 
                        </div>
                 </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Zip</label>
                <div class="col-lg-8">
                    <input name="ZIP" type="number"
                           class="form-control" value="<?php echo $ZIP ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Contact No.</label>
                <div class="col-lg-8">
                    <input name="contact" type="number"
                           class="form-control" maxlength="11"  minlength="11" value="<?php echo $contact ?>" required>
                           <span class="alert" style="color: red"><?php echo $validation_mobile ?></span>

                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-lg-3">Area: </label>
                <div class="col-lg-8">
                    <select class="form-control" name="areaID" id="areaID" >
                        <option value="<?php echo $areaID; ?>"><?php echo $areaName ?></option>
                        <?php echo $GoRow ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
            <div class="col-sm-6 ">
                    <a href="viewaccount.php" class="btn btn-success btn-lg pull-left"> Go Back</a>
                </div>

                <div class="col-sm-6">
                    <button name="submit" type="submit" class="btn btn-warning btn-lg pull-right">
                        <i class="fa fa-plus"></i> Edit 
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
