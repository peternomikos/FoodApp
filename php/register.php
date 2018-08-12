<?php session_start(); ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>

<?php
  $conn = new mysqli('localhost', 'root', '', 'FoodService');
  mysqli_query($conn,"SET NAMES 'utf8'");
  mysqli_query($conn,"SET CHARACTER SET 'utf8'");

  if (mysqli_connect_error())
  {
      die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
  }
  $name	     = $_POST['name'];
  $surname   = $_POST['surname'];
  $password  = $_POST['password'];
  $password2 = $_POST['password2'];
  $email     = $_POST['email'];
  $telephone = $_POST['telephone'];
  $nlen      = strlen($name);
  $slen      = strlen($surname);
  $plen      = strlen($telephone);

  if($run_query=mysqli_query($conn,"SELECT * FROM customer WHERE customer.email='$email'")){
    if(mysqli_num_rows($run_query)>0){
      echo("<script>alert('To email $email υπάρχει ήδη.')</script>");
      echo("<script>window.location = 'register.php';</script>");
    }
  }

  if($password!=$password2){
    echo("<script>alert('Οι κωδικοί που έχετε δώσει δεν είναι ίδιοι.')</script>");
    echo("<script>window.location = 'register.php';</script>");
  }

  if($nlen>25 || $slen>25){
    echo("<script>alert('Το όνομα ή επίθετο που εισάγατε είναι πολύ μεγάλο.')</script>");
    echo("<script>window.location = 'register.php';</script>");
  }

  if(!filter_var( $email, FILTER_VALIDATE_EMAIL)){
    echo("<script>alert('Το email που εισάγατε δεν είναι έγκυρο.')</script>");
    echo("<script>window.location = 'register.php';</script>");
  }
  if($plen != 10){
    echo("<script>alert('Το νούμερο τηλεφώνου που εισάγατε δεν είναι έγκυρο.')</script>");
    echo("<script>window.location = 'register.php';</script>");
  }

  $sql = "INSERT into costumer VALUES ('$name','$surname','$email','$password','$telephone')";
  if (mysqli_query($conn, $sql)) {
      echo("<script>alert('New record created successfully')</script>");
      $_SESSION['login_user'] = $email;
      header("location:../html/Client_View.html");
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  $conn->close();
  ?>
</html>
