 <?php  
include 'dbconnect.php';
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM accounts WHERE statusID=1 and accountNo LIKE '%".$_POST["query"]."%'
      OR firstname LIKE '%".$_POST["query"]."%' or lastname LIKE '%".$_POST["query"]."%' ";  
      $result = $conn->query($query) or die (mysqli_error($conn));
      $output = '<ul class="list-unstyled">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '<li value='.$row["accountNo"].'>'.$row["accountNo"].'- '.$row["lastname"].', '.$row["firstname"].' </li>
                ';  
           }  
      }  
      else  
      {  
           $output .= '<li>Account Number not found</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
 ?>  