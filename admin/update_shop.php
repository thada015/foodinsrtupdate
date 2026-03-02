<?php
session_start();
require '../myadd.php';

<<<<<<< HEAD
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id          = intval($_POST['id']);
$shop_name   = mysqli_real_escape_string($connect, trim($_POST['shop_name']));
$address     = mysqli_real_escape_string($connect, trim($_POST['address']));
$map_link    = mysqli_real_escape_string($connect, trim($_POST['map_link']));
$category_id = intval($_POST['category_id']);
$description = mysqli_real_escape_string($connect, trim($_POST['description']));

/* ===== อัปโหลดรูปปกใหม่ (ถ้ามี) ===== */
$cover_sql = '';
if (!empty($_FILES['image']['name'])) {
    $ext  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fname = 'shop_' . $id . '_cover_' . time() . '.' . $ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $fname)) {
        $fname_esc  = mysqli_real_escape_string($connect, $fname);
        $cover_sql  = ", image = '$fname_esc'";
    }
}

/* ===== UPDATE ข้อมูลร้าน ===== */
$sql = "UPDATE shops SET
            shop_name   = '$shop_name',
            address     = '$address',
            map_link    = '$map_link',
            category_id = $category_id,
            description = '$description'
            $cover_sql
        WHERE id = $id";

if (!mysqli_query($connect, $sql)) {
    die("เกิดข้อผิดพลาด: " . mysqli_error($connect));
}

/* ===== อัปโหลดรูปเพิ่มเติมใหม่ ===== */
if (!empty($_FILES['images']['name'][0])) {
    $files = $_FILES['images'];
    $total = count($files['name']);

    for ($i = 0; $i < $total; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

        $ext   = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $fname = 'shop_' . $id . '_' . time() . '_' . $i . '.' . $ext;

        if (move_uploaded_file($files['tmp_name'][$i], '../uploads/' . $fname)) {
            $fname_esc = mysqli_real_escape_string($connect, $fname);
            mysqli_query($connect,
                "INSERT INTO shop_images (shop_id, image) VALUES ($id, '$fname_esc')"
            );
        }
    }
}

header("Location: edit_shop.php?id=$id&success=1");
exit();
=======
if ($_SESSION['role'] !== 'admin') exit();

$id = intval($_POST['id']);

mysqli_query($connect,"
UPDATE shops SET
 shop_name='{$_POST['shop_name']}',
 category_id='{$_POST['category_id']}',
 address='{$_POST['address']}',
 map_link='{$_POST['map_link']}',
 description='{$_POST['description']}'
WHERE id=$id
");

/* อัปโหลดหลายรูป */
if (!empty($_FILES['images']['name'][0])) {
  foreach ($_FILES['images']['name'] as $k => $name) {
    $file = time().'_'.$name;
    move_uploaded_file($_FILES['images']['tmp_name'][$k],
        "../uploads/".$file);

    mysqli_query($connect,"
      INSERT INTO shop_images (shop_id,image)
      VALUES ($id,'$file')
    ");
  }
}

header("Location: shopmanage.php");
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
