
 <?php
  include('smsChikka.php');
  include "dbconnect.php";

  if (isset($_GET['ID'])) {
  $userid = $_GET['ID'];
    $query = "SELECT firstname, lastname FROM users WHERE userid=$userid";   

    //Fetch records from MySQL
    $result = $conn->query($query); 
    if ($conn->error) {
      die("Query failed: " . $conn->error);
    }

    if (!$result->num_rows) {
      die("Record not found for Employee ID: " . $userid); 
    } else {
      $row = mysqli_fetch_assoc($result);
    }
  }



if(isset($_POST['submit'])){

$lastname = "";
$firstname = "";
$lastname= $_POST['lastname'];
$firstname= $_POST['firstname'];
}

echo "<script>
alert('Success! Message Delivered to Customer');
window.location.href='viewAreaAssignment.php';
</script>";

 function gen_random_string($length)
  {
    $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $final_rand ='';
    for($i=0;$i<$length; $i++)
    {
      $final_rand .= $chars[ rand(0,strlen($chars)-1)];;                 
    }
    return $final_rand;
  }


          $messageID = gen_random_string(32);
          
          $query3 = "SELECT mobileNumber FROM users Where userid = $userid";
         
          $result3 = $conn->query($query3);
          if ($result3->num_rows) {
            while ($row3 = mysqli_fetch_assoc($result3)){
              $to = $row3['mobileNumber'];

              $message = "Good day! " . $row['firstname'] . "" . $row['lastname'] . ", 
              We would like to inform you that you have a pending area that has been assign to you. Pleas login to see the area and kindly check the deadline. ";
              $clientId = '720ed6269a80183091ce97ae0fee05b746b6b0ad01d4a80c67edc50e11036ebb';
              $secretKey = '1f414c153d6a4191a9ee608355ef4ac67b8c7ee9fb25f8adfd6b2c2fe068a867';
              $shortCode = '29290761';
              //$clientId = '720ed6269a80183091ce97ae0fee05b746b6b0ad01d4a80c67edc50e11036ebb';
              //$secretKey = '1f414c153d6a4191a9ee608355ef4ac67b8c7ee9fb25f8adfd6b2c2fe068a867';
              //$shortCode = '29290761';
              $chikkaAPI = new ChikkaSMS($clientId,$secretKey,$shortCode);
              $response = $chikkaAPI->sendText($messageID, $to, $message);

              header("Location: viewAreaAssignment.php?message=The SMS Message has been sent.&type=success");
            }
          }
        


      
      ?>