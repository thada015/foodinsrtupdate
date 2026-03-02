<?php
session_start();
require '../myadd.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// นับข้อมูล
$shop_count   = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM shops"))[0];
$review_count = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM reviews"))[0];
$user_count   = mysqli_fetch_row(mysqli_query($connect,"SELECT COUNT(*) FROM accountuser"))[0];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
<?php  include "../navbar.php"; ?>
=======

>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
<div class="container-fluid">
  <div class="row">

    <!-- 🔹 Sidebar -->
<body>
<div class="d-flex">

  <!-- 🔹 MAIN CONTENT -->
  <div class="main-content p-4 w-100">
    <!-- เนื้อหา Dashboard ของคุณ -->
  </div>

<<<<<<< HEAD
 
  <div class="sidebar bg-dark text-white ">
    <h5 class="mb-4">🍽️ Admin Panel</h5>

    <a href="dashboard.php" class="menu-item active">📊 Dashboard</a>
=======
  <!-- 🔹 SIDEBAR (ขวา) -->
  <div class="sidebar bg-dark text-white p-3">
    <h5 class="mb-4">🍽️ Admin Panel</h5>

    <a href="dashboard.php" class="menu-item active">📊 Dashboard</a>
    <a href="/foodinsrt/home.php"class="menu-item">Home</a>
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
    <a href="adminshop.php" class="menu-item">เพิ่มร้าน</a>
    <a href="manage_users.php" class="menu-item"> จัดการผู้ใช้</a>
    <a href="shopmanage.php" class="menu-item">จัดการร้านอาหาร</a>
    <a href="reviews.php" class="menu-item">รีวิว</a>
    
    
    <hr>
    <a href="../logout.php" class="menu-item text-danger">🚪 ออกจากระบบ</a>
  </div>

</div>
</body>


    <!-- 🔹 Content -->
    <div class="col-md-10 p-4">
      <h3 class="mb-4">📊 Dashboard</h3>

      <!-- สถิติ -->
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6>🏪 ร้านอาหาร</h6>
              <h3><?= $shop_count ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6>⭐ รีวิวทั้งหมด</h6>
              <h3><?= $review_count ?></h3>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6>👤 ผู้ใช้</h6>
              <h3><?= $user_count ?></h3>
            </div>
          </div>
        </div>
      </div>

        






      </div>
    </div>
  </div>
</div>



    </div>
  </div>
</div>
<style>

body {
  margin: 0;
  background: #f5f6fa;
}


.sidebar {
  width: 240px;
  min-height: 100vh;
  position: fixed;
  right: 0;
  top: 0;
}


.menu-item {
  display: block;
  padding: 10px 12px;
  color: #ccc;
  text-decoration: none;
  border-radius: 6px;
  margin-bottom: 6px;
}

.menu-item:hover,
.menu-item.active {
  background: #198754;
  color: #fff;
}


.main-content {
  margin-right: 240px; 
}


</style>