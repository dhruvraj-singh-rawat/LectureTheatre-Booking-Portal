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
                    <li ><a href="index.php">Home</a></li>
                    <li><a href="book.php">Book</a></li>
                    <li  class="active"><a href="history.php">History</a></li>
                    
                    <li><a href="create_account.php">Create Account</a></li>
                   
                    
                   
                </ul>
            </div>

            <div>
                <ul class="nav navbar-nav navbar-right">
                    
                    <li><a  href="../logout.php">Log Out</a></li>
                </ul>
            </div>        

        </div>
    </nav>

        </div>
    </nav>

   <div class="container">
    <h2 class="text-center"><strong>BOOKING HISTORY    </strong></h2>

            <table class="table table-hover ">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Booking ID</th>
                      <th>Event Superviser</th>
                      <th>Event Name</th>
                      <th>Club</th>
                      <th>LT-Selected</th>
                      <th>Date</th>
                      <th>Starting Time</th>
                      <th>Ending Time</th>
                      <th>Message</th>
                    </tr>
                  </thead>
                    <tbody>

                    <?php

                    include("../includes/config.php");

                    $account_admin=$_SESSION['login_admin'];
                    $account_privilage=$_SESSION['login_privilage'];
                    if ($account_privilage==1){


                        $result=$conn->query("SELECT name_event,lt_selected,bookingID_name,date,message,club_name,start_time,end_time,name_superviser  FROM users_booking ");

                        $count=1;



                        while($row = $result->fetch_assoc()){
                        ?>
                            <tr>
                            <th scope=\"row\"><?php echo "$count" ;?></th>
                            <td><?php echo $row["bookingID_name"] ;?></td>
                            <td><?php echo $row["name_superviser"] ;?></td>
                            <td><?php echo $row["name_event"] ;?></td>
                            <td><?php echo $row["club_name"] ;?></td>
                            <td><?php echo $row["lt_selected"] ;?></td>
                             <td><?php echo date('d-M-Y', strtotime(str_replace('-', '/',$row["date"]))) ;?></td>
                             <td><?php echo date('h:i A', strtotime($row["start_time"]))  ;?></td>
                             <td> <?php echo date('h:i A',strtotime($row["end_time"]))  ;?></td>
                            <td><?php echo $row["message"] ;?></td>
                            </tr>

                            <?php
                            $count=$count+1;

                            }



                    }

                    else{

                             $result=$conn->query("SELECT name,lt_selected,bookingID_name,message,club_name FROM users_booking WHERE bookingID_name='$account_admin'");

                                $count=1;

                                while($row = $result->fetch_assoc()){

                                ?>
                                    <tr>
                                    <th scope=\"row\"><?php echo "$count" ;?></th>
                                    <td><?php echo $row["bookingID_name"] ;?></td>
                                    <td><?php echo $row["name"] ;?></td>
                                    <td><?php echo $row["club_name"] ;?></td>
                                    <td><?php echo $row["lt_selected"] ;?></td>
                                    <td><?php echo $row["message"] ;?></td>
                                    </tr>

                                    <?php
                                    $count=$count+1;

                                    }

                         }

 
                    ?>


                      
                  </tbody>
        </table>
    </div>

 


    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>

  </body>
</html>