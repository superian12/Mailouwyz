<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
    if(!isset($_GET['m']))
    {
        header('location:viewpsr.php');
    }

    if(!isset($_GET['d']) && !isset($_GET['y'])){
     
    $current_fitler= 'All Records';
    // Get Messenger Name
        $get_messenger = "SELECT firstName , lastName FROM users where userid = ".$_GET['m'];
        $query_get_messenger = $conn->query($get_messenger) or die (mysqli_error($conn));
        while ($row = mysqli_fetch_array($query_get_messenger)) {
            $messenger_full_name = $row['lastName'].', '.$row['firstName'];
        }

        $get_all_performance = "SELECT pa.PAsurveyID,pa.mailNo, year(pa.dateFilled) as f_year, month(pa.dateFilled) as f_m , day(pa.dateFilled) as f_date,pa.accountNo ,pa.quest1,pa.quest2,pa.quest3,pa.remarks,pa.recommendation,ac.firstname , ac.lastname from performanceassessments pa INNER JOIN mails m ON m.mailNo = pa.mailNo INNER JOIN users u ON m.messenger = u.userid INNER JOIN accounts ac ON ac.accountNo = pa.accountNo where m.messenger=".$_GET['m'] ;

        $query_get_all_performance = $conn-> query($get_all_performance) or die (myqli_error($conn));

    }
    else{
        $current_fitler = stringDate($_GET['d'],$_GET['y']);

        $get_messenger = "SELECT firstName , lastName FROM users where userid = ".$_GET['m'];
        $query_get_messenger = $conn->query($get_messenger) or die (mysqli_error($conn));
        while ($row = mysqli_fetch_array($query_get_messenger)) {
            $messenger_full_name = $row['lastName'].', '.$row['firstName'];
        }

        $get_all_performance = "SELECT pa.PAsurveyID,pa.mailNo,year(pa.dateFilled) as f_year, month(pa.dateFilled) as f_m , day(pa.dateFilled) as f_date, pa.accountNo ,pa.quest1,pa.quest2,pa.quest3,pa.remarks,pa.recommendation , ac.firstname ,pa.dateFilled, ac.lastname from performanceassessments pa INNER JOIN mails m ON m.mailNo = pa.mailNo INNER JOIN users u ON m.messenger = u.userid INNER JOIN accounts ac ON ac.accountNo = pa.accountNo where m.messenger=".$_GET['m']." and month(pa.dateFilled) = ".$_GET['d']." AND year(pa.dateFilled) = ".$_GET['y'];

        $query_get_all_performance = $conn-> query($get_all_performance) or die (myqli_error($conn));

    }

        if(isset($_POST['submit'])){
            $month = mysqli_real_escape_string($conn,$_POST['month']);
            $year = mysqli_real_escape_string($conn,$_POST['year']);
            header('location:generatePAR.php?m='.$_GET['m'].'&d='.$month.'&y='.$year);
        }


?>
<!DOCTYPE html>
<html>
<head> 
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href-="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <style type="text/css">

      #wrapper {
            display: grid;
            grid-template-columns:2fr 1fr;
            margin-left: 20px;
            margin-right: 20px;

        }
    
        #mail_bar{
            margin-left: 50px;
        }
        #messenger_heading
        {
            margin-top:50px;
        }
    </style>

</head>
<body>
    <?php include 'topmenu2.php'; ?>
 <h3 align="center" id="messenger_heading">Performance Assesment Of <?php echo $messenger_full_name ?></h3>
 <br>
<h4 align="center"><?php echo $current_fitler ?></h4>



    <div id="wrapper">
        <div id="pa-table">
            <h3 align="center">Performance Survey</h3>
            <form class="form-horizontal well" method="POST">
                <table class="table table-stripped table-boarder">
                    <thead>
                        <th>Mail #</th>
                        <th>Account #</th>
                        <th>Account Name</th>
                        <th>Question #1</th>
                        <th>Question #2</th>
                        <th>Question #3</th>
                        <th>Remarks</th>
                        <th>Recommendations</th>
                        <th>Date Filled</th>
                    </thead>
                    <tbody>
                        <?php
                            while ($row=mysqli_fetch_array($query_get_all_performance)) {
                                $survey_id = $row['PAsurveyID'];
                                $mail_number = $row['mailNo'];
                                $account_number = $row['accountNo'];
                                $question_1 = $row['quest1'];
                                $question_2 = $row['quest2'];
                                $question_3 = $row['quest3'];
                                $remarks = $row['remarks'];
                                $recommendation = $row['recommendation'];
                                $accountName = $row['lastname']. ','.$row['firstname'];
                                $full_date = completeStringDate($row['f_m'],$row['f_year'],$row['f_date']);



                                echo "
                                <tr>
                                    <td>".$mail_number."</td>
                                    <td>".$account_number."</td>
                                    <td>$accountName</td>
                                    <td>".$question_1."</td>
                                    <td>".$question_2."</td>
                                    <td>".$question_2."</td>
                                    <td>".$remarks."</td>
                                    <td>".$recommendation."</td>
                                    <td>$full_date</td>
                                </tr>";
                             } 
                         ?>
                    </tbody>
                </table>
            </form>
        </div>

           
        <div id="mail_bar">
            <h3 align="center">Mail Report</h3>
            <form class="form-horizontal well" method="POST">
                <table class="table table-stripped table-boarder                                                                                                                                                     ">
                    <thead>
                        <th>Date#</th>
                        <th>Year</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><select name="month" id="month"  required> 
                        <option value="">Select....</option>
                        <option value="1">January </option>
                        <option value="2">Febuary  </option>
                        <option value="3">March </option>
                        <option value="4">April </option>
                        <option value="5">May </option>
                        <option value="6">June </option>
                        <option value="7">July </option>
                        <option value="8">August </option>
                        <option value="9">September </option>
                        <option value="10">October </option>
                        <option value="11">November </option>
                        <option value="12">December </option>

                        </select> </td>
                            <td><input style="width: 100px" type="text" name="year" required=""></td>
                        </tr>
                    </tbody>
                </table>


          <div class="col-lg-8">
           <button name="submit" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i> Add Filter
                            </button>
                        </div>

            </form>
    <!--
             <script type="text/javascript">
        function print_page() {
            var ButtonControl = document.getElementById("btnprint");
            ButtonControl.style.visibility = "hidden";
            window.print();
        }
    </script>
-->
        </div>
    </div>

</body>
</html>