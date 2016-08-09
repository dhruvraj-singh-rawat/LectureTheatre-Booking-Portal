<?php
session_start();
include("includes/config.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$email=$conn->real_escape_string($_POST['email']);
	$password=md5($conn->real_escape_string($_POST['password']));


	$result=$conn->query("SELECT user_name,position,email,password,privilage FROM users_profile WHERE email='$email' and password='$password'");
	//$result=mysql_query($query);
	//$count=mysql_num_rows($result);
  //$row = mysql_fetch_assoc($result);
  //$result=$query->execute();
  $count=$result->num_rows;
  //echo 'The value of the Count is '.$count;

	if($count == 1){

    while($row = $result->fetch_assoc()) {

          $_SESSION['login_admin']=$row["user_name"];
          $_SESSION['login_position']=$row["position"];
          $_SESSION['login_email']= $row["email"];
          $_SESSION['login_password']= $row["password"];
          $_SESSION['login_privilage']= $row["privilage"];

        
    }

    
		header("location: admin/index.php");

	}
	else{
		
    echo "<div class=\"alert alert-danger fade in text-center\"\>
      <a href=\"\#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Username or password</strong></div>";
      


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

    <title>Signin For LT-Registration</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">


  </head>

  <body id ="back_1" background="">

    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required> 
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


  </body>
</html>

