<?php
session_start();
include("../includes/config.php");

if (!$_SESSION['login_admin']){

    header("Location: ../login.php");
    die();
}

else{

  if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name_event=$conn->real_escape_string($_POST['name_event']);
    $name_superviser=$conn->real_escape_string($_POST['name_superviser']);
    $password=md5($conn->real_escape_string($_POST['password']));
    $lt_selected=$conn->real_escape_string($_POST['lt_selected']);
    $message=$conn->real_escape_string($_POST['message']);
    $booking_id=$_SESSION['login_admin'];
    $club_name=$conn->real_escape_string($_POST['club']);

    //---------

    $date=$conn->real_escape_string($_POST['date']);


    $start_time=$conn->real_escape_string($_POST['start_time']);
    $end_time=$conn->real_escape_string($_POST['end_time']);
    $start_time  = date("H:i:s", strtotime($start_time));
    $end_time  = date("H:i:s", strtotime($end_time));

    

    //echo 'Login password is '.$_SESSION['login_password'].' and entered password is '.$password;

    //echo 'the name is '.$name.' the password is '.$password.' the lt selected is '.$lt_selected.' the message is '.$message.' booking id is '.$booking_id.'the value of checkbox is '.$checkbox;

    

    //$query="INSERT INTO users_bookin (name,lt_selected,message,bookingID_name) VALUES ('dhruv','1','hello','jacol')";
   // $query = 
    //$result=mysql_query($query);
    //$count=mysql_num_rows($result);
   

 

        if ($password==$_SESSION['login_password']){

            if($conn->query("INSERT INTO `users_booking` (`id`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`) VALUES (NULL, '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%d-%m-%Y') )")){

                echo "<div class=\"alert alert-success fade in text-center\"\>
                    <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";

    
                }

            else{


                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book. Try Again! Sorry for Inconvenience :( </strong></div>";
                }


        }

        else{

                echo "<div class=\"alert alert-danger fade in text-center\"\>
                     <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Wrong Account Password Entered! Re-Enter The Account Password for the Account with which you are Logged In Right Now</strong></div>";


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

  <script>
 $( function() {
    $('#EndTime').timepicker({
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
                    <li ><a href="index.php">Home</a></li>
                    <li  class="active"><a href="book.php">Book</a></li>
                    <li ><a href="history.php">History</a></li>
                    
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
    <br>


    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading text-center" >Booking Wizard</div>

          <div class="panel-body">
            <form id="booking-form" method="POST" class="form-horizontal" action="#">

            <br>


              <div class="form-group">
                <label class="col-md-2 control-label" for="Name">Event Superviser</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="name" name="name_superviser" placeholder="Event In charge" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Name_Event">Event Name</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="Name_Event" name="name_event" placeholder="Name of the Event" />
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-2 control-label" for="Name_Event">Club</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="Name_Club" name="club" placeholder="Name of the Club" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Date">Date</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="datepicker" name="date" placeholder="Date" />
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-2 control-label" for="Time">Starting Time</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="StartTime" name="start_time" placeholder="Starting Time" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Time">Ending Time</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="EndTime" name="end_time" placeholder="Ending Time" />
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
                <label class="col-md-2 control-label" for="password">Current Password</label>
                <div class="col-md-4">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password for Security Reason" />
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-2 control-label" for="Message">Message</label>
                <div class="col-md-4">
                  <textarea name="message" class="form-control" id="textarea" rows="5" ></textarea>
                </div>
              </div>
              <br>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-2">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>                
              </div>



            </form>
          </div>
        </div>
      </div>
    </body>
  </html>