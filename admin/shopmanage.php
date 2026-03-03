<?php
session_start();
require '../myadd.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$shops = mysqli_query($connect, "
    SELECT shops.*, categories.category_name
    FROM shops
    LEFT JOIN categories ON shops.category_id = categories.id
    ORDER BY shops.id DESC
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการร้านอาหาร</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php  include "../navbar.php"; ?>
<body class="bg-light">

<div class="container my-5">

  <!-- HEADER -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">🏪 จัดการร้านอาหาร</h3>
    <a href="adminshop.php" class="btn btn-success">
      ➕ เพิ่มร้านอาหาร
    </a>
  </div>

  <!-- TABLE -->
  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>รูปภาพ</th>
            <th>ชื่อร้าน</th>
            <th>หมวดหมู่</th>
            <th>รายละเอียด</th>
            <th>ที่อยู่ / แผนที่</th>
            <th class="text-center">จัดการ</th>
          </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_assoc($shops)) { ?>
          <tr>

            <td><?= $row['id'] ?></td>

            <!-- รูป -->
            <td>
              <img src="../uploads/<?= $row['image'] ?: 'noimg.png' ?>"
                   class="rounded"
                   width="90"
                   height="70"
                   style="object-fit:cover;">
            </td>

            <!-- ชื่อ -->
            <td>
              <strong><?= htmlspecialchars($row['shop_name']) ?></strong>
            </td>

            <!-- หมวด -->
            <td>
              <span class="badge bg-warning text-dark">
                <?= htmlspecialchars($row['category_name']) ?>
              </span>
            </td>

            <!-- รายละเอียด -->
            <td class="text-muted" style="max-width:200px;">
              <?= mb_strimwidth(strip_tags($row['description']), 0, 60, '...') ?>
            </td>

            <!-- ที่อยู่ + map -->
            <td style="max-width:220px;">
              <div class="small">
                📍 <?= htmlspecialchars($row['address']) ?>
              </div>
              <?php if (!empty($row['map_link'])) { ?>
                <a href="<?= $row['map_link'] ?>" target="_blank"
                   class="btn btn-sm btn-outline-success mt-1">
                  🗺️ แผนที่
                </a>
              <?php } ?>
            </td>

            <!-- ปุ่ม -->
            <td class="text-center">
              <a href="edit_shop.php?id=<?= $row['id'] ?>"
                 class="btn btn-sm btn-warning mb-1">
                ✏️ แก้ไข
              </a>

              <a href="delete_shop.php?id=<?= $row['id'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('ลบร้านนี้ใช่หรือไม่?')">
                🗑️ ลบ
              </a>
            </td>

          </tr>
        <?php } ?>
        </tbody>

      </table>
    </div>
  </div>

  <!-- BACK -->
  <div class="mt-4">
    <a href="dashboard.php">
      ⬅ กลับ Dashboard
    </a>
  </div>

</div>

</body>
</html>