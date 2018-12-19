<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '4';
    session_start();
    validateAccess($sessionDepartment);


            if(isset($_REQUEST['mailNo']))
            {
            	#GET Account
            	$SQL_getacc= "SELECT accountNo FROM mails WHERE mailNo=".$_REQUEST['mailNo']; 	
            	$query_acc = $conn->query($SQL_getacc) or die(mysqli_error($conn));
            	while($row = mysqli_fetch_array($query_acc))
            	{
            	 	$accNo = $row['accountNo'];	
            	}
            	#DISPLAY account data
                $SQLMap = "SELECT mapID , accountNo,lat,lgn FROM map WHERE status='Active' AND accountNo = $accNo ";
                $queryMap= $conn->query($SQLMap) or die (mysqli_error($conn));
                
                while($row = mysqli_fetch_array($queryMap))
                {
                    $lat = $row['lat'];
                    $long = $row['lgn'];
                }



            	$sql_select =" SELECT ac.firstname,ac.lastname , ac.houseNo, ac.streetName , ac.city, ac.region , ac.zip ,a.areaName , mt.mailtypeName , rm.dueDate FROM mails m 
            	INNER JOIN accounts ac ON m.accountNo = ac.accountNo
            	INNER JOIN area a ON ac.areaID = a.areaID
            	INNER JOIN mailtypes mt ON m.mailtypeID = mt.mailtypeID
            	INNER JOIN receivedMails rm ON m.receivedMailID = rm.receivedMailID
            	WHERE mailNo =".$_REQUEST['mailNo'];


            	$query_select = $conn->query($sql_select) or die (mysqli_error($conn));
            	while($row = mysqli_fetch_array($query_select))
            	{
            		$accountName = $row['lastname'].", ".$row['firstname'];
            		$houseNo = base64_decode($row['houseNo']);
                    $streetName = base64_decode($row['streetName']);
                    $city = base64_decode($row['city']);
                    $region = base64_decode($row['region']);
                    $zip = base64_decode($row['zip']);
            		$areaName = $row['areaName'];
            		$mailtype = $row['mailtypeName'];
            		$dueDate = $row['dueDate']; 
            	}



            }
            else
            {
            	header('location: viewmail3.php');
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
            include('topmenu4.php');
        ?>
        
        <br/>

        <div class="col-lg-offset-1 col-lg-5">

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
			<table class="table table-hover">
			<tr>
				<td><b>Account Number</b></td>
				<td align='center'><b><?php echo $accountName ?> </b></td>
			</tr>
            <tr>
                <td><b>Full Name</b></td>
                <td align='center'><b><?php echo $accountName ?> </b></td>
            </tr>
			<tr>
				<td><b>House Number</b></td>
				<td align='center'><b><?php echo$houseNo ?></b></td>
			</tr>
            <tr>
                <td><b>Street Name</b></td>
                <td align='center'><b><?php echo$streetName ?></b></td>
            </tr>
            <tr>
                <td><b>City</b></td>
                <td align='center'><b><?php echo$city ?></b></td>
            </tr>
            <tr>
                <td><b>Region</b></td>
                <td align='center'><b><?php echo$region ?></b></td>
            </tr>
            <tr>
                <td><b>ZIP code</b></td>
                <td align='center'><b><?php echo$zip ?></b></td>
            </tr>
			<tr>
				<td><b>Area</b></td>
				<td align='center'><b><?php echo $areaName ?> </b></td>
			</tr>
			<tr>
				<td><b>Mail Type</b></td>
				<td align='center'><b><?php echo$mailtype ?></b></td>
			</tr>
			<tr>
				<td><b>Due Date</b></td>
				<td align='center'><b><?php echo $dueDate ?> </b></td>
			</tr>
			</table>

			
			<a href="editDeliveredRemitedMail.php?mailNo=<?php echo$_REQUEST['mailNo']?> " type="button" class="btn btn-warning"> Deliver</a> 
			
			<a href="editRemitMail.php?mailNo=<?php echo$_REQUEST['mailNo'] ?>" type="button" class="btn btn-danger pull-right"> Remit</a>

            <br>
            <br>
            <br>
             <a href="viewMail3.php" type="button" class="btn btn-info  pull-left"> Go Back</a>
            <br>

			</div>
		</div>

</body>
</html>

</body>
</html>