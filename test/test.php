<?php 

  include '../dbconnect.php';
  include '../system_command.php';

  if (isset($_POST['submit'])) {

          $validator ='';


          $accountNo = mysqli_real_escape_string($conn,$_POST['input_id']);
          $get_id = 'SELECT * from accounts WHERE accountNo = '.$accountNo ;
          $query_get_id =$conn->query($get_id) or die (mysqli_error($conn));

          if(mysqli_num_rows($query_get_id))
          {    
               $validator++;
               echo "<script>alert('Account Number already Exist')</script>";
          }
          if($accountNo <= 0 )
          {
               $validator++;
               echo "<script>alert('Account Number already Exist you retard')</script>";
          }
          else 
          {
               echo "<script>alert('Every Thing is alright')</script>";
          }

        

}

  //sendEmail('christian.ian.banzon@gmail.compact(varname)','christian','banzon','test','You can pass this');


 ?>


 <!DOCTYPE html>
 <html>
 <head>
   <title>Test Validate</title>
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 </head>
 <body>
  <form method="POST">
    <label>Account No.</label>
    <input type="number" name="input_id">
    <button id='submit' name="submit" class="button">Add me up</button>
  </form>
 </body>
 </html>