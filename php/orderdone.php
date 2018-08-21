<?php
    session_start();
    if (!isset($_SESSION['username']))
    header("location: login.php");
    $db = new mysqli('localhost', 'root', '', 'FoodService');
    mysqli_query($db,"SET NAMES 'utf8'");
    mysqli_query($db,"SET CHARACTER SET 'utf8'");

    //euresi paraggelias pou molis pragmatopoiithike
    $sql = "SELECT * FROM orders WHERE deliverygirlboy = '".$_SESSION['username']."' AND status = 0";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $new_lat = $row['lat'];
    $new_lng = $row['lng'];

    //enimerosi oti pragmatopoiithike
    $sql = "UPDATE orders SET status = 1 WHERE deliverygirlboy='".$_SESSION['username']."'
    AND id = '".$_SESSION['orderid']."' ";
    $result = $db->query($sql);

    //ananeosi suntetagmenon topothesias deliveryman
    $sql = "SELECT * FROM deliverygirlboy WHERE Username = '".$_SESSION['username']."'";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);

    $sql = "UPDATE deliverygirlboy SET status = 1, lat = '".$new_lat."', lon = '".$new_lng."'
            WHERE username='".$_SESSION['username']."'";
    $result = $db->query($sql);

    echo("<script>alert('Ευχαριστούμε για τη συνεργασία. Η πληρωμή σας έχει προστεθεί. Παρακαλώ περιμένετε για επόμενη παραγγελία.')</script>");
    echo("<script>window.location = 'checkpendingorders.php';</script>");
?>
