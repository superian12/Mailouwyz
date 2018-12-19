<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Autocomplete textbox using jQuery, PHP and MySQL</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <style>  
           ul{  
                background-color:#eee;  
                cursor:pointer;  
           }  
           li{  
                padding:12px;  
           }  
           </style>  
      </head>  
      <body>  
           <br /><br />  
           <div class="form-group">
                        <label class="control-label col-lg-4">Account Number</label>
                        <div class="col-lg-8">  
                <input type="text" name="accountNo" id="accountNo" class="form-control" placeholder="Enter accountNo Name" />  
                <div id="account_number"></div>  
                </div>
                </div>
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#accountNo').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"search.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#account_number').fadeIn();  
                          $('#account_number').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  accountNo
           $('#accountNo').val($(this).text());  
           $('#account_number').fadeOut();  
      });  
 });  
 </script>  