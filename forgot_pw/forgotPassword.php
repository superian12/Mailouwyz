<?php
    include "../dbconnect.php";
    include "../system_command.php";
    require "../phpmailer/PHPMailerAutoload.php";

    


    $mail = new phpmailer;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    #$mail->Host = "ssl://smtp.gmail.com";
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "christian.ian.banzon@gmail.com";
    $mail->Password = "Lifegoeson12";
    #$mail->SMTPSecure = true;  
    $mail->SMTPSecure = 'tls';  
    #$mail->Port = "465";
    $mail->Port = 587;
    $mail->setFrom('christian.banzon@benilde.edu.ph', 'The Administrator');
    $mail->isHTML(true);
 
 

if(isset($_POST) & !empty($_POST))
    {

    $emailadd= mysqli_real_escape_string($conn,$_POST['emailadd']);



    $sql = "SELECT u.userid, u.email ,u.firstname, u.lastname FROM users u   WHERE  email = '$emailadd'";
    $query=$conn->query($sql) or die (mysqli_error($conn));

    if (mysqli_num_rows($query) > 0) {

         while($row = mysqli_fetch_array($query))
        {
            $userid = $row['userid'];
            $email = $row['email'];
            $fn = $row['firstname'];
            $ln = $row['lastname'];
        }



        #UPDATES PASSWORD   
        $keygen = rand(1000000,9999000);
        
        $update_password = "UPDATE users set pwdkey  = $keygen , sid = 2 WHERE userID = $userid ";
        $conn->query($update_password) or die (mysqli_error($conn));


            $mail->addAddress($email, $fn . " " . $ln);
            $mail->Subject = "Account Confirmation";
            $mail->Body = "
                    Good Day!<br/>
                    Mr. $ln , $firstname<br/>
                    your password had been reset and your forgot password code is now <u>$keygen</u>
                    <br/><br/>
                    Thank you for your continues support for Mailouwyz System
                   
            ";

            $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
                )
            );

               if(!$mail->send())
            {
         #       echo"<script type='text/javascript'>
          #          alert('Error in sending mail! Error ".$mail->ErrorInfo."');
           #         location='index.php';
            #        </script>";
                echo 'Mailer error: ' . $mail->ErrorInfo;
                 
            }
            else
            {
                echo"<script type='text/javascript'>
                    alert(' New password sent to Email !');
                    location='confirmpassword.php';
                    </script>";
                
            }
            #alert
       
    }
    
    else
    {   
       
        echo"<script type='text/javascript'>
                    alert(' Wrong Email !');
            
                    </script>";
        
    }
}


?>


<!DOCTYPE html>

<html>
    <head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

<form class="form-signin" method="POST">
  
      <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="" >Forgot Password </i>
                </h1>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-4">Email </label>
                        <div class="col-lg-8">
                            <input type="email" name="emailadd" class="form-control" placeholder="Email Address" required>
                            <br>

                        </div>
                        </div>
                  
                  
                  
                    <div class="form-group">           
                        <div>
                            <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Login
                            </button>
                        </div>
                    </div>
                      </div>
                 </div>
        </form>
    </body> 
</html>
