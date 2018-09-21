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

if (isset($_SESSION['user_name']))
{
echo "Έχεις κάνει ήδη login <b>".$_SESSION['user_name']."</b>! Μια φορά αρκεί.";
echo "<br><a href='logout.php'>Log off</a>";
}

if (isset($_SESSION['username']))
{
echo "Έχεις κάνει ήδη login <b>".$_SESSION['username']."</b>! Μια φορά αρκεί.";
echo "<br><a href='logout.php'>Log off</a>";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $db = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($db,"SET NAMES 'utf8'");
  mysqli_query($db,"SET CHARACTER SET 'utf8'");

  $myuserpassword  = $_POST['password'];
  $myuseremail     = $_POST['email'];

  $sqlclient = "SELECT * FROM costumer WHERE email = '$myuseremail' and password = '$myuserpassword'";
  $result_c = mysqli_query($db, $sqlclient);
  $customer = mysqli_fetch_array($result_c);

  $sqlman = "SELECT Username FROM manager WHERE Username = '$myuseremail' and Password = '$myuserpassword'";
  $result_m = mysqli_query($db, $sqlman);

  $sqldel = "SELECT Username FROM deliverygirlboy WHERE Username = '$myuseremail' and Password = '$myuserpassword'";
  $result_d = mysqli_query($db, $sqldel);
  $delivery = mysqli_fetch_array($result_d);

  $count_client = mysqli_num_rows($result_c);
  $count_man = mysqli_num_rows($result_m);
  $count_del = mysqli_num_rows($result_d);

  if($count_man==1){
    $_SESSION['login_user'] = $myuseremail;
    $row = $result_m->fetch_array(MYSQLI_NUM);

	   header("location:../html/Manager_View.html");

  } else if($count_client==1){
    $_SESSION['user_email'] = $customer['email'];
    $_SESSION['user_name'] = $customer['name'];
    $_SESSION['user_surname'] = $customer['surname'];
    $_SESSION['user_telephone'] = $customer['Telephone'];

    header("location:../html/Item_Selection.html");

  } else if($count_del==1) {
    $_SESSION['username'] = $myuseremail;

	   header("location:del_login_location.php");

  } else {
    echo("<script>alert('Κάτι πήγε λάθος. Παρακαλώ εισάγεται πάλι τα στοιχεία σας')</script>");
    echo("<script>window.location = '../index.html';</script>");
  }
  $db->close();
}

?>
</html>
