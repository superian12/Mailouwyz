<?php 
       include "dbconnect.php";
       include "system_command.php";
       $sessionDepartment = '2';
       session_start();
       validateAccess($sessionDepartment);

       // GET USER
           $sqlUser="SELECT Lastname FROM users  WHERE userID =".$_SESSION['userid'];
        $queryUsers = $conn->query($sqlUser) or die (mysqli_error($conn));
        $DashID = "";
        while ($row = mysqli_fetch_array($queryUsers))
        {
            $Name = $row["Lastname"];
            $DashID = $Name;
        }

 ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
       <link href="assets/calCss.css" rel="stylesheet" type="text/css" medeia="all" />

    <script language="JavaScript" type="text/javascript">
        function initialCalendar() {
            var hr = new XMLHttpRequest();
            var url = "calendar.php";
            var currentTime = new Date();
            var month = currentTime.getMonth() + 1;
            var year = currentTime.getFullYear();
            showmonth = month;
            showyear = year;
            var vars = "showmonth="+showmonth+"&showyear="+showyear;
            hr.open("POST", url, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4  && hr.status == 200) {
                    var return_data = hr.responseText;
                    document.getElementById("showCalendar").innerHTML = return_data;
                }
            }
            hr.send(vars);
            document.getElementById("showCalendar").innerHTML = "Loading...";
        }
    </script>

    <script language="JavaScript" type="text/javascript">
        function next_month() {
            var nextmonth = showmonth + 1;
            if(nextmonth > 12) {
                nextmonth = 1;
                showyear = showyear + 1;
           }
            showmonth = nextmonth;
            var hr = new XMLHttpRequest();
            var url = "calendar.php";
            var vars = "showmonth="+showmonth+"&showyear="+showyear;
            hr.open("POST", url, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4  && hr.status == 200) {
                    var return_data = hr.responseText;
                    document.getElementById("showCalendar").innerHTML = return_data;
                }
            }
            hr.send(vars);
            document.getElementById("showCalendar").innerHTML = "Loading...";
        }
    </script>

    <script language="JavaScript" type="text/javascript">
        function last_month() {
            var lastmonth = showmonth - 1;
            if(lastmonth < 1) {
                lastmonth = 12;
                showyear = showyear - 1;
           }
            showmonth = lastmonth;
            var hr = new XMLHttpRequest();
            var url = "calendar.php";
            var vars = "showmonth="+showmonth+"&showyear="+showyear;
            hr.open("POST", url, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4  && hr.status == 200) {
                    var return_data = hr.responseText;
                    document.getElementById("showCalendar").innerHTML = return_data;
                }
            }
            hr.send(vars);
            document.getElementById("showCalendar").innerHTML = "Loading...";
        }
    </script>

    <script type="text/javascript">
        function overlay() {
            el = document.getElementById("overlay");
            el.style.display = (el.style.display == "block") ? "none" : "block";
            el = document.getElementById("events");
            el.style.display = (el.style.display == "block") ? "none" : "block";
            el = document.getElementById("eventsBody");
            el.style.display = (el.style.display == "block") ? "none" : "block";

        }
    </script>

    <script language="JavaScript" type="text/javascript">
        function show_details(theId) {
            var deets = (theId.id);
           el = document.getElementById("overlay");
            el.style.display = (el.style.display == "block") ? "none" : "block";
            el = document.getElementById("events");
            el.style.display = (el.style.display == "block") ? "none" : "block";
            var hr = new XMLHttpRequest();
            var url = "events.php"
            var vars = "deets="+deets;
            hr.ope("POST", url, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    var return_data = hr.responseText;
                    document.getElementById("events").innerHTML = return_data;
                }
        } 
        hr.send(vars);
        document.getElementById("events").innerHTML = "Loading...";
    }

    </script>
        <title></title>

    <style type="text/css">
        .detailButton {
            margin-top: 40px;
            clear: left;
            text-align: center;
        }
    </style>    
    </head>
    <body onLoad="initialCalendar();">
        <?php 
         include("topmenu2.php");  
        ?> 
          <div id="showCalendar"></div>
          <div id="overlay">
            <div id="events"></div>
        </div>
    </body>
</html>
