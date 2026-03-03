<?php
session_start();
require_once '../myadd.php';

// 🔒 กันไม่ให้คนที่ไม่ใช่ admin เข้า
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../home.php");
    exit();
}

// ดึงผู้ใช้ทั้งหมด
$user_query = mysqli_query($connect, "
    SELECT id_account, user_account, nickname, role, profile_image
    FROM accountuser
    ORDER BY id_account DESC
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการผู้ใช้</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php  include "../navbar.php"; ?>
<div class="container mt-5">
    <h3>จัดการผู้ใช้</h3>

    <a href="dashboard.php" class="btn btn-danger mb-3">กลับ Dashboard</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>รูป</th>
                <th>Username</th>
                <th>Nickname</th>
                <th>Role</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($user = mysqli_fetch_assoc($user_query)) { ?>
            <tr>
                <td><?= $user['id_account'] ?></td>
                <td>
                    <?php
                    $img = !empty($user['profile_image'])
                        ? "../uploads/profile/" . $user['profile_image']
                        : "../uploads/profile/default.png";
                    ?>
                    <img src="<?= $img ?>" width="40" height="40" class="rounded-circle" style="object-fit:cover;">
                </td>
                <td><?= htmlspecialchars($user['user_account']) ?></td>
                <td><?= htmlspecialchars($user['nickname']) ?></td>
                <td>
                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'secondary' ?>">
                        <?= $user['role'] ?>
                    </span>
                </td>
                <td>

                    <!-- เปลี่ยน role -->
                    <?php if ($_SESSION['user_id'] != $user['id_account']) { ?>
                        <a href="toggle_role.php?id=<?= $user['id_account'] ?>" 
                           class="btn btn-warning btn-sm">
                           เปลี่ยนสิทธิ์
                        </a>

                        <a href="delete_user.php?id=<?= $user['id_account'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('ลบผู้ใช้นี้?');">
                           ลบ
                        </a>
                    <?php } else { ?>
                        <span class="text-muted">คุณ</span>
                    <?php } ?>

                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>

</body>
</html>