<?php
session_start();
require 'myadd.php';

if (!isset($_GET['id'])) {
    die("ไม่พบร้านค้า");
}
$id = intval($_GET['id']);

/* ดึงข้อมูลร้าน + หมวดหมู่ */
$sql_shop = "
    SELECT shops.*, categories.category_name
    FROM shops
    LEFT JOIN categories ON shops.category_id = categories.id
    WHERE shops.id = $id
";
$result_shop = mysqli_query($connect, $sql_shop);
if (!$result_shop || mysqli_num_rows($result_shop) == 0) {
    die("ไม่พบข้อมูลร้าน");
}
$shop = mysqli_fetch_assoc($result_shop);

/* ดึงรูปจาก shop_images */
$sql_images = "
    SELECT image FROM shop_images
    WHERE shop_id = $id
    ORDER BY id ASC
";
$result_images = mysqli_query($connect, $sql_images);
$extra_images = [];
if ($result_images) {
    while ($img = mysqli_fetch_assoc($result_images)) {
        $extra_images[] = $img['image'];
    }
}

/* รวมรูปหลัก + รูปเพิ่มเติม (กันซ้ำ) */
$all_images = [];
if (!empty($shop['image'])) {
    $all_images[] = $shop['image'];
}
foreach ($extra_images as $img) {
    if (!in_array($img, $all_images)) {
        $all_images[] = $img;
    }
}
if (empty($all_images)) {
    $all_images[] = 'noimg.png';
}

/* รีวิว + โปรไฟล์ผู้ใช้ */
$sql_reviews = "
    SELECT reviews.*, 
           accountuser.user_account,
           accountuser.profile_image
    FROM reviews
    JOIN accountuser ON reviews.id_account = accountuser.id_account
    WHERE reviews.shop_id = $id
    ORDER BY reviews.id DESC
";
$reviews = mysqli_query($connect, $sql_reviews);

/* คะแนนเฉลี่ย */
$avg_q = mysqli_query($connect, "SELECT AVG(rating) AS avg_rating FROM reviews WHERE shop_id = $id");
$avg = mysqli_fetch_assoc($avg_q);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($shop['shop_name']) ?></title>
<link rel="icon" type="image/jpg" href="favicon.jpg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
  .carousel-main-img {
    height: 420px;
    object-fit: contain;
    background: #000;
}
  .thumb-img {
    height: 70px;
    object-fit: cover;
    cursor: pointer;
    border: 3px solid transparent;
    border-radius: 6px;
    transition: border-color .2s, opacity .2s;
    opacity: .65;
  }
  .thumb-img:hover,
  .thumb-img.active-thumb {
    border-color: #0d6efd;
    opacity: 1;
  }
</style>
</head>

