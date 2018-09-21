<?php
  session_start();
  if (!isset($_SESSION['username']))
    header("location: login.php");

  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");

  $today = date("Y-m-d");
  $kilomtostore = 0;
  $kilomtoclien = 0;
  $startshifts   = 0;
  $endshifts     = 0;
  $startshiftm   = 0;
  $endshiftm     = 0;
  $startshifth   = 0;
  $endshifth     = 0;
  $totalseconds = 0;
  $totalminutes = 0;
  $totalhours   = 0;
  $shift        = 0;

  $sql = "UPDATE timetable_del
          SET end_shift=NOW()
          WHERE username='".$_SESSION['username']."' AND end_shift = start_shift";
  $result = $db->query($sql);

  $sql = "UPDATE deliverygirlboy
          SET status=0, lat=0, lon=0
          WHERE Username='".$_SESSION['username']."'";
  $result = $db->query($sql);

  $sql = "SELECT * FROM timetable_del WHERE username = '".$_SESSION['username']."' ";
  $result = $db->query($sql);

  while($row = mysqli_fetch_array($result)){

    $shift = date("Y-m-d", strtotime($row["start_shift"]));

    if ($shift === $today){

      $startshifts   += date("s", strtotime($row["start_shift"]));
      $endshifts     += date("s", strtotime($row["end_shift"]));

      $startshiftm   += date("i", strtotime($row["start_shift"]));
      $endshiftm     += date("i", strtotime($row["end_shift"]));

      $startshifth   += date("G", strtotime($row["start_shift"]));
      $endshifth     += date("G", strtotime($row["end_shift"]));

      $totalseconds = $endshifts - $startshifts;
      $totalminutes = $endshiftm - $startshiftm;
      $totalhours   = $endshifth - $startshifth;
      }
  }

  $sql1 = "SELECT * FROM orders WHERE deliverygirlboy = '".$_SESSION['username']."' ";
  $result1 = $db->query($sql1);
  $routecounter=0;
  while($row1 = mysqli_fetch_array($result1)){

    if ($shift === $today){
      $routecounter++;
      $kilomtostore +=  $row1["mydistfromstore"];
      $kilomtoclien +=  $row1["kilometers"];

      }
  }
  if($totalminutes>=20){
    $totalhours++;
  }

  $totalkilometers = $kilomtoclien + $kilomtostore;
  $totalkilometers /= 1000;



  $payment = ceil(5 * $totalhours + 0.10 * $totalkilometers);

  $sql = "UPDATE deliverygirlboy SET daypay = '".$payment."'
          WHERE Username = '" . $_SESSION['username'] ."'";
  $result = $db->query($sql);
  $totalkilometers *= 1000;
  echo "You have worked for " .$totalhours. " hours.";
  echo "<br>";
  echo "You have made " .$routecounter. " routes and " .$totalkilometers. " kilometers in total.";
  echo "<br>";
  ?>

  <a href="location.php">
     <input class="button button1" type="button"  name="activation" id="activation" value="Ενεργοποίηση">
  </a>
