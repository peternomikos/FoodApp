<?php
	$mysql_con = new mysqli('localhost', 'root', '', 'FoodService');
	mysqli_query($mysql_con,"SET NAMES 'utf8'");
	mysqli_query($mysql_con,"SET CHARACTER SET 'utf8'");


      $output = '';

      $sql    = "SELECT * FROM orders WHERE status = 0";
      $result = mysqli_query($mysql_con,$sql);
      $count  = mysqli_num_rows($result);

      if($count == 0) {
        $output = "Μόλις ολοκληρώθηκε.";
        echo $output;
        echo("<script>window.location = 'OrdersInProgress.php';</script>");
        return;
      }

      $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '
                <tr>
                     <td width="30%"><label>Όνομα</label></td>
                     <td width="70%">'.$row["name"].'</td>
                </tr>
                <tr>
                <td width="30%"><label>Επίθετο</label></td>
                <td width="70%">'.$row["surname"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Τηλέφωνο</label></td>
                     <td width="70%">'.$row["telephone"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Συνολικό Κόστος</label></td>
                     <td width="70%">'.$row["cost"].'</td>
                </tr>
                <tr>
                     <td width="30%"><label>Διανομέας</label></td>
                     <td width="70%">'.$row["deliverygirlboy"].'</td>
                </tr>
                ';
      }
      $output .= "</table></div>";
      echo $output;
    ?>
