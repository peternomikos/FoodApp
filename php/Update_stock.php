
<?php
 session_start();
?>
<html lang="gr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manager_View</title>
</head>

<?php

if (!$conn = mysqli_connect('localhost', 'root','','FoodService')) {
	die("Connection failed: " . mysqli_connect_error());
}

$manager = $_SESSION['login_user'];
$Reserves_sql = "SELECT Cheesepie_Reserve, Simit_Reserve, Tost_Reserve, Cake_Reserve, Spinachpie_Reserve FROM stock WHERE Shop_Manager = '$manager'";
$result_reservers = mysqli_query($conn, $Reserves_sql);
$reservers_array  = mysqli_fetch_array($result_reservers);

	if ($_POST['chesse']!='-')
	{
		$newreserver = $_POST['chesse'] + $reservers_array['Cheesepie_Reserve'];
		$sql = "UPDATE stock
		SET Cheesepie_Reserve='$newreserver'
		WHERE Shop_Manager='$manager'";
	}
	mysqli_query($conn, $sql);
	if ($_POST['spinach']!='-')
	{
		$newreserver = $_POST['spinach'] + $reservers_array['Spinachpie_Reserve'];
		$sql = "UPDATE stock
		SET Spinachpie_Reserve='$newreserver'
		WHERE Shop_Manager='$manager'";
	}
	mysqli_query($conn, $sql);
	if ($_POST['cake']!='-')
	{
		$newreserver = $_POST['cake'] + $reservers_array['Cake_Reserve'];
		$sql = "UPDATE stock
		SET Cake_Reserve='$newreserver'
		WHERE Shop_Manager='$manager'";
	}
	mysqli_query($conn, $sql);
	if ($_POST['bread']!='-')
	{
		$newreserver = $_POST['bread'] + $reservers_array['Simit_Reserve'];
		$sql = "UPDATE stock
		SET Simit_Reserve='$newreserver'
		WHERE Shop_Manager='$manager'";
	}
	mysqli_query($conn, $sql);
	if ($_POST['toast']!='-')
	{
		$newreserver = $_POST['toast'] + $reservers_array['Tost_Reserve'];
		$sql = "UPDATE stock
		SET Tost_Reserve='$newreserver'
		WHERE Shop_Manager='$manager'";
	}
	mysqli_query($conn, $sql);

	header("location:../html/Manager_View.html");

mysqli_close($conn);
?>
