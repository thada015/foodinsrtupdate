<?php
session_start();
require_once '../myadd.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔒 ตรวจสิทธิ์
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = intval($_GET['id']);

// กันลบตัวเอง
if ($id == $_SESSION['user_id']) {
    header("Location: manage_users.php");
    exit();
}

// ดึง role ปัจจุบัน
$result = mysqli_query($connect,
    "SELECT role FROM accountuser WHERE id_account = $id"
);

if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}

if (mysqli_num_rows($result) == 0) {
    header("Location: manage_users.php");
    exit();
}

$user = mysqli_fetch_assoc($result);

$new_role = ($user['role'] === 'admin') ? 'user' : 'admin';

$update = mysqli_query($connect,
    "UPDATE accountuser SET role = '$new_role' WHERE id_account = $id"
);

if (!$update) {
    die("Update Error: " . mysqli_error($connect));
}

header("Location: manage_users.php");
exit();