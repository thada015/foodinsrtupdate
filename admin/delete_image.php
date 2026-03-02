<?php
session_start();
require '../myadd.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$img_id  = intval($_GET['id']);
$shop_id = intval($_GET['shop_id']);
$is_ajax = isset($_GET['ajax']);

// ดึงชื่อไฟล์ก่อนลบ
$row = mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT image FROM shop_images WHERE id = $img_id AND shop_id = $shop_id")
);

if (!$row) {
    if ($is_ajax) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบรูปภาพ']);
    } else {
        header("Location: edit_shop.php?id=$shop_id&error=notfound");
    }
    exit();
}

// ลบไฟล์จริง
$file_path = __DIR__ . '/../uploads/' . $row['image'];
if (file_exists($file_path)) {
    unlink($file_path);
}

// ลบจาก database
mysqli_query($connect, "DELETE FROM shop_images WHERE id = $img_id AND shop_id = $shop_id");

if ($is_ajax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    header("Location: edit_shop.php?id=$shop_id");
}
exit();