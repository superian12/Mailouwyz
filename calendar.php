<?php
    include('dbconnect.php');

	$showmonth = $_POST['showmonth'];
	$showyear = $_POST['showyear'];
	$showmonth = preg_replace('#[^0-9]#i', '', $showmonth);
	$showyear = preg_replace('#[^0-9]#i', '', $showyear);

	$day_count = cal_days_in_month(CAL_GREGORIAN, $showmonth, $showyear);
	$pre_days = date('w', mktime(0, 0, 0, $showmonth, 1, $showyear));
	$post_days = (6 - (date('w', mktime(0, 0, 0, $showmonth, $day_count, $showyear))));

	echo '<div id="calendar_wrap">';
	echo '<div class="title_bar">';
	echo '<div class="previous_month"><input name="button" type="submit" value="Previous Month" onClick="javascript:last_month();"></div>';
	echo '<div class="show_month">' . $showmonth . '/' . $showyear . '</div>';
	echo '<div class="next_month"><input name="button" type="submit" value="Next Month" onClick="javascript:next_month();"></div>';
	echo '</div>';

	echo '<div class="week_days">';
	echo '<div class="days_of_week">Sun</div>';
	echo '<div class="days_of_week">Mon</div>';
	echo '<div class="days_of_week">Tue</div>';
	echo '<div class="days_of_week">Wed</div>';
	echo '<div class="days_of_week">Thur</div>';
	echo '<div class="days_of_week">Fri</div>';
	echo '<div class="days_of_week">Sat</div>';
	echo '<div class="clear"></div>';
	echo '</div>';

/* Previous Month Filler Days */
	if ($pre_days != 0) {
		for($i=1; $i<=$pre_days; $i++) {
			echo '<div class="non_cal_day"></div>';
		}
	}
/* Current Month */
	for($i=1; $i<= $day_count; $i++) {
		//get events
		$date = $showyear.'-'.$showmonth.'-'.$i;

		$sql = 'SELECT *  FROM calendar WHERE evedate = "'.$date.'"';
		$result = $conn->query($sql);

		echo '<div class="cal_day">';
		echo '<div class="day_heading">' . $i . '</div>';

		//check if there is event and show event details button
		if($result->num_rows > 0) {
			?>
				<!-- Button trigger modal -->
				<div class='detailButton'>
					<!-- data-target attribute should be the same as id of modal-->
					<button type="button" class="btn btn-default btn-success" data-toggle="modal" data-target="#<?php echo $date; ?>">
					  Deadline
					</button>
				</div>

				<!-- Modal -->
				<!-- id of modal should be the same as button's data-target attribute-->
				<div class="modal fade" id="<?php echo $date; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">
				        	<?php 
				        		//get the date and convert it to Month Day, Year format
				        		echo date('F j, Y', strtotime($date)); 
				        	?>
				        </h4>
				      </div>
				      <div class="modal-body">
					      <?php
					      	//get all description
							while($row = $result->fetch_assoc()) {
								echo "<p>" .$row['descrip']."</p><hr>";
							}
					      ?>
				      </div>
				    </div>
				  </div>
				</div>
				<!-- End of Modal -->
			<?php
		}
		echo ' </div>';
	}
/* Next Month Filler Days */
	if($post_days != 0) {
		for($i=1; $i<=$post_days; $i++) {
			echo '<div class="non_cal_day"></div>';
		}
	}

	echo '</div>';
?> 