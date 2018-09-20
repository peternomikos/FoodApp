<?php  
    session_start();
    if (!isset($_SESSION['login_user']))
    header("location: login.php");
    
	$db = new mysqli('localhost', 'root', '', 'FoodService');
	mysqli_query($db,"SET NAMES 'utf8'");
	mysqli_query($db,"SET CHARACTER SET 'utf8'");

    //euresi katastimatos tou sugkekrimenou manager
    $sql="SELECT * FROM manager WHERE Username = '".$_SESSION['login_user']."' ";
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result);
    $afm = $row['AFM'];


    $sql="SELECT * FROM store WHERE Store_Manager = '$afm' ";
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
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

        <script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
				});
			});
        </script>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
        </head>
	 <body>  
		 
		 <!-- menubar-section-starts -->
		 <div class="menu-bar">
			 <div class="container">
				 <div class="top-menu">
					 <ul>
						 <li><a href="index_man.php">ΑΡΧΙΚΗ</a></li>|
						 <li><a href="stock.php">ΑΠΟΘΕΜΑΤΑ</a></li>|
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
		 <!-- menubar-section-ends -->
		 
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
								 <td> <?php echo $row["name"]; ?> </td>  
								 <td><a href="#" class="hover" id="<?php echo $row["id"]; ?>"><?php echo "Προβολή"; ?></a></td>  
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
 
 <script>  
    //dunamiki emfanisi ton ekremon paraggelion meso ajax
    $(document).ready(function(){  
        $('.hover').popover({  
            title:fetchData,  
            html:true,  
            placement:'right'  
        });  
        function fetchData(){  
            var fetch_data = '';  
            var element = $(this);  
            var id = element.attr("id");  
            $.ajax({  
                    url:"select.php",  
                    method:"POST",  
                    async:false,  
                    data:{id:id},  
                    success:function(data){  
                        fetch_data = data;  
                    }  
            });  
            return fetch_data;  
        }  
    });  
 </script> 