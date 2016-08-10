<?php session_start();
if ((!$_SESSION['login_admin'] ) || ($_SESSION['login_privilage'] != 1) ){

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
	<meta name="description" content="Account Creation Wizard">
	<meta name="author" content="Dhruvraj Singh Rawat">
	<title>Account Creation Wizard</title>

	<!-- Bootstrap CSS -->

	<link href="../css/bootstrap.min.css" rel="stylesheet" />
	<link href="../css/bootstrap.min.css" rel="stylesheet" />

	<!-- Bootstrap CSS Validator -->

	<link href="../css/bootstrapValidator.min.css" rel="stylesheet" />

	<!-- Jquery and Bootstrap js -->

	<script src="../js/jquery.min.js" text="text/javascript"></script>
	<script src="../js/bootstrap.min.js" text="text/javascript"></script>

	<!-- Bootstrap Validator js -->

	<script src="../js/bootstrapValidator.min.js" text="text/javascript"></script>





</head>








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
                    <li><a href="book.php">Book</a></li>
                    <li><a href="history.php">History</a></li>
                  
                    <li   class="active"><a href="create_account.php">Create Account</a></li>
                   
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
    	<div class="panel panel-default">
    		<div class="panel-heading text-center" >Account Creation Wizard</div>

    			<div class="panel-body">
    				<form id="registration-form" method="POST" class="form-horizontal" action="#">




    					<div class="form-group">
    						<label class="col-md-2 control-label" for="email">Email Address</label>
    						<div class="col-md-4">
    							<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" />
    						</div>
    					</div>

    					<div class="form-group">
    						<label class="col-md-2 control-label" for="password">Password</label>
    						<div class="col-md-4">
    							<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
    						</div>
    					</div>


    					<div class="form-group">
    						<label class="col-md-2 control-label" for="passwordConfirm">Confirm Password</label>
    						<div class="col-md-4">
    							<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm Password" />
    						</div>
    					</div>


    					<div class="form-group">
    						<label class="col-md-2 control-label" for="accountType">Account Type</label>
    						<div class="col-md-4">
    							<select class="form-control" id="accountType" name="accountType">
    								<option value="0">Choose One</option>
    								<option value="1">Adminstrator Account</option>
    								<option value="2">Basic Account</option>
    							</select>
    							
    						</div>
    					</div>

    					<div class="form-group">
    						<div class="col-md-6 col-md-offset-2">
    							<buttion type="submit" class="btn btn-success">Submit</buttion>
    						</div>    						
    					</div>

    				</form>

    			</div>

    		
    	</div>

    </div>

 



     

       
    	   
     


    <!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   

</body>

<script type="text/javascript">
	
	$(document).ready(function () {

		var validator = $("#registration-form").bootstrapValidator({

			fields : {

				email : {

					message="Email is required"

					validator :{
						notEmpty : {
							message: "Please provide an email Address"
						}
					}

				}

			}


		});


	});


</script>




</html>