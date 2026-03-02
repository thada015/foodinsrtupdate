<?php
session_start();
require_once __DIR__.'/../myadd.php';

if ($_SESSION['role'] !== 'admin') exit();

$id = $_GET['id'];
$shop_id = $_GET['shop_id'];

mysqli_query($connect,"DELETE FROM reviews WHERE id='$id'");
header("Location: ../shop.php?id=".$shop_id);
