<?php
session_start();
require '../myadd.php';

/* =========================
   เช็คสิทธิ์แอดมิน
========================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/* =========================
   เช็ค id
========================= */
if (!isset($_GET['id'])) {
    header("Location: shop_manage.php");
    exit();
}

$id = intval($_GET['id']);

/* =========================
   ลบรูปหลายรูปของร้าน
========================= */
$images = mysqli_query($connect, "
    SELECT image FROM shop_images WHERE shop_id = $id
");

if ($images) {
    while ($img = mysqli_fetch_assoc($images)) {
        $path = "../uploads/" . $img['image'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

/* ลบ record รูป */
mysqli_query($connect, "DELETE FROM shop_images WHERE shop_id = $id");

/* =========================
   ลบรูปหลักร้าน (ถ้ามี)
========================= */
$result = mysqli_query($connect, "
    SELECT image FROM shops WHERE id = $id
");

if ($result && mysqli_num_rows($result) > 0) {
    $shop = mysqli_fetch_assoc($result);

    if (!empty($shop['image'])) {
        $main_img = "../uploads/" . $shop['image'];
        if (file_exists($main_img)) {
            unlink($main_img);
        }
    }
}

/* =========================
   ลบรีวิว (ถ้าไม่ได้ใช้ ON DELETE CASCADE)
========================= */
mysqli_query($connect, "DELETE FROM reviews WHERE shop_id = $id");

/* =========================
   ลบร้าน
========================= */
mysqli_query($connect, "DELETE FROM shops WHERE id = $id");

/* ========================= */
header("Location: shopmanage.php");
exit();