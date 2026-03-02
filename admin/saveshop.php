<?php
session_start();
<<<<<<< HEAD
require '../myadd.php';

=======
require_once __DIR__ . '/../myadd.php';

/* ===== เช็กสิทธิ์แอดมิน ===== */
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home.php");
    exit();
}

<<<<<<< HEAD
$shop_name   = mysqli_real_escape_string($connect, trim($_POST['shop_name']));
$address     = mysqli_real_escape_string($connect, trim($_POST['address']));
$map_link    = mysqli_real_escape_string($connect, trim($_POST['map_link']));
$category_id = intval($_POST['category_id']);
$description = mysqli_real_escape_string($connect, trim($_POST['description']));

/* ===== อัปโหลดรูปปก ===== */
$cover_filename = '';
if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $cover_filename = 'shop_' . time() . '_cover.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $cover_filename);
}

/* ===== INSERT ร้าน ===== */
$sql = "INSERT INTO shops (shop_name, address, map_link, category_id, description, image)
        VALUES ('$shop_name','$address','$map_link',$category_id,'$description','$cover_filename')";

if (!mysqli_query($connect, $sql)) {
    die("เกิดข้อผิดพลาด: " . mysqli_error($connect));
}

$shop_id = mysqli_insert_id($connect);

/* ===== อัปโหลดรูปเพิ่มเติม ===== */
if (!empty($_FILES['extra_images']['name'][0])) {
    $files = $_FILES['extra_images'];
    $total = count($files['name']);

    for ($i = 0; $i < $total; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

        $ext  = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $fname = 'shop_' . $shop_id . '_' . time() . '_' . $i . '.' . $ext;

        if (move_uploaded_file($files['tmp_name'][$i], '../uploads/' . $fname)) {
            $fname_esc = mysqli_real_escape_string($connect, $fname);
            mysqli_query($connect,
                "INSERT INTO shop_images (shop_id, image) VALUES ($shop_id, '$fname_esc')"
            );
        }
    }
}

header("Location: shopmanage.php?success=add");
exit();
=======
/* ===== รับค่าจากฟอร์ม + ป้องกัน SQL Injection ===== */
$shop_name   = mysqli_real_escape_string($connect, $_POST['shop_name']);
$address     = mysqli_real_escape_string($connect, $_POST['address']);
$map_link    = mysqli_real_escape_string($connect, $_POST['map_link']);
$category_id = (int)$_POST['category_id'];
$description = mysqli_real_escape_string($connect, $_POST['description']);

/* ===== อัปโหลดรูป ===== */
$image = null;

if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image = time() . '_' . rand(1000,9999) . '.' . $ext;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        __DIR__ . '/../uploads/' . $image
    );
}

/* ===== บันทึกข้อมูล ===== */
$sql = "
INSERT INTO shops
(shop_name, address, map_link, category_id, description, image)
VALUES
('$shop_name', '$address', '$map_link', $category_id, '$description', '$image')
";

if (mysqli_query($connect, $sql)) {
    header("Location: ../home.php?success=1");
    exit();
} else {
    die("SQL ERROR: " . mysqli_error($connect));
}
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
