<?php
    session_start();
    if (!isset($_SESSION['username']))
    header("location: login.php");

    $db = new mysqli('localhost', 'root', '', 'FoodService');
    mysqli_query($db,"SET NAMES 'utf8'");
    mysqli_query($db,"SET CHARACTER SET 'utf8'");


    //apothikeusi tis topothesias tou delivera stin vasi
    $sql = "UPDATE deliverygirlboy
    SET lat = '".$_POST['latitude']."', lon = '".$_POST['longitude']."'
    WHERE username='".$_SESSION['username']."'";
    $result = $db->query($sql);

    echo("<script>alert('Παρακαλώ περιμένετε. Θα ενημερωθείτε μόλις υπάρξει κάποια παραγγελία προς παράδοση.')</script>");
    echo("<script>window.location = 'del_login_location.php';</script>");
?>
