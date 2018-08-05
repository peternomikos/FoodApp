<?php
session_start();
?>
<html lang="gr">

<head>
  <meta charset="utf-8">
</head>

<?php
if (isset($_SESSION['login_user']))
{
  echo "Η παραγγελία σας καταχωρήθηκε και θα είναι έτοιμη σε λίγο!";
  echo "Ευχαριστούμε που μας προτιμήσατε!";
  echo "<br><a href='../html/Client_View.html'>Back</a>";

  $db = new mysqli('localhost', 'root', '', 'FoodService');

  $sql = "SELECT id, firstname, lastname FROM MyGuests";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $greek = $_POST['greek'];       $cheese = $_POST['chesse'];
  $frape = $_POST['frape'];       $spinac = $_POST['spinach'];
  $espre = $_POST['espreso'];     $toast  = $_POST['toast'];
  $cappu = $_POST['cappuccino'];  $cake   = $_POST['cake'];
  $frenc = $_POST['french'];      $bread  = $_POST['bread'];

  $db->close();
}
  ?>

</html>
