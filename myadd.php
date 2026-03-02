<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "accountuser";
         
$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Connect failed: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8");
