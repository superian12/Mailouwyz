<?php
//load the database configuration file
include 'dbConfig.php';

if(isset($_POST['importSubmit'])){
    
    //validate whether uploaded file is a csv file
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip first line
            fgetcsv($csvFile);
            
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
                $prevQuery = "SELECT accountNo FROM accounts WHERE email = '".$line[5]."'";
                $prevResult = $db->query($prevQuery);
                if($prevResult->num_rows > 0){
                    //update member data
                    $db->query("UPDATE accounts SET accountNo = '".$line[0]."', firstname = '".$line[1]."', middlename = '".$line[2]."', lastname = '".$line[3]."', houseNo = '".$line[4]."', streetName = '".$line[5]."', city = '".$line[6]."', region = '".$line[7]."', areaID = '".$line[8]."', mobile = '".$line[9]."', statusID = '".$line[11]."' WHERE email = '".$line[10]."'");
                }else{
                    //insert member data into database
                    $db->query("INSERT INTO accounts (accountNo, firstname, middlename, lastname, houseNo, streetName, city, region, areaID, mobile, email, statusID) VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".$line[6]."','".$line[7]."','".$line[8]."','".$line[9]."','".$line[10]."','".$line[11]."')");
                }
            }
            
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

//redirect to the listing page
header("Location: viewAccount.php".$qstring);