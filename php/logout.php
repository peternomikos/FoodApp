<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7"/>
</head>
<?php
session_destroy();
echo("<script>window.location = '../index.html';</script>");
?>
</html>
