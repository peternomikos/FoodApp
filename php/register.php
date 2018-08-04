<?php
$conn = new mysqli('localhost', 'root', '', 'FoodService');

if (mysqli_connect_error())
{
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}
$password  = $_POST['password'];
$email     = $_POST['email'];
$telephone = $_POST['telephone'];

$sql = "INSERT into costumer (email, password, telephone) VALUES ('".$_POST['email']."','".$_POST['password']."','".$_POST['telephone']."')";

if ($conn->query($sql) === TRUE) {
    echo "Καλώς Ήρθατε στο FooDelicious";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
