<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'myadd.php';

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit();
}

$category_id = intval($_GET['id']);

// ดึงชื่อหมวด
$cat_query = mysqli_query($connect, 
    "SELECT * FROM categories WHERE id = $category_id"
);
$cat = mysqli_fetch_assoc($cat_query);

// ดึงร้านในหมวด
$sql = "
SELECT *
FROM shops
WHERE category_id = $category_id
ORDER BY created_at DESC
";

$shop_result = mysqli_query($connect, $sql);

if (!$shop_result) {
    die("Query ผิดพลาด: " . mysqli_error($connect));
}

$count = mysqli_num_rows($shop_result);

?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title><?= $cat['category_name'] ?></title>
<link rel="icon" type="image/jpg" href="favicon.jpg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.shop-card img{
    height: 200px;
    object-fit: cover;
}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5">


    <a href="category.php" class="btn btn-success mb-3">กลับหน้าหมวดหมู่</a>

    <h3 class="mb-4"> หมวด: <?= $cat['category_name'] ?></h3>
<div class="row g-4">
        <?php if ($count > 0) { 
    mysqli_data_seek($shop_result, 0);
    while ($shop = mysqli_fetch_assoc($shop_result)) { ?>
            <div class="col-md-4">
                <div class="card shop-card shadow-sm">
                    <?php if (!empty($shop['image'])) { ?>
    <img src="uploads/<?= $shop['image'] ?>" class="card-img-top">
<?php } else { ?>
    <img src="uploads/noimage.jpg" class="card-img-top">
<?php } ?>
                    <div class="card-body">
                        <h5><?= $shop['shop_name'] ?></h5>
                        <p class="text-muted">
                            <?= mb_strimwidth($shop['description'], 0, 80, '...') ?>
                        </p>

                        <a href="shop.php?id=<?= $shop['id'] ?>" 
                           class="btn btn-primary btn-sm">
                           ดูร้านเพิ่มเติม
                        </a>

                        <?php if (!empty($shop['map_link'])) { ?>
                        <a href="<?= $shop['map_link'] ?>" 
                           target="_blank"
                           class="btn btn-outline-success btn-sm">
                           เปิดแผนที่
                        </a>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <p class="text-muted">❌ ยังไม่มีร้านในหมวดนี้</p>
        <?php } ?>
    </div>
</div>

</body>
</html>