<?php
require 'myadd.php';
session_start();

$cat_sql = "SELECT * FROM categories ORDER BY id ASC";
$cat_result = mysqli_query($connect, $cat_sql);

$category_images = [
    "อาหารตามสั่ง" => "assets/category/a1.jpg",
    "ปิ้งย่าง" => "assets/category/a2.jpg",
    "ชาบู" => "assets/category/a3.jpg",
    "คาเฟ่" => "assets/category/a4.jpg",
    "ซีฟู้ด" => "assets/category/a5.jpg",
    "ของหวาน" => "assets/category/a6.jpg",
    "ฟาสต์ฟู้ด" => "assets/category/a7.jpg",
    "ก๋วยเตี๋ยว" => "assets/category/a8.jpg",
    "หมูกระทะ" => "assets/category/a9.jpg",
    "สุกี้" => "assets/category/a10.jpg",
    "หม่าล่า" => "assets/category/a11.jpg"
];
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>หมวดหมู่อาหาร</title>
<link rel="icon" type="image/jpg" href="favicon.jpg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.category-card img{
    height: 180px;
    object-fit: cover;
}
.category-card{
    transition: 0.3s;
}
.category-card:hover{
    transform: scale(1.05);
}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5">
    <h3 class="text-center mb-4"> ประเภทอาหารที่ต้องการ</h3>

    <div class="row g-4">
        <?php while ($cat = mysqli_fetch_assoc($cat_result)) { 
            $image_url = $category_images[$cat['category_name']] ?? "assets/category/default.jpg";
        ?>
        <div class="col-md-3">
            <a href="shop_by_category.php?id=<?= $cat['id'] ?>" class="text-decoration-none">
                <div class="card category-card shadow-sm">
                    <img src="<?= $image_url ?>" class="card-img-top">
                    <div class="card-body text-center">
                        <h6><?= $cat['category_name'] ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>