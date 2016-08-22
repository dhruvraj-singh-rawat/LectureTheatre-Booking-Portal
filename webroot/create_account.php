<?php session_start();
include("../includes/config.php");
if ((!$_SESSION['login_admin'] ) || ($_SESSION['login_privilage'] != 2) ){
    header("Location: ../login.php");
    die();
}

else{

	if($_SERVER["REQUEST_METHOD"]=="POST"){

	$name=$conn->real_escape_string($_POST['name']);
    $position=$conn->real_escape_string($_POST['position']);
    $password=$conn->real_escape_string($_POST['password']);
    $email=$conn->real_escape_string($_POST['email']);
    $AccountType=$conn->real_escape_string($_POST['AccountType']);

    $currentpassword=$conn->real_escape_string($_POST['currentpassword']);

    $hash_db=$_SESSION['login_password'];

      if (password_verify($currentpassword, $hash_db)){

      	$options = [
          'cost' => 11,
          'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        $hash=password_hash($password, PASSWORD_BCRYPT, $options);

 			if($conn->query("INSERT INTO `users_profile` (`id`, `user_name`,`password`, `email`, `position`, `privilage`) VALUES (NULL, '$name', '$hash','$email', '$position', '$AccountType')")){

 				echo "<div class=\"alert alert-success fade in text-center\"\>
                    <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully made an ID! Start Booking :)</strong></div>";



 			}
 			else{

 				echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The account has not been created. Some Error has occured in DB </strong></div>";

 				


 			}


      }
      else{

      	   echo "<div class=\"alert alert-info fade in text-center\"\>
            <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The Current Password is incorrect! </strong></div>";


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

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    

	<!-- BootstrapValidator CSS -->
    <link href="../css/bootstrapValidator.min.css" rel="stylesheet"/>
	
    <!-- jQuery and Bootstrap JS -->
	<script src="../js/jquery.min.js" type="text/javascript"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
		
	<!-- BootstrapValidator -->
    <script src="../js/bootstrapValidator.min.js" type="text/javascript"></script>

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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="book.php">Book</a></li>
                    <li><a href="history.php">History</a></li>
                    
                   <?php
  if($_SESSION['login_privilage'] == 2){
    ?>
    <li class="active"><a href="create_account.php">Create Account</a></li>
    
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

	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading text-center"><h3>Account Registration</h3></div>
			<br>
			<div class="panel-body">

				<form id="registration-form" method="POST" class="form-horizontal" action="#">

					<div class="form-group">
						<label class="col-md-2 control-label" for="name">Name</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="name" name="name" placeholder="Account Name" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="position">Position</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="position" name="position" placeholder="User Position" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="email">Email Address</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="email" name="email" placeholder="Email address" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="password">Password</label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="confirmpassword">Confirm Password</label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm password" />	
						</div>
					</div>	

					<div class="form-group">
						<label class="col-md-2 control-label" for="AccountType">Account Type</label>
						<div class="col-md-4">
							<select class="form-control" id="AccountType" name="AccountType">
								<option value="0">Choose One</option>
								<option value="1">Basic Account</option>
								<option value="2">Admin Account</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="confirmpassword">Current Password</label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password" />	
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-2">
							<button type="submit" class="btn btn-success">Submit</button>
						</div>
					</div>

				</form>

				<div id="confirmation" class="alert alert-success hidden">
					<span class="glyphicon glyphicon-star"></span> Thank you for registering
				</div>

			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function () {
		var validator = $("#registration-form").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				name : {
					validators: {
						notEmpty : {
							message : "Name is required"
						},
						stringLength: {
							min : 5, 
							max: 35,
							message: "Name must be between 6 and 35 characters long"
						},
 
						different : {
							field : "email", 
							message: "Email address and name can not match"
						}
					}
				}, 

				position : {
					validators: {
						notEmpty : {
							message : "Position is required"
						},
						stringLength: {
							min : 4, 
							max: 35,
							message: "Name must be between 4 and 35 characters long"
						},
 

					}
				},


				email :{
					message : "Email address is required",
					validators : {
						notEmpty : {
							message : "Please provide an email address"
						}, 
						stringLength: {
							min : 6, 
							max: 35,
							message: "Email address must be between 6 and 35 characters long"
						},
						emailAddress: {
							message: "Email address was invalid"
						}
					}
				}, 
				password : {
					validators: {
						notEmpty : {
							message : "Password is required"
						},
						stringLength : {
							min: 8,
							message: "Password must be 8 characters long"
						}, 
						different : {
							field : "email", 
							message: "Email address and password can not match"
						}
					}
				}, 
				confirmpassword : {
					validators: {
						notEmpty : {
							message: "Confirm password field is required"
						}, 
						identical : {
							field: "password", 
							message : "Password and confirmation must match"
						}
					}
				}, 

				currentpassword : {
					validators: {
						notEmpty : {
							message: "Current password field is required"
						}
						
					}
				},

				AccountType : {
					validators : {
						greaterThan : {
							value: 1,
							message: "Membership is required"
						}
					}
				}
			}
		});
	

		
	});
</script>
</html>