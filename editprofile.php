<?php
session_start();
require 'myadd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']); // ปลอดภัยขึ้น

// ใช้ id_account ให้ตรงกับฐานข้อมูล
$result = mysqli_query($connect, "SELECT * FROM accountuser WHERE id_account = $user_id");

if (!$result) {
    die("SQL Error: " . mysqli_error($connect));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("ไม่พบข้อมูลผู้ใช้");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>แก้ไขโปรไฟล์</title>
    <link rel="icon" type="image/jpg" href="favicon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="mb-4 text-center fw-bold text-dark">ตั้งค่าโปรไฟล์</h4>

        <form action="updateprofile.php" method="POST" enctype="multipart/form-data">

            <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                    <img src="uploads/profile/<?= !empty($user['profile_image']) ? $user['profile_image'] : 'default.png' ?>"
                         class="rounded-circle shadow-sm"
                         width="120" height="120"
                         style="object-fit:cover; border: 4px solid #fff;">
                    <div class="position-absolute bottom-0 end-0 bg-white border rounded-circle p-2 shadow-sm d-flex justify-content-center align-items-center" style="width: 35px; height: 35px; transform: translate(-5%, -5%);">
                        <i class="bi bi-camera-fill text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-semibold small mb-1">ชื่อผู้ใช้งาน</label>
                <input type="text" class="form-control bg-light text-secondary border-0 py-2 px-3 rounded-3"
                       value="<?= htmlspecialchars($user['user_account']) ?>" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-semibold small mb-1">ชื่อเล่นของคุณ</label>
                <input type="text"
                       name="nickname"
                       class="form-control custom-input py-2 px-3 rounded-3 shadow-none"
                       value="<?= htmlspecialchars($user['nickname']) ?>"
                       placeholder="กรอกชื่อเล่นที่ต้องการให้แสดง">
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-semibold small mb-1">เปลี่ยนรูปโปรไฟล์</label>
                <input type="file"
                       name="profile_image"
                       class="form-control form-control-sm text-muted rounded-3"
                       accept="image/*">
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-medium mt-2 btn-save">
                บันทึกการเปลี่ยนแปลง
            </button>

        </form>
    </div>
</div>

</body>
</html>