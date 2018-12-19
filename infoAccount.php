<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
 
            

            if(!isset($_REQUEST['accountNo']))
            {   
                
                header('location: viewaccount.php');
            }
            else
            {
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
                WHERE ac.statusID ='1' AND accountNo=".$_REQUEST['accountNo'];

                $queryAccount = $conn->query($sqlAccount) or die (mysqli_error($conn));

                while($row =mysqli_fetch_array($queryAccount))
                {
                    $accountNo=$row['accountNo'];
                    $firstname=$row['firstname'];
                    $lastname=$row['lastname'];
                    $middlename=$row['middlename'];
                    //$address = $row['Address'];
                    $areaName = $row['areaName'];
                    $areaID = $row['areaID'];
                    $houseNo = $row['houseNo'];
                    $streetName =$row['streetName'];
                    $city =$row['city'];
                    $region =$row['region'];
                    $ZIP =$row['ZIP'];
                    $contact =$row['mobile'];
                     $fullName= $lastname.','.$firstname;

                }

                if(isset($_POST['submit']))
                {

                    #Check if affected by mail
                    $sql_check ="SELECT mailNo FROM Mails WHERE mailStatus in ('1','2') AND accountNo=".$_REQUEST['accountNo'];
                    $queryAffect = $conn->query($sql_check) or die (mysqli_error($conn));

                    if(mysqli_num_rows($queryAffect) > 0)
                    {     
                    echo"<script type='text/javascript'>
                    alert('Cannot delete area because of pending mails!');
                    location='viewaccount.php';
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
<title>Account Information</title>
   <?php
            include('topmenu2.php');
        ?>
        
        <br/>

        <div class="col-lg-offset-1  col-lg-6">

        <div class="well" style="color: black">
        <label>Map Location</label>
   
            <div id="map" style="width:100%;height:400px;"></div>
        </div>
        </div>
       
            <script>
            function myMap() 
            {
              var mapCanvas = document.getElementById("map");
              var myCenter = new google.maps.LatLng(<?php echo$lat?>,<?php echo$long?> ); 
              var mapOptions = {center: myCenter, zoom: 18};
              var map = new google.maps.Map(mapCanvas,mapOptions);
              var marker = new google.maps.Marker({
                position: myCenter,
                animation: google.maps.Animation.BOUNCE
              });
              marker.setMap(map);
            }
</script> 

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxLcBhYr5nz356Li4jgaT1nwXB8CkXgz8&callback=myMap"></script>
            <!--
            To use this code on your website, get a free API key from Google.
            Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
            --> 
     <div class="col-lg-5">
            <div class="well">
            <h3 class="text-center">Account Details</h3>

            <form method="POST" class="form-horizontal well">
            <table class="table table-hover">
            <tr>
                <td><b>Account Number</b></td>
                <td align='right'> <input name="accountNo" type="text" value="<?php echo $accountNo?>" 
                                class="form-control" disabled></b></td>
            </tr>
            <tr>
                <td><b>First Name</b></td>
                <td align='right'> <input name="firstname" type="text" value="<?php echo $firstname?>" 
                                class="form-control" disabled></b></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td align='right'> <input name="lastname" type="text" value="<?php echo $lastname?>" 
                                class="form-control" disabled></b></td>
            </tr>
             <tr>
                <td><b>Middle Name</b></td>
                <td align='right'> <input name="middlename" type="text" value="<?php echo $middlename?>" 
                                class="form-control" disabled></b></td>
            </tr>
             <tr>
                <td><b>Houde No</b></td>
                <td align='right'> <input name="houseNo" type="text" value="<?php echo $houseNo?>" 
                                class="form-control" disabled></b></td>
            </tr>

             <tr>
                <td><b>Street Name</b></td>
                <td align='right'> <input name="streetName" type="text" value="<?php echo $streetName?>" 
                                class="form-control" disabled></b></td>
            </tr>

            <tr>
                <td><b>Region</b></td>
                <td align='right'> <input name="region" type="text" value="<?php echo $region?>" 
                                class="form-control" disabled></b></td>
            </tr>
            <tr>
                <td><b>ZIP</b></td>
                <td align='right'> <input name="ZIP" type="text" value="<?php echo $ZIP?>" 
                                class="form-control" disabled></b></td>
            </tr>

            <tr>
                <td><b>Contact No</b></td>
                <td align='right'> <input name="mobile" type="text" value="<?php echo $contact?>" 
                                class="form-control" disabled></b></td>
            </tr>
           
            <tr>
                <td><b>Area</b></td>
                <td align='right'><select name="area" class="form-control"  disabled>
                            <option value=<?php echo$areaID?>> <?php echo$areaName?></option>
                            <?php echo $GoRow ?>
                            </select></td>
            </tr>

            </table>
                
            
       
          
            </form>           
            </div>     
    </div> 

</body>
</html>
