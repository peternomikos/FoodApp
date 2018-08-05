<?php session_start(); ?>
<html lang="gr">

<head>
  <meta charset="utf-8">
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

  $sqlmandel = "SELECT Distributer FROM manager WHERE Username = '$myuseremail' and Password = '$myuserpassword'";
  $result_m_d = mysqli_query($db, $sqlmandel);


  $count_client = mysqli_num_rows($result_c);
  $count_mandel = mysqli_num_rows($result_m_d);

  if($count_mandel==1){
    $_SESSION['login_user'] = $myuseremail;
    $row = $result_m_d->fetch_array(MYSQLI_NUM);

    if($row[0]==0){
      header("location:../html/Manager_View.html");
    } else {
      header("location:../html/Delivery_View.html");
    }
  } else if($count_client==1){
    $_SESSION['login_user'] = $myuseremail;
    header("location:../html/Client_View.html");
  } else {
    $error = "Your Login credentials are invalid";
    header("location:../index.html");
  }
}
?>
</html>
