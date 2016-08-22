<?php session_start();
include("../includes/config.php");
if ((!$_SESSION['login_admin'] ) ){
    header("Location: ../login.php");
    die();
}

else{
  

  if($_SERVER["REQUEST_METHOD"]=="POST"){


    $currentpassword=$conn->real_escape_string($_POST['currentpassword']);
    $ref=$conn->real_escape_string($_POST['ref']);
    $id=$_SESSION['login_admin'];

    $hash_db=$_SESSION['login_password'];
    

     


      
      

      $count_inside=0;

      $priv=$_SESSION['login_privilage'];
    

      if (password_verify($currentpassword, $hash_db)){

        if($priv==2){

          $result1=$conn->query("SELECT date  FROM users_booking ");
          $count_actual=$result1->num_rows;

              if($conn->query("DELETE FROM `users_booking` WHERE reference_number='$ref' ")){

          $result2=$conn->query("SELECT date  FROM users_booking ");

          $count_inside=$result2->num_rows;

          if ($count_inside==$count_actual){

            echo "<div class=\"alert alert-info fade in text-center\"\>
              <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The Referance ID entered is incorrect! Try Again :( </strong></div>";



          }
          else{

            echo "<div class=\"alert alert-success fade in text-center\"\>
                      <a href=\"delete_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Deleted The Booking :)</strong></div>";
                     

          }



        }
        else{
          echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The Reservation has NOT Deleted . Some Error has occured in DB </strong></div>";
        }
      } 

      else{

        $result5=$conn->query("SELECT date  FROM users_booking WHERE `bookingID_name` ='$id'");
          $count_actual_1=$result5->num_rows;

        if($conn->query("DELETE FROM `users_booking` WHERE `reference_number`='$ref'  AND `bookingID_name` ='$id' ")){



          $result4=$conn->query("SELECT date  FROM users_booking AND bookingID_name = '$id' ");

          @$count_inside_1=$result4->num_rows;

          if (@($count_inside_1==$count_actual_1)){

            echo "<div class=\"alert alert-info fade in text-center\"\>
              <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The Referance ID entered is incorrect! Try Again :( </strong></div>";



          }
          else{

            echo "<div class=\"alert alert-success fade in text-center\"\>
                      <a href=\"delete_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Deleted The Booking :)</strong></div>";
                     

          }



        }
        else{
          echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"create_account.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>The Reservation has NOT Deleted . Some Error has occured in DB </strong></div>";
        }


        


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

    <!-- BootstrapValidator CSS -->
    <link href="../css/bootstrapValidator.min.css" rel="stylesheet"/>
        <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
  
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
                <li class="active"><a href="delete_reservation.php">Delete Reservation</a></li>

                    <?php
                      if($_SESSION['login_privilage'] == 2){
                        ?>
                        <li><a href="delete_account.php">Delete Account</a></li>
                        <?php

                      }
                                        
                    ?> 
                    <li ><a href="change_password.php">Change Password</a></li> 
                    
                   
                    <li><a  href="../logout.php">Log Out</a></li>
                </ul>
            </div>        

        </div>
    </nav>

    <br>
    
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading text-center"><h3>Delete Booking</h3></div>
      <br>
      <div class="panel-body">

        <form id="delete-reservation" method="POST" class="form-horizontal" action="#">

        <div class="form-group">
            <label class="col-md-2 control-label" for="ref">Referance Number</label>
            <div class="col-md-4">
              <input type="text" class="form-control" id="ref" name="ref" placeholder="Referance Number" />
            </div>
          </div>




          <div class="form-group">
            <label class="col-md-2 control-label" for="currentpassword">Current assword</label>
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
    var validator = $("#delete-reservation").bootstrapValidator({
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

        ref : {
          validators: {
            notEmpty : {
              message : "Referance Number is required"
            }
          }
        }


      }
    });
  

    
  });
</script>
</html>