<?php
session_start();
require '../myadd.php';

// (ถ้ามีระบบ admin login ควรเช็คตรงนี้)

$sql = "
SELECT reviews.*, 
       accountuser.user_account, 
       shops.shop_name
FROM reviews
JOIN accountuser 
    ON reviews.id_account = accountuser.id_account
JOIN shops 
    ON reviews.shop_id = shops.id
ORDER BY reviews.id DESC
";

$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการรีวิว</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<<<<<<< HEAD
<?php  include "../navbar.php"; ?>
=======

>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">📋 จัดการรีวิวทั้งหมด</h3>
    <a href="dashboard.php" class="btn btn-secondary">
        ← กลับหน้า Dashboard
    </a>
</div>

    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>#</th>
                <th>ร้าน</th>
                <th>ผู้รีวิว</th>
                <th>คะแนน</th>
                <th>ความคิดเห็น</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['shop_name'] ?></td>
                <td><?= $row['user_account'] ?></td>
                <td>⭐ <?= $row['rating'] ?></td>
                <td><?= $row['comment'] ?></td>
                <td>
                    <a href="deletereview.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('ลบรีวิวนี้หรือไม่?')">
                       ลบ
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>