<?php
session_start();
require 'myadd.php';

if (!isset($_SESSION['id_account'])) {
    header("Location: login.php");
    exit();
}

$id_account = intval($_SESSION['id_account']);
$shop_id = intval($_POST['shop_id']);
$rating  = intval($_POST['rating']);
$comment = mysqli_real_escape_string($connect, $_POST['comment']);

$sql = "
    INSERT INTO reviews (shop_id, id_account, rating, comment)
    VALUES ('$shop_id','$id_account','$rating','$comment')
";

if (!mysqli_query($connect, $sql)) {
    die("SQL Error: " . mysqli_error($connect));
}

header("Location: shop.php?id=".$shop_id);
exit();
?>