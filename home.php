<?php
session_start();
require 'myadd.php';

if (isset($_SESSION['user_id'])) {
<<<<<<< HEAD
=======
  require 'myadd.php';
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
    $uid = intval($_SESSION['user_id']);
    $result = mysqli_query($connect, "SELECT profile_image, nickname FROM accountuser WHERE id_account = $uid");
    $user_nav = mysqli_fetch_assoc($result);

    $profile_image = !empty($user_nav['profile_image'])
        ? 'uploads/profile/' . $user_nav['profile_image']
        : 'uploads/profile/default.png';

    $display_name = !empty($user_nav['nickname'])
        ? $user_nav['nickname']
        : $_SESSION['username'];
}
<<<<<<< HEAD

// ===== 1. รับค่าค้นหา =====
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// ===== 2. สร้าง WHERE =====
$where_sql = '';
if ($search !== '') {
    $like = '%' . mysqli_real_escape_string($connect, $search) . '%';
    $where_sql = "WHERE (
        shops.shop_name          LIKE '$like'
     OR shops.description        LIKE '$like'
     OR shops.address            LIKE '$like'
     OR categories.category_name LIKE '$like'
    )";
}

// ===== 3. Pagination =====
$per_page = 6;
$page     = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset   = ($page - 1) * $per_page;

$count_res   = mysqli_fetch_assoc(mysqli_query($connect,
    "SELECT COUNT(*) AS total FROM shops
     JOIN categories ON shops.category_id = categories.id
     $where_sql"
));
$total_all   = $count_res['total'];
$total_pages = ceil($total_all / $per_page);

// ===== 4. Query หลัก =====
$sql = "
  SELECT shops.id, shops.shop_name, shops.description,
         shops.address, shops.image, shops.map_link,
         categories.category_name
  FROM shops
  JOIN categories ON shops.category_id = categories.id
  $where_sql
  ORDER BY shops.id DESC
  LIMIT $per_page OFFSET $offset
";

