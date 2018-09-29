<?php
session_start();
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<?php

    if (!isset($_SESSION['user_name']))
    header("location:../index.html");

    $address   = $_POST['address'];
    $latitude  = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $finallat;
    $finallng;
    $minimumDist1 = 999999999999;

    $conn = new mysqli('localhost', 'root', '', 'FoodService');
    mysqli_query($conn,"SET NAMES 'utf8'");
    mysqli_query($conn,"SET CHARACTER SET 'utf8'");

    $store_q="SELECT * FROM store";
    $stores = $conn->query($store_q);

    while($row = mysqli_fetch_array($stores)){
      $storelat = $row['Store_Lat'];
      $storelon = $row['Store_Long'];

      $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$latitude.",".$longitude."&destinations=".$storelat.",".$storelon."&key=AIzaSyD4kFxsuS6usfZ9-B4ZKLMw6YZwjBTkwfM";
      $json = file_get_contents($url);
      $response_a = json_decode($json, true);
      $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];

      $sql_query = "SELECT * FROM stock WHERE Shop_Name='".$row['Store_Name']."'";
      $stock = $conn->query($sql_query);

      $stockrow = mysqli_fetch_array($stock);
      $flag=1;

      if($stockrow['Cheesepie_Reserve']<$_POST['chesse']){$flag=0;}
      if($stockrow['Spinachpie_Reserve']<$_POST['spinach']){$flag=0;}
      if($stockrow['Simit_Reserve']<$_POST['bread']){$flag=0;}
      if($stockrow['Tost_Reserve']<$_POST['toast']){$flag=0;}
      if($stockrow['Cake_Reserve']<$_POST['cake']){$flag=0;}

      if($flag==1){
        if($dist<$minimumDist1){
          $minimumDist1 = $dist;
          $index = $row['Store_Name'];
          $st_address = $row['Store_Street'].$row['Store_Number'].$row['Store_City'].$row['Store_TK'];
          $finallat = $storelat;
          $finallng = $storelon;
        }
      }
    }
    if($minimumDist1!=999999999999){
      $sql = "SELECT * FROM stock WHERE Shop_Name='".$index."'";
      $result =mysqli_query($conn, $sql);
      $product = mysqli_fetch_array($result);

      $new_chesse = $product['Cheesepie_Reserve'] - $_POST['chesse'];
      $new_spinach = $product['Spinachpie_Reserve'] - $_POST['spinach'];
      $new_bread = $product['Simit_Reserve'] - $_POST['bread'];
      $new_toast = $product['Tost_Reserve'] - $_POST['toast'];
      $new_cake = $product['Cake_Reserve'] - $_POST['cake'];

      $totalcost = $_POST['chesse'] * $product['Cheesepie_Price'] + $_POST['spinach'] * $product['Spinachpie_Price'] + $_POST['bread'] * $product['Simit_Price'] +
      $_POST['toast'] * $product['Tost_Price'] + $_POST['cake'] * $product['Cake_Price'] + $_POST['greek'] * $product['Greek_Coffer_Price'] +
      $_POST['frape'] * $product['Frape_Price'] + $_POST['espreso'] * $product['Espresso_Price'] + $_POST['cappuccino'] * $product['Cappuccino_Price'] +
      $_POST['french'] * $product['French_Coffer_Price'];

      $sql = "UPDATE stock SET Cheesepie_Reserve = '".$new_chesse."', Spinachpie_Reserve = '".$new_spinach."',
       Simit_Reserve = '".$new_bread."', Tost_Reserve = '".$new_toast."', Cake_Reserve = '".$new_cake."'
       WHERE Shop_Name='$index'";

       $result = $conn->query($sql);

       $today = date("Y-m-d");
       $adress = $_POST['address'];
       $user_name = $_SESSION['user_name'];
       $user_sur = $_SESSION['user_surname'];
       $user_email = $_SESSION['user_email'];
       $user_tel = $_SESSION['user_telephone'];

       $sql = "INSERT INTO orders(id, address, name, surname, lat, lng, dateoforder, email, st_address, st_lat, st_lng, kilometers, cost, telephone,mydistfromstore)
       VALUES (NULL,'$adress','$user_name','$user_sur', '$latitude', '$longitude', '$today', '$user_email', '$index', '$finallat', '$finallng', '$minimumDist1', '$totalcost','$user_tel',0)";

       $result = $conn->query($sql);

       echo("<script>alert('Η παραγγελία σας καταχωρήθηκε επιτυχώς. Εκτιμώμενος χρόνος παράδοσης 20 λεπτά.')</script>");
       echo '<script type="text/javascript">alert("Το ποσό της παραγγελίας σας είναι '.$totalcost.' €");</script>';
       echo("<script>window.location = '../html/Item_Selection.html';</script>");

    } else {
      echo("<script>alert('Δεν υπάρχει αρκετό απόθεμα. Παρακαλούμε, επαναλάβετε την παραγγελία σας.')</script>");
      echo("<script>window.location = '../html/Item_Selection.html';</script>");
    }

    $conn->close();
?>


</html>
