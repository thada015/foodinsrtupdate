<?php
session_start();
require 'myadd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$nickname = mysqli_real_escape_string($connect, $_POST['nickname']);

/* ===== อัปเดตชื่อเล่นก่อน ===== */
mysqli_query($connect, "
    UPDATE accountuser
    SET nickname = '$nickname'
    WHERE id_account = $user_id
");

/* ===== ถ้ามีอัปโหลดรูป ===== */
if (!empty($_FILES['profile_image']['name'])) {

    $folder = "uploads/profile/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $image_name = time() . "_" . $_FILES['profile_image']['name'];

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $folder . $image_name)) {

        mysqli_query($connect, "
            UPDATE accountuser
            SET profile_image = '$image_name'
            WHERE id_account = $user_id
        ");
    }
}

header("Location: home.php");
exit();
?>