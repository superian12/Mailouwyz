<?php 
include '../system_command.php';

sendSMS('09178213064', 'Hellooo');
/*$keyt = 33;
$ch = curl_init();
$parameters = array(
    'apikey' => '2e05ca771a6637fcf1a428ad0a76f054', //Your API KEY
    'number' => '09156169613',
    'message' => 'Mikee Default name muna yung gamit na sender kasi kailangan pa i approve ng sephamore yung name'.$keyt,
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
echo $output;
*/


 ?>