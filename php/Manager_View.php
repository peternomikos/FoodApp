<?php
session_start();
?>
<!DOCTYPE html>

<html lang="gr">

<head>
  <title>Manager_View</title>
  <h1>Welcome </h1>
  <?php
  echo "Favorite color is " . $_SESSION["login_user"] . ".<br>";
  ?>
</head>

<body>

  <section>

    <article>

    </article>

  </section>

</body>

</html>
