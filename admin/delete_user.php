<?php
session_start();
require_once '../myadd.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../home.php");
    exit();
}

$id = intval($_GET['id']);

// กันลบตัวเอง
if ($id == $_SESSION['user_id']) {
    header("Location: manage_users.php");
    exit();
}

mysqli_query($connect, "DELETE FROM accountuser WHERE id_account = $id");

header("Location: manage_users.php");
exit();