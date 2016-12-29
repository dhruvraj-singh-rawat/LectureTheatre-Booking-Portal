<?php session_start();
include("../includes/config.php");
if ((!$_SESSION['login_admin'] ) ){
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
 

    <link type="text/css" href="../css/bootstrap-timepicker.min.css" /

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">


  <link rel="stylesheet" href="../css/jquery.timepicker.min.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="../js/jquery-1.12.4.js"></script>
  <script src="../js/jquery-ui.js"></script>
   <script src="../js/jquery.timepicker.min.js"></script>
   <script src="../js/moment.min.js"></script>


  <!-- BootstrapValidator CSS -->
    <link href="../css/bootstrapValidator.min.css" rel="stylesheet"/>
  
    <!-- jQuery and Bootstrap JS -->
  
  <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    
  <!-- BootstrapValidator -->
    <script src="../js/bootstrapValidator.min.js" type="text/javascript"></script>


  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2D" , dateFormat: 'dd-mm-yy'});
  } );
  </script>




</head>
<body>
  <nav class="navbar navbar-inverse">
        <div class="container-fluid">

            <!-- Logo -->
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand">LT-RESERVATION</a>
            </div>

            <!-- Menu Items -->
            <div>
                <ul class="nav navbar-nav">
                    <li ><a href="index.php">Home</a></li>
                    <li ><a href="book.php">Book</a></li>
                    <li ><a href="history.php">History</a></li>
                    
                   <?php
  if($_SESSION['login_privilage'] == 2){
    ?>
    <li><a href="create_account.php">Create Account</a></li>
    
    <?php

  }
                    
?> 
					<li  class="active" ><a href="free_slot.php">Free Slots</a></li>
                   
                    
                   
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


    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading text-center" ><h3>Free Slot Finder</h3></div>

          <div class="panel-body">
            <form id="free_slot-form" method="POST" class="form-horizontal" action="#">

            <br>


              

              <div class="form-group">
                <label class="col-md-2 control-label" for="Date">Date</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="datepicker" name="date" placeholder="DD-MM-YYYY"  />
                </div>
              </div>




              <div class="form-group">
                <label class="col-md-2 control-label" for="lt_selected">Select Desired LT</label>
                <div class="col-md-4">
                  <select class="form-control" id="lt_selected" name="lt_selected">
                    <option value="0">Choose One</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>                
              </div>



            </form>
          </div>
        </div>
      </div>
      <br>
      <br>


      <div class="container">
        <h2 class="text-center"><strong></strong></h2>
        <br>

        <table class="table table-striped table-bordered table-hover" id="history">
          <thead>

              <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>

              </tr>
            
          </thead>


          <tfoot>

              <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>

              </tr>
            
          </tfoot>

          <tbody>

                <?php

                   
                    if ($_SERVER["REQUEST_METHOD"]=="POST"){

                    	$date=$conn->real_escape_string($_POST['date']);
                    	$lt_selected=$conn->real_escape_string($_POST['lt_selected']);


                        $result=$conn->query("SELECT start_time,end_time  FROM users_booking WHERE date=STR_TO_DATE('$date','%d-%m-%Y') AND lt_selected=$lt_selected ORDER BY start_time ASC");

                        $count=1;
                        $temp_start=0;
                        $temp_end_current=0;
                        $temp_end_previous=0;
                        $count_inside=0;
                        $loop_round=0;

                        while($row = $result->fetch_assoc()){

                            if($loop_round==0){
                              //echo 'inside 1';
                              $temp_start=strtotime($row["start_time"]);
                              $temp_end_current=strtotime($row["end_time"]);

                            }
                            else{
                             // echo 'inside 2';
                              $temp_start=strtotime($row["start_time"]);
                              $temp_end_previous=$temp_end_current;
                              $temp_end_current=strtotime($row["end_time"]);

                              //echo 'The previous temp is '.$temp_end_previous.' and the current temp is '.$temp_end_current.' and temp start is '.$temp_start;

                            }

                            if($temp_start>=strtotime("05:00 PM") && $temp_end_current<=strtotime("11:00 PM")){


                             // echo 'inside 3';
                              $count_inside=1;

                              if($loop_round==0 && $temp_start>strtotime("05:00 PM")){
                                ?>
                                <tr>
                                <th scope=\"row\"><?php echo "$count" ;?></th>
                                <td><?php echo date('h:i A',strtotime("05:00 PM")) ;?></td>
                                <td><?php echo date('h:i A',$temp_start) ;?></td>
                                </tr>



                                <?php
                                $count=$count+1;
                              }
                              else{
                                if($temp_start!=$temp_end_previous && ($count!=1 || $loop_round>0)){
                                  //echo 'inside 4';
                                  ?>
                                  <tr>
                                  <th scope=\"row\"><?php echo "$count" ;?></th>
                                  <td><?php echo date('h:i A',$temp_end_previous) ;?></td>
                                  <td><?php echo date('h:i A',$temp_start) ;?></td>
                                  </tr>
                                  <?php
                                  $count=$count+1;


                                }
                              }


                            }
                            $loop_round+=1;



                        }

                  if($temp_end_current<strtotime("11:00 PM") && $count_inside==0){
                    //echo 'Inside 5';
                  	?>
                    <tr>
                  	<th scope=\"row\"><?php echo "$count" ;?></th>
                  	<td><?php echo date('h:i A',strtotime("05:00 PM")) ;?></td>
                  	<td><?php echo date('h:i A',strtotime("11:00 PM")) ;?></td>
                    </tr>
                  	<?php

                  }
                  elseif($temp_end_current<strtotime("11:00 PM")){
                    //echo 'Inside 6';
                    ?>
                    <tr>
                    <th scope=\"row\"><?php echo "$count" ;?></th>
                    <td><?php echo date('h:i A',$temp_end_current) ;?></td>
                    <td><?php echo date('h:i A',strtotime("11:00 PM")) ;?></td>
                    </tr>
                    <?php

                  }
                  elseif($count==1 && $temp_start==strtotime("05:00 PM")){
                    //echo 'Inside 7';
                    ?>
                    <tr>
                    <th scope=\"row\"><?php echo "$count" ;?></th>
                    <td><?php echo date('h:i A',$temp_end_current) ;?></td>
                    <td><?php echo date('h:i A',strtotime("11:00 PM")) ;?></td>
                    </tr>
                    <?php

                  }
                  elseif($count==1){
                     //echo 'Inside 8';
                    ?>
                    <tr>
                    <th scope=\"row\"><?php echo "$count" ;?></th>
                    <td><?php echo date('h:i A',$temp_end_current) ;?></td>
                    <td><?php echo date('h:i A',strtotime("11:00 PM")) ;?></td>
                    </tr>
                    <?php                   

                  }

                        	
                     

                    }

                   ?>
    </body>


  </html>