<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
if(isset($_SESSION['username'])) {
  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");

  $sql = "UPDATE deliverygirlboy
          SET status=0, lat=0, lon=0
          WHERE Username='".$_SESSION['username']."'";
  $result = $db->query($sql);
}
session_destroy();
echo("<script>window.location = '../index.html';</script>");
?>
</html>
