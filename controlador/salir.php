<?php
session_start();

unset($_SESSION);

session_destroy();

header("Location: index.php");
die();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cerrando sesión...</title>
</head>
<body>
</body>
</html>