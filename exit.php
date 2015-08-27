<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
    </head>
    <body>
    </body>
</html>
<?php
session_start();
unset($_SESSION['logged']);
unset($_SESSION['operator']);
session_unset();
session_destroy();
header("Location: login.php");