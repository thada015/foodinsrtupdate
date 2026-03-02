<?php
require '../myadd.php';

$id = $_GET['id'];

mysqli_query($connect, "DELETE FROM reviews WHERE id = '$id'");

header("Location: reviews.php");
exit();
?>