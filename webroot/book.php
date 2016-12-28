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
    $password=$conn->real_escape_string($_POST['password']);
    $lt_selected=$conn->real_escape_string($_POST['lt_selected']);
    $message=$conn->real_escape_string($_POST['message']);
    $booking_id=$_SESSION['login_admin'];
    $club_name=$conn->real_escape_string($_POST['club']);
    $privilage_id=$conn->real_escape_string($_SESSION['login_privilage']);

    $hash_db=$_SESSION['login_password']; 

    //---------

    $date=$conn->real_escape_string($_POST['date']);


    $start_time=$conn->real_escape_string($_POST['start_time']);
    $end_time=$conn->real_escape_string($_POST['end_time']);

    $start_time  = date("H:i:s", strtotime($start_time));
    $end_time  = date("H:i:s", strtotime($end_time));

    //$plus_30 = date("H:i", strtotime('+30 minutes', $start_time));
    //echo "$plus_30";

    $date_sys=date("Y-m-d");

    $start_time_temp = strtotime($start_time);
    $end_time_temp = strtotime($end_time);
    $diff_time=($end_time_temp-$start_time_temp)/60;
    

    //echo $diff_time;

    $date_sys_temp=strtotime($date_sys);
    $date_temp=strtotime($date);
    $diff_date=(($date_temp-$date_sys_temp)/(86400));

    $time = '30 minutes';

    $new_time = strtotime($start_time."-".$time);
    $new_time1 = date("H:i:s", $new_time);

    //echo "$new_time1<br>";

    //echo ' Diff in date '.$diff_date.' start_time is '.$start_time_temp.'   end time temp is '.$end_time_temp.' 0..'.strtotime("11:00 PM");

   
    //$diff=$date-$date_sys;
    //echo $diff;
  




    $reference=uniqid('lt');

    
    

        if (password_verify($password, $hash_db)){



          //$result1=$conn->query("SELECT start_time,end_time  FROM users_booking WHERE lt_selected=$lt_selected AND date=STR_TO_DATE('$date','%Y-%m-%d')");
          //$count_inside=0;
          //$counting=0;
          //$extra_end_time=0;

          /*$count_actual=$result1->num_rows;
          echo "$count_actual <br>";

          while($row = $result1->fetch_assoc()){

            $Start_Time=$row["start_time"];
            $End_Time=$row["end_time"];

            if( ( ($Start_Time>=$start_time) && ($Start_Time>=$end_time) ) || ( ($End_Time<=$start_time) && ($End_Time<=$end_time) ) ){

              $count_inside+=1;
            }

          }
          echo "$count_inside   $count_actual";*/
         // echo 'The count actual is '.$count_actual.' and the count inside is '.$count_inside;
          // 5 PM =1471878000  $$ 11 PM = 1471899600

          //if($count_inside==$count_actual){
            if($start_time_temp>=$end_time_temp)
            {
                echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Please Enter Valid Start And End Time To Book Your LT</strong></div>";
            }

            else if (($diff_time>0) && ( $diff_date<=3 ) && ($diff_date>=0) && ($start_time_temp>=strtotime("09:00 AM") ) && ($end_time_temp<=strtotime("11:00 PM"))) 
            {
              $diff_time1=(($end_time_temp-$start_time_temp)/1800)+1;
              $high_priority = array();
              $low_priority = array();
              //$p=0;
              //$q=0;
              for($i = 1; $i <= $diff_time1; $i++)
              {
                $new_time1 = strtotime($new_time1."+".$time);
            $new_time1 = date("H:i:s", $new_time1);
            //echo "$new_time1<br>";
                $result=$conn->query("SELECT start_time,end_time,privilage,reference_number FROM users_booking WHERE lt_selected=$lt_selected AND date=STR_TO_DATE('$date','%Y-%m-%d') ORDER BY start_time ASC");

                while($row = $result->fetch_assoc())
                {
                  $Start_Time=$row["start_time"];
                  $End_Time=$row["end_time"];
                  $Privilage=$row["privilage"];
                  $Reference_Number=$row["reference_number"];
                  //echo "$Privilage<br>";
                  //echo "$new_time1<br>$Start_Time<br>$End_Time";
                  //$pc = $new_time1<$End_Time;
                  if(($new_time1>$Start_Time) and ($new_time1<$End_Time))
                  {
                  //  echo "$new_time1<br>$Start_Time<br>$End_Time<br>";
                    if($privilage_id<$Privilage)
                    {
                    //  echo "h1<br>";
                      $l = count($low_priority);
                        for($j = 0; $j < $l; $j++)
                        {
                          if($Reference_Number==$low_priority[$j])
                          {
                    //        echo "h2<br>";
                            break;
                          }
                        }
                        if($j==$l)
                        {
                          //echo "h<br>";
                          //$low_priority[] = $Reference_Number;
                          //$p++;
                    //      echo "h3<br>";
                          array_push($low_priority, $Reference_Number);
                        }
                    }
                    else
                    {
                    //  echo "h4<br>";
                      $h = count($high_priority);
                      /*if($h == 0)
                      {
                        array_push($high_priority, $Reference_Number);  
                      }
                      else
                      {*/
                        for($k = 0; $k < $h; $k++)
                        {
                          if($Reference_Number==$high_priority[$k])
                          {
                    //        echo "h5<br>";
                            break;
                          }
                        }
                        if($k==$h)
                        {
                          //$high_priority[] = $Reference_Number;
                          //$q++;
                    //      echo "h6<br>";
                          array_push($high_priority, $Reference_Number);
                          //echo "h<br>";
                        }
                      //}
                    }
                    break;
                  }
                  else if(($new_time1==$Start_Time))
                  {
                    //echo "h7<br>";
                    if($privilage_id<$Privilage)
                    {
                      $l = count($low_priority);
                      //echo "h8<br>";
                      /*if($l == 0)
                      {
                        array_push($low_priority, $Reference_Number); 
                      }
                      else
                      {*/
                        for($j = 0; $j < $l; $j++)
                        {
                          if($Reference_Number==$low_priority[$j])
                          {
                      //      echo "h9<br>";
                            break;
                          }
                        }
                        if($j==$l)
                        {
                      //    echo "hh1<br>";
                          //$low_priority[] = $Reference_Number;
                          //$p++;
                          array_push($low_priority, $Reference_Number);
                        }
                      //}
                    }
                    else
                    {
                      //echo "hh2<br>";
                      $h = count($high_priority);
                        for($k = 0; $k < $h; $k++)
                        {
                          if($Reference_Number==$high_priority[$k])
                          {
                          //  echo "hh3<br>";
                            break;
                          }
                        }
                        if($k==$h)
                        {
                          //echo "hh4<br>";
                          //$high_priority[] = $Reference_Number;
                          array_push($high_priority, $Reference_Number);
                          //echo "hhhhhh<br>";
                        }
                    }
                    break;
                  }
                }

              }
              $a=count($high_priority);
              $b=count($low_priority);
              //echo "$a <br>$b";
              if(count($high_priority)==1)
              { //echo "hhi<br>";
                $r_f=$high_priority[0];
                //echo "$r_f<br>";
                $s_t1=NULL;
                if($result2=$conn->query("SELECT start_time FROM users_booking WHERE reference_number='$r_f'"))
                {
                  while($row2 = $result2->fetch_assoc())
                  {
                    $s_t1 = $row2["start_time"];
                  }
                  //echo "$s_t1<br>";
                }

                
                //echo "$s_t1<br>";
                if($end_time==$s_t1)
                {
                  if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                    {
                        echo "<div class=\"alert alert-success fade in text-center\"\>
                          <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                    }
                    for($r=0; $r<sizeof($low_priority); $r++)
                    {
                      $rf = $low_priority[$r];
                    if($pp=$conn->query("DELETE FROM users_booking WHERE reference_number='$rf'"))
                    {
                      // email bhi send karna h abhi
                    }
                    }
                }
                else
                {
                  //echo "h<br>";
                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book.
                        Due to higher or equal priority booking during your booking timings. Try Again! Sorry for Inconvenience :( </strong></div>";
                }
              }
              else if(count($high_priority)>1)
              {
                //echo "hhhi<br>";
                echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book.
                        Due to higher or equal priority booking during your booking timings. Try Again! Sorry for Inconvenience :( </strong></div>";
              }
              else if((count($high_priority)==0) && (count($low_priority))>0)
              {
                for($m=0; $m<count($low_priority); $m++)
                {
                  $e_t=$low_priority[$m];
                  $s_t=NULL;
                  if($result5=$conn->query("SELECT start_time FROM users_booking WHERE reference_number='$e_t'"))
                  {
                    while($row5 = $result5->fetch_assoc())
                    {
                      $s_t = $row5["start_time"];
                    }
                    //echo "$s_t1<br>";
                  }
                  //$s_t=$conn->query("SELECT start_time FROM users_booking WHERE reference_number=$e_t");
                  if($s_t!=$end_time)
                  {
                    $rf = $low_priority[$m];
                    if($qq=$conn->query("DELETE FROM users_booking WHERE reference_number='$rf'"))
                    {
                      // email bhi send karna h abhi
                    }
                  }
                }
                if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                  {
                    echo "<div class=\"alert alert-success fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                  }

              }
              else if((count($high_priority))==0 && (count($low_priority))==0)
              {
                //echo "hi<br>";
                if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                  {
                    echo "<div class=\"alert alert-success fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                  }
              }


              /*$result2=$conn->query("SELECT start_time,end_time,privilage FROM users_booking WHERE lt_selected=$lt_selected AND date=STR_TO_DATE('$date','%Y-%m-%d') ORDER BY start_time ASC");

              while($row = $result2->fetch_assoc()){
                $Start_Time=$row["start_time"];
                $End_Time=$row["end_time"];
                $Privilage=$row["privilage"];

                if(($start_time<$Start_Time) && ($end_time>$Start_Time) && ($end_time<=$End_Time) && ($privilage_id>$Privilage))
                {
                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book.
                        Due to higher or equal priority booking during your booking timings. Try Again! Sorry for Inconvenience :( </strong></div>";
                        break;
                }

                if(($start_time>=$Start_Time) && ($start_time<$End_Time) && ($Privilage<=$privilage_id)){
                  $counting=10;
                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book.
                        Due to higher or equal priority booking during your booking timings. Try Again! Sorry for Inconvenience :( </strong></div>";
                        break;
                }
                else if(($start_time>=$Start_Time) && ($start_time<$End_Time) && ($Privilage>$privilage_id))
                {
                  if($end_time<=$End_Time)
                  {
                    $counting=20;
                    echo "<div class=\"alert alert-danger fade in text-center\"\>
                            <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Able to book. Other lower priority booking cancelled.:-) </strong></div>";
                    // IMPORTANT ISSUE WITH $to
                    //$to = "$_SESSION['login_email']";
                    //$subject = "LT BOOKING CANCELED";
                    //$txt ="Due to the same lt booked by a high privilaged person, your lt booking is canceled. So, if your work is urgent, go and try some other free slots asap."
                    //$headers = "From: hs30897@gmail.com" . "\r\n";
                    //mail($to,$subject,$txt,$headers);
                    break;
                  }
                  else if($end_time>$End_Time)
                  {
                    $extra_end_time = $end_time;
                  }
                }
                else if($extra_end_time!=NULL) 
                {
                  if($extra_end_time<$Start_Time)
                  {
                    $counting=30;
                    if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                      {
                        echo "<div class=\"alert alert-success fade in text-center\"\>
                            <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                      } 
                    else
                    {
                          echo "<div class=\"alert alert-danger fade in text-center\"\>
                              <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book. Try Again! Sorry for Inconvenience :( </strong></div>";
                      }
                      break;
                  }
                  else if(($extra_end_time>$Start_Time) && ($Privilage<=$privilage_id))
                  {
                    $counting=40;
                    echo "<div class=\"alert alert-danger fade in text-center\"\>
                            <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book.Due to higher or equal priority booking during your booking timings. Try Again! Sorry for Inconvenience :( </strong></div>";
                            break;
                  }
                  else if(($extra_end_time>$Start_Time) && ($Privilage>$privilage_id))
                  {
                    $counting=50;
                  }
                }

              }

              if($counting==0 || $counting==50) 
              {
                if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                  {
                    echo "<div class=\"alert alert-success fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                  } 
                else
                {
                      echo "<div class=\"alert alert-danger fade in text-center\"\>
                          <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book. Try Again! Sorry for Inconvenience :( </strong></div>";
                  }
              }*/

                /*if($conn->query("INSERT INTO `users_booking` (`id`,`reference_number`, `name_event`,`club_name`, `lt_selected`, `message`, `bookingID_name`,`name_superviser`,`start_time`,`end_time`,`date`,`privilage`) VALUES (NULL,'$reference', '$name_event', '$club_name','$lt_selected', '$message', '$booking_id','$name_superviser','$start_time' ,'$end_time',STR_TO_DATE('$date','%Y-%m-%d'),'$privilage_id' )"))
                {
                  echo "<div class=\"alert alert-success fade in text-center\"\>
                      <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Successfully Booked A LT! Rejoice :) </strong></div>";    
                }
              else
              {
                  echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Not able to book. Try Again! Sorry for Inconvenience :( </strong></div>";
                }*/

            }
            else{

              echo "<div class=\"alert alert-danger fade in text-center\"\>
                        <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong> Not able to book. Invalid Date or Time . Try Again :( </strong></div>";



            }

                        


          //}
          /*else
          {
                echo "<div class=\"alert alert-info fade in text-center\"\>
                <a href=\"book.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>This LT is not available at these Date and Time Combination . Use \"FREE SLOTS\" Tab for Finding Free Time Slots ;)  </strong></div>";
          }*/

        }

        else
        {
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
  var disableddates = ["2016-12-17", "2016-12-18", "2016-12-22", "2016-12-25"];


  function DisableSpecificDates(date) {
      var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
      return [disableddates.indexOf(string) == -1];
    }

    $(function() {
      $("#datepicker").datepicker({ beforeShowDay: DisableSpecificDates, minDate: 0, maxDate: "+2D", dateFormat: 'yy-mm-dd'  });
  });
  </script>

 <script>
  function my() 
  {
      var satsundays = ["2016-12-28", "2016-12-29"];
      var d = document.getElementById("datepicker").value;
      var dis = new Date(d);
      var day = dis.getDate();
      var month = dis.getMonth();
      var year = dis.getFullYear();
      var len = satsundays.length;
      var i, dd, dd1, dd2, dd3, t, option, option1;
      var selectobject = document.getElementById('start_time');
      var selectobject1 = document.getElementById('end_time');
      option = document.createElement('option');
      option1 = document.createElement('option');
      option2 = document.createElement('option');
      option3 = document.createElement('option');
      option4 = document.createElement('option');
      option5 = document.createElement('option');
      option6 = document.createElement('option');
      option7 = document.createElement('option');
      option8 = document.createElement('option');
      option9 = document.createElement('option');
      option10 = document.createElement('option');
      option11 = document.createElement('option');
      option12 = document.createElement('option');
      option13 = document.createElement('option');
      option14 = document.createElement('option');
      option15 = document.createElement('option');
      option16 = document.createElement('option');
      option17 = document.createElement('option');
      option18 = document.createElement('option');
      option19 = document.createElement('option');
      option20 = document.createElement('option');
      option21 = document.createElement('option');
      option22 = document.createElement('option');
      option23 = document.createElement('option');
      option24 = document.createElement('option');
      option25 = document.createElement('option');
      option26 = document.createElement('option');
      option27 = document.createElement('option');
      option28 = document.createElement('option');
      option29 = document.createElement('option');
      option30 = document.createElement('option');
      option31 = document.createElement('option');
      var Text = selectobject.options[1].text;
      var Text1 = selectobject1.options[1].text;
      for (i=0; i <= len - 1; i++) 
    {
        dd = new Date(satsundays[i]);
        dd1 = dd.getDate();
        dd2 = dd.getMonth();
        dd3 = dd.getFullYear();
        
        if (day===dd1)
        {
          if(month===dd2) 
          {
            if(year===dd3)
            {
              if(Text != "9:00am") {
                option.text=option.value="4:30pm";
                selectobject.add(option, 1);
                option1.text=option1.value="4:00pm";
                selectobject.add(option1, 1);
                option2.text=option2.value="3:30pm";
                selectobject.add(option2, 1);
                option3.text=option3.value="3:00pm";
                selectobject.add(option3, 1);
                option4.text=option4.value="2:30pm";
                selectobject.add(option4, 1);
                option5.text=option5.value="2:00pm";
                selectobject.add(option5, 1);
                option6.text=option6.value="1:30pm";
                selectobject.add(option6, 1);
                option7.text=option7.value="1:00pm";
                selectobject.add(option7, 1);
                option8.text=option8.value="12:30pm";
                selectobject.add(option8, 1);
                option9.text=option9.value="12:00pm";
                selectobject.add(option9, 1);
                option10.text=option10.value="11:30am";
                selectobject.add(option10, 1);
                option11.text=option11.value="11:00am";
                selectobject.add(option11, 1);
                option12.text=option12.value="10:30am";
                selectobject.add(option12, 1);
                option13.text=option13.value="10:00am";
                selectobject.add(option13, 1);
                option14.text=option14.value="9:30am";
                selectobject.add(option14, 1);
                option15.text=option15.value="9:00am";
                selectobject.add(option15, 1);
              }
              if(Text1 != "9:00am") {
              option16.text=option16.value="4:30pm";
                selectobject1.add(option16, 1);
                option17.text=option17.value="4:00pm";
                selectobject1.add(option17, 1);
                option18.text=option18.value="3:30pm";
                selectobject1.add(option18, 1);
                option19.text=option19.value="3:00pm";
                selectobject1.add(option19, 1);
                option20.text=option20.value="2:30pm";
                selectobject1.add(option20, 1);
                option21.text=option21.value="2:00pm";
                selectobject1.add(option21, 1);
                option22.text=option22.value="1:30pm";
                selectobject1.add(option22, 1);
                option23.text=option23.value="1:00pm";
                selectobject1.add(option23, 1);
                option24.text=option24.value="12:30pm";
                selectobject1.add(option24, 1);
                option25.text=option25.value="12:00pm";
                selectobject1.add(option25, 1);
                option26.text=option26.value="11:30am";
                selectobject1.add(option26, 1);
                option27.text=option27.value="11:00am";
                selectobject1.add(option27, 1);
                option28.text=option28.value="10:30am";
                selectobject1.add(option28, 1);
                option29.text=option29.value="10:00am";
                selectobject1.add(option29, 1);
                option30.text=option30.value="9:30am";
                selectobject1.add(option30, 1);
                option31.text=option31.value="9:00am";
                selectobject1.add(option31, 1);                 
              }
            break;
            }
          }
        }
      }
      if (i===len) 
    {
      if(Text != "5:00pm") {
        for(var h=1; h<17; h++)
          selectobject.remove(1);     
      }
      if(Text1 != "5:00pm") {
        for(var f=1; f<17; f++)
          selectobject1.remove(1);
      }
      }
    }
 </script>

<script>
    
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
                    <li  class="active"><a href="book.php">Book</a></li>
                    <li ><a href="history.php">History</a></li>
                    
                   <?php
  if($_SESSION['login_account'] == 2){
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
                      if($_SESSION['login_account'] == 2){
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
                <label class="col-sm-2 control-label"  >Privilage</label>
                <div class="col-md-4">
                  <strong> <input type="text" class="form-control text-center" name="privilage" id="privilage"    placeholder="

                  <?php echo $_SESSION['login_privilage']; ?> 



                  " readonly="readonly"/></strong>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Date">Date</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="datepicker" name="date" placeholder="YYYY-MM-DD" onchange="my();" readonly/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Time">Starting Time</label>
                <div class="col-md-4">
                <select name="start_time" size="1" id="start_time" style="width: 350px; height: 35px;">
                  <option value="0">Select Starting Time</option>
                  <option value="5:00pm">5:00pm</option>
                  <option value="5:30pm">5:30pm</option>
                  <option value="6:00pm">6:00pm</option>
                  <option value="6:30pm">6:30pm</option>
                  <option value="7:00pm">7:00pm</option>
                  <option value="7:30pm">7:30pm</option>
                  <option value="8:00pm">8:00pm</option>
                  <option value="8:30pm">8:30pm</option>
                  <option value="9:00pm">9:00pm</option>
                  <option value="9:30pm">9:30pm</option>
                  <option value="10:00pm">10:00pm</option>
                  <option value="10:30pm">10:30pm</option>
                  <option value="11:00pm">11:00pm</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-2 control-label" for="Time">Ending Time</label>
                <div class="col-md-4">
                <select name="end_time" size="1" id="end_time" style="width: 350px; height: 35px;">
                  <option value="0">Select Starting Time</option>
                  <option value="5:00pm">5:00pm</option>
                  <option value="5:30pm">5:30pm</option>
                  <option value="6:00pm">6:00pm</option>
                  <option value="6:30pm">6:30pm</option>
                  <option value="7:00pm">7:00pm</option>
                  <option value="7:30pm">7:30pm</option>
                  <option value="8:00pm">8:00pm</option>
                  <option value="8:30pm">8:30pm</option>
                  <option value="9:00pm">9:00pm</option>
                  <option value="9:30pm">9:30pm</option>
                  <option value="10:00pm">10:00pm</option>
                  <option value="10:30pm">10:30pm</option>
                  <option value="11:00pm">11:00pm</option>
                  </select>
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