<?php
 
require_once "../dbconnect.php";
// Get un-encoded mails
$get_encoded = "SELECT (SELECT count(*) from mails m where m.receivedmailID = 1) as encoded , (SELECT rm.quantity FROM receivedmails rm where rm.receivedmailID = 1) as total
";

$query_get_encoded = $conn -> query($get_encoded) or die (mysqli_error($conn));
$total_row = "";
while($row = mysqli_fetch_array($query_get_encoded))
{	
	$total_row = $row['total'] - $row['encoded']; 
}

$un_encoded_mails = 
$query = "SELECT ms.description , count(*) as ct from mails m INNER JOIN mailstatus ms on m.mailStatus = ms.statusID where m.receivedmailID =1 GROUP by mailstatus";
$execute_command = $conn -> query($query) or die (mysqli_error($conn));


?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Reporst Generation</title>  
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Mail Status', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($execute_command))  
                          {  
                               echo "['".$row["description"]."', ".$row["ct"]."],";  
                          }  
                          		echo "['Unsorted Mails', ".$total_row."]";
                          ?>  

                     ]);  
                var options = {  
                      title: 'Mailouys Batch Batch Report',  
                      //is3D:true,  
                      pieHole: 0.4  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>  
      </head>  
      <body>  
           <br /><br />  
           <div style="width:900px;">  
                <h3 align="center">Batch Mail No. 1</h3>  
                <br />  
                <div id="piechart" style="width: 900px; height: 500px;"></div>  
           </div>  
      </body>  
 </html>  