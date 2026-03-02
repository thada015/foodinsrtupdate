<?php
require 'myadd.php';

/* ===== INSERT ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $shop_name   = $_POST['shop_name'];
    $description = $_POST['description'];
    $address     = $_POST['address'];
    $category_id = $_POST['category_id'];

    /* ===== UPLOAD IMAGE ===== */
    $image_name = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '.' . $ext;
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "uploads/" . $image_name
        );
    }

    $sql = "INSERT INTO shops (shop_name, description, address, image, category_id)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $shop_name,
        $description,
        $address,
        $image_name,
        $category_id
    );
    mysqli_stmt_execute($stmt);
}

/* ===== SELECT ===== */
$result = mysqli_query($connect, "SELECT * FROM shops ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการร้านอาหาร</title>
</head>
<<<<<<< HEAD
<?php  include "../navbar.php"; ?>
=======
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
<body>
<h2>ข้อมูลร้านอาหาร
</h2>

<hr>

<h2>ร้านอาหารทั้งหมด</h2>

<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>รูป</th>
    <th>ชื่อร้าน</th>
    <th>ที่อยู่</th>
    <th>หมวดหมู่อาหาร</th>


</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td>
        <?php if (!empty($row['image'])) { ?>
            <img src="uploads/<?= $row['image'] ?>" width="100">
        <?php } ?>
    </td>
    <td><?= $row['shop_name'] ?></td>
    <td><?= $row['address'] ?></td>
    <td><?= $row['category_id'] ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>