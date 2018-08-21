<?php
    session_start();

    $db = new mysqli('localhost', 'root', '', 'FoodService');
    mysqli_query($db,"SET NAMES 'utf8'");
    mysqli_query($db,"SET CHARACTER SET 'utf8'");

    //an einai apenergopoiimeni i vardia tou
    $sql = "SELECT * FROM deliverygirlboy WHERE username = '".$_SESSION['username']."' ";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $del_username = $row["Username"];

    if($row['status']==0 && $row['lat'] == 0 && $row['lon'] == 0) {
?>
<h3> &nbsp &nbsp &nbsp  Έναρξη Βάρδιας</h3>
<a href="location.php">
   <input class="button button1" type="button"  name="activation" id="activation" value="Ενεργοποίηση">
</a>
<?php
}else{ //an einai energopoiimenos
    echo "&nbsp &nbspΜην παραλείψετε να αποσυνδεθείτε όταν τελειώσει η βάρδιά σας. <br>";
    echo "&nbsp &nbspΠαρακαλώ, να ανανεώνετε την σελίδα ΠΑΡΑΓΓΕΛΙΕΣ<br>&nbsp &nbsp για να ενημερώνεστε για νέα ανάθεση παραγγελίας. <br><br>";
  }
?>
<a href="checkpendingorders.php">
   <input class="button button1" type="button"  name="orders" id="orders" value="Τσέκαρε τις παραγγελίες">
</a>
