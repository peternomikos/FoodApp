  <?php
  session_start();

  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");
  
  $Μισθός_manager=800;
  
  <!DOCTYPE html>
<html>
<head>
<title>Misthos_manager</title>
</head>
<body>
<section>
<input type="submit" value="Mισθός manager" >

</body>
</html>
  
  echo $Μισθός_manager;
  
  ?>