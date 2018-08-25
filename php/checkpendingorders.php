<?php
  session_start();
  if (!isset($_SESSION['username']))
    header("location: login.php");

  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");

  $sql = "SELECT * FROM deliverygirlboy WHERE Username='".$_SESSION['username']."'";
  $result = $db->query($sql);
  $row = mysqli_fetch_array($result);
  $status = $row['status'];

  if ($status == 0 && $row['lat'] == 0 && $row['lon'] == 0) {
        echo("<script>alert('Παρακαλώ ενεργοποιήστε τη βάρδιά σας.')</script>");
        echo("<script>window.location = 'del_location_update.php';</script>");
        return;
    }

  $del_lat = $row['lat'];
  $del_lon = $row['lon'];

  if($status == 1){
    $sql="SELECT * FROM orders WHERE status=0 AND deliverygirlboy IS NULL";
    $result = $db->query($sql);
    $count=mysqli_num_rows($result);

  if ($count==0){
    echo "&nbsp &nbspΔεν υπάρχει ακόμα κάποια παραγγελία. Παρακαλώ περιμένετε.";
  }else{
    $sql1 = "UPDATE deliverygirlboy SET status = 0
             WHERE Username='".$_SESSION['username']."'";
   $result1 = $db->query($sql1);
   $minimumDist2 = 999999999999;
   $index = "";

   while($row = mysqli_fetch_array($result)){
     $storeLat = $row['st_lat'];
     $storeLon = $row['st_lng'];

     $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$del_lat.",".$del_lon."&destinations=".$storeLat.",".$storeLon."&key=AIzaSyD4kFxsuS6usfZ9-B4ZKLMw6YZwjBTkwfM";
     $json = file_get_contents($url);
     $response_a = json_decode($json, true);
     $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
     if($dist<$minimumDist2){
        $minimumDist2 = $dist;
        $index = $row['id'];

    }
   }
   $sql = "SELECT * FROM orders WHERE id ='".$index."' AND status = 0";
   $result = $db->query($sql);
   $row = mysqli_fetch_array($result);

   $sql = "UPDATE orders
   SET mydistfromstore = '".$minimumDist2."', deliverygirlboy = '".$_SESSION['username']."'
   WHERE id='$index'";
   $result = $db->query($sql);
   $_SESSION['orderid'] = $index;
  }
}
 ?>

<html>
<head>
  <style>
  #myMap {
            height: 350px;
            width: 450px;
            }
  </style>
</head>
<body>
  <div id="myMap"></div>
  <a href="orderdone.php">
    <input class="button button1" type="button"  name="done" id="done" value="Ολοκλήρωση Παραγγελίας">
  </a>
  <a href="endshift.php">
    <input class ='button button2' type="button" name="endshift" id="endshift" value="Τέλος βάρδιας!">
  </a>
  <a href="logout.php">
    <input class ='button button3' type="button" name="=logout" id="logout" value="Logout!">
  </a>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4kFxsuS6usfZ9-B4ZKLMw6YZwjBTkwfM&libraries=places"></script>
            <script type="text/javascript">
                var map;
                var marker2;
                var marker3;
                var myLatlng2 = { lat: <?php echo $row['st_lat']; ?> , lng: <?php echo $row['st_lng']; ?>};
                var myLatlng3 = { lat: <?php echo $row['lat']; ?>, lng: <?php echo $row['lng']; ?>};
                var geocoder = new google.maps.Geocoder();
                var infowindow2 = new google.maps.InfoWindow();
                var infowindow3 = new google.maps.InfoWindow();

                function initialize(){
                    var mapOptions = {
                        zoom: 17,
                        center: myLatlng2,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

                    marker2 = new google.maps.Marker({
                        map: map,
                        position: myLatlng2
                    });

                    marker3 = new google.maps.Marker({
                        map: map,
                        position: myLatlng3
                    });

                    geocoder.geocode({'latLng': myLatlng2 }, function(results, status) {
                        infowindow2.setContent("Τοποθεσία Καταστήματος");
                        infowindow2.open(map, marker2);
                    });

                    geocoder.geocode({'latLng': myLatlng3 }, function(results, status) {
                        infowindow3.setContent("Τοποθεσία Πελάτη");
                        infowindow3.open(map, marker3);
                    });
                }
                google.maps.event.addDomListener(window, 'load', initialize);
                </script>
</body>
</html>