<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container my-5">

  <!-- ================= SHOP INFO ================= -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h3 class="mb-1"><?= htmlspecialchars($shop['shop_name']) ?></h3>
          <span class="badge bg-warning text-dark">
            <?= htmlspecialchars($shop['category_name']) ?>
          </span>
        </div>
        <?php if (!empty($shop['map_link'])): ?>
          <a href="<?= htmlspecialchars($shop['map_link']) ?>" target="_blank"
             class="btn btn-outline-success btn-sm">
            🗺️ Google Map
          </a>
        <?php endif; ?>
      </div>
      <p class="text-muted mt-2 mb-1">📍 <?= htmlspecialchars($shop['address']) ?></p>
      <p class="mb-0">
        ⭐ คะแนนเฉลี่ย:
        <strong>
          <?= $avg['avg_rating'] ? number_format($avg['avg_rating'], 1) : 'ยังไม่มีรีวิว' ?>
        </strong>
      </p>
    </div>
  </div>

  <!-- ================= IMAGE CAROUSEL ================= -->
  <div class="card shadow-sm mb-4">

    <!-- Carousel หลัก -->
    <div id="shopCarousel" class="carousel slide" data-bs-ride="false">

      <div class="carousel-inner">
        <?php foreach ($all_images as $i => $img): ?>
          <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <img src="uploads/<?= htmlspecialchars($img) ?>"
                 class="d-block w-100 carousel-main-img"
                 alt="รูปร้าน <?= $i + 1 ?>">
          </div>
        <?php endforeach; ?>
      </div>

      <?php if (count($all_images) > 1): ?>
        <button class="carousel-control-prev" type="button"
                data-bs-target="#shopCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#shopCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>

        <!-- Counter -->
        <div class="position-absolute bottom-0 end-0 m-2">
          <span class="badge bg-dark bg-opacity-75" id="imgCounter">
            1 / <?= count($all_images) ?>
          </span>
        </div>
      <?php endif; ?>

    </div>

    <!-- Thumbnails -->
    <?php if (count($all_images) > 1): ?>
    <div class="d-flex gap-2 p-2 flex-wrap">
      <?php foreach ($all_images as $i => $img): ?>
        <img src="uploads/<?= htmlspecialchars($img) ?>"
             class="thumb-img <?= $i === 0 ? 'active-thumb' : '' ?>"
             style="width: 80px;"
             data-bs-target="#shopCarousel"
             data-bs-slide-to="<?= $i ?>"
             alt="thumb <?= $i + 1 ?>">
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>

  <!-- ================= REVIEW LIST ================= -->
  <h4 class="mb-3">รีวิวจากผู้ใช้</h4>

  <?php if (mysqli_num_rows($reviews) == 0): ?>
    <div class="alert alert-light text-center">ยังไม่มีรีวิว</div>
  <?php endif; ?>

  <?php while ($r = mysqli_fetch_assoc($reviews)): ?>
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <?php
          $profile = !empty($r['profile_image'])
              ? "uploads/profile/" . $r['profile_image']
              : "uploads/profile/default.png";
          ?>
          <img src="<?= $profile ?>" width="50" height="50"
               style="border-radius:50%; object-fit:cover; margin-right:10px;">
          <div>
            <strong><?= htmlspecialchars($r['user_account']) ?></strong><br>
            ⭐ <?= $r['rating'] ?>
          </div>
        </div>
        <p class="mt-2 mb-2"><?= nl2br(htmlspecialchars($r['comment'])) ?></p>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <div class="text-end">
            <a href="admin/delete_review.php?id=<?= $r['id'] ?>&shop_id=<?= $id ?>"
               class="btn btn-sm btn-outline-danger"
               onclick="return confirm('ลบรีวิวนี้?')">
              🗑️ ลบ
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>

  <!-- ================= REVIEW FORM ================= -->
  <div class="card shadow-sm mt-4">
    <div class="card-body">
      <?php if (isset($_SESSION['id_account'])): ?>
        <h5 class="mb-3">✍️ เขียนรีวิว</h5>
        <form action="save_review.php" method="post">
          <input type="hidden" name="shop_id" value="<?= $id ?>">
          <label class="form-label">ให้คะแนน</label>
          <select name="rating" class="form-select mb-3" required>
            <option value="5">⭐⭐⭐⭐⭐ ดีมาก</option>
            <option value="4">⭐⭐⭐⭐ ดี</option>
            <option value="3">⭐⭐⭐ ปานกลาง</option>
            <option value="2">⭐⭐ พอใช้</option>
            <option value="1">⭐ แย่</option>
          </select>
          <textarea name="comment" class="form-control mb-3" rows="3"
                    placeholder="เล่าประสบการณ์ของคุณ..." required></textarea>
          <button class="btn btn-primary">ส่งรีวิว</button>
        </form>
      <?php else: ?>
        <div class="alert alert-warning text-center mb-0">
          กรุณา <a href="login.php">เข้าสู่ระบบ</a> เพื่อเขียนรีวิว
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>

<script>
// อัปเดต thumbnail active + counter เมื่อ carousel เปลี่ยนรูป
const carousel = document.getElementById('shopCarousel');
if (carousel) {
  carousel.addEventListener('slid.bs.carousel', function (e) {
    const idx = e.to;
    const total = <?= count($all_images) ?>;

    // counter
    const counter = document.getElementById('imgCounter');
    if (counter) counter.textContent = (idx + 1) + ' / ' + total;

    // thumbs
    document.querySelectorAll('.thumb-img').forEach((t, i) => {
      t.classList.toggle('active-thumb', i === idx);
    });
  });
}
</script>

</body>
</html>