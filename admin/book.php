<?php
session_start();
include("../includes/config.php");

if (!$_SESSION['login_admin']){

    header("Location: ../login.php");
    die();
}

else{

  if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name=$conn->real_escape_string($_POST['name']);
    $password=md5($conn->real_escape_string($_POST['password']));
    $lt_selected=$conn->real_escape_string($_POST['lt_selected']);
    $message=$conn->real_escape_string($_POST['message']);
    $booking_id=$_SESSION['login_admin'];
    $club_name=$conn->real_escape_string($_POST['club']);

    @$checkbox=$conn->real_escape_string($_POST['checkbox']);

    //echo 'the name is '.$name.' the password is '.$password.' the lt selected is '.$lt_selected.' the message is '.$message.' booking id is '.$booking_id.'the value of checkbox is '.$checkbox;

    

    //$query="INSERT INTO users_bookin (name,lt_selected,message,bookingID_name) VALUES ('dhruv','1','hello','jacol')";
   // $query = 
    //$result=mysql_query($query);
    //$count=mysql_num_rows($result);
   

    if ($checkbox){

        if ($password==$_SESSION['login_password']){

            if($conn->query("INSERT INTO `users_booking` (`id`, `name`,`club_name`, `lt_selected`, `message`, `bookingID_name`) VALUES (NULL, '$name', '$club_name','$lt_selected', '$message', '$booking_id')")){

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


 
   


    
    else{
            echo "<div class=\"alert alert-info fade in text-center\"\>
                <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Woo Hold On..Tick the Checkbox at the Bottom To confirm your Booking! ;)</strong></div>";
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
    <label for="InputName">Name of the Event</label>
    <input name="name" type="text" class="form-control" id="InputName" placeholder="Name">
    <small class="text-muted"></small>
  </fieldset>

    <fieldset class="form-group">
    <label for="InputName">Name of the Club</label>
    <input name="club" type="text" class="form-control" id="InputName" placeholder="Name of the Club">
    <small class="text-muted"></small>
  </fieldset>

  <fieldset class="form-group">
    <label for="InputPassword">Password</label>
    <input name="password" type="password" class="form-control" id="InputPassword" placeholder="Password">
    <small class="text-muted">Again enter the password for security Reason!</small>
  </fieldset>

  <fieldset class="form-group">
    <label for="DATE">Date</label>
    <input name="date" type="text" class="form-control datepicker" data-date-format="dd/mm/yyyy"id="InputDate" placeholder="Date">
    <small class="text-muted">Enter the date of Reservation!</small>
  </fieldset>

  <fieldset class="form-group">
    <label for="Time">Starting Time</label>
    <input name="start_time" type="text" class="form-control input-group " id="InputTimeS" placeholder="Starting Time">
    
    <small class="text-muted">Enter the Starting Time for Reservation!</small>
  </fieldset>

  <fieldset class="form-group">
    <label for="selectlt">Select a Desired LT</label>
    <select name="lt_selected" class="form-control" id="selectlt">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </fieldset>
  
  <fieldset class="form-group">
    <label for="textarea">Message</label>
    <textarea name="message" class="form-control" id="textarea" rows="5"></textarea>
    <small class="text-muted">Briefly Explain the Reason for Lt Reservation!</small>
  </fieldset>

    <label>
      <input name="checkbox" type="checkbox"> Are You Confirm ?
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
 
</html>