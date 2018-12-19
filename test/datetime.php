<?php 

  include '../system_command.php';
 $date2=date("d-m-Y");//today's date

   $date1=new DateTime("30-01-1983");
   $date2=new DateTime($date2);

   $interval = $date1->diff($date2);

   

   $myage= $interval->d; 

   echo $myage;

  /*if ($myage >= 16){ 
     echo "var_dump(expression)lid age";} 
  else{ 
     echo "Invalid age";}
  */

   // $today =date("d-m-Y");
   // $birth = new DateTime("30-11-1997");
//$today = new DateTime($today);
   //// $age = $today-$birth;
    //$age = $birth->diff($today);
    //$age = $age->y;

    //if(strtotime($today) > strtotime($birth));
   // {
   //   echo "Tommy Lee";
   // }

//if( strtotime($database_date) > strtotime('now') )
   //	echo "<script>alert('$age')</script>";

/*$input = 2014-07-31;
$date = new DateTime($input);
$now = new DateTime();

if($date < $now) {

    //philippineTime();
    //echo greaterTime($date);
  }
if(greaterTime($date) ==1)
{
  echo"Yehey"; 
}
  




 ?>
 */