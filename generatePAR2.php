<?php
    include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '1';
    session_start();
    validateAccess($sessionDepartment);
    if(!isset($_GET['m']))
    {
        header('location:viewpsr2.php');
    }
    // Get Messenger Name
        $get_messenger = "SELECT firstName , lastName FROM users where userid = ".$_GET['m'];
        $query_get_messenger = $conn->query($get_messenger) or die (mysqli_error($conn));
        while ($row = mysqli_fetch_array($query_get_messenger)) {
            $messenger_full_name = $row['lastName'].', '.$row['firstName'];
        }

        $get_all_performance = "SELECT pa.PAsurveyID,pa.mailNo, pa.accountNo ,pa.quest1,pa.quest2,pa.quest3,pa.remarks,pa.recommendation from performanceassessments pa INNER JOIN mails m ON m.mailNo = pa.mailNo INNER JOIN users u ON m.messenger = u.userid INNER JOIN accounts ac ON ac.accountNo = pa.accountNo where m.messenger=".$_GET['m'] ;

        $query_get_all_performance = $conn-> query($get_all_performance) or die (myqli_error($conn));

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
            margin-left: 200px;
            margin-right: 200px;
            margin-top:50px;
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
    <?php include 'topmenu.php'; ?>
 <h3 align="center" id="messenger_heading">Performance Assesment Of <?php echo $messenger_full_name ?></h3>



    <div id="wrapper">
        <div id="pa-table">
            <h3 align="center">Performance Survey</h3>
            <form class="form-horizontal well">
                <table class="table table-stripped table-boarder">
                    <thead>
                        <th>Mail #</th>
                        <th>Account #</th>
                        <th>Question #1</th>
                        <th>Question #2</th>
                        <th>Question #3</th>
                        <th>Remarks</th>
                        <th>Recommendations</th>
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

                                echo "
                                <tr>
                                    <td>".$mail_number."</td>
                                    <td>".$account_number."</td>
                                    <td>".$question_1."</td>
                                    <td>".$question_2."</td>
                                    <td>".$question_2."</td>
                                    <td>".$remarks."</td>
                                    <td>".$recommendation."</td>
                                </tr>";
                             } 
                         ?>
                    </tbody>
                </table>
            </form>
        </div>

           
        <div id="mail_bar">
            <h3 align="center">Mail Report</h3>
            <form class="form-horizontal well">
                <table class="table table-stripped table-boarder                                                                                                                                                     ">
                    <thead>
                        <th>Batch#</th>
                        <th> # of Mails</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2</td>
                            <td>250</td>
                        </tr>
                    </tbody>
                </table>

            </form>
             <script type="text/javascript">
        function print_page() {
            var ButtonControl = document.getElementById("btnprint");
            ButtonControl.style.visibility = "hidden";
            window.print();
        }
    </script>

          <div class="col-lg-8">
            <button type="button" id="btnprint" value="Print this Page" onclick="print_page()" class="btn btn-success btn-lg pull-right">
            <i class="fa fa-plus"></i> Print Page
                    </button>
                        </div>
        </div>
    </div>

</body>
</html>