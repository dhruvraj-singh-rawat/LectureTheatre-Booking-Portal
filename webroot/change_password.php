<?php session_start();
include("../includes/config.php");
if ((!$_SESSION['login_admin'] ) ){
    header("Location: ../login.php");
    die();
}

else{

  if($_SERVER["REQUEST_METHOD"]=="POST"){


    $currentpassword=$conn->real_escape_string($_POST['currentpassword']);
    $newpassword=$conn->real_escape_string($_POST['newpassword']);
    $hash_db=$_SESSION['login_password'];
    
    $email=$_SESSION['login_email'];

      if (password_verify($currentpassword, $hash_db)){

        $options = [
          'cost' => 11,
          'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        $hash=password_hash($newpassword, PASSWORD_BCRYPT, $options);

      if($conn->query("UPDATE `users_profile` SET `password`='$hash' WHERE email='$email' ")){

        echo "<div class=\"alert alert-success fade in text-center\"\>
                    <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Changed the Password :)</strong></div>";
                    $_SESSION['login_password']=$hash;



      }
      else{

        echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The account has NOT CHANGED . Some Error has occured in DB </strong></div>";

        


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

    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- BootstrapValidator CSS -->
    <link href="../css/bootstrapValidator.min.css" rel="stylesheet"/>
  
      <!-- jQuery and Bootstrap JS -->

    <script src="../js/jquery.js"></script>
 
    <script src="../js/bootstrap.min.js"></script>
    
    
      
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
                  <li class="active"><a href="change_password.php">Change Password</a></li>  
                    <li><a  href="../logout.php">Log Out</a></li>
                </ul>
            </div>        

        </div>
    </nav>

    <br>
    
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading text-center"><h3>Change Password</h3></div>
      <br>
      <div class="panel-body">

        <form id="password-form" method="POST" class="form-horizontal" action="#">





          <div class="form-group">
            <label class="col-md-2 control-label" for="currentpassword">Current Password</label>
            <div class="col-md-4">
              <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password" /> 
            </div>
          </div>         


          <div class="form-group">
            <label class="col-md-2 control-label" for="newpassword">New Password</label>
            <div class="col-md-4">
              <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="confirmpassword">Confirm New Password</label>
            <div class="col-md-4">
              <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password" /> 
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
      <footer class="footer">
      <div class="container">
        <p class="text-muted text-center">
            This Portal is Designed and Developed By <a href="https://www.linkedin.com/in/dhruvraj-rawat-96b67a3a">Dhruvraj Singh Rawat</a>

        </p>
      </div>
    </footer>
</body>

<script type="text/javascript">
  $(document).ready(function () {
    var validator = $("#password-form").bootstrapValidator({
      feedbackIcons: {
        valid: "glyphicon glyphicon-ok",
        invalid: "glyphicon glyphicon-remove", 
        validating: "glyphicon glyphicon-refresh"
      }, 
      fields : {
 
        currentpassword : {

          validators: {
            notEmpty : {
              message : "Current Password is required"
            }
          }
        },

         newpassword : {
          validators: {

            stringLength : {
              min: 8,
              message: "Password must be 8 characters long"
            },

            notEmpty : {
              message: "New password field is required"
            }
            
          }
        }, 

        confirmpassword : {
          validators: {
            notEmpty : {
              message: "Confirm New password field is required"
            }, 
            identical : {
              field: "newpassword", 
              message : "New Password and confirmation must match"
            }
          }
        }



      }
    });
  

    
  });
</script>
</html>