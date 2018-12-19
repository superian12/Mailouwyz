<?php
 include "dbconnect.php";
     include "dbconnect.php";
    include "system_command.php";
    $sessionDepartment = '2';
    session_start();
    validateAccess($sessionDepartment);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Assign Area</title>
    </head>
    <body>
        <?php
            include('topmenu2.php');
        ?> 

         <div class="container">
            <div class="col-lg-offset-3 col-lg-6" >
                <h1 class="text-center" style="color:black;">
                    <i class="fa fa-envelope-o" > Assign  Messengers  </i>
                </h1>   
                	<form action ="" method="POST" class="form-horizontal well">
                    	<div class="form-group">
                        	<label class="control-label col-lg-3">Area: </label>
                        
                        <div class="col-lg-8">
                        	<select name="AreaID" class="form-control" required>
                            	<option value="">Select one...</option>
                            		<?php echo $goArea; ?>
                            </select>
                        </div>
                    </div>
                  <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-8">
                            <button name="addAssign" type="submit" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-plus"></i>Select Area
                            </button>
                        </div>
                    </div>
					
                </form>
            </div>
            </div>
    </body> 
</html>