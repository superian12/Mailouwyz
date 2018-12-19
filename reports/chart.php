<?php
 
require_once "../dbconnect.php";

if(!isset($_REQUEST['batchNo']))
{
  header('location:../index.php');
}
// Get un-encoded mails
$RM_ID = $_REQUEST['batchNo'];
$get_encoded = "SELECT (SELECT count(*) from mails m where m.receivedmailID = $RM_ID) as encoded , (SELECT rm.quantity FROM receivedmails rm where rm.receivedmailID = $RM_ID) as total ,(SELECT COUNT(*) from mails m where m.mailStatus = $RM_ID and receivedmailID = $RM_ID) as pending , (SELECT count(*) from mails m where m.mailStatus =2 and m.receivedmailID = $RM_ID) as queue, (SELECT count(*) from mails m where m.mailStatus =3 and m.receivedmailID = $RM_ID) as delivered ,(SELECT count(*) from mails m where m.mailStatus =5 and m.receivedmailID = $RM_ID) as remitted , (SELECT count(*) from mails m where m.mailStatus =4 and m.receivedmailID = $RM_ID) as complete , (SELECT dueDate FROM receivedmails WHERE receivedmailID = $RM_ID) as dueDate
";

$query_get_encoded = $conn -> query($get_encoded) or die (mysqli_error($conn));

while($row = mysqli_fetch_array($query_get_encoded))
{	
  $total_received = $row['total'];
	$total_row = $row['total'] - $row['encoded']; 
  $queue = $row['queue'];
  $remitted =$row['remitted'];
  $delivered = $row['delivered'];
  $pending =$row['pending'];
  $complete = $row['complete'];
  $mnt = $row['dueDate'];
}
//GET Total Remittance
$get_remittance = "SELECT m.RTSID , rt.RTSname , count(*) as total  from mails m INNER JOIN rtscode rt ON m.RTSID = rt.RTSID where m.RTSID != 0  and m.receivedmailID = ".$RM_ID." GROUP BY m.RTSID";
$query_get_remittance = $conn->query($get_remittance) or die(mysqli_error($conn));




// Convert to Percentage

$unsort_percentage = ($total_row / $total_received) * 100;
$queue_percentage = ($queue / $total_received) * 100;
$pending_percentage = ($pending / $total_received) * 100;
$remitted_percentage = ($remitted / $total_received) * 100;
$delivered_percentage = ($delivered / $total_received) * 100;
// Decimal Places and Percentage Signs
$total_unsort_percentage = number_format($unsort_percentage, 2, '.', '') .'%';
$total_queue_percentage = number_format($queue_percentage, 2, '.', '').'%';
$total_pending_percentage = number_format($pending_percentage, 2, '.', '').'%';
$total_remitted_percentage = number_format($remitted_percentage, 2, '.', '').'%';
$total_delivered_percentage = number_format($delivered_percentage, 2, '.', '').'%';


// Account Per Mail

$get_Account_Mail = "SELECT accountNo , count(*)  as ttl FROM mails m WHERE m.receivedmailID = ".$RM_ID ." GROUP by accountNo";
$query_account_mail = $conn->query($get_Account_Mail) or die (mysqli_error($conn));

?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
           <title>Reports Generation</title>  
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Mail Status', 'Number'],  
                          <?php  
                          
                          		echo "
                              ['Unsorted Mails', ".$total_row."],
                              ['Queue Mails', ".$queue."],
                              ['Pending Mails', ".$pending."],
                              ['Delivered Mails', ".$delivered."],
                              ['Remitted Mails', ".$remitted."],
                              ['Completed Mails', ".$complete."],

                              ";

                          ?>  

                     ]);  
                var options = {  
                      title: 'Mail Status',  
                      subtitle: 'Received : 655  Deadline:11982',
                      //is3D:true,  
                      pieHole: 0.5  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>

           <style>

           #wrapper {
            display:grid;
            grid-template-columns: repeat(3,1fr);
            grid-column-gap:1em;
           }
             table {
                  table-layout: fixed;
                  word-wrap: break-word;
                }

              td {
                width: 10%
              }
}
           </style>  
      </head>  
      <body>  
        <h3 align="center"> Batch Mail No. <?php echo $RM_ID ?></h3>
          <div class="row">
           <div  class="col-lg-6 ">  
              <h3 align="center">Graph Summary</h3>  
              <br />  
              <div id="piechart" style="width: 900px; height: 500px;"></div>  
           </div>  
           <div class="col-lg-6">
            <h3 align="center">Narrative Summary</h3>

            <div class="col-lg-6 panel panel-default">
              <div class="panel-heading"> Batch Description:</div>
              <div class="panel-body"><strong>Received</strong>:<br><strong>Deadline </strong>: <?php echo $mnt; ?></div>
            </div>
           </div>
          </div>


          <div id="wrapper">
           <div id= "mail_chart">
            <h4 align="center">Mails</h4>
              <table class="table table-stripped table-boarder">
              <thead>
                <th>Type</th>
                <th>Quantity</th>
                <th>Percentage</th>
              </thead>
              <tbody>

                <tr><td >Unsorted Mails</td><td ><?php echo $total_row ?></td><td ><?php echo $total_unsort_percentage ?></td></tr> 
                <tr><td >Pending Mails</td><td ><?php echo $pending ?></td><td ><?php echo $total_pending_percentage ?></td></tr> 
                <tr><td >Queue Mails</td><td><?php echo $queue ?></td><td ><?php echo $total_queue_percentage ?></td></tr> 
                <tr><td >Delivered Mails</td><td><?php echo $delivered ?></td><td ><?php echo $total_delivered_percentage ?></td></tr> 
                <tr><td >Remitted Mails</td><td><?php echo $remitted ?></td><td><?php echo $total_remitted_percentage ?></td></tr> 
              </tbody>
              <tfoot style="background-color: #3B3738; color: white" >
                <td>Total Mails</td><td><?php echo $total_received?></td><td>100%</td>
              </tfoot>

              </table>          
            </div>
            <div id="account_chart">
              <h4 align="center">Accounts</h4>
                <table class="table table-stripped table-boarder" >
                  <thead>
                    <th>Account Number</th>
                    <th>Total Mails</th>
                  </thead>
                  <tbody>
                   <?php
                    while ($row = mysqli_fetch_array($query_account_mail))
                    {
                      $account_no =$row['accountNo'];
                      $account_total= $row['ttl'];
                    echo"
                    <tr>
                        <td>". $account_no. "</td>
                        <td>". $account_total. "</td>
                     </tr>
                        ";
                    }
                  ?>
                  </tbody>
                  </table>
            </div>
            <div id="RTS">
            <h4 align="center">Remittances</h3>
              <table class="table table-boarder table-stripped">
                <thead>
                  <th>Remittance Name</th>
                  <th>Quantity</th>
                </thead>
                <tbody>
                  <?php 
                    while ($row = mysqli_fetch_array($query_get_remittance)) {
                      $remittance_name = $row['RTSname'];
                      $remittance_quantity= $row['total'];
                      echo "
                      <tr>
                      <td>".$remittance_name."</td><td>".$remittance_quantity."</td>
                      </tr>
                      ";
                    }
                   ?>
                </tbody>
              </table>
            </div>
        </div>

      </body>  
 </html>  