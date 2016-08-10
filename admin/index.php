<?php session_start();
if (!$_SESSION['login_admin']){

    header("Location: ../login.php");
    die();
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>DashBoard</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">




  </head>

  <body>

  <nav class="navbar navbar-default">
        <div class="container-fluid">

            <!-- Logo -->
            <div class="navbar-header">
                <a href="#" class="navbar-brand">LT-REGISTRATION</a>
            </div>

            <!-- Menu Items -->
            <div>
                <ul class="nav navbar-nav">
                    <li  class="active"><a href="index.php">Home</a></li>
                    <li><a href="book.php">Book</a></li>
                    <li><a href="history.php">History</a></li>
                    
                    <li><a href="create_account.php">Create Account</a></li>

                    <li><a href="test.php">Testing</a></li>
                    
                   
                </ul>
            </div>

            <div>
                <ul class="nav navbar-nav navbar-right">
                    
                    <li><a  href="../logout.php">Log Out</a></li>
                </ul>
            </div>        

        </div>
    </nav>

 

    <div class="container">
    	<h2 class="text-center"><strong>Account Details</strong></h2>
    	<p class="text-left"><strong></strong></p><div class="well"><?php	echo $_SESSION['login_admin']; ?></div>

    	<div class="well"><?php echo $_SESSION['login_position']; ?>  
        </div>

    	<div class="well"><?php echo $_SESSION['login_email']; ?>           
        </div>

        <div class="well"><?php  if(@$_SESSION['login_privilage']==1){
            echo "Administrator Privilages";
            }
            else{
                echo 'Non-Administrator Account';
                } ?></div>

     

       
    	   
     
    </div>

    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   


  </body>
</html>