<?php
$deets = $_POST['deets'];
$deets = preg_replace('#[0-9-]#i', '', $deets);

include('dbconnect.php');

$events = '';
$sql = 'SELECT descrip  FROM calendar WHERE evedate = "'.$deets.'"';
$result = $conn->query($sql);
if($result->num_rows > 0) {
			echo '<div id="evetsControl"><button onMouseDown="overlay()">Close</button><br /><b>'. $deets .'</b><br /></div>';
			while($row = mysqli_fetch_array($result)) {
				$descrip = $row['descrip'];
				$events .= '<div id="evetsBody">'.$descript.'<br /><hr><br /></div>';
			}
		}
	echo $events;
?> 