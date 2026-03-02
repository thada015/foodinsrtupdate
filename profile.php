<?php
session_start();
require 'myadd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

/* ================= USER INFO ================= */
$userQuery = mysqli_query($connect,
    "SELECT * FROM accountuser WHERE id_account = $user_id");

if (!$userQuery) {
    die(mysqli_error($connect));
}

$user = mysqli_fetch_assoc($userQuery);

/* ================= REVIEW COUNT ================= */
$countQuery = mysqli_query($connect,
    "SELECT COUNT(*) AS total_reviews
     FROM reviews
     WHERE id_account = $user_id");

if (!$countQuery) {
    die(mysqli_error($connect));
}

$countData = mysqli_fetch_assoc($countQuery);
$total_reviews = $countData['total_reviews'];

/* ================= REVIEW LIST ================= */
$reviewList = mysqli_query($connect,
    "SELECT reviews.*, shops.shop_name
     FROM reviews
     JOIN shops ON reviews.shop_id = shops.id
     WHERE reviews.id_account = $user_id
     ORDER BY reviews.created_at DESC");

if (!$reviewList) {
    die(mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>โปรไฟล์</title>
    <link rel="icon" type="image/jpg" href="favicon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background: #f8f9fa;
}

.review-card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">

    <div class="card shadow-lg border-0 p-4 mb-4 text-center">

    <div class="position-relative d-inline-block">
        <img src="uploads/profile/<?= !empty($user['profile_image']) ? $user['profile_image'] : 'default.png' ?>"
             width="140" height="140"
             class="rounded-circle shadow"
             style="object-fit:cover; border:4px solid #fff;">
    </div>

    <h3 class="mt-3 fw-bold">
        <?= htmlspecialchars($user['nickname'] ?: $user['user_account']) ?>
    </h3>

    <p class="text-muted"><?= htmlspecialchars($user['email_account']) ?></p>

    <div class="d-flex justify-content-center gap-3 mt-3">

        <div class="text-center">
            <h5 class="fw-bold mb-0"><?= $total_reviews ?></h5>
            <small class="text-muted">รีวิว</small>
        </div>

    </div>

    <div class="mt-4">
        <a href="editprofile.php" class="btn btn-outline-dark px-4 rounded-pill">
            แก้ไขโปรไฟล์
        </a>
    </div>
</div>

    <!-- ================= REVIEW LIST ================= -->

    <h5 class="mb-3">รีวิวของฉัน</h5>

    <?php if ($total_reviews > 0) { ?>
        <?php while ($review = mysqli_fetch_assoc($reviewList)) { ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">
                        <?= htmlspecialchars($review['shop_name']) ?>
                    </h6>

                    <div class="text-warning mb-2">
                        <?= str_repeat("⭐", $review['rating']) ?>
                    </div>

                    <p><?= htmlspecialchars($review['comment']) ?></p>

                    <small class="text-muted">
                        <?= $review['created_at'] ?>
                    </small>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="alert alert-info">
            ยังไม่มีรีวิว
        </div>
    <?php } ?>

</div>

</body>
</html>