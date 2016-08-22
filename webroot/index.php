<?php session_start();
include("../includes/config.php");

//echo strtotime("5:00 PM");
//echo ' '.date('h:i A',1471446000) ;

//echo ' '.strtotime("11:00 PM");

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
    <meta name="description" content="Lecture Hall Booking Portal">
    <meta name="author" content="Dhruvraj Singh Rawat">
    <title>Dashboard</title>

    

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">




  </head>

  <body>

  <nav class="navbar navbar-inverse">
        <div class="container-fluid">

            <!-- Logo -->
            <div class="navbar-header">
                <a href="#" class="navbar-brand">LT-RESERVATION</a>
            </div>

            <!-- Menu Items -->
            <div>
                <ul class="nav navbar-nav">
                    <li  class="active"><a href="index.php">Home</a></li>
                    <li><a href="book.php">Book</a></li>
                    <li><a href="history.php">History</a></li>
                    
                    <?php
                      if($_SESSION['login_privilage'] == 2){
                        ?>
                        <li><a href="create_account.php">Create Account</a></li>
                        
                        <?php

                      }
                                        
                    ?>
                    <li><a href="free_slot.php">Free Slots</a></li>                    
                    
                   
                </ul>
            </div>

            <div>
                <ul class="nav navbar-nav navbar-right">


                  <li ><a href="delete_reservation.php">Delete Reservation</a></li>


                    <?php
                      if($_SESSION['login_privilage'] == 2){
                        ?>
                        <li ><a href="delete_account.php">Delete Account</a></li>
                        <?php

                      }
                                        
                    ?>  

                    
                    <li><a href="change_password.php">Change Password</a></li>

             
                    <li><a  href="../logout.php">Log Out</a></li>
                </ul>
            </div>        

        </div>
    </nav>
    <br>
    <br>
    <br>

<div class="container">
      <div class="panel panel-default">
        <div class="panel-heading text-center" ><h3>DashBoard</h3></div>

          <div class="panel-body ">
            <form id="Dashboard" method="POST" class="form-horizontal text-center" action="#">

            <br>


              <div class="form-group">
                <label class="col-sm-2 control-label"  >User Name</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"  placeholder="

                  <?php    echo $_SESSION['login_admin']; ?> 



                  " disabled/></strong>
                  
                </div>
              </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"  >Position</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"   placeholder="

                  <?php echo $_SESSION['login_position']; ?>



                  " disabled/></strong>
                  
                </div>
              </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"  >Email</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"    placeholder="

                  <?php echo $_SESSION['login_email']; ?> 



                  " disabled/></strong>
                  
                </div>
              </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"  >Account Type</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"    placeholder="

                  <?php  if(@$_SESSION['login_privilage']==2){
            echo "Administrator ";
            }
            else{
                echo 'Basic Account';
                } ?>


                  " disabled/></strong>
                  
                </div>
              </div>


    <div class="form-group">
                <label class="col-sm-2 control-label"  >Total Booking For Today</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"    placeholder="

                  <?php
$date=date("d/m/Y");


$result=$conn->query("SELECT start_time  FROM users_booking WHERE date=STR_TO_DATE('$date','%d/%m/%Y')");


$count=$result->num_rows;
echo '              '.$count;

                
?>

                  



                  " disabled/></strong>
                  
                </div>
              </div>




           <div class="form-group">
                <label class="col-sm-2 control-label"  >Booking For today from this Account</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"    placeholder="
<?php
$date=date("d/m/Y");
$login_user=$_SESSION['login_admin'];

$result=$conn->query("SELECT start_time  FROM `users_booking` WHERE date=STR_TO_DATE('$date','%d/%m/%Y') AND `bookingID_name`='$login_user'");


$count=$result->num_rows;
echo '                                '.$count;

                
?>

                  



                  " disabled/></strong>
                  
                </div>
              </div>

           <div class="form-group">
                <label class="col-sm-2 control-label"  >Total Booking Recieved from this Account</label>
                <div class="col-sm-8">
                  <strong> <input type="text" class="form-control text-center"    placeholder="

<?php

$login_user=$_SESSION['login_admin'];

$result=$conn->query("SELECT start_time  FROM `users_booking` WHERE `bookingID_name`='$login_user'");


$count=$result->num_rows;
echo '                                  '.$count;

                
?>


                  



                  " disabled/></strong>
                  
                </div>
              </div>




            </form>
          </div>
        </div>
      </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted text-center">
            This Portal is Designed and Developed By <a href="https://www.linkedin.com/in/dhruvraj-rawat-96b67a3a">Dhruvraj Singh Rawat</a>

        </p>
      </div>
    </footer>


   


  </body>
</html>