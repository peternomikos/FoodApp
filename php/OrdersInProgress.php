<?php
    session_start();
    if (!isset($_SESSION['login_user']))
    header("location: login.php");

    $Manager = $_SESSION['login_user'];
	  $db = new mysqli('localhost', 'root', '', 'FoodService');
	  mysqli_query($db,"SET NAMES 'utf8'");
	  mysqli_query($db,"SET CHARACTER SET 'utf8'");

    $sql="SELECT * FROM store WHERE Store_Manager = '$Manager' ";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $st_name = $row['Store_Name'];

    //euresi ton paraggelion tou katastimatos tou pou ekremoun
    $sql="SELECT * FROM orders WHERE st_address = '$st_name' AND status = 0 ";
    $result = $db->query($sql);
    $count=mysqli_num_rows($result);

 ?>
 <!DOCTYPE html>
 <html>
      <head>
        <title>Εκρεμείς Παραγγελίες</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      </head>
	 <body>

		 <!-- menubar-section-starts -->
		 <div class="menu-bar">
			 <div class="container">
				 <div class="top-menu">
					 <ul>
						 <li><a href="../html/Manager_View.html">ΑΡΧΙΚΗ</a></li>|
						 <li class="active"><a href="OrdersInProgress.php">ΕΚΡΕΜΕΙΣ ΠΑΡΑΓΓΕΛΙΕΣ</a></li>
						 <div class="clearfix"></div>
					 </ul>
				 </div>
				 <div class="login-section">
					 <ul>
						 <li><h3>Γειά σου <?php echo $_SESSION['login_user']; ?> </h3></li>
						 <li><a href="logout.php">Αποσύνδεση</a></li>
						 <div class="clearfix"></div>
					 </ul>
				 </div>
				 <div class="clearfix"></div>
			 </div>
		 </div>


		 <?php
			 if($count == 0) {
				 echo "&nbsp &nbspΔεν υπάρχουν εκρεμείς παραγγελίες προς το παρόν για το κατάστημά σας.";
				 }else{
			 ?>

			 <div class="container" style="width:800px;">
				 <br>
				 <div class="table-responsive">
					 <table class="table table-bordered">
						 <tr>
							 <th width="70%">Όνομα Πελάτη</th>
							 <th width="30%">Λεπτομέρειες</th>
						 </tr>
						 <?php
							 while($row = mysqli_fetch_array($result))
							 {
							 ?>
							 <tr>
								 <td><div id="links"></div></td>
							 </tr>
							 <?php
							 }
						 ?>
					 </table>
				 </div>
			 </div>

			 <?php
			 }
		 ?>
	 </body>
 </html>

 <script language="javascript" type="text/javascript">
  function loadlink(){
    $('#links').load('select.php',function () {$(this).unwrap(); });
  }
  loadlink();
  setInterval(function(){ loadlink() }, 5000);
 </script>
