
<?php
 session_start();
?>
<html lang="gr">

<head>
  <title>Manager_View</title>
</head>

<?php

$conn = mysqli_connect('localhost', 'root','','foodApp');
$manager = $_SESSION['login_user'];
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 if Cheesepie_Reserve!='-',Simit_Reserve!='-',Tost_Reserve!='-',Cake_Reserve!='-',Spinachpie_Reserve!='-'{
$sql = "UPDATE stock SET Cheesepie_Reserve='',Simit_Reserve='',Tost_Reserve='',Cake_Reserve='',Spinachpie_Reserve='' WHERE  Shop_Manager='$manager'";
 }


if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

 //Μισθός_managerισθός_manager=800;
    //echo $Μισθός_manager;
mysqli_close($conn);
?>



