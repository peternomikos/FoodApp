<?php
  session_start();
  if (!isset($_SESSION['username']))
  header("location: login.php");

  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");

  //energopoiisi delivera kai kataxorisi topothesias tou
  $sql = "UPDATE deliverygirlboy
  SET deliverygirlboy.status = 1
  WHERE Username = '" . $_SESSION['username'] ."'";
  $result = $db->query($sql);


  $sql1 = "INSERT INTO timetable_del (username, start_shift )
    VALUES ( '" . $_SESSION['username'] ."', now() )";
  $result = $db->query($sql1);

?>

<!DOCTYPE html>
<html lang="gr">

<head>
  <style>
      #myMap {
      height: 350px;
      width: 450px;
      }
      </style>
</head>
<body>

<form action="del_location_update.php" method="post">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4kFxsuS6usfZ9-B4ZKLMw6YZwjBTkwfM&libraries=places">  </script>
<script type="text/javascript">
            var map;
            var marker;
            var myLatlng = new google.maps.LatLng(38.246640,21.734574);
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();

            function initialize(){
                var mapOptions = {
                    zoom: 18,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                map = new google.maps.Map(document.getElementById("myMap"), mapOptions);


                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true
                });

                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#latitude,#longitude').show();
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                google.maps.event.addListener(marker, 'dragend', function() {
                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                $('#address').val(results[0].formatted_address);
                                $('#latitude').val(marker.getPosition().lat());
                                $('#longitude').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });

                var search = document.getElementById('address');
                var autocomplete = new google.maps.places.Autocomplete(search);
                autocomplete.bindTo('bounds', map);

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                var place = autocomplete.getPlace();

                                if (place.geometry.viewport) {
                                    map.fitBounds(place.geometry.viewport);
                                } else {
                                    map.setCenter(place.geometry.location);
                                }

                                completeAddress = document.getElementById('address').value;
                                document.getElementById('latitude').value = place.geometry.location.lat();
                                document.getElementById('longitude').value = place.geometry.location.lng();

                                marker.setPosition(place.geometry.location);
                                marker.setVisible(true);

                                infowindow.setContent(completeAddress);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
            }
          google.maps.event.addDomListener(window, 'load', initialize);

  </script>

  <div id="myMap"></div>
  <input type="hidden" name="latitude" id="latitude" placeholder="Latitude"/>
  <input type="hidden" name="longitude" id="longitude" placeholder="Longitude"/>
  <button class="button button1" id="button"> Επιβεβαίωση </button>
  </form>

</body>
