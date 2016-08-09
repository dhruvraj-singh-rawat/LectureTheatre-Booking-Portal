<?php
session_start();
include("../includes/config.php");

if (!$_SESSION['login_admin']){

    header("Location: ../login.php");
    die();
}
else{

  if($_SERVER["REQUEST_METHOD"]=="POST"){

     $date=$conn->real_escape_string($_POST['date']);
     

     

    $start_time=$conn->real_escape_string($_POST['start_time']);

    $time  = date("H:i:s", strtotime($start_time));
    

    //echo 'The start time is '.$start_time.' and time in 24 hrs '.$time;

    //$timestamp = strtotime($start_time);
   // $timee=time("%h:%i %p", $timestamp);

    echo $start_time;





    if($conn->query("INSERT INTO `users_booking` (`start_time`,`date`) VALUES ( '$time' ,STR_TO_DATE('$date','%d-%m-%Y')  ) ")){

    echo "<div class=\"alert alert-success fade in text-center\"\>
        <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Inserted Date A LT! Rejoice :) </strong></div>";


    }
    else{

      echo 'Some Error Occured Bro :( ' ;
    }


    


  }
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
 

    <link type="text/css" href="../css/bootstrap-timepicker.min.css" /

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">


  <link rel="stylesheet" href="../css/jquery.timepicker.min.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="../js/jquery-1.12.4.js"></script>
  <script src="../js/jquery-ui.js"></script>
   <script src="../js/jquery.timepicker.min.js"></script>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2D" , dateFormat: 'dd-mm-yy'});
  } );
  </script>

 <script>
 $( function() {
    $('#StartTime').timepicker({
        timeFormat: 'h:mm p',
    interval: 30,
    minTime: '5:00pm',
    maxTime: '11:00pm',
    defaultTime: '11',
    startTime: '10:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
  } );
 </script>

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
                    <li><a href="index.php">Home</a></li>
                    <li class="active"><a href="book.php">Book</a></li>
                    <li><a href="history.php">History</a></li>
                    <li><a href="../logout.php">Log Out</a></li>
                </ul>
            </div>

        </div>
    </nav>

 

    <div class="container">
        <h2 class="text-center"><strong>LT-Booking Page</strong></h2>


          <form method="post">

            <fieldset class="form-group">
              <label for="DATE">Date</label>
              <input name="date" type="text" class="form-control " id="datepicker" placeholder="Date">
              <small class="text-muted">Enter the date of Reservation!</small>
            </fieldset>


           <fieldset class="form-group">
              <label for="Time">Starting Time</label>
              <input name="start_time" type="text" class="form-control " id="StartTime" placeholder="Starting Time">
              
              <small class="text-muted">Enter the Starting Time for Reservation!</small>
            </fieldset>

            <br>

            <button type="submit" class="btn btn-primary">Submit</button>

            </div>
           </form>


</body>
</html>






