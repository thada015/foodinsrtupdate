<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

<<<<<<< HEAD
require_once __DIR__ . '/myadd.php';

$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$base_path = ($current_dir === 'admin') ? '../' : '';

$user_nav = null;
$display_name = '';
$profile_image = $base_path . 'uploads/profile/default.png';
=======
require_once 'myadd.php';

$user_nav = null;
$profile_image = 'uploads/profile/default.png';
$display_name = '';
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705

if (isset($_SESSION['user_id'])) {

    $uid = intval($_SESSION['user_id']);

<<<<<<< HEAD
=======
    // ✅ เปลี่ยนชื่อตัวแปร ไม่ใช้ $result
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
    $nav_query = mysqli_query($connect,
        "SELECT profile_image, nickname, user_account
         FROM accountuser
         WHERE id_account = $uid"
    );

    if ($nav_query && mysqli_num_rows($nav_query) > 0) {
<<<<<<< HEAD

        $user_nav = mysqli_fetch_assoc($nav_query);

        if (!empty($user_nav['profile_image'])) {
            $profile_image = $base_path . 'uploads/profile/' . $user_nav['profile_image'];
        }
=======
        $user_nav = mysqli_fetch_assoc($nav_query);

        $profile_image = !empty($user_nav['profile_image'])
            ? 'uploads/profile/' . $user_nav['profile_image']
            : 'uploads/profile/default.png';
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705

        $display_name = !empty($user_nav['nickname'])
            ? $user_nav['nickname']
            : $user_nav['user_account'];
    }
}
<<<<<<< HEAD


$search_val = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
=======
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container-fluid">

    <div class="d-flex align-items-center">
<<<<<<< HEAD
      
        <a class="navbar-brand fw-bold me-3" href="/foodinsrt/home.php" style="color: #2e7d32;">
=======
      <a class="navbar-brand fw-bold me-3" href="home.php" style="color: #2e7d32;">
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
        FoodinSrt
      </a>

      <a href="category.php" class="btn btn-outline-secondary">
        หมวดหมู่อาหาร
      </a>
    </div>

    <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">

<<<<<<< HEAD
      <!-- ===== Search Form ===== -->
      <form class="d-flex mx-auto w-50" role="search" 
            method="GET" action="home.php">
        <input class="form-control me-2" 
               type="search"
               name="search"
               placeholder="ค้นหาร้านอาหาร..."
               value="<?= $search_val ?>">
=======
      <!-- Search -->
      <form class="d-flex mx-auto w-50" role="search">
        <input class="form-control me-2" 
               type="search" 
               placeholder="ค้นหาร้านอาหาร">
>>>>>>> a782f25e8b02f71870d857724d4f8055168ba705
        <button class="btn btn-outline-success" type="submit">
          ค้นหา
        </button>
      </form>

      <!-- Admin Button -->
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
        <div class="ms-3">
          <a href="admin/dashboard.php" class="btn btn-dark">
            Dashboard แอดมิน
          </a>
        </div>
      <?php } ?>

      <ul class="navbar-nav ms-auto">

        <?php if (!isset($_SESSION['user_id'])) { ?>
          <li class="nav-item">
            <a class="btn btn-outline-primary" href="login.php">
              Login
            </a>
          </li>

        <?php } else { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#" role="button" data-bs-toggle="dropdown">

              <img src="<?= $profile_image ?>"
                   class="rounded-circle me-2 shadow-sm"
                   width="40" height="40"
                   style="object-fit: cover;">

              <span><?= htmlspecialchars($display_name) ?></span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profile.php">โปรไฟล์</a></li>
              <li><a class="dropdown-item" href="editprofile.php">แก้ไขโปรไฟล์</a></li>
              <li><a class="dropdown-item text-danger" href="logout.php">ออกจากระบบ</a></li>
            </ul>
          </li>
        <?php } ?>

      </ul>
    </div>
  </div>
</nav>