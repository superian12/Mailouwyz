<?php
require_once "dbconnect.php";
date_default_timezone_set('Asia/Manila');


	function DashID()
	{
		
		include "dbconnect.php";
		$sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
        $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
        while ($row = mysqli_fetch_array($queryUsers))
        {
            $Name = $row["Lastname"];
            $DashID = $Name;
        }

        return $DashID;

	}
	function validateAccess($deptID)
	{
		if (!isset($_SESSION['userid']) || $deptID != $_SESSION['departmentID'] )
		{
			unset($_SESSION['userid']);
			unset($_SESSION['departmentID']);
			header('location: index.php');		
		}			 
	}	
	function sendEmail($email, $subject, $message)
	{
		include_once('phpmailer/PHPMailerAutoload.php');
		$mail = new PHPMailer;

		if(!$mail->validateAddress($email))
		{
			echo 'Invalid Email Address';
			exit;
		}


	    $mail = new phpmailer;
	    $mail->SMTPDebug = 0;
	    $mail->isSMTP();
	    $mail->Host = "smtp.gmail.com";
	    $mail->SMTPAuth = true;
	    $mail->Username = "christian.ian.banzon@gmail.com";
	    $mail->Password = "Lifegoeson12";
	    $mail->SMTPSecure = 'tls';  
	    $mail->Port = 587;
	    $mail->setFrom('christian.banzon@benilde.edu.ph', 'The Administrator');
	    $mail->isHTML(true);
	    // Send part
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;

            $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
                )
            );

               if(!$mail->send())
            {
                return 'Mailer error: ' . $mail->ErrorInfo;
            }
            else
            {
                return "<script type='text/javascript'>
                    alert(' New password sent to Email !');
                    location='confirmpassword.php';
                    </script>";
            }
		/*
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "christian.ian.banzon@benilde.edu.ph";
		$mail->Password = "Lifegoeson12";
		$mail->SetFrom("christian.ian.banzon@gmail.com");
		$mail->FromName = "Mailouiyz";
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress($email);
		$mail->Send();
		*/
	}

	function philippineTime()
	{
		date_default_timezone_set('Asia/Manila');
		echo date("d-m-Y  h:i:sa");

	}
	function sendSMS($number, $message){

		$ch = curl_init();
		$parameters = array(
		    'apikey' => '2e05ca771a6637fcf1a428ad0a76f054', //Your API KEY
		    'number' =>	$number ,
		    'message' => $message,
		    'sendername' => ''
		);
		curl_setopt( $ch, CURLOPT_URL,'http://api.semaphore.co/api/v4/messages' );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		//Send the parameters set above with the request
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

		// Receive response from server
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $ch );
		curl_close ($ch);

		//Show the server response
		

	}
	function stringDate($month , $year){
		$str_month='';

		if($month == 1){
			$str_month ='January '.$year;
		}
		else if($month==2){
			$str_month='Febuary '.$year;
		}
		elseif ($month==3) {
			$str_month='March ' . $year;
		}
		elseif ($month==4) {
			$str_month='April ' .$year
			;
		}
		elseif ($month==5) {
			$str_month='May '.$year;
		}
		elseif ($month==6) {
			$str_month='June '.$year;
		}
		elseif ($month==7) {
			$str_month='July '.$year;
		}
		elseif ($month==8) {
			$str_month='August '.$year;
		}
		elseif ($month==9) {
			$str_month='September '.$year;
		}
		elseif ($month==10) {
			$str_month='October '.$year;
		}
		elseif ($month==11) {
			$str_month='November '.$year;
		}
		elseif ($month==12) {
			$str_month='December ' .$year;
		}

		return $str_month;
	}
	function completeStringDate($month , $year,$day){
		$str_month='';

		if($month == 1){
			$str_month ='January '.$day.' '.$year;
		}
		else if($month==2){
			$str_month='Febuary '.$day.' '.$year;
		}
		elseif ($month==3) {
			$str_month='March ' .$day.' '.$year;
		}
		elseif ($month==4) {
			$str_month='April ' .$day.' '.$year;
			
		}
		elseif ($month==5) {
			$str_month='May '.$day.' '.$year;
		}
		elseif ($month==6) {
			$str_month='June '.$day.' '.$year;
		}
		elseif ($month==7) {
			$str_month='July '.$day.' '.$year;
		}
		elseif ($month==8) {
			$str_month='August '.$day.' '.$year;
		}
		elseif ($month==9) {
			$str_month='September '.$day.' '.$year;
		}
		elseif ($month==10) {
			$str_month='October '.$day.' '.$year;
		}
		elseif ($month==11) {
			$str_month='November '.$day.' '.$year;
		}
		elseif ($month==12) {
			$str_month='December ' .$day.' '.$year;
		}

		return $str_month;
	}




	
?>

	