$result = mysqli_query($connect, $sql);
if (!$result) { die("SQL ERROR: " . mysqli_error($connect)); }
$total = mysqli_num_rows($result);
=======
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/jpg" href="favicon.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<<<<<<< HEAD
  <title>FoodinSrt</title>
  <style>
    .carousel-img { height: 500px; object-fit: cover; }
    @media (max-width: 768px) { .carousel-img { height: 250px; } }
    mark { background-color: #fff3cd; padding: 0 2px; border-radius: 3px; }
    .no-result-box { text-align: center; padding: 60px 20px; color: #aaa; }
    .no-result-box .icon { font-size: 3.5rem; }
  </style>
</head>
<body>

=======

  <title>FoodinSrt</title>

  <style>
    .carousel-img {
      height: 500px;
      object-fit: cover;
    }

    @media (max-width: 768px) {
      .carousel-img {
        height: 250px;
      }
    }

    .navbar form input {
      min-width: 250px;
    }
  </style>
</head>

<body>


>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
<?php include 'navbar.php'; ?>

<!-- ================= สไลด์ ================= -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
<<<<<<< HEAD
    <div class="carousel-item active">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>
    <div class="carousel-item">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>
    <div class="carousel-item">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
=======

    <div class="carousel-item active">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>

    <div class="carousel-item">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>

    <div class="carousel-item">
      <img src="pt/p1.jpg" class="d-block w-100 carousel-img">
    </div>

  </div>

  <button class="carousel-control-prev" type="button"
          data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button"
          data-bs-target="#carouselExample" data-bs-slide="next">
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- ================= ร้านอาหาร ================= -->
<<<<<<< HEAD
<div class="container mt-5">

  <?php if ($search !== ''): ?>
    <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
      <p class="mb-0 text-muted">
        พบ <strong><?= $total_all ?></strong> ร้านอาหาร
        สำหรับ "<strong><?= htmlspecialchars($search) ?></strong>"
      </p>
      <a href="home.php" class="btn btn-sm btn-outline-secondary">✕ ล้างการค้นหา</a>
    </div>
  <?php endif; ?>

  <?php if ($total > 0): ?>
  <div class="row g-4">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="uploads/<?= htmlspecialchars($row['image'] ?: 'noimg.png') ?>"
               class="card-img-top" style="height:200px; object-fit:cover;"
               alt="<?= htmlspecialchars($row['shop_name']) ?>">
          <div class="card-body">
            <span class="badge bg-warning text-dark mb-2">
              <?= htmlspecialchars($row['category_name']) ?>
            </span>
            <h5 class="card-title">
              <?php
                $name = htmlspecialchars($row['shop_name']);
                if ($search !== '') {
                    $name = preg_replace(
                        '/(' . preg_quote(htmlspecialchars($search), '/') . ')/iu',
                        '<mark>$1</mark>', $name
                    );
                }
                echo $name;
              ?>
            </h5>
            <p class="small text-muted">📍 <?= htmlspecialchars($row['address']) ?></p>
            <p class="card-text">
              <?= mb_strimwidth(htmlspecialchars($row['description']), 0, 70, '...') ?>
            </p>
            <div class="d-flex gap-2">
              <a href="shop.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">ดูร้านเพิ่มเติม</a>
              <a href="<?= htmlspecialchars($row['map_link']) ?>" target="_blank"
                 class="btn btn-outline-success btn-sm">เปิดแผนที่</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <?php else: ?>
  <div class="no-result-box">
    
    <h5 class="mt-3">ไม่พบร้านอาหาร</h5>
    <p>ลองค้นหาด้วยคำอื่นดูนะครับ</p>
    <a href="home.php" class="btn btn-success mt-2">ดูร้านอาหารทั้งหมด</a>
  </div>
  <?php endif; ?>

</div>

<!-- ================= Pagination ================= -->
<?php if ($total_pages > 1): ?>
<div class="d-flex justify-content-center mt-4 mb-5">
  <ul class="pagination">

    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">&laquo;</a>
    </li>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= $i === $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
      <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">&raquo;</a>
    </li>

  </ul>
</div>
<?php endif; ?>
=======
<?php
require 'myadd.php';

$sql = "
SELECT 
    shops.id,
    shops.shop_name,
    shops.description,
    shops.address,
    shops.image,
    shops.map_link,
    categories.category_name
FROM shops
JOIN categories ON shops.category_id = categories.id
ORDER BY shops.id DESC
";

$result = mysqli_query($connect, $sql);

if (!$result) {
  die("SQL ERROR: " . mysqli_error($connect));
}
?>

<div class="container mt-5">
  <div class="row g-4">

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">

          <img src="uploads/<?= $row['image'] ?: 'noimg.png' ?>"
               class="card-img-top"
               style="height:200px; object-fit:cover;">

          <div class="card-body">
            <span class="badge bg-warning text-dark mb-2">
                <?= $row['category_name'] ?>
            </span>

            <h5 class="card-title"><?= $row['shop_name'] ?></h5>

            <p class="small text-muted">
                📍 <?= $row['address'] ?>
            </p>

            <p class="card-text">
                <?= mb_strimwidth($row['description'], 0, 70, '...') ?>
            </p>

            <div class="d-flex gap-2">
                <a href="shop.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                    ดูร้านเพิ่มเติม
                </a>

                <a href="<?= $row['map_link'] ?>" target="_blank"
                   class="btn btn-outline-success btn-sm">
                    เปิดแผนที่
                </a>
            </div>
          </div>
          

        </div>
      </div>
    <?php } ?>

  </div>
</div>

<!-- ================= ปุ่มไปหน้าอื่น ================= -->
<div class="d-flex justify-content-center mt-4 mb-5">
  <div class="btn-group">
    <button class="btn btn-primary">1</button>
    <button class="btn btn-primary">2</button>
    <button class="btn btn-primary">3</button>
    <button class="btn btn-primary">4</button>
  </div>
</div>
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705

</body>
</html>