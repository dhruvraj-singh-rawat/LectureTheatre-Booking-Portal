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


          $result1=$conn->query("SELECT start_time,end_time  FROM users_booking WHERE lt_selected=$lt_selected AND date=STR_TO_DATE('$date','%d-%m-%Y')");
          $count_inside=0;

          $count_actual=$result1->num_rows;

          while($row = $result1->fetch_assoc()){

            $Start_Time=$row["start_time"];
            $End_Time=$row["end_time"];

            if( ( ($Start_Time>=$start_time) && ($Start_Time>=$end_time) ) || ( ($End_Time<=$start_time) && ($End_Time<=$end_time) ) ){

              $count_inside+=1;
            }

          }
         // echo 'The count actual is '.$count_actual.' and the count inside is '.$count_inside;

          if($count_inside==$count_actual){

                        if($conn->query("INSERT INTO `users_booking` (`id`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`) VALUES (NULL, '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%d-%m-%Y') )")){

                echo "<div class=\"alert alert-success fade in text-center\"\>
                    <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";

    
                }

            else{


                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book. Try Again! Sorry for Inconvenience :( </strong></div>";
                }


          }
          else{

                  echo "<div class=\"alert alert-info fade in text-center\"\>
            <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>LT not available at this timing.Try for some different Timings :( </strong></div>";

          }

        }

        else{

                echo "<div class=\"alert alert-danger fade in text-center\"\>
                     <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Wrong Account Password Entered! Re-Enter The Account Password for the Account with which you are Logged In Right Now</strong></div>";


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
    <meta name="description" content="Lecture Hall Booking Portal">
    <meta name="author" content="Dhruvraj Singh Rawat">
    <title>Dashboard</title>

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

 <script>
 $( function() {
    $('#StartTime').timepicker({
        timeFormat: 'h:mm p',
    interval: 30,
    minTime: '5:00pm',
    maxTime: '11:00pm',
    defaultTime: '5:00pm',
    startTime: '5:00pm',
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
    defaultTime: '6:00pm',
    startTime: '5:00pm',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
  } );
 </script>

</head>
<body>
  <nav class="navbar navbar-inverse">
        <div class="container-fluid">

            <!-- Logo -->
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand">LT-REGISTRATION</a>
            </div>

            <!-- Menu Items -->
            <div>
                <ul class="nav navbar-nav">
                    <li ><a href="index.php">Home</a></li>
                    <li  class="active"><a href="book.php">Book</a></li>
                    <li ><a href="history.php">History</a></li>
                    
                   <?php
  if($_SESSION['login_privilage'] == 2){
    ?>
    <li><a href="create_account.php">Create Account</a></li>
    
    <?php

  }
                    
?> 
                   
                    
                   
                </ul>
            </div>

            <div>
                <ul class="nav navbar-nav navbar-right">
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
        <div class="panel-heading text-center" ><h3>Booking Wizard</h3></div>

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
                <label class="col-md-2 control-label" for="Name_Club">Club</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="Name_Club" name="club" placeholder="Name of the Club" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Date">Date</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="datepicker" name="date" placeholder="DD-MM-YYYY"  />
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


    <script type="text/javascript">
  $(document).ready(function () {
    var validator = $("#booking-form").bootstrapValidator({
      feedbackIcons: {
        valid: "glyphicon glyphicon-ok",
        invalid: "glyphicon glyphicon-remove", 
        validating: "glyphicon glyphicon-refresh"
      }, 
      fields : {

        name_superviser : {
          validators: {
            notEmpty : {
              message : "Name is required"
            },
            stringLength: {
              min : 4, 
              max: 35,
              message: "Name must be between 4 and 35 characters long"
            }
 

          }
        },




        message : {
          validators: {
            notEmpty : {
              message : "Message is required"
            },
            stringLength: {
              min : 4, 
              max: 175,
              message: "Name must be between 4 and 175 characters long"
            },

          }
        }, 

        name_event : {
          validators: {
            notEmpty : {
              message : "Name of the Event is required"
            },
            stringLength: {
              min : 3, 
              max: 35,
              message: "Name of Event must be between 4 and 35 characters long"
            },
 

          }
        },

        club : {
          validators: {
            notEmpty : {
              message : "Name of Club is required"
            },
            stringLength: {
              min : 3, 
              max: 35,
              message: "Name of Club must be between 4 and 35 characters long"
            },
 

          }
        },



        password : {
          validators: {
            notEmpty : {
              message : "Password is required"
            },
            stringLength : {
              min: 4,
              message: "Password must be atleast 4 characters long"
            }, 
            different : {
              field : "email", 
              message: "Email address and password can not match"
            }
          }
        }, 
 

       
        lt_selected : {
          validators : {
            greaterThan : {
              value: 1,
              message: "LT is required"
            }
          }
        }
      }
    });
  

    
  });
</script>
  </html>