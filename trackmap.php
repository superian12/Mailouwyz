<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);

// SELECT System User
            $sqlUser="SELECT emp.firstName FROM users u INNER JOIN employee emp on u.empID = emp.empID WHERE userID =".$_SESSION['userid'];
            $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
            $DashID = "";
            while ($row = mysqli_fetch_array($queryUsers))
            {
                $Name = $row["firstName"];
                $DashID = $Name;
            }
            

            if(!isset($_REQUEST['accountNo']))
            {   
                
                header('location: trackmessengerlocation.php');
            }
            else
            {
                #DISPLAY account data
                $SQLMap = "SELECT mapID , accountNo,lat,lgn FROM map WHERE  accountNo =".$_REQUEST['accountNo'];
                $queryMap= $conn->query($SQLMap) or die (mysqli_error($conn));
                
                while($row = mysqli_fetch_array($queryMap))
                {
                    $lat = $row['lat'];
                    $long = $row['lgn'];
                }

                $sqlAccount = "SELECT accountName , Address , a.areaName FROM account ac
                INNER JOIN area a ON ac.areaID = a.areaID 
                WHERE ac.status ='Active' AND accountNo=".$_REQUEST['accountNo'];

                $queryAccount = $conn->query($sqlAccount) or die (mysqli_error($conn));

                while($row =mysqli_fetch_array($queryAccount))
                {
                    $accountName = $row['accountName'];
                    $address = $row['Address'];
                    $areaName = $row['areaName'];

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
       <div class="col-lg-4">
            <div class="well">
            <h3 class="text-center">Account Details</h3>

            <form method="POST" class="form-horizontal well">
            <table class="table table-hover">
            <tr>
                <td><b>Account Name</b></td>
                <td align='right'><b><?php echo $accountName ?> </b></td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td align='right'><b><?php echo$address ?></b></td>
            </tr>
            <tr>
                <td><b>Area</b></td>
                <td align='right'><b><?php echo $areaName ?> </b></td>
            </tr>
            </table>
                
            
       
            <a href="trackmap.php" class="btn btn-lg btn-warning">
            <i class ="fa fa-map-o"></i> Go back</a>
                            
                            
            </form>           
            </div>     
    </div> 

</body>
</html>
