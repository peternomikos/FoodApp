<?php session_start(); ?>
<html lang="gr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
if (isset($_SESSION['login_user']))
{
echo "Έχεις κάνει ήδη login <b>".$_SESSION['login_user']."</b>! Μια φορά αρκεί.";
echo "<br><a href='logout.php'>Log off</a>";
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
  $db = new mysqli('localhost', 'root', '', 'FoodService');

  $myuserpassword  = $_POST['password'];
  $myuseremail     = $_POST['email'];

  $sqlclient = "SELECT email FROM costumer WHERE email = '$myuseremail' and password = '$myuserpassword'";
  $result_c = mysqli_query($db, $sqlclient);

  $sqlman = "SELECT Username FROM manager WHERE Username = '$myuseremail' and Password = '$myuserpassword'";
  $result_m = mysqli_query($db, $sqlman);

  $sqldel = "SELECT Username FROM manager WHERE Username = '$myuseremail' and Password = '$myuserpassword'";
  $result_d = mysqli_query($db, $sqldel);

  $count_client = mysqli_num_rows($result_c);
  $count_man = mysqli_num_rows($result_m);
  $count_del = mysqli_num_rows($result_d);

  if($count_man==1){
    $_SESSION['login_user'] = $myuseremail;
    $row = $result_m->fetch_array(MYSQLI_NUM);

	   header("location:../html/Manager_View.html");

  } else if($count_client==1){
    $_SESSION['login_user'] = $myuseremail;

    header("location:../html/Client_View.html");

  } else if($count_del==1) {

	   header("location:../html/Delivery_View.html");

  } else {
    echo("<script>alert('Κάτι πήγε λάθος. Παρακαλώ εισάγεται πάλι τα στοιχεία σας')</script>");
    echo("<script>window.location = '../index.html';</script>");
  }
}
$db->close();
?>
</html>
